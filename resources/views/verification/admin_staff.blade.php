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
<<<<<<< Updated upstream
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="ti ti-user-cog text-2xl text-green-700"></i>
                Manage Staff Accounts
=======
            <h2 class="font-display font-normal text-2xl sm:text-3xl text-slate-900 tracking-wide flex items-center gap-3">
                <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <span>Manage Staff</span>
>>>>>>> Stashed changes
            </h2>
        </div>
    </x-slot>

<<<<<<< Updated upstream
    <div class="pb-12 pt-0 animate-fade-in-up" x-data="{
=======
    <div class="pb-12 pt-4" x-data="{
>>>>>>> Stashed changes
        deleteUrl: '',
        editOpen: {{ session('edit_user_id') && $errors->any() ? 'true' : 'false' }},
        editUrl: '{{ session('edit_user_id') ? route('verification.staff.update', session('edit_user_id')) : '' }}',
        editName: '{{ old('name', '') }}',
        editLastName: '{{ old('last_name', '') }}',
        editEmail: '{{ old('email', '') }}',
        editContact: '{{ old('contact', '') }}',
        openEditModal(user) {
            this.editUrl = '{{ url('/admin/verifications/staff') }}/' + user.id;
            this.editName = user.name;
            this.editLastName = user.last_name || '';
            this.editEmail = user.email;
            this.editContact = user.contact || '';
            
            // Explicitly set the form action to avoid Alpine teleport binding issues
            setTimeout(() => {
                const form = document.getElementById('editStaffForm');
                if (form) form.action = this.editUrl;
            }, 50);

            this.editOpen = true;
        }
    }">
        <div class="max-w-full 2xl:max-w-[1700px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Sub-Navigation Tabs -->
<<<<<<< Updated upstream
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
                <a href="{{ route('verification.reviews') }}" aria-label="ID Verification Reviews"
                    class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.reviews') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-checklist md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">ID Verification Reviews</span>
                </a>
                <a href="{{ route('verification.accounts') }}" aria-label="Verify Tourists"
                    class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.accounts') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-users md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">Verify Tourists</span>
                </a>
                <a href="{{ route('verification.staff') }}" aria-label="Manage Staff"
                    class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.staff') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-user-cog md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">Manage Staff</span>
                </a>
                <a href="{{ route('verification.add_account') }}" aria-label="Add Account"
                    class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.add_account') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-user-plus md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">Add Account</span>
=======
            <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-2 -mb-2 border-b border-slate-200 no-scrollbar whitespace-nowrap">
                <a href="{{ route('verification.reviews') }}" aria-label="Verify Tourists"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.reviews') || request()->routeIs('verification.accounts') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span>Verify Tourists</span>
                </a>
                <a href="{{ route('verification.staff') }}" aria-label="Manage Staff"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.staff') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Manage Staff</span>
                </a>
                <a href="{{ route('verification.add_account') }}" aria-label="Add Account"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.add_account') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Add Account</span>
