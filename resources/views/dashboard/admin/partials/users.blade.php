<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-users me-1"></i>
                Gestion des Utilisateurs
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" id="userSearch" placeholder="Rechercher...">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <select class="form-select" id="userSort">
                    <option value="">Trier par...</option>
                    <option value="date">Date d'inscription</option>
                    <option value="purchases">Achats</option>
                    <option value="role">Rôle</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Inscrit le</th>
                        <th>Achats</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <!-- Loaded dynamically -->
                </tbody>
            </table>
        </div>
        <div id="usersPagination" class="d-flex justify-content-center mt-3">
            <!-- Pagination loaded dynamically -->
        </div>
    </div>
</div>

<!-- Organizer Requests Section -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-user-plus me-1"></i>
            Demandes Organisateur
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Date de demande</th>
                        <th>Motivation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizerRequests ?? collect() as $request)
                        <tr>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->email }}</td>
                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ Str::limit($request->motivation, 50) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm approve-request" data-id="{{ $request->id }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm reject-request" data-id="{{ $request->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune demande d'organisateur en attente</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentPage = 1;

function loadUsers(page = 1, search = '', sort = '') {
    $.get(`{{ route('admin.users') }}?page=${page}&search=${search}&sort=${sort}`, function(response) {
        $('#usersTableBody').empty();
        
        response.data.forEach(user => {
            $('#usersTableBody').append(`
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.roles.map(role => role.name).join(', ')}</td>
                    <td>${new Date(user.created_at).toLocaleDateString()}</td>
                    <td>${user.total_purchases}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary btn-sm view-user" data-id="${user.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm edit-user" data-id="${user.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-user" data-id="${user.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        });

        // Update pagination
        updatePagination(response);
    });
}

function updatePagination(response) {
    const pagination = $('#usersPagination');
    pagination.empty();

    if (response.last_page > 1) {
        let paginationHtml = '<ul class="pagination">';
        
        // Previous page
        paginationHtml += `
            <li class="page-item ${response.current_page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${response.current_page - 1}">Précédent</a>
            </li>
        `;

        // Page numbers
        for (let i = 1; i <= response.last_page; i++) {
            paginationHtml += `
                <li class="page-item ${response.current_page === i ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }

        // Next page
        paginationHtml += `
            <li class="page-item ${response.current_page === response.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${response.current_page + 1}">Suivant</a>
            </li>
        `;

        paginationHtml += '</ul>';
        pagination.html(paginationHtml);
    }
}

// Event Listeners
$('#userSearch').on('input', function() {
    loadUsers(1, $(this).val(), $('#userSort').val());
});

$('#userSort').on('change', function() {
    loadUsers(1, $('#userSearch').val(), $(this).val());
});

$('#usersPagination').on('click', '.page-link', function(e) {
    e.preventDefault();
    const page = $(this).data('page');
    loadUsers(page, $('#userSearch').val(), $('#userSort').val());
});

// Handle organizer requests
$('.approve-request, .reject-request').click(function() {
    const requestId = $(this).data('id');
    const status = $(this).hasClass('approve-request') ? 'approved' : 'rejected';
    
    $.ajax({
        url: `/admin/organizer-requests/${requestId}`,
        type: 'PATCH',
        data: { status: status },
        success: function(response) {
            // Reload the page or update the table
            location.reload();
        }
    });
});

// Initial load
loadUsers();
</script>
@endpush
