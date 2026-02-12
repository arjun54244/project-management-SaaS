<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Invoices</h2>
        <a href="{{ route('invoices.create') }}"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
            New Invoice
        </a>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900/30 dark:text-green-300">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="mb-6 flex gap-4">
        <div class="relative max-w-sm flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                class="block w-full p-2.5 pl-10 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                placeholder="Search invoice or client...">
        </div>
        <select wire:model.live="filterStatus"
            class="block p-2.5 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-400 dark:text-white">
            <option value="">All Statuses</option>
            <option value="paid">Paid</option>
            <option value="unpaid">Unpaid</option>
            <option value="partial">Partial</option>
            <option value="overdue">Overdue</option>
        </select>
    </div>

    <!-- Table -->
    <div
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Invoice #</th>
                        <th class="px-6 py-3">Client</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Due Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Payment Mode</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Paid</th>
                        <th class="px-6 py-3">Balance</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($invoices as $invoice)
                        @php
                            $isOverdue = $invoice->payment_status !== \App\Enums\PaymentStatus::Paid && $invoice->due_date->isPast();
                        @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $invoice->invoice_number }}
                            </td>
                            <td class="px-6 py-4">{{ $invoice->client->name }}</td>
                            <td class="px-6 py-4">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 {{ $isOverdue ? 'text-red-600 dark:text-red-400' : '' }}">
                                {{ $invoice->due_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($isOverdue)
                                    <span
                                        class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                        Overdue
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                                                                                                @if($invoice->payment_status === \App\Enums\PaymentStatus::Paid) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                                                                                @elseif($invoice->payment_status === \App\Enums\PaymentStatus::Partial) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                                                                                @else bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300 @endif">
                                        {{ ucfirst($invoice->payment_status->value) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $invoice->payment_method ? $invoice->payment_method->label() : '-' }}
                            </td>
                            <td class="px-6 py-4 font-semibold">₹{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-6 py-4 text-emerald-600 dark:text-emerald-400 font-medium">
                                ₹{{ number_format($invoice->total_paid, 2) }}</td>
                            <td class="px-6 py-4 text-amber-600 dark:text-amber-400 font-medium">
                                ₹{{ number_format($invoice->remaining_balance, 2) }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('invoices.show', $invoice) }}"
                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    View
                                </a>
                                @if($invoice->total_paid == 0)
                                    <a href="{{ route('invoices.edit', $invoice) }}"
                                        class="text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300">
                                        Edit
                                    </a>
                                @else
                                    <span class="text-zinc-400 dark:text-zinc-600 cursor-not-allowed"
                                        title="Locked after payment">
                                        Edit
                                    </span>
                                @endif
                                @if($invoice->payment_status !== \App\Enums\PaymentStatus::Paid)
                                    <button wire:click="openPaymentModal({{ $invoice->id }})"
                                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        Record Payment
                                    </button>
                                    <button wire:click="markAsPaid({{ $invoice->id }})"
                                        wire:confirm="Are you sure you want to mark this invoice as fully paid? This will record a manual payment for the remaining balance."
                                        class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                                        Mark as Paid
                                    </button>
                                @endif
                                <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank"
                                    class="text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-300">
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                No invoices found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $invoices->links() }}
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
                        <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-zinc-100" id="modal-title">
                            Record Payment
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="amount"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-zinc-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" step="0.01" wire:model="paymentAmount" id="amount"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-zinc-300 rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                                        placeholder="0.00">
                                </div>
                                @error('paymentAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="method"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Payment
                                    Method</label>
                                <select wire:model="paymentMethod" id="method"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-zinc-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                                    @foreach(\App\Enums\PaymentMethod::cases() as $method)
                                        <option value="{{ $method->value }}">{{ $method->label() }}</option>
                                    @endforeach
                                </select>
                                @error('paymentMethod') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="reference"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Transaction
                                    Reference</label>
                                <input type="text" wire:model="transactionReference" id="reference"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-zinc-300 rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                                    placeholder="Check No, UPI Ref, etc.">
                                @error('transactionReference') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Payment
                                    Date</label>
                                <input type="date" wire:model="paymentDate" id="date"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-zinc-300 rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                                @error('paymentDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="notes"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Notes</label>
                                <textarea wire:model="paymentNotes" id="notes" rows="3"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-zinc-300 rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"></textarea>
                                @error('paymentNotes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="savePayment"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Record Payment
                        </button>
                        <button type="button" wire:click="closePaymentModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-zinc-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-zinc-700 hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>