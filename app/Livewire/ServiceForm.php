<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ServiceForm extends Component
{
    public ?Service $service = null;

    public $name;
    public $description;
    public $base_price;
    public $status = 'active';

    public function mount(?Service $service = null)
    {
        if ($service && $service->exists) {
            $this->service = $service;
            $this->name = $service->name;
            $this->description = $service->description;
            $this->base_price = $service->base_price;
            $this->status = $service->status;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
            'status' => $this->status,
        ];

        if ($this->service && $this->service->exists) {
            $this->service->update($data);
            session()->flash('message', 'Service updated successfully.');
        } else {
            Service::create($data);
            session()->flash('message', 'Service created successfully.');
        }

        return redirect()->route('services.index');
    }

    public function render()
    {
        return view('livewire.service-form');
    }
}
