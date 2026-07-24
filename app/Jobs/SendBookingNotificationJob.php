<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class SendBookingNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recipientIds;
    public $recipientType;
    public $type;
    public $message;
    public $relatedBookingId;

    /**
     * Create a new job instance.
     */
    public function __construct(array $recipientIds, string $recipientType, string $type, string $message, ?int $relatedBookingId = null)
    {
        $this->recipientIds = $recipientIds;
        $this->recipientType = $recipientType;
        $this->type = $type;
        $this->message = $message;
        $this->relatedBookingId = $relatedBookingId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->recipientIds)) {
            return;
        }

        $now = now();
        $notifications = [];

        foreach ($this->recipientIds as $recipientId) {
            $notifications[] = [
                'recipient_id' => $recipientId,
                'recipient_type' => $this->recipientType,
                'type' => $this->type,
                'message' => $this->message,
                'related_booking_id' => $this->relatedBookingId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert in chunks of 500 to avoid hitting MariaDB packet limits
        foreach (array_chunk($notifications, 500) as $chunk) {
            Notification::insert($chunk);
        }
    }
}
