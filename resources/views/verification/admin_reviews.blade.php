<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                ID Verification Reviews
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

            <div class="space-y-10">
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
                                        <a href="{{ Storage::url($tourist->id_photo) }}" target="_blank">
                                            <img src="{{ Storage::url($tourist->id_photo) }}" alt="ID"
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
        </div>
    </div>
</x-app-layout>