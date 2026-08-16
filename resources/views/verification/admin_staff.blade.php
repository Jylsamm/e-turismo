<x-app-layout>
    @push('head')
        <style>
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
                <i class="ti ti-user-cog text-2xl text-emerald-700"></i>
                <span>Manage Staff</span>
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0" x-data="{
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Sub-Navigation Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
                <a href="{{ route('verification.reviews') }}" aria-label="ID Verification Reviews"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.reviews') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-checklist text-base shrink-0 mr-1.5"></i>
                    <span>ID Verification Reviews</span>
                </a>
                <a href="{{ route('verification.accounts') }}" aria-label="Verify Tourists"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.accounts') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-users text-base shrink-0 mr-1.5"></i>
                    <span>Verify Tourists</span>
                </a>
                <a href="{{ route('verification.staff') }}" aria-label="Manage Staff"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.staff') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-user-cog text-base shrink-0 mr-1.5"></i>
                    <span>Manage Staff</span>
                </a>
                <a href="{{ route('verification.add_account') }}" aria-label="Add Account"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.add_account') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-user-plus text-base shrink-0 mr-1.5"></i>
                    <span>Add Account</span>
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
                                            @if($user->assignedDestination)
                                                <span class="text-xs text-gray-700 font-semibold">{{ $user->assignedDestination->name }}</span>
                                            @else
                                                <span class="text-gray-400 italic text-xs">No Spot Assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                    @click="openEditModal({{ json_encode($user->only(['id', 'name', 'last_name', 'email', 'contact'])) }})"
                                                    class="text-blue-600 hover:text-blue-800 p-1.5 rounded-xl hover:bg-blue-50 transition-all duration-150 flex items-center justify-center"
                                                    title="Edit staff details">
                                                    <i class="ti ti-edit text-lg"></i>
                                                </button>
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
                                            </div>
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