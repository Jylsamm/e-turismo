<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
