@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Détails de la réservation</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Informations de l'événement</h5>
                        <p><strong>Événement:</strong> {{ $reservation->ticket->event->title }}</p>
                        <p><strong>Date:</strong> {{ $reservation->ticket->event->start_date->format('d/m/Y H:i') }}</p>
                        <p><strong>Lieu:</strong> {{ $reservation->ticket->event->adresse }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Détails de la réservation</h5>
                        <p><strong>Référence:</strong> {{ $reservation->id }}</p>
                        <p><strong>Type de ticket:</strong> {{ $reservation->ticket->nom }}</p>
                        <p><strong>Quantité:</strong> {{ $reservation->quantity }}</p>
                        <p><strong>Prix unitaire:</strong> {{ number_format($reservation->ticket->prix, 2) }} FC</p>
                        <p><strong>Total:</strong> {{ number_format($reservation->ticket->prix * $reservation->quantity, 2) }} FC</p>
                        <p>
                            <strong>Statut:</strong>
                            @if($reservation->status === 'payé')
                                <span class="badge bg-success">Payé</span>
                            @elseif($reservation->status === 'réservé')
                                <span class="badge bg-warning">Réservé</span>
                            @else
                                <span class="badge bg-danger">Annulé</span>
                            @endif
                        </p>
                        @if($reservation->expires_at)
                            <p>
                                <strong>Expire le:</strong>
                                @if($reservation->isExpired())
                                    <span class="text-danger">Expirée</span>
                                @else
                                    {{ $reservation->expires_at->format('d/m/Y H:i') }}
                                    ({{ $reservation->expires_at->diffForHumans() }})
                                @endif
                            </p>
                        @endif
                    </div>

                    @if($reservation->payment)
                        <div class="mb-4">
                            <h5>Informations de paiement</h5>
                            <p><strong>Méthode:</strong> {{ $reservation->payment->methode }}</p>
                            <p><strong>Date:</strong> {{ $reservation->payment->created_at->format('d/m/Y H:i') }}</p>
                            @if($reservation->payment->qr_code)
                                <div class="text-center">
                                    <img src="data:image/png;base64,{{ $reservation->payment->qr_code }}" 
                                         alt="QR Code" class="img-fluid">
                                    <p class="mt-2">
                                        <small>Présentez ce QR code à l'entrée de l'événement</small>
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        @if($reservation->status === 'réservé' && !$reservation->isExpired())
                            <a href="{{ route('payments.checkout', $reservation->ticket) }}" 
                               class="btn btn-primary">
                                Procéder au paiement
                            </a>
                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    Annuler la réservation
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-primary">
                            Retour aux réservations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
