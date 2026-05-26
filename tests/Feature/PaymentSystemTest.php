<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Services\PaymentService;
use App\Livewire\InvoiceReceivePayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PaymentSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_record_cash_payment()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-001',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);
        $payment = $paymentService->recordPayment(
            $invoice,
            500,
            PaymentMethod::Cash,
            null,
            'Partial payment'
        );

        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 500,
            'payment_method' => 'cash',
        ]);

        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Partial, $invoice->payment_status);
        $this->assertEquals(500, $invoice->total_paid);
        $this->assertEquals(500, $invoice->remaining_balance);
    }

    public function test_upi_payment_requires_transaction_reference()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Transaction reference is required');

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-002',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);
        $paymentService->recordPayment(
            $invoice,
            500,
            PaymentMethod::UPI,
            null  // Missing transaction reference
        );
    }

    public function test_prevents_overpayment()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('exceeds remaining balance');

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-003',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);
        $paymentService->recordPayment($invoice, 1500, PaymentMethod::Cash);
    }

    public function test_full_payment_updates_status_to_paid()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-004',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);
        $paymentService->recordPayment($invoice, 1000, PaymentMethod::Cash);

        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Paid, $invoice->payment_status);
        $this->assertEquals(1000, $invoice->total_paid);
        $this->assertEquals(0, $invoice->remaining_balance);
    }

    public function test_multiple_partial_payments()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-005',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);

        // First payment
        $paymentService->recordPayment($invoice, 300, PaymentMethod::Cash);
        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Partial, $invoice->payment_status);
        $this->assertEquals(300, $invoice->total_paid);

        // Second payment
        $paymentService->recordPayment($invoice, 400, PaymentMethod::UPI, 'UPI123456');
        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Partial, $invoice->payment_status);
        $this->assertEquals(700, $invoice->total_paid);

        // Final payment
        $paymentService->recordPayment($invoice, 300, PaymentMethod::Cheque, 'CHQ789');
        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Paid, $invoice->payment_status);
        $this->assertEquals(1000, $invoice->total_paid);
        $this->assertEquals(0, $invoice->remaining_balance);
    }

    public function test_payment_immutability()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Payments are immutable');

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-006',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);
        $payment = $paymentService->recordPayment($invoice, 500, PaymentMethod::Cash);

        // Attempt to update payment (should throw exception)
        $payment->update(['amount' => 600]);
    }

    public function test_refund_creates_negative_payment()
    {
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-007',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        $paymentService = app(PaymentService::class);

        // Make full payment
        $paymentService->recordPayment($invoice, 1000, PaymentMethod::Cash);
        $invoice->refresh();
        $this->assertEquals(PaymentStatus::Paid, $invoice->payment_status);

        // Issue refund
        $paymentService->recordRefund($invoice, 200, PaymentMethod::Cash, null, 'Partial refund');

        $invoice->refresh();
        $this->assertEquals(800, $invoice->total_paid);
        $this->assertEquals(PaymentStatus::Partial, $invoice->payment_status);

        // Check negative payment exists
        $refund = $invoice->payments()->where('amount', '<', 0)->first();
        $this->assertNotNull($refund);
        $this->assertEquals(-200, $refund->amount);
    }

    public function test_livewire_payment_form_validation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-008',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        Livewire::test(InvoiceReceivePayment::class, ['invoice' => $invoice])
            ->set('amount', '')
            ->set('payment_method', 'cash')
            ->call('recordPayment')
            ->assertHasErrors(['amount']);
    }

    public function test_livewire_payment_form_records_payment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'Test Client', 'email' => 'test@example.com']);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'subscription_id' => null,
            'invoice_number' => 'INV-009',
            'invoice_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => 1000,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        Livewire::test(InvoiceReceivePayment::class, ['invoice' => $invoice])
            ->set('amount', 500)
            ->set('payment_method', 'cash')
            ->set('paid_at', now()->format('Y-m-d'))
            ->call('recordPayment')
            ->assertHasNoErrors()
            ->assertDispatched('payment-recorded');

        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'amount' => 500,
        ]);
    }
}
