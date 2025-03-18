@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Mes réservations</h2>

            @if($reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Événement</th>
                                <th>Ticket</th>
                                <th>Quantité</th>
                                <th>Statut</th>
                                <th>Expire le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>
                                        <a href="{{ route('events.show', $reservation->ticket->event) }}">
                                            {{ $reservation->ticket->event->title }}
                                        </a>
                                    </td>
                                    <td>{{ $reservation->ticket->nom }}</td>
                                    <td>{{ $reservation->quantity }}</td>
                                    <td>
                                        @if($reservation->status === 'payé')
                                            <span class="badge bg-success">Payé</span>
                                        @elseif($reservation->status === 'réservé')
                                            <span class="badge bg-warning">Réservé</span>
                                        @else
                                            <span class="badge bg-danger">Annulé</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->expires_at)
                                            @if($reservation->isExpired())
                                                <span class="text-danger">Expirée</span>
                                            @else
                                                {{ $reservation->expires_at->diffForHumans() }}
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($reservation->status === 'réservé' && !$reservation->isExpired())
                                            <div class="btn-group">
                                                <a href="{{ route('payments.checkout', $reservation->ticket) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    Payer
                                                </a>
                                                <form action="{{ route('reservations.cancel', $reservation) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($reservation->status === 'payé')
                                            <a href="{{ route('payments.success', $reservation->payment) }}" 
                                               class="btn btn-sm btn-success">
                                                Voir le ticket
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Vous n'avez pas encore de réservation.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
