@extends('layouts.app')

@section('title', 'Créer un article')

@section('content')
<x-page-header title="Créer un article" />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">Créer un nouvel article</h2>

                    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Informations de base -->
                        <div class="mb-4">
                            <h4 class="mb-3">Informations de base</h4>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre de l'article *</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Extrait *</label>
                                <textarea name="excerpt" id="excerpt" rows="2" 
                                          class="form-control @error('excerpt') is-invalid @enderror" required
                                          placeholder="Un bref résumé de l'article">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenu *</label>
                                <textarea name="content" id="content" rows="10" 
                                          class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image de couverture *</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                                       accept="image/*" required>
                                <small class="form-text text-muted">Format recommandé : 1200x630px, max 2MB</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Métadonnées -->
                        <div class="mb-4">
                            <h4 class="mb-3">Métadonnées</h4>

                            <div class="mb-3">
                                <label for="event_id" class="form-label">Événement associé</label>
                                <select name="event_id" id="event_id" class="form-select @error('event_id') is-invalid @enderror">
                                    <option value="">Aucun événement</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" 
                                       value="{{ old('tags') }}" placeholder="Séparez les tags par des virgules">
                                <small class="form-text text-muted">Ex: événement, musique, festival</small>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('blog.index') }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Publier l'article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser TinyMCE
    tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500
    });
});
</script>
@endpush
@endsection
