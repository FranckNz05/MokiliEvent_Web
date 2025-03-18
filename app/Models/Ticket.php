<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    const UPDATED_AT = 'update_at';

    protected $table = 'tickets';

    protected $fillable = [
        'event_id',
        'nom',
        'description',
        'prix',
        'quantite',
        'quantite_vendue',
        'montant_promotionnel',
        'promotion_start',
        'promotion_end',
        'statut',
        'reservable',
        'reservation_deadline'
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'quantite' => 'integer',
        'quantite_vendue' => 'integer',
        'reservable' => 'boolean',
        'reservation_deadline' => 'datetime'
    ];

    protected $dates = [
        'promotion_start',
        'promotion_end',
        'create_at',
        'update_at'
    ];

    // Relations
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Helpers
    public function getAvailableQuantityAttribute()
    {
        return $this->quantite - $this->quantite_vendue;
    }

    public function isAvailable()
    {
        return $this->statut === 'disponible' && $this->getAvailableQuantityAttribute() > 0;
    }
}
