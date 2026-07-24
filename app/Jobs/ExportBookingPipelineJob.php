<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportBookingPipelineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $adminId;

    public function __construct($adminId)
    {
        $this->adminId = $adminId;
    }

    public function handle()
    {
        $bookings = Booking::with(['tourist', 'destination'])->latest()->get();

        $filename = 'exports/booking_pipeline_' . time() . '.csv';
        
        $csvContent = '';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Booking ID', 'Tourist Name', 'Classification', 'Destination', 'Visit Date', 'Status', 'Booked At']);
        
        foreach ($bookings as $b) {
            $firstName = $b->tourist->name ?? 'N/A';
            $lastName = $b->tourist->last_name ?? '';
            fputcsv($handle, [
                $b->id,
                trim($firstName . ' ' . $lastName),
                $b->tourist->classification ?? 'N/A',
                $b->destination->name ?? 'N/A',
                $b->visit_date,
                $b->status,
                $b->created_at->format('Y-m-d H:i'),
            ]);
        }
        
        rewind($handle);
        while (($line = fgets($handle)) !== false) {
            $csvContent .= $line;
        }
        fclose($handle);

        Storage::disk('public')->put($filename, $csvContent);

        // Send a notification to the admin with the download link
        Notification::create([
            'recipient_id' => $this->adminId,
            'recipient_type' => 'staff', // admins are staff-privileged
            'type' => 'system_alert',
            'message' => 'Your booking pipeline CSV export is ready. <a href="' . asset('storage/' . $filename) . '" class="underline text-brand-600 font-bold" download>Download CSV</a>',
            'is_read' => false
        ]);
    }
}
