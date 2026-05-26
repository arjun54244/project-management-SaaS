<?php

namespace App\Livewire;

use App\Models\Domain;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DomainList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        Domain::find($id)->delete();
        $this->dispatch('domain-deleted');
    }

    public function renew($id)
    {
        $domain = Domain::findOrFail($id);

        $invoice = \Illuminate\Support\Facades\DB::transaction(function () use ($domain) {
            $tax = $domain->client->gst_enabled ? round($domain->renewal_price * 0.18, 2) : 0;
            $total = $domain->renewal_price + $tax;

            $invoice = \App\Models\Invoice::create([
                'client_id' => $domain->client_id,
                'invoice_number' => 'INV-DOM-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'invoice_date' => now(),
                'due_date' => now()->addDays(7),
                'subtotal' => $domain->renewal_price,
                'tax' => $tax,
                'total_amount' => $total,
                'payment_status' => \App\Enums\PaymentStatus::Unpaid,
            ]);

            $invoice->items()->create([
                'item_type' => 'domain',
                'item_id' => $domain->id,
                'description' => 'Domain Renewal: ' . $domain->name . ' (' . $domain->expiry_date->format('Y') . '-' . $domain->expiry_date->copy()->addYear()->format('Y') . ')',
                'qty' => 1,
                'price' => $domain->renewal_price,
                'total' => $domain->renewal_price,
            ]);

            return $invoice;
        });

        return redirect()->route('invoices.show', $invoice);
    }

    public function render()
    {
        return view('livewire.domain-list', [
            'domains' => Domain::where('name', 'like', '%' . $this->search . '%')
                ->with('client')
                ->orderBy('expiry_date', 'asc')
                ->paginate(10),
        ]);
    }
}
