@extends('layouts.app')

@section('title', 'À propos de MokiliEvent')

@section('content')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="about-img position-relative overflow-hidden p-5 pe-0">
                    <img class="img-fluid w-100" src="{{ asset('images/logo.png') }}" alt="À propos de MokiliEvent">
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <h1 class="display-5 mb-4">Votre partenaire de confiance pour tous vos événements</h1>
                <p class="mb-4">MokiliEvent est la première plateforme de billetterie en ligne au Congo, dédiée à simplifier l'organisation et la participation aux événements.</p>
                <p class="mb-4">Notre mission est de connecter les organisateurs d'événements avec leur public, en offrant une expérience utilisateur exceptionnelle et des outils innovants.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Billetterie en ligne sécurisée</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Paiement mobile intégré</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Support client 24/7</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Outils de promotion</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Statistiques en temps réel</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Gestion des événements</p>
                    </div>
                </div>
                <a class="btn btn-primary py-3 px-5 mt-2" href="{{ route('contact.index') }}">En savoir plus</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Feature Start -->
<div class="container-fluid bg-light bg-icon my-5 py-6">
    <div class="container">
        <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h1 class="display-5 mb-3">Pourquoi nous choisir ?</h1>
            <p>Découvrez les avantages qui font de MokiliEvent la plateforme de référence pour vos événements.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <img class="img-fluid mb-4" src="{{ asset('img/icon-1.png') }}" alt="Facilité d'utilisation">
                    <h4 class="mb-3">Facilité d'utilisation</h4>
                    <p class="mb-4">Interface intuitive pour créer, gérer et promouvoir vos événements en quelques clics.</p>
                    <a class="btn btn-outline-primary border-2 py-2 px-4 rounded-pill" href="{{ route('auth.register') }}">Commencer</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <img class="img-fluid mb-4" src="{{ asset('img/icon-2.png') }}" alt="Paiement sécurisé">
                    <h4 class="mb-3">Paiement sécurisé</h4>
                    <p class="mb-4">Transactions sécurisées avec support des paiements mobiles et cartes bancaires.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary">Découvrir nos événements</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <img class="img-fluid mb-4" src="{{ asset('img/icon-3.png') }}" alt="Support client">
                    <h4 class="mb-3">Support client</h4>
                    <p class="mb-4">Une équipe dédiée pour vous accompagner à chaque étape de votre projet.</p>
                    <a class="btn btn-primary" href="{{ route('contact.index') }}">Nous contacter</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

    <div class="container">
        <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p>Une équipe passionnée et expérimentée pour faire de vos événements un succès.</p>
        </div>
    </div>
</div>
@endsection
