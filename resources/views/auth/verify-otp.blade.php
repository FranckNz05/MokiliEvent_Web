@extends('layouts.app')

@section('content')
@php
$breadcrumbs = [
    ['text' => 'Vérification', 'url' => route('verification.notice')]
];
@endphp

@include('layouts.partials.page-header', ['pageTitle' => 'Vérification du compte', 'breadcrumbs' => $breadcrumbs])

<div class="auth-container">
    <div class="auth-card">
        <h2 class="card-title">Vérification par code</h2>

        @if (session('message'))
            <div class="alert alert-info" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <p class="text-center mb-4">
            Nous avons envoyé un code de vérification à votre adresse email :<br>
            <strong>{{ session('email') }}</strong>
        </p>

        <form method="POST" action="{{ route('verification.verify') }}" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <div class="mb-4">
                <label for="otp" class="form-label">Code de vérification</label>
                <input type="text" class="form-control @error('otp') is-invalid @enderror"
                    id="otp" name="otp" required maxlength="6"
                    placeholder="Entrez le code à 6 chiffres">
                @error('otp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Vérifier</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="mb-0">Vous n'avez pas reçu le code ?
                <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <button type="submit" class="btn btn-link p-0">
                        Renvoyer le code
                    </button>
                </form>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');

    otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });
});
</script>
@endpush
@endsection
