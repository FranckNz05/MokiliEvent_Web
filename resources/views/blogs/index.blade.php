@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar gauche -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Catégories</h5>
                    <div class="list-group">
                        @foreach($categories as $category)
                            <a href="{{ route('blogs.category', $category->slug) }}"
                               class="list-group-item list-group-item-action {{ request()->route('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="col-md-6">
            @foreach($blogs as $blog)
                <div class="card mb-3 blog-card">
                    <div class="card-body">
                        <!-- En-tête du blog -->
                        <div class="d-flex align-items-center mb-3">
                            @if(isset($blog->user) && isset($blog->user->organizer))
                                <img src="{{ $blog->user->organizer->logo ? asset('storage/' . $blog->user->organizer->logo) : asset('images/default-avatar.png') }}"
                                     class="rounded-circle me-2"
                                     width="40"
                                     height="40"
                                     alt="{{ $blog->user->organizer->company_name ?? 'Organisateur' }}">
                                <div>
                                    <h6 class="mb-0">{{ $blog->user->organizer->company_name ?? $blog->user->name }}</h6>
                                    <small class="text-muted">{{ $blog->created_at->diffForHumans() }}</small>
                                </div>
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $blog->user->name ?? 'Utilisateur' }}</h6>
                                    <small class="text-muted">{{ $blog->created_at->diffForHumans() }}</small>
                                </div>
                            @endif
                        </div>

                        <!-- Contenu du blog -->
                        <div class="blog-content">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text">{{ $blog->content }}</p>

                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}"
                                     class="img-fluid rounded mb-3"
                                     alt="{{ $blog->title }}">
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex gap-3">
                                <!-- Commentaires -->
                                <button class="btn btn-link text-muted p-0"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#comments-{{ $blog->id }}">
                                    <i class="fas fa-comment"></i>
                                    <span class="ms-1">{{ $blog->comments_count }}</span>
                                </button>

                                <!-- J'aime -->
                                <button class="btn btn-link text-muted p-0 like-btn"
                                        data-blog-id="{{ $blog->id }}">
                                    <i class="fas fa-heart {{ auth()->check() && isset($blog->likes) && $blog->likes->where('user_id', auth()->id())->count() ? 'text-danger' : '' }}"></i>
                                    <span class="ms-1 likes-count">{{ isset($blog->likes) ? $blog->likes->count() : 0 }}</span>
                                </button>

                                <!-- Partager -->
                                <button class="btn btn-link text-muted p-0 share-btn"
                                        data-blog-id="{{ $blog->id }}">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Section commentaires -->
                        <div class="collapse mt-3" id="comments-{{ $blog->id }}">
                            <div class="card card-body">
                                @auth
                                    <form action="{{ route('blogs.comment', $blog->id) }}" method="POST" class="mb-3">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="content" class="form-control" rows="2" placeholder="Écrire un commentaire..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2">Commenter</button>
                                    </form>
                                @endauth

                                <div class="comments-list">
                                    @if(isset($blog->comments))
                                        @foreach($blog->comments()->latest()->take(5)->get() as $comment)
                                            <div class="d-flex mb-2">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user text-secondary" style="font-size: 12px;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="bg-light rounded p-2">
                                                        <strong>{{ $comment->user->name ?? 'Utilisateur' }}</strong>
                                                        <p class="mb-0">{{ $comment->content }}</p>
                                                    </div>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Aucun commentaire pour le moment.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $blogs->links() }}
            </div>
        </div>

        <!-- Sidebar droite -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Articles populaires</h5>
                    @foreach($popularBlogs as $popularBlog)
                        <div class="mb-3">
                            <a href="#" class="text-decoration-none">
                                <h6 class="mb-1">{{ $popularBlog->title }}</h6>
                                <small class="text-muted">{{ $popularBlog->views_count }} vues</small>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.blog-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.blog-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn-link {
    text-decoration: none;
    transition: color 0.2s;
}

.btn-link:hover {
    color: #1da1f2 !important;
}

.like-btn.active i {
    color: #e0245e;
}

.comments-list {
    max-height: 300px;
    overflow-y: auto;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des likes
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const blogId = this.dataset.blogId;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.likes-count');

            fetch(`/blog/${blogId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    icon.classList.toggle('text-danger');
                    countSpan.textContent = data.likes_count;
                }
            });
        });
    });

    // Gestion du partage
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', function() {
            const blogId = this.dataset.blogId;
            const url = window.location.origin + '/blog/' + blogId;

            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: url
                });
            } else {
                // Fallback pour les navigateurs qui ne supportent pas l'API Web Share
                navigator.clipboard.writeText(url);
                alert('Lien copié dans le presse-papiers !');
            }
        });
    });
});
</script>
@endpush
@endsection
