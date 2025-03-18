<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'paiements';

    protected $fillable = [
        'matricule',
        'order_id',
        'montant',
        'methode_paiement',
        'statut',
        'qr_code',
        'reference_transaction'
    ];

    protected $casts = [
        'montant' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsToThrough(Ticket::class, Order::class);
    }

    public function event()
    {
        return $this->belongsToThrough(Event::class, Order::class, 'evenement_id');
    }

    public function isPending()
    {
        return $this->statut === 'en_attente';
    }

    public function isPaid()
    {
        return $this->statut === 'payé';
    }

    public function isFailed()
    {
        return $this->statut === 'échoué';
    }
}
