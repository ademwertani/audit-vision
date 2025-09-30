@extends('layouts.back')

@section('title', 'View Quote')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Quote #{{ $quote->id }}</h4>
        <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>Nom :</strong> {{ $quote->nom }}</li>
            <li class="list-group-item"><strong>Prénom :</strong> {{ $quote->prenom }}</li>
            <li class="list-group-item"><strong>Adresse :</strong> {{ $quote->adresse }}</li>
            <li class="list-group-item"><strong>Email :</strong> {{ $quote->email }}</li>
            <li class="list-group-item"><strong>Created At :</strong> {{ $quote->created_at->format('Y-m-d H:i') }}</li>
        </ul>
    </div>
</div>
@endsection
