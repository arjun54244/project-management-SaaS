<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">

    @if($payments->isEmpty())
        <p class="text-center text-zinc-500 dark:text-zinc-400 py-8">No payments recorded yet.</p>
    @else
        <!-- Summary -->
        <div class="mb-4 grid grid-cols-3 gap-4">
            <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Invoice Total</p>
                <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                    ₹{{ number_format($invoice->total_amount, 2) }}</p>
            </div>
            <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <p class="text-xs text-green-700 dark:text-green-300">Total Paid</p>
                <p class="text-lg font-semibold text-green-700 dark:text-green-300">₹{{ number_format($totalPaid, 2) }}</p>
            </div>
            <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                <p class="text-xs text-orange-700 dark:text-orange-300">Remaining</p>
                <p class="text-lg font-semibold text-orange-700 dark:text-orange-300">
                    ₹{{ number_format($remainingBalance, 2) }}</p>
            </div>
        </div>

        <!-- Payment List -->
        <div class="space-y-3">
            @foreach($payments as $payment)
                <div
                    class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg {{ $payment->amount < 0 ? 'bg-red-50 dark:bg-red-900/10' : 'bg-white dark:bg-zinc-900' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                    {{ $payment->payment_method->label() }}
                                </span>
                                @if($payment->amount < 0)
                                    <span
                                        class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                                        REFUND
                                    </span>
                                @endif
                            </div>

                            @if($payment->transaction_reference)
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                    Ref: {{ $payment->transaction_reference }}
                                </p>
                            @endif

                            @if($payment->notes)
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                                    {{ $payment->notes }}
                                </p>
                            @endif

                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $payment->paid_at->format('M d, Y h:i A') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p
                                class="text-lg font-bold {{ $payment->amount < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                {{ $payment->amount < 0 ? '-' : '' }}₹{{ number_format(abs($payment->amount), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>