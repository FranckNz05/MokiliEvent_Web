@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Modifier le ticket</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-ticket-alt me-1"></i>
            Édition du ticket pour l'événement {{ $ticket->event->name }}
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du ticket</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $ticket->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Prix (FCFA)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $ticket->price) }}" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantité disponible</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $ticket->quantity) }}" min="0" required>
                    <div class="form-text">
                        Tickets déjà vendus : {{ $ticket->orders->count() }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $ticket->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.tickets') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
