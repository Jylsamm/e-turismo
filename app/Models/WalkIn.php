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
        'registered_by_staff_id',
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
