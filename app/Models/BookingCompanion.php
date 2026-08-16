<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCompanion extends Model
{
    protected $fillable = [
        'booking_id',
        'name',
        'age',
        'gender',
        'contact_number',
        'email',
        'classification',
        'duration_days',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
