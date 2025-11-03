@extends('layouts.back')

@section('title', 'Project Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Project Details</h4>
        <div class="btn-group">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
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
            
            {{-- Image principale --}}
            <div class="col-md-4 mb-4 mb-md-0">
                @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="img-fluid rounded">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif

                {{-- Galerie (jusqu'à 5 images) --}}
                @if(!empty($project->images))
                    <h6 class="mt-3 mb-2">Galerie</h6>
                    <div class="row g-2">
                        @foreach($project->images as $img)
                            <div class="col-6">
                                <img src="{{ Storage::url($img) }}" class="img-fluid rounded border" alt="Gallery image">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Infos projet --}}
            <div class="col-md-8">
                <h3>{{ $project->name }}</h3>
                <h5 class="text-muted">{{ $project->summary }}</h5>

                {{-- Service --}}
                <div class="mb-2">
                    <strong>Service:</strong>
                    @if($project->service)
                        <span class="badge bg-primary">{{ $project->service->name }}</span>
                    @else
                        <span class="text-muted">No service</span>
                    @endif
                </div>

                {{-- Secteur --}}
                <div class="mb-3">
                    <strong>Secteur:</strong>
                    @if($project->secteur)
                        @php
                            $map = [
                                'Tertiaire' => 'bg-info',
                                'Industrie' => 'bg-warning text-dark',
                                'Agricole'  => 'bg-success',
                            ];
                            $cls = $map[$project->secteur] ?? 'bg-secondary';
                        @endphp
                        <span class="badge {{ $cls }}">{{ $project->secteur }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </div>

                <hr>

                <p>{{ $project->description }}</p>

                {{-- Vidéo YouTube du service --}}
                @if(optional($project->service)->youtube_embed)
                    <div class="ratio ratio-16x9 my-3">
                        <iframe
                            src="{{ $project->service->youtube_embed }}"
                            title="Service video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
