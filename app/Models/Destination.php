<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

<<<<<<< Updated upstream
=======
/**
<<<<<<< Updated upstream
=======
 * @property int $id
 * @property string $name
 * @property string|null $initials
 * @property string $location
 * @property int $capacity
 * @property string|null $description
 * @property string|null $photos
 * @property string $availability_status
 * @property float|null $checkin_latitude
 * @property float|null $checkin_longitude
 * @property int|null $checkin_radius
 * @property int|null $last_updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read Collection<int, \App\Models\DestinationImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\DestinationImage|null $primaryImage
 * @property-read Collection<int, \App\Models\User> $staff
 * @property-read int|null $staff_count
 * @method static Builder<static>|Destination newModelQuery()
 * @method static Builder<static>|Destination newQuery()
 * @method static Builder<static>|Destination query()
 * @method static Builder<static>|Destination whereAvailabilityStatus($value)
 * @method static Builder<static>|Destination whereCapacity($value)
 * @method static Builder<static>|Destination whereCheckinLatitude($value)
 * @method static Builder<static>|Destination whereCheckinLongitude($value)
 * @method static Builder<static>|Destination whereCheckinRadius($value)
 * @method static Builder<static>|Destination whereCreatedAt($value)
 * @method static Builder<static>|Destination whereDescription($value)
 * @method static Builder<static>|Destination whereId($value)
 * @method static Builder<static>|Destination whereInitials($value)
 * @method static Builder<static>|Destination whereLastUpdatedBy($value)
 * @method static Builder<static>|Destination whereLocation($value)
 * @method static Builder<static>|Destination whereName($value)
 * @method static Builder<static>|Destination wherePhotos($value)
 * @method static Builder<static>|Destination whereUpdatedAt($value)
>>>>>>> Stashed changes
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
