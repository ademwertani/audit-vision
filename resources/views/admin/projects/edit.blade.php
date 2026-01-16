@extends('layouts.back')

@section('title', 'Edit Project')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Edit Project</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name', $project->name) }}"
                    required
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Summary --}}
            <div class="mb-3">
                <label for="summary" class="form-label">Summary *</label>
                <textarea
                    class="form-control @error('summary') is-invalid @enderror"
                    id="summary"
                    name="summary"
                    rows="3"
                    required>{{ old('summary', $project->summary) }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image principale --}}
            <div class="mb-3">
                <label class="form-label">Main Image</label>

                @if($project->image)
                    <div class="mb-2">
                        <img
                            src="{{ asset('storage/' . $project->image) }}"
                            class="img-thumbnail"
                            style="max-height:150px;"
                            alt="Current project image"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    class="form-control @error('image') is-invalid @enderror"
                    name="image"
                    id="image"
                    accept="image/*"
                >
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    Upload a new image to replace the current one (optional). Max 2MB (JPEG, PNG, JPG, GIF).
                </small>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
