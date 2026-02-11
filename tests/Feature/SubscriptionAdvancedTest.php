<?php

namespace Tests\Feature;

use App\Livewire\SubscriptionEdit;
use App\Models\Client;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Enums\SubscriptionStatus;
use App\Enums\DiscountType;
use App\Enums\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SubscriptionAdvancedTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_edit_subscription_without_invoices()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'John Doe', 'email' => 'john@test.com']);
        $package1 = Package::create(['name' => 'Basic', 'duration_months' => 1, 'base_price' => 100, 'status' => 'active']);
        $package2 = Package::create(['name' => 'Premium', 'duration_months' => 3, 'base_price' => 250, 'status' => 'active']);

        $subscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package1->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'price_before_discount' => 100,
            'final_price' => 100,
            'status' => SubscriptionStatus::Active,
        ]);

        Livewire::test(SubscriptionEdit::class, ['subscription' => $subscription])
            ->set('package_id', $package2->id)
            ->set('start_date', now()->format('Y-m-d'))
            ->call('save')
            ->assertRedirect(route('subscriptions.index'));

        $subscription->refresh();
        $this->assertEquals($package2->id, $subscription->package_id);
    }

    public function test_cannot_change_package_with_invoices()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'Jane Doe', 'email' => 'jane@test.com']);
        $package1 = Package::create(['name' => 'Basic', 'duration_months' => 1, 'base_price' => 100, 'status' => 'active']);
        $package2 = Package::create(['name' => 'Premium', 'duration_months' => 3, 'base_price' => 250, 'status' => 'active']);

        $subscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package1->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'price_before_discount' => 100,
            'final_price' => 100,
            'status' => SubscriptionStatus::Active,
        ]);

        // Create an invoice for this subscription
        Invoice::create([
            'subscription_id' => $subscription->id,
            'client_id' => $client->id,
            'invoice_number' => 'INV-001',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 100,
            'total_amount' => 100,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        Livewire::test(SubscriptionEdit::class, ['subscription' => $subscription])
            ->assertSet('package_locked', true)
            ->set('package_id', $package2->id)
            ->set('start_date', now()->format('Y-m-d'))
            ->call('save');

        // Verify package was not changed
        $subscription->refresh();
        $this->assertEquals($package1->id, $subscription->package_id);
    }

    public function test_renewal_creates_new_subscription()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@client.com']);
        $package = Package::create(['name' => 'Monthly', 'duration_months' => 1, 'base_price' => 50]);

        $oldSubscription = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'price_before_discount' => 50,
            'final_price' => 50,
            'status' => SubscriptionStatus::Active,
        ]);

        $subscriptionService = app(SubscriptionService::class);
        $newSubscription = $subscriptionService->renewSubscription($oldSubscription);

        // Check old subscription is expired
        $oldSubscription->refresh();
        $this->assertEquals(SubscriptionStatus::Expired, $oldSubscription->status);

        // Check new subscription is created as Pending (new rule)
        $this->assertNotEquals($oldSubscription->id, $newSubscription->id);
        $this->assertEquals($oldSubscription->id, $newSubscription->parent_subscription_id);
        $this->assertEquals(SubscriptionStatus::Pending, $newSubscription->status);

        // Record full payment for the renewal invoice
        $invoice = $newSubscription->invoices()->first();
        app(\App\Services\PaymentService::class)->recordPayment(
            $invoice,
            $invoice->total_amount,
            \App\Enums\PaymentMethod::Cash
        );

        $newSubscription->refresh();
        $this->assertEquals(SubscriptionStatus::Active, $newSubscription->status);

        // Check dates are correct
        $expectedStartDate = $oldSubscription->end_date->copy()->addDay();
        $this->assertEquals($expectedStartDate->format('Y-m-d'), $newSubscription->start_date->format('Y-m-d'));
    }

    public function test_cli_command_creates_subscription()
    {
        $client = Client::create(['name' => 'CLI Client', 'email' => 'cli@test.com']);
        $package = Package::create(['name' => 'Annual', 'duration_months' => 12, 'base_price' => 500]);

        $this->artisan('assign:package', [
            '--client' => $client->id,
            '--package' => $package->id,
            '--discount_type' => 'percentage',
            '--discount_value' => 10,
            '--force' => true,
        ])->assertExitCode(0);

        $this->assertDatabaseHas('subscriptions', [
            'client_id' => $client->id,
            'package_id' => $package->id,
            'final_price' => 450, // 500 - 10%
        ]);
    }
}
