<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Package;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\SubscriptionService as SubscriptionServiceModel;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Enums\DiscountType;
use App\Livewire\ServiceList;
use App\Livewire\ServiceForm;
use App\Livewire\PackageForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_service()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(ServiceForm::class)
            ->set('name', 'Web Hosting')
            ->set('description', 'Shared hosting service')
            ->set('base_price', 100)
            ->set('status', 'active')
            ->call('save')
            ->assertRedirect(route('services.index'));

        $this->assertDatabaseHas('services', [
            'name' => 'Web Hosting',
            'base_price' => 100,
            'status' => 'active',
        ]);
    }

    public function test_can_attach_services_to_package()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service1 = Service::create(['name' => 'Hosting', 'base_price' => 50, 'status' => 'active']);
        $service2 = Service::create(['name' => 'SSL', 'base_price' => 20, 'status' => 'active']);

        Livewire::test(PackageForm::class)
            ->set('name', 'Premium Package')
            ->set('duration_months', 12)
            ->set('base_price', 500)
            ->set('status', 'active')
            ->set('selectedServices', [$service1->id, $service2->id])
            ->set('serviceQuantities', [$service1->id => 2, $service2->id => 1])
            ->call('save')
            ->assertRedirect(route('packages.index'));

        $package = Package::where('name', 'Premium Package')->first();
        $this->assertCount(2, $package->services);
        $this->assertEquals(2, $package->services->find($service1->id)->pivot->quantity);
        $this->assertEquals(1, $package->services->find($service2->id)->pivot->quantity);
    }

    public function test_subscription_snapshots_services()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);

        $service1 = Service::create(['name' => 'Hosting', 'base_price' => 50]);
        $service2 = Service::create(['name' => 'SSL', 'base_price' => 20]);

        $package = Package::create([
            'name' => 'Premium',
            'duration_months' => 12,
            'base_price' => 500,
        ]);

        $package->services()->attach([
            $service1->id => ['quantity' => 2],
            $service2->id => ['quantity' => 1],
        ]);

        $subscriptionService = app(SubscriptionService::class);
        $subscription = $subscriptionService->createSubscription($client, $package);

        // Verify services were snapshotted
        $this->assertCount(2, $subscription->subscriptionServices);

        $snapshotted = $subscription->subscriptionServices;
        $this->assertEquals('Hosting', $snapshotted[0]->service_name);
        $this->assertEquals(50, $snapshotted[0]->service_price);
        $this->assertEquals(2, $snapshotted[0]->quantity);

        $this->assertEquals('SSL', $snapshotted[1]->service_name);
        $this->assertEquals(20, $snapshotted[1]->service_price);
        $this->assertEquals(1, $snapshotted[1]->quantity);
    }

    public function test_changing_package_services_does_not_affect_old_subscriptions()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);

        $service = Service::create(['name' => 'Hosting', 'base_price' => 50]);

        $package = Package::create([
            'name' => 'Basic',
            'duration_months' => 1,
            'base_price' => 100,
        ]);

        $package->services()->attach($service->id, ['quantity' => 1]);

        $subscriptionService = app(SubscriptionService::class);
        $subscription = $subscriptionService->createSubscription($client, $package);

        // Verify original snapshot
        $this->assertEquals('Hosting', $subscription->subscriptionServices->first()->service_name);
        $this->assertEquals(50, $subscription->subscriptionServices->first()->service_price);

        // Change service price
        $service->update(['base_price' => 100]);

        // Verify subscription snapshot unchanged
        $subscription->refresh();
        $this->assertEquals(50, $subscription->subscriptionServices->first()->service_price);
    }

    public function test_pricing_includes_services()
    {
        $service1 = Service::create(['name' => 'Hosting', 'base_price' => 50]);
        $service2 = Service::create(['name' => 'SSL', 'base_price' => 20]);

        $package = Package::create([
            'name' => 'Premium',
            'duration_months' => 12,
            'base_price' => 500,
        ]);

        $package->services()->attach([
            $service1->id => ['quantity' => 2],  // 50 * 2 = 100
            $service2->id => ['quantity' => 1],  // 20 * 1 = 20
        ]);

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);

        $subscriptionService = app(SubscriptionService::class);
        $subscription = $subscriptionService->createSubscription($client, $package);

        // Base: 500 + Services: 120 = 620
        $this->assertEquals(620, $subscription->price_before_discount);
        $this->assertEquals(620, $subscription->final_price);
    }

    public function test_pricing_with_discount_applies_after_services()
    {
        $service = Service::create(['name' => 'Hosting', 'base_price' => 100]);

        $package = Package::create([
            'name' => 'Premium',
            'duration_months' => 12,
            'base_price' => 500,
        ]);

        $package->services()->attach($service->id, ['quantity' => 1]);

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);

        $subscriptionService = app(SubscriptionService::class);
        $subscription = $subscriptionService->createSubscription(
            $client,
            $package,
            DiscountType::Percentage,
            10  // 10% discount
        );

        // Base: 500 + Service: 100 = 600
        // Discount: 600 * 10% = 60
        // Final: 600 - 60 = 540
        $this->assertEquals(600, $subscription->price_before_discount);
        $this->assertEquals(540, $subscription->final_price);
    }

    public function test_renewal_snapshots_current_services()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);

        $service = Service::create(['name' => 'Hosting', 'base_price' => 50]);

        $package = Package::create([
            'name' => 'Monthly',
            'duration_months' => 1,
            'base_price' => 100,
        ]);

        $package->services()->attach($service->id, ['quantity' => 1]);

        $subscriptionService = app(SubscriptionService::class);
        $oldSubscription = $subscriptionService->createSubscription($client, $package);

        // Change service price before renewal
        $service->update(['base_price' => 75]);

        // Renew subscription
        $newSubscription = $subscriptionService->renewSubscription($oldSubscription);

        // Old subscription should have old price
        $this->assertEquals(50, $oldSubscription->subscriptionServices->first()->service_price);

        // New subscription should have new price
        $this->assertEquals(75, $newSubscription->subscriptionServices->first()->service_price);
    }
}
