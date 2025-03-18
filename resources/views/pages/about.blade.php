@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12">
                <h1 class="mb-4 display-3 text-white">À Propos de MokiliEvent</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- About Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="rounded overflow-hidden">
                    <img src="{{ asset('images/about.jpg') }}" class="img-fluid" alt="À propos de MokiliEvent">
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 mb-4">La Référence des Événements au Congo</h1>
                <p class="mb-4">MokiliEvent est la première plateforme d'événements au Congo-Brazzaville, facilitant la découverte et la participation aux meilleurs événements du pays.</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-users fa-2x text-primary me-3"></i>
                            <h5 class="mb-0">Communauté Active</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check fa-2x text-primary me-3"></i>
                            <h5 class="mb-0">Événements Vérifiés</h5>
                        </div>
                    </div>
                </div>
                <p class="mb-4">Notre mission est de connecter les organisateurs d'événements avec leur public cible, tout en offrant une expérience utilisateur exceptionnelle.</p>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-shield-alt fa-2x text-primary me-3"></i>
                            <h5 class="mb-0">Paiements Sécurisés</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-headset fa-2x text-primary me-3"></i>
                            <h5 class="mb-0">Support 24/7</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Team Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <h1 class="display-5 mb-0">Notre Équipe</h1>
            <hr class="w-25 mx-auto bg-primary">
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('images/team-1.jpg') }}" alt="">
                    </div>
                    <div class="team-text">
                        <div class="bg-light">
                            <h5 class="fw-bold mb-0">Jean Doe</h5>
                            <small>CEO & Fondateur</small>
                        </div>
                        <div class="bg-primary">
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('images/team-2.jpg') }}" alt="">
                    </div>
                    <div class="team-text">
                        <div class="bg-light">
                            <h5 class="fw-bold mb-0">Marie Doe</h5>
                            <small>Directrice Marketing</small>
                        </div>
                        <div class="bg-primary">
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('images/team-3.jpg') }}" alt="">
                    </div>
                    <div class="team-text">
                        <div class="bg-light">
                            <h5 class="fw-bold mb-0">Pierre Doe</h5>
                            <small>Développeur</small>
                        </div>
                        <div class="bg-primary">
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('images/team-4.jpg') }}" alt="">
                    </div>
                    <div class="team-text">
                        <div class="bg-light">
                            <h5 class="fw-bold mb-0">Sophie Doe</h5>
                            <small>Support Client</small>
                        </div>
                        <div class="bg-primary">
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team End -->
@endsection
