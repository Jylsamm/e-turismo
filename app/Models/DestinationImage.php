<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $destination_id
 * @property string $path
 * @property int $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Destination|null $destination
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DestinationImage wherePath($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DestinationImage extends Model
{
    protected $fillable = ['destination_id', 'path', 'is_primary'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
