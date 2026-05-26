<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionService as SubscriptionServiceModel;
use App\Models\Client;
use App\Models\Package;
use App\Enums\SubscriptionStatus;
use App\Enums\DiscountType;
use Carbon\Carbon;

class SubscriptionService
{
    protected $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    public function createSubscription(
        Client $client,
        Package $package,
        ?DiscountType $discountType = null,
        float $discountValue = 0
    ): Subscription {
        // Load package with services
        $package->load('services');

        // Calculate price including services
        $priceBeforeDiscount = $this->calculatePriceBeforeDiscount($package);
        $finalPrice = $this->pricingService->calculate($priceBeforeDiscount, $discountType, $discountValue);

        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths($package->duration_months);

        $subscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price_before_discount' => $priceBeforeDiscount,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'status' => SubscriptionStatus::Active,
        ]);

        // Snapshot services
        $this->snapshotServices($subscription, $package);

        return $subscription;
    }

    public function updateSubscription(
        Subscription $subscription,
        Package $package,
        Carbon $startDate,
        ?DiscountType $discountType = null,
        float $discountValue = 0
    ): Subscription {
        // Safety check: prevent package change if invoices exist
        if ($subscription->hasInvoices() && $subscription->package_id !== $package->id) {
            throw new \Exception('Cannot change package after invoicing. Please create a new subscription instead.');
        }

        // Load package with services
        $package->load('services');

        $priceBeforeDiscount = $this->calculatePriceBeforeDiscount($package);
        $finalPrice = $this->pricingService->calculate($priceBeforeDiscount, $discountType, $discountValue);
        $endDate = $startDate->copy()->addMonths($package->duration_months);

        $subscription->update([
            'package_id' => $package->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price_before_discount' => $priceBeforeDiscount,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
        ]);

        // Re-snapshot services if package changed
        if ($subscription->wasChanged('package_id')) {
            $subscription->subscriptionServices()->delete();
            $this->snapshotServices($subscription, $package);
        }

        return $subscription->fresh();
    }

    public function renewSubscription(
        Subscription $oldSubscription,
        ?Package $newPackage = null,
        ?DiscountType $discountType = null,
        ?float $discountValue = null
    ): Subscription {
        // Mark old subscription as expired
        $oldSubscription->update(['status' => SubscriptionStatus::Expired]);

        // Use same package if not specified
        $package = $newPackage ?? $oldSubscription->package;
        $package->load('services');

        // Use same discount if not specified
        $discountType = $discountType ?? $oldSubscription->discount_type;
        $discountValue = $discountValue ?? ($oldSubscription->discount_value ? (float) $oldSubscription->discount_value : 0.0);

        $priceBeforeDiscount = $this->calculatePriceBeforeDiscount($package);
        $finalPrice = $this->pricingService->calculate($priceBeforeDiscount, $discountType, $discountValue);

        // New subscription starts the day after old one ends
        $startDate = Carbon::parse($oldSubscription->end_date)->copy()->addDay();
        $endDate = $startDate->copy()->addMonths($package->duration_months);

        $subscription = Subscription::create([
            'client_id' => $oldSubscription->client_id,
            'package_id' => $package->id,
            'parent_subscription_id' => $oldSubscription->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price_before_discount' => $priceBeforeDiscount,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'status' => SubscriptionStatus::Pending,
        ]);

        // Snapshot services (always fresh from package)
        $this->snapshotServices($subscription, $package);

        // Generate invoice for renewal
        app(\App\Services\InvoiceService::class)->generateInvoice($subscription);

        return $subscription;
    }

    public function assignViaCommand(
        Client $client,
        Package $package,
        ?DiscountType $discountType = null,
        float $discountValue = 0,
        ?Carbon $startDate = null
    ): Subscription {
        $startDate = $startDate ?? Carbon::now();

        // Load package with services
        $package->load('services');

        $priceBeforeDiscount = $this->calculatePriceBeforeDiscount($package);
        $finalPrice = $this->pricingService->calculate($priceBeforeDiscount, $discountType, $discountValue);
        $endDate = $startDate->copy()->addMonths($package->duration_months);

        $subscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price_before_discount' => $priceBeforeDiscount,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'status' => SubscriptionStatus::Active,
        ]);

        // Snapshot services
        $this->snapshotServices($subscription, $package);

        return $subscription;
    }

    /**
     * Calculate price before discount including services
     */
    protected function calculatePriceBeforeDiscount(Package $package): float
    {
        $basePrice = (float) $package->base_price;

        // Add service prices
        $servicesTotal = 0;
        foreach ($package->services as $service) {
            if ($service->base_price) {
                $quantity = $service->pivot->quantity ?? 1;
                $servicesTotal += (float) $service->base_price * $quantity;
            }
        }

        return $basePrice + $servicesTotal;
    }

    /**
     * Snapshot package services to subscription
     */
    protected function snapshotServices(Subscription $subscription, Package $package): void
    {
        foreach ($package->services as $service) {
            SubscriptionServiceModel::create([
                'subscription_id' => $subscription->id,
                'service_name' => $service->name,
                'service_price' => $service->base_price ?? 0,
                'quantity' => $service->pivot->quantity ?? 1,
            ]);
        }
    }

    /**
     * Terminate a subscription early
     */
    public function endSubscription(Subscription $subscription, Carbon $date, ?string $reason = null): Subscription
    {
        $subscription->update([
            'status' => SubscriptionStatus::Cancelled,
            'end_date' => $date,
            'cancelled_at' => Carbon::now(),
            'cancellation_reason' => $reason,
        ]);

        return $subscription->fresh();
    }
}
