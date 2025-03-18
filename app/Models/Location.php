<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'city',
        'state',
        'country',
        'address',
        'postal_code',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    /**
     * Get the events for the location.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the location's full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->country,
            $this->postal_code
        ]);

        return implode(', ', $parts);
    }
}
