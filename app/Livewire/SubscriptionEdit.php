<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Models\Package;
use App\Enums\DiscountType;
use App\Services\PricingService;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SubscriptionEdit extends Component
{
    public Subscription $subscription;
    public $packages;

    public $package_id;
    public $start_date;
    public $discount_type = '';
    public $discount_value = 0;

    public $base_price = 0;
    public $final_price = 0;
    public $end_date = '';
    public $package_locked = false;

    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription->load(['package', 'client', 'invoices']);
        $this->packages = Package::where('status', 'active')->orderBy('name')->get();

        // Check if package can be changed
        $this->package_locked = $this->subscription->hasInvoices();

        // Initialize form fields
        $this->package_id = $this->subscription->package_id;
        $this->start_date = $this->subscription->start_date->format('Y-m-d');
        $this->discount_type = $this->subscription->discount_type?->value ?? '';
        $this->discount_value = $this->subscription->discount_value ?? 0;

        $this->calculatePrice();
    }

    public function updatedPackageId()
    {
        $package = $this->packages->find($this->package_id);
        $this->base_price = $package ? $package->base_price : 0;
        $this->calculatePrice();
    }

    public function updatedStartDate()
    {
        $this->calculatePrice();
    }

    public function updatedDiscountType()
    {
        $this->calculatePrice();
    }

    public function updatedDiscountValue()
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        $package = $this->packages->find($this->package_id);
        if (!$package) {
            $this->final_price = 0;
            $this->end_date = '';
            return;
        }

        $this->base_price = $package->base_price;

        $pricingService = app(PricingService::class);
        $type = $this->discount_type ? DiscountType::tryFrom($this->discount_type) : null;

        $this->final_price = $pricingService->calculate(
            $this->base_price,
            $type,
            (float) $this->discount_value
        );

        // Calculate end date
        if ($this->start_date) {
            $startDate = Carbon::parse($this->start_date);
            $endDate = $startDate->copy()->addMonths($package->duration_months);
            $this->end_date = $endDate->format('Y-m-d');
        }
    }

    public function save(SubscriptionService $subscriptionService)
    {
        $this->validate([
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_value' => 'nullable|numeric|min:0',
        ]);

        try {
            $package = Package::findOrFail($this->package_id);
            $startDate = Carbon::parse($this->start_date);
            $type = $this->discount_type ? DiscountType::tryFrom($this->discount_type) : null;

            $subscriptionService->updateSubscription(
                $this->subscription,
                $package,
                $startDate,
                $type,
                (float) $this->discount_value
            );

            session()->flash('message', 'Subscription updated successfully.');
            return redirect()->route('subscriptions.index');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.subscription-edit');
    }
}
