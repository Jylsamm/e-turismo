<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $qrCode;
    public $bookingId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $qrCode, int $bookingId)
    {
        $this->qrCode = $qrCode;
        $this->bookingId = $bookingId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Storage::disk('public')->makeDirectory('qr-tickets');
        $qrPath = 'qr-tickets/' . $this->bookingId . '.svg';
        $qrCodeImage = QrCode::size(250)->margin(1)->generate($this->qrCode);
        Storage::disk('public')->put($qrPath, $qrCodeImage);
    }
}
