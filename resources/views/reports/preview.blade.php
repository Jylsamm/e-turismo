{{--
    resources/views/reports/preview.blade.php
    Rendered by ReportController::generateVisitorRecord()
    Injected into the modal on the Reports index page.
    Variables available: $data, $monthYearLabel, $cityLabel, $attractionName, $daysInMonth
--}}
<div id="visitor-record-preview">

    {{-- ── Header ───────────────────────────────────────────────────── --}}
    <div class="text-center mb-4 print-section">
        <p class="text-xs text-gray-500 italic mb-1">(This recording form can be used instead of just counting the visitors)</p>
        <h2 class="text-base font-bold uppercase tracking-wide text-gray-800">Tourism Attraction Visitor Record</h2>
    </div>

    <table class="w-full border-collapse text-xs mb-3 print-section" style="border: 1px solid #000;">
        <tbody>
            <tr>
                <td class="border border-black px-2 py-1 font-semibold w-48">Month / Year</td>
                <td class="border border-black px-2 py-1">{{ $monthYearLabel }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-1 font-semibold">Name of City/Municipality</td>
                <td class="border border-black px-2 py-1">{{ $cityLabel }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-1 font-semibold">Name of Attraction/Spot</td>
                <td class="border border-black px-2 py-1">{{ $attractionName }}</td>
            </tr>
            <tr>
                <td class="border border-black px-2 py-1 font-semibold">Type of Tourism Attraction</td>
                <td class="border border-black px-2 py-1">&nbsp;</td>
            </tr>
        </tbody>
    </table>

    {{-- ── Daily Visitor Table ──────────────────────────────────────── --}}
    <div class="overflow-x-auto print-section">
        <table class="border-collapse text-xs print-section" style="border:1px solid #000; min-width:100%; table-layout:fixed;">
            <colgroup>
                <col style="width:28px">
                <col style="width:36px">
                {{-- This City/Municipality --}}
                <col style="width:32px"><col style="width:32px"><col style="width:32px">
                {{-- Other City/Municipality --}}
                <col style="width:32px"><col style="width:32px"><col style="width:32px">
                {{-- Foreign Country Residence --}}
                <col style="width:32px"><col style="width:32px"><col style="width:32px">
                {{-- Grand Total --}}
                <col style="width:32px"><col style="width:32px"><col style="width:32px">
            </colgroup>
            <thead>
                <tr style="background:#e2e8f0;">
                    <th rowspan="3" class="border border-black p-1 text-center align-middle">Date</th>
                    <th rowspan="3" class="border border-black p-1 text-center align-middle">Day</th>
                    <th colspan="9" class="border border-black p-1 text-center">***Place of Residence</th>
                    <th colspan="3" rowspan="2" class="border border-black p-1 text-center align-middle">*Grand Total Number of Visitors</th>
                </tr>
                <tr style="background:#e2e8f0;">
                    <th colspan="3" class="border border-black p-1 text-center">This City/Municipality</th>
                    <th colspan="3" class="border border-black p-1 text-center">Other City/Municipality</th>
                    <th colspan="3" class="border border-black p-1 text-center">Foreign Country Residence</th>
                </tr>
                <tr style="background:#e2e8f0;">
                    @foreach(['This City/Municipality','Other City/Municipality','Foreign Country Residence','Grand Total'] as $group)
                        <th class="border border-black p-1 text-center">M</th>
                        <th class="border border-black p-1 text-center">F</th>
                        <th class="border border-black p-1 text-center">T</th>
                    @endforeach
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
                        // Find the row for this day number
                        $row = null;
                        foreach ($data as $r) {
                            if ((int)$r['day'] === $dayNum) { $row = $r; break; }
                        }
                        $isBlank = ($row === null);
                    @endphp
                    <tr class="{{ $dayNum % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="border border-black p-1 text-center font-medium">{{ $isBlank ? '' : $dayNum }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['week_day'] }}</td>
                        {{-- This City --}}
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['this_male'] }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['this_female'] }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['this_total'] }}</td>
                        {{-- Other City --}}
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['other_male'] }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['other_female'] }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['other_total'] }}</td>
                        {{-- Foreign --}}
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['foreign_male'] }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['foreign_female'] }}</td>
                        <td class="border border-black p-1 text-center">{{ $isBlank ? '' : $row['foreign_total'] }}</td>
                        {{-- Grand Total --}}
                        <td class="border border-black p-1 text-center font-semibold">{{ $isBlank ? '' : $row['grand_male'] }}</td>
                        <td class="border border-black p-1 text-center font-semibold">{{ $isBlank ? '' : $row['grand_female'] }}</td>
                        <td class="border border-black p-1 text-center font-semibold">{{ $isBlank ? '' : $row['grand_total'] }}</td>
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
                <tr style="background:#d1fae5; font-weight:700;">
                    <td colspan="2" class="border border-black p-1 text-center text-xs">Total of this Month</td>
                    <td class="border border-black p-1 text-center">{{ $totals['this_male'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['this_female'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['this_total'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['other_male'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['other_female'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['other_total'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['foreign_male'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['foreign_female'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['foreign_total'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['grand_male'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['grand_female'] }}</td>
                    <td class="border border-black p-1 text-center">{{ $totals['grand_total'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-500 mt-2 print-section">
        ***Place of Residence: Philippines (This City/Municipality | Other City/Municipality | Foreign Country Residence)
    </p>

</div>
