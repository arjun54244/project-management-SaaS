<?php

namespace Tests\Feature;

use App\Enums\DiscountType;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Subscription;
use App\Repositories\DashboardRepository;
use App\Services\PricingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoreSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_client_and_package()
    {
        $client = Client::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('clients', ['email' => 'john@example.com']);

        $package = Package::create([
            'name' => 'Standard Plan',
            'duration_months' => 12,
            'base_price' => 1200.00,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('packages', ['name' => 'Standard Plan']);
    }

    public function test_pricing_service_logic()
    {
        $service = new PricingService();

        // No discount
        $price = $service->calculate(100, null, 0);
        $this->assertEquals(100, $price);

        // Percentage discount
        $price = $service->calculate(100, DiscountType::Percentage, 10); // 10% off
        $this->assertEquals(90, $price);

        // Flat discount
        $price = $service->calculate(100, DiscountType::Flat, 20); // 20 off
        $this->assertEquals(80, $price);
    }

    public function test_subscription_creation_and_dashboard_repository()
    {
        $client = Client::create(['name' => 'Jane', 'email' => 'jane@example.com', 'dob' => Carbon::now()->startOfWeek()]);
        $package = Package::create(['name' => 'Monthly', 'duration_months' => 1, 'base_price' => 100]);

        // Create subscription expiring today
        $sub = Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package->id,
            'start_date' => Carbon::now()->subMonth(),
            'end_date' => Carbon::today(), // Expires today
            'price_before_discount' => 100,
            'final_price' => 100,
            'status' => SubscriptionStatus::Active,
        ]);

        // Create Invoice
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => $sub->id,
            'invoice_number' => 'INV-001',
            'invoice_date' => Carbon::today(),
            'due_date' => Carbon::today()->addDays(7),
            'subtotal' => 100,
            'total_amount' => 100,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        // Record Payment (Revenue is now derived from payments table)
        app(\App\Services\PaymentService::class)->recordPayment(
            $invoice,
            100,
            \App\Enums\PaymentMethod::Cash,
            'TEST-REF',
            'Test payment',
            Carbon::today()
        );

        $repo = new DashboardRepository();

        // Test Upcoming Renewals (previously Expiring Packages)
        $renewals = $repo->getUpcomingRenewals('7days');
        $this->assertCount(1, $renewals);
        $this->assertEquals('Monthly', $renewals->first()['package_name']);

        // Test Revenue Metrics
        $metrics = $repo->getRevenueMetrics((int) date('Y'), (int) date('m'));
        $this->assertEquals(100, $metrics['total_received']);
        $this->assertEquals(0, $metrics['total_outstanding']);

        // Test Birthdays
        $birthdays = $repo->getBirthdaysThisWeek();
        $this->assertCount(1, $birthdays);
        $this->assertEquals('Jane', $birthdays->first()->name);
    }
}
