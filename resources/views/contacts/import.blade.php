@extends('layouts.app')

@section('title', 'Import Contacts from XML')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-upload me-2"></i>Import Contacts from XML
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="xml_file" class="form-label">
                            <i class="fas fa-file-code me-1"></i>Select XML File *
                        </label>
                        <input type="file" 
                               class="form-control @error('xml_file') is-invalid @enderror" 
                               id="xml_file" 
                               name="xml_file" 
                               accept=".xml"
                               required>
                        @error('xml_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Maximum file size: 2MB. Only XML files are allowed.
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Contacts
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-1"></i>Import Contacts
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
