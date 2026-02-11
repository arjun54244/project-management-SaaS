<?php

namespace Tests\Feature;

use App\Livewire\SubscriptionForm;
use App\Livewire\SubscriptionList;
use App\Models\Client;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Enums\DiscountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SubscriptionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_list_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'John Doe', 'email' => 'john@test.com']);
        $package = Package::create(['name' => 'Premium', 'duration_months' => 12, 'base_price' => 100]);

        app(SubscriptionService::class)->createSubscription($client, $package);

        $response = $this->get(route('subscriptions.index'));

        $response->assertStatus(200);
        $response->assertSeeLivewire(SubscriptionList::class);
        $response->assertSee('John Doe');
        $response->assertSee('Premium');
    }

    public function test_can_create_subscription()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'Jane Doe', 'email' => 'jane@test.com', 'status' => 'active']);
        $package = Package::create(['name' => 'Standard', 'duration_months' => 6, 'base_price' => 50, 'status' => 'active']);

        Livewire::test(SubscriptionForm::class)
            ->set('client_id', $client->id)
            ->set('package_id', $package->id)
            ->set('discount_type', 'percentage')
            ->set('discount_value', 10) // 10%
            ->call('save')
            ->assertRedirect(route('subscriptions.index'));

        $this->assertDatabaseHas('subscriptions', [
            'client_id' => $client->id,
            'package_id' => $package->id,
            'price_before_discount' => 50,
            'final_price' => 45, // 50 - 10%
        ]);
    }
}
