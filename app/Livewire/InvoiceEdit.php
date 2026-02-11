<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Package;
use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class InvoiceEdit extends Component
{
    public Invoice $invoice;
    public $items = [];
    public $tax = 0;
    public $discount = 0;
    public $due_date;
    public $subtotal = 0;
    public $total_amount = 0;
    public $canEdit = true;
    public $payment_status;
    public $payment_method;

    public $availablePackages;
    public $availableServices;

    protected $rules = [
        'items.*.item_type' => 'required|in:package,service,custom',
        'items.*.item_id' => 'nullable|required_if:items.*.item_type,package,service',
        'items.*.description' => 'required|string|max:255',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'tax' => 'required|numeric|min:0',
        'discount' => 'required|numeric|min:0',
        'due_date' => 'required|date',
        'payment_status' => 'required|in:paid,unpaid,partial',
        'payment_method' => 'nullable|in:cash,upi,cheque,bank_transfer,other',
    ];

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice->load('items', 'payments');

        // Rule: Invoice can be edited ONLY if no payments exist
        if ($this->invoice->payments()->count() > 0) {
            $this->canEdit = false;
        }

        $this->availablePackages = Package::where('status', 'active')->orderBy('name')->get();
        $this->availableServices = Service::where('status', 'active')->orderBy('name')->get();

        $this->tax = (float) $invoice->tax;
        $this->discount = (float) $invoice->discount;
        $this->due_date = \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d');
        $this->payment_status = $invoice->payment_status->value;
        $this->payment_method = $invoice->payment_method?->value;

        foreach ($invoice->items as $item) {
            $this->items[] = [
                'id' => $item->id,
                'item_type' => $item->item_type,
                'item_id' => $item->item_id,
                'description' => $item->description,
                'qty' => $item->qty,
                'price' => (float) $item->price,
                'total' => (float) $item->total,
            ];
        }

        $this->calculateTotals();
    }

    public function addItem()
    {
        if (!$this->canEdit)
            return;

        $this->items[] = [
            'id' => null,
            'item_type' => 'custom',
            'item_id' => null,
            'description' => '',
            'qty' => 1,
            'price' => 0,
            'total' => 0,
        ];
    }

    public function removeItem($index)
    {
        if (!$this->canEdit)
            return;

        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updatedItems($value, $key)
    {
        if (!$this->canEdit)
            return;

        $parts = explode('.', $key);
        if (count($parts) < 2)
            return;

        $index = $parts[0];
        $property = $parts[1];

        if ($property === 'item_type') {
            $this->items[$index]['item_id'] = null;
            $this->items[$index]['description'] = '';
            $this->items[$index]['price'] = 0;
        }

        if ($property === 'item_id') {
            $type = $this->items[$index]['item_type'];
            $id = $this->items[$index]['item_id'];

            if ($type === 'package' && $id) {
                $package = $this->availablePackages->find($id);
                if ($package) {
                    $this->items[$index]['description'] = $package->name;
                    $this->items[$index]['price'] = $package->base_price;
                }
            } elseif ($type === 'service' && $id) {
                $service = $this->availableServices->find($id);
                if ($service) {
                    $this->items[$index]['description'] = $service->name;
                    $this->items[$index]['price'] = $service->base_price;
                }
            }
        }

        $this->calculateTotals();
    }

    public function updatedTax()
    {
        $this->calculateTotals();
    }

    public function updatedDiscount()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $subtotal = 0;
        foreach ($this->items as $index => $item) {
            $itemTotal = (int) ($item['qty'] ?? 0) * (float) ($item['price'] ?? 0);
            $this->items[$index]['total'] = $itemTotal;
            $subtotal += $itemTotal;
        }

        $this->subtotal = $subtotal;
        $this->total_amount = ($subtotal + (float) $this->tax) - (float) $this->discount;
    }

    public function save()
    {
        if (!$this->canEdit) {
            session()->flash('error', 'Invoice cannot be edited after payment is received.');
            return;
        }

        $this->validate();

        try {
            DB::beginTransaction();

            // Update main invoice record
            $this->invoice->update([
                'tax' => $this->tax,
                'discount' => $this->discount,
                'subtotal' => $this->subtotal,
                'total_amount' => $this->total_amount,
                'due_date' => Carbon::parse($this->due_date),
                'payment_status' => $this->payment_status,
                'payment_method' => $this->payment_method ?: null,
            ]);

            // Sync items
            // Remove existing items and recreate to keep it simple and clean
            $this->invoice->items()->delete();

            foreach ($this->items as $itemData) {
                $this->invoice->items()->create([
                    'item_type' => $itemData['item_type'],
                    'item_id' => $itemData['item_id'],
                    'description' => $itemData['description'],
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                    'total' => $itemData['total'],
                ]);
            }

            DB::commit();

            session()->flash('message', 'Invoice updated successfully.');
            return redirect()->route('invoices.show', $this->invoice);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to update invoice: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.invoice-edit');
    }
}
