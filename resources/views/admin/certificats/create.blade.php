@extends('layouts.back')

@section('title', 'Ajouter un certificat')

@section('content')
<div class="container">
    <h1 class="mb-4">Ajouter un certificat</h1>

    <form action="{{ route('admin.certificats.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image (facultatif)</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="pdf_file">Fichier PDF</label>
            <input type="file" class="form-control" name="pdf_file" id="pdf_file" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
    </form>
</div>
@endsection
