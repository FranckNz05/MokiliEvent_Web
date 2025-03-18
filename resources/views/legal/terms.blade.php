@extends('layouts.app')

@section('title', 'Conditions d\'utilisation')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Conditions d'utilisation</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Terms Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="mb-5">
                    <h4 class="mb-3">1. Introduction</h4>
                    <p>Bienvenue sur MokiliEvent. En utilisant notre plateforme, vous acceptez les présentes conditions d'utilisation. Veuillez les lire attentivement.</p>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">2. Définitions</h4>
                    <p>"MokiliEvent" désigne la plateforme de billetterie en ligne accessible via le site web.</p>
                    <p>"Utilisateur" désigne toute personne qui accède et utilise la plateforme.</p>
                    <p>"Organisateur" désigne tout utilisateur qui crée et gère des événements sur la plateforme.</p>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">3. Inscription et compte</h4>
                    <p>Pour utiliser certaines fonctionnalités de notre plateforme, vous devez créer un compte. Vous êtes responsable de maintenir la confidentialité de vos informations de connexion.</p>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">4. Utilisation de la plateforme</h4>
                    <p>En utilisant MokiliEvent, vous vous engagez à :</p>
                    <ul>
                        <li>Fournir des informations exactes et complètes</li>
                        <li>Respecter les droits de propriété intellectuelle</li>
                        <li>Ne pas utiliser la plateforme à des fins illégales</li>
                        <li>Ne pas perturber le fonctionnement de la plateforme</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">5. Événements et billetterie</h4>
                    <p>Les organisateurs sont responsables de :</p>
                    <ul>
                        <li>L'exactitude des informations sur leurs événements</li>
                        <li>La gestion des billets et des accès</li>
                        <li>Le respect des lois et règlements applicables</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">6. Paiements et remboursements</h4>
                    <p>Les transactions sont sécurisées via nos partenaires de paiement. Les conditions de remboursement sont définies par chaque organisateur.</p>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">7. Responsabilités</h4>
                    <p>MokiliEvent agit comme intermédiaire entre les organisateurs et les participants. Nous ne sommes pas responsables du déroulement des événements.</p>
                </div>

                <div class="mb-5">
                    <h4 class="mb-3">8. Modification des conditions</h4>
                    <p>Nous nous réservons le droit de modifier ces conditions à tout moment. Les utilisateurs seront informés des changements importants.</p>
                </div>
            </div>
            <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h3 class="mb-4">Besoin d'aide ?</h3>
                    <p>Notre équipe est là pour répondre à vos questions concernant nos conditions d'utilisation.</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('contact.index') }}">Contactez-nous</a>
                </div>
                <div class="border-start border-5 border-primary ps-4">
                    <h3 class="mb-4">Documents légaux</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="{{ route('legal.privacy') }}"><i class="fa fa-arrow-right text-primary me-2"></i>Politique de confidentialité</a>
                        <a class="text-body mb-2" href="{{ route('faq.index') }}"><i class="fa fa-arrow-right text-primary me-2"></i>FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Terms End -->
@endsection
