<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">📊 Reports Dashboard</h1>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        {{-- Filter Form --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Filter & Preview</h2>
            <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Destination</label>
                    <select name="destination_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                        <option value="">All Destinations</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ $filters['destination_id'] == $dest->id ? 'selected' : '' }}>
                                {{ $dest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Date From</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Date To</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-2 text-sm font-medium transition">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @php
            $cards = [
                ['label'=>'Total Bookings','value'=>$stats['total_bookings'],'color'=>'indigo'],
                ['label'=>'Confirmed','value'=>$stats['confirmed'],'color'=>'green'],
                ['label'=>'Declined','value'=>$stats['declined'],'color'=>'red'],
                ['label'=>'Pending','value'=>$stats['pending'],'color'=>'amber'],
                ['label'=>'Actual Visitors','value'=>$stats['total_visitors'],'color'=>'blue'],
            ];
            @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow p-5 border-l-4 border-{{ $card['color'] }}-500">
                <p class="text-xs text-gray-500 uppercase">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-{{ $card['color'] }}-600 mt-1">{{ $card['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Generate Report + Export --}}
        <div class="bg-white rounded-2xl shadow p-6 flex flex-col sm:flex-row gap-4 items-end">
            <form action="{{ route('reports.generate') }}" method="POST" class="grid grid-cols-4 gap-4 flex-1">
                @csrf
                <input type="hidden" name="destination_id" value="{{ $filters['destination_id'] }}">
                <input type="hidden" name="date_from" value="{{ $filters['date_from'] }}">
                <input type="hidden" name="date_to" value="{{ $filters['date_to'] }}">
                <div class="col-span-2">
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Report Type</label>
                    <select name="type" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                        <option value="monthly">Monthly</option>
                        <option value="weekly">Weekly</option>
                        <option value="daily">Daily</option>
                    </select>
                </div>
                <div class="col-span-2 flex items-end">
                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg py-2 text-sm font-medium transition">
                        📄 Save Report
                    </button>
                </div>
            </form>

            <div>
                <a href="{{ route('reports.export') }}?date_from={{ $filters['date_from'] }}&date_to={{ $filters['date_to'] }}&destination_id={{ $filters['destination_id'] }}"
                    class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-900 text-white rounded-lg px-5 py-2 text-sm font-medium transition">
                    ⬇️ Export CSV
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
