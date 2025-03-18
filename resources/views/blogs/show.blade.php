@extends('layouts.app')

@section('title', $blog->title)

@section('content')
@php
$breadcrumbs = [
    ['text' => 'Accueil', 'url' => route('home')],
    ['text' => 'Blog', 'url' => route('blogs.index')],
    ['text' => $blog->title]
];
@endphp

@include('layouts.partials.page-header', [
    'pageTitle' => $blog->title,
    'breadcrumbs' => $breadcrumbs
])

<!-- Blog Detail Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="blog-item">
                    <div class="blog-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta d-flex justify-content-between py-3">
                            <span><i class="fa fa-user text-primary me-2"></i>{{ $blog->user->organizer->company_name }}</span>
                            <span><i class="fa fa-calendar text-primary me-2"></i>{{ $blog->created_at->format('d M Y') }}</span>
                            <span><i class="fa fa-comments text-primary me-2"></i>{{ $blog->comments->count() }} Commentaires</span>
                        </div>
                        <div class="blog-text">
                            {!! $blog->content !!}
                        </div>
                    </div>
                </div>
                <!-- Blog Detail End -->

                <!-- Comments Start -->
                <div class="comments-section mt-5">
                    <h4 class="mb-4">{{ $blog->comments->count() }} Commentaires</h4>

                    @foreach($blog->comments as $comment)
                    <div class="comment-item d-flex mb-4">
                        <img class="rounded-circle me-3" src="{{ $comment->user->profile_photo_url }}" style="width: 50px; height: 50px;" alt="{{ $comment->user->name }}">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6>{{ $comment->user->name }}</h6>
                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>
                    </div>
                    @endforeach

                    @auth
                    <div class="leave-comment mt-5">
                        <h4 class="mb-4">Laisser un commentaire</h4>
                        <form action="{{ route('blogs.comments.store', $blog) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <textarea class="form-control" name="content" rows="5" placeholder="Votre commentaire"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publier le commentaire</button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <a href="{{ route('auth.login') }}" class="alert-link">Connectez-vous</a> pour laisser un commentaire.
                    </div>
                    @endauth
                </div>
                <!-- Comments End -->
            </div>

            <!-- Sidebar Start -->
            <div class="col-lg-4">
                <!-- Author Bio -->
                <div class="mb-5 p-4 bg-light rounded">
                    <h4 class="mb-4">À propos de l'auteur</h4>
                    <div class="d-flex align-items-center mb-3">
                        <img class="rounded-circle me-3" src="{{ $blog->user->organizer->logo }}" style="width: 60px; height: 60px;" alt="{{ $blog->user->organizer->company_name }}">
                        <div>
                            <h6 class="mb-1">{{ $blog->user->organizer->company_name }}</h6>
                            <small>Auteur</small>
                        </div>
                    </div>
                    <p class="mb-0">{{ $blog->user->organizer->description ?? 'Auteur passionné partageant son expertise et ses connaissances sur les événements.' }}</p>
                </div>

                <!-- Recent Posts -->
                <div class="mb-5">
                    <h4 class="mb-4">Articles récents</h4>
                    @foreach($similarBlogs as $relatedBlog)
                    <div class="d-flex mb-3">
                        <img class="img-fluid me-3" src="{{ asset('storage/' . $relatedBlog->image) }}" style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $relatedBlog->title }}">
                        <div>
                            <a class="h6" href="{{ route('blogs.show', $relatedBlog) }}">{{ $relatedBlog->title }}</a>
                            <small class="d-block">{{ $relatedBlog->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Categories -->
                @if($categories->isNotEmpty())
                <div class="mb-5">
                    <h4 class="mb-4">Catégories</h4>
                    <div class="d-flex flex-column">
                        @foreach($categories as $category)
                        <a class="h6 mb-3" href="{{ route('blogs.category', $category) }}">
                            <i class="fa fa-angle-right me-2"></i>{{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tags -->

            </div>
            <!-- Sidebar End -->
        </div>
    </div>
</div>
<!-- Blog Detail End -->

@endsection

@push('styles')
<style>
    .blog-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .comment-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }
    .comment-item:last-child {
        border-bottom: none;
    }
</style>
@endpush
