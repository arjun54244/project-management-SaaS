<div x-data="{
    search: @entangle('search'),
    filterStatus: @entangle('filterStatus'),

    columns: JSON.parse(localStorage.getItem('invoice_table_columns')) || {
        invoice_number: true,
        client: true,
        date: true,
        due_date: true,
        status: true,
        payment_mode: true,
        total: true,
        // paid: true,
        // balance: true
    },

    toggleColumn(col) {
        this.columns[col] = !this.columns[col];
        localStorage.setItem(
            'invoice_table_columns',
            JSON.stringify(this.columns)
        );
    },

    async shareInvoice(url, filename, title) {

        try {

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/pdf',
                }
            });

            if (!response.ok) {
                throw new Error('Failed to generate PDF');
            }

            const blob = await response.blob();

            // Validate PDF
            if (blob.type !== 'application/pdf') {
                throw new Error('Invalid PDF response');
            }

            const file = new File(
                [blob],
                filename,
                { type: 'application/pdf' }
            );

            // Mobile Share API
            if (
                navigator.canShare &&
                navigator.canShare({ files: [file] })
            ) {

                await navigator.share({
                    files: [file],
                    title: title,
                });

            } else {

                // Download fallback
                const blobUrl = window.URL.createObjectURL(blob);

                const link = document.createElement('a');
                link.href = blobUrl;
                link.download = filename;

                document.body.appendChild(link);

                link.click();

                document.body.removeChild(link);

                setTimeout(() => {
                    window.URL.revokeObjectURL(blobUrl);
                }, 1000);
            }

        } catch (error) {

            console.error('Invoice Share Error:', error);

            alert(
                'Failed to download/share invoice PDF. Please try again.'
            );
        }
    }
}">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
            Invoices
        </h2>

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
    <div class="mb-6 flex flex-wrap gap-4">

        <!-- Search -->
        <div class="relative max-w-sm flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>

            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search invoice or client..."
                class="block w-full p-2.5 pl-10 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
            >
        </div>

        <!-- Status Filter -->
        <select
            wire:model.live="filterStatus"
            class="block p-2.5 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
        >
            <option value="">All Statuses</option>
            <option value="paid">Paid</option>
            <option value="unpaid">Unpaid</option>
            <option value="partial">Partial</option>
            <option value="overdue">Overdue</option>
        </select>

        <!-- Column Toggle -->
        <div x-data="{ open: false }" class="relative">

            <button
                @click="open = !open"
                type="button"
                class="px-4 py-2.5 text-sm font-medium text-zinc-900 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-100 dark:bg-zinc-800 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-700"
            >
                Columns
            </button>

            <div
                x-show="open"
                @click.away="open = false"
                class="absolute z-10 w-48 bg-white rounded-lg shadow border border-zinc-200 dark:bg-zinc-700 dark:border-zinc-600 mt-2 right-0"
            >
                <ul class="p-3 space-y-1 text-sm">

                    <template x-for="(isEnabled, column) in columns" :key="column">
                        <li>
                            <div class="flex items-center p-2 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-600">

                                <input
                                    @click="toggleColumn(column)"
                                    :id="'checkbox-' + column"
                                    type="checkbox"
                                    :checked="isEnabled"
                                    class="w-4 h-4 text-indigo-600 border-zinc-300 rounded"
                                >

                                <label
                                    :for="'checkbox-' + column"
                                    class="ml-2 capitalize text-zinc-800 dark:text-zinc-200"
                                    x-text="column.replace(/_/g, ' ')"
                                ></label>

                            </div>
                        </li>
                    </template>

                </ul>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <!-- Head -->
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">

                    <tr>
                        <th x-show="columns.invoice_number" class="px-6 py-3">Invoice #</th>
                        <th x-show="columns.client" class="px-6 py-3">Client</th>
                        <th x-show="columns.date" class="px-6 py-3">Date</th>
                        <th x-show="columns.due_date" class="px-6 py-3">Due Date</th>
                        <th x-show="columns.status" class="px-6 py-3">Status</th>
                        <th x-show="columns.payment_mode" class="px-6 py-3">Payment Mode</th>
                        <th x-show="columns.total" class="px-6 py-3">Total</th>
                        <!-- <th x-show="columns.paid" class="px-6 py-3">Paid</th>
                        <th x-show="columns.balance" class="px-6 py-3">Balance</th> -->
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>

                </thead>

                <!-- Body -->
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">

                    @forelse($invoices as $invoice)

                        @php
                            $isOverdue =
                                $invoice->payment_status !== \App\Enums\PaymentStatus::Paid
                                && $invoice->due_date->isPast();
                        @endphp

                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">

                            <td x-show="columns.invoice_number"
                                class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $invoice->invoice_number }}
                            </td>

                            <td x-show="columns.client" class="px-6 py-4">
                                {{ $invoice->client->name }}
                            </td>

                            <td x-show="columns.date" class="px-6 py-4">
                                {{ $invoice->invoice_date->format('M d, Y') }}
                            </td>

                            <td
                                x-show="columns.due_date"
                                class="px-6 py-4 {{ $isOverdue ? 'text-red-600 dark:text-red-400' : '' }}"
                            >
                                {{ $invoice->due_date->format('M d, Y') }}
                            </td>

                            <!-- Status -->
                            <td x-show="columns.status" class="px-6 py-4">

                                @if($isOverdue)

                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                        Overdue
                                    </span>

                                @else

                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($invoice->payment_status === \App\Enums\PaymentStatus::Paid)
                                            bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                        @elseif($invoice->payment_status === \App\Enums\PaymentStatus::Partial)
                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                        @else
                                            bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300
                                        @endif
                                    ">
                                        {{ ucfirst($invoice->payment_status->value) }}
                                    </span>

                                @endif

                            </td>

                            <!-- Payment -->
                            <td x-show="columns.payment_mode"
                                class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $invoice->payment_method?->label() ?? '-' }}
                            </td>

                            <!-- Total -->
                            <td x-show="columns.total"
                                class="px-6 py-4 font-semibold">
                                ₹{{ number_format($invoice->total_amount, 2) }}
                            </td>

                            <!-- Paid -->
                            <!-- <td x-show="columns.paid"
                                class="px-6 py-4 text-emerald-600 dark:text-emerald-400 font-medium">
                                ₹{{ number_format($invoice->total_paid, 2) }}
                            </td> -->

                            <!-- Balance -->
                            <!-- <td x-show="columns.balance"
                                class="px-6 py-4 text-amber-600 dark:text-amber-400 font-medium">
                                ₹{{ number_format($invoice->remaining_balance, 2) }}
                            </td> -->

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right whitespace-nowrap space-x-3">

                                <!-- Share -->
                                <button
                                    @click="
                                        shareInvoice(
                                            '{{ route('invoices.pdf', $invoice) }}',
                                            'Invoice-{{ $invoice->invoice_number }}.pdf',
                                            'Invoice {{ $invoice->invoice_number }}'
                                        )
                                    "
                                    class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300"
                                    title="Share Invoice"
                                >
                                    Share
                                </button>

                                <!-- View -->
                                <a
                                    href="{{ route('invoices.show', $invoice) }}"
                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                                >
                                    View
                                </a>

                                <!-- Edit -->
                                @if($invoice->total_paid == 0)

                                    <a
                                        href="{{ route('invoices.edit', $invoice) }}"
                                        class="text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-300"
                                    >
                                        Edit
                                    </a>

                                @else

                                    <span
                                        class="text-zinc-400 cursor-not-allowed"
                                        title="Locked after payment"
                                    >
                                        Edit
                                    </span>

                                @endif

                                <!-- Record Payment -->
                                @if($invoice->payment_status !== \App\Enums\PaymentStatus::Paid)

                                    <button
                                        wire:click="openPaymentModal({{ $invoice->id }})"
                                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
                                    >
                                        Record Payment
                                    </button>

                                    <button
                                        wire:click="markAsPaid({{ $invoice->id }})"
                                        wire:confirm="Are you sure?"
                                        class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300"
                                    >
                                        Paid
                                    </button>

                                @endif

                                <!-- PDF -->
                                <a
                                    href="{{ route('invoices.pdf', $invoice) }}"
                                    target="_blank"
                                    class="text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-300"
                                >
                                    PDF
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10"
                                class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
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
</div>