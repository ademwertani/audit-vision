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
            <div class="col-md-4 mb-4 mb-md-0">
                @if($project->image)
                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="img-fluid rounded">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <h3>{{ $project->name }}</h3>
                <h5 class="text-muted">{{ $project->summary }}</h5>

                {{-- Category --}}
                <div class="mb-2">
                    <strong>Category:</strong>
                    @if($project->category)
                        <span class="badge bg-primary">{{ $project->category->name }}</span>
                    @else
                        <span class="text-muted">Uncategorized</span>
                    @endif
                </div>

                {{-- Secteur (AJOUT) --}}
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
