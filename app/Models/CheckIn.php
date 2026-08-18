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
class CheckIn extends Model
{
    protected $fillable = [
        'booking_id',
        'arrival_time',
        'verified_by_staff_id',
        'occupancy_updated',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'verified_by_staff_id');
    }
}
