@extends('layouts.back')

@section('title', 'Modifier un certificat')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier un certificat</h1>

    <form action="{{ route('admin.certificats.update', $certificat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $certificat->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" required>{{ old('description', $certificat->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image (facultatif)</label>
            @if($certificat->image)
            <div>
                <img src="{{ asset('storage/' . $certificat->image) }}" width="100" alt="Certificat image">
            </div>
            @endif
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="pdf_file">Fichier PDF</label>
            <input type="file" class="form-control" name="pdf_file" id="pdf_file" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
    </form>
</div>
@endsection
