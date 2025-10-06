@extends('layouts.back')
@section('title','Modifier un avis')

@section('content')
<div class="card shadow-sm">
  <div class="card-header"><h4 class="mb-0">Modifier l’avis</h4></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
      @csrf @method('PUT')
      @include('admin.customers._form', ['customer' => $customer])
      <button class="btn btn-primary"><i class="fas fa-save me-2"></i> Mettre à jour</button>
      <a href="{{ route('admin.customers.index') }}" class="btn btn-light">Annuler</a>
    </form>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
@endpush
