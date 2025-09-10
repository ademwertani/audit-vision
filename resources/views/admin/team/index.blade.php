@extends('layouts.back')

@section('title', 'Team Members')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Team Management</h4>
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Member
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id='table' class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>LinkedIn</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                    <tr>
                        <td>
                            <img src="{{ $team->image_url }}" alt="{{ $team->name }}" 
                                 class="rounded-circle" width="50" height="50">
                        </td>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->role }}</td>
                        <td>
                            @if($team->linkedin)
                            <a href="{{ $team->linkedin }}" target="_blank">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.teams.show', $team->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.teams.edit', $team->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST">
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
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No team members found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection