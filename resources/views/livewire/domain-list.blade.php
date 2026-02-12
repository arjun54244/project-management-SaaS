<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Domain Renewals</h2>
            <p class="text-sm text-zinc-500">Manage domain registrations and expiry dates</p>
        </div>
        <flux:button icon="plus" variant="primary" :href="route('domains.create')" wire:navigate>Add Domain
        </flux:button>
    </div>

    <div class="mb-4">
        <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search domains..." />
    </div>

    <div
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Domain Name</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Registrar</th>
                    <th class="px-6 py-3">Expiry Date</th>
                    <th class="px-6 py-3">Renewal Price</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($domains as $domain)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                        <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100 italic">
                            {{ $domain->name }}
                        </td>
                        <td class="px-6 py-4">{{ $domain->client->name }}</td>
                        <td class="px-6 py-4 text-xs font-semibold uppercase text-zinc-500">{{ $domain->registrar }}</td>
                        <td
                            class="px-6 py-4 {{ $domain->expiry_date->isPast() ? 'text-red-600 font-bold' : ($domain->expiry_date->diffInDays(now()) < 30 ? 'text-amber-600' : '') }}">
                            {{ $domain->expiry_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 font-bold">₹{{ number_format($domain->renewal_price, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            <flux:badge :color="$domain->status->color()" size="sm">{{ $domain->status->label() }}
                            </flux:badge>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <flux:button wire:click="renew({{ $domain->id }})" icon="banknotes" variant="ghost" size="sm"
                                color="emerald" title="Generate Renewal Invoice" />
                            <flux:button :href="route('domains.edit', $domain)" icon="pencil-square" variant="ghost"
                                size="sm" wire:navigate />
                            <flux:button wire:click="delete({{ $domain->id }})"
                                wire:confirm="Are you sure you want to delete this domain?" icon="trash" variant="ghost"
                                size="sm" color="danger" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-zinc-500 italic">No domains found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $domains->links() }}
    </div>
</div>