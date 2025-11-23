@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Financial Branches</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Financial Branch</li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('financial-branches.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Code <small class="text-muted">(Auto-generated)</small></label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" readonly>
                        @error('code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Financial Institution</label>
                        <select class="form-select" id="institution_id" name="institution_id" required data-institution-code="">
                            <option value="" disabled selected>Select Financial Institution</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" data-code="{{ $institution->code }}" {{ old('institution_id') == $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }} ({{ $institution->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Financial Branch</button>
                    <a href="{{ route('financial-branches.index') }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>

    </section>
</div>

@endsection

@section('scripts')
<!-- Auto-generate branch code based on selected institution -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const institutionSelect = document.getElementById('institution_id');
    const codeInput = document.getElementById('code');

    institutionSelect.addEventListener('change', function() {
        const institutionId = this.value;
        
        if (!institutionId) {
            codeInput.value = '';
            return;
        }

        // Show loading indicator
        codeInput.value = 'Generating...';
        codeInput.style.backgroundColor = '#f8f9fa';

        // Fetch next code from server
        fetch(`{{ route('financial-branches.next-code') }}?institution_id=${institutionId}`)
            .then(response => response.json())
            .then(data => {
                if (data.code) {
                    codeInput.value = data.code;
                    codeInput.style.backgroundColor = '#d4edda'; // Light green
                } else {
                    codeInput.value = '';
                    alert('Error generating code: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                codeInput.value = '';
                alert('Error generating code. Please try again.');
            })
            .finally(() => {
                // Reset background after 2 seconds
                setTimeout(() => {
                    codeInput.style.backgroundColor = '';
                }, 2000);
            });
    });

    // If there's an old value selected (validation error), generate code
    if (institutionSelect.value) {
        institutionSelect.dispatchEvent(new Event('change'));
    }
});
</script>

