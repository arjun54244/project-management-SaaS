<?php

namespace App\Livewire;

use App\Repositories\DashboardRepository;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $selectedYear;
    public $selectedMonth;
    public $renewalFilter = '7days';

    public $showPaymentModal = false;
    public $selectedInvoiceId;

    protected $listeners = [
        'payment-recorded' => 'handlePaymentRecorded',
        'invoice-updated' => '$refresh',
        'subscription-ended' => '$refresh'
    ];

    public function mount()
    {
        $this->selectedYear = date('Y');
        $this->selectedMonth = null;
    }

    public function setRenewalFilter($filter)
    {
        $this->renewalFilter = $filter;
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

    public function render(DashboardRepository $repository)
    {
        return view('livewire.dashboard', [
            'birthdays' => $repository->getBirthdaysThisWeek(),
            'upcomingRenewals' => $repository->getUpcomingRenewals($this->renewalFilter),
            'revenueMetrics' => $repository->getRevenueMetrics((int) $this->selectedYear, $this->selectedMonth),
            'quickStats' => $repository->getQuickStats(),
            'pendingInvoices' => $repository->getPendingInvoices(),
            'years' => range(date('Y'), date('Y') - 5),
            'months' => [
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            ],
        ]);
    }
}
