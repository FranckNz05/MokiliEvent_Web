@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Vérification de l'adresse e-mail</div>

                <div class="card-body">
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
                        </div>
                    @endif

                    Avant de continuer, veuillez vérifier votre e-mail pour un lien de vérification.
                    Si vous n'avez pas reçu l'e-mail,
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            cliquez ici pour en demander un autre
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
