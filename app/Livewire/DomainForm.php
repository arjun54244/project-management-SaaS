<?php

namespace App\Livewire;

use App\Models\Domain;
use App\Models\Client;
use App\Enums\DomainStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DomainForm extends Component
{
    public $domain;
    public $isEditing = false;

    public $client_id;
    public $name;
    public $registrar;
    public $purchase_date;
    public $expiry_date;
    public $renewal_price;
    public $status;
    public $notes;

    public function mount(?Domain $domain = null)
    {
        if ($domain && $domain->exists) {
            $this->domain = $domain;
            $this->isEditing = true;
            $this->client_id = $domain->client_id;
            $this->name = $domain->name;
            $this->registrar = $domain->registrar;
            $this->purchase_date = $domain->purchase_date ? $domain->purchase_date->format('Y-m-d') : null;
            $this->expiry_date = $domain->expiry_date ? $domain->expiry_date->format('Y-m-d') : null;
            $this->renewal_price = $domain->renewal_price;
            $this->status = $domain->status->value;
            $this->notes = $domain->notes;
        } else {
            $this->purchase_date = date('Y-m-d');
            $this->status = DomainStatus::Active->value;
        }
    }

    public function save()
    {
        $rules = [
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|unique:domains,name,' . ($this->domain->id ?? 'NULL'),
            'registrar' => 'required|string',
            'purchase_date' => 'required|date',
            'expiry_date' => 'required|date|after:purchase_date',
            'renewal_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ];

        $this->validate($rules);

        $data = [
            'client_id' => $this->client_id,
            'name' => $this->name,
            'registrar' => $this->registrar,
            'purchase_date' => $this->purchase_date,
            'expiry_date' => $this->expiry_date,
            'renewal_price' => $this->renewal_price,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->isEditing) {
            $this->domain->update($data);
        } else {
            Domain::create($data);
        }

        return redirect()->route('domains.index');
    }

    public function render()
    {
        return view('livewire.domain-form', [
            'clients' => Client::orderBy('name')->get(),
            'statuses' => DomainStatus::cases(),
        ]);
    }
}
