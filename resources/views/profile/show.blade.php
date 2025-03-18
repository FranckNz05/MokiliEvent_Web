@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="profile-header py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="profile-photo">
                    @if($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle">
                    @endif
                </div>
            </div>
            <div class="col">
                <h1 class="text-white mb-2">{{ $user->name }}</h1>
                <p class="text-white-50 mb-0">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                    @if($user->email_verified_at)
                        <span class="badge bg-success ms-2">
                            <i class="fas fa-check-circle me-1"></i>Vérifié
                        </span>
                    @else
                        <span class="badge bg-warning ms-2">
                            <i class="fas fa-exclamation-circle me-1"></i>Non vérifié
                        </span>
                    @endif
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ route('profile.edit') }}" class="btn btn-light">
                    <i class="fas fa-edit me-2"></i>Modifier le profil
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <!-- Informations personnelles -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-user text-primary me-2"></i>
                        Informations personnelles
                    </h5>
                    
                    <div class="profile-info">
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Membre depuis</label>
                            <p class="mb-0">
                                <i class="far fa-calendar-alt text-primary me-2"></i>
                                {{ $user->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Rôle</label>
                            <p class="mb-0">
                                <i class="fas fa-user-tag text-primary me-2"></i>
                                {{ $user->roles->pluck('name')->implode(', ') }}
                            </p>
                        </div>
                        
                        @if($user->phone)
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Téléphone</label>
                            <p class="mb-0">
                                <i class="fas fa-phone text-primary me-2"></i>
                                {{ $user->phone }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="col-lg-8">
            <div class="row g-4">
                <!-- Événements créés -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Événements créés</h6>
                                    <h2 class="card-title mb-0">{{ $user->events_count ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billets achetés -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                    <i class="fas fa-ticket-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Billets achetés</h6>
                                    <h2 class="card-title mb-0">{{ $user->tickets_count ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activité récente -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-history text-primary me-2"></i>
                                Activité récente
                            </h5>
                            
                            <div class="timeline">
                                @forelse($user->recent_activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-icon bg-light">
                                        <i class="fas fa-circle text-primary"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <p class="mb-1">{{ $activity->description }}</p>
                                        <small class="text-muted">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                @empty
                                <p class="text-muted text-center mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Aucune activité récente
                                </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.profile-header {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('/images/profile-bg.jpg');
    background-size: cover;
    background-position: center;
    margin-top: -24px;
}

.profile-photo {
    width: 120px;
    height: 120px;
    border: 4px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    overflow: hidden;
}

.profile-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.stats-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-icon {
    position: absolute;
    left: -3rem;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-icon i {
    font-size: 0.5rem;
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    position: relative;
}

.timeline-content::before {
    content: '';
    position: absolute;
    left: -0.5rem;
    top: 1rem;
    width: 1rem;
    height: 1rem;
    background: #f8f9fa;
    transform: rotate(45deg);
}

.info-item label {
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
@endpush
