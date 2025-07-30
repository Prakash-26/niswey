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
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>XML Format Information</h6>
                    <p class="mb-2">Your XML file should follow this structure:</p>
                    <pre class="bg-light p-3 rounded small"><code>&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;contacts&gt;
    &lt;contact&gt;
        &lt;name&gt;John Doe&lt;/name&gt;
        &lt;phone&gt;+1-555-123-4567&lt;/phone&gt;
        &lt;company&gt;ABC Corporation&lt;/company&gt;
        &lt;address&gt;123 Main St, City, State 12345&lt;/address&gt;
    &lt;/contact&gt;
&lt;/contacts&gt;</code></pre>
                    <small class="text-muted">
                        <strong>Note:</strong> Name is the only required field. Phone, company, and address are optional.
                    </small>
                </div>

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
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notes</h6>
                        <ul class="mb-0">
                            <li>Contacts with duplicate names may be imported</li>
                            <li>Invalid contact data will be reported but won't stop the import process</li>
                            <li>All dates and times will be set to the current time for imported contacts</li>
                            <li>The import process will validate each contact before adding it to the database</li>
                        </ul>
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
