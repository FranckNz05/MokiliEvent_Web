<!-- Paiements -->
<div class="tab-pane fade" id="payments">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Mes paiements</h4>
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Événement</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->event->title }}</td>
                                    <td>{{ number_format($payment->montant, 2) }} FC</td>
                                    <td>
                                        @if($payment->statut === 'payé')
                                            <span class="badge bg-success">Payé</span>
                                        @elseif($payment->statut === 'en attente')
                                            <span class="badge bg-warning">En attente</span>
                                        @else
                                            <span class="badge bg-danger">Échoué</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($payment->statut === 'payé')
                                            <a href="{{ route('payments.success', $payment) }}" 
                                               class="btn btn-sm btn-primary">
                                                Voir le ticket
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $payments->links() }}
            @else
                <div class="alert alert-info">
                    Vous n'avez pas encore effectué de paiement.
                </div>
            @endif
        </div>
    </div>
</div>
