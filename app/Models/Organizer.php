<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'slug',
        'logo',
        'banner_image',
        'slogan',
        'description',
        'email',
        'phone_primary',
        'phone_secondary',
        'website',
        'address',
        'city',
        'country',
        'is_verified',
        'social_media'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'social_media' => 'array'
    ];

    /**
     * Get the user that owns the organizer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the events for the organizer.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function followers()
    {
        return $this->hasMany(OrganizerFollower::class);
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }
}
