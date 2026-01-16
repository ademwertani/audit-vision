@extends('layouts.back')

@section('title', 'Liste des certificats')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des certificats</h1>
    <a href="{{ route('admin.certificats.create') }}" class="btn btn-primary mb-3">Ajouter un certificat</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Image</th>
                <th>PDF</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certificats as $certificat)
            <tr>
                <td>{{ $certificat->name }}</td>
                <td>{{ Str::limit($certificat->description, 50) }}</td>
                <td>
                    @if($certificat->image)
                    <img src="{{ asset('storage/' . $certificat->image) }}" width="50" />
                    @else
                    Aucune image
                    @endif
                </td>
                <td>
                    <a href="{{ asset('storage/' . $certificat->pdf_file) }}" target="_blank">Voir le PDF</a>
                </td>
                <td>
                    <a href="{{ route('admin.certificats.edit', $certificat->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.certificats.destroy', $certificat->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce certificat ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $certificats->links() }}
</div>
@endsection
