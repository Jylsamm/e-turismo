<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('reports.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Saved Report #{{ $report->id }}</h1>
                    <p class="text-xs text-slate-500">Archived record from {{ $report->created_at->format('M d, Y • h:i A') }}</p>
                </div>
            </div>
            <a href="{{ route('reports.export-visitor-record', ['date_from' => $report->date_from, 'date_to' => $report->date_to, 'destination_id' => $report->destination_id]) }}"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 text-xs font-bold shadow-sm transition">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export DOCX
            </a>
        </div>
    </x-slot>

    <div class="pb-12 pt-4 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Report Scope Banner --}}
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2 border border-emerald-200">
                    {{ $report->type ?? 'Monthly' }} Report
                </span>
                <h2 class="text-lg font-bold text-slate-900">
                    {{ $report->destination ? $report->destination->name : 'All Municipal Destinations' }}
                </h2>
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-2">
                    <span>Period: <strong>{{ \Carbon\Carbon::parse($report->date_from)->format('M d, Y') }}</strong> &ndash; <strong>{{ \Carbon\Carbon::parse($report->date_to)->format('M d, Y') }}</strong></span>
                </p>
            </div>
        </div>

        {{-- Summary KPI Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-bold uppercase text-slate-400">Total Bookings</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ number_format($stats['total_bookings']) }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-900 to-emerald-950 text-white rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-bold uppercase text-emerald-300">Actual Visitors</p>
                <p class="text-3xl font-black text-white mt-1">{{ number_format($stats['total_visitors']) }}</p>
            </div>
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-bold uppercase text-emerald-600">Confirmed</p>
                <p class="text-3xl font-black text-emerald-700 mt-1">{{ number_format($stats['confirmed']) }}</p>
            </div>
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm">
                <p class="text-xs font-bold uppercase text-amber-600">Walk-ins</p>
                <p class="text-3xl font-black text-amber-700 mt-1">{{ number_format($stats['walkin_visitors']) }}</p>
            </div>
        </div>

        {{-- Top Destinations --}}
        @if($topDestinations->isNotEmpty())
        <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4">Top Destinations in Period</h3>
            <div class="space-y-3">
                @php $max = $topDestinations->first()?->total ?: 1; @endphp
                @foreach($topDestinations as $i => $dest)
                <div>
                    <div class="flex items-center justify-between text-xs font-semibold mb-1">
                        <span class="text-slate-800">{{ $i + 1 }}. {{ $dest->name }}</span>
                        <span class="text-emerald-700 font-bold">{{ $dest->total }} bookings</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ ($dest->total / $max) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- DOT Compliance Notice --}}
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-xs text-slate-600 space-y-1">
            <p class="font-bold text-slate-800 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Department of Tourism Reporting Standard
            </p>
            <p>This report compiles visitor footfall, residence classifications, and booking statistics in compliance with local government and DOT tourism monitoring regulations.</p>
        </div>
    </div>
</x-app-layout>
