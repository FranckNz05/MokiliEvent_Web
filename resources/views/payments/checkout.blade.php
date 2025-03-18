@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Paiement</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Détails de la commande</h5>
                        <p><strong>Événement:</strong> {{ $ticket->event->title }}</p>
                        <p><strong>Ticket:</strong> {{ $ticket->nom }}</p>
                        <p><strong>Quantité:</strong> {{ $reservation->quantity }}</p>
                        <p><strong>Montant total:</strong> {{ number_format($payment->montant, 2) }} FC</p>
                    </div>

                    <form action="{{ route('payments.process', $payment) }}" method="POST" id="payment-form">
                        @csrf
                        <div class="mb-4">
                            <h5>Choisir le mode de paiement</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="airtel" value="Airtel Money" required>
                                <label class="form-check-label" for="airtel">
                                    Airtel Money
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="mtn" value="MTN Mobile Money">
                                <label class="form-check-label" for="mtn">
                                    MTN Mobile Money
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de téléphone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="alert alert-info">
                            <small>Vous recevrez un message pour confirmer le paiement sur votre téléphone.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Procéder au paiement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
