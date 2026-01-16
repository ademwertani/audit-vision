@extends('layouts.back')

@section('title', 'YouTube Videos')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Liste des vidéos YouTube</h4>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Ajouter une vidéo
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($videos->isEmpty())
            <p class="mb-0">Aucune vidéo pour le moment.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>URL</th>
                            <th>Titre</th>
                            <th>Créée le</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($videos as $video)
                            <tr>
                                <td>{{ $video->id }}</td>
                                <td>
                                    <a href="{{ $video->url }}" target="_blank">
                                        {{ Str::limit($video->url, 50) }}
                                    </a>
                                </td>
                                <td>{{ $video->title ?? '—' }}</td>
                                <td>{{ $video->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.videos.destroy', $video->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer cette vidéo ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{ $videos->links() }}
        @endif
    </div>
</div>
@endsection
