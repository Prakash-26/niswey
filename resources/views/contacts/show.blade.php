@extends('layouts.app')

@section('title', 'Contact Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>{{ $contact->name }}
                    </h4>
                    <div>
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('contacts.destroy', $contact) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this contact?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-phone me-1"></i>Phone Number
                            </h6>
                            <p class="h5">
                                {{ $contact->phone ?? 'Not provided' }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-building me-1"></i>Company
                            </h6>
                            <p class="h5">
                                {{ $contact->company ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-calendar me-1"></i>Added
                            </h6>
                            <p class="h5">
                                {{ $contact->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($contact->address)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>Address
                        </h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $contact->address }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="row text-muted small">
                    <div class="col-md-6">
                        <strong>Created:</strong> {{ $contact->created_at->format('M d, Y \a\t g:i A') }}
                    </div>
                    <div class="col-md-6">
                        <strong>Last Updated:</strong> {{ $contact->updated_at->format('M d, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Contacts
                    </a>
                    <div>
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
