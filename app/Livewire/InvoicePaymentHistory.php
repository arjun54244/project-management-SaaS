<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Attributes\On;
use Livewire\Component;

class InvoicePaymentHistory extends Component
{
    public $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load('payments');
    }

    #[On('payment-recorded')]
    public function refreshPayments()
    {
        $this->invoice->refresh();
    }

    public function render()
    {
        return view('livewire.invoice-payment-history', [
            'payments' => $this->invoice->payments()->orderBy('paid_at', 'desc')->get(),
            'totalPaid' => $this->invoice->total_paid,
            'remainingBalance' => $this->invoice->remaining_balance,
        ]);
    }
}
