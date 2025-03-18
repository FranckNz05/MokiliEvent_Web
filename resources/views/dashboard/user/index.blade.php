@extends('layouts.app')

@section('title', 'Mon compte')

@section('content')
<div class="container-xxl py-5" style="margin-top: 4rem;">
    <div class="container">
        <div class="row g-5">
            <!-- User Profile -->
            <div class="col-lg-4">
                <div class="card border-0 bg-light shadow-sm mb-4">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="rounded-circle"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                     style="width: 100px; height: 100px; margin: 0 auto;">
                                    <span class="text-white h3 mb-0">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h5 class="card-title">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-4">{{ Auth::user()->email }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                Modifier le profil
                            </a>
                            @if(!Auth::user()->hasRole('organizer'))
                                <a href="{{ route('organizer-request.create') }}" class="btn btn-outline-primary">
                                    Devenir organisateur
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card border-0 bg-light shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Statistiques</h6>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Billets achetés</span>
                            <span class="fw-bold">{{ $stats['tickets_count'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Événements participés</span>
                            <span class="fw-bold">{{ $stats['events_attended'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total dépensé</span>
                            <span class="fw-bold">{{ number_format($stats['total_spent'], 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Upcoming Events -->
                <div class="card border-0 bg-light shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Mes prochains événements</h5>
                            <a href="{{ route('tickets.my-tickets') }}" class="btn btn-link">Voir tous mes billets</a>
                        </div>

                        @forelse($upcomingEvents as $event)
                            <div class="d-flex align-items-center border-bottom py-3">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}"
                                         alt="{{ $event->title }}"
                                         class="rounded"
                                         style="width: 48px; height: 48px; object-fit: cover;">
                                @else
                                    <div class="rounded bg-secondary d-flex align-items-center justify-content-center"
                                         style="width: 48px; height: 48px;">
                                        <i class="bi bi-calendar-event text-white"></i>
                                    </div>
                                @endif

                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $event->title }}</h6>
                                    <p class="small text-muted mb-0">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $event->start_date->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                <a href="{{ route('events.show', $event) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Voir détails
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Vous n'avez pas encore de billets pour des événements à venir.</p>
                                <a href="{{ route('events.index') }}" class="btn btn-primary mt-3">Découvrir les événements</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card border-0 bg-light shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Mes dernières commandes</h5>
                            <a href="{{ route('orders.index') }}" class="btn btn-link">Voir toutes mes commandes</a>
                        </div>

                        @forelse($orders as $order)
                            <div class="d-flex align-items-center border-bottom py-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Commande #{{ $order->order_number }}</h6>
                                    <p class="small text-muted mb-0">
                                        {{ $order->created_at->format('d/m/Y H:i') }} -
                                        {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
                                    </p>
                                </div>
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                    {{ $order->status === 'completed' ? 'Payée' : 'En attente' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Vous n'avez pas encore effectué de commande.</p>
                                <a href="{{ route('events.index') }}" class="btn btn-primary mt-3">Découvrir les événements</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Orders -->
                <div class="col-lg-8">
                    <div class="card border-0 bg-light shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Mes commandes</h5>
                            <ul class="list-group">
                                @foreach($orders as $order)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Commande #{{ $order->id }}</span>
                                        <span class="badge bg-primary rounded-pill">{{ $order->status }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-grid mt-3">
                                <a href="{{ route('orders.index') }}" class="btn btn-link">Voir toutes mes commandes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
