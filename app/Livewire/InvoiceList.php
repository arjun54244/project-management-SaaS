<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class InvoiceList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $paymentAmount;
    public $paymentMethod;
    public $transactionReference;
    public $paymentNotes;
    public $paymentDate;

    protected $listeners = ['payment-recorded' => 'handlePaymentRecorded'];

    public function rules()
    {
        return [
            'paymentAmount' => 'required|numeric|min:0.01',
            'paymentMethod' => 'required',
            'transactionReference' => 'nullable|string',
            'paymentNotes' => 'nullable|string',
        ];
    }

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
        $invoice = Invoice::findOrFail($invoiceId);
        $this->paymentAmount = $invoice->balance; // Default to remaining balance
        $this->paymentMethod = PaymentMethod::Cash->value;
        $this->paymentDate = now()->format('Y-m-d');
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedInvoiceId = null;
        $this->reset(['paymentAmount', 'paymentMethod', 'transactionReference', 'paymentNotes', 'paymentDate']);
    }

    public function handlePaymentRecorded()
    {
        $this->closePaymentModal();
    }

    public function savePayment()
    {
        $this->validate();

        try {
            $invoice = Invoice::findOrFail($this->selectedInvoiceId);

            // Re-check balance
            if ($this->paymentAmount > $invoice->balance) {
                $this->addError('paymentAmount', 'Amount cannot exceed remaining balance (' . $invoice->balance . ')');
                return;
            }

            app(PaymentService::class)->recordPayment(
                $invoice,
                $this->paymentAmount,
                PaymentMethod::from($this->paymentMethod),
                $this->transactionReference,
                $this->paymentNotes,
                $this->paymentDate ? Carbon::parse($this->paymentDate) : now()
            );

            session()->flash('message', 'Payment recorded successfully.');
            $this->dispatch('payment-recorded'); // You might want to refresh the list or dashboard
            $this->closePaymentModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to record payment: ' . $e->getMessage());
        }
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
