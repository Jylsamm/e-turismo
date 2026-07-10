<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'initials',
        'location',
        'capacity',
        'description',
        'photos',
        'availability_status',
    ];

    public function staff()
    {
        return $this->hasMany(User::class, 'assigned_destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
