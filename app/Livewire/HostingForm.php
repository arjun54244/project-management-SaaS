<?php

namespace App\Livewire;

use App\Models\Hosting;
use App\Models\Client;
use App\Models\Domain;
use App\Enums\HostingStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class HostingForm extends Component
{
    public $hosting;
    public $isEditing = false;

    public $client_id;
    public $domain_id;
    public $provider;
    public $plan_name;
    public $ip_address;
    public $username;
    public $password;
    public $purchase_date;
    public $expiry_date;
    public $renewal_price;
    public $status;
    public $notes;

    public function mount(?Hosting $hosting = null)
    {
        if ($hosting && $hosting->exists) {
            $this->hosting = $hosting;
            $this->isEditing = true;
            $this->client_id = $hosting->client_id;
            $this->domain_id = $hosting->domain_id;
            $this->provider = $hosting->provider;
            $this->plan_name = $hosting->plan_name;
            $this->ip_address = $hosting->ip_address;
            $this->username = $hosting->username;
            $this->password = $hosting->password;
            $this->purchase_date = $hosting->purchase_date ? $hosting->purchase_date->format('Y-m-d') : null;
            $this->expiry_date = $hosting->expiry_date ? $hosting->expiry_date->format('Y-m-d') : null;
            $this->renewal_price = $hosting->renewal_price;
            $this->status = $hosting->status->value;
            $this->notes = $hosting->notes;
        } else {
            $this->purchase_date = date('Y-m-d');
            $this->status = HostingStatus::Active->value;
        }
    }

    public function save()
    {
        $rules = [
            'client_id' => 'required|exists:clients,id',
            'domain_id' => 'nullable|exists:domains,id',
            'provider' => 'required|string',
            'plan_name' => 'required|string',
            'purchase_date' => 'required|date',
            'expiry_date' => 'required|date|after:purchase_date',
            'renewal_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ];

        $this->validate($rules);

        $data = [
            'client_id' => $this->client_id,
            'domain_id' => $this->domain_id,
            'provider' => $this->provider,
            'plan_name' => $this->plan_name,
            'ip_address' => $this->ip_address,
            'username' => $this->username,
            'password' => $this->password,
            'purchase_date' => $this->purchase_date,
            'expiry_date' => $this->expiry_date,
            'renewal_price' => $this->renewal_price,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->isEditing) {
            $this->hosting->update($data);
        } else {
            Hosting::create($data);
        }

        return redirect()->route('hostings.index');
    }

    public function render()
    {
        return view('livewire.hosting-form', [
            'clients' => Client::orderBy('name')->get(),
            'domains' => $this->client_id ? Domain::where('client_id', $this->client_id)->orderBy('name')->get() : collect(),
            'statuses' => HostingStatus::cases(),
        ]);
    }
}
