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
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Summary --}}
            <div class="mb-3">
                <label for="summary" class="form-label">Summary *</label>
                <input type="text" class="form-control @error('summary') is-invalid @enderror"
                       id="summary" name="summary" value="{{ old('summary') }}" required>
                @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Secteur --}}
            <div class="mb-3">
                <label for="secteur" class="form-label">Secteur</label>
                <select class="form-select @error('secteur') is-invalid @enderror"
                        id="secteur" name="secteur">
                    <option value="">-- Select Secteur --</option>
                    @foreach(\App\Models\Project::SECTEURS as $sec)
                        <option value="{{ $sec }}" {{ old('secteur') === $sec ? 'selected' : '' }}>
                            {{ $sec }}
                        </option>
                    @endforeach
                </select>
                @error('secteur')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Service --}}
            <div class="mb-3">
                <label for="service_id" class="form-label">Service *</label>
                <select class="form-select @error('service_id') is-invalid @enderror"
                        id="service_id" name="service_id" required>
                    <option value="">-- Select Service --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Image principale --}}
            <div class="mb-3">
                <label for="image" class="form-label">Main Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror"
                       id="image" name="image" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
            </div>

            {{-- ✅ Galerie images --}}
            <div class="mb-3">
                <label class="form-label">Gallery Images (max 5)</label>
                <input type="file" class="form-control @error('images') is-invalid @enderror"
                       name="images[]" multiple accept="image/*">
                @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">You can upload up to 5 images</small>

                {{-- ✅ Preview zone --}}
                <div id="preview-area" class="row g-2 mt-2 d-none"></div>
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

{{-- ✅ Preview Script --}}
<script>
document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
    const preview = document.getElementById('preview-area');
    preview.innerHTML = '';
    preview.classList.remove('d-none');

    [...e.target.files].slice(0, 5).forEach(file => {
        const reader = new FileReader();
        reader.onload = evt => {
            preview.innerHTML += `
                <div class="col-4 col-md-2">
                    <img src="${evt.target.result}" class="img-fluid rounded border" style="height:90px;object-fit:cover;">
                </div>`;
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection
