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
                        <th>Galerie</th> {{-- ✅ nouvelle colonne --}}
                        <th>Name</th>
                        <th>Service</th>
                        <th>Secteur</th>
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
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}" class="img-thumbnail" style="width:60px;height:60px;object-fit:cover;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>

                            {{-- ✅ Galerie (affichage badge + mini preview on hover) --}}
                            <td>
                                @if(!empty($project->images))
                                    <span class="badge bg-success">{{ count($project->images) }} imgs</span>

                                    {{-- Mini preview au survol --}}
                                    <div class="d-flex gap-1 mt-1">
                                        @foreach(array_slice($project->images, 0, 3) as $img)
                                            <img src="{{ Storage::url($img) }}" class="rounded border" style="width:30px;height:30px;object-fit:cover;" alt="gallery img">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>{{ $project->name }}</td>

                            <td>
                                @if($project->service)
                                    <span class="badge bg-primary">{{ $project->service->name }}</span>
                                @else
                                    <span class="text-muted">No service</span>
                                @endif
                            </td>

                            <td>
                                @if($project->secteur)
                                    @php
                                        $map = [
                                            'Tertiaire' => 'bg-info',
                                            'Industrie' => 'bg-warning text-dark',
                                            'Agricole'  => 'bg-success',
                                        ];
                                        $cls = $map[$project->secteur] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $cls }}">{{ $project->secteur }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>{{ $project->summary }}</td>

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
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
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
