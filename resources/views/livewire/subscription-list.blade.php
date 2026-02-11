<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Subscriptions</h2>
        <a href="{{ route('subscriptions.create') }}"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
            New Subscription
        </a>
    </div>

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
                placeholder="Search client...">
        </div>
        <select wire:model.live="filterStatus"
            class="block p-2.5 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-400 dark:text-white">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="expired">Expired</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <!-- Table -->
    <div
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Client</th>
                        <th class="px-6 py-3">Package</th>
                        <th class="px-6 py-3">Start Date</th>
                        <th class="px-6 py-3">End Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($subscriptions as $subscription)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $subscription->client->name }}
                            </td>
                            <td class="px-6 py-4">{{ $subscription->package->name }}</td>
                            <td class="px-6 py-4">{{ $subscription->start_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">{{ $subscription->end_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                                @if($subscription->status === \App\Enums\SubscriptionStatus::Active) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                @elseif($subscription->status === \App\Enums\SubscriptionStatus::Expired) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                                    {{ ucfirst($subscription->status->value) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">₹{{ number_format($subscription->final_price, 2) }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('subscriptions.edit', $subscription) }}"
                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm">
                                    Edit
                                </a>
                                @if($subscription->status === \App\Enums\SubscriptionStatus::Active)
                                    <button wire:click="openEndModal({{ $subscription->id }})"
                                        class="ml-3 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                        End
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                No subscriptions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $subscriptions->links() }}
        </div>
    </div>

    @livewire('subscription-end')
</div>