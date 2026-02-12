<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Edit Invoice {{ $invoice->invoice_number }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Update line items and billing details.</p>
        </div>
        <a href="{{ route('invoices.show', $invoice) }}" 
           class="px-4 py-2 text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-700 transition">
            Cancel
        </a>
    </div>

    @if(!$canEdit)
        <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-3 dark:bg-amber-900/20 dark:border-amber-900/30">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="font-semibold text-amber-800 dark:text-amber-400">Invoice Locked</h3>
                <p class="text-sm text-amber-700 dark:text-amber-500">Invoice cannot be edited after payment is received. Please create a credit note or a new invoice if changes are required.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Line Items --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-800/50">
                    <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Line Items</h2>
                    @if($canEdit)
                    <button wire:click="addItem" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                        + Add Item
                    </button>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 font-medium">
                            <tr>
                                <th class="px-4 py-3 w-40">Type</th>
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
                                            @if(!$canEdit) disabled @endif
                                            class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                        <option value="package">Package</option>
                                        <option value="service">Service</option>
                                        <option value="domain">Domain</option>
                                        <option value="hosting">Hosting</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2 space-y-2">
                                    @if($item['item_type'] === 'package')
                                        <select wire:model.live="items.{{ $index }}.item_id"
                                                @if(!$canEdit) disabled @endif
                                                class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                            <option value="">Select Package...</option>
                                            @foreach($availablePackages as $package)
                                                <option value="{{ $package->id }}">{{ $package->name }} (₹{{ number_format($package->base_price, 2) }})</option>
                                            @endforeach
                                        </select>
                                    @elseif($item['item_type'] === 'service')
                                        <select wire:model.live="items.{{ $index }}.item_id"
                                                @if(!$canEdit) disabled @endif
                                                class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                            <option value="">Select Service...</option>
                                            @foreach($availableServices as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }} (₹{{ number_format($service->base_price, 2) }})</option>
                                            @endforeach
                                        </select>
                                    @elseif($item['item_type'] === 'domain')
                                        <select wire:model.live="items.{{ $index }}.item_id"
                                                @if(!$canEdit) disabled @endif
                                                class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                            <option value="">Select Domain...</option>
                                            @foreach($availableDomains as $domain)
                                                <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($item['item_type'] === 'hosting')
                                        <select wire:model.live="items.{{ $index }}.item_id"
                                                @if(!$canEdit) disabled @endif
                                                class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                            <option value="">Select Hosting...</option>
                                            @foreach($availableHostings as $hosting)
                                                <option value="{{ $hosting->id }}">{{ $hosting->plan_name }} ({{ $hosting->provider }})</option>
                                            @endforeach
                                        </select>
                                    @endif

                                    <input type="text" wire:model.blur="items.{{ $index }}.description" 
                                           @if(!$canEdit) disabled @endif
                                           placeholder="Item description..."
                                           class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800">
                                    @error("items.$index.description") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" wire:model.live.debounce.300ms="items.{{ $index }}.qty"
                                           @if(!$canEdit) disabled @endif
                                           class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800 text-right">
                                    @error("items.$index.qty") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" step="0.01" wire:model.live.debounce.300ms="items.{{ $index }}.price"
                                           @if(!$canEdit) disabled @endif
                                           class="w-full bg-transparent border-zinc-200 dark:border-zinc-700 rounded-md focus:ring-indigo-500 dark:bg-zinc-800 text-right">
                                    @error("items.$index.price") <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </td>
                                <td class="px-4 py-2 text-right font-medium text-zinc-900 dark:text-zinc-100">
                                    ₹{{ number_format($item['total'], 2) }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    @if($canEdit)
                                    <button wire:click="removeItem({{ $index }})" class="text-zinc-400 hover:text-red-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Billing Details --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 space-y-4">
                <h2 class="font-semibold text-zinc-900 dark:text-zinc-100">Billing Summary</h2>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Due Date</label>
                    <input type="date" wire:model="due_date" 
                           @if(!$canEdit) disabled @endif
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
                               @if(!$canEdit) disabled @endif
                               class="w-24 text-right bg-transparent border-zinc-200 dark:border-zinc-700 rounded focus:ring-indigo-500 dark:bg-zinc-800 p-1 text-sm dark:text-zinc-100">
                    </div>

                    <div class="flex justify-between items-center text-sm gap-4">
                        <span class="text-zinc-600 dark:text-zinc-400">Discount (-)</span>
                        <input type="number" step="0.01" wire:model.live.debounce.300ms="discount"
                               @if(!$canEdit) disabled @endif
                               class="w-24 text-right bg-transparent border-zinc-200 dark:border-zinc-700 rounded focus:ring-indigo-500 dark:bg-zinc-800 p-1 text-sm dark:text-zinc-100">
                    </div>

                    <div class="pt-2 flex justify-between font-bold text-zinc-900 dark:text-zinc-100">
                        <span>Grand Total</span>
                        <span class="text-lg text-indigo-600 dark:text-indigo-400">₹{{ number_format($total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Payment Management</h3>
                    
                    <div class="space-y-1">
                        <label for="payment_status" class="text-xs text-zinc-600 dark:text-zinc-400">Payment Status</label>
                        <select wire:model.live="payment_status" id="payment_status"
                                class="w-full text-sm border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                            @foreach(\App\Enums\PaymentStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ ucfirst($status->value) }}</option>
                            @endforeach
                        </select>
                        @error('payment_status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="payment_method" class="text-xs text-zinc-600 dark:text-zinc-400">Payment Mode</label>
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

                @if($canEdit)
                <button wire:click="save" 
                        class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold shadow-sm transition">
                    Save Changes
                </button>
                @endif
            </div>

            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-4 text-xs text-zinc-500 dark:text-zinc-400 space-y-2">
                <p>• Client: <span class="font-medium">{{ $invoice->client->name }}</span></p>
                <p>• Subscription: <span class="font-medium">{{ $invoice->subscription->package->name }}</span></p>
                <p>• Locked Fields: Invoice #, Client, Subscription</p>
            </div>
        </div>
    </div>
</div>

