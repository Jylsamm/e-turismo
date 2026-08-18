<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

<<<<<<< Updated upstream
=======
/**
 * @mixin Builder
 */
>>>>>>> Stashed changes
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
        'checkin_latitude',
        'checkin_longitude',
        'checkin_radius',
        'last_updated_by',
    ];

    /**
     * Cast coordinates to float so they are never returned as strings.
     * Blade templates and JSON responses will both get proper numeric values.
     */
    protected $casts = [
        'checkin_latitude'  => 'float',
        'checkin_longitude' => 'float',
        'checkin_radius'    => 'integer',
    ];

    public function staff()
    {
        return $this->hasMany(User::class, 'assigned_destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(DestinationImage::class)->orderByDesc('is_primary');
    }

    public function primaryImage()
    {
        return $this->hasOne(DestinationImage::class)->where('is_primary', true);
    }
}
