<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Verify Account Status
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0">
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

            <div class="space-y-6">
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
        </div>
    </div>
</x-app-layout>