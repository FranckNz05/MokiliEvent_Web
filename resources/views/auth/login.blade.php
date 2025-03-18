@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container py-5">
    <h2>Connexion</h2>
    <form method="POST" action="{{ route('auth.login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Adresse email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">Vous n'avez pas de compte ? <a href="{{ route('auth.register') }}" class="text-primary">Inscrivez-vous</a></p>
        </div>
    </form>
</div>
@endsection
