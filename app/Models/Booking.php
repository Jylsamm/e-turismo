<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'tourist_id',
        'destination_id',
        'visit_date',
        'status',
        'decline_reason',
        'decided_by_staff_id',
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
