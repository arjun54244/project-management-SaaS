<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Package;
use App\Enums\DiscountType;
use App\Services\PricingService;
use App\Services\SubscriptionService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SubscriptionForm extends Component
{
    public $clients;
    public $packages;

    public $client_id = '';
    public $package_id = '';
    public $discount_type = '';
    public $discount_value = 0;

    public $base_price = 0;
    public $final_price = 0;

    public function mount()
    {
        $this->clients = Client::where('status', 'active')->orderBy('name')->get();
        $this->packages = Package::where('status', 'active')->orderBy('name')->get();
    }

    public function updatedPackageId()
    {
        $package = $this->packages->find($this->package_id);
        $this->base_price = $package ? $package->base_price : 0;
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
        if (!$this->base_price) {
            $this->final_price = 0;
            return;
        }

        $pricingService = app(PricingService::class);
        $type = $this->discount_type ? DiscountType::tryFrom($this->discount_type) : null;

        $this->final_price = $pricingService->calculate(
            $this->base_price,
            $type,
            (float) $this->discount_value
        );
    }

    public function save(SubscriptionService $subscriptionService)
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'package_id' => 'required|exists:packages,id',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_value' => 'nullable|numeric|min:0',
        ]);

        $client = Client::findOrFail($this->client_id);
        $package = Package::findOrFail($this->package_id);
        $type = $this->discount_type ? DiscountType::tryFrom($this->discount_type) : null;

        $subscriptionService->createSubscription(
            $client,
            $package,
            $type,
            (float) $this->discount_value
        );

        session()->flash('message', 'Subscription created successfully.');
        return redirect()->route('subscriptions.index');
    }

    public function render()
    {
        return view('livewire.subscription-form');
    }
}
