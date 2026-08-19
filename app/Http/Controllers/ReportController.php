<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Destination;
use App\Models\Report;
use App\Models\WalkIn;
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

        $destinations = Destination::orderBy('name')->get();

        $filters = [
            'destination_id' => $request->destination_id,
            'period'         => $request->period ?? 'monthly',
            'date_from'      => $request->date_from ?? now()->startOfMonth()->toDateString(),
            'date_to'        => $request->date_to ?? now()->toDateString(),
        ];

        $stats = $this->buildStats($filters);
        $topDestinations = $this->getTopDestinations($filters);

        return view('reports.index', compact('destinations', 'filters', 'stats', 'topDestinations'));
    }

    /**
     * Show a previously generated report.
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $filters = [
            'destination_id' => $report->destination_id,
            'date_from'      => $report->date_from,
            'date_to'        => $report->date_to,
        ];

        $stats = $this->buildStats($filters);
        $topDestinations = $this->getTopDestinations($filters);

        return view('reports.show', compact('report', 'stats', 'topDestinations'));
    }

    /**
     * Return the HTML preview of the Visitor Record (for modal rendering).
     * GET /reports/generate-visitor-record
     */
    public function generateVisitorRecord(Request $request)
    {
        $this->authorize('viewAny', Report::class);
        $viewData = $this->buildVisitorRecordData($request);
        return view('reports.preview', $viewData);
    }

    /**
     * Export the Visitor Record as a DOCX download.
     * GET /reports/export-visitor-record
     */
    public function exportVisitorRecord(Request $request)
    {
        $this->authorize('create', Report::class);
        $viewData = $this->buildVisitorRecordData($request);
        extract($viewData); // gives us $data, $monthYearLabel, $cityLabel, $attractionName, $daysInMonth

        $templatePath = $this->getDocxTemplatePath();
        if (!$templatePath || !file_exists($templatePath)) {
            return back()->with('error', 'Report template (.docx) was not found on the server.');
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
        
        $setVal = function($key, $val) use ($templateProcessor) {
            $safeVal = htmlspecialchars((string)$val, ENT_QUOTES | ENT_SUBSTITUTE | ENT_XML1, 'UTF-8');
            $templateProcessor->setValue($key, $safeVal);
        };

        $setVal('month_year', $monthYearLabel);
        $setVal('city_municipality', $cityLabel);
        $setVal('attraction_name', $attractionName);
        $setVal('type_of_attraction', $attractionType ?? '');

        $sumThisMale = 0; $sumThisFemale = 0; $sumThisTotal = 0;
        $sumOtherMale = 0; $sumOtherFemale = 0; $sumOtherTotal = 0;
        $sumForeignMale = 0; $sumForeignFemale = 0; $sumForeignTotal = 0;
        $sumGrandMale = 0; $sumGrandFemale = 0; $sumGrandTotal = 0;

        $rowIdx = 1;
        foreach ($data as $row) {
            $setVal("day#{$rowIdx}", $row['day']);
            $setVal("week_day#{$rowIdx}", $row['week_day']);
            $setVal("this_male#{$rowIdx}", $row['this_male']);
            $setVal("this_female#{$rowIdx}", $row['this_female']);
            $setVal("this_total#{$rowIdx}", $row['this_total']);
            $setVal("other_male#{$rowIdx}", $row['other_male']);
            $setVal("other_female#{$rowIdx}", $row['other_female']);
            $setVal("other_total#{$rowIdx}", $row['other_total']);
            $setVal("foreign_male#{$rowIdx}", $row['foreign_male']);
            $setVal("foreign_female#{$rowIdx}", $row['foreign_female']);
            $setVal("foreign_total#{$rowIdx}", $row['foreign_total']);
            $setVal("grand_male#{$rowIdx}", $row['grand_male']);
            $setVal("grand_female#{$rowIdx}", $row['grand_female']);
            $setVal("grand_total#{$rowIdx}", $row['grand_total']);

            $sumThisMale    += $row['this_male'];
            $sumThisFemale  += $row['this_female'];
            $sumThisTotal   += $row['this_total'];
            $sumOtherMale   += $row['other_male'];
            $sumOtherFemale += $row['other_female'];
            $sumOtherTotal  += $row['other_total'];
            $sumForeignMale    += $row['foreign_male'];
            $sumForeignFemale  += $row['foreign_female'];
            $sumForeignTotal   += $row['foreign_total'];
            $sumGrandMale    += $row['grand_male'];
            $sumGrandFemale  += $row['grand_female'];
            $sumGrandTotal   += $row['grand_total'];

            $rowIdx++;
        }

        // Blank trailing rows (template always has 31 rows)
        for ($i = $rowIdx; $i <= 31; $i++) {
            foreach (['day', 'week_day', 'this_male', 'this_female', 'this_total',
                      'other_male', 'other_female', 'other_total',
                      'foreign_male', 'foreign_female', 'foreign_total',
                      'grand_male', 'grand_female', 'grand_total'] as $field) {
                $setVal("{$field}#{$i}", '');
            }
        }

        $setVal('sum_this_male',    $sumThisMale);
        $setVal('sum_this_female',  $sumThisFemale);
        $setVal('sum_this_total',   $sumThisTotal);
        $setVal('sum_other_male',   $sumOtherMale);
        $setVal('sum_other_female', $sumOtherFemale);
        $setVal('sum_other_total',  $sumOtherTotal);
        $setVal('sum_foreign_male',   $sumForeignMale);
        $setVal('sum_foreign_female', $sumForeignFemale);
        $setVal('sum_foreign_total',  $sumForeignTotal);
        $setVal('sum_grand_male',   $sumGrandMale);
        $setVal('sum_grand_female', $sumGrandFemale);
        $setVal('sum_grand_total',  $sumGrandTotal);

        $tempFile = tempnam(sys_get_temp_dir(), 'docx_vr');
        $templateProcessor->saveAs($tempFile);

        $cleanName = str_replace([' ', '/', '\\'], '_', $attractionName);
        $filename  = "{$cleanName}-{$monthYearLabel}.docx";

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Legacy DOCX export route alias.
     */
    public function exportDocx(Request $request)
    {
        return $this->exportVisitorRecord($request);
    }

    /* ------------------------------------------------------------------ */
    /*  Private helpers                                                     */
    /* ------------------------------------------------------------------ */

    /**
     * Locate the DOCX template from known locations.
     */
    private function getDocxTemplatePath(): ?string
    {
        $possiblePaths = [
            resource_path('templates/Tourism Attraction Visitor Record.docx'),
            base_path('resources/templates/Tourism Attraction Visitor Record.docx'),
            base_path('Docx_Template/Tourism Attraction Visitor Record.docx'),
            storage_path('app/Docx_Template/Tourism Attraction Visitor Record.docx'),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Aggregate daily visitor counts by residence type & gender for one calendar month.
     * The month is derived from date_from (the whole calendar month is always used).
     */
    private function buildVisitorRecordData(Request $request): array
    {
        $request->validate([
            'date_from'      => 'required|date',
            'date_to'        => 'nullable|date',
            'destination_id' => 'nullable|exists:destinations,id',
        ]);

        $start       = \Carbon\Carbon::parse($request->date_from)->startOfMonth();
        $end         = \Carbon\Carbon::parse($request->date_from)->endOfMonth();
        $daysInMonth = $start->daysInMonth;

        // Build a keyed array of all days in the month
        $data = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $dateStr = $d->toDateString();
            $data[$dateStr] = [
                'day'           => $d->day,
                'week_day'      => $d->format('D'),
                'this_male'     => 0, 'this_female'    => 0, 'this_total'    => 0,
                'other_male'    => 0, 'other_female'   => 0, 'other_total'   => 0,
                'foreign_male'  => 0, 'foreign_female' => 0, 'foreign_total' => 0,
                'grand_male'    => 0, 'grand_female'   => 0, 'grand_total'   => 0,
            ];
        }

        // 1. Primary checked-in tourists (Bookings + CheckIns + Users)
        $primaryCheckins = CheckIn::query()
            ->join('bookings', 'check_ins.booking_id', '=', 'bookings.id')
            ->join('users',    'bookings.tourist_id',  '=', 'users.id')
            ->selectRaw('DATE(bookings.visit_date) as visit_date, users.classification, users.gender, COUNT(*) as cnt')
            ->whereBetween('bookings.visit_date', [$start->toDateString(), $end->toDateString()])
            ->when($request->destination_id, fn($q) => $q->where('bookings.destination_id', $request->destination_id))
            ->groupBy('visit_date', 'users.classification', 'users.gender')
            ->get();

        // 2. Checked-in companions (Bookings + CheckIns + BookingCompanions)
        $companionCheckins = DB::table('booking_companions')
            ->join('bookings', 'booking_companions.booking_id', '=', 'bookings.id')
            ->join('check_ins', 'check_ins.booking_id', '=', 'bookings.id')
            ->selectRaw('DATE(bookings.visit_date) as visit_date, booking_companions.classification, booking_companions.gender, COUNT(*) as cnt')
            ->whereBetween('bookings.visit_date', [$start->toDateString(), $end->toDateString()])
            ->when($request->destination_id, fn($q) => $q->where('bookings.destination_id', $request->destination_id))
            ->groupBy('visit_date', 'booking_companions.classification', 'booking_companions.gender')
            ->get();

        // 3. Walk-ins
        $walkins = WalkIn::query()
            ->selectRaw('DATE(created_at) as visit_date, classification, gender, COUNT(*) as cnt')
            ->whereBetween('created_at', [$start->toDateString() . ' 00:00:00', $end->toDateString() . ' 23:59:59'])
            ->when($request->destination_id, fn($q) => $q->where('destination_id', $request->destination_id))
            ->groupBy('visit_date', 'classification', 'gender')
            ->get();

        // Helper to resolve bucket
        $classify = function(?string $c): ?string {
            $val = trim((string)$c);
            if (empty($val) || strcasecmp($val, 'Local') === 0 || stripos($val, 'City') !== false || stripos($val, 'Municipality') !== false) {
                return 'this';
            }
            if (strcasecmp($val, 'Domestic') === 0 || stripos($val, 'Domestic') !== false) {
                return 'other';
            }
            if (strcasecmp($val, 'Foreign') === 0 || stripos($val, 'International') !== false || stripos($val, 'Foreign') !== false) {
                return 'foreign';
            }
            return 'this';
        };

        // Helper to resolve gender
        $genderize = function(?string $g): string {
            $val = strtolower(trim((string)$g));
            return (in_array($val, ['female', 'f', 'woman', 'girl'])) ? 'female' : 'male';
        };

        // Aggregate into $data
        foreach ([$primaryCheckins, $companionCheckins, $walkins] as $collection) {
            foreach ($collection as $item) {
                $dateStr = $item->visit_date;
                if (!isset($data[$dateStr])) continue;

                $bucket = $classify($item->classification ?? 'Local');
                $g      = $genderize($item->gender ?? 'male');
                $cnt    = (int) $item->cnt;

                $data[$dateStr]["{$bucket}_{$g}"] += $cnt;
            }
        }

        // Compute row totals
        $summary = [
            'total_this'    => 0,
            'total_other'   => 0,
            'total_foreign' => 0,
            'total_male'    => 0,
            'total_female'  => 0,
            'grand_total'   => 0,
        ];

        foreach ($data as &$row) {
            $row['this_total']    = $row['this_male']    + $row['this_female'];
            $row['other_total']   = $row['other_male']   + $row['other_female'];
            $row['foreign_total'] = $row['foreign_male'] + $row['foreign_female'];
            $row['grand_male']    = $row['this_male']    + $row['other_male']    + $row['foreign_male'];
            $row['grand_female']  = $row['this_female']  + $row['other_female']  + $row['foreign_female'];
            $row['grand_total']   = $row['grand_male']   + $row['grand_female'];

            $summary['total_this']    += $row['this_total'];
            $summary['total_other']   += $row['other_total'];
            $summary['total_foreign'] += $row['foreign_total'];
            $summary['total_male']    += $row['grand_male'];
            $summary['total_female']  += $row['grand_female'];
            $summary['grand_total']   += $row['grand_total'];
        }
        unset($row);

        // Header meta
        $monthYearLabel = $start->format('F Y');
        $cityLabel      = config('app.municipality_name', 'Tigbao, Zamboanga del Sur');
        $attractionName = 'All Attractions';
        $attractionType = 'Ecotourism & Heritage Attractions';

        if ($request->destination_id) {
            $dest = Destination::find($request->destination_id);
            if ($dest) {
                $attractionName = $dest->name;
                $attractionType = $dest->description ? \Illuminate\Support\Str::limit($dest->description, 60) : 'Tourist Attraction';
            }
        }

        return compact('data', 'monthYearLabel', 'cityLabel', 'attractionName', 'attractionType', 'daysInMonth', 'summary');
    }

    private function buildStats(array $filters): array
    {
        $dateFrom = $filters['date_from'];
        $dateTo   = $filters['date_to'];
        $destId   = $filters['destination_id'];

        $bookingQuery = Booking::whereBetween('visit_date', [$dateFrom, $dateTo])
            ->when(!empty($destId), fn($q) => $q->where('destination_id', $destId));

        $bookingCounts = $bookingQuery->clone()
            ->selectRaw('COUNT(*) as total_bookings')
            ->selectRaw("SUM(CASE WHEN status IN ('confirmed','completed') THEN 1 ELSE 0 END) as confirmed")
            ->selectRaw("SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined")
            ->selectRaw("SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending")
            ->selectRaw("SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled")
            ->first();

        // Checked-in primary tourists
        $primaryVisitors = CheckIn::query()
            ->join('bookings', 'check_ins.booking_id', '=', 'bookings.id')
            ->whereBetween('bookings.visit_date', [$dateFrom, $dateTo])
            ->when(!empty($destId), fn($q) => $q->where('bookings.destination_id', $destId))
            ->count();

        // Checked-in companions
        $companionVisitors = DB::table('booking_companions')
            ->join('bookings', 'booking_companions.booking_id', '=', 'bookings.id')
            ->join('check_ins', 'check_ins.booking_id', '=', 'bookings.id')
            ->whereBetween('bookings.visit_date', [$dateFrom, $dateTo])
            ->when(!empty($destId), fn($q) => $q->where('bookings.destination_id', $destId))
            ->count();

        // Walk-in visitors
        $walkinVisitors = WalkIn::query()
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->when(!empty($destId), fn($q) => $q->where('destination_id', $destId))
            ->count();

        $totalVisitors = $primaryVisitors + $companionVisitors + $walkinVisitors;

        return [
            'total_bookings'     => (int) ($bookingCounts->total_bookings ?? 0),
            'confirmed'          => (int) ($bookingCounts->confirmed ?? 0),
            'declined'           => (int) ($bookingCounts->declined ?? 0),
            'pending'            => (int) ($bookingCounts->pending ?? 0),
            'cancelled'          => (int) ($bookingCounts->cancelled ?? 0),
            'total_visitors'     => (int) $totalVisitors,
            'primary_visitors'   => (int) $primaryVisitors,
            'companion_visitors' => (int) $companionVisitors,
            'walkin_visitors'    => (int) $walkinVisitors,
        ];
    }

    private function getTopDestinations(array $filters): \Illuminate\Support\Collection
    {
        return DB::table('bookings')
            ->join('destinations', 'bookings.destination_id', '=', 'destinations.id')
            ->whereBetween('bookings.visit_date', [$filters['date_from'], $filters['date_to']])
            ->whereIn('bookings.status', ['confirmed', 'completed'])
            ->select('destinations.id', 'destinations.name', 'destinations.location', DB::raw('count(*) as total'))
            ->groupBy('destinations.id', 'destinations.name', 'destinations.location')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }
}
