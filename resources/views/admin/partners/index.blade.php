@extends('layouts.back')

@section('title', 'Partners')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Partners</h3>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-success">
        <i class="fa fa-plus me-2"></i>Ajouter un partenaire
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle" id="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Nom</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>{{ $partner->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . ltrim($partner->logo, '/')) }}"
                                 alt="{{ $partner->name }}" style="height:48px; width:auto; object-fit:contain;">
                        </td>
                        <td>{{ $partner->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce partenaire ?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Aucun partenaire pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
