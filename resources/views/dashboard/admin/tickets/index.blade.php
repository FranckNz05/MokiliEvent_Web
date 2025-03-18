@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestion des tickets</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-ticket-alt me-1"></i>
            Liste des tickets
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Événement</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Vendus</th>
                            <th>Organisateur</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->name }}</td>
                                <td>
                                    <a href="{{ route('events.show', $ticket->event) }}">
                                        {{ $ticket->event->name }}
                                    </a>
                                </td>
                                <td>{{ number_format($ticket->price, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $ticket->quantity }}</td>
                                <td>{{ $ticket->orders->count() }}</td>
                                <td>{{ $ticket->event->user->name }}</td>
                                <td>
                                    @if($ticket->quantity > $ticket->orders->count())
                                        <span class="badge bg-success">Disponible</span>
                                    @else
                                        <span class="badge bg-danger">Épuisé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
