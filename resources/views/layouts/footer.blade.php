<!-- Footer Start -->
<footer class="container-fluid bg-primary footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Section À propos -->
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">À propos</h4>
                <p class="text-white">
                    MokiliEvent est la plateforme de référence pour tous vos événements en République Démocratique du Congo. Découvrez, réservez et profitez d'événements inoubliables en toute simplicité.
                </p>
                <div class="d-flex pt-3">
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Section Liens rapides -->
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Liens rapides</h4>
                <ul class="list-unstyled">
                    <li><a class="btn btn-link text-white" href="{{ route('about.index') }}">À propos</a></li>
                    <li><a class="btn btn-link text-white" href="{{ route('contact.index') }}">Contact</a></li>
                    <li><a class="btn btn-link text-white" href="{{ route('events.index') }}">Événements</a></li>
                    <li><a class="btn btn-link text-white" href="{{ route('blogs.index') }}">Blog</a></li>
                    {{-- <li><a class="btn btn-link text-white" href="{{ route('faq') }}">FAQ</a></li> --}}
                    <li><a class="btn btn-link text-white" href="{{ route('terms') }}">Conditions d'utilisation</a></li>
                    <li><a class="btn btn-link text-white" href="{{ route('privacy') }}">Politique de confidentialité</a></li>
                </ul>
            </div>

            <!-- Section Contact -->
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Contact</h4>
                <ul class="list-unstyled">
                    <li class="mb-2 text-white">
                        <i class="fa fa-map-marker-alt me-3"></i>Brazzaville, Congo
                    </li>
                    <li class="mb-2 text-white">
                        <i class="fa fa-phone-alt me-3"></i>+242 06 408 88 68
                    </li>
                    <li class="mb-2 text-white">
                        <i class="fa fa-envelope me-3"></i><a href="mailto:contact@mokilievent.com" class="text-white">contact@mokilievent.com</a>
                    </li>
                    <li class="mb-2 text-white">
                        <i class="fa fa-clock me-3"></i>Lun - Ven : 9h - 18h
                    </li>
                </ul>
            </div>

            <!-- Section Newsletter et Réseaux sociaux -->
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-4">Newsletter</h4>
                <p class="text-white">Abonnez-vous pour recevoir les dernières actualités et offres exclusives.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="position-relative">
                    @csrf
                    <input type="email" name="email" class="form-control border-0 rounded-pill py-3 ps-4 pe-5" placeholder="Votre email" required aria-label="Entrer votre email pour vous abonner">
                    <button type="submit" class="btn btn-light py-2 position-absolute top-0 end-0 mt-2 me-2">S'abonner</button>
                </form>
                <div class="d-flex pt-4">
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-square btn-light rounded-circle me-2" href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Copyright -->
    <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0 text-white">
                    &copy; {{ date('Y') }} <a href="{{ route('home') }}" class="text-white">MokiliEvent</a>. Tous droits réservés.
                </div>
                <div class="col-md-6 text-center text-md-end text-white">
                    Développé par <a href="#" class="text-white">MokiliEvent Team</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->
