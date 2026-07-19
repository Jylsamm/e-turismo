<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.4s ease-out forwards;
            }
            .admin-card-hover {
                transition: all 0.3s ease-in-out !important;
            }
            .admin-card-hover:hover {
                transform: translateY(-4px) !important;
                box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.15), 0 4px 10px -5px rgba(21, 128, 61, 0.1) !important;
                border-color: #bbf7d0 !important;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="ti ti-user-cog text-2xl text-green-700"></i>
                Manage Staff Accounts
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0 animate-fade-in-up" x-data="{ deleteUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Sub-Navigation Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
                <a href="{{ route('verification.reviews') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.reviews') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-checklist mr-1"></i> ID Verification Reviews
                </a>
                <a href="{{ route('verification.accounts') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.accounts') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-users mr-1"></i> Verify Tourists
                </a>
                <a href="{{ route('verification.staff') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.staff') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-user-cog mr-1"></i> Manage Staff
                </a>
                <a href="{{ route('verification.add_account') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.add_account') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-user-plus mr-1"></i> Add Account
                </a>
            </div>

            {{-- Alerts --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 rounded-2xl px-4 py-3 text-sm shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div
                    class="bg-green-50 border border-green-300 text-green-700 rounded-2xl px-4 py-3 text-sm shadow-sm flex items-center gap-2">
                    <i class="ti ti-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="space-y-6">
                <div
                    class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden admin-card-hover">
                    <div
                        class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/50 to-white">
                        <div>

                        </div>
                        <a href="{{ route('verification.add_account') }}"
                            class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl text-xs transition flex items-center gap-1.5 shadow-sm">
                            <i class="ti ti-user-plus text-sm"></i> Add New Staff
                        </a>
                    </div>

                    <div class="max-h-[550px] overflow-y-auto overflow-x-auto relative">
                        <table class="w-full text-sm">
                            <thead
                                class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold sticky top-0 z-10 shadow-sm">
                                <tr>
                                    <th class="px-5 py-4 text-left">Staff Name / Email</th>
                                    <th class="px-5 py-4 text-left">Contact Number</th>
                                    <th class="px-5 py-4 text-left">Assigned Destination Spot</th>
                                    <th class="px-5 py-4 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($staffUsers as $user)
                                    <tr class="hover:bg-green-50/20 transition-colors duration-150">
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}
                                                {{ $user->last_name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                                <i class="ti ti-mail text-xs text-gray-400"></i>
                                                {{ $user->email }}
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-650">
                                            @if($user->contact)
                                                <p class="inline-flex items-center gap-1">
                                                    <i class="ti ti-phone text-xs text-gray-400"></i>
                                                    {{ $user->contact }}
                                                </p>
                                            @else
                                                <span class="text-gray-400 italic">None</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <form method="POST" action="{{ route('verification.staff.reassign', $user) }}"
                                                class="flex items-center gap-1.5" x-data="{ showDestDropdown: false, activeDestId: '{{ $user->assigned_destination_id }}', activeDestName: '{{ $user->assignedDestination ? $user->assignedDestination->name : 'No Spot Assigned' }}' }">
                                                @csrf
                                                <input type="hidden" name="assigned_destination_id" :value="activeDestId" />
                                                <div class="flex items-center gap-1.5 relative">
                                                    <!-- Dropdown Trigger Button -->
                                                    <button type="button" @click="showDestDropdown = !showDestDropdown" @click.away="showDestDropdown = false" class="flex justify-between items-center w-48 rounded-xl border border-gray-250 bg-white px-3 py-1.5 text-xs text-gray-700 font-semibold hover:bg-gray-50 transition focus:outline-none focus:ring-1 focus:ring-brand-500 shadow-sm">
                                                        <span class="truncate" x-text="activeDestName"></span>
                                                        <svg class="h-3 w-3 text-gray-450 transform transition-transform duration-200 shrink-0 ml-1" :class="showDestDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div x-show="showDestDropdown" 
                                                         x-transition:enter="transition ease-out duration-150"
                                                         x-transition:enter-start="opacity-0 scale-95"
                                                         x-transition:enter-end="opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-100"
                                                         x-transition:leave-start="opacity-100 scale-100"
                                                         x-transition:leave-end="opacity-0 scale-95"
                                                         class="absolute left-0 bottom-full mb-1.5 z-30 w-48 rounded-xl bg-white border border-gray-200 shadow-xl py-1 max-h-36 overflow-y-auto"
                                                         style="display: none;">
                                                        <button type="button" @click="activeDestId = ''; activeDestName = 'No Spot Assigned'; showDestDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                            -- No Spot Assigned --
                                                        </button>
                                                        @foreach($destinations as $dest)
                                                            @php
                                                                $assignedToOther = $staffUsers->where('id', '!=', $user->id)
                                                                    ->where('assigned_destination_id', $dest->id)
                                                                    ->isNotEmpty();
                                                            @endphp
                                                            @if(!$assignedToOther)
                                                                <button type="button" @click="activeDestId = '{{ $dest->id }}'; activeDestName = '{{ addslashes($dest->name) }}'; showDestDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                                    {{ $dest->name }}
                                                                </button>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-green-700 hover:bg-green-800 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1">
                                                        <i class="ti ti-device-floppy text-sm"></i> Save
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($user->id !== Auth::id())
                                                <button type="button"
                                                    @click="deleteUrl = '{{ route('verification.staff.delete', $user) }}'; $dispatch('open-confirm-modal', { id: 'delete-staff-modal' })"
                                                    class="text-red-500 hover:text-red-750 p-1.5 rounded-xl hover:bg-red-50 transition-all duration-150 flex items-center justify-center"
                                                    title="Delete staff account">
                                                    <i class="ti ti-trash text-lg"></i>
                                                </button>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Self (Protected)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-gray-400 italic">
                                            No staff accounts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Staff Confirmation Modal --}}
        <x-confirm-modal id="delete-staff-modal" title="Delete Staff Account"
            message="Are you sure you want to delete this staff account? This will permanently remove their access credentials.">
            <form method="POST" :action="deleteUrl">
                @csrf
                @method('DELETE')
                <button type="submit" @click.stop
                    class="px-4 py-2.5 rounded-xl bg-red-650 hover:bg-red-700 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        </x-confirm-modal>
    </div>
</x-app-layout>