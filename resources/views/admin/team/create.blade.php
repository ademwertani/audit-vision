@extends('layouts.back')

@section('title', 'Add Team Member')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Add New Team Member</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role *</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" 
                       id="role" name="role" value="{{ old('role') }}" required>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="linkedin" class="form-label">LinkedIn Profile URL</label>
                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" 
                       id="linkedin" name="linkedin" value="{{ old('linkedin') }}"
                       placeholder="https://linkedin.com/in/username">
                @error('linkedin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Photo *</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
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