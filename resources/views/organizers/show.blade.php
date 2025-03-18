@extends('layouts.app')

@section('content')
<!-- Banner Section Start -->
<div class="position-relative">
    @if($organizer->banner_image)
        <div class="banner-image" style="height: 300px; background-image: url('{{ asset('storage/' . $organizer->banner_image) }}'); background-size: cover; background-position: center;">
            <div class="overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5);"></div>
        </div>
    @else
        <div class="banner-image bg-primary" style="height: 300px;">
            <div class="overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.2);"></div>
        </div>
    @endif
</div>
<!-- Banner Section End -->

<!-- Organizer Info Section Start -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Profile Card -->
            <div class="card border-0 shadow-sm mt-n5 position-relative z-1">
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Logo -->
                        <div class="mx-auto rounded-circle overflow-hidden mb-4 position-relative" style="width: 150px; height: 150px; margin-top: -100px;">
                            @if($organizer->logo)
                                <img src="{{ asset('storage/' . $organizer->logo) }}" alt="{{ $organizer->company_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="bg-primary w-100 h-100 d-flex align-items-center justify-content-center">
                                    <span class="text-white display-4">{{ substr($organizer->company_name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Company Info -->
                        <h2 class="mb-3">{{ $organizer->company_name }}</h2>
                        @if($organizer->slogan)
                            <p class="text-muted mb-4">{{ $organizer->slogan }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="d-flex justify-content-center gap-4 mb-4">
                            <div class="text-center">
                                <h4 class="mb-0">{{ $organizer->followers_count }}</h4>
                                <small class="text-muted">Abonnés</small>
                            </div>
                            <div class="text-center">
                                <h4 class="mb-0">{{ $organizer->events_count }}</h4>
                                <small class="text-muted">Événements</small>
                            </div>
                        </div>

                        <!-- Follow Button -->
                        @auth
                            @if(auth()->user()->id !== $organizer->user_id)
                                <div class="mb-4">
                                    @if(auth()->user()->isFollowing($organizer))
                                        <form action="{{ route('organizers.unfollow', $organizer) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4"
                                                onclick="return confirm('Êtes-vous sûr de vouloir vous désabonner de {{ $organizer->company_name }} ?')">
                                                <i class="fas fa-user-minus me-2"></i>Ne plus suivre
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('organizers.follow', $organizer) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                <i class="fas fa-user-plus me-2"></i>Suivre
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="mb-4">
                                <a href="{{ route('auth.login') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-user-plus me-2"></i>Suivre
                                </a>
                            </div>
                        @endauth

                        <!-- Social Media -->
                        @if($organizer->social_media)
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                @foreach($organizer->social_media as $platform => $url)
                                    <a href="{{ $url }}" target="_blank" class="text-muted hover-primary">
                                        <i class="fab fa-{{ $platform }} fa-lg"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Contact Info -->
                        <div class="row justify-content-center mb-4">
                            @if($organizer->email)
                                <div class="col-auto">
                                    <p class="mb-0"><i class="fas fa-envelope me-2"></i>{{ $organizer->email }}</p>
                                </div>
                            @endif
                            @if($organizer->phone_primary)
                                <div class="col-auto">
                                    <p class="mb-0"><i class="fas fa-phone me-2"></i>{{ $organizer->phone_primary }}</p>
                                </div>
                            @endif
                            @if($organizer->website)
                                <div class="col-auto">
                                    <p class="mb-0"><i class="fas fa-globe me-2"></i>{{ $organizer->website }}</p>
                                </div>
                            @endif
                        </div>

                        @if($organizer->description)
                            <div class="mb-4">
                                <p class="text-muted">{{ $organizer->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Events Section -->
            <div class="mt-5">
                <h3 class="mb-4">Événements</h3>
                @forelse($events as $event)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid rounded-start" alt="{{ $event->title }}" style="height: 100%; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title mb-1">{{ $event->title }}</h5>
                                        <span class="badge bg-{{ $event->status === 'upcoming' ? 'success' : 'secondary' }}">
                                            {{ $event->status === 'upcoming' ? 'À venir' : 'Passé' }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-2">
                                        <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y H:i') }}
                                    </p>
                                    <p class="card-text mb-2">{{ Str::limit($event->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            Voir plus
                                        </a>
                                        <span class="text-muted small">
                                            <i class="fas fa-ticket-alt me-1"></i>À partir de {{ number_format($event->min_price, 0, ',', ' ') }} FCFA
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted mb-0">Aucun événement à afficher pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- Blog Posts Section -->
            @if($blogPosts && $blogPosts->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4">Articles de blog</h3>
                    <div class="row g-4">
                        @foreach($blogPosts as $post)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="text-muted small mb-2">
                                            <i class="far fa-calendar-alt me-2"></i>{{ $post->created_at->format('d M Y') }}
                                        </p>
                                        <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                                        <a href="{{ route('blogs.show', $post) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            Lire la suite
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Organizer Info Section End -->
@endsection

@push('styles')
<style>
.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
@endpush
