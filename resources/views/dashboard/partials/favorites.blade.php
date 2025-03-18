<!-- Favoris -->
<div class="tab-pane fade" id="favorites">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Mes événements favoris</h4>
            @if($favorites->count() > 0)
                <div class="row g-4">
                    @foreach($favorites as $favorite)
                        <div class="col-md-6">
                            <div class="card">
                                <img src="{{ asset($favorite->event->image) }}" 
                                     class="card-img-top" alt="{{ $favorite->event->title }}"
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $favorite->event->title }}</h5>
                                    <p class="card-text">
                                        <i class="far fa-calendar-alt text-primary me-2"></i>
                                        {{ $favorite->event->start_date->format('d M Y') }}
                                    </p>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        {{ $favorite->event->adresse }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('events.show', $favorite->event) }}" 
                                           class="btn btn-primary">
                                            Voir l'événement
                                        </a>
                                        <form action="{{ route('events.unfavorite', $favorite->event) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-heart-broken"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $favorites->links() }}
            @else
                <div class="alert alert-info">
                    Vous n'avez pas encore d'événements favoris.
                </div>
            @endif
        </div>
    </div>
</div>
