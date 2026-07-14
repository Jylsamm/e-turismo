<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Identity &amp; Account Management
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Error Alerts --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Navigation Tabs --}}
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button onclick="switchTab('reviews')" id="tab-btn-reviews" class="tab-btn border-brand-700 text-brand-800 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        🔍 ID Verification Reviews
                    </button>
                    <button onclick="switchTab('accounts')" id="tab-btn-accounts" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        👥 Verify Account Status
                    </button>
                    <button onclick="switchTab('add-account')" id="tab-btn-add-account" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        ➕ Add Account (Tourist/Staff)
                    </button>
                </nav>
            </div>

            {{-- ── TAB 1: ID VERIFICATION REVIEWS ────────────────────────────────── --}}
            <div id="tab-reviews" class="tab-content space-y-10">
                {{-- PENDING TABLE --}}
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Pending Review</h3>
                            <p class="text-sm text-gray-500">Tourists requiring manual identity approval</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $pending->count() }} pending
                        </span>
                    </div>

                    @if($pending->isEmpty())
                    <p class="px-6 py-8 text-gray-400 text-sm text-center">No pending verifications.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
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
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-gray-800">{{ $tourist->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $tourist->email }}</p>
                                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded">{{ $tourist->classification }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-medium">{{ $tourist->id_type }}</p>
                                        <p class="text-xs text-gray-500 font-mono">{{ $tourist->id_number }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($tourist->ready_to_complete_requirements)
                                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-green-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Ready
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-2.5 py-1 rounded-full font-semibold border border-amber-200">
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
                                        <p class="text-xs text-gray-500 font-mono break-words">{{ $tourist->id_verification_notes ?? '—' }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($tourist->id_photo)
                                        <a href="{{ asset('storage/' . $tourist->id_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $tourist->id_photo) }}" alt="ID"
                                                class="h-16 w-24 object-cover rounded border hover:opacity-80 transition" />
                                        </a>
                                        @else
                                        <span class="text-xs text-gray-400">No photo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('verification.decide', $tourist) }}" class="space-y-2">
                                            @csrf
                                            <input type="hidden" name="decision" value="verified">
                                            <button type="submit" class="w-full px-3 py-1.5 bg-green-600 text-white rounded text-xs font-medium hover:bg-green-700 transition">
                                                ✓ Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('verification.decide', $tourist) }}" class="mt-1 space-y-2">
                                            @csrf
                                            <input type="hidden" name="decision" value="rejected">
                                            <input type="text" name="notes" placeholder="Rejection reason…"
                                                class="w-full text-xs border border-gray-300 rounded px-2 py-1" />
                                            <button type="submit" class="w-full px-3 py-1.5 bg-red-600 text-white rounded text-xs font-medium hover:bg-red-700 transition">
                                                ✗ Reject
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
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Recently Verified</h3>
                    </div>
                    @if($verified->isEmpty())
                    <p class="px-6 py-6 text-gray-400 text-sm text-center">No verified tourists yet.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">Tourist</th>
                                    <th class="px-4 py-3 text-left">ID Type</th>
                                    <th class="px-4 py-3 text-left">Score</th>
                                    <th class="px-4 py-3 text-left">Verified At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($verified as $tourist)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-gray-800">{{ $tourist->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $tourist->email }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $tourist->id_type ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-green-600 font-bold">{{ $tourist->id_verification_score ?? '—' }}%</span>
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

            {{-- ── TAB 2: VERIFY ACCOUNT STATUS (ALL USERS) ─────────────────────── --}}
            <div id="tab-accounts" class="tab-content space-y-6 hidden">
                <div class="bg-white shadow rounded-xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Account Listing &amp; Verification</h3>
                            <p class="text-sm text-gray-500">View and manually update status of all tourists and staff</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">Name / Email</th>
                                    <th class="px-4 py-3 text-left">Role</th>
                                    <th class="px-4 py-3 text-left">Identity Details</th>
                                    <th class="px-4 py-3 text-left">Verification Status</th>
                                    <th class="px-4 py-3 text-left">Verification Notes</th>
                                    <th class="px-4 py-3 text-left">Action / Update Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($allUsers as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-gray-800">{{ $user->name }} {{ $user->last_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                        @if($user->contact)
                                        <p class="text-xs text-gray-500">📞 {{ $user->contact }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 rounded text-xs font-semibold capitalize
                                            {{ $user->isAdmin() ? 'bg-red-50 text-red-700' : '' }}
                                            {{ $user->isStaff() ? 'bg-brand-50 text-brand-700' : '' }}
                                            {{ $user->isTourist() ? 'bg-teal-50 text-teal-700' : '' }}
                                        ">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-600">
                                        @if($user->isTourist())
                                            <p><strong>ID:</strong> {{ $user->id_type ?? 'None' }}</p>
                                            <p><strong>No:</strong> {{ $user->id_number ?? 'None' }}</p>
                                            <p><strong>DOB:</strong> {{ $user->dob ? $user->dob->format('M j, Y') : 'N/A' }} (Age: {{ $user->age }})</p>
                                        @elseif($user->isStaff() && $user->assignedDestination)
                                            <p class="text-brand-700 font-semibold">📍 {{ $user->assignedDestination->name }}</p>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $st = $user->id_verification_status;
                                            $c = 'gray';
                                            if ($st === 'verified') $c = 'green';
                                            elseif ($st === 'pending') $c = 'yellow';
                                            elseif ($st === 'rejected') $c = 'red';
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-{{ $c }}-100 text-{{ $c }}-800 uppercase">
                                            {{ $st }}
                                        </span>
                                        @if($user->is_manually_verified)
                                        <span class="block text-[10px] text-brand-700 font-semibold mt-1">🔒 Manually Verified</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 max-w-xs text-xs text-gray-500 break-words">
                                        {{ $user->id_verification_notes ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{-- Only allow updating other accounts, not the active admin --}}
                                        @if($user->id !== Auth::id())
                                        <form method="POST" action="{{ route('admin.accounts.update_status', $user) }}" class="space-y-1">
                                            @csrf
                                            <div class="flex gap-1.5">
                                                <select name="status" class="text-xs border border-gray-300 rounded px-2 py-1 bg-white focus:outline-none focus:ring-1 focus:ring-brand-500">
                                                    <option value="verified" {{ $st === 'verified' ? 'selected' : '' }}>Verify</option>
                                                    <option value="pending" {{ $st === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="rejected" {{ $st === 'rejected' ? 'selected' : '' }}>Reject</option>
                                                    <option value="unverified" {{ $st === 'unverified' ? 'selected' : '' }}>Unverify</option>
                                                </select>
                                                <button type="submit" class="px-2 py-1 bg-brand-700 text-white rounded text-xs font-medium hover:bg-brand-800 transition">
                                                    Update
                                                </button>
                                            </div>
                                            <input type="text" name="notes" placeholder="Optional review notes…" class="w-full text-[10px] border border-gray-300 rounded px-2 py-1" />
                                        </form>
                                        @else
                                        <span class="text-xs text-gray-400 italic">Self (Protected)</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── TAB 3: ADD TOURIST/STAFF ACCOUNT ────────────────────────────── --}}
            <div id="tab-add-account" class="tab-content space-y-6 hidden">
                <div class="bg-white shadow rounded-xl overflow-hidden max-w-3xl mx-auto">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Register New Tourist or Staff</h3>
                        <p class="text-sm text-gray-500 font-medium">Input fields will dynamically change based on the chosen role.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.accounts.store') }}" class="p-6 space-y-6">
                        @csrf

                        {{-- Role / Type --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Account Role</label>
                            <select id="reg-role" name="role" onchange="toggleFormRoleFields()" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required>
                                <option value="tourist" selected>Tourist</option>
                                <option value="staff">Staff (Tourist Spot Staff)</option>
                            </select>
                        </div>

                        {{-- Name Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Middle Initial</label>
                                <input type="text" name="middle_initial" placeholder="e.g. A" maxlength="2" value="{{ old('middle_initial') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                            </div>
                        </div>

                        {{-- Email & Contact --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Number (Optional)</label>
                                <input type="text" name="contact" placeholder="e.g. 09123456789" value="{{ old('contact') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                            </div>
                        </div>

                        {{-- Passwords --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                        </div>

                        {{-- ── TOURIST ONLY FIELDS ── --}}
                        <div id="tourist-fields" class="space-y-6 border-t pt-4">
                            <h4 class="font-bold text-sm text-brand-700">Tourist Identity details</h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Classification</label>
                                    <select name="classification" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">
                                        <option value="Local" selected>Local (Municipal Resident)</option>
                                        <option value="Domestic">Domestic (National Resident)</option>
                                        <option value="Foreign">Foreign (International Visitor)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">ID Type</label>
                                    <select name="id_type" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">
                                        <option value="National ID" selected>National ID (PhilSys)</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driver's License">Driver's License</option>
                                        <option value="Voter ID">Voter's ID</option>
                                        <option value="School ID">School / Student ID</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">ID Number / School Name</label>
                                    <input type="text" name="id_number" placeholder="e.g. 2022-041633" value="{{ old('id_number') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- ── STAFF ONLY FIELDS ── --}}
                        <div id="staff-fields" class="space-y-6 border-t pt-4 hidden">
                            <h4 class="font-bold text-sm text-brand-700">Staff Assignment details</h4>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Assigned Destination Spot</label>
                                <select name="assigned_destination_id" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">
                                    <option value="">None / Unassigned</option>
                                    @foreach($destinations as $dest)
                                        <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t">
                            <button type="submit" class="px-6 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Tabs switching scripts --}}
    <script>
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Remove active style from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-brand-700', 'text-brand-800');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Show active tab
            document.getElementById('tab-' + tabId).classList.remove('hidden');

            // Apply active button styles
            const activeBtn = document.getElementById('tab-btn-' + tabId);
            activeBtn.classList.add('border-brand-700', 'text-brand-800');
            activeBtn.classList.remove('border-transparent', 'text-gray-500');

            // Save tab state to localStorage so it stays on page reload/form submit
            localStorage.setItem('active_admin_tab', tabId);
        }

        function toggleFormRoleFields() {
            const role = document.getElementById('reg-role').value;
            const touristSection = document.getElementById('tourist-fields');
            const staffSection = document.getElementById('staff-fields');

            if (role === 'tourist') {
                touristSection.classList.remove('hidden');
                staffSection.classList.add('hidden');
            } else {
                touristSection.classList.add('hidden');
                staffSection.classList.remove('hidden');
            }
        }

        // Restore tab on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedTab = localStorage.getItem('active_admin_tab') || 'reviews';
            switchTab(savedTab);
            toggleFormRoleFields();
        });
    </script>
</x-app-layout>
