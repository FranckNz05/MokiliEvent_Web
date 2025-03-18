<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'quantity',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function isExpired()
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    public function isPaid()
    {
        return $this->status === 'payé';
    }

    public function isCancelled()
    {
        return $this->status === 'annulé';
    }
}
