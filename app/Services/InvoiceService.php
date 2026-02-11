<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Enums\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InvoiceService
{
    public function generateInvoice(Subscription $subscription): Invoice
    {
        $invoiceNumber = $this->generateInvoiceNumber();

        $invoice = Invoice::create([
            'client_id' => $subscription->client_id,
            'subscription_id' => $subscription->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(30),
            'subtotal' => $subscription->final_price,
            'discount' => 0,
            'tax' => 0,
            'total_amount' => $subscription->final_price,
            'payment_status' => PaymentStatus::Unpaid,
        ]);

        // Create invoice item from subscription
        $invoice->items()->create([
            'item_type' => 'package',
            'item_id' => $subscription->package_id,
            'description' => $subscription->package->name . ' (' . $subscription->package->duration_months . ' months)',
            'qty' => 1,
            'price' => $subscription->final_price,
            'total' => $subscription->final_price,
        ]);

        return $invoice;
    }

    public function markAsPaid(Invoice $invoice): Invoice
    {
        $paymentService = app(\App\Services\PaymentService::class);

        if (!$invoice->isFullyPaid()) {
            $paymentService->recordPayment(
                $invoice,
                $invoice->remaining_balance,
                \App\Enums\PaymentMethod::Cash,
                'MANUAL-MARK-PAID',
                'Marked as paid via admin interface'
            );
        }

        return $invoice->fresh();
    }

    public function markAsUnpaid(Invoice $invoice): Invoice
    {
        $invoice->payments()->delete();

        $paymentService = app(\App\Services\PaymentService::class);
        $paymentService->updateInvoiceStatus($invoice);

        return $invoice->fresh();
    }

    public function generatePdfHtml(Invoice $invoice): string
    {
        $invoice->load(['client', 'subscription.package', 'items']);

        return view('livewire.invoice-pdf', [
            'invoice' => $invoice,
        ])->render();
    }

    protected function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $date = Carbon::now()->format('Ymd');
        $random = strtoupper(Str::random(4));

        return "{$prefix}-{$date}-{$random}";
    }

    public function isOverdue(Invoice $invoice): bool
    {
        return $invoice->payment_status !== PaymentStatus::Paid
            && $invoice->due_date && now()->greaterThan($invoice->due_date);
    }
}
