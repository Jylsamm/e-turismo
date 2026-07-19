<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Destination;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show report filter form and summary.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Report::class);

        $destinations = Destination::all();

        $filters = [
            'destination_id' => $request->destination_id,
            'period' => $request->period ?? 'monthly',
            'date_from' => $request->date_from ?? now()->startOfMonth()->toDateString(),
            'date_to' => $request->date_to ?? now()->toDateString(),
        ];

        $stats = $this->buildStats($filters);

        return view('reports.index', compact('destinations', 'filters', 'stats'));
    }

    /**
     * Generate a saved DOT report.
     */
    public function generate(Request $request)
    {
        $this->authorize('create', Report::class);

        $request->validate([
            'destination_id' => 'nullable|exists:destinations,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'type' => 'required|in:daily,weekly,monthly',
        ]);

        $filters = $request->only(['destination_id', 'date_from', 'date_to', 'type']);
        $stats = $this->buildStats($filters);

        $report = Report::create([
            'generated_by_admin_id' => auth()->id(),
            'destination_id' => $filters['destination_id'] ?? null,
            'type' => $filters['type'],
            'date_from' => $filters['date_from'],
            'date_to' => $filters['date_to'],
            'total_visitors' => $stats['total_visitors'],
            'total_bookings' => $stats['total_bookings'],
            'confirmed_bookings' => $stats['confirmed'],
            'declined_bookings' => $stats['declined'],
        ]);

        return redirect()->route('reports.show', $report)->with('success', 'Report generated successfully.');
    }

    /**
     * Show a previously generated report.
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $filters = [
            'destination_id' => $report->destination_id,
            'date_from' => $report->date_from,
            'date_to' => $report->date_to,
        ];

        $stats = $this->buildStats($filters);
        $topDestinations = $this->getTopDestinations($filters);

        return view('reports.show', compact('report', 'stats', 'topDestinations'));
    }

    /**
     * Export report data as Word DOCX using PHPWord TemplateProcessor.
     */
    public function exportDocx(Request $request)
    {
        $this->authorize('create', Report::class);

        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'destination_id' => 'nullable|exists:destinations,id',
        ]);

        $start = \Carbon\Carbon::parse($request->date_from);
        $end = \Carbon\Carbon::parse($request->date_to);
        
        $days = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days[] = $date->copy();
        }

        // Fetch check-ins
        $checkins = CheckIn::query()
            ->join('bookings', 'check_ins.booking_id', '=', 'bookings.id')
            ->join('users', 'bookings.tourist_id', '=', 'users.id')
            ->selectRaw('DATE(bookings.visit_date) as visit_date, users.classification, users.gender, COUNT(*) as count')
            ->whereBetween('bookings.visit_date', [$request->date_from, $request->date_to])
            ->when($request->destination_id, function($q) use ($request) {
                $q->where('bookings.destination_id', $request->destination_id);
            })
            ->groupBy('visit_date', 'users.classification', 'users.gender')
            ->get();

        // Fetch walk-ins
        $walkins = WalkIn::query()
            ->selectRaw('DATE(created_at) as visit_date, classification, gender, COUNT(*) as count')
            ->whereBetween('created_at', [$request->date_from . ' 00:00:00', $request->date_to . ' 23:59:59'])
            ->when($request->destination_id, function($q) use ($request) {
                $q->where('destination_id', $request->destination_id);
            })
            ->groupBy('visit_date', 'classification', 'gender')
            ->get();

        // Group data by date
        $data = [];
        foreach ($days as $dayCarbon) {
            $dateStr = $dayCarbon->toDateString();
            $data[$dateStr] = [
                'day' => $dayCarbon->day,
                'week_day' => $dayCarbon->format('D'),
                'this_male' => 0, 'this_female' => 0, 'this_total' => 0,
                'other_male' => 0, 'other_female' => 0, 'other_total' => 0,
                'foreign_male' => 0, 'foreign_female' => 0, 'foreign_total' => 0,
                'grand_male' => 0, 'grand_female' => 0, 'grand_total' => 0,
            ];
        }

        foreach ($checkins as $item) {
            $dateStr = $item->visit_date;
            if (!isset($data[$dateStr])) continue;
            $c = $item->classification;
            $g = strtolower($item->gender ?? 'male');
            $cnt = $item->count;

            if ($c === 'Local') {
                if ($g === 'male') $data[$dateStr]['this_male'] += $cnt;
                else $data[$dateStr]['this_female'] += $cnt;
            } elseif ($c === 'Domestic' || $c === 'Domestic Tourist') {
                if ($g === 'male') $data[$dateStr]['other_male'] += $cnt;
                else $data[$dateStr]['other_female'] += $cnt;
            } elseif ($c === 'Foreign' || $c === 'International Tourist') {
                if ($g === 'male') $data[$dateStr]['foreign_male'] += $cnt;
                else $data[$dateStr]['foreign_female'] += $cnt;
            }
        }

        foreach ($walkins as $item) {
            $dateStr = $item->visit_date;
            if (!isset($data[$dateStr])) continue;
            $c = $item->classification;
            $g = strtolower($item->gender ?? 'male');
            $cnt = $item->count;

            if ($c === 'Local') {
                if ($g === 'male') $data[$dateStr]['this_male'] += $cnt;
                else $data[$dateStr]['this_female'] += $cnt;
            } elseif ($c === 'Domestic' || $c === 'Domestic Tourist') {
                if ($g === 'male') $data[$dateStr]['other_male'] += $cnt;
                else $data[$dateStr]['other_female'] += $cnt;
            } elseif ($c === 'Foreign' || $c === 'International Tourist') {
                if ($g === 'male') $data[$dateStr]['foreign_male'] += $cnt;
                else $data[$dateStr]['foreign_female'] += $cnt;
            }
        }

        foreach ($data as $dateStr => &$row) {
            $row['this_total'] = $row['this_male'] + $row['this_female'];
            $row['other_total'] = $row['other_male'] + $row['other_female'];
            $row['foreign_total'] = $row['foreign_male'] + $row['foreign_female'];
            $row['grand_male'] = $row['this_male'] + $row['other_male'] + $row['foreign_male'];
            $row['grand_female'] = $row['this_female'] + $row['other_female'] + $row['foreign_female'];
            $row['grand_total'] = $row['grand_male'] + $row['grand_female'];
        }
        unset($row);

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app/Docx_Template/Tourism Attraction Visitor Record.docx'));

        $monthYearLabel = $start->format('F Y');
        $cityLabel = "Tigbao, Zamboanga del Sur";
        $attractionName = "All Attractions";
        $attractionType = "Various";

        if ($request->destination_id) {
            $dest = Destination::find($request->destination_id);
            if ($dest) {
                $attractionName = $dest->name;
                $attractionType = $dest->description ?? 'Nature/Attraction';
            }
        }

        $templateProcessor->setValue('month_year', $monthYearLabel);
        $templateProcessor->setValue('city_municipality', $cityLabel);
        $templateProcessor->setValue('attraction_name', $attractionName);
        $templateProcessor->setValue('attraction_type', $attractionType);

        $numRows = count($days);
        $templateProcessor->cloneRow('day', $numRows);

        $sumThisMale = 0; $sumThisFemale = 0; $sumThisTotal = 0;
        $sumOtherMale = 0; $sumOtherFemale = 0; $sumOtherTotal = 0;
        $sumForeignMale = 0; $sumForeignFemale = 0; $sumForeignTotal = 0;
        $sumGrandMale = 0; $sumGrandFemale = 0; $sumGrandTotal = 0;

        $rowIdx = 1;
        foreach ($data as $dateStr => $row) {
            $templateProcessor->setValue("day#{$rowIdx}", $row['day']);
            $templateProcessor->setValue("week_day#{$rowIdx}", $row['week_day']);

            $templateProcessor->setValue("this_male#{$rowIdx}", $row['this_male']);
            $templateProcessor->setValue("this_female#{$rowIdx}", $row['this_female']);
            $templateProcessor->setValue("this_total#{$rowIdx}", $row['this_total']);

            $templateProcessor->setValue("other_male#{$rowIdx}", $row['other_male']);
            $templateProcessor->setValue("other_female#{$rowIdx}", $row['other_female']);
            $templateProcessor->setValue("other_total#{$rowIdx}", $row['other_total']);

            $templateProcessor->setValue("foreign_male#{$rowIdx}", $row['foreign_male']);
            $templateProcessor->setValue("foreign_female#{$rowIdx}", $row['foreign_female']);
            $templateProcessor->setValue("foreign_total#{$rowIdx}", $row['foreign_total']);

            $templateProcessor->setValue("grand_male#{$rowIdx}", $row['grand_male']);
            $templateProcessor->setValue("grand_female#{$rowIdx}", $row['grand_female']);
            $templateProcessor->setValue("grand_total#{$rowIdx}", $row['grand_total']);

            $sumThisMale += $row['this_male'];
            $sumThisFemale += $row['this_female'];
            $sumThisTotal += $row['this_total'];

            $sumOtherMale += $row['other_male'];
            $sumOtherFemale += $row['other_female'];
            $sumOtherTotal += $row['other_total'];

            $sumForeignMale += $row['foreign_male'];
            $sumForeignFemale += $row['foreign_female'];
            $sumForeignTotal += $row['foreign_total'];

            $sumGrandMale += $row['grand_male'];
            $sumGrandFemale += $row['grand_female'];
            $sumGrandTotal += $row['grand_total'];

            $rowIdx++;
        }

        $templateProcessor->setValue('sum_this_male', $sumThisMale);
        $templateProcessor->setValue('sum_this_female', $sumThisFemale);
        $templateProcessor->setValue('sum_this_total', $sumThisTotal);

        $templateProcessor->setValue('sum_other_male', $sumOtherMale);
        $templateProcessor->setValue('sum_other_female', $sumOtherFemale);
        $templateProcessor->setValue('sum_other_total', $sumOtherTotal);

        $templateProcessor->setValue('sum_foreign_male', $sumForeignMale);
        $templateProcessor->setValue('sum_foreign_female', $sumForeignFemale);
        $templateProcessor->setValue('sum_foreign_total', $sumForeignTotal);

        $templateProcessor->setValue('sum_grand_male', $sumGrandMale);
        $templateProcessor->setValue('sum_grand_female', $sumGrandFemale);
        $templateProcessor->setValue('sum_grand_total', $sumGrandTotal);

        $tempFile = tempnam(sys_get_temp_dir(), 'docx_report');
        $templateProcessor->saveAs($tempFile);

        $cleanName = str_replace(' ', '_', $attractionName);
        return response()->download($tempFile, "{$cleanName}-{$monthYearLabel}.docx")->deleteFileAfterSend(true);
    }

    /* ------------------------------------------------------------------ */
    /*  Private helpers                                                     */
    /* ------------------------------------------------------------------ */

    private function buildStats(array $filters): array
    {
        $query = Booking::whereBetween('visit_date', [
            $filters['date_from'],
            $filters['date_to'],
        ]);

        if (!empty($filters['destination_id'])) {
            $query->where('destination_id', $filters['destination_id']);
        }

        $bookings = $query->get();

        $stats = $query->clone()
            ->selectRaw('COUNT(*) as total_bookings')
            ->selectRaw("SUM(CASE WHEN status IN ('confirmed','completed') THEN 1 ELSE 0 END) as confirmed")
            ->selectRaw("SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined")
            ->selectRaw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending")
            ->first();

        $totalVisitors = CheckIn::query()
            ->join('bookings', 'check_ins.booking_id', '=', 'bookings.id')
            ->whereBetween('bookings.visit_date', [$filters['date_from'], $filters['date_to']])
            ->when(!empty($filters['destination_id']), function ($q) use ($filters) {
                $q->where('bookings.destination_id', $filters['destination_id']);
            })
            ->count();

        return [
            'total_bookings' => (int) ($stats->total_bookings ?? 0),
            'total_visitors' => (int) $totalVisitors,
            'confirmed' => (int) ($stats->confirmed ?? 0),
            'declined' => (int) ($stats->declined ?? 0),
            'pending' => (int) ($stats->pending ?? 0),
        ];
    }

    private function getTopDestinations(array $filters): \Illuminate\Support\Collection
    {
        return DB::table('bookings')
            ->join('destinations', 'bookings.destination_id', '=', 'destinations.id')
            ->whereBetween('bookings.visit_date', [$filters['date_from'], $filters['date_to']])
            ->whereIn('bookings.status', ['confirmed', 'completed'])
            ->select('destinations.name', DB::raw('count(*) as total'))
            ->groupBy('destinations.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }
}
