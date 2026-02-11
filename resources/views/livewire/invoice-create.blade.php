<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Create New Invoice</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Generate a new billing entry for a client.</p>
        </div>
        <a href="{{ route('invoices.index') }}"
            class="px-4 py-2 text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-700 transition">
            Cancel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Client & Subscription Selection --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_id"
                            class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Select
                            Client</label>
                        <select wire:model="client_id" id="client_id"
                            class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                            <option value="">Choose a client...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="subscription_id"
                            class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Link to Subscription
                            (Optional)</label>
                        <select wire:model.live="subscription_id" id="subscription_id"
                            class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                            <option value="">No subscription linkage</option>
                            @foreach($subscriptions as $sub)
                                <option value="{{ $sub->id }}">
                                    {{ $sub->client->name }} - {{ $sub->package->name }}
                                    (₹{{ number_format($sub->final_price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('subscription_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Line Items --}}
            <div
                class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                <div
                    class="p-4 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-800/50">
                    <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Line Items</h2>
                    <button wire:click="addItem"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                        + Add Item
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 font-medium">
                            <tr>
                                <th class="px-4 py-3 w-48">Type</th>
                                <th class="px-4 py-3">Selection / Description</th>
                                <th class="px-4 py-3 w-24">Qty</th>
                                <th class="px-4 py-3 w-32">Price</th>
                                <th class="px-4 py-3 w-32">Total</th>
                                <th class="px-4 py-3 w-16"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach($items as $index => $item)
                                <tr>
                                    <td class="px-4 py-2">
                                        <select wire:model.live="items.{{ $index }}.item_type"
                                            class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                            <option value="package">Package</option>
                                            <option value="service">Service</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-2 space-y-2">
                                        @if($item['item_type'] === 'package')
                                            <select wire:model.live="items.{{ $index }}.item_id"
                                                class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                                <option value="">Select Package...</option>
                                                @foreach($availablePackages as $package)
                                                    <option value="{{ $package->id }}">{{ $package->name }}
                                                        (₹{{ number_format($package->base_price, 2) }})</option>
                                                @endforeach
                                            </select>
                                        @elseif($item['item_type'] === 'service')
                                            <select wire:model.live="items.{{ $index }}.item_id"
                                                class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                                <option value="">Select Service...</option>
                                                @foreach($availableServices as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}
                                                        (₹{{ number_format($service->base_price, 2) }})</option>
                                                @endforeach
                                            </select>
                                        @endif

                                        <input type="text" wire:model.blur="items.{{ $index }}.description"
                                            placeholder="Item description..."
                                            class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                        @error("items.$index.description") <span
                                        class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" wire:model.live.debounce.300ms="items.{{ $index }}.qty"
                                            class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800 text-right">
                                        @error("items.$index.qty") <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" step="0.01"
                                            wire:model.live.debounce.300ms="items.{{ $index }}.price"
                                            class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800 text-right">
                                        @error("items.$index.price") <span
                                        class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-4 py-2 text-right font-medium text-zinc-900 dark:text-zinc-100">
                                        ₹{{ number_format($item['total'], 2) }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <button wire:click="removeItem({{ $index }})"
                                            class="text-zinc-400 hover:text-red-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($items) === 0)
                    <div class="p-8 text-center text-zinc-500 dark:text-zinc-400">
                        No items added yet. Click "+ Add Item" to begin.
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            {{-- Billing Details --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 space-y-4">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Billing Summary</h2>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Due Date</label>
                    <input type="date" wire:model="due_date"
                        class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                    @error('due_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-2">
                    <div class="flex justify-between text-sm text-zinc-600 dark:text-zinc-400">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-zinc-600 dark:text-zinc-400">Tax (+)</span>
                        <input type="number" step="0.01" wire:model.live.debounce.300ms="tax"
                            class="w-24 text-right bg-transparent border-zinc-200 dark:border-zinc-700 rounded focus:ring-indigo-500 dark:bg-zinc-800 p-1 text-sm dark:text-zinc-100">
                    </div>

                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-zinc-600 dark:text-zinc-400">Discount (-)</span>
                        <input type="number" step="0.01" wire:model.live.debounce.300ms="discount"
                            class="w-24 text-right bg-transparent border-zinc-200 dark:border-zinc-700 rounded focus:ring-indigo-500 dark:bg-zinc-800 p-1 text-sm dark:text-zinc-100">
                    </div>

                    <div class="pt-2 flex justify-between font-bold text-zinc-900 dark:text-zinc-100">
                        <span>Grand Total</span>
                        <span
                            class="text-lg text-indigo-600 dark:text-indigo-400">₹{{ number_format($total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Payment Management</h3>

                    <div class="space-y-1">
                        <label for="payment_status" class="text-xs text-zinc-600 dark:text-zinc-400">Payment
                            Status</label>
                        <select wire:model.live="payment_status" id="payment_status"
                            class="w-full text-sm border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                            @foreach(\App\Enums\PaymentStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                            @endforeach
                        </select>
                        @error('payment_status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="payment_method" class="text-xs text-zinc-600 dark:text-zinc-400">Payment
                            Mode</label>
                        <select wire:model="payment_method" id="payment_method"
                            class="w-full text-sm border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                            <option value="">None / Pending</option>
                            @foreach(\App\Enums\PaymentMethod::cases() as $method)
                                <option value="{{ $method->value }}">{{ $method->label() }}</option>
                            @endforeach
                        </select>
                        @error('payment_method') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button wire:click="save"
                    class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold shadow-sm transition">
                    Create Invoice
                </button>
            </div>

            <div
                class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 text-xs text-blue-700 dark:text-blue-400 space-y-2">
                <p class="font-semibold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pro Tip
                </p>
                <p>Selecting a Package or Service will automatically fill the description and base price. You can still
                    customize them after selection.</p>
            </div>
        </div>
    </div>
</div>