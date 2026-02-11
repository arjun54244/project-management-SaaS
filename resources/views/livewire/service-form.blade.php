<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
            {{ $service && $service->exists ? 'Edit Service' : 'Create Service' }}
        </h2>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
        <form wire:submit="save" class="space-y-6">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Service Name
                    *</label>
                <input wire:model="name" type="text" id="name"
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description"
                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                <textarea wire:model="description" id="description" rows="3"
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Base Price -->
            <div>
                <label for="base_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base Price
                    (Optional)</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-zinc-500 sm:text-sm">₹</span>
                    </div>
                    <input wire:model="base_price" type="number" step="0.01" min="0" id="base_price"
                        class="pl-7 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                </div>
                @error('base_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Leave empty if this service has no individual
                    price</p>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status *</label>
                <select wire:model="status" id="status"
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('services.index') }}"
                    class="px-4 py-2 border border-zinc-300 shadow-sm text-sm font-medium rounded-md text-zinc-700 bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $service && $service->exists ? 'Update' : 'Create' }} Service
                </button>
            </div>
        </form>
    </div>
</div>