<?php

namespace App\Livewire;

use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class SubscriptionList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $listeners = ['subscription-ended' => '$refresh'];

    public function openEndModal($subscriptionId)
    {
        $this->dispatch('openSubscriptionEndModal', subscription: $subscriptionId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Subscription::with(['client', 'package'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->whereHas('client', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $subscriptions = $query->paginate(10);

        return view('livewire.subscription-list', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
