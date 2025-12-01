@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Profile</h3>
                <p class="text-subtitle text-muted">Update your personal information and employment details</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label fw-bold">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->employee->name ?? $user->name) }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="employee_code" class="form-label fw-bold">Employee Code</label>
                                        <input type="text" id="employee_code" name="employee_code" class="form-control" value="{{ old('employee_code', $user->employee->employee_code ?? '') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->employee->phone ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="NIK" class="form-label fw-bold">NIK</label>
                                        <input type="text" id="NIK" name="NIK" class="form-control" value="{{ old('NIK', $user->employee->NIK ?? '') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="NPWP" class="form-label fw-bold">NPWP</label>
                                        <input type="text" id="NPWP" name="NPWP" class="form-control" value="{{ old('NPWP', $user->employee->NPWP ?? '') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Birthplace" class="form-label fw-bold">Birthplace</label>
                                        <input type="text" id="Birthplace" name="Birthplace" class="form-control" value="{{ old('Birthplace', $user->employee->Birthplace ?? '') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Birthdate" class="form-label fw-bold">Birthdate</label>
                                        <input type="date" id="Birthdate" name="Birthdate" class="form-control" value="{{ old('Birthdate', isset($user->employee->Birthdate) ? $user->employee->Birthdate->format('Y-m-d') : '') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <textarea id="address" name="address" class="form-control" rows="3">{{ old('address', $user->employee->address ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Changes
                                </button>
                                <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
