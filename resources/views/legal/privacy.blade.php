@extends('layouts.app')

@section('title', 'Politique de confidentialité')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Politique de confidentialité</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Privacy Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="mb-5">
                    <h4 class="mb-3">1. Collecte des données</h4>
                    <p>Nous collectons les informations suivantes :</p>
                    <ul>
                        <li>Informations d'identification (nom, prénom, email)</li>
                        <li>Données de connexion et d'utilisation</li>
                        <li>Informations de paiement (via nos partenaires)</li>
                        <li>Préférences et historique d'événements</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">2. Utilisation des données</h4>
                    <p>Vos données sont utilisées pour :</p>
                    <ul>
                        <li>Gérer votre compte et vos réservations</li>
                        <li>Améliorer nos services</li>
                        <li>Communiquer avec vous</li>
                        <li>Personnaliser votre expérience</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">3. Protection des données</h4>
                    <p>Nous mettons en œuvre des mesures de sécurité pour protéger vos données :</p>
                    <ul>
                        <li>Chiffrement des données sensibles</li>
                        <li>Accès restreint aux données personnelles</li>
                        <li>Surveillance continue de nos systèmes</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">4. Partage des données</h4>
                    <p>Nous partageons vos données uniquement avec :</p>
                    <ul>
                        <li>Les organisateurs des événements que vous réservez</li>
                        <li>Nos partenaires de paiement sécurisés</li>
                        <li>Les autorités en cas d'obligation légale</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">5. Vos droits</h4>
                    <p>Vous disposez des droits suivants :</p>
                    <ul>
                        <li>Accès à vos données personnelles</li>
                        <li>Rectification de vos données</li>
                        <li>Suppression de vos données</li>
                        <li>Opposition au traitement</li>
                        <li>Portabilité des données</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">6. Cookies</h4>
                    <p>Nous utilisons des cookies pour :</p>
                    <ul>
                        <li>Améliorer la navigation</li>
                        <li>Mémoriser vos préférences</li>
                        <li>Analyser l'utilisation du site</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">7. Modifications</h4>
                    <p>Nous nous réservons le droit de modifier cette politique. Les utilisateurs seront informés des changements importants.</p>
                </div>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h3 class="mb-4">Questions sur vos données ?</h3>
                    <p>Pour toute question concernant vos données personnelles, contactez notre délégué à la protection des données.</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('contact.index') }}">Contactez-nous</a>
                </div>
                <div class="border-start border-5 border-primary ps-4">
                    <h3 class="mb-4">Documents légaux</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="{{ route('legal.terms') }}"><i class="fa fa-arrow-right text-primary me-2"></i>Conditions d'utilisation</a>
                        <a class="text-body mb-2" href="{{ route('faq.index') }}"><i class="fa fa-arrow-right text-primary me-2"></i>FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Privacy End -->
@endsection
