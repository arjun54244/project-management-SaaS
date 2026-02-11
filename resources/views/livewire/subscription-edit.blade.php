<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
            Edit Subscription
        </h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
            Client: <span class="font-medium">{{ $subscription->client->name }}</span>
        </p>
    </div>

    @if($package_locked)
        <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Package Locked</h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">
                        Package cannot be changed after invoicing. To change the package, please create a new subscription.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <p class="text-sm text-red-800 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package -->
                <div>
                    <label for="package_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Package @if($package_locked)<span class="text-xs text-yellow-600">(Locked)</span>@endif
                    </label>
                    <select wire:model.live="package_id" id="package_id" @if($package_locked) disabled @endif
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white disabled:bg-zinc-100 dark:disabled:bg-zinc-800 disabled:cursor-not-allowed">
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

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Start
                        Date</label>
                    <input wire:model.live="start_date" type="date" id="start_date"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

                <!-- Calculated Fields -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between items-center p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                        <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">End Date:</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-zinc-100">
                            {{ $end_date ?: 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                        <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">Final Price:</span>
                        <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                            ₹{{ number_format($final_price, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('subscriptions.index') }}"
                    class="px-4 py-2 border border-zinc-300 shadow-sm text-sm font-medium rounded-md text-zinc-700 bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Subscription
                </button>
            </div>
        </form>
    </div>
</div>