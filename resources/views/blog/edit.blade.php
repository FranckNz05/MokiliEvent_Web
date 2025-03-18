@extends('layouts.app')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="display-3 mb-3 animated slideInDown">Modifier l'article</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.show', $blog) }}">{{ Str::limit($blog->title, 30) }}</a></li>
                <li class="breadcrumb-item active">Modifier</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Edit Blog Post Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                                    <label for="title">Titre de l'article</label>
                                </div>
                            </div>

                            @if($events->count() > 0)
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="event_id" name="event_id">
                                            <option value="">Aucun événement</option>
                                            @foreach($events as $event)
                                                <option value="{{ $event->id }}" {{ old('event_id', $blog->event_id) == $event->id ? 'selected' : '' }}>
                                                    {{ $event->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="event_id">Événement associé (optionnel)</label>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image de couverture</label>
                                    @if($blog->image_path)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($blog->image_path) }}" alt="Current image" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="form-text text-muted">Laissez vide pour conserver l'image actuelle</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="content">Contenu de l'article</label>
                                    <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" id="status" name="status">
                                        <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                        <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Publié</option>
                                    </select>
                                    <label for="status">Statut</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Mettre à jour l'article</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Blog Post End -->

@push('scripts')
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        height: 500,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help',
        menubar: false
    });
</script>
@endpush

@endsection
