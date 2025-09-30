@extends('layouts.back')

@section('title', 'Créer une demande de devis')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Nouvelle demande de devis</h4>
    </div>
    <div class="card-body">

        <!-- Message de succès -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.quotes.store') }}" method="POST">
    @csrf

    <!-- Champ nom -->
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
    </div>

    <!-- Champ prénom -->
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" name="prenom" id="prenom" class="form-control" required>
    </div>

    <!-- Champ adresse -->
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" name="adresse" id="adresse" class="form-control" required>
    </div>

    <!-- Champ email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">Annuler</a>
</form>

    </div>
</div>
@endsection
