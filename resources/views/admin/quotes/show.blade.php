@extends('layouts.back')

@section('title', 'View Quote')

@section('content')
@php
    // Mise en forme SIRET : "123 456 789 01234"
    $siretDigits = preg_replace('/\D/', '', (string)($quote->siret ?? ''));
    if (preg_match('/^(\d{3})(\d{3})(\d{3})(\d{5})$/', $siretDigits, $m)) {
        $siretFmt = "{$m[1]} {$m[2]} {$m[3]} {$m[4]}";
    } else {
        $siretFmt = $siretDigits !== '' ? $siretDigits : '—';
    }

    // Sécurise l'accès aux opérations (array/json)
    $ops = is_array($quote->operations)
        ? $quote->operations
        : (json_decode($quote->operations, true) ?: []);
@endphp

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Quote #{{ $quote->id }}</h4>
        <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Nom bénéficiaire :</strong>
                        {{ $quote->nom_beneficiaire ?? '—' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Prénom bénéficiaire :</strong>
                        {{ $quote->prenom_beneficiaire ?? '—' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Email :</strong>
                        {{ $quote->email ?? '—' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Téléphone :</strong>
                        {{ $quote->telephone ?? '—' }}
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Raison sociale :</strong>
                        {{ $quote->raison_sociale ?? '—' }}
                    </li>
                    <li class="list-group-item">
                        <strong>SIRET :</strong>
                        {{ $siretFmt }}
                    </li>
                    <li class="list-group-item">
                        <strong>Adresse :</strong>
                        {{ $quote->adresse ?? '—' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Secteur :</strong>
                        @if(!empty($quote->secteur))
                            <span class="badge bg-info text-dark text-uppercase ms-1">{{ $quote->secteur }}</span>
                        @else
                            —
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Opérations :</strong>
                        @if(!empty($ops))
                            @foreach($ops as $op)
                                <span class="badge bg-secondary text-capitalize ms-1">{{ $op }}</span>
                            @endforeach
                        @else
                            —
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <hr>

        <div class="text-muted small">
            <strong>Created At :</strong>
            {{ optional($quote->created_at)->format('Y-m-d H:i') ?? '—' }}
            &nbsp;|&nbsp;
            <strong>Updated At :</strong>
            {{ optional($quote->updated_at)->format('Y-m-d H:i') ?? '—' }}
        </div>
    </div>
</div>
@endsection
