<?php

namespace Tests\Feature;

use App\Livewire\InvoiceForm;
use App\Livewire\InvoiceList;
use App\Livewire\InvoiceView;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\SubscriptionService;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function createSubscription(?string $email = null): Subscription
    {
        $email = $email ?? 'test' . uniqid() . '@test.com';
        $client = Client::create(['name' => 'Test Client', 'email' => $email, 'status' => 'active']);
        $package = Package::create(['name' => 'Test Package', 'duration_months' => 12, 'base_price' => 100, 'status' => 'active']);

        return app(SubscriptionService::class)->createSubscription($client, $package);
    }

    public function test_invoice_list_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = $this->createSubscription();
        app(InvoiceService::class)->generateInvoice($subscription);

        $response = $this->get(route('invoices.index'));

        $response->assertStatus(200);
        $response->assertSeeLivewire(InvoiceList::class);
    }

    public function test_can_create_invoice_from_subscription()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = $this->createSubscription();

        Livewire::test(InvoiceForm::class)
            ->set('subscription_id', $subscription->id)
            ->call('save')
            ->assertRedirect(route('invoices.index'));

        $this->assertDatabaseHas('invoices', [
            'client_id' => $subscription->client_id,
            'subscription_id' => $subscription->id,
            'total_amount' => $subscription->final_price,
            'payment_status' => PaymentStatus::Unpaid->value,
        ]);

        $this->assertDatabaseHas('invoice_items', [
            'qty' => 1,
            'price' => $subscription->final_price,
            'total' => $subscription->final_price,
        ]);
    }

    public function test_can_view_invoice()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = $this->createSubscription();
        $invoice = app(InvoiceService::class)->generateInvoice($subscription);

        $response = $this->get(route('invoices.show', $invoice));

        $response->assertStatus(200);
        $response->assertSeeLivewire(InvoiceView::class);
        $response->assertSee($invoice->invoice_number);
    }

    public function test_can_record_payment_for_invoice()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = $this->createSubscription();
        $invoice = app(InvoiceService::class)->generateInvoice($subscription);

        $this->assertEquals(PaymentStatus::Unpaid, $invoice->payment_status);

        Livewire::test(\App\Livewire\InvoiceReceivePayment::class, ['invoice' => $invoice])
            ->set('amount', 100)
            ->set('payment_method', 'cash')
            ->call('recordPayment');

        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Paid, $invoice->payment_status);
        $this->assertEquals(100, $invoice->total_paid);
    }

    public function test_can_filter_invoices_by_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = $this->createSubscription();
        $paidInvoice = app(InvoiceService::class)->generateInvoice($subscription);

        // Record payment to make it paid
        app(\App\Services\PaymentService::class)->recordPayment(
            $paidInvoice,
            (float) $paidInvoice->total_amount,
            \App\Enums\PaymentMethod::Cash
        );

        $subscription2 = $this->createSubscription();
        $unpaidInvoice = app(InvoiceService::class)->generateInvoice($subscription2);

        Livewire::test(InvoiceList::class)
            ->set('filterStatus', 'paid')
            ->assertSee($paidInvoice->invoice_number)
            ->assertDontSee($unpaidInvoice->invoice_number);

        Livewire::test(InvoiceList::class)
            ->set('filterStatus', 'unpaid')
            ->assertSee($unpaidInvoice->invoice_number)
            ->assertDontSee($paidInvoice->invoice_number);
    }

    public function test_can_access_invoice_pdf()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $subscription = $this->createSubscription();
        $invoice = app(InvoiceService::class)->generateInvoice($subscription);

        $response = $this->get(route('invoices.pdf', $invoice));

        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
        $response->assertSee('INVOICE');
    }

    public function test_invoice_service_generates_correct_invoice()
    {
        $subscription = $this->createSubscription();
        $invoiceService = app(InvoiceService::class);

        $invoice = $invoiceService->generateInvoice($subscription);

        $this->assertNotNull($invoice->invoice_number);
        $this->assertStringStartsWith('INV-', $invoice->invoice_number);
        $this->assertEquals($subscription->client_id, $invoice->client_id);
        $this->assertEquals($subscription->id, $invoice->subscription_id);
        $this->assertEquals($subscription->final_price, $invoice->total_amount);
        $this->assertEquals(PaymentStatus::Unpaid, $invoice->payment_status);
        $this->assertCount(1, $invoice->items);
    }
}
