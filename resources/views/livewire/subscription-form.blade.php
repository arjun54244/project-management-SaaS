<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
            Create Subscription
        </h2>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Client -->
                <div>
                    <label for="client_id"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Client</label>
                    <select wire:model.live="client_id" id="client_id"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Package -->
                <div>
                    <label for="package_id"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Package</label>
                    <select wire:model.live="package_id" id="package_id"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <option value="">Select Package</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}">
                                {{ $package->name }} - ₹{{ number_format($package->base_price, 2) }} /
                                {{ $package->duration_months }}m
                            </option>
                        @endforeach
                    </select>
                    @error('package_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Pricing & Discount</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Base Price (Read Only) -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base Price</label>
                        <div
                            class="mt-1 block w-full py-2 px-3 rounded-md border border-zinc-300 bg-zinc-50 text-zinc-500 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400">
                            ₹{{ number_format($base_price, 2) }}
                        </div>
                    </div>

                    <!-- Discount Type -->
                    <div>
                        <label for="discount_type"
                            class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Discount Type</label>
                        <select wire:model.live="discount_type" id="discount_type"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                            <option value="">None</option>
                            <option value="percentage">Percentage (%)</option>
                            <option value="flat">Flat Amount (₹)</option>
                        </select>
                    </div>

                    <!-- Discount Value -->
                    <div>
                        <label for="discount_value"
                            class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Discount Value</label>
                        <input wire:model.live="discount_value" type="number" min="0" step="0.01" id="discount_value"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    </div>
                </div>

                <!-- Final Price -->
                <div class="mt-6 flex justify-end items-center gap-4">
                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Final Price:</span>
                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        ₹{{ number_format($final_price, 2) }}
                    </span>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('subscriptions.index') }}"
                    class="px-4 py-2 border border-zinc-300 shadow-sm text-sm font-medium rounded-md text-zinc-700 bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Subscription
                </button>
            </div>
        </form>
    </div>
</div>