>>>>>>> Stashed changes
                </a>
            </div>

            {{-- Error Alerts --}}
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-300 text-rose-800 rounded-2xl px-4 py-3 text-sm shadow-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="space-y-6" x-data="{ searchQuery: '' }">
                <div class="seamless-table-card">
                    <!-- Seamless Ledger Header -->
                    <div class="seamless-table-header">
                        <div class="seamless-table-title-group">
                            <div class="seamless-table-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="seamless-table-title">Staff Accounts & Station Directory</div>
                                <div class="seamless-table-subtitle">{{ $staffUsers->count() }} active staff members</div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative w-full sm:w-64 group">
                            <span class="absolute inset-y-0 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors duration-200" style="left: 12px;">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" id="admin-staff-search" name="search_staff" x-model="searchQuery" placeholder="Search staff name or email…"
                                style="padding-left: 2.5rem;"
                                class="w-full pr-8 py-1.5 border border-stone-300 rounded-xl text-xs sm:text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 bg-white placeholder-slate-400 transition-all duration-200" />
                            <button type="button" x-show="searchQuery.length > 0" x-transition @click="searchQuery = ''"
                                class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-rose-500 transition-colors duration-150 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto relative">
                        <table class="seamless-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Staff Name / Email</th>
                                    <th class="text-left">Contact Number</th>
                                    <th class="text-left">Assigned Destination Spot</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffUsers as $user)
                                    <tr class="border-b border-slate-200 hover:bg-slate-50/80 transition-colors duration-150"
                                        x-show="searchQuery === '' || '{{ strtolower(addslashes($user->name . ' ' . $user->last_name . ' ' . $user->email)) }}'.includes(searchQuery.toLowerCase())">
                                        <td class="px-5 py-4 align-top">
                                            <p class="font-bold text-slate-800 text-sm leading-snug">{{ $user->name }} {{ $user->last_name }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $user->email }}</span>
                                            </p>
                                        </td>
                                        <td class="px-5 py-4 align-top text-xs text-slate-600">
                                            @if($user->contact)
                                                <p class="inline-flex items-center gap-1.5 font-medium">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                    <span>{{ $user->contact }}</span>
                                                </p>
                                            @else
                                                <span class="text-slate-400 italic">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 align-top">
                                            @if($user->assignedDestination)
                                                <span class="inline-flex items-center gap-1.5 text-xs text-emerald-800 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span>{{ $user->assignedDestination->name }}</span>
                                                </span>
                                            @else
                                                <span class="text-slate-400 italic text-xs">No Spot Assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 align-top">
                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                    @click="openEditModal({{ json_encode($user->only(['id', 'name', 'last_name', 'email', 'contact'])) }})"
                                                    class="text-emerald-700 hover:text-emerald-900 p-1.5 rounded-xl hover:bg-emerald-50 border border-slate-200 shadow-2xs transition-all duration-150 flex items-center justify-center cursor-pointer"
                                                    title="Edit staff details">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                @if($user->id !== auth()->id())
                                                    <button type="button"
                                                        @click="deleteUrl = '{{ route('verification.staff.delete', $user) }}'; $dispatch('open-confirm-modal', { id: 'delete-staff-modal' })"
                                                        class="text-rose-600 hover:text-rose-800 p-1.5 rounded-xl hover:bg-rose-50 border border-slate-200 shadow-2xs transition-all duration-150 flex items-center justify-center cursor-pointer"
                                                        title="Delete staff account">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                @else
                                                    <span class="text-xs text-slate-400 italic bg-slate-50 px-2 py-0.5 rounded border border-slate-200">Self (Protected)</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-slate-400 italic">
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

        {{-- Edit Staff Modal --}}
        <template x-teleport="body">
            <div x-show="editOpen"
                 class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto"
                 style="display: none;"
                 role="dialog"
                 aria-modal="true"
                 x-cloak>
                
            {{-- Backdrop overlay with blur --}}
            <div x-show="editOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="editOpen = false"
                 class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

            {{-- Dialog box --}}
            <div x-show="editOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @keydown.escape.window="editOpen = false"
                 class="bg-white border border-gray-250 rounded-2xl max-w-md w-full shadow-2xl relative z-10 transition-all flex flex-col max-h-[90vh]">
                
                {{-- Header --}}
                <div class="flex items-center justify-between p-5 border-b shrink-0">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-1.5">
                        <i class="ti ti-edit text-brand-600 text-lg"></i> Edit Staff Account
                    </h3>
                    <button type="button" @click="editOpen = false" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                {{-- Scrollable Form Content --}}
                <form id="editStaffForm" method="POST" :action="editUrl" class="flex flex-col flex-grow overflow-hidden">
                    @csrf
                    @method('PATCH')

                    <div class="p-5 space-y-4 overflow-y-auto flex-grow">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">First Name</label>
                                <input type="text" name="name" x-model="editName" required class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Last Name</label>
                                <input type="text" name="last_name" x-model="editLastName" required class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Email Address</label>
                            <input type="email" name="email" x-model="editEmail" required class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Contact Number</label>
                            <input type="text" name="contact" x-model="editContact" required class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                        </div>

                        <div class="border-t pt-3">
                            <p class="text-xs text-gray-400 mb-2">Leave blank to keep the current password.</p>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">New Password</label>
                                    <input type="password" name="password" autocomplete="new-password" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="flex justify-end gap-2 p-5 border-t shrink-0 bg-gray-50 rounded-b-2xl">
                        <button type="button" @click="editOpen = false" class="px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-xs rounded-lg transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white font-semibold text-xs rounded-lg shadow-sm hover:shadow transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </template>

        {{-- Delete Staff Confirmation Modal --}}
        <x-confirm-modal id="delete-staff-modal" title="Delete Staff Account"
            message="Are you sure you want to delete this staff account? This will permanently remove their access credentials.">
            <form method="POST" :action="deleteUrl">
                @csrf
                @method('DELETE')
                <button type="submit" @click.stop
                    class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        </x-confirm-modal>
    </div>
</x-app-layout>