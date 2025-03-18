@extends('layouts.app')

@section('title', 'Devenir Organisateur')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 mx-auto">
                <div class="bg-light rounded p-4">
                    <h2 class="mb-4">Devenir Organisateur</h2>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('organizer-request.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Nom de l'entreprise</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                   id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company_address" class="form-label">Adresse de l'entreprise</label>
                            <input type="text" class="form-control @error('company_address') is-invalid @enderror" 
                                   id="company_address" name="company_address" value="{{ old('company_address') }}" required>
                            @error('company_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company_phone" class="form-label">Téléphone de l'entreprise</label>
                            <input type="tel" class="form-control @error('company_phone') is-invalid @enderror" 
                                   id="company_phone" name="company_phone" value="{{ old('company_phone') }}" required>
                            @error('company_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="company_email" class="form-label">Email de l'entreprise</label>
                            <input type="email" class="form-control @error('company_email') is-invalid @enderror" 
                                   id="company_email" name="company_email" value="{{ old('company_email') }}" required>
                            @error('company_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description de votre activité</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="5" required 
                                    placeholder="Décrivez votre activité, votre expérience dans l'organisation d'événements, et pourquoi vous souhaitez devenir organisateur (minimum 100 caractères)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="documents" class="form-label">Documents justificatifs (optionnel)</label>
                            <input type="file" class="form-control @error('documents.*') is-invalid @enderror" 
                                   id="documents" name="documents[]" multiple accept=".pdf,.doc,.docx">
                            <small class="text-muted">Vous pouvez télécharger plusieurs documents (PDF, DOC, DOCX - max 2MB chacun)</small>
                            @error('documents.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Soumettre la demande</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
