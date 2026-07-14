<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
            $cards = [
                ['label' => 'Total Tourists', 'value' => $stats['total_tourists'], 'color' => 'brand'],
                ['label' => 'Destinations', 'value' => $stats['total_destinations'], 'color' => 'emerald'],
                ['label' => 'Pending Bookings', 'value' => $stats['pending_bookings'], 'color' => 'amber'],
                ['label' => 'Confirmed', 'value' => $stats['confirmed_bookings'], 'color' => 'green'],
                ['label' => 'Total Check-ins', 'value' => $stats['total_checkins'], 'color' => 'blue'],
                ['label' => "Today's Visitors", 'value' => $stats['today_visitors'], 'color' => 'rose'],
            ];
            @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow p-5 border-t-4 border-{{ $card['color'] }}-500">
                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $card['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Recent Bookings --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h2 class="font-semibold text-gray-700">Recent Bookings</h2>
                    <a href="{{ route('bookings.index') }}" class="text-sm text-brand-700 hover:underline">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left">Tourist</th>
                                <th class="px-4 py-3 text-left">Destination</th>
                                <th class="px-4 py-3 text-left">Visit Date</th>
                                <th class="px-4 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $booking->tourist?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $booking->destination?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $booking->visit_date }}</td>
                                <td class="px-4 py-3">
                                    @php
                                    $colors = ['pending'=>'yellow','confirmed'=>'green','declined'=>'red','completed'=>'blue'];
                                    $c = $colors[$booking->status] ?? 'gray';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700 capitalize">{{ $booking->status }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">No bookings yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Destinations & Quick Actions --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow p-5">
                    <h2 class="font-semibold text-gray-700 mb-3">Top Destinations</h2>
                    <ul class="space-y-2">
                        @forelse($topDestinations as $dest)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-gray-700 font-medium">{{ $dest->name }}</span>
                            <span class="text-brand-700 font-bold">{{ $dest->bookings_count }} bookings</span>
                        </li>
                        @empty
                        <li class="text-gray-400 text-sm">No data yet.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <h2 class="font-semibold text-gray-700 mb-3">Quick Actions</h2>
                    <div class="space-y-2">
                        <a href="{{ route('destinations.create') }}" class="block w-full text-center bg-brand-700 hover:bg-brand-800 text-white rounded-lg py-2 text-sm font-medium transition shadow-sm">+ Add Destination</a>
                        <a href="{{ route('reports.index') }}" class="block w-full text-center bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg py-2 text-sm font-medium transition shadow-sm">📊 Generate Report</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Unread Notifications --}}
        @if($notifications->count())
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
            <h2 class="font-semibold text-amber-800 mb-3">🔔 Unread Notifications</h2>
            <ul class="space-y-2">
                @foreach($notifications as $notif)
                <li class="text-sm text-amber-900">{{ $notif->message }}</li>
                @endforeach
            </ul>
            <form action="{{ route('notifications.read-all') }}" method="POST" class="mt-3">
                @csrf
                <button class="text-xs text-amber-700 underline">Mark all as read</button>
            </form>
        </div>
        @endif
    </div>
</x-app-layout>
