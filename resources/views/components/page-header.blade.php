@props(['title'])

<div style="padding-top: 5px;">
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/foule-humains-copie.jpg') }}') center 80%/cover no-repeat;">
        <div class="container">
            <h1 class="display-4 animated slideInDown mb-4">{{ $title }}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
