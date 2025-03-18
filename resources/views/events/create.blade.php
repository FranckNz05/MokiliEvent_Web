@extends('layouts.app')

@section('title', 'Créer un événement')

@section('content')
<x-page-header title="Créer un événement" />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">Créer un nouvel événement</h2>

                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Informations de base -->
                        <div class="mb-4">
                            <h4 class="mb-3">Informations de base</h4>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre de l'événement *</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea name="description" id="description" rows="5" 
                                          class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Catégorie *</label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image de l'événement *</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date et heure -->
                        <div class="mb-4">
                            <h4 class="mb-3">Date et heure</h4>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Date de début *</label>
                                    <input type="datetime-local" name="start_date" id="start_date" 
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">Date de fin *</label>
                                    <input type="datetime-local" name="end_date" id="end_date" 
                                           class="form-control @error('end_date') is-invalid @enderror"
                                           value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="mb-4">
                            <h4 class="mb-3">Localisation</h4>
                            
                            <div class="mb-3">
                                <label for="location" class="form-label">Adresse de l'événement *</label>
                                <input type="text" name="location" id="location" 
                                       class="form-control @error('location') is-invalid @enderror"
                                       value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" 
                                       class="form-control @error('latitude') is-invalid @enderror"
                                       value="{{ old('latitude') }}">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" 
                                       class="form-control @error('longitude') is-invalid @enderror"
                                       value="{{ old('longitude') }}">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Type d'événement -->
                        <div class="mb-4">
                            <h4 class="mb-3">Type d'événement</h4>
                            
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="is_free" id="is_free_true" value="1" 
                                           class="form-check-input @error('is_free') is-invalid @enderror"
                                           {{ old('is_free') == '1' ? 'checked' : '' }}>
                                    <label for="is_free_true" class="form-check-label">Gratuit</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="is_free" id="is_free_false" value="0" 
                                           class="form-check-input @error('is_free') is-invalid @enderror"
                                           {{ old('is_free') == '0' ? 'checked' : '' }}>
                                    <label for="is_free_false" class="form-check-label">Payant</label>
                                </div>
                                @error('is_free')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Réservations -->
                        <div class="mb-4">
                            <h4 class="mb-3">Réservations</h4>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="allow_reservation" id="allow_reservation" 
                                           class="form-check-input @error('allow_reservation') is-invalid @enderror"
                                           {{ old('allow_reservation') ? 'checked' : '' }}>
                                    <label for="allow_reservation" class="form-check-label">Autoriser les réservations</label>
                                </div>
                                @error('allow_reservation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="reservation_deadline_container" style="display: none;">
                                <label for="reservation_deadline" class="form-label">Date limite de réservation</label>
                                <input type="datetime-local" name="reservation_deadline" id="reservation_deadline" 
                                       class="form-control @error('reservation_deadline') is-invalid @enderror"
                                       value="{{ old('reservation_deadline') }}">
                                @error('reservation_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Créer l'événement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const allowReservationCheckbox = document.getElementById('allow_reservation');
    const reservationDeadlineContainer = document.getElementById('reservation_deadline_container');

    function toggleReservationDeadline() {
        reservationDeadlineContainer.style.display = allowReservationCheckbox.checked ? 'block' : 'none';
    }

    allowReservationCheckbox.addEventListener('change', toggleReservationDeadline);
    toggleReservationDeadline();
});
</script>
@endpush
@endsection
