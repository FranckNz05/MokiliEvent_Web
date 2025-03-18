<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizerRequest extends Model
{
    protected $table = 'organizer_requests';

    protected $fillable = [
        'user_id', 'company_name', 'email', 'phone_primary',
        'address', 'status', 'rejection_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
