@extends('layouts.back')

@section('title', 'Category Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Category Details</h4>
        <div>
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-2"></i>Delete
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>ID:</strong>
            <p>{{ $category->id }}</p>
        </div>
        <div class="mb-3">
            <strong>Name:</strong>
            <p>{{ $category->name }}</p>
        </div>
        <div class="mb-3">
            <strong>Created At:</strong>
            <p>{{ $category->created_at->format('F j, Y \a\t g:i a') }}</p>
        </div>
        <div class="mb-3">
            <strong>Updated At:</strong>
            <p>{{ $category->updated_at->format('F j, Y \a\t g:i a') }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>
</div>
@endsection