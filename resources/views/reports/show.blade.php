<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600">← Reports</a>
            <h1 class="text-2xl font-bold text-gray-800">Report #{{ $report->id }}</h1>
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Report Meta --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-sm text-gray-500">
                        <span class="uppercase font-semibold text-gray-700">{{ $report->type }}</span> Report
                        · Generated {{ $report->created_at->format('M d, Y h:i A') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Period: <strong>{{ $report->date_from }}</strong> → <strong>{{ $report->date_to }}</strong>
                        @if($report->destination)
                        · Destination: <strong>{{ $report->destination->name }}</strong>
                        @else
                        · All Destinations
                        @endif
                    </p>
                </div>
                <a href="{{ route('reports.export') }}?date_from={{ $report->date_from }}&date_to={{ $report->date_to }}&destination_id={{ $report->destination_id }}"
                    class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-900 text-white rounded-lg px-4 py-2 text-sm transition">
                    ⬇️ Export CSV
                </a>
            </div>
        </div>

        {{-- Summary Stats --}}
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
            <div class="bg-white rounded-xl shadow p-5 border-l-4 border-{{ $card['color'] }}-500 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $card['label'] }}</p>
                <p class="text-4xl font-bold text-{{ $card['color'] }}-600 mt-1">{{ $card['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Top Destinations --}}
        @if($topDestinations->count())
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Top Destinations by Confirmed Bookings</h2>
            <div class="space-y-3">
                @php $max = $topDestinations->first()?->total ?? 1; @endphp
                @foreach($topDestinations as $i => $dest)
                <div>
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">{{ $i + 1 }}. {{ $dest->name }}</span>
                        <span class="text-indigo-600 font-bold">{{ $dest->total }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($dest->total / $max) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- DOT Compliance Notice --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-sm text-blue-800">
            <p class="font-semibold">🏛️ DOT Report Compliance</p>
            <p class="mt-1">This report summarizes tourist activity in accordance with the Department of Tourism monitoring requirements. Data reflects confirmed bookings and actual check-in arrivals within the selected period.</p>
        </div>
    </div>
</x-app-layout>
