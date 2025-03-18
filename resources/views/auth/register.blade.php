@extends('layouts.app')

@section('title', 'Inscription')

@section('styles')
<style>
    .hero-header {
        background-image: linear-gradient(to bottom, #f8f9fa, #ffffff);
        background-size: 100% 300px;
        background-position: 0% 100%;
    }
</style>
@endsection

@section('content')
@php
$breadcrumbs = [
    ['text' => 'Inscription', 'url' => route('auth.register')]
];
@endphp

@include('layouts.partials.page-header', ['pageTitle' => 'Inscription', 'breadcrumbs' => $breadcrumbs])

<div class="auth-container">
    <div class="auth-card">
        <h2 class="card-title">Créer un compte</h2>

        <form method="POST" action="{{ route('auth.register') }}" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom complet</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Numéro de téléphone</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                    id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control"
                    id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </div>

            <div class="text-center mt-4">
                <p class="mb-0">Déjà inscrit ? <a href="{{ route('auth.login') }}" class="text-primary">Se connecter</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('profile_photo');
    const previewContainer = document.getElementById('preview-container');

    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" class="profile-photo-preview" alt="Profile preview">
                `;
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
