@extends('layouts.app')

@section('content')
<!-- Header Section Start -->
<div class="container-fluid bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white">
                <h1 class="display-4 fw-bold">Nos Organisateurs</h1>
                <p class="lead mb-0">Découvrez les organisateurs qui font vivre notre plateforme</p>
            </div>
        </div>
    </div>
</div>
<!-- Header Section End -->

<!-- Organizers List Start -->
<div class="container py-5">
    <div class="row g-4">
        @forelse($organizers as $organizer)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <!-- Banner Image -->
                        @if($organizer->banner_image)
                            <div class="rounded-3 mb-4 overflow-hidden" style="height: 100px;">
                                <img src="{{ asset('storage/' . $organizer->banner_image) }}" alt="Banner" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="position-relative mb-4" style="margin-top: {{ $organizer->banner_image ? '-50px' : '0' }}">
                            <div class="mx-auto rounded-circle overflow-hidden border border-4 border-white" style="width: 100px; height: 100px;">
                                @if($organizer->logo)
                                    <img src="{{ asset('storage/' . $organizer->logo) }}" alt="{{ $organizer->company_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="bg-primary w-100 h-100 d-flex align-items-center justify-content-center">
                                        <span class="text-white display-4">{{ substr($organizer->company_name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Company Info -->
                        <h5 class="card-title mb-2">{{ $organizer->company_name }}</h5>
                        @if($organizer->slogan)
                            <p class="text-muted small mb-3">{{ $organizer->slogan }}</p>
                        @endif

                        <!-- Stats -->
                        <div class="d-flex justify-content-center gap-4 mb-4">
                            <div class="text-center">
                                <h6 class="mb-0">{{ $organizer->followers_count }}</h6>
                                <small class="text-muted">Abonnés</small>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0">{{ $organizer->events_count }}</h6>
                                <small class="text-muted">Événements</small>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('organizers.show', $organizer) }}" class="btn btn-outline-primary rounded-pill">
                                <i class="fas fa-eye me-2"></i>Voir le profil
                            </a>
                            @auth
                                @if(auth()->user()->id !== $organizer->user_id)
                                    @if(auth()->user()->isFollowing($organizer))
                                        <form action="{{ route('organizers.unfollow', $organizer) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger rounded-pill"
                                                onclick="return confirm('Êtes-vous sûr de vouloir vous désabonner de {{ $organizer->company_name }} ?')">
                                                <i class="fas fa-user-minus me-2"></i>Ne plus suivre
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('organizers.follow', $organizer) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary rounded-pill">
                                                <i class="fas fa-user-plus me-2"></i>Suivre
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('auth.login') }}" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-user-plus me-2"></i>Suivre
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Aucun organisateur trouvé.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $organizers->links() }}
    </div>
</div>
<!-- Organizers List End -->
@endsection
