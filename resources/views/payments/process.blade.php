@extends('layouts.app')

@section('title', 'Paiement')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Paiement de votre commande</h2>

                    <!-- Résumé de la commande -->
                    <div class="mb-4">
                        <h5 class="mb-3">Résumé de votre commande</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Événement :</div>
                                <div class="col-sm-8">{{ $order->evenement->title }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Billet :</div>
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

                    <!-- Options de paiement -->
                    <div class="mb-4">
                        <h5 class="mb-3">Choisissez votre mode de paiement</h5>
                        <form action="{{ route('payments.store', $order) }}" method="POST" id="payment-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="payment-option border rounded p-3">
                                        <input type="radio" class="btn-check" name="methode_paiement" id="orange_money" value="orange_money" checked>
                                        <label class="btn btn-outline-primary w-100 h-100" for="orange_money">
                                            <img src="{{ asset('images/orange-money.png') }}" alt="Orange Money" class="img-fluid mb-2" style="height: 40px;">
                                            <span class="d-block">Orange Money</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="payment-option border rounded p-3">
                                        <input type="radio" class="btn-check" name="methode_paiement" id="mtn_momo" value="mtn_momo">
                                        <label class="btn btn-outline-primary w-100 h-100" for="mtn_momo">
                                            <img src="{{ asset('images/mtn-momo.png') }}" alt="MTN MoMo" class="img-fluid mb-2" style="height: 40px;">
                                            <span class="d-block">MTN Mobile Money</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages d'erreur -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Bouton de paiement -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Payer {{ number_format($order->montant_total, 0, ',', ' ') }} FCFA
                                </button>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Instructions :</h6>
                        <ol class="mb-0">
                            <li>Sélectionnez votre mode de paiement préféré</li>
                            <li>Cliquez sur le bouton "Payer"</li>
                            <li>Suivez les instructions sur votre téléphone pour valider le paiement</li>
                            <li>Une fois le paiement effectué, vous recevrez une confirmation par email</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.payment-option {
    cursor: pointer;
    transition: all 0.3s ease;
}
.payment-option:hover {
    border-color: var(--bs-primary) !important;
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}
.btn-check:checked + .btn {
    border-color: var(--bs-primary);
    background-color: rgba(var(--bs-primary-rgb), 0.1);
}
</style>
@endpush
@endsection
