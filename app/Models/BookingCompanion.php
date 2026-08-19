<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $booking_id
 * @property string $name
 * @property int $age
 * @property string $gender
 * @property string|null $contact_number
 * @property string|null $email
 * @property string $classification
 * @property int $duration_days
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Booking $booking
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingCompanion whereName($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
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
