@extends('layouts.app')

@section('title', 'Demande d’organisateur')

@section('content')
<div class="container py-5">
    <h2>Demande pour devenir organisateur</h2>
    <form action="{{ route('organizer.request.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="company_name" class="form-label">Nom de l'entreprise *</label>
            <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" required>
            @error('company_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_primary" class="form-label">Téléphone principal *</label>
            <input type="text" name="phone_primary" id="phone_primary" class="form-control @error('phone_primary') is-invalid @enderror" required>
            @error('phone_primary')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Adresse *</label>
            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" required>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Soumettre la demande</button>
    </form>
</div>
@endsection
