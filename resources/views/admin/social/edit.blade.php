@extends('layouts.back')

@section('title', 'Social Links')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Manage Social Links</h4>
    </div>
    <div class="card-body">
        

        <form action="{{ route('admin.social.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook URL</label>
                <input type="url" class="form-control" id="facebook" name="facebook" 
                       value="{{ old('facebook', $social->facebook) }}" 
                       placeholder="https://facebook.com/yourpage">
            </div>
            
            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram URL</label>
                <input type="url" class="form-control" id="instagram" name="instagram" 
                       value="{{ old('instagram', $social->instagram) }}"
                       placeholder="https://instagram.com/yourpage">
            </div>
            
            <div class="mb-3">
                <label for="linkedin" class="form-label">LinkedIn URL</label>
                <input type="url" class="form-control" id="linkedin" name="linkedin" 
                       value="{{ old('linkedin', $social->linkedin) }}"
                       placeholder="https://linkedin.com/company/yourpage">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Changes
            </button>
        </form>
    </div>
</div>
@endsection