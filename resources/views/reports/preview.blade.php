{{--
    resources/views/reports/preview.blade.php
    Rendered by ReportController::generateVisitorRecord()
    Injected into the modal on the Reports index page.
    Variables available: $data, $monthYearLabel, $cityLabel, $attractionName, $attractionType, $daysInMonth, $summary
--}}
<div id="visitor-record-preview" class="w-full text-slate-800 antialiased select-text">

    {{-- ── Form Header ─────────────────────────────────────────────── --}}
    <div class="text-center mb-5 pb-3 border-b border-slate-200 print:border-black print:pb-2 print:mb-3">
        <p class="text-[11px] font-medium tracking-wide uppercase text-slate-500 italic print:text-black">
            (This recording form can be used instead of just counting the visitors)
        </p>
        <h2 class="text-lg sm:text-xl font-extrabold uppercase tracking-wider text-slate-900 mt-1 print:text-base print:mt-0">
            Tourism Attraction Visitor Record
        </h2>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 mt-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200 print:hidden">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            DOT Standard Annex Form • {{ $monthYearLabel }}
        </div>
    </div>

    {{-- ── Meta Details Table ────────────────────────────────────────── --}}
    <div class="mb-4 overflow-hidden rounded-xl border border-slate-300 print:border-black print:rounded-none print:mb-2 bg-slate-50/50 print:bg-transparent">
        <table class="w-full border-collapse text-xs print:text-[9pt]">
            <tbody>
                <tr class="border-b border-slate-200 print:border-black">
                    <td class="px-3 py-2 font-bold text-slate-700 print:text-black w-48 sm:w-56 bg-slate-100 print:bg-transparent border-r border-slate-200 print:border-black">
                        Month / Year
                    </td>
                    <td class="px-3 py-2 font-medium text-slate-900 print:text-black">
                        {{ $monthYearLabel }}
                    </td>
                </tr>
                <tr class="border-b border-slate-200 print:border-black">
                    <td class="px-3 py-2 font-bold text-slate-700 print:text-black bg-slate-100 print:bg-transparent border-r border-slate-200 print:border-black">
                        Name of City / Municipality
                    </td>
                    <td class="px-3 py-2 font-medium text-slate-900 print:text-black">
                        {{ $cityLabel }}
                    </td>
                </tr>
                <tr class="border-b border-slate-200 print:border-black">
                    <td class="px-3 py-2 font-bold text-slate-700 print:text-black bg-slate-100 print:bg-transparent border-r border-slate-200 print:border-black">
                        Name of Attraction / Spot
                    </td>
                    <td class="px-3 py-2 font-semibold text-emerald-800 print:text-black">
                        {{ $attractionName }}
                    </td>
                </tr>
                <tr>
                    <td class="px-3 py-2 font-bold text-slate-700 print:text-black bg-slate-100 print:bg-transparent border-r border-slate-200 print:border-black">
                        Type of Tourism Attraction
                    </td>
                    <td class="px-3 py-2 text-slate-600 print:text-black">
                        {{ $attractionType ?? 'Ecotourism & Heritage Attractions' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ── Daily Visitor Table ──────────────────────────────────────── --}}
    <div class="overflow-x-auto rounded-xl border border-slate-300 shadow-sm print:shadow-none print:rounded-none print:border-black bg-white">
        <table class="w-full border-collapse text-[11px] print:text-[8pt] text-center" style="min-width: 720px;">
            <thead>
                {{-- Group Row 1 --}}
                <tr class="bg-slate-800 text-white print:bg-slate-200 print:text-black font-semibold text-xs print:text-[8.5pt]">
                    <th rowspan="3" class="border border-slate-600 print:border-black px-2 py-2 w-10 align-middle">Date</th>
                    <th rowspan="3" class="border border-slate-600 print:border-black px-2 py-2 w-12 align-middle">Day</th>
                    <th colspan="9" class="border border-slate-600 print:border-black px-2 py-1.5 uppercase tracking-wider bg-slate-900 print:bg-slate-200">
                        *** Place of Residence
                    </th>
                    <th colspan="3" rowspan="2" class="border border-slate-600 print:border-black px-2 py-1.5 bg-emerald-950 text-emerald-200 print:bg-slate-300 print:text-black align-middle uppercase tracking-wider">
                        * Grand Total Number of Visitors
                    </th>
                </tr>

                {{-- Group Row 2 --}}
                <tr class="bg-slate-700 text-slate-100 print:bg-slate-100 print:text-black font-medium">
                    <th colspan="3" class="border border-slate-600 print:border-black px-1.5 py-1 bg-sky-950/70 print:bg-transparent">
                        This City / Municipality
                    </th>
                    <th colspan="3" class="border border-slate-600 print:border-black px-1.5 py-1 bg-indigo-950/70 print:bg-transparent">
                        Other City / Municipality
                    </th>
                    <th colspan="3" class="border border-slate-600 print:border-black px-1.5 py-1 bg-purple-950/70 print:bg-transparent">
                        Foreign Country Residence
                    </th>
                </tr>

                {{-- Gender / Total Headers (M / F / T) --}}
                <tr class="bg-slate-100 text-slate-700 print:bg-slate-100 print:text-black font-bold text-[10px] print:text-[7.5pt]">
                    {{-- This City --}}
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-sky-50 print:bg-transparent w-8">M</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-sky-50 print:bg-transparent w-8">F</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-sky-100 font-extrabold text-sky-900 print:text-black w-9">T</th>

                    {{-- Other City --}}
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-indigo-50 print:bg-transparent w-8">M</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-indigo-50 print:bg-transparent w-8">F</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-indigo-100 font-extrabold text-indigo-900 print:text-black w-9">T</th>

                    {{-- Foreign --}}
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-purple-50 print:bg-transparent w-8">M</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-purple-50 print:bg-transparent w-8">F</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-purple-100 font-extrabold text-purple-900 print:text-black w-9">T</th>

                    {{-- Grand Total --}}
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-emerald-50 text-emerald-950 font-bold print:text-black w-9">M</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-emerald-50 text-emerald-950 font-bold print:text-black w-9">F</th>
                    <th class="border border-slate-300 print:border-black py-1 px-1 bg-emerald-100 text-emerald-900 font-extrabold print:text-black w-10">T</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totals = [
                        'this_male'=>0,'this_female'=>0,'this_total'=>0,
                        'other_male'=>0,'other_female'=>0,'other_total'=>0,
                        'foreign_male'=>0,'foreign_female'=>0,'foreign_total'=>0,
                        'grand_male'=>0,'grand_female'=>0,'grand_total'=>0,
                    ];
                @endphp

                @for ($dayNum = 1; $dayNum <= 31; $dayNum++)
                    @php
                        $row = null;
                        foreach ($data as $r) {
                            if ((int)$r['day'] === $dayNum) { $row = $r; break; }
                        }
                        $isBlank = ($row === null);
                        $hasVisitors = !$isBlank && ($row['grand_total'] > 0);
                    @endphp
                    <tr class="{{ $hasVisitors ? 'bg-emerald-50/40 font-medium' : ($dayNum % 2 === 0 ? 'bg-slate-50/60' : 'bg-white') }} transition-colors hover:bg-slate-100/80 print:hover:bg-transparent">
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-bold text-slate-700 print:text-black">
                            {{ $isBlank ? '' : $dayNum }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-500 print:text-black">
                            {{ $isBlank ? '' : $row['week_day'] }}
                        </td>

                        {{-- This City --}}
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-700 print:text-black">
                            {{ $isBlank ? '' : ($row['this_male'] > 0 ? $row['this_male'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-700 print:text-black">
                            {{ $isBlank ? '' : ($row['this_female'] > 0 ? $row['this_female'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-semibold text-sky-800 bg-sky-50/40 print:bg-transparent print:text-black">
                            {{ $isBlank ? '' : ($row['this_total'] > 0 ? $row['this_total'] : '0') }}
                        </td>

                        {{-- Other City --}}
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-700 print:text-black">
                            {{ $isBlank ? '' : ($row['other_male'] > 0 ? $row['other_male'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-700 print:text-black">
                            {{ $isBlank ? '' : ($row['other_female'] > 0 ? $row['other_female'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-semibold text-indigo-800 bg-indigo-50/40 print:bg-transparent print:text-black">
                            {{ $isBlank ? '' : ($row['other_total'] > 0 ? $row['other_total'] : '0') }}
                        </td>

                        {{-- Foreign --}}
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-700 print:text-black">
                            {{ $isBlank ? '' : ($row['foreign_male'] > 0 ? $row['foreign_male'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 text-slate-700 print:text-black">
                            {{ $isBlank ? '' : ($row['foreign_female'] > 0 ? $row['foreign_female'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-semibold text-purple-800 bg-purple-50/40 print:bg-transparent print:text-black">
                            {{ $isBlank ? '' : ($row['foreign_total'] > 0 ? $row['foreign_total'] : '0') }}
                        </td>

                        {{-- Grand Total --}}
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-semibold text-slate-900 print:text-black">
                            {{ $isBlank ? '' : ($row['grand_male'] > 0 ? $row['grand_male'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-semibold text-slate-900 print:text-black">
                            {{ $isBlank ? '' : ($row['grand_female'] > 0 ? $row['grand_female'] : '0') }}
                        </td>
                        <td class="border border-slate-300 print:border-black py-1 px-1 font-black text-emerald-800 bg-emerald-50/60 print:bg-transparent print:text-black">
                            {{ $isBlank ? '' : ($row['grand_total'] > 0 ? $row['grand_total'] : '0') }}
                        </td>
                    </tr>
                    @if (!$isBlank)
                        @php
                            $totals['this_male']     += $row['this_male'];
                            $totals['this_female']   += $row['this_female'];
                            $totals['this_total']    += $row['this_total'];
                            $totals['other_male']    += $row['other_male'];
                            $totals['other_female']  += $row['other_female'];
                            $totals['other_total']   += $row['other_total'];
                            $totals['foreign_male']  += $row['foreign_male'];
                            $totals['foreign_female']+= $row['foreign_female'];
                            $totals['foreign_total'] += $row['foreign_total'];
                            $totals['grand_male']    += $row['grand_male'];
                            $totals['grand_female']  += $row['grand_female'];
                            $totals['grand_total']   += $row['grand_total'];
                        @endphp
                    @endif
                @endfor

                {{-- Monthly Total Row --}}
                <tr class="bg-emerald-100 text-emerald-950 print:bg-slate-200 print:text-black font-extrabold text-xs print:text-[8.5pt]">
                    <td colspan="2" class="border border-emerald-300 print:border-black py-2 px-2 text-center uppercase tracking-wider">
                        Total of this Month
                    </td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['this_male'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['this_female'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1 bg-sky-200/80 text-sky-950 font-black print:bg-transparent print:text-black">{{ $totals['this_total'] }}</td>

                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['other_male'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['other_female'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1 bg-indigo-200/80 text-indigo-950 font-black print:bg-transparent print:text-black">{{ $totals['other_total'] }}</td>

                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['foreign_male'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['foreign_female'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1 bg-purple-200/80 text-purple-950 font-black print:bg-transparent print:text-black">{{ $totals['foreign_total'] }}</td>

                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['grand_male'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1">{{ $totals['grand_female'] }}</td>
                    <td class="border border-emerald-300 print:border-black py-2 px-1 bg-emerald-200 text-emerald-950 font-black text-sm print:text-[9pt] print:bg-transparent print:text-black">{{ $totals['grand_total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ── Form Footer Note ────────────────────────────────────────── --}}
    <div class="mt-3 text-[10px] text-slate-500 print:text-[7pt] print:text-black print:mt-2 space-y-0.5">
        <p>*** <strong>Place of Residence:</strong> Philippines (<strong>This City/Municipality</strong> - Local residents; <strong>Other City/Municipality</strong> - Domestic tourists; <strong>Foreign Country Residence</strong> - International tourists).</p>
        <p>* <strong>Grand Total Number of Visitors:</strong> Combined count of all checked-in online bookings, group companions, and registered walk-ins.</p>
</div>

