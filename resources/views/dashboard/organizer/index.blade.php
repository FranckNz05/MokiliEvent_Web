@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('organizer.dashboard') }}">
                            <i class="fas fa-home"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar"></i> Mes événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-ticket-alt"></i> Tickets vendus
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-line"></i> Statistiques
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de bord Organisateur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Créer un événement
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Événements</h5>
                            <p class="card-text display-6">{{ $stats['events_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Tickets vendus</h5>
                            <p class="card-text display-6">{{ $stats['tickets_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Revenus</h5>
                            <p class="card-text display-6">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} €</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Participants</h5>
                            <p class="card-text display-6">{{ $stats['participants_count'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3>Événements à venir</h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Événement</th>
                                    <th>Date</th>
                                    <th>Lieu</th>
                                    <th>Tickets vendus</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events ?? [] as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->start_date }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ $event->tickets_sold }} / {{ $event->tickets_available }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucun événement à venir</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3>Ventes récentes</h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Événement</th>
                                    <th>Tickets</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales ?? [] as $sale)
                                    <tr>
                                        <td>{{ $sale->created_at }}</td>
                                        <td>{{ $sale->customer_name }}</td>
                                        <td>{{ $sale->event_title }}</td>
                                        <td>{{ $sale->tickets_count }}</td>
                                        <td>{{ number_format($sale->amount, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucune vente récente</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
