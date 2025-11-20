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

                <form action="{{ route('banks.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="account_name" class="form-label">Account Name</label>
                        <input type="text" class="form-control" id="account_name" name="account_name" value="{{ old('account_name') }}" required>
                        @error('account_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" value="{{ old('account_number') }}" required>
                        @error('account_number')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Financial Institution</label>
                        <select class="form-select" id="institution_id" name="institution_id" required>
                            <option value="">Select Institution</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" {{ old('institution_id') == $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="account_type" class="form-label">Account Type</label>
                        <input type="text" class="form-control" id="account_type" name="account_type" value="{{ old('account_type') }}" required>
                        @error('account_type')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <select class="form-select" id="currency" name="currency" required>
                            <option value="">Select Currency</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="IDR" {{ old('currency') == 'IDR' ? 'selected' : '' }}>IDR</option>
                                <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY</option>
                                <option value="CNY" {{ old('currency') == 'CNY' ? 'selected' : '' }}>CNY</option>
                                </option>
                        </select>
                        @error('currency')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="opened_date" class="form-label">Opened Date</label>
                        <input type="date" class="form-control datepicker" id="opened_date" name="opened_date" value="{{ old('opened_date') }}">
                        @error('opened_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Bank</button>
                    <a href="{{ route('banks.index') }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>

    </section>
</div>

@endsection

