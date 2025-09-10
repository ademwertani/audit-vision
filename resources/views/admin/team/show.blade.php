@extends('layouts.back')

@section('title', 'View Team Member')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Team Member Details</h4>
        <div>
            <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-2"></i>Delete
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ $team->image_url }}" alt="{{ $team->name }}" 
                     class="img-fluid rounded" style="max-height: 300px;">
            </div>
            <div class="col-md-8">
                <h3>{{ $team->name }}</h3>
                <h5 class="text-muted">{{ $team->role }}</h5>
                <hr>
                @if($team->linkedin)
                <div class="mb-3">
                    <strong>LinkedIn:</strong>
                    <p><a href="{{ $team->linkedin }}" target="_blank">{{ $team->linkedin }}</a></p>
                </div>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Team
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection