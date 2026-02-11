<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Services\InvoiceService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class InvoiceView extends Component
{
    public Invoice $invoice;
    public $showPaymentModal = false;

    protected $listeners = ['payment-recorded' => 'handlePaymentRecorded'];

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load(['client', 'subscription.package', 'items']);
    }

    public function openPaymentModal()
    {
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
    }

    public function handlePaymentRecorded()
    {
        $this->closePaymentModal();
        $this->invoice->refresh();
    }

    public function markAsPaid()
    {
        app(InvoiceService::class)->markAsPaid($this->invoice);
        session()->flash('message', 'Invoice marked as paid.');
        $this->invoice->refresh();
        $this->dispatch('payment-recorded');
        $this->dispatch('dashboard-updated');
    }

    public function render()
    {
        return view('livewire.invoice-view');
    }
}
