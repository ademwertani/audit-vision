@extends('layouts.back')

@section('title', 'Edit Team Member')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Edit Team Member</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $team->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role *</label>
                <input type="text" class="form-control @error('role') is-invalid @enderror" 
                       id="role" name="role" value="{{ old('role', $team->role) }}" required>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="linkedin" class="form-label">LinkedIn Profile URL</label>
                <input type="url" class="form-control @error('linkedin') is-invalid @enderror" 
                       id="linkedin" name="linkedin" value="{{ old('linkedin', $team->linkedin) }}"
                       placeholder="https://linkedin.com/in/username">
                @error('linkedin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Photo</label>
                @if($team->image)
                <div class="mb-2">
                    <img src="{{ $team->image_url }}" alt="Current Photo" class="img-thumbnail" style="max-height: 150px;">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                        <label class="form-check-label" for="remove_image">Remove current photo</label>
                    </div>
                </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Leave blank to keep current photo</small>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
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