@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<x-page-header title="Blog" />

<div class="container-xxl py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            @auth
                @if(auth()->user()->hasRole(['organizer', 'admin']))
                    <a href="{{ route('blogs.create') }}" class="btn btn-primary">Créer un article</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="blog-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ $blog->image_path ? Storage::url($blog->image_path) : asset('images/default-blog.jpg') }}" alt="{{ $blog->title }}">
                        </div>
                        <div class="bg-light p-4">
                            <div class="d-flex mb-3">
                                <small class="me-3"><i class="far fa-user text-primary me-2"></i>{{ $blog->user->organizer->company_name ?? "Non disponible"}}</small>
                                <small><i class="far fa-calendar-alt text-primary me-2"></i>{{ $blog->created_at->format('d M Y') }}</small>
                            </div>
                            <h5 class="mb-3">{{ $blog->title }}</h5>
                            <p>{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                            <a class="text-uppercase" href="{{ route('blogs.show', $blog) }}">Lire plus <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Aucun article de blog pour le moment.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush

@endsection
