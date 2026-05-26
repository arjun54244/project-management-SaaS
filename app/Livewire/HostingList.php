<?php

namespace App\Livewire;

use App\Models\Hosting;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class HostingList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Hosting::find($id)->delete();
        $this->dispatch('hosting-deleted');
    }

    public function renew($id)
    {
        $hosting = Hosting::find($id);
        return redirect()->route('invoices.create', [
            'client_id' => $hosting->client_id,
            'item_type' => 'hosting',
            'item_id' => $hosting->id,
            'description' => 'Hosting Renewal: ' . $hosting->plan_name,
            'price' => $hosting->renewal_price,
        ]);
    }

    public function render()
    {
        return view('livewire.hosting-list', [
            'hostings' => Hosting::query()
                ->where(function ($query) {
                    $query->where('plan_name', 'like', '%' . $this->search . '%')
                        ->orWhere('provider', 'like', '%' . $this->search . '%');
                })
                ->with(['client', 'domain'])
                ->orderBy('expiry_date', 'asc')
                ->paginate(10),
        ]);
    }
}
