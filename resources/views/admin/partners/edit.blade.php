@extends('layouts.back')

@section('title', 'Modifier un partenaire')

@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h4 class="mb-0">Modifier un partenaire</h4></div>

    <div class="card-body">
        <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nom *</label>
                <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="form-control" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Logo actuel</label><br>
                <img src="{{ asset('storage/' . ltrim($partner->logo, '/')) }}"
                     alt="{{ $partner->name }}" style="max-height:80px;">
            </div>

            <div class="mb-3">
                <label class="form-label">Nouveau logo (optionnel)</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                @error('logo') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <img id="preview" src="#" alt="" style="display:none; max-height:80px;">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>Mettre à jour
                </button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('input[name="logo"]').addEventListener('change', e => {
  const img = document.getElementById('preview');
  const file = e.target.files?.[0];
  if(!file){ img.style.display='none'; return; }
  img.src = URL.createObjectURL(file);
  img.style.display = 'inline-block';
});
</script>
@endpush
@endsection
