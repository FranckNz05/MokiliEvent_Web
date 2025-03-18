<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $table = 'seats';

    protected $fillable = [
        'zone_id', 'seat_number', 'status'
    ];

    public function zone()
    {
        return $this->belongsTo(EventZone::class, 'zone_id');
    }
}
