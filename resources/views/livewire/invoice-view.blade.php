<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
            Invoice {{ $invoice->invoice_number }}
        </h2>
        <div class="flex space-x-3">
            @if($invoice->total_paid == 0)
                <a href="{{ route('invoices.edit', $invoice) }}"
                    class="px-4 py-2 border border-amber-300 shadow-sm text-sm font-medium rounded-md text-amber-700 bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 dark:text-amber-300 dark:border-amber-900/30">
                    Edit Invoice
                </a>
            @endif
            <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank"
                class="px-4 py-2 border border-zinc-300 shadow-sm text-sm font-medium rounded-md text-zinc-700 bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                Download PDF
            </a>
            <button onclick="shareInvoice_{{ $invoice->id }}()"
                class="px-4 py-2 border border-zinc-300 shadow-sm text-sm font-medium rounded-md text-zinc-700 bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                Share Invoice
            </button>
            <script>
                function shareInvoice_{{ $invoice->id }}() {
                    const shareData = {
                        title: 'Invoice {{ $invoice->invoice_number }}',
                        text: 'View invoice {{ $invoice->invoice_number }}',
                        url: '{{ URL::signedRoute('invoices.public.pdf', $invoice) }}'
                    };
                    if (navigator.share) {
                        navigator.share(shareData);
                    } else {
                        navigator.clipboard.writeText(shareData.url);
                        alert('Invoice link copied to clipboard!');
                    }
                }
            </script>
            @if($invoice->payment_status !== \App\Enums\PaymentStatus::Paid)
                <button wire:click="openPaymentModal"
                    class="px-4 py-2 border border-green-300 shadow-sm text-sm font-medium rounded-md text-green-700 bg-white hover:bg-green-50 dark:bg-zinc-800 dark:text-green-400 dark:border-green-900/50 dark:hover:bg-zinc-700">
                    Record Payment
                </button>
                <button wire:click="markAsPaid" wire:confirm="Are you sure you want to mark this invoice as fully paid?"
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700">
                    Mark as Paid
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg dark:bg-green-900/30 dark:text-green-300">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-8">
        <!-- Header -->
        <div class="flex justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">INVOICE</h1>
                <p class="text-zinc-600 dark:text-zinc-400">{{ $invoice->invoice_number }}</p>
            </div>
            <div class="text-right">
                @php
                    $isOverdue = $invoice->payment_status !== \App\Enums\PaymentStatus::Paid && $invoice->due_date->isPast();
                @endphp
                @if($isOverdue)
                    <span
                        class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                        Overdue
                    </span>
                @else
                    <span
                        class="px-3 py-1 text-sm rounded-full 
                                                                    @if($invoice->payment_status === \App\Enums\PaymentStatus::Paid) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                                    @elseif($invoice->payment_status === \App\Enums\PaymentStatus::Partial) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                                    @else bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300 @endif">
                        {{ ucfirst($invoice->payment_status->value) }}
                    </span>
                @endif
                @if($invoice->payment_method)
                    <div class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        Paid via {{ $invoice->payment_method->label() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Dates & Client Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 uppercase mb-2">Bill To</h3>
                <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $invoice->client->name }}</p>
                @if($invoice->client->company_name)
                    <p class="text-zinc-600 dark:text-zinc-400">{{ $invoice->client->company_name }}</p>
                @endif
                <p class="text-zinc-600 dark:text-zinc-400">{{ $invoice->client->email }}</p>
                @if($invoice->client->phone)
                    <p class="text-zinc-600 dark:text-zinc-400">{{ $invoice->client->phone }}</p>
                @endif
                @if($invoice->client->gst_number)
                    <p class="text-zinc-600 dark:text-zinc-400">GSTIN: {{ $invoice->client->gst_number }}</p>
                @endif
            </div>
            <div class="text-right">
                <div class="mb-2">
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Invoice Date:</span>
                    <span
                        class="ml-2 text-zinc-900 dark:text-zinc-100">{{ $invoice->invoice_date->format('M d, Y') }}</span>
                </div>
                <div>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Due Date:</span>
                    <span
                        class="ml-2 {{ $isOverdue ? 'text-red-600 dark:text-red-400' : 'text-zinc-900 dark:text-zinc-100' }}">
                        {{ $invoice->due_date->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden mb-8">
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">
                            Description</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">
                            Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">
                            Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">
                            Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-6 py-4 text-zinc-900 dark:text-zinc-100">{{ $item->description }}</td>
                            <td class="px-6 py-4 text-center text-zinc-600 dark:text-zinc-400">{{ $item->qty }}</td>
                            <td class="px-6 py-4 text-right text-zinc-600 dark:text-zinc-400">
                                ₹{{ number_format($item->price, 2) }}</td>
                            <td class="px-6 py-4 text-right text-zinc-900 dark:text-zinc-100">
                                ₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="flex justify-end">
            <div class="w-64">
                <div class="flex justify-between py-2">
                    <span class="text-zinc-600 dark:text-zinc-400">Subtotal</span>
                    <span class="text-zinc-900 dark:text-zinc-100">₹{{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                @if($invoice->discount > 0)
                    <div class="flex justify-between py-2">
                        <span class="text-zinc-600 dark:text-zinc-400">Discount</span>
                        <span class="text-red-600 dark:text-red-400">-₹{{ number_format($invoice->discount, 2) }}</span>
                    </div>
                @endif
                @if($invoice->tax > 0)
                    <div class="flex justify-between py-2">
                        <span class="text-zinc-600 dark:text-zinc-400">Tax</span>
                        <span class="text-zinc-900 dark:text-zinc-100">₹{{ number_format($invoice->tax, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between py-3 border-t-2 border-zinc-300 dark:border-zinc-600 mt-2">
                    <span class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Total</span>
                    <span
                        class="text-lg font-bold text-indigo-600 dark:text-indigo-400">₹{{ number_format($invoice->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Payment History</h3>
        @livewire('invoice-payment-history', ['invoice' => $invoice])
    </div>

    <div class="mt-6">
        <a href="{{ route('invoices.index') }}"
            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
            ← Back to Invoices
        </a>
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
                        @livewire('invoice-receive-payment', ['invoice' => $invoice], 'payment-modal-' . $invoice->id)
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>