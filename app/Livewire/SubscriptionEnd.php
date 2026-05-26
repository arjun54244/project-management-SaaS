<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use Livewire\Component;
use Carbon\Carbon;

class SubscriptionEnd extends Component
{
    public Subscription $subscription;
    public $termination_date;
    public $reason;
    public $isModalOpen = false;

    protected $listeners = ['openSubscriptionEndModal' => 'openModal'];

    public function mount()
    {
        $this->termination_date = Carbon::today()->format('Y-m-d');
    }

    public function openModal(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['reason']);
    }

    public function endSubscription(SubscriptionService $subscriptionService)
    {
        $this->validate([
            'termination_date' => 'required|date',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $subscriptionService->endSubscription(
                $this->subscription,
                Carbon::parse($this->termination_date),
                $this->reason
            );

            $this->isModalOpen = false;
            $this->dispatch('subscription-ended');
            session()->flash('message', 'Subscription terminated successfully.');

            // If we are on the subscription list or view, we can redirect or refresh
            return redirect()->route('subscriptions.index');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to terminate subscription: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.subscription-end');
    }
}
