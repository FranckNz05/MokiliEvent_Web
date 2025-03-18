@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Événements à {{ $ville }}</h1>

            @if($events->count() > 0)
                <div class="row g-4">
                    @foreach($events as $event)
                        <div class="col-md-6 col-lg-4">
                            <div class="card event-card border-0 shadow-sm h-100">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="badge bg-danger position-absolute top-0 end-0 m-3">{{ $event->category->name }}</div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-truncate">{{ $event->title }}</h5>
                                    <div class="d-flex justify-content-between text-muted small mb-3">
                                        <span><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                                        <span><i class="fas fa-ticket-alt"></i> {{ number_format($event->price, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>{{ $event->ville }}, {{ $event->pays }}
                                    </p>
                                    <p class="card-text text-truncate">{{ Str::limit($event->description, 100) }}</p>
                                    <a href="{{ route('events.show', $event->slug) }}" class="btn btn-danger btn-sm rounded-pill">Voir plus</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Aucun événement n'est actuellement disponible à {{ $ville }}.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
