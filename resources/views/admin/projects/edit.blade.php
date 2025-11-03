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
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $project->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Summary --}}
            <div class="mb-3">
                <label for="summary" class="form-label">Summary *</label>
                <input type="text" class="form-control @error('summary') is-invalid @enderror" 
                       id="summary" name="summary" value="{{ old('summary', $project->summary) }}" required>
                @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Secteur --}}
            <div class="mb-3">
                <label for="secteur" class="form-label">Secteur</label>
                <select class="form-select @error('secteur') is-invalid @enderror" id="secteur" name="secteur">
                    <option value="">-- Select Secteur --</option>
                    @foreach(\App\Models\Project::SECTEURS as $sec)
                        <option value="{{ $sec }}" {{ old('secteur', $project->secteur) === $sec ? 'selected' : '' }}>{{ $sec }}</option>
                    @endforeach
                </select>
                @error('secteur')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Service --}}
            <div class="mb-3">
                <label for="service_id" class="form-label">Service *</label>
                <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                    <option value="">-- Select Service --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" 
                            {{ old('service_id', $project->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Image principale --}}
            <div class="mb-3">
                <label class="form-label">Image principale</label>

                @if($project->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $project->image) }}" class="img-thumbnail" style="max-height:150px;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                            <label class="form-check-label" for="remove_image">Remove current image</label>
                        </div>
                    </div>
                @endif

                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- ✅ GALERIE IMAGES --}}
            <div class="mb-3">
                <label class="form-label">Galerie (max 5 images)</label>

                {{-- Liste images existantes --}}
                @if(!empty($project->images))
                    <div class="row g-2 mb-2">
                        @foreach($project->images as $img)
                            <div class="col-6 col-md-3 text-center">
                                <img src="{{ Storage::url($img) }}" class="img-fluid rounded border mb-1" style="height:90px;object-fit:cover;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="keep[]" value="{{ $img }}" checked>
                                    <label class="form-check-label small">Garder</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Input nouvelle images --}}
                <input type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" multiple accept="image/*">
                @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror

                <small class="text-muted d-block mt-1">
                    Vous pouvez ajouter de nouvelles images (jusqu’à 5 au total).
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
