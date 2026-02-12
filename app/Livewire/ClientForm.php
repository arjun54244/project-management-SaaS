<?php

namespace App\Livewire;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ClientForm extends Component
{
    public ?Client $client = null;

    public $gst_number = '';
    public $gst_enabled = false;

    public function mount(?Client $client = null)
    {
        if ($client && $client->exists) {
            $this->client = $client;
            $this->name = $client->name;
            $this->email = $client->email;
            $this->phone = $client->phone;
            $this->company_name = $client->company_name;
            $this->gst_number = $client->gst_number;
            $this->gst_enabled = $client->gst_enabled;
            $this->dob = $client->dob ? $client->dob->format('Y-m-d') : '';
            $this->status = $client->status;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('clients')->ignore($this->client)],
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:20',
            'gst_enabled' => 'boolean',
            'dob' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'gst_number' => $this->gst_number,
            'gst_enabled' => $this->gst_enabled,
            'dob' => $this->dob ?: null,
            'status' => $this->status,
        ];

        if ($this->client) {
            $this->client->update($data);
            $message = 'Client updated successfully.';
        } else {
            Client::create($data);
            $message = 'Client created successfully.';
        }

        session()->flash('message', $message);
        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.client-form');
    }
}
