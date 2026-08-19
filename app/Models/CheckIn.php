<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

<<<<<<< Updated upstream
=======
/**
<<<<<<< Updated upstream
 * @mixin Builder
=======
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property int $booking_id
 * @property string $arrival_time
 * @property int|null $verified_by_staff_id
 * @property int $occupancy_updated
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Booking $booking
 * @property-read \App\Models\User|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereOccupancyUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CheckIn whereVerifiedByStaffId($value)
>>>>>>> Stashed changes
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
