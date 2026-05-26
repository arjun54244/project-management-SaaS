<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Client;
use App\Enums\PaymentMethod;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PaymentList extends Component
{
    use WithPagination;

    public $search = '';
    public $paymentMethod = '';
    public $clientId = '';
    public $startDate;
    public $endDate;

    protected $queryString = [
        'search' => ['except' => ''],
        'paymentMethod' => ['except' => ''],
        'clientId' => ['except' => ''],
        'startDate' => ['except' => null],
        'endDate' => ['except' => null],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Payment::query()
            ->with(['invoice.client'])
            ->latest('paid_at');

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('invoice', function ($iq) {
                    $iq->where('invoice_number', 'like', '%' . $this->search . '%');
                })->orWhere('transaction_reference', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->paymentMethod) {
            $query->where('payment_method', $this->paymentMethod);
        }

        if ($this->clientId) {
            $query->whereHas('invoice', function ($q) {
                $q->where('client_id', $this->clientId);
            });
        }

        if ($this->startDate) {
            $query->whereDate('paid_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('paid_at', '<=', $this->endDate);
        }

        return view('livewire.payment-list', [
            'payments' => $query->paginate(15),
            'clients' => Client::orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::cases(),
        ]);
    }
}
