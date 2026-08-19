<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $generated_by_admin_id
 * @property int|null $destination_id
 * @property string $type
 * @property \Illuminate\Support\Carbon $date_from
 * @property \Illuminate\Support\Carbon $date_to
 * @property int $total_visitors
 * @property int $total_bookings
 * @property int $confirmed_bookings
 * @property int $declined_bookings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $admin
 * @property-read \App\Models\Destination|null $destination
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereConfirmedBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDeclinedBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereGeneratedByAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereTotalBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereTotalVisitors($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Report extends Model
{
    protected $fillable = [
        'generated_by_admin_id',
        'destination_id',
        'type',
        'date_from',
        'date_to',
        'total_visitors',
        'total_bookings',
        'confirmed_bookings',
        'declined_bookings',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to'   => 'date',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'generated_by_admin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
