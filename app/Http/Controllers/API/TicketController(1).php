<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['event', 'ticketType'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $tickets
        ]);
    }

    public function show(Ticket $ticket)
    {
        // Vérifier que l'utilisateur est le propriétaire du billet
        if ($ticket->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $ticket->load(['event', 'ticketType']);

        return response()->json([
            'status' => true,
            'data' => $ticket
        ]);
    }

    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $event = Event::findOrFail($request->event_id);
        $ticketType = TicketType::findOrFail($request->ticket_type_id);

        // Vérifier si l'événement est toujours actif
        if ($event->end_date < now() || $event->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Event is no longer available'
            ], 400);
        }

        // Vérifier la disponibilité des billets
        if ($ticketType->remaining < $request->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Not enough tickets available'
            ], 400);
        }

        // Calculer le montant total
        $totalAmount = $ticketType->price * $request->quantity;

        // TODO: Intégrer le système de paiement ici
        // Pour l'instant, on suppose que le paiement est réussi

        // Créer les billets
        $tickets = [];
        for ($i = 0; $i < $request->quantity; $i++) {
            $ticket = Ticket::create([
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'ticket_type_id' => $ticketType->id,
                'ticket_number' => 'TIX-' . Str::random(10),
                'qr_code' => Str::uuid(),
                'status' => 'valid',
                'price' => $ticketType->price,
            ]);
            $tickets[] = $ticket;
        }

        // Mettre à jour le nombre de billets restants
        $ticketType->decrement('remaining', $request->quantity);

        return response()->json([
            'status' => true,
            'message' => 'Tickets purchased successfully',
            'data' => [
                'tickets' => $tickets,
                'total_amount' => $totalAmount
            ]
        ], 201);
    }

    public function validateTicket(Ticket $ticket)
    {
        // Vérifier que l'utilisateur est l'organisateur de l'événement
        if ($ticket->event->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($ticket->status !== 'valid') {
            return response()->json([
                'status' => false,
                'message' => 'Ticket is not valid'
            ], 400);
        }

        if ($ticket->event->end_date < now()) {
            return response()->json([
                'status' => false,
                'message' => 'Event has ended'
            ], 400);
        }

        $ticket->update([
            'status' => 'used',
            'validated_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Ticket validated successfully',
            'data' => $ticket
        ]);
    }

    public function myTickets(Request $request)
    {
        $query = Ticket::with(['event', 'ticketType'])
            ->where('user_id', auth()->id());

        if ($request->has('status')) {
            if ($request->status === 'upcoming') {
                $query->whereHas('event', function ($q) {
                    $q->where('start_date', '>', now());
                });
            } elseif ($request->status === 'past') {
                $query->whereHas('event', function ($q) {
                    $q->where('end_date', '<', now());
                });
            }
        }

        $tickets = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $tickets
        ]);
    }
}
