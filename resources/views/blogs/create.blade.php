@extends('layouts.app')

@section('title', 'Créer un blog')

@section('content')
<x-page-header title="Créer un blog" />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">Créer un nouveau blog</h2>

                    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <h4 class="mb-3">Informations de base</h4>
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre du blog *</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenu *</label>
                                <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image *</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Créer le blog</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
