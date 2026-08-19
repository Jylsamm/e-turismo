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
 * @property int $recipient_id
 * @property string $recipient_type
 * @property string $type
 * @property string $message
 * @property int|null $related_booking_id
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Booking|null $booking
 * @property-read \App\Models\User|null $recipient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRecipientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRelatedBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
>>>>>>> Stashed changes
 */
>>>>>>> Stashed changes
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
