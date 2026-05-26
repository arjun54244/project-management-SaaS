<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
            {{ $package ? 'Edit Package' : 'Create Package' }}
        </h2>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
        <form wire:submit="save" class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Name</label>
                <input wire:model="name" type="text" id="name"
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Duration -->
                <div>
                    <label for="duration_months"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Duration</label>
                    <select wire:model="duration_months" id="duration_months"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <option value="1">1 Month</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">12 Months</option>
                    </select>
                    @error('duration_months') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="base_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base
                        Price</label>
                    <input wire:model="base_price" type="number" step="0.01" id="base_price"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    @error('base_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description"
                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                <textarea wire:model="description" id="description" rows="3"
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                <select wire:model="status" id="status"
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Services Section -->
            <div class="border-t border-zinc-200 dark:border-zinc-800 pt-6">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Included Services</h3>

                @if($services->isEmpty())
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        No services available. <a href="{{ route('services.create') }}"
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">Create a service</a> first.
                    </p>
                @else
                    <div class="space-y-3">
                        @foreach($services as $service)
                            <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                <div class="flex items-center space-x-3 flex-1">
                                    <input wire:model.live="selectedServices" type="checkbox" value="{{ $service->id }}"
                                        id="service_{{ $service->id }}"
                                        class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 dark:bg-zinc-700 dark:border-zinc-600">
                                    <label for="service_{{ $service->id }}" class="flex-1 cursor-pointer">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $service->name }}
                                        </div>
                                        @if($service->base_price)
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                ₹{{ number_format($service->base_price, 2) }}</div>
                                        @endif
                                    </label>
                                </div>

                                @if(in_array($service->id, $selectedServices))
                                    <div class="flex items-center space-x-2">
                                        <label for="qty_{{ $service->id }}"
                                            class="text-xs text-zinc-500 dark:text-zinc-400">Qty:</label>
                                        <input wire:model="serviceQuantities.{{ $service->id }}" type="number" min="1"
                                            id="qty_{{ $service->id }}"
                                            class="w-16 rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(count($selectedServices) > 0)
                        <div class="mt-3 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                            <p class="text-sm text-indigo-700 dark:text-indigo-300">
                                <strong>{{ count($selectedServices) }}</strong> service(s) selected
                            </p>
                        </div>
                    @endif
                @endif
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <a href="{{ route('packages.index') }}"
                    class="px-4 py-2 border border-zinc-300 shadow-sm text-sm font-medium rounded-md text-zinc-700 bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $package ? 'Update Package' : 'Create Package' }}
                </button>
            </div>
        </form>
    </div>
</div>