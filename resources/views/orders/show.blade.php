@extends('layouts.app')

@section('title', 'Détails de la commande')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Détails de votre commande</h2>

                    <!-- Informations de la commande -->
                    <div class="mb-4">
                        <h5 class="mb-3">Informations de la commande</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Numéro de commande :</div>
                                <div class="col-sm-8">{{ $order->matricule }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Date :</div>
                                <div class="col-sm-8">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Statut :</div>
                                <div class="col-sm-8">
                                    @if($order->isPending())
                                        <span class="badge bg-warning">En attente</span>
                                    @elseif($order->isPaid())
                                        <span class="badge bg-success">Payée</span>
                                    @else
                                        <span class="badge bg-danger">Annulée</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Détails de l'événement -->
                    <div class="mb-4">
                        <h5 class="mb-3">Événement</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Titre :</div>
                                <div class="col-sm-8">{{ $order->evenement->title }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Date :</div>
                                <div class="col-sm-8">{{ $order->evenement->start_date->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Lieu :</div>
                                <div class="col-sm-8">{{ $order->evenement->location->name }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Détails du billet -->
                    <div class="mb-4">
                        <h5 class="mb-3">Billet</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Type :</div>
                                <div class="col-sm-8">{{ $order->ticket->nom }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Quantité :</div>
                                <div class="col-sm-8">{{ $order->quantity }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 text-muted">Montant total :</div>
                                <div class="col-sm-8">
                                    <strong class="text-primary">{{ number_format($order->montant_total, 0, ',', ' ') }} FCFA</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        @if($order->isPending())
                            <a href="{{ route('payments.process', $order) }}" class="btn btn-primary">
                                Procéder au paiement
                            </a>
                        @endif
                        <a href="{{ route('profile.tickets') }}" class="btn btn-outline-secondary">
                            Retour à mes billets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
