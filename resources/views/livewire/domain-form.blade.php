<div class="p-6">
    <div class="mb-6">
        <flux:button icon="chevron-left" variant="ghost" :href="route('domains.index')" wire:navigate>Back to Domains
        </flux:button>
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">
            {{ $isEditing ? 'Edit Domain' : 'Add New Domain' }}</h2>
    </div>

    <form wire:submit="save"
        class="space-y-6 max-w-2xl bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:select wire:model="client_id" label="Client" placeholder="Select a client">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </flux:select>

            <flux:input wire:model="name" label="Domain Name" placeholder="example.com" />

            <flux:input wire:model="registrar" label="Registrar" placeholder="GoDaddy, Namecheap, etc." />

            <flux:input wire:model="renewal_price" type="number" step="0.01" label="Renewal Price" prefix="₹" />

            <flux:input wire:model="purchase_date" type="date" label="Purchase Date" />

            <flux:input wire:model="expiry_date" type="date" label="Expiry Date" />

            <flux:select wire:model="status" label="Status">
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </flux:select>
        </div>

        <flux:textarea wire:model="notes" label="Notes" placeholder="Additional details..." rows="3" />

        <div class="flex justify-end pt-4">
            <flux:button type="submit" variant="primary" class="px-8">
                {{ $isEditing ? 'Update Domain' : 'Register Domain' }}</flux:button>
        </div>
    </form>
</div>