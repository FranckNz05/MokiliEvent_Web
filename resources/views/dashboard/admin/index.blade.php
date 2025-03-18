@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tableau de Bord Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Administration</li>
    </ol>

    <!-- Navigation Pills -->
    <ul class="nav nav-pills mb-4" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill" data-bs-target="#dashboard" type="button" role="tab">
                <i class="fas fa-tachometer-alt me-1"></i>
                Tableau de Bord
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="users-tab" data-bs-toggle="pill" data-bs-target="#users" type="button" role="tab">
                <i class="fas fa-users me-1"></i>
                Utilisateurs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="events-tab" data-bs-toggle="pill" data-bs-target="#events" type="button" role="tab">
                <i class="fas fa-calendar-alt me-1"></i>
                Événements
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tickets-tab" data-bs-toggle="pill" data-bs-target="#tickets" type="button" role="tab">
                <i class="fas fa-ticket-alt me-1"></i>
                Tickets
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="blogs-tab" data-bs-toggle="pill" data-bs-target="#blogs" type="button" role="tab">
                <i class="fas fa-blog me-1"></i>
                Articles
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="adminTabsContent">
        <!-- Dashboard -->
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-subtitle mb-1">Utilisateurs</h6>
                                    <h3 class="card-title mb-0">{{ number_format($stats['total_users'] ?? 0) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-calendar-check fa-2x text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-subtitle mb-1">Événements</h6>
                                    <h3 class="card-title mb-0">{{ number_format($stats['total_events'] ?? 0) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-ticket-alt fa-2x text-warning"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-subtitle mb-1">Tickets vendus</h6>
                                    <h3 class="card-title mb-0">{{ number_format($stats['total_tickets_sold'] ?? 0) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-subtitle mb-1">Revenus</h6>
                                    <h3 class="card-title mb-0">{{ number_format($stats['revenue'] ?? 0, 2) }} FCFA</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('dashboard.admin.partials.dashboard')
        </div>

        <!-- Users -->
        <div class="tab-pane fade" id="users" role="tabpanel">
            @include('dashboard.admin.partials.users')
        </div>

        <!-- Events -->
        <div class="tab-pane fade" id="events" role="tabpanel">
            @include('dashboard.admin.partials.events')
        </div>

        <!-- Tickets -->
        <div class="tab-pane fade" id="tickets" role="tabpanel">
            @include('dashboard.admin.partials.tickets')
        </div>

        <!-- Blogs -->
        <div class="tab-pane fade" id="blogs" role="tabpanel">
            @include('dashboard.admin.partials.blogs')
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.nav-pills .nav-link {
    color: #6c757d;
    background-color: transparent;
    border: 1px solid #dee2e6;
    margin-right: 0.5rem;
}

.nav-pills .nav-link.active {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.nav-pills .nav-link:hover:not(.active) {
    background-color: #f8f9fa;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
}

.card .card-header {
    font-weight: 500;
}

.table > :not(caption) > * > * {
    padding: 1rem 1rem;
}

.btn-group > .btn {
    padding: 0.25rem 0.5rem;
}

.pagination {
    margin-bottom: 0;
}
</style>
@endpush

@push('scripts')
<script>
// Persist active tab
$(document).ready(function() {
    // Get active tab from localStorage
    const activeTab = localStorage.getItem('adminActiveTab');
    if (activeTab) {
        // Show the active tab
        const tab = new bootstrap.Tab(document.querySelector(activeTab));
        tab.show();
    }

    // Store the active tab in localStorage
    $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('adminActiveTab', '#' + e.target.id);
    });
});
</script>
@endpush
