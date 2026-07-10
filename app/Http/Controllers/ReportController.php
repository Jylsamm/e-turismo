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
     * Export report data as CSV.
     */
    public function export(Request $request)
    {
        $this->authorize('create', Report::class);

        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'destination_id' => 'nullable|exists:destinations,id',
        ]);

        $query = Booking::with(['tourist', 'destination'])
            ->whereBetween('visit_date', [$request->date_from, $request->date_to])
            ->where('status', '!=', 'pending');

        if ($request->destination_id) {
            $query->where('destination_id', $request->destination_id);
        }

        $bookings = $query->get();

        $filename = 'eturismo_report_' . $request->date_from . '_to_' . $request->date_to . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Booking ID', 'Tourist Name', 'ID Type', 'Destination', 'Visit Date', 'Status', 'Booked At']);
            foreach ($bookings as $b) {
                fputcsv($file, [
                    $b->id,
                    $b->tourist->name ?? 'N/A',
                    $b->tourist->classification ?? 'N/A',
                    $b->destination->name ?? 'N/A',
                    $b->visit_date,
                    $b->status,
                    $b->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

        $totalVisitors = CheckIn::whereHas('booking', function ($q) use ($filters) {
            $q->whereBetween('visit_date', [$filters['date_from'], $filters['date_to']]);
            if (!empty($filters['destination_id'])) {
                $q->where('destination_id', $filters['destination_id']);
            }
        })->count();

        return [
            'total_bookings' => $bookings->count(),
            'total_visitors' => $totalVisitors,
            'confirmed' => $bookings->where('status', 'confirmed')->count() + $bookings->where('status', 'completed')->count(),
            'declined' => $bookings->where('status', 'declined')->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
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
