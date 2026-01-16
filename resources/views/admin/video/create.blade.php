@extends('layouts.back')

@section('title', 'Ajouter une vidéo YouTube')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Ajouter une vidéo YouTube</h4>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.videos.store') }}" method="POST">
            @csrf

            {{-- URL --}}
            <div class="mb-3">
                <label for="url" class="form-label">YouTube URL</label>
                <input
                    type="url"
                    class="form-control @error('url') is-invalid @enderror"
                    id="url"
                    name="url"
                    value="{{ old('url') }}"
                    placeholder="https://www.youtube.com/watch?v=..."
                    required
                >
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Titre --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input
                    type="text"
                    class="form-control @error('title') is-invalid @enderror"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Titre de la vidéo"
                >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea
                    class="form-control @error('description') is-invalid @enderror"
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Description de la vidéo (optionnel)"
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Enregistrer
            </button>
        </form>
    </div>
</div>
@endsection
