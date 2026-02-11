<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Enums\PaymentStatus;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class InvoiceList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $showPaymentModal = false;
    public $selectedInvoiceId;

    protected $listeners = ['payment-recorded' => 'handlePaymentRecorded'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function openPaymentModal($invoiceId)
    {
        $this->selectedInvoiceId = $invoiceId;
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedInvoiceId = null;
    }

    public function handlePaymentRecorded()
    {
        $this->closePaymentModal();
    }

    public function markAsPaid($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        app(InvoiceService::class)->markAsPaid($invoice);
        session()->flash('message', 'Invoice #' . $invoice->invoice_number . ' marked as paid.');
        $this->dispatch('payment-recorded');
        $this->dispatch('dashboard-updated');
    }

    public function render()
    {
        $query = Invoice::with(['client', 'subscription.package'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filterStatus) {
            if ($this->filterStatus === 'overdue') {
                $query->where('payment_status', '!=', PaymentStatus::Paid)
                    ->where('due_date', '<', now());
            } else {
                $query->where('payment_status', $this->filterStatus);
            }
        }

        $invoices = $query->paginate(10);

        return view('livewire.invoice-list', [
            'invoices' => $invoices,
        ]);
    }
}
