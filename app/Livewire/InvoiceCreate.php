<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Models\Package;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\Client;
use App\Services\InvoiceService;
use App\Enums\SubscriptionStatus;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Layout('layouts.app')]
class InvoiceCreate extends Component
{
    public $subscriptions;
    public $clients;
    public $availablePackages;
    public $availableServices;

    public $client_id = '';
    public $subscription_id = '';
    public $due_date;
    public $items = [];
    public $tax = 0;
    public $discount = 0;
    public $total_amount = 0;
    public $payment_status = 'unpaid';
    public $payment_method = null;

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'subscription_id' => 'nullable|exists:subscriptions,id',
        'due_date' => 'required|date',
        'items.*.item_type' => 'required|in:package,service,custom',
        'items.*.item_id' => 'nullable|required_if:items.*.item_type,package,service',
        'items.*.description' => 'required|string|max:255',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
        'tax' => 'required|numeric|min:0',
        'discount' => 'required|numeric|min:0',
        'payment_status' => 'required|in:paid,unpaid,partial',
        'payment_method' => 'nullable|in:cash,upi,cheque,bank_transfer,other',
    ];

    public function mount()
    {
        $this->clients = Client::orderBy('name')->get();
        $this->subscriptions = Subscription::with(['client', 'package'])
            ->where('status', SubscriptionStatus::Active)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->availablePackages = Package::where('status', 'active')->orderBy('name')->get();
        $this->availableServices = Service::where('status', 'active')->orderBy('name')->get();

        $this->due_date = now()->addDays(7)->format('Y-m-d');
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
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
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotals();
    }

    public function updatedItems($value, $key)
    {
        // Format of $key: index.property (e.g., 0.item_type)
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

    public function updatedSubscriptionId()
    {
        if (!$this->subscription_id)
            return;

        $subscription = $this->subscriptions->find($this->subscription_id);
        if ($subscription) {
            $this->client_id = $subscription->client_id;

            // Auto-add the package as an item if items are empty or just one default empty one
            if (count($this->items) === 1 && empty($this->items[0]['description'])) {
                $this->items[0] = [
                    'item_type' => 'package',
                    'item_id' => $subscription->package_id,
                    'description' => $subscription->package->name,
                    'qty' => 1,
                    'price' => $subscription->final_price,
                    'total' => $subscription->final_price,
                ];
            }

            $this->calculateTotals();
        }
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

    public function save(InvoiceService $invoiceService)
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $invoice = Invoice::create([
                'client_id' => $this->client_id,
                'subscription_id' => $this->subscription_id ?: null,
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'due_date' => Carbon::parse($this->due_date),
                'subtotal' => $this->subtotal,
                'tax' => $this->tax,
                'discount' => $this->discount,
                'total_amount' => $this->total_amount,
                'payment_status' => $this->payment_status,
                'payment_method' => $this->payment_method ?: null,
            ]);

            foreach ($this->items as $itemData) {
                $invoice->items()->create([
                    'item_type' => $itemData['item_type'],
                    'item_id' => $itemData['item_id'],
                    'description' => $itemData['description'],
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                    'total' => $itemData['total'],
                ]);
            }

            DB::commit();

            session()->flash('message', 'Invoice created successfully.');
            return redirect()->route('invoices.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.invoice-create');
    }
}
