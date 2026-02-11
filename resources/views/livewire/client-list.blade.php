<div>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Clients</h2>
        <a href="{{ route('clients.create') }}"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
            Add Client
        </a>
    </div>

    <!-- Search & Filters -->
    <div class="mb-6">
        <div class="relative max-w-sm">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                class="block w-full p-2.5 pl-10 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                placeholder="Search clients...">
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div
        class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Company</th>
                        <th class="px-6 py-3">Contact</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($clients as $client)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $client->name }}
                                @if($client->dob && \Carbon\Carbon::parse($client->dob)->isBirthday())
                                    <span
                                        class="ml-2 text-xs bg-pink-100 text-pink-800 px-2 py-0.5 rounded-full dark:bg-pink-900/30 dark:text-pink-300">🎂
                                        Birthday</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $client->company_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span>{{ $client->email }}</span>
                                    <span class="text-xs text-zinc-500">{{ $client->phone }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $client->id }})"
                                    class="px-2 py-1 text-xs rounded-full {{ $client->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' }}">
                                    {{ ucfirst($client->status) }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('clients.edit', $client) }}"
                                    class="text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                <button wire:click="delete({{ $client->id }})"
                                    wire:confirm="Are you sure you want to delete this client?"
                                    class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                No clients found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $clients->links() }}
        </div>
    </div>
</div>