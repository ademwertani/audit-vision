@extends('layouts.back')

@section('title', 'Avis clients')

@section('content')
<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Avis clients</h4>
    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
      <i class="fa-solid fa-plus me-2"></i>Nouvel avis
    </a>
  </div>

  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($customers->count())
      <div class="table-responsive">
        <table class="table align-middle">
  <thead>
    <tr>
      <th>Client</th>
      <th>Titre</th>
      <th>Note</th>
      <th>Créé le</th>
      <th class="text-end">Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($customers as $c)
    <tr>
      <td>{{ $c->customer_name }}</td>
      <td>{{ $c->title }}</td>
      <td>
        @for($i=1;$i<=5;$i++)
          <i class="{{ $i <= (int)$c->note ? 'fa-solid' : 'fa-regular' }} fa-star text-warning"></i>
        @endfor
        <small class="text-muted ms-1">({{ (int)$c->note }}/5)</small>
      </td>
      <td>{{ $c->created_at->format('d/m/Y') }}</td>
      <td class="text-end">
        <a href="{{ route('admin.customers.edit',$c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
        <form action="{{ route('admin.customers.destroy',$c) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')">Del</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

{{ $customers->links() }}

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
@endpush

      </div>

      <div class="mt-3">
        {{ $customers->links() }}
      </div>
    @else
      <p class="mb-0 text-muted">Aucun avis pour le moment.</p>
    @endif
  </div>
</div>
@endsection
