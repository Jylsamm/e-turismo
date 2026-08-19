<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string|null $middle_initial
 * @property string|null $suffix
 * @property Carbon|null $dob
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $contact
 * @property string|null $classification
 * @property string|null $id_type
 * @property string|null $id_number
 * @property string|null $id_photo
 * @property int|null $assigned_destination_id
 * @property string $id_verification_status
 * @property float|null $id_verification_score
 * @property string|null $id_verification_notes
 * @property Carbon|null $id_verified_at
 * @property bool $ready_to_complete_requirements
 * @property bool $is_manually_verified
 * @property string|null $gender
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read int|string $age
 * @mixin Builder
 * @property string|null $ocr_raw_text
 * @property array<array-key, mixed>|null $ocr_extracted_fields
 * @property int|null $ocr_processing_ms
 * @property string|null $ocr_image_hash
 * @property string|null $ocr_provider
 * @property string|null $remember_token
 * @property-read \App\Models\Destination|null $assignedDestination
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereAssignedDestinationId($value)
 * @method static Builder<static>|User whereClassification($value)
 * @method static Builder<static>|User whereContact($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereDob($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereGender($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereIdNumber($value)
 * @method static Builder<static>|User whereIdPhoto($value)
 * @method static Builder<static>|User whereIdType($value)
 * @method static Builder<static>|User whereIdVerificationNotes($value)
 * @method static Builder<static>|User whereIdVerificationScore($value)
 * @method static Builder<static>|User whereIdVerificationStatus($value)
 * @method static Builder<static>|User whereIdVerifiedAt($value)
 * @method static Builder<static>|User whereIsManuallyVerified($value)
 * @method static Builder<static>|User whereLastName($value)
 * @method static Builder<static>|User whereMiddleInitial($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User whereOcrExtractedFields($value)
 * @method static Builder<static>|User whereOcrImageHash($value)
 * @method static Builder<static>|User whereOcrProcessingMs($value)
 * @method static Builder<static>|User whereOcrProvider($value)
 * @method static Builder<static>|User whereOcrRawText($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereReadyToCompleteRequirements($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereRole($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @mixin Builder
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'middle_initial',
        'suffix',
        'dob',
        'email',
        'email_verified_at',
        'password',
        'role',
        'contact',
        'classification',
        'id_type',
        'id_number',
        'id_photo',
        'assigned_destination_id',
        'id_verification_status',
        'id_verification_score',
        'id_verification_notes',
        'id_verified_at',
        'ready_to_complete_requirements',
        'is_manually_verified',
        'gender',
        'ocr_raw_text',
        'ocr_extracted_fields',
        'ocr_processing_ms',
        'ocr_image_hash',
        'ocr_provider',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the user's age based on their date of birth.
     * Returns 'N/A' if dob is not set.
     */
    public function getAgeAttribute()
    {
        if (!$this->dob) {
            return 'N/A';
        }
        return Carbon::parse($this->dob)->age;
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isTourist(): bool
    {
        return $this->role === 'tourist';
    }

    public function isIdentityVerified(): bool
    {
        return $this->id_verification_status === 'verified';
    }

    public function isIdentityPending(): bool
    {
        return $this->id_verification_status === 'pending';
    }

<<<<<<< Updated upstream
    public function isIdentityRejected(): bool
    {
        return $this->id_verification_status === 'rejected';
=======
    public function setSuffixAttribute($value)
    {
        $clean = $value ? trim($value) : null;
        $this->attributes['suffix'] = ($clean && in_array(strtoupper($clean), ['N/A', 'NA', 'NONE', 'NOT APPLICABLE', 'NULL']))
            ? null
            : $clean;
    }

    public function setMiddleInitialAttribute($value)
    {
        $clean = $value ? trim($value) : null;
        $this->attributes['middle_initial'] = ($clean && in_array(strtoupper(rtrim($clean, '.')), ['N/A', 'NA', 'NONE', 'NOT APPLICABLE', 'NULL']))
            ? null
            : ($clean ? strtoupper(rtrim($clean, '.')) . '.' : null);
>>>>>>> Stashed changes
    }

    public function fullName(): string
    {
        $name = trim($this->name ?? '');
        $lastName = trim($this->last_name ?? '');
        
        if (!empty($lastName) && !str_ends_with(strtolower($name), strtolower($lastName))) {
            $middle = trim($this->middle_initial ?? '');
            if (!empty($middle) && !in_array(strtoupper(rtrim($middle, '.')), ['N/A', 'NA', 'NONE']) && !str_contains(strtolower($name), strtolower(rtrim($middle, '.')))) {
                $name .= ' ' . $middle;
            }
            $name .= ' ' . $lastName;
        }

        $suffix = trim($this->suffix ?? '');
        if (!empty($suffix) && !in_array(strtoupper($suffix), ['N/A', 'NA', 'NONE']) && !str_contains(strtolower($name), strtolower($suffix))) {
            $name .= ' ' . $suffix;
        }
        
        // Remove duplicated consecutive words/initials (e.g. "B. B.") and trailing N/A tokens
        $clean = preg_replace('/\b(\w+\.?)\s+\1\b/i', '$1', $name);
        $clean = preg_replace('/\b(N\/A|NA|NONE)\b/i', '', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);
        return trim($clean) ?: $name;
    }

    public function assignedDestination()
    {
        return $this->belongsTo(Destination::class, 'assigned_destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tourist_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'recipient_id');
    }

    public function sendEmailVerificationNotification()
    {
        // OTP registration verifies the email in-page, so disable Laravel's default email verification link notification.
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        if (app()->environment('testing')) {
            $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
        } else {
            $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'id_verified_at'         => 'datetime',
            'id_verification_score'  => 'decimal:2',
            'dob'                    => 'date',
            'password'               => 'hashed',
            'ready_to_complete_requirements' => 'boolean',
            'ocr_extracted_fields'   => 'array',
            'ocr_processing_ms'      => 'integer',
        ];
    }
}
