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
 * @property int $tourist_id
 * @property int $destination_id
 * @property string $visit_date
 * @property int $duration_days
 * @property string $status
 * @property string|null $decline_reason
 * @property int|null $decided_by_staff_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $gcash_reference_number
 * @property string|null $payment_screenshot_path
 * @property string|null $payment_status
 * @property string|null $rejection_reason
 * @property string|null $payment_submitted_at
 * @property string|null $payment_reviewed_at
 * @property int|null $reviewed_by
 * @property string|null $qr_token
 * @property string|null $qr_generated_at
 * @property string|null $checked_in_at
 * @property int|null $checked_in_by
 * @property-read \App\Models\CheckIn|null $checkIn
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookingCompanion> $companions
 * @property-read int|null $companions_count
 * @property-read \App\Models\Destination|null $destination
 * @property-read \App\Models\User|null $staff
 * @property-read \App\Models\Ticket|null $ticket
 * @property-read \App\Models\User|null $tourist
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCheckedInAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCheckedInBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDecidedByStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDeclineReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereGcashReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePaymentReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePaymentScreenshotPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking wherePaymentSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereQrGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereQrToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereTouristId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
>>>>>>> Stashed changes
 */
>>>>>>> Stashed changes
class Booking extends Model
{
    protected $fillable = [
        // Core booking fields (original migration)
        'tourist_id',
        'destination_id',
        'visit_date',
        'status',
        'decline_reason',
        'decided_by_staff_id',

        // GCash / QR payment fields (2026_07_09_175237 migration)
        'gcash_reference_number',
        'payment_screenshot_path',
        'payment_status',
        'rejection_reason',
        'payment_submitted_at',
        'payment_reviewed_at',
        'reviewed_by',
        'qr_token',
        'qr_generated_at',
        'checked_in_at',
        'checked_in_by',
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
