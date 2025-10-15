@extends('layouts.back')

@section('title', 'Quotes Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quotes Management</h2>
        <a href="{{ route('admin.quotes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Quote
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom bénéficiaire</th>
                            <th>Prénom bénéficiaire</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Secteur</th>
                            <th>Opérations</th>
                            <th>Adresse</th>
                            <th>Raison sociale</th>
                            <th>SIRET</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            @php
                                // Format SIRET "123 456 789 01234"
                                $siretDigits = preg_replace('/\D/', '', (string)($quote->siret ?? ''));
                                if (preg_match('/^(\d{3})(\d{3})(\d{3})(\d{5})$/', $siretDigits, $m)) {
                                    $siretFmt = "{$m[1]} {$m[2]} {$m[3]} {$m[4]}";
                                } else {
                                    $siretFmt = $siretDigits !== '' ? $siretDigits : '—';
                                }

                                // Robustesse : si cast JSON actif -> array ; sinon tenter json_decode
                                $ops = is_array($quote->operations)
                                    ? $quote->operations
                                    : (json_decode($quote->operations, true) ?: []);
                            @endphp
                            <tr>
                                <td>{{ $quote->id }}</td>
                                <td>{{ $quote->nom_beneficiaire ?? '—' }}</td>
                                <td>{{ $quote->prenom_beneficiaire ?? '—' }}</td>
                                <td>{{ $quote->email ?? '—' }}</td>
                                <td>{{ $quote->telephone ?? '—' }}</td>
                                <td>
                                    @if(!empty($quote->secteur))
                                        <span class="badge bg-info text-dark text-uppercase">{{ $quote->secteur }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($ops))
                                        @foreach($ops as $op)
                                            <span class="badge bg-secondary text-capitalize me-1">{{ $op }}</span>
                                        @endforeach
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $quote->adresse ?? '—' }}</td>
                                <td>{{ $quote->raison_sociale ?? '—' }}</td>
                                <td>{{ $siretFmt }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.quotes.edit', $quote->id) }}" class="btn btn-sm btn-warning" title="Éditer">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Êtes-vous sûr ?')"
                                                title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    Aucune demande de devis pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($quotes, 'links'))
                <div class="mt-3">
                    {{ $quotes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
