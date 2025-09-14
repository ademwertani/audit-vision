@extends('layouts.back')

@section('title', 'About Information')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Edit About Information</h4>
    </div>
    <div class="card-body">
        
        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="heading" class="form-label">Heading *</label>
                <input type="text" class="form-control @error('heading') is-invalid @enderror" 
                       id="heading" name="heading" value="{{ old('heading', $about->heading) }}" required>
                @error('heading')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="summary" class="form-label">Summary *</label>
                <textarea class="form-control @error('summary') is-invalid @enderror" 
                          id="summary" name="summary" rows="5" required>{{ old('summary', $about->summary) }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Location *</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                           id="location" name="location" value="{{ old('location', $about->location) }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Phone *</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $about->phone) }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $about->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                @if($about->logo)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$about->logo) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo">
                        <label class="form-check-label" for="remove_logo">Remove current logo</label>
                    </div>
                </div>
                @endif
                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                       id="logo" name="logo">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
            </div>

            <div class="mb-3">
                <label for="aboutimage" class="form-label">About Image</label>
                @if($about->aboutimage)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$about->aboutimage) }}" alt="Current About Image" class="img-thumbnail" style="max-height: 100px;">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="remove_aboutimage" name="remove_aboutimage">
                        <label class="form-check-label" for="remove_aboutimage">Remove current image</label>
                    </div>
                </div>
                @endif
                <input type="file" class="form-control @error('aboutimage') is-invalid @enderror" id="aboutimage" name="aboutimage">
                @error('aboutimage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection