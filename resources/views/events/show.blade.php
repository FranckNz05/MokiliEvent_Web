@extends('layouts.app')

@section('title', $event->title)

@section('content')
@php
$breadcrumbs = [
    ['text' => 'Événements', 'url' => route('events.index')],
    ['text' => $event->title]
];
@endphp

@include('layouts.partials.page-header', [
    'pageTitle' => $event->title,
    'breadcrumbs' => $breadcrumbs
])

<!-- Event Details Start -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Image de l'événement -->
            <div class="event-main-image mb-5">
                <img class="img-fluid rounded shadow-sm" src="{{ asset($event->image) }}" alt="{{ $event->title }}">
            </div>

            <!-- En-tête et badges -->
            <div class="mb-4">
                <h1 class="display-5 mb-4">{{ $event->title }}</h1>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-{{ $event->status === 'Gratuit' ? 'success' : 'primary' }} px-3 py-2">
                        <i class="fas {{ $event->status === 'Gratuit' ? 'fa-check-circle' : 'fa-ticket-alt' }} me-1"></i>
                        {{ $event->status }}
                    </span>
                    <span class="badge bg-info px-3 py-2">
                        <i class="fas fa-chair me-1"></i>
                        {{ $event->event_type }}
                    </span>
                    <span class="badge bg-{{ $event->etat === 'En cours' ? 'success' : ($event->etat === 'Archivé' ? 'secondary' : 'danger') }} px-3 py-2">
                        <i class="fas fa-clock me-1"></i>
                        {{ $event->etat }}
                    </span>
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="far fa-calendar-alt text-primary me-2"></i>Date et Heure
                            </h5>
                            <p class="mb-2">Début: {{ $event->start_date->format('d M Y à H:i') }}</p>
                            <p class="mb-2">Fin: {{ $event->end_date->format('d M Y à H:i') }}</p>
                            <p class="text-muted mb-0"><small>Durée: {{ $event->getDurationAttribute() }}</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>Lieu
                            </h5>
                            <p class="mb-2">{{ $event->adresse }}</p>
                            <p class="mb-2">{{ $event->ville }}, {{ $event->pays }}</p>
                            @if($event->adresse_map)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->adresse_map) }}"
                                   class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-map me-1"></i>Voir sur la carte
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organisateur -->
            @if($event->organizer)
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img src="{{ $event->organizer->logo ? asset($event->organizer->logo) : asset('images/default-profile.jpg') }}"
                             alt="{{ $event->organizer->company_name }}"
                             class="rounded-circle me-4" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h4 class="mb-2">
                                <a href="{{ route('organizers.show', $event->organizer->slug) }}" class="text-decoration-none">
                                    {{ $event->organizer->company_name }}
                                    @if($event->organizer->is_verified)
                                        <i class="fas fa-check-circle text-primary ms-1" title="Organisateur vérifié"></i>
                                    @endif
                                </a>
                            </h4>
                            <div class="text-muted">
                                @if($event->organizer->phone_primary)
                                    <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $event->organizer->phone_primary }}</p>
                                @endif
                                @if($event->organizer->email)
                                    <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $event->organizer->email }}</p>
                                @endif
                                @if($event->organizer->website)
                                    <p class="mb-0"><i class="fas fa-globe me-2"></i><a href="{{ $event->organizer->website }}" target="_blank">Site web</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Description -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body">
                    <h4 class="card-title mb-4">À propos de l'événement</h4>
                    <div class="event-description">
                        {!! $event->description !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Section Billets -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <!-- Section des billets -->
                    <div class="tickets-section mt-5">
                        <h3 class="mb-4">Billets disponibles</h3>

                        <form action="{{ route('events.purchase-tickets', $event) }}" method="POST" id="tickets-form">
                            @csrf
                            <div class="tickets-container">
                                @foreach($event->tickets as $index => $ticket)
                                    @php
                                        $remainingTickets = $ticket->quantite - $ticket->quantite_vendue;
                                        $isPromo = $ticket->montant_promotionnel && now()->between($ticket->promotion_start, $ticket->promotion_end);
                                        $price = $isPromo ? $ticket->montant_promotionnel : $ticket->prix;
                                    @endphp
                                    <div class="ticket-item mb-4 p-3 border rounded @if($remainingTickets <= 0) opacity-50 @endif">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h5 class="mb-1">{{ $ticket->nom }}</h5>
                                                <p class="text-muted mb-2">{{ $ticket->description }}</p>
                                                <div class="price-info">
                                                    @if($isPromo)
                                                        <span class="text-decoration-line-through text-muted">{{ number_format($ticket->prix, 0, ',', ' ') }} FCFA</span>
                                                        <span class="text-danger ms-2">{{ number_format($price, 0, ',', ' ') }} FCFA</span>
                                                    @else
                                                        <span class="text-primary">{{ number_format($price, 0, ',', ' ') }} FCFA</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">
                                                    {{ $remainingTickets }} billets restants
                                                </small>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <input type="number"
                                                           name="tickets[{{ $index }}][quantity]"
                                                           class="form-control quantity-input"
                                                           style="width: 80px"
                                                           min="0"
                                                           max="{{ $remainingTickets }}"
                                                           value="0"
                                                           {{ $remainingTickets <= 0 ? 'disabled' : '' }}>
                                                    <input type="hidden"
                                                           name="tickets[{{ $index }}][ticket_id]"
                                                           value="{{ $ticket->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="total-section mt-4 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Total :</h5>
                                    <h5 class="mb-0" id="total-amount">0 FCFA</h5>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg" id="purchase-button" disabled>
                                    Procéder au paiement
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Informations importantes -->
                    <div class="mt-4">
                        <h5 class="mb-3">Informations importantes</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Les billets ne sont pas remboursables
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-qrcode text-primary me-2"></i>
                                Un QR code vous sera fourni après le paiement
                            </li>
                            <li>
                                <i class="fas fa-clock text-primary me-2"></i>
                                Présentez-vous 30 minutes avant le début
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Partage -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Partager l'événement</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('events.show', $event)) }}"
                           class="btn btn-outline-primary flex-grow-1" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/direct/new/?text={{ urlencode(route('events.show', $event)) }}"
                           class="btn btn-outline-danger flex-grow-1" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode(route('events.show', $event)) }}"
                           class="btn btn-outline-success flex-grow-1" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Événements similaires -->
    @if($similarEvents->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">Événements similaires</h3>
        <div class="row g-4">
            @foreach($similarEvents as $relatedEvent)
            <div class="col-lg-4 col-md-6">
                <div class="card event-card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        @if($relatedEvent->image)
                            <img src="{{ asset($relatedEvent->image) }}"
                                 alt="{{ $relatedEvent->title }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                            </div>
                        @endif
                        <button class="btn-favorite position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2 border-0 shadow-sm"
                                onclick="toggleFavorite(event, {{ $relatedEvent->id }})">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <a href="{{ route('events.show', $relatedEvent->slug) }}"
                               class="text-decoration-none text-dark">
                                {{ Str::limit($relatedEvent->title, 50) }}
                            </a>
                        </h5>
                        <div class="mb-2 text-muted">
                            <i class="far fa-calendar-alt me-2"></i>
                            {{ Carbon\Carbon::parse($relatedEvent->start_date)->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                        </div>
                        <div class="mb-3 text-muted">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $relatedEvent->ville }}
                        </div>
                        <div class="card-text">
                            @php
                                $minPrice = $relatedEvent->tickets->min('prix');
                            @endphp
                            @if($minPrice === null)
                                <span class="text-muted">Prix non défini</span>
                            @elseif($minPrice > 0)
                                <span class="text-primary">À partir de {{ number_format($minPrice, 0, ',', ' ') }} XAF</span>
                            @else
                                <span class="text-success">Gratuit</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
<!-- Event Details End -->
@endsection

@push('styles')
<style>
.event-main-image img {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
}

.event-description {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #444;
}

.ticket-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.ticket-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn-favorite {
    transition: transform 0.2s ease;
}

.btn-favorite:hover {
    transform: scale(1.1);
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .event-main-image img {
        max-height: 300px;
    }

    .ticket-card {
        padding: 1rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
function toggleFavorite(event, eventId) {
    event.preventDefault();
    event.stopPropagation();
    const button = event.currentTarget;
    const icon = button.querySelector('i');

    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('tickets-form');
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalAmount = document.getElementById('total-amount');
    const purchaseButton = document.getElementById('purchase-button');

    function updateTotal() {
        let total = 0;
        let hasTickets = false;

        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const ticketItem = input.closest('.ticket-item');
            const priceText = ticketItem.querySelector('.price-info').textContent;
            const price = parseInt(priceText.match(/\d+/g).pop().replace(/\s/g, ''));

            total += price * quantity;
            if (quantity > 0) hasTickets = true;
        });

        totalAmount.textContent = `${total.toLocaleString('fr-FR')} FCFA`;
        purchaseButton.disabled = !hasTickets;
    }

    quantityInputs.forEach(input => {
        input.addEventListener('change', updateTotal);
        input.addEventListener('input', updateTotal);
    });

    form.addEventListener('submit', function(e) {
        const hasTickets = Array.from(quantityInputs).some(input => parseInt(input.value) > 0);
        if (!hasTickets) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un billet.');
        }
    });
});
</script>
@endpush
