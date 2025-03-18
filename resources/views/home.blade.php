@extends('layouts.app')

@section('content')
<!-- Hero Section Start -->
<div class="container-fluid py-5 mb-5 hero-header position-relative" style="background-image: url('{{ asset('images/foule-humains-copie.jpg') }}'); height: 500px; background-size: cover; background-position: center;">
    <div class="overlay position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.6); top: 0; left: 0;"></div>
    <div class="container py-5 position-relative text-center text-white">
        <h1 class="mb-4 display-3 fw-bold">Le repère incontournable pour tous vos événements !</h1>
        <div class="mx-auto" style="max-width: 600px;">
            <form action="{{ route('events.index') }}" method="GET" class="d-flex position-relative">
                <input class="form-control border-0 shadow-lg rounded-start-pill py-3 px-4" type="text" name="search" placeholder="Rechercher un événement...">
                <button type="submit" class="btn btn-danger rounded-end-pill px-4 shadow-lg">Rechercher</button>
            </form>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Événements Populaires -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center mb-4">Événements Populaires</h2>
            </div>
        </div>
        <div class="position-relative">
            <div class="owl-carousel popular-events-carousel">
                @foreach($popularEvents as $event)
                <div class="item px-2">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            @if($event->image)
                                <img src="{{ asset($event->image) }}"
                                     class="card-img-top"
                                     alt="{{ $event->title }}"
                                     style="height: 200px; object-fit: cover;">
                            @endif
                            @if($event->category)
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-primary">{{ $event->category->name }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('events.show', $event->slug) }}"
                                   class="text-decoration-none text-dark">
                                    {{ $event->title }}
                                </a>
                            </h5>
                            <p class="text-muted mb-3">
                                <small>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#popularEventsCarousel">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#popularEventsCarousel">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</section>

<!-- Organisateurs -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center mb-4">Nos Organisateurs</h2>
            </div>
        </div>
        <div class="position-relative">
            <div class="owl-carousel organizers-carousel">
                @foreach($organizers as $organizer)
                <div class="item px-2">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <img src="{{ $organizer->logo ? asset($organizer->logo) : asset('images/default-logo.png') }}"
                                     alt="{{ $organizer->company_name }}"
                                     class="rounded-circle"
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <h5 class="card-title">
                                <a href="{{ route('organizers.show', $organizer->slug) }}"
                                   class="text-decoration-none text-dark">
                                    {{ $organizer->company_name }}
                                </a>
                            </h5>
                            <p class="text-muted">
                                <small>{{ $organizer->events_count }} événements</small>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#organizersCarousel">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#organizersCarousel">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</section>

<!-- Categories Section Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h2 class="display-5 fw-bold">Nos Catégories</h2>
            <p class="text-muted">Découvrez les événements par catégorie</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($categories ?? [] as $category)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('events.index', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="position-relative category-card text-center text-white py-4 rounded shadow">
                        <div class="category-image position-absolute w-100 h-100" style="background-image: url('{{ asset('images/' . $category->slug . '.jpg') }}'); background-size: cover; background-position: center; filter: brightness(0.5);"></div>
                        <div class="position-relative z-1">
                            <h5>{{ $category->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Categories Section End -->

<!-- Call to Action Start -->
<div class="container-fluid py-5 bg-danger text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold">Vous organisez un événement ?</h2>
                <p class="mb-0">Rejoignez notre plateforme et commencez à vendre vos billets dès aujourd'hui</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('events.create') }}" class="btn btn-light btn-lg rounded-pill px-4 shadow">Créer un événement</a>
            </div>
        </div>
    </div>
</div>
<!-- Call to Action End -->

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<style>
.hero-header .overlay {
    background: rgba(0, 0, 0, 0.6);
}

.category-card:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.btn-favorite {
    transition: all 0.2s ease;
}

.btn-favorite:hover {
    transform: scale(1.1);
}

.owl-carousel .item {
    margin: 0 5px;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.owl-carousel:hover .carousel-control-prev,
.owl-carousel:hover .carousel-control-next {
    opacity: 1;
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
$(document).ready(function(){
    $('.popular-events-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            992: { items: 3 },
            1200: { items: 4 }
        }
    });

    $('.organizers-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            992: { items: 4 },
            1200: { items: 5 }
        }
    });

    // Newsletter Form
    $('.newsletter-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnContent = submitBtn.html();

        submitBtn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', response.message);
                    form[0].reset();
                } else {
                    showToast('error', response.message);
                }
            },
            error: function() {
                showToast('error', 'Une erreur est survenue. Veuillez réessayer.');
            },
            complete: function() {
                submitBtn.html(originalBtnContent).prop('disabled', false);
            }
        });
    });

    function showToast(type, message) {
        const toast = $(`
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `);

        $('body').append(toast);
        const bsToast = new bootstrap.Toast(toast.find('.toast')[0]);
        bsToast.show();

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endpush
