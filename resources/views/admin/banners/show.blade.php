@extends('layouts.back')

@section('title', 'Banner Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Banner Details</h4>
        <div class="btn-group">
            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-1"></i>Delete
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="img-fluid rounded">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                        <span class="text-muted">No image available</span>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h3>{{ $banner->title }}</h3>
                <p class="lead">{{ $banner->summary }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection