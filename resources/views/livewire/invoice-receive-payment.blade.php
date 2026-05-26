<div
    class="bg-white dark:bg-zinc-900 rounded-xl overflow-hidden shadow-2xl transition-all border border-zinc-200 dark:border-zinc-800">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/50">
        <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 italic">Record Payment</h3>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">Invoice: {{ $invoice->invoice_number }} •
            {{ $invoice->client->name }}</p>
    </div>

    <div class="p-6">
        @if(session('message'))
            <div
                class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm text-green-800 dark:text-green-300">{{ session('message') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div
                class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-red-800 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        @if($remainingBalance > 0)
            <div class="mb-6 grid grid-cols-2 gap-4">
                <div
                    class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-100 dark:border-indigo-900/30">
                    <p class="text-[10px] uppercase tracking-wider font-bold text-indigo-600 dark:text-indigo-400">Total
                        Outstanding</p>
                    <p class="text-xl font-black text-indigo-900 dark:text-indigo-100">
                        ₹{{ number_format($remainingBalance, 2) }}</p>
                </div>
                <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <p class="text-[10px] uppercase tracking-wider font-bold text-zinc-500 dark:text-zinc-400">Total Paid
                    </p>
                    <p class="text-xl font-black text-zinc-700 dark:text-zinc-300">₹{{ number_format($totalPaid, 2) }}</p>
                </div>
            </div>

            <form wire:submit="recordPayment" class="space-y-4">
                <!-- Amount -->
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-1">Payment Amount</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-zinc-400 group-focus-within:text-indigo-500 transition-colors">₹</span>
                        </div>
                        <input wire:model="amount" type="number" step="0.01" min="0.01"
                            class="pl-8 w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-zinc-800 dark:text-zinc-100 font-bold">
                    </div>
                    @error('amount') <span
                    class="text-red-500 rotate-1 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-1">Mode</label>
                        <select wire:model.live="payment_method"
                            class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->value }}">{{ $method->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Date -->
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-1">Date Paid</label>
                        <input wire:model="paid_at" type="date"
                            class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                    </div>
                </div>

                <!-- Transaction Reference -->
                @php
                    $selectedMethod = \App\Enums\PaymentMethod::tryFrom($payment_method);
                @endphp
                @if($selectedMethod && $selectedMethod->requiresReference())
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-1">Reference ID <span
                                class="text-red-500">*</span></label>
                        <input wire:model="transaction_reference" type="text" placeholder="e.g. UPI Ref, Chq #, Txn ID"
                            class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-zinc-800 dark:text-zinc-100">
                        @error('transaction_reference') <span
                        class="text-red-500 rotate-1 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-1">Internal Notes</label>
                    <textarea wire:model="notes" rows="2" placeholder="Optional details..."
                        class="w-full border-zinc-200 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 dark:bg-zinc-800 dark:text-zinc-100"></textarea>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-black shadow-lg shadow-indigo-500/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="recordPayment">CONFIRM PAYMENT</span>
                        <span wire:loading wire:target="recordPayment">RECORDING...</span>
                        <svg wire:loading wire:target="recordPayment" class="animate-spin h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>
        @else
            <div class="py-8 text-center space-y-4">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-2">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-zinc-900 dark:text-zinc-100 italic uppercase">INVOICE SETTLED</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Total amount has been fully received. No further
                        payments required.</p>
                </div>
                <button wire:click="$dispatch('close-modal')"
                    class="px-6 py-2 bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-700 font-bold transition">
                    CLOSE
                </button>
            </div>
        @endif
    </div>
</div>