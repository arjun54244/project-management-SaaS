<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Enums\PaymentMethod;
use App\Services\PaymentService;
use Livewire\Component;
use Carbon\Carbon;

class InvoiceReceivePayment extends Component
{
    public $invoice;

    public $amount;
    public $payment_method = 'cash';
    public $transaction_reference;
    public $notes;
    public $paid_at;

    protected PaymentService $paymentService;

    public function boot(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load('payments');
        $this->paid_at = now()->format('Y-m-d');

        // Pre-fill amount with remaining balance
        $remainingBalance = $this->invoice->remaining_balance;
        if ($remainingBalance > 0) {
            $this->amount = $remainingBalance;
        }
    }

    public function updatedPaymentMethod()
    {
        // Clear transaction reference when switching to cash or other that doesn't require it
        $method = PaymentMethod::tryFrom($this->payment_method);
        if ($method && !$method->requiresReference()) {
            $this->transaction_reference = null;
        }
    }

    public function recordPayment()
    {
        $paymentMethod = PaymentMethod::from($this->payment_method);

        $rules = [
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,upi,cheque,bank_transfer,other',
            'paid_at' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ];

        // Add transaction reference validation for non-cash/non-other payments
        if ($paymentMethod->requiresReference()) {
            $rules['transaction_reference'] = 'required|string|max:255';
        }

        $this->validate($rules);

        try {
            // Prevent overpayment check (additional safety in Livewire)
            if ($this->amount > round($this->invoice->remaining_balance, 2)) {
                $this->addError('amount', "Payment amount exceeds remaining balance (₹" . number_format($this->invoice->remaining_balance, 2) . ").");
                return;
            }

            $this->paymentService->recordPayment(
                $this->invoice,
                (float) $this->amount,
                $paymentMethod,
                $this->transaction_reference,
                $this->notes,
                Carbon::parse($this->paid_at)
            );

            session()->flash('message', 'Payment recorded successfully.');

            // Refresh invoice
            $this->invoice->refresh();

            // Emit event to close modal and refresh lists
            $this->dispatch('payment-recorded');
            $this->dispatch('dashboard-updated'); // For dashboard stats

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.invoice-receive-payment', [
            'paymentMethods' => PaymentMethod::cases(),
            'remainingBalance' => $this->invoice->remaining_balance,
            'totalPaid' => $this->invoice->total_paid,
        ]);
    }
}
