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
        <h1 class="text-2xl font-bold text-gray-800">📊 Reports Dashboard</h1>
    </x-slot>

    <div class="pb-8 pt-0 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        {{-- Filter Form --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow p-6 admin-card-hover">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Filter & Preview</h2>
            <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Destination</label>
                    <select name="destination_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
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
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Date To</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-brand-700 hover:bg-brand-800 text-white rounded-lg py-2.5 text-sm font-medium transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @php
            $cards = [
                ['label'=>'Total Bookings','value'=>$stats['total_bookings'],'color'=>'brand'],
                ['label'=>'Confirmed','value'=>$stats['confirmed'],'color'=>'green'],
                ['label'=>'Declined','value'=>$stats['declined'],'color'=>'red'],
                ['label'=>'Pending','value'=>$stats['pending'],'color'=>'amber'],
                ['label'=>'Actual Visitors','value'=>$stats['total_visitors'],'color'=>'blue'],
            ];
            @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow p-5 border-l-4 border-{{ $card['color'] }}-500 border-t border-r border-b border-gray-200 admin-card-hover">
                <p class="text-xs text-gray-500 uppercase font-medium">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-{{ $card['color'] }}-600 mt-1">{{ $card['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Generate Report + Export --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow p-6 flex flex-col sm:flex-row gap-4 items-end admin-card-hover">
            <form action="{{ route('reports.generate') }}" method="POST" class="grid grid-cols-4 gap-4 flex-1">
                @csrf
                <input type="hidden" name="destination_id" value="{{ $filters['destination_id'] }}">
                <input type="hidden" name="date_from" value="{{ $filters['date_from'] }}">
                <input type="hidden" name="date_to" value="{{ $filters['date_to'] }}">
                <div class="col-span-2">
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Report Type</label>
                    <select name="type" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
                        <option value="monthly">Monthly</option>
                        <option value="weekly">Weekly</option>
                        <option value="daily">Daily</option>
                    </select>
                </div>
                <div class="col-span-2 flex items-end">
                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg py-2.5 text-sm font-medium transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                        📄 Save Report
                    </button>
                </div>
            </form>

            <div>
                <a href="{{ route('reports.export-docx') }}?date_from={{ $filters['date_from'] }}&date_to={{ $filters['date_to'] }}&destination_id={{ $filters['destination_id'] }}"
                    class="inline-flex items-center gap-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl px-5 py-3 text-sm font-semibold shadow-sm transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                    <i class="ti ti-file-text text-base"></i> Export DOCX
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
