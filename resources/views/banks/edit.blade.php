@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Banks</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bank</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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

                <form action="{{ route('banks.update', $bank->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="account_name" class="form-label">Account Name</label>
                        <input type="text" class="form-control" id="account_name" name="account_name" value="{{ old('account_name', $bank->account_name) }}" required>
                        @error('account_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" value="{{ old('account_number', $bank->account_number) }}" required>
                        @error('account_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Financial Institution</label>
                        <select class="form-select" id="institution_id" name="institution_id" required>
                            <option value="">Select Institution</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" {{ old('institution_id', $bank->institution_id) == $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="branch_id" class="form-label">Branch</label>
                        <select class="form-select" id="branch_id" name="branch_id" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" data-institution-id="{{ $branch->institution_id }}" {{ old('branch_id', $bank->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_type" class="form-label">Account Type</label>
                        <input type="text" class="form-control" id="account_type" name="account_type" value="{{ old('account_type', $bank->account_type) }}" required>
                        @error('account_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <select class="form-select" id="currency" name="currency" required>
                            <option value="">Select Currency</option>
                                <option value="IDR" {{ old('currency', $bank->currency) == 'IDR' ? 'selected' : '' }}>IDR</option>
                                <option value="USD" {{ old('currency', $bank->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                </option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="opened_date" class="form-label">Opened Date</label>
                        <input type="date" class="form-control datepicker" id="opened_date" name="opened_date" value="{{ old('opened_date', $bank->opened_date) }}">
                        @error('opened_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="closed_date" class="form-label">Closed Date</label>
                        <input type="date" class="form-control datepicker" id="closed_date" name="closed_date" value="{{ old('closed_date', $bank->closed_date) }}">
                        @error('closed_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $bank->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', $bank->is_active) == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active', $bank->is_active) == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Bank</button>
                    <a href="{{ route('banks.index') }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>

    </section>
</div>

@endsection

@section('scripts')
<!-- Simple script to filter branches based on selected institution -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const institutionSelect = document.getElementById('institution_id');
    const branchSelect = document.getElementById('branch_id');
    const branchOptions = Array.from(branchSelect.options).slice(1);
    const originalBranchValue = branchSelect.value;

    institutionSelect.addEventListener('change', function() {
        const selectedInstitutionId = this.value;
        const currentBranchValue = branchSelect.value;

        // Clear current options
        branchSelect.innerHTML = '<option value="">Select Branch</option>';

        if (selectedInstitutionId) {
            // Add matching branches
            branchOptions.forEach(function(option) {
                if (option.dataset.institutionId == selectedInstitutionId) {
                    const newOption = option.cloneNode(true);
                    // Restore selection if this was the previously selected branch
                    if (newOption.value == currentBranchValue || newOption.value == originalBranchValue) {
                        newOption.selected = true;
                    }
                    branchSelect.appendChild(newOption);
                }
            });
        } else {
            // Show all branches
            branchOptions.forEach(function(option) {
                const newOption = option.cloneNode(true);
                // Restore selection if this was the previously selected branch
                if (newOption.value == currentBranchValue || newOption.value == originalBranchValue) {
                    newOption.selected = true;
                }
                branchSelect.appendChild(newOption);
            });
        }

        // Update Choices.js
        if (window.branchChoices) {
            window.branchChoices.destroy();
            window.branchChoices = new Choices(branchSelect);
        }
    });

    // Initialize on page load
    if (institutionSelect.value) {
        institutionSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection

