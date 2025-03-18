<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function purchase(Request $request, Ticket $ticket)
    {
        // Validation de base
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . ($ticket->quantite - $ticket->quantite_vendue)
        ]);

        // Vérifier si le ticket est disponible
        if ($ticket->statut !== 'disponible') {
            return back()->with('error', 'Ce billet n\'est plus disponible à la vente.');
        }

        // Vérifier si la quantité demandée est disponible
        if ($request->quantity > ($ticket->quantite - $ticket->quantite_vendue)) {
            return back()->with('error', 'La quantité demandée n\'est pas disponible.');
        }

        // Si le ticket est réservable, créer une réservation
        if ($ticket->reservable) {
            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'status' => 'Réservé',
                'expires_at' => now()->addDays($ticket->reservation_deadline ?? 7)
            ]);

            // Rediriger vers la page de paiement avec la réservation
            return redirect()->route('payment.process', [
                'reservation_id' => $reservation->id
            ]);
        }

        // Si non réservable, créer directement le paiement
        $montant_total = $ticket->montant_promotionnel && now()->between($ticket->promotion_start, $ticket->promotion_end)
            ? $ticket->montant_promotionnel * $request->quantity
            : $ticket->prix * $request->quantity;

        $payment = Payment::create([
            'matricule' => Str::random(6),
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
            'evenement_id' => $ticket->evenement_id,
            'montant' => $montant_total,
            'statut' => 'en attente',
            'methode' => $request->methode_paiement
        ]);

        return redirect()->route('payment.process', [
            'payment_id' => $payment->id
        ]);
    }

    public function generateTicketPDF(Payment $payment)
    {
        // Générer le QR code
        $qrCode = QrCode::size(200)
            ->generate(route('tickets.verify', $payment->matricule));

        // Créer le PDF
        $pdf = PDF::loadView('tickets.pdf', [
            'payment' => $payment,
            'qrCode' => $qrCode,
            'ticket' => $payment->ticket,
            'event' => $payment->ticket->event
        ]);

        // Sauvegarder le PDF
        $pdfPath = 'tickets/'. $payment->matricule .'.pdf';
        $pdf->save(storage_path('app/public/' . $pdfPath));

        // Mettre à jour le paiement avec le chemin du QR code
        $payment->update([
            'qr_code' => $pdfPath
        ]);

        return $pdf->download('ticket-' . $payment->matricule . '.pdf');
    }

    public function verifyTicket($matricule)
    {
        $payment = Payment::where('matricule', $matricule)
            ->where('statut', 'payé')
            ->first();

        if (!$payment) {
            return response()->json([
                'valid' => false,
                'message' => 'Billet invalide ou non payé'
            ]);
        }

        return response()->json([
            'valid' => true,
            'ticket' => [
                'event' => $payment->ticket->event->title,
                'type' => $payment->ticket->nom,
                'date' => $payment->ticket->event->start_date->format('d/m/Y H:i'),
                'quantity' => $payment->quantity
            ]
        ]);
    }
}
