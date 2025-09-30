@extends('layouts.back')

@section('title', 'Modifier la demande de devis')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Modifier la demande</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.quotes.update', $quote->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nom" class="form-label">Nom *</label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                       id="nom" name="nom" value="{{ old('nom', $quote->nom) }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom *</label>
                <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                       id="prenom" name="prenom" value="{{ old('prenom', $quote->prenom) }}" required>
                @error('prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse *</label>
                <input type="text" class="form-control @error('adresse') is-invalid @enderror" 
                       id="adresse" name="adresse" value="{{ old('adresse', $quote->adresse) }}" required>
                @error('adresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $quote->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
