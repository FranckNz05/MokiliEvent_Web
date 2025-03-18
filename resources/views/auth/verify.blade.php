@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex flex-column">
    <div class="row justify-content-center flex-grow-1 align-items-center py-5">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Vérification de votre adresse email') }}</h4>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
                        <p class="lead">{{ __('Pour continuer, veuillez vérifier votre boîte email et cliquer sur le lien de vérification.') }}</p>
                        <p class="text-muted">La page se rafraîchira automatiquement dans <span id="countdown">30</span> secondes</p>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __("Si vous n'avez pas reçu l'email :") }}
                        <ul class="mb-0 mt-2">
                            <li>Vérifiez votre dossier spam</li>
                            <li>
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-primary">
                                        {{ __('Cliquez ici pour recevoir un nouveau lien') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted small">
                            <i class="fas fa-clock me-2"></i>
                            {{ __("Le lien de vérification expire après 30 minutes.") }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = 30;
    const countdownElement = document.getElementById('countdown');
    
    const countdown = setInterval(function() {
        timeLeft--;
        countdownElement.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdown);
            window.location.reload();
        }
    }, 1000);
});
</script>
@endpush
