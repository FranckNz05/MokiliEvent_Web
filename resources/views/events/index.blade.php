@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Filtres -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Filtres</h5>
                    <form action="{{ route('events.index') }}" method="GET">
                        <!-- Recherche -->
                        <div class="mb-3">
                            <label for="search" class="form-label">Rechercher</label>
                            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Titre, organisateur, mots-clés...">
                        </div>

                        <!-- Période -->
                        <div class="mb-3">
                            <label for="periode" class="form-label">Période</label>
                            <select class="form-select" id="periode" name="periode">
                                <option value="">Toutes les périodes</option>
                                <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                                <option value="week" {{ request('periode') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                                <option value="month" {{ request('periode') == 'month' ? 'selected' : '' }}>Ce mois-ci</option>
                                <option value="upcoming" {{ request('periode') == 'upcoming' ? 'selected' : '' }}>À venir</option>
                            </select>
                        </div>

                        <!-- Catégories -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Catégorie</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Villes -->
                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <select class="form-select" id="ville" name="ville">
                                <option value="">Toutes les villes</option>
                                @foreach($villes as $v)
                                    <option value="{{ $v }}" {{ request('ville') == $v ? 'selected' : '' }}>
                                        {{ $v }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type d'événement -->
                        <div class="mb-3">
                            <label for="event_type" class="form-label">Type d'événement</label>
                            <select class="form-select" id="event_type" name="event_type">
                                <option value="">Tous les types</option>
                                <option value="Espace libre" {{ request('event_type') == 'Espace libre' ? 'selected' : '' }}>Espace libre</option>
                                <option value="Plan de salle" {{ request('event_type') == 'Plan de salle' ? 'selected' : '' }}>Plan de salle</option>
                                <option value="Mixte" {{ request('event_type') == 'Mixte' ? 'selected' : '' }}>Mixte</option>
                            </select>
                        </div>

                        <!-- Tri -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Trier par</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (croissant)</option>
                                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (décroissant)</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Titre</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger">Appliquer les filtres</button>
                            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des événements -->
        <div class="col-lg-9">
            @if($events->count() > 0)
                <div class="row g-4">
                    @foreach($events as $event)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('events.show', $event->slug) }}" class="text-decoration-none">
                            <div class="card event-card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    @if($event->image)
                                        <img src="{{ asset($event->image) }}"
                                             alt="{{ $event->title }}"
                                             class="card-img-top"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                             style="height: 200px;">
                                            <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                    @auth
                                        <button class="btn-favorite position-absolute top-0 end-0 m-3 bg-white rounded-circle p-2 border-0 shadow-sm"
                                                onclick="event.preventDefault(); toggleFavorite(event, {{ $event->id }})">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    @endauth

                                    @if($event->category)
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge bg-danger">{{ $event->category->name }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">{{ Str::limit($event->title, 50) }}</h5>

                                    @if($event->start_date)
                                        <div class="mb-2 text-muted">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            {{ Carbon\Carbon::parse($event->start_date)->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                                        </div>
                                    @endif

                                    @if($event->ville)
                                        <div class="mb-3 text-muted">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            {{ $event->ville }}
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @php
                                                $minPrice = $event->tickets->min('prix');
                                            @endphp
                                            @if($minPrice === null)
                                                <span class="text-muted">Gratuit</span>
                                            @elseif($minPrice > 0)
                                                <span class="text-primary fw-bold">À partir de {{ number_format($minPrice, 0, ',', ' ') }} XAF</span>
                                            @else
                                                <span class="text-success">Gratuit</span>
                                            @endif
                                        </div>
                                        <div class="text-muted small">
                                            <i class="fas fa-eye me-1"></i> {{ $event->views_count ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Aucun événement ne correspond à vos critères de recherche.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.event-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    aspect-ratio: 1;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.event-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.event-image-container {
    position: relative;
    width: 100%;
    height: 60%;
    overflow: hidden;
    background-color: #f8f9fa;
}

.event-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.event-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e9ecef;
    color: #adb5bd;
}

.event-image-placeholder i {
    font-size: 3rem;
}

.event-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.7));
    pointer-events: none;
}

.btn-favorite {
    position: absolute;
    top: 15px;
    right: 15px;
    background: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    z-index: 10;
}

.btn-favorite:hover {
    transform: scale(1.1);
    background-color: #fff;
}

.btn-favorite i {
    color: #dc3545;
    font-size: 1.2rem;
}

.event-info {
    padding: 1.2rem;
    height: 40%;
    display: flex;
    flex-direction: column;
    background: white;
}

.event-title {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.8rem;
    color: #2c3e50;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.event-datetime, .event-location {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.event-footer {
    margin-top: auto;
    padding-top: 0.8rem;
    border-top: 1px solid #eee;
}

.price {
    color: #2c3e50;
    font-size: 1.1rem;
    font-weight: 700;
}

.free-price {
    color: #dc3545;
    font-size: 1.1rem;
    font-weight: 700;
}

@media (max-width: 768px) {
    .col-md-6 {
        margin-bottom: 1.5rem;
    }

    .event-card {
        aspect-ratio: 1;
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
</script>
@endpush
