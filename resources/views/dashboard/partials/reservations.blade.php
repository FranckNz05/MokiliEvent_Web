<!-- Réservations -->
<div class="tab-pane fade" id="reservations">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Mes réservations</h4>
            @if($reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Événement</th>
                                <th>Ticket</th>
                                <th>Quantité</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->ticket->event->title }}</td>
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
                                        <a href="{{ route('reservations.show', $reservation) }}" 
                                           class="btn btn-sm btn-primary">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $reservations->links() }}
            @else
                <div class="alert alert-info">
                    Vous n'avez pas encore de réservation.
                </div>
            @endif
        </div>
    </div>
</div>
