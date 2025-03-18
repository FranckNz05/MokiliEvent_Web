<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->middleware('auth');
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request, Ticket $ticket)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $ticket->getAvailableQuantityAttribute()
        ]);

        $amount = $ticket->prix * $request->quantity;

        // Créer une réservation
        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
            'quantity' => $request->quantity,
            'status' => 'réservé',
            'expires_at' => now()->addMinutes(30)
        ]);

        // Créer un paiement en attente
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
            'reservation_id' => $reservation->id,
            'event_id' => $ticket->event_id,
            'montant' => $amount,
            'statut' => 'en attente',
            'methode' => $request->payment_method,
            'qr_code' => Str::random(20)
        ]);

        return view('payments.checkout', compact('payment', 'reservation', 'ticket'));
    }

    public function process(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette commande.');
        }

        if (!$order->isPending()) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Cette commande ne peut plus être payée.');
        }

        // Charger les relations nécessaires
        $order->load(['ticket', 'evenement']);

        return view('payments.process', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->isPending()) {
            return back()->with('error', 'Cette commande ne peut plus être payée.');
        }

        $request->validate([
            'methode_paiement' => 'required|in:orange_money,mtn_momo,carte_bancaire'
        ]);

        DB::beginTransaction();
        try {
            // Créer le paiement
            $payment = Payment::create([
                'matricule' => 'PAY-' . strtoupper(Str::random(8)),
                'order_id' => $order->id,
                'montant' => $order->montant_total,
                'methode_paiement' => $request->methode_paiement,
                'statut' => 'en_attente'
            ]);

            // Traiter le paiement avec le service approprié
            $success = $this->paymentService->processPayment($payment);

            if ($success) {
                DB::commit();
                return redirect()->route('payments.success', $payment);
            } else {
                throw new \Exception('Échec du paiement');
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur de paiement: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du traitement du paiement. Veuillez réessayer.');
        }
    }

    public function callback(Request $request, Order $order)
    {
        $payment = $order->paiement;

        if (!$payment) {
            abort(404);
        }

        try {
            $success = $this->paymentService->verifyPayment($payment);

            if ($success) {
                DB::transaction(function () use ($order, $payment) {
                    $payment->update([
                        'statut' => 'payé',
                        'reference_transaction' => request('reference'),
                        'qr_code' => $this->paymentService->generateQrCode($payment->matricule)
                    ]);

                    $order->update(['statut' => 'payé']);

                    if ($order->reservation) {
                        $order->reservation->update(['status' => 'payé']);
                    }
                });

                return redirect()->route('payments.success', $payment);
            }

            return redirect()->route('payments.failed', $payment);
        } catch (\Exception $e) {
            \Log::error('Erreur callback paiement: ' . $e->getMessage());
            return redirect()->route('payments.failed', $payment);
        }
    }

    public function success(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.success', compact('payment'));
    }

    public function failed(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.failed', compact('payment'));
    }

    public function history()
    {
        $payments = auth()->user()->payments()->latest()->paginate(10);
        return view('payments.history', compact('payments'));
    }
}
