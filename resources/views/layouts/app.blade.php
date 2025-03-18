<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'MokiliEvent'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="MokiliEvent">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">
                         Événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">
                         Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about.index') }}">
                         À propos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                         Contact
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.register') }}">Inscription</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default-avatar.png') }}"
                                     alt="Photo de profil"
                                     class="rounded-circle me-2"
                                     style="width: 32px; height: 32px; object-fit: cover;">
                                <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="fas fa-user me-2"></i>Mon profil
                                </a></li>
                                <li><a href="{{ route('profile.tickets') }}" class="dropdown-item">
                                    <i class="fas fa-ticket-alt me-2"></i>Mes billets
                                </a></li>
                                @if(auth()->user()->hasRole('organizer'))
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a href="{{ route('organizer.dashboard') }}" class="dropdown-item">
                                        <i class="fas fa-chart-line me-2"></i>Tableau de bord
                                    </a></li>
                                @endif
                                @if(auth()->user()->hasRole('admin'))
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <i class="fas fa-cog me-2"></i>Administration
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    @section('page_header')
    @include('layouts.partials.page-header')
    @endsection

    <!-- Main Content -->
    <main class="animate-fade-in">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>À propos de MokiliEvent</h5>
                    <p>La plateforme de référence pour tous vos événements en République du Congo et ailleurs.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('events.index') }}" class="text-white">Événements</a></li>
                        <li><a href="{{ route('blogs.index') }}" class="text-white">Blog</a></li>
                        <li><a href="{{ route('organizers.index') }}" class="text-white">Organisateurs</a></li>
                        <li><a href="{{ route('about.index') }}" class="text-white">A propos</a></li>
                        <li><a href="{{ route('contact.index') }}" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Suivez-nous</h5>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4 border-top">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} MokiliEvent. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="{{ route('legal.terms') }}" class="text-white me-3">Conditions d'utilisation</a>
                    <a href="{{ route('legal.privacy') }}" class="text-white">Politique de confidentialité</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
