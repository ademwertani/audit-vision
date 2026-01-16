@extends('layouts.back')

@section('title', 'Project Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Project Details</h4>
        <div class="btn-group">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            {{-- Image principale --}}
            <div class="col-md-4 mb-4 mb-md-0">
                @if($project->image)
                    <img
                        src="{{ asset('storage/' . $project->image) }}"
                        alt="{{ $project->name }}"
                        class="img-fluid rounded">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
            </div>

            {{-- Infos projet --}}
            <div class="col-md-8">
                <h3>{{ $project->name }}</h3>
                <p class="text-muted mt-2">
                    {{ $project->summary }}
                </p>

                <div class="mt-4">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
