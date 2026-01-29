@extends('layouts.back')

@section('title', 'View Contact Message')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Message Details</h5>
        <div>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <strong>Company Name:</strong>
            <p>{{ $contact->company_name }}</p>
        </div>
        <div class="mb-3">
            <strong>SIRET:</strong>
            <p>{{ $contact->siret }}</p>
        </div>
        <div class="mb-3">
            <strong>Email:</strong>
            <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
        </div>
        <div class="mb-3">
            <strong>Subject:</strong>
            <p>{{ $contact->subject }}</p>
        </div>
        <div class="mb-3">
            <strong>Message:</strong>
            <p class="border p-3 rounded bg-light">{{ $contact->message }}</p>
        </div>
        <div class="mb-3">
            <strong>Received:</strong>
            <p>{{ $contact->created_at->format('F j, Y \a\t g:i a') }}</p>
        </div>
    </div>
</div>
@endsection
