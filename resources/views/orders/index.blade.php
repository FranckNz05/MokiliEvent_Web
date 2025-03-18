@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Mes commandes</h2>

                    @if($orders->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Vous n'avez pas encore de commande.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Numéro</th>
                                        <th>Date</th>
                                        <th>Événement</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->matricule }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $order->evenement->title }}</td>
                                            <td>{{ number_format($order->montant_total, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                @if($order->isPending())
                                                    <span class="badge bg-warning">En attente</span>
                                                @elseif($order->isPaid())
                                                    <span class="badge bg-success">Payée</span>
                                                @else
                                                    <span class="badge bg-danger">Annulée</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                                    Voir
                                                </a>
                                                @if($order->isPending())
                                                    <a href="{{ route('payments.process', $order) }}" class="btn btn-sm btn-success">
                                                        Payer
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
