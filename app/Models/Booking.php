<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        // Core booking fields (original migration)
        'tourist_id',
        'destination_id',
        'visit_date',
        'status',
        'decline_reason',
        'decided_by_staff_id',

        // GCash / QR payment fields (2026_07_09_175237 migration)
        'gcash_reference_number',
        'payment_screenshot_path',
        'payment_status',
        'rejection_reason',
        'payment_submitted_at',
        'payment_reviewed_at',
        'reviewed_by',
        'qr_token',
        'qr_generated_at',
        'checked_in_at',
        'checked_in_by',
    ];

    public function tourist()
    {
        return $this->belongsTo(User::class, 'tourist_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'decided_by_staff_id');
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function checkIn()
    {
        return $this->hasOne(CheckIn::class);
    }
}
