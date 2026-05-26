<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Hosting Renewals</h2>
            <p class="text-sm text-zinc-500">Manage web hosting accounts and subscriptions</p>
        </div>
        <flux:button icon="plus" variant="primary" :href="route('hostings.create')" wire:navigate>Add Hosting
        </flux:button>
    </div>

    <div class="mb-4">
        <flux:input wire:model.live="search" icon="magnifying-glass"
            placeholder="Search hosting plans or providers..." />
    </div>

    <div
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Plan / Provider</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Linked Domain</th>
                    <th class="px-6 py-3">Expiry Date</th>
                    <th class="px-6 py-3">Renewal Price</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($hostings as $hosting)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $hosting->plan_name }}</div>
                            <div class="text-[10px] text-zinc-500 font-bold uppercase">{{ $hosting->provider }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $hosting->client->name }}</td>
                        <td class="px-6 py-4">
                            @if($hosting->domain)
                                <span
                                    class="text-xs italic text-indigo-600 dark:text-indigo-400">{{ $hosting->domain->name }}</span>
                            @else
                                <span class="text-xs text-zinc-400">None</span>
                            @endif
                        </td>
                        <td
                            class="px-6 py-4 {{ $hosting->expiry_date->isPast() ? 'text-red-600 font-bold' : ($hosting->expiry_date->diffInDays(now()) < 30 ? 'text-amber-600' : '') }}">
                            {{ $hosting->expiry_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 font-bold">₹{{ number_format($hosting->renewal_price, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <flux:badge :color="$hosting->status->color()" size="sm">{{ $hosting->status->label() }}
                            </flux:badge>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <flux:button wire:click="renew({{ $hosting->id }})" icon="banknotes" variant="ghost" size="sm"
                                color="emerald" title="Generate Renewal Invoice" />
                            <flux:button :href="route('hostings.edit', $hosting)" icon="pencil-square" variant="ghost"
                                size="sm" wire:navigate />
                            <flux:button wire:click="delete({{ $hosting->id }})"
                                wire:confirm="Are you sure you want to delete this hosting account?" icon="trash"
                                variant="ghost" size="sm" color="danger" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-zinc-500 italic">No hosting accounts found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $hostings->links() }}
    </div>
</div>