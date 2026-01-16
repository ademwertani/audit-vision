@extends('layouts.back')

@section('title', 'Create Project')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Create New Project</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required>
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
                    required>{{ old('summary') }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Main Image --}}
            <div class="mb-3">
                <label for="image" class="form-label">Main Image *</label>
                <input type="file"
                       class="form-control @error('image') is-invalid @enderror"
                       id="image"
                       name="image"
                       accept="image/*"
                       required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
            </div>

            {{-- Actions --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
