<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Staff Dashboard</h1>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg">{{ session('error') }}</div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow p-5 border-t-4 border-amber-400">
                <p class="text-xs text-gray-500 uppercase">Pending</p>
                <p class="text-4xl font-bold text-amber-600 mt-1">{{ $stats['pending_bookings'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5 border-t-4 border-green-400">
                <p class="text-xs text-gray-500 uppercase">Confirmed</p>
                <p class="text-4xl font-bold text-green-600 mt-1">{{ $stats['confirmed_bookings'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5 border-t-4 border-blue-400">
                <p class="text-xs text-gray-500 uppercase">Today's Check-ins</p>
                <p class="text-4xl font-bold text-blue-600 mt-1">{{ $stats['today_checkins'] }}</p>
            </div>
        </div>

        {{-- Quick Check-In --}}
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-indigo-800 mb-4">🔍 QR Check-In Scanner</h2>
            <form action="{{ route('checkins.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" name="qr_code" placeholder="Scan or type QR code…"
                    class="flex-1 border border-indigo-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none"
                    autofocus>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-6 py-2 text-sm font-medium transition">
                    Verify & Check In
                </button>
            </form>
            <a href="{{ route('checkins.create') }}" class="text-xs text-indigo-600 mt-2 inline-block hover:underline">Open full scan page →</a>
        </div>

        {{-- Pending Bookings --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-gray-700">Pending Booking Requests</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Tourist</th>
                            <th class="px-4 py-3 text-left">Visit Date</th>
                            <th class="px-4 py-3 text-left">Submitted</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingBookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ $booking->tourist?->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->tourist?->classification }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $booking->visit_date }}</td>
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ $booking->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <form action="{{ route('bookings.confirm', $booking) }}" method="POST">
                                        @csrf
                                        <button class="bg-green-500 hover:bg-green-600 text-white text-xs rounded px-3 py-1.5 transition">✓ Confirm</button>
                                    </form>
                                    <button onclick="document.getElementById('decline-{{ $booking->id }}').classList.toggle('hidden')"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs rounded px-3 py-1.5 transition">✕ Decline</button>
                                </div>
                                {{-- Decline reason form --}}
                                <div id="decline-{{ $booking->id }}" class="hidden mt-2">
                                    <form action="{{ route('bookings.decline', $booking) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="text" name="decline_reason" placeholder="Reason…"
                                            class="flex-1 border rounded px-2 py-1 text-xs" required>
                                        <button type="submit" class="bg-red-600 text-white text-xs rounded px-3 py-1">Send</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">No pending bookings. 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Notifications --}}
        @if($notifications->count())
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
            <h2 class="font-semibold text-amber-800 mb-3">🔔 Alerts</h2>
            <ul class="space-y-1">
                @foreach($notifications as $notif)
                <li class="text-sm text-amber-900">{{ $notif->message }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</x-app-layout>
