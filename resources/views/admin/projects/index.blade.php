@extends('layouts.back')

@section('title', 'Projects Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Projects Management</h2>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create New Project
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="table" class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Summary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>

                            {{-- Image principale --}}
                            <td>
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}"
                                         alt="{{ $project->name }}"
                                         class="img-thumbnail"
                                         style="width:60px;height:60px;object-fit:cover;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>

                            <td>{{ $project->name }}</td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($project->summary, 80) }}
                            </td>

                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
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

        @if(method_exists($projects, 'links'))
            <div class="mt-3">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
