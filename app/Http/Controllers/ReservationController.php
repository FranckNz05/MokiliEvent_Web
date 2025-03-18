<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $ticket->getAvailableQuantityAttribute()
        ]);

        if (!$ticket->isAvailable()) {
            return back()->with('error', 'Ce ticket n\'est plus disponible.');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
            'quantity' => $request->quantity,
            'status' => 'réservé',
            'expires_at' => now()->addMinutes(30)
        ]);

        return redirect()->route('payments.checkout', $ticket)
            ->with('success', 'Réservation créée avec succès !');
    }

    public function index()
    {
        $reservations = auth()->user()->reservations()
            ->with(['ticket.event', 'payment'])
            ->latest()
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        if ($reservation->status === 'payé') {
            return back()->with('error', 'Impossible d\'annuler une réservation déjà payée.');
        }

        $reservation->update(['status' => 'annulé']);

        return back()->with('success', 'Réservation annulée avec succès.');
    }
}
