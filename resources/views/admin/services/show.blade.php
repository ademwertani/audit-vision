@extends('layouts.back')

@section('title', 'Service Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Service Details</h4>
        <div class="btn-group">
            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            {{-- Colonne image --}}
            <div class="col-md-4 mb-4 mb-md-0">
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="img-fluid rounded">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
            </div>

            {{-- Colonne contenu --}}
            <div class="col-md-8">
                <h3 class="mb-1">{{ $service->name }}</h3>
                @if(!empty($service->summary))
                    <h5 class="text-muted fw-normal mb-3">{{ $service->summary }}</h5>
                @endif

                <div class="mb-3">
                    <strong>Category:</strong>
                    @if($service->category)
                        <span class="badge bg-primary">{{ $service->category->name }}</span>
                    @else
                        <span class="text-muted">Uncategorized</span>
                    @endif
                </div>

                @if(!empty($service->description))
                    <hr>
                    <p class="mb-0">{{ $service->description }}</p>
                @endif

                {{-- ====== Section Vidéo YouTube ====== --}}
                @php
                    // On tente d'utiliser l'accessor si le modèle est déjà mis à jour.
                    $embed = method_exists($service, 'getYoutubeEmbedAttribute') ? $service->youtube_embed : null;
                @endphp

                @if($embed)
                    <hr>
                    <h5 class="mb-2">Vidéo</h5>
                    <div class="ratio ratio-16x9 mb-3">
                        <iframe
                            src="{{ $embed }}"
                            title="YouTube video"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                @elseif(!empty($service->youtube_url))
                    {{-- Fallback: pas d'accessor, on affiche au moins un lien sortant --}}
                    <hr>
                    <h5 class="mb-2">Vidéo</h5>
                    <p class="mb-0">
                        <a href="{{ $service->youtube_url }}" target="_blank" rel="noopener">
                            Voir la vidéo sur YouTube
                        </a>
                    </p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        {{-- (Optionnel) métadonnées bas de page --}}
        <div class="text-muted small mt-4">
            <div>Created: {{ $service->created_at?->format('Y-m-d H:i') ?? '—' }}</div>
            <div>Updated: {{ $service->updated_at?->format('Y-m-d H:i') ?? '—' }}</div>
        </div>
    </div>
</div>
@endsection
