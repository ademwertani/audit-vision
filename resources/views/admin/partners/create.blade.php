@extends('layouts.back')

@section('title', 'Ajouter un partenaire')

@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h4 class="mb-0">Ajouter un partenaire</h4></div>

    <div class="card-body">
        <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Logo (PNG/JPG) *</label>
                <input type="file" name="logo" class="form-control" accept="image/*" required>
                @error('logo') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <img id="preview" src="#" alt="" style="display:none; max-height:80px;">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>Enregistrer
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
