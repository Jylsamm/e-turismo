<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
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

    public function isIdentityRejected(): bool
    {
        return $this->id_verification_status === 'rejected';
    }

    public function fullName(): string
    {
        $parts = array_filter([$this->name, $this->middle_initial, $this->last_name]);
        return implode(' ', $parts);
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
        ];
    }
}
