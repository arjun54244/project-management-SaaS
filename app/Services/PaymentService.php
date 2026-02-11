<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Carbon\Carbon;

class PaymentService
{
    /**
     * Record a payment for an invoice
     */
    public function recordPayment(
        Invoice $invoice,
        float $amount,
        PaymentMethod $paymentMethod,
        ?string $transactionReference = null,
        ?string $notes = null,
        ?Carbon $paidAt = null
    ): Payment {
        // Validate amount
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Payment amount must be greater than zero.');
        }

        // Prevent overpayment
        $totalPaid = $this->getTotalPaid($invoice);
        $totalAmount = (float) $invoice->total_amount;
        $remainingBalance = $totalAmount - $totalPaid;

        if ($amount > round($remainingBalance, 2)) {
            throw new \InvalidArgumentException("Payment amount (₹{$amount}) exceeds remaining balance (₹" . number_format($remainingBalance, 2) . ").");
        }

        // Validate transaction reference for non-cash payments
        if ($paymentMethod->requiresReference() && empty($transactionReference)) {
            throw new \InvalidArgumentException("Transaction reference is required for {$paymentMethod->label()} payments.");
        }

        // Create payment
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'transaction_reference' => $transactionReference,
            'paid_at' => $paidAt ?? Carbon::now(),
            'notes' => $notes,
        ]);

        // Update invoice payment status (DERIVED from payments)
        $this->updateInvoiceStatus($invoice);

        return $payment;
    }

    /**
     * Calculate and update invoice payment status
     */
    public function updateInvoiceStatus(Invoice $invoice): void
    {
        $totalPaid = $this->getTotalPaid($invoice);
        $totalAmount = (float) $invoice->total_amount;

        $status = $this->calculateInvoiceStatus($totalPaid, $totalAmount);

        // Get the latest payment method to show on the invoice
        $latestPaymentMethod = $invoice->payments()->latest('paid_at')->first()?->payment_method;

        $invoice->update([
            'payment_status' => $status,
            'payment_method' => $latestPaymentMethod,
        ]);

        // Activate subscription if fully paid or partial activation is allowed
        if ($invoice->subscription && $invoice->subscription->status === \App\Enums\SubscriptionStatus::Pending) {
            $allowPartial = config('subscriptions.allow_partial_activation', false);

            if ($status === PaymentStatus::Paid || ($allowPartial && $status === PaymentStatus::Partial)) {
                $invoice->subscription->update(['status' => \App\Enums\SubscriptionStatus::Active]);

                // Trigger an event or log activation if needed
            }
        }
    }

    /**
     * Calculate invoice status based on payments
     */
    public function calculateInvoiceStatus(float $totalPaid, float $totalAmount): PaymentStatus
    {
        if ($totalPaid <= 0) {
            return PaymentStatus::Unpaid;
        }

        if ($totalPaid >= $totalAmount) {
            return PaymentStatus::Paid;
        }

        return PaymentStatus::Partial;
    }

    /**
     * Get total paid amount for an invoice
     */
    public function getTotalPaid(Invoice $invoice): float
    {
        return (float) $invoice->payments()->sum('amount');
    }

    /**
     * Get remaining balance for an invoice
     */
    public function getRemainingBalance(Invoice $invoice): float
    {
        return max(0, $invoice->total_amount - $this->getTotalPaid($invoice));
    }

    /**
     * Record a refund (negative payment)
     */
    public function recordRefund(
        Invoice $invoice,
        float $amount,
        PaymentMethod $paymentMethod,
        ?string $transactionReference = null,
        ?string $notes = null
    ): Payment {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Refund amount must be greater than zero.');
        }

        // Create negative payment for refund
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => -$amount,
            'payment_method' => $paymentMethod,
            'transaction_reference' => $transactionReference,
            'paid_at' => Carbon::now(),
            'notes' => $notes ? "REFUND: {$notes}" : 'REFUND',
        ]);

        // Update invoice status
        $this->updateInvoiceStatus($invoice);

        return $payment;
    }
}
