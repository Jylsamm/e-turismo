<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
