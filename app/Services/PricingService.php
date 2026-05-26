<?php

namespace App\Services;

use App\Enums\DiscountType;

class PricingService
{
    public function calculate(float $basePrice, ?DiscountType $discountType, float $discountValue): float
    {
        if (!$discountType || $discountValue <= 0) {
            return $basePrice;
        }

        if ($discountType === DiscountType::Percentage) {
            $discount = $basePrice * ($discountValue / 100);
        } else {
            $discount = $discountValue;
        }

        return max(0, $basePrice - $discount);
    }

    /**
     * Calculate package price including services
     * 
     * @param \App\Models\Package $package
     * @param DiscountType|null $discountType
     * @param float $discountValue
     * @return float
     */
    public function calculatePackagePrice($package, ?DiscountType $discountType = null, float $discountValue = 0): float
    {
        // Start with package base price
        $basePrice = (float) $package->base_price;

        // Add service prices
        $servicesTotal = 0;
        foreach ($package->services as $service) {
            if ($service->base_price) {
                $quantity = $service->pivot->quantity ?? 1;
                $servicesTotal += (float) $service->base_price * $quantity;
            }
        }

        $priceBeforeDiscount = $basePrice + $servicesTotal;

        // Apply discount
        return $this->calculate($priceBeforeDiscount, $discountType, $discountValue);
    }
}
