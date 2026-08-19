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
 * @property int $destination_id
 * @property string $name
 * @property int $age
 * @property string|null $contact_number
 * @property string|null $email
 * @property string $classification
 * @property string|null $gender
 * @property int $duration_days
 * @property int $registered_by_staff_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Destination|null $destination
 * @property-read \App\Models\User|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereRegisteredByStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WalkIn whereUpdatedAt($value)
>>>>>>> Stashed changes
 */
>>>>>>> Stashed changes
class WalkIn extends Model
{
    protected $fillable = [
        'destination_id',
        'name',
        'age',
        'contact_number',
        'email',
        'classification',
        'duration_days',
        'registered_by_staff_id',
        'gender',
    ];

    protected $casts = [
        'duration_days' => 'integer',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'registered_by_staff_id');
    }
}
