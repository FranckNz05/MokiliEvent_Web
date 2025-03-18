@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12">
                <h1 class="mb-4 display-3 text-primary">Contactez-Nous</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="d-flex align-items-center bg-light rounded p-4 mb-4">
                        <div class="icon me-3">
                            <i class="fa fa-map-marker-alt text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h5>Notre Adresse</h5>
                            <p class="mb-0">123 Rue de Brazzaville, Congo</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center bg-light rounded p-4 mb-4">
                        <div class="icon me-3">
                            <i class="fa fa-phone-alt text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h5>Téléphone</h5>
                            <p class="mb-0">+242 06 123 4567</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center bg-light rounded p-4">
                        <div class="icon me-3">
                            <i class="fa fa-envelope text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h5>Email</h5>
                            <p class="mb-0">contact@mokilievent.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <h3 class="mb-4">Envoyez-nous un message</h3>
                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control rounded py-3 px-4 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Votre nom">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" class="form-control rounded py-3 px-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Votre email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control rounded py-3 px-4 @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" placeholder="Sujet">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control rounded py-3 px-4 @error('message') is-invalid @enderror" name="message" rows="6" placeholder="Votre message">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary rounded-pill py-3 px-5">Envoyer le Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="rounded overflow-hidden">
                    <iframe class="w-100" 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63520.111583042195!2d15.241595!3d-4.289374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a3130fe234b2f%3A0x4d934ee66f897c2!2sBrazzaville%2C%20Congo!5e0!3m2!1sen!2s!4v1660000000000!5m2!1sen!2s"
                        style="height: 450px; border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection
