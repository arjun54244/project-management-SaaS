<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Payment History</h2>
            <p class="text-sm text-zinc-500">Track all received payments and refunds</p>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-zinc-500 uppercase mb-1">Search</label>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Invoice / Ref..."
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-500 uppercase mb-1">Client</label>
                <select wire:model.live="clientId"
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
                    <option value="">All Clients</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-500 uppercase mb-1">Method</label>
                <select wire:model.live="paymentMethod"
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
                    <option value="">All Methods</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->value }}">{{ $method->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-500 uppercase mb-1">Start Date</label>
                <input wire:model.live="startDate" type="date"
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-zinc-500 uppercase mb-1">End Date</label>
                <input wire:model.live="endDate" type="date"
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
            </div>
        </div>
    </div>

    {{-- Payments Table --}}
    <div
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 font-bold">Date</th>
                        <th class="px-6 py-3 font-bold">Client</th>
                        <th class="px-6 py-3 font-bold">Invoice #</th>
                        <th class="px-6 py-3 font-bold">Method</th>
                        <th class="px-6 py-3 font-bold">Reference</th>
                        <th class="px-6 py-3 font-bold text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">
                                {{ $payment->paid_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $payment->invoice->client->name }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('invoices.show', $payment->invoice) }}"
                                    class="text-indigo-600 hover:underline">
                                    {{ $payment->invoice->invoice_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-bold uppercase">
                                    {{ $payment->payment_method->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs italic text-zinc-500">
                                {{ $payment->transaction_reference ?: '-' }}
                            </td>
                            <td
                                class="px-6 py-4 text-right font-bold {{ $payment->amount < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                ₹{{ number_format($payment->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-zinc-200 dark:text-zinc-800 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="text-zinc-500 italic">No payments found matching your criteria</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>