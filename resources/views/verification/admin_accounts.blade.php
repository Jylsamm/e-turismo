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
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="ti ti-shield-check text-2xl text-green-700"></i>
                Verify Tourists
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0 animate-fade-in-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Error Alerts --}}
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
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-2xl px-4 py-3 text-sm shadow-sm flex items-center gap-2">
                <i class="ti ti-circle-check text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Sub-Navigation Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
                <a href="{{ route('verification.reviews') }}" 
                   class="px-4 py-2 text-sm font-semibold rounded-xl transition {{ request()->routeIs('verification.reviews') ? 'bg-green-700 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    <i class="ti ti-checklist mr-1"></i> ID Verification Reviews
                </a>
                <a href="{{ route('verification.accounts') }}" 
                   class="px-4 py-2 text-sm font-semibold rounded-xl transition {{ request()->routeIs('verification.accounts') ? 'bg-green-700 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    <i class="ti ti-users mr-1"></i> Verify Tourists
                </a>
                <a href="{{ route('verification.staff') }}" 
                   class="px-4 py-2 text-sm font-semibold rounded-xl transition {{ request()->routeIs('verification.staff') ? 'bg-green-700 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    <i class="ti ti-user-cog mr-1"></i> Manage Staff
                </a>
                <a href="{{ route('verification.add_account') }}" 
                   class="px-4 py-2 text-sm font-semibold rounded-xl transition {{ request()->routeIs('verification.add_account') ? 'bg-green-700 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                    <i class="ti ti-user-plus mr-1"></i> Add Account
                </a>
            </div>

            <div class="space-y-6" x-data="{ searchQuery: '', statusFilter: 'all' }">
                <div class="bg-white shadow-sm hover:shadow-lg border border-gray-150 rounded-2xl overflow-hidden transition-all duration-300">

                    <!-- Search and Status Filter Bar -->
                    <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50/60 to-white flex flex-col sm:flex-row gap-3 items-center justify-between">
                        <!-- Search Bar -->
                        <div class="relative w-full sm:max-w-sm group">
                            <span class="absolute inset-y-0 flex items-center pointer-events-none text-gray-400 group-focus-within:text-green-600 transition-colors duration-200" style="left: 14px;">
                                <i class="ti ti-search text-base"></i>
                            </span>
                            <input type="text" x-model="searchQuery" id="tourist-search" placeholder="Search by name or email…" style="padding-left: 2.75rem;" class="w-full pr-8 py-2.5 border border-gray-200 rounded-xl text-sm shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 bg-white placeholder-gray-400 transition-all duration-200 hover:border-gray-300" />
                            <!-- Clear button -->
                            <button type="button" x-show="searchQuery.length > 0" x-transition @click="searchQuery = ''" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-400 transition-colors duration-150">
                                <i class="ti ti-x text-sm"></i>
                            </button>
                        </div>

                        <!-- Status Filter Pill Buttons -->
                        <div class="flex items-center gap-2 flex-wrap justify-end">
                            <span class="text-xs font-semibold text-gray-400 mr-0.5">Filter:</span>

                            <button type="button" @click="statusFilter = 'all'"
                                :class="statusFilter === 'all' ? 'bg-gray-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-list text-xs"></i> All
                            </button>

                            <button type="button" @click="statusFilter = 'verified'"
                                :class="statusFilter === 'verified' ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-green-700 border border-green-200 hover:bg-green-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-discount-check text-xs"></i> Verified
                            </button>

                            <button type="button" @click="statusFilter = 'pending'"
                                :class="statusFilter === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-amber-600 border border-amber-200 hover:bg-amber-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-clock-hour-4 text-xs"></i> Pending
                            </button>

                            <button type="button" @click="statusFilter = 'rejected'"
                                :class="statusFilter === 'rejected' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-red-600 border border-red-200 hover:bg-red-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-circle-x text-xs"></i> Rejected
                            </button>

                            <button type="button" @click="statusFilter = 'unverified'"
                                :class="statusFilter === 'unverified' ? 'bg-gray-500 text-white shadow-sm' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-help text-xs"></i> Unverified
                            </button>
                        </div>
                    </div>

                    <div class="max-h-[550px] overflow-y-auto overflow-x-auto relative">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold sticky top-0 z-10 shadow-sm">
                                <tr>
                                    <th class="px-5 py-4 text-left">Name / Email</th>
                                    <th class="px-5 py-4 text-left">Role</th>
                                    <th class="px-5 py-4 text-left">Identity Details</th>
                                    <th class="px-5 py-4 text-left">Verification Status</th>
                                    <th class="px-5 py-4 text-left">Verification Notes</th>
                                    <th class="px-5 py-4 text-left">Action / Update Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($allUsers as $user)
                                <tr class="hover:bg-green-50/20 transition-colors duration-150"
                                    x-show="(statusFilter === 'all' || '{{ $user->id_verification_status }}' === statusFilter) && 
                                            (searchQuery === '' || '{{ strtolower(addslashes($user->name . ' ' . $user->last_name)) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower(addslashes($user->email)) }}'.includes(searchQuery.toLowerCase()))">
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-gray-800 text-sm">{{ $user->name }} {{ $user->last_name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                            <i class="ti ti-mail text-xs text-gray-400"></i>
                                            {{ $user->email }}
                                        </p>
                                        @if($user->contact)
                                        <p class="text-xs text-gray-500 inline-flex items-center gap-1 mt-0.5">
                                            <i class="ti ti-phone text-xs text-gray-400"></i>
                                            {{ $user->contact }}
                                        </p>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($user->isAdmin())
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100 uppercase">
                                                <i class="ti ti-shield-lock text-xs"></i> Admin
                                            </span>
                                        @elseif($user->isStaff())
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100 uppercase">
                                                <i class="ti ti-user-cog text-xs"></i> Staff
                                            </span>
                                        @elseif($user->isTourist())
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-100 uppercase">
                                                <i class="ti ti-user text-xs"></i> Tourist
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-700 border border-gray-100 uppercase">
                                                {{ $user->role }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-655">
                                        @if($user->isTourist())
                                            <div class="space-y-0.5">
                                                <p class="flex items-center gap-1"><i class="ti ti-id text-gray-400"></i> <strong class="text-gray-700">Type:</strong> {{ $user->id_type ?? 'None' }}</p>
                                                <p class="flex items-center gap-1"><i class="ti ti-hash text-gray-400"></i> <strong class="text-gray-700">No:</strong> {{ $user->id_number ?? 'None' }}</p>
                                                <p class="flex items-center gap-1"><i class="ti ti-calendar-event text-gray-400"></i> <strong class="text-gray-700">DOB:</strong> {{ $user->dob ? $user->dob->format('M j, Y') : 'N/A' }} (Age: {{ $user->age }})</p>
                                            </div>
                                        @elseif($user->isStaff() && $user->assignedDestination)
                                            <p class="text-green-700 font-semibold inline-flex items-center gap-1">
                                                <i class="ti ti-map-pin text-sm text-green-600"></i> {{ $user->assignedDestination->name }}
                                            </p>
                                        @else
                                            <span class="text-gray-400 italic">—</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @php
                                            $st = $user->id_verification_status;
                                            $badgeClasses = 'bg-gray-100 text-gray-800 border-gray-200';
                                            $icon = 'ti-help';
                                            if ($st === 'verified') {
                                                $badgeClasses = 'bg-green-100 text-green-800 border-green-200';
                                                $icon = 'ti-discount-check-filled';
                                            } elseif ($st === 'pending') {
                                                $badgeClasses = 'bg-amber-100 text-amber-800 border-amber-200';
                                                $icon = 'ti-clock-hour-4';
                                            } elseif ($st === 'rejected') {
                                                $badgeClasses = 'bg-red-100 text-red-800 border-red-200';
                                                $icon = 'ti-circle-x';
                                            }
                                        @endphp
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase border shadow-sm {{ $badgeClasses }}">
                                                <i class="ti {{ $icon }} text-xs"></i>
                                                {{ $st }}
                                            </span>
                                            @if($user->is_manually_verified)
                                            <span class="inline-flex items-center gap-1 text-[10px] text-green-750 font-bold mt-1 bg-green-50 px-2 py-0.5 rounded border border-green-100">
                                                <i class="ti ti-lock text-[10px]"></i> Manually Verified
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 max-w-xs text-xs text-gray-500 break-words leading-relaxed">
                                        {{ $user->id_verification_notes ?? '—' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        {{-- Only allow updating other accounts, not the active admin --}}
                                        @if($user->id !== Auth::id())
                                        <form method="POST" action="{{ route('admin.accounts.update_status', $user) }}" class="space-y-2" x-data="{ showStatusDropdown: false, activeStatus: '{{ $st }}' }">
                                            @csrf
                                            <input type="hidden" name="status" :value="activeStatus" />
                                            <div class="flex items-center gap-1.5 relative">
                                                <!-- Dropdown Trigger Button -->
                                                <button type="button" @click="showStatusDropdown = !showStatusDropdown" @click.away="showStatusDropdown = false" class="flex justify-between items-center w-28 rounded-xl border border-gray-250 shadow-sm bg-white px-3 py-1.5 text-xs text-gray-700 font-semibold hover:bg-gray-50 transition focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                    <span x-text="activeStatus.charAt(0).toUpperCase() + activeStatus.slice(1)"></span>
                                                    <svg class="h-3 w-3 text-gray-450 transform transition-transform duration-200 shrink-0 ml-1" :class="showStatusDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>

                                                <!-- Dropdown Menu (Fixed height + hover + smooth animation) -->
                                                <div x-show="showStatusDropdown" 
                                                     x-transition:enter="transition ease-out duration-150"
                                                     x-transition:enter-start="opacity-0 scale-95"
                                                     x-transition:enter-end="opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-100"
                                                     x-transition:leave-start="opacity-100 scale-100"
                                                     x-transition:leave-end="opacity-0 scale-95"
                                                     class="absolute left-0 bottom-full mb-1.5 z-30 w-32 rounded-xl bg-white border border-gray-200 shadow-xl py-1 max-h-36 overflow-y-auto"
                                                     style="display: none;">
                                                    <button type="button" @click="activeStatus = 'verified'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Verify
                                                    </button>
                                                    <button type="button" @click="activeStatus = 'pending'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Pending
                                                    </button>
                                                    <button type="button" @click="activeStatus = 'rejected'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Reject
                                                    </button>
                                                    <button type="button" @click="activeStatus = 'unverified'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Unverify
                                                    </button>
                                                </div>

                                                <button type="submit" class="px-3 py-1.5 bg-green-700 hover:bg-green-800 text-white rounded-xl text-xs font-semibold shadow-sm hover:shadow transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1">
                                                    <i class="ti ti-device-floppy text-sm"></i> Update
                                                </button>
                                            </div>
                                            <input type="text" name="notes" placeholder="Optional review notes…" class="w-full text-[11px] border border-gray-200 rounded-xl px-3 py-1.5 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-white placeholder-gray-400 transition" />
                                        </form>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs text-gray-400 italic bg-gray-50 border border-gray-150 rounded-xl">
                                            <i class="ti ti-user-x text-xs"></i> Self (Protected)
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>