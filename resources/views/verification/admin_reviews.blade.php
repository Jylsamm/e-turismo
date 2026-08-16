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
                <i class="ti ti-checklist text-2xl text-emerald-700"></i>
                <span>ID Verification Reviews</span>
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0">
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
                <div
                    class="bg-green-50 border border-green-300 text-green-700 rounded-2xl px-4 py-3 text-sm shadow-sm flex items-center gap-2">
                    <i class="ti ti-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="space-y-10">
                {{-- PENDING TABLE --}}
                <div class="bg-white border border-gray-200 shadow rounded-xl overflow-hidden admin-card-hover" x-data="{ searchQuery: '' }">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Pending Review</h3>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $pending->count() }} pending
                        </span>
                    </div>

                    <!-- Search Bar -->
                    <div class="px-5 py-3 border-b border-gray-100 bg-gradient-to-r from-gray-50/60 to-white">
                        <div class="relative w-full sm:max-w-sm group">
                            <span
                                class="absolute inset-y-0 flex items-center pointer-events-none text-gray-400 group-focus-within:text-green-600 transition-colors duration-200"
                                style="left: 14px;">
                                <i class="ti ti-search text-base"></i>
                            </span>
                            <input type="text" id="admin-reviews-pending-search" name="search_query" x-model="searchQuery" placeholder="Search by name or email…"
                                style="padding-left: 2.75rem;"
                                class="w-full pr-8 py-2.5 border border-gray-200 rounded-xl text-sm shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 bg-white placeholder-gray-400 transition-all duration-200 hover:border-gray-300" />
                            <button type="button" x-show="searchQuery.length > 0" x-transition @click="searchQuery = ''"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-400 transition-colors duration-150">
                                <i class="ti ti-x text-sm"></i>
                            </button>
                        </div>
                    </div>

                    @if($pending->isEmpty())
                        <div class="px-6 py-12 flex flex-col items-center justify-center text-gray-300">
                            <i class="ti ti-circle-check text-5xl"></i>
                        </div>
                    @else
                        <div class="max-h-[420px] overflow-y-auto overflow-x-auto relative">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase sticky top-0 z-10 shadow-sm">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Tourist</th>
                                        <th class="px-4 py-3 text-left">ID Type / Number</th>
                                        <th class="px-4 py-3 text-left">Requirements</th>
                                        <th class="px-4 py-3 text-left">Score</th>
                                        <th class="px-4 py-3 text-left">Engine Notes</th>
                                        <th class="px-4 py-3 text-left">ID Photo</th>
                                        <th class="px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($pending as $tourist)
                                        <tr class="hover:bg-gray-50"
                                            x-show="searchQuery === '' || '{{ strtolower($tourist->name . ' ' . $tourist->email) }}'.includes(searchQuery.toLowerCase())">
                                            <td class="px-4 py-3">
                                                <p class="font-medium text-gray-800">{{ $tourist->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $tourist->email }}</p>
                                                <span
                                                    class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded">{{ $tourist->classification }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <p class="font-medium">{{ $tourist->id_type }}</p>
                                                <p class="text-xs text-gray-500 font-mono">{{ $tourist->id_number }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($tourist->ready_to_complete_requirements)
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-green-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                        Ready
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-amber-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                        Incomplete
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @php $s = $tourist->id_verification_score; @endphp
                                                <span class="font-bold {{ $s >= 60 ? 'text-yellow-600' : 'text-red-500' }}">
                                                    {{ $s !== null ? $s . '%' : '—' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 max-w-xs">
                                                <p class="text-xs text-gray-500 font-mono break-words">
                                                    {{ $tourist->id_verification_notes ?? '—' }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($tourist->id_photo)
                                                    <a href="{{ Storage::url($tourist->id_photo) }}" target="_blank">
                                                        <img src="{{ Storage::url($tourist->id_photo) }}" alt="ID"
                                                            class="h-16 w-24 object-cover rounded border hover:opacity-80 transition" />
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-400">No photo</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <form method="POST" action="{{ route('verification.decide', $tourist) }}"
                                                    class="space-y-2">
                                                    @csrf
                                                    <input type="hidden" name="decision" value="verified">
                                                    <button type="submit"
                                                        class="w-full px-3 py-1.5 bg-green-600 text-white rounded text-xs font-medium hover:bg-green-700 transition">
                                                        ✓ Approve
                                                    </button>
                                                </form>
                                                 <form method="POST" action="{{ route('verification.decide', $tourist) }}"
                                                     class="mt-1 space-y-2">
                                                     @csrf
                                                     <input type="hidden" name="decision" value="pending">
                                                     <input type="text" name="notes" placeholder="Optional review notes…"
                                                         class="w-full text-xs border border-gray-300 rounded px-2 py-1" />
                                                     <button type="submit"
                                                         class="w-full px-3 py-1.5 bg-amber-600 text-white rounded text-xs font-medium hover:bg-amber-700 transition">
                                                         Keep Pending
                                                     </button>
                                                 </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- RECENTLY VERIFIED --}}
                <div class="bg-white border border-gray-200 shadow rounded-xl overflow-hidden admin-card-hover"
                    x-data="{ searchQuery: '', statusFilter: 'all' }">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Recently Verified</h3>
                    </div>

                    <!-- Search Bar -->
                    <div
                        class="px-5 py-3 border-b border-gray-100 bg-gradient-to-r from-gray-50/60 to-white flex flex-col sm:flex-row gap-3 items-center justify-between">
                        <div class="relative w-full sm:max-w-sm group">
                            <span
                                class="absolute inset-y-0 flex items-center pointer-events-none text-gray-400 group-focus-within:text-green-600 transition-colors duration-200"
                                style="left: 14px;">
                                <i class="ti ti-search text-base"></i>
                            </span>
                            <input type="text" id="admin-reviews-history-search" name="search_query_history" x-model="searchQuery" placeholder="Search by name or email…"
                                style="padding-left: 2.75rem;"
                                class="w-full pr-8 py-2.5 border border-gray-200 rounded-xl text-sm shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 bg-white placeholder-gray-400 transition-all duration-200 hover:border-gray-300" />
                            <button type="button" x-show="searchQuery.length > 0" x-transition @click="searchQuery = ''"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-400 transition-colors duration-150">
                                <i class="ti ti-x text-sm"></i>
                            </button>
                        </div>
                    </div>

                    @if($verified->isEmpty())
                        <div class="px-6 py-12 flex flex-col items-center justify-center text-gray-300">
                            <i class="ti ti-discount-check text-5xl"></i>
                        </div>
                    @else
                        <div class="max-h-[420px] overflow-y-auto overflow-x-auto relative">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase sticky top-0 z-10 shadow-sm">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Tourist</th>
                                        <th class="px-4 py-3 text-left">ID Type</th>
                                        <th class="px-4 py-3 text-left">Score</th>
                                        <th class="px-4 py-3 text-left">Verified At</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($verified as $tourist)
                                        <tr class="hover:bg-gray-50"
                                            x-show="searchQuery === '' || '{{ strtolower($tourist->name . ' ' . $tourist->email) }}'.includes(searchQuery.toLowerCase())">
                                            <td class="px-4 py-3">
                                                <p class="font-medium text-gray-800">{{ $tourist->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $tourist->email }}</p>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">{{ $tourist->id_type ?? '—' }}</td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="text-green-600 font-bold">{{ $tourist->id_verification_score ?? '—' }}%</span>
                                            </td>
                                            <td class="px-4 py-3 text-xs text-gray-400">
                                                {{ $tourist->id_verified_at?->format('M j, Y g:i A') ?? '—' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>