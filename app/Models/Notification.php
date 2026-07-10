<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'recipient_id',
        'recipient_type',
        'type',
        'message',
        'related_booking_id',
        'is_read',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'related_booking_id');
    }
}
