@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')

<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 60px; height: 60px;">
                        <i class="fa fa-map-marker-alt text-white fs-4"></i>
                    </div>
                    <h5>Notre Bureau</h5>
                    <p class="mb-0">123 Rue de Brazzaville, Congo</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 60px; height: 60px;">
                        <i class="fa fa-envelope-open text-white fs-4"></i>
                    </div>
                    <h5>Email</h5>
                    <p class="mb-0">support@mokilievent.com</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle mb-4" style="width: 60px; height: 60px;">
                        <i class="fa fa-phone-alt text-white fs-4"></i>
                    </div>
                    <h5>Téléphone</h5>
                    <p class="mb-0">+242 06 408 8868</p>
                    <p class="mb-0">+242 06 830 6542</p>
                    <p class="mb-0">+242 05 766 8371</p>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4">
                    <iframe class="position-relative rounded w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63520.110523304214!2d15.241595895363882!3d-4.267459108480173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a33d43d88f31d%3A0x2a91a34b7c76a5d0!2sBrazzaville%2C%20Congo!5e0!3m2!1sfr!2sfr!4v1647524145548!5m2!1sfr!2sfr"
                        frameborder="0" style="min-height: 400px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <div class="bg-light rounded p-4">
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
                                    <label for="name">Votre nom</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
                                    <label for="email">Votre email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Sujet" value="{{ old('subject') }}" required>
                                    <label for="subject">Sujet</label>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Votre message" id="message" name="message" style="height: 150px" required>{{ old('message') }}</textarea>
                                    <label for="message">Message</label>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Envoyer le message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
@endsection
