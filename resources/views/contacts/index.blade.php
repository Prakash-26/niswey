@extends('layouts.app')

@section('title', 'All Contacts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-address-book me-2"></i>All Contacts</h1>
    <div>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Add New Contact
        </a>
        <a href="{{ route('contacts.import.form') }}" class="btn btn-success">
            <i class="fas fa-upload me-1"></i>Import XML
        </a>
    </div>
</div>

@if($contacts->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>
                                    <strong>{{ $contact->name }}</strong>
                                </td>
                                <td>
                                    @if($contact->phone)
                                        <i class="fas fa-phone me-1 text-muted"></i>
                                        {{ $contact->phone }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($contact->company)
                                        <i class="fas fa-building me-1 text-muted"></i>
                                        {{ $contact->company }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('contacts.show', $contact) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('contacts.edit', $contact) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('contacts.destroy', $contact) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this contact?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
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
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $contacts->links("pagination::bootstrap-4") }}
    </div>
@else
    <div class="text-center">
        <div class="card">
            <div class="card-body py-5">
                <i class="fas fa-address-book fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No contacts found</h4>
                <p class="text-muted">Get started by adding your first contact or importing from XML.</p>
                <div class="mt-3">
                    <a href="{{ route('contacts.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-1"></i>Add First Contact
                    </a>
                    <a href="{{ route('contacts.import.form') }}" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i>Import from XML
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
