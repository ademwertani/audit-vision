@extends('layouts.back')

@section('title', 'YouTube Video')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Manage YouTube Video</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.video.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="url" class="form-label">YouTube URL</label>
                <input type="url" class="form-control" id="url" name="url" value="{{ old('url', $video->url) }}" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
