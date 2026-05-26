<div class="p-6">
    <div class="mb-6">
        <flux:button icon="chevron-left" variant="ghost" :href="route('hostings.index')" wire:navigate>Back to Hosting
        </flux:button>
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">
            {{ $isEditing ? 'Edit Hosting' : 'Add New Hosting' }}</h2>
    </div>

    <form wire:submit="save"
        class="space-y-6 max-w-4xl bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:select wire:model.live="client_id" label="Client" placeholder="Select a client">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </flux:select>

            <flux:select wire:model="domain_id" label="Link Domain" placeholder="Select a domain (optional)">
                <option value="">No domain linked</option>
                @foreach($domains as $domain)
                    <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                @endforeach
            </flux:select>

            <flux:input wire:model="provider" label="Hosting Provider"
                placeholder="Bluehost, AWS, DigitalOcean, etc." />

            <flux:input wire:model="plan_name" label="Plan Name" placeholder="Basic Shared, Pro VPS, etc." />

            <flux:input wire:model="ip_address" label="IP Address" placeholder="123.123.123.123" />

            <flux:input wire:model="renewal_price" type="number" step="0.01" label="Renewal Price" prefix="₹" />

            <flux:input wire:model="purchase_date" type="date" label="Purchase Date" />

            <flux:input wire:model="expiry_date" type="date" label="Expiry Date" />

            <div
                class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-100 dark:border-zinc-800">
                <flux:input wire:model="username" label="Control Panel Username" icon="user" />
                <flux:input wire:model="password" type="text" label="Control Panel Password" icon="key" />
            </div>

            <flux:select wire:model="status" label="Status">
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </flux:select>
        </div>

        <flux:textarea wire:model="notes" label="Notes" placeholder="Additional details..." rows="3" />

        <div class="flex justify-end pt-4">
            <flux:button type="submit" variant="primary" class="px-8">
                {{ $isEditing ? 'Update Hosting' : 'Register Hosting' }}</flux:button>
        </div>
    </form>
</div>