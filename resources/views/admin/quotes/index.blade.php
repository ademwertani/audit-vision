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
                <table id='table' class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotes as $quote)
                            <tr>
                                <td>{{ $quote->id }}</td>
                                <td>{{ $quote->nom }}</td>
                                <td>{{ $quote->prenom }}</td>
                                <td>{{ $quote->email }}</td>
                                <td>{{ $quote->adresse }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.quotes.edit', $quote->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.quotes.destroy', $quote->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection