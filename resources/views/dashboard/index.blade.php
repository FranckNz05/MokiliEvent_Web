@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Réservations</h6>
                            <h3 class="mb-0">{{ $stats['total_reservations'] }}</h3>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Réservations payées</h6>
                            <h3 class="mb-0">{{ $stats['reservations_payees'] }}</h3>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total dépensé</h6>
                            <h3 class="mb-0">{{ number_format($stats['total_depense'], 2) }} FC</h3>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Événements favoris</h6>
                            <h3 class="mb-0">{{ $stats['events_favoris'] }}</h3>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Menu latéral -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/default-profile.jpg') }}" 
                             alt="Profile" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="ms-3">
                            <h5 class="mb-0">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h5>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                    </div>

                    <div class="list-group">
                        <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                        <a href="#reservations" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-ticket-alt me-2"></i> Réservations
                        </a>
                        <a href="#payments" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-credit-card me-2"></i> Paiements
                        </a>
                        <a href="#favorites" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-heart me-2"></i> Favoris
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="col-lg-9">
            <div class="tab-content">
                @include('dashboard.partials.profile')
                @include('dashboard.partials.reservations')
                @include('dashboard.partials.payments')
                @include('dashboard.partials.favorites')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Garder l'onglet actif après le rechargement de la page
    $(document).ready(function() {
        var hash = window.location.hash;
        if (hash) {
            $('.list-group-item[href="' + hash + '"]').tab('show');
        }

        // Mettre à jour l'URL lors du changement d'onglet
        $('.list-group-item').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    });
</script>
@endpush
