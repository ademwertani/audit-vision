@extends('layouts.back')

@section('title','Stats')

@section('content')
<div class="card shadow-sm">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h4 class="mb-0">Statistiques (home)</h4>
    @if(session('success')) <div class="text-success fw-semibold">{{ session('success') }}</div> @endif
  </div>

  <div class="card-body">
    {{-- Create --}}
    <form class="row g-2 mb-4" method="POST" action="{{ route('admin.stats.store') }}">
      @csrf
      <div class="col-md-3">
        <input type="text" name="label" class="form-control" placeholder="Label (ex: Homes)" required>
      </div>
      <div class="col-md-2">
        <input type="text" name="slug" class="form-control" placeholder="Slug (optionnel)">
      </div>
      <div class="col-md-2">
        <input type="number" name="value" class="form-control" placeholder="Valeur" min="0" required>
      </div>
      <div class="col-md-2">
        <input type="number" name="display_order" class="form-control" placeholder="Ordre" value="0">
      </div>
      <div class="col-md-2 d-flex align-items-center gap-2">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="1" name="is_accent" id="createAccent">
          <label for="createAccent" class="form-check-label">Accent</label>
        </div>
      </div>
      <div class="col-md-1">
        <button class="btn btn-primary w-100">Ajouter</button>
      </div>
    </form>

    {{-- List/Update inline --}}
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Label</th><th>Slug</th><th>Valeur</th><th>Ordre</th><th>Accent</th><th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($stats as $s)
            <tr>
              <form method="POST" action="{{ route('admin.stats.update', $s) }}">
                @csrf @method('PUT')
                <td style="min-width:180px">
                  <input type="text" name="label" class="form-control" value="{{ $s->label }}" required>
                </td>
                <td style="min-width:140px">
                  <input type="text" name="slug" class="form-control" value="{{ $s->slug }}">
                </td>
                <td style="width:140px">
                  <input type="number" name="value" class="form-control" value="{{ $s->value }}" min="0" required>
                </td>
                <td style="width:120px">
                  <input type="number" name="display_order" class="form-control" value="{{ $s->display_order }}">
                </td>
                <td style="width:120px">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_accent" value="1" {{ $s->is_accent ? 'checked' : '' }}>
                  </div>
                </td>
                <td class="text-end">
                  <button class="btn btn-sm btn-success">Mettre à jour</button>
              </form>
                  <form class="d-inline" method="POST" action="{{ route('admin.stats.destroy', $s) }}" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                  </form>
                </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted">Aucune stat pour le moment.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
