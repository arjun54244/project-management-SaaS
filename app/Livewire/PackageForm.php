<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PackageForm extends Component
{
    public ?Package $package = null;

    public $name = '';
    public $duration_months = 1;
    public $base_price = '';
    public $description = '';
    public $status = 'active';

    // Service management
    public $selectedServices = [];
    public $serviceQuantities = [];

    public function mount(?Package $package = null)
    {
        if ($package && $package->exists) {
            $this->package = $package->load('services');
            $this->name = $package->name;
            $this->duration_months = $package->duration_months;
            $this->base_price = $package->base_price;
            $this->description = $package->description;
            $this->status = $package->status;

            // Load existing services
            foreach ($package->services as $service) {
                $this->selectedServices[] = $service->id;
                $this->serviceQuantities[$service->id] = $service->pivot->quantity ?? 1;
            }
        }
    }

    public function updatedSelectedServices()
    {
        // Initialize quantity for newly selected services
        foreach ($this->selectedServices as $serviceId) {
            if (!isset($this->serviceQuantities[$serviceId])) {
                $this->serviceQuantities[$serviceId] = 1;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'duration_months' => 'required|integer|in:1,3,6,12',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'selectedServices' => 'nullable|array',
            'selectedServices.*' => 'exists:services,id',
            'serviceQuantities.*' => 'integer|min:1',
        ]);

        $data = [
            'name' => $this->name,
            'duration_months' => $this->duration_months,
            'base_price' => $this->base_price,
            'description' => $this->description,
            'status' => $this->status,
        ];

        if ($this->package) {
            $this->package->update($data);
            $message = 'Package updated successfully.';
        } else {
            $this->package = Package::create($data);
            $message = 'Package created successfully.';
        }

        // Sync services with quantities
        $syncData = [];
        foreach ($this->selectedServices as $serviceId) {
            $syncData[$serviceId] = [
                'quantity' => $this->serviceQuantities[$serviceId] ?? 1
            ];
        }
        $this->package->services()->sync($syncData);

        session()->flash('message', $message);
        return redirect()->route('packages.index');
    }

    public function render()
    {
        $services = Service::active()->orderBy('name')->get();

        return view('livewire.package-form', [
            'services' => $services,
        ]);
    }
}
