<!-- Stats Cards -->
<div class="row">
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Utilisateurs</h6>
                        <h4 class="mt-2 mb-0">{{ number_format($stats['total_users'] ?? 0) }}</h4>
                    </div>
                    <div class="avatar avatar-lg rounded bg-white bg-opacity-10">
                        <i class="fas fa-users fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small>
                        <i class="fas fa-user-tie me-1"></i>
                        {{ number_format($stats['total_organizers'] ?? 0) }} Organisateurs
                    </small>
                    <small class="ms-2">
                        <i class="fas fa-user me-1"></i>
                        {{ number_format($stats['total_clients'] ?? 0) }} Clients
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Événements</h6>
                        <h4 class="mt-2 mb-0">{{ number_format($stats['total_events'] ?? 0) }}</h4>
                    </div>
                    <div class="avatar avatar-lg rounded bg-white bg-opacity-10">
                        <i class="fas fa-calendar-check fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small>
                        <i class="fas fa-eye me-1"></i>
                        {{ number_format($stats['total_views'] ?? 0) }} Vues totales
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Tickets</h6>
                        <h4 class="mt-2 mb-0">{{ number_format($stats['total_tickets_sold'] ?? 0) }}</h4>
                    </div>
                    <div class="avatar avatar-lg rounded bg-white bg-opacity-10">
                        <i class="fas fa-ticket-alt fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small>
                        <i class="fas fa-chart-line me-1"></i>
                        {{ round(($stats['total_tickets_sold'] ?? 0 / max($stats['total_events'] ?? 0, 1)) * 100, 1) }}% Taux de vente
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Revenus</h6>
                        <h4 class="mt-2 mb-0">{{ number_format($stats['revenue'] ?? 0) }} FCFA</h4>
                    </div>
                    <div class="avatar avatar-lg rounded bg-white bg-opacity-10">
                        <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small>
                        <i class="fas fa-calculator me-1"></i>
                        {{ number_format(($stats['revenue'] ?? 0) / max($stats['total_tickets_sold'] ?? 0, 1)) }} FCFA/ticket
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <div class="col-xl-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-line me-1"></i>
                Évolution des Ventes et Revenus
            </div>
            <div class="card-body">
                <canvas id="salesChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-chart-pie me-1"></i>
                Événements par Catégorie
            </div>
            <div class="card-body">
                <canvas id="categoryChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-list me-1"></i>
        Activité Récente
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Événements Populaires</h5>
                <div class="list-group">
                    @forelse($popularEvents ?? collect() as $event)
                        <a href="{{ route('events.show', $event) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $event->title }}</h6>
                                <small>{{ number_format($event->tickets_sold ?? 0) }} tickets</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $event->user->name ?? 'N/A' }}
                                </small>
                                <small class="text-success">{{ number_format($event->revenue ?? 0) }} FCFA</small>
                            </div>
                        </a>
                    @empty
                        <div class="text-muted">Aucun événement à afficher</div>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3">Articles Populaires</h5>
                <div class="list-group">
                    @forelse($popularBlogs ?? collect() as $blog)
                        <a href="{{ route('blogs.show', $blog) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $blog->title }}</h6>
                                <small>{{ number_format($blog->views ?? 0) }} vues</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $blog->user->name ?? 'N/A' }}
                                </small>
                                <small>
                                    <i class="fas fa-heart text-danger me-1"></i>{{ $blog->likes_count ?? 0 }}
                                    <i class="fas fa-comment text-primary ms-2 me-1"></i>{{ $blog->comments_count ?? 0 }}
                                </small>
                            </div>
                        </a>
                    @empty
                        <div class="text-muted">Aucun article à afficher</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.list-group-item {
    transition: all 0.2s;
}

.list-group-item:hover {
    transform: translateX(5px);
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyStats['labels'] ?? []) !!},
        datasets: [{
            label: 'Ventes',
            data: {!! json_encode($monthlyStats['sales'] ?? []) !!},
            borderColor: 'rgba(0, 123, 255, 1)',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Revenus (FCFA)',
            data: {!! json_encode($monthlyStats['revenue'] ?? []) !!},
            borderColor: 'rgba(40, 167, 69, 1)',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true,
            yAxisID: 'revenue'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Nombre de ventes'
                }
            },
            revenue: {
                position: 'right',
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Revenus (FCFA)'
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        },
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart');
new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($categoryStats['labels'] ?? []) !!},
        datasets: [{
            data: {!! json_encode($categoryStats['counts'] ?? []) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>
@endpush
