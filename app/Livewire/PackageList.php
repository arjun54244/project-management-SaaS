<?php

namespace App\Livewire;

use App\Models\Package;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PackageList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $package = Package::findOrFail($id);

        if ($package->subscriptions()->where('status', 'active')->exists()) {
            session()->flash('error', 'Cannot delete package with active subscriptions.');
            return;
        }

        $package->delete();
        session()->flash('message', 'Package deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $package = Package::findOrFail($id);
        $package->status = $package->status === 'active' ? 'inactive' : 'active';
        $package->save();
    }

    public function render()
    {
        $packages = Package::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.package-list', [
            'packages' => $packages,
        ]);
    }
}
