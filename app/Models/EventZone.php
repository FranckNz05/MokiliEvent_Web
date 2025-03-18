<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventZone extends Model
{
    protected $table = 'event_zones';

    protected $fillable = [
        'event_id', 'name', 'description', 'capacity', 'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
