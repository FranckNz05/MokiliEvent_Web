<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'user_id',
        'ticket_id',
        'evenement_id',
        'quantity',
        'montant_total',
        'statut',
        'reservation_id'
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'quantity' => 'integer'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function evenement()
    {
        return $this->belongsTo(Event::class, 'evenement_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function paiement()
    {
        return $this->hasOne(Payment::class);
    }

    // Helpers
    public function isPending()
    {
        return $this->statut === 'en_attente';
    }

    public function isPaid()
    {
        return $this->statut === 'payé';
    }

    public function isCancelled()
    {
        return $this->statut === 'annulé';
    }
}
