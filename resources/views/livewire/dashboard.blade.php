<div x-data="{ 
    showMetrics: $persist(true).as('dash_metrics'),
    showOutstanding: $persist(true).as('dash_outstanding'),
    showBirthdays: $persist(true).as('dash_birthdays'),
    showPaymentRecap: $persist(true).as('dash_payments'),
    showRenewals: $persist(true).as('dash_renewals'),
    showSettings: false
}">
    {{-- Header with Year/Month Selection & Customization --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Enterprise Dashboard</h2>
            <p class="text-sm text-zinc-500">Real-time revenue and subscription insights</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Customization Toggle --}}
            <div class="relative">
                <button @click="showSettings = !showSettings"
                    class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition"
                    title="Customize Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </button>

                <div x-show="showSettings" @click.away="showSettings = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-56 p-4 bg-white dark:bg-zinc-900 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-800 z-50 space-y-3">
                    <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Show/Hide Widgets</h4>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="showMetrics"
                            class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300 group-hover:text-indigo-500">Revenue
                            Metrics</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="showOutstanding"
                            class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300 group-hover:text-indigo-500">Outstanding
                            Invoices</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="showBirthdays"
                            class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300 group-hover:text-indigo-500">Weekly
                            Birthdays</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="showPaymentRecap"
                            class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300 group-hover:text-indigo-500">Payment
                            Recap</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="showRenewals"
                            class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300 group-hover:text-indigo-500">Upcoming
                            Renewals</span>
                    </label>
                </div>
            </div>

            <select wire:model.live="selectedYear"
                class="rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            <select wire:model.live="selectedMonth"
                class="rounded-lg border-zinc-200 dark:border-zinc-800 dark:bg-zinc-900 text-sm">
                <option value="">Full Year</option>
                @foreach($months as $num => $name)
                    <option value="{{ $num }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Metrics Grid --}}
    <div x-show="showMetrics" x-collapse class="grid grid-cols-1 gap-4 md:grid-cols-4 mb-8">
        <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Invoiced</h3>
            <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">
                ₹{{ number_format($revenueMetrics['total_invoiced'], 2) }}
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Net Revenue</h3>
            <p class="mt-2 text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                ₹{{ number_format($revenueMetrics['net_revenue'], 2) }}
            </p>
            <div class="mt-2 text-xs text-zinc-500">
                + ₹{{ number_format($revenueMetrics['tax_collected'], 2) }} GST
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Received</h3>
            <p class="mt-2 text-3xl font-bold text-emerald-600 dark:text-emerald-500">
                ₹{{ number_format($revenueMetrics['total_received'], 2) }}
            </p>
        </div>

        <div
            class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm border-l-4 border-l-amber-500">
            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Outstanding</h3>
            <p class="mt-2 text-3xl font-bold text-amber-600 dark:text-amber-500">
                ₹{{ number_format($revenueMetrics['total_outstanding'], 2) }}
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex justify-between items-start">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Quick Stats</h3>
                <span class="text-[10px] px-1.5 bg-zinc-100 dark:bg-zinc-800 rounded uppercase font-bold">This
                    Month</span>
            </div>
            <div class="mt-3 space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-zinc-500">Today:</span>
                    <span class="font-bold">₹{{ number_format($quickStats['today_received'], 2) }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-zinc-500">Month:</span>
                    <span class="font-bold">₹{{ number_format($quickStats['month_received'], 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Outstanding Invoices Section --}}
    <div x-show="showOutstanding" x-collapse class="mb-8">
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Outstanding Invoices</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Invoice #</th>
                            <th class="px-6 py-3">Client</th>
                            <th class="px-6 py-3">Due Date</th>
                            <th class="px-6 py-3 text-right">Balance</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($pendingInvoices as $invoice)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td class="px-6 py-4">{{ $invoice->client->name }}</td>
                                <td class="px-6 py-4 {{ $invoice->due_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                    {{ $invoice->due_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-amber-600">
                                    ₹{{ number_format($invoice->remaining_balance, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center space-x-3">
                                    <a href="{{ route('invoices.edit', $invoice) }}"
                                        class="text-amber-500 hover:text-amber-700 transition" title="Edit Invoice">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button wire:click="openPaymentModal({{ $invoice->id }})"
                                        class="text-green-500 hover:text-green-700 transition" title="Record Payment">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-zinc-500 italic">No outstanding invoices
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Birthdays and Quick Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div x-show="showBirthdays" x-collapse class="md:col-span-2">
            <!-- Birthdays Card -->
            <div
                class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm h-full">
                <div class="flex items-center gap-2 mb-4 text-zinc-500 dark:text-zinc-400">

                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <!-- Candle -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 2c.8 0 1.5.7 1.5 1.5S12.8 5 12 5s-1.5-.7-1.5-1.5S11.2 2 12 2z" />

                        <!-- Cake top -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16v4H4z" />

                        <!-- Cake bottom -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 14h18v6H3z" />

                        <!-- Decorative icing -->
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 14c1 1 2 1 3 0s2-1 3 0 2 1 3 0 2-1 3 0" />
                    </svg>

                    <h3 class="text-sm font-medium">Birthdays (This Week)</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse($birthdays as $client)
                        <div
                            class="p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 flex justify-between items-center transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $client->name }}</span>
                            <span
                                class="text-xs px-2 py-1 bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400 rounded-full font-bold">
                                {{ \Carbon\Carbon::parse($client->dob)->format('M d') }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-full py-4 text-center text-zinc-400 text-sm italic">
                            No birthdays this week
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div x-show="showPaymentRecap" x-collapse>
            <!-- Payment Recap -->
            <div
                class="p-6 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm h-full">
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4 text-center">Payment Modes
                    (Month)</h3>
                <div class="space-y-3">
                    @forelse($quickStats['method_summary'] as $method)
                        <div class="flex justify-between items-center">
                            <span
                                class="text-xs text-zinc-600 dark:text-zinc-400">{{ $method->payment_method->label() }}</span>
                            <span class="text-sm font-bold">₹{{ number_format($method->total, 2) }}</span>
                        </div>
                    @empty
                        <div class="py-4 text-center text-zinc-400 text-xs italic">No data</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Renewals Table --}}
    <div x-show="showRenewals" x-collapse
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden mb-8">
        <div
            class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Upcoming Renewals</h3>

            <div class="inline-flex p-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                <button wire:click="setRenewalFilter('7days')"
                    class="px-3 py-1.5 text-xs font-medium rounded-md {{ $renewalFilter == '7days' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-zinc-100' : 'text-zinc-500 hover:text-zinc-700' }}">
                    Next 7 Days
                </button>
                <button wire:click="setRenewalFilter('this_week')"
                    class="px-3 py-1.5 text-xs font-medium rounded-md {{ $renewalFilter == 'this_week' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-zinc-100' : 'text-zinc-500 hover:text-zinc-700' }}">
                    Weekly
                </button>
                <button wire:click="setRenewalFilter('this_month')"
                    class="px-3 py-1.5 text-xs font-medium rounded-md {{ $renewalFilter == 'this_month' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-zinc-100' : 'text-zinc-500 hover:text-zinc-700' }}">
                    Monthly
                </button>
                <button wire:click="setRenewalFilter('next_month')"
                    class="px-3 py-1.5 text-xs font-medium rounded-md {{ $renewalFilter == 'next_month' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-zinc-100' : 'text-zinc-500 hover:text-zinc-700' }}">
                    Next Month
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Client</th>
                        <th class="px-6 py-3">Package</th>
                        <th class="px-6 py-3">Expiry Date</th>
                        <th class="px-6 py-3 text-right">Remaining</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($upcomingRenewals as $sub)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $sub['client_name'] }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] {{ $sub['type'] === 'subscription' ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : ($sub['type'] === 'domain' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400') }} font-bold uppercase">
                                        {{ $sub['type'] }}
                                    </span>
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400 font-medium">
                                        {{ $sub['package_name'] }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-300">
                                {{ $sub['end_date']->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @php
                                    $badgeClass = match ($sub['highlight_level']) {
                                        'danger' => 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400',
                                        'warning' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400',
                                        default => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                    {{ $sub['days_remaining'] }} Days
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $route = match ($sub['type']) {
                                        'domain' => route('domains.edit', $sub['id']),
                                        'hosting' => route('hostings.edit', $sub['id']),
                                        default => route('subscriptions.edit', $sub['id']),
                                    };
                                @endphp
                                <a href="{{ $route }}" class="text-zinc-400 hover:text-indigo-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-zinc-200 dark:text-zinc-800 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span class="text-zinc-500 italic">No renewals found for this period</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Payment Modal --}}
    @if($showPaymentModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-zinc-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    wire:click="closePaymentModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        @livewire('invoice-receive-payment', ['invoice' => $selectedInvoiceId], key: 'payment-modal-' . $selectedInvoiceId)
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>