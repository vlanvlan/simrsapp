@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Employees</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Employee</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic Tables start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form" action="{{ route('employees.update', $employee->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="employee_code">Employee Code</label>
                                            <input type="text" id="employee_code" class="form-control" name="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" required>
                                            @error('employee_code')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $employee->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="position_id">Position</label>
                                            <select class="form-select" id="position_id" name="position_id" required>
                                                <option value="{{ old('position_id', $employee->position_id) }}" selected>{{ $employee->position->name }}</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('position_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="unit_id">Unit</label>
                                            <select class="form-select" id="unit_id" name="unit_id" required>
                                                <option value="{{ old('unit_id', $employee->unit_id) }}" selected>{{ $employee->unit->name }}</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="hire_date">Hire Date</label>
                                            <input type="date" id="hire_date" class="form-control datepicker" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" placeholder="Hire Date" required>
                                            @error('hire_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="date" id="end_date" class="form-control datepicker" name="end_date" value="{{ old('end_date', $employee->end_date) }}" placeholder="End Date">
                                            @error('end_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="employment_status">Employment Status</label>
                                            <select class="form-select" id="employment_status" name="employment_status" required>
                                                <option value="{{ old('employment_status', $employee->employment_status) }}" selected>{{ ucfirst($employee->employment_status) }}</option>
                                                <option value="permanent">Permanent</option>
                                                <option value="contract">Contract</option>
                                                <option value="internship">Internship</option>
                                            </select>
                                            @error('employment_status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="{{ old('gender', $employee->gender) }}" selected>{{ ucfirst($employee->gender) }}</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" id="nik" class="form-control" name="nik" value="" placeholder="NIK" required>
                                            @error('nik')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="npwp">NPWP</label>
                                            <input type="text" id="npwp" class="form-control" name="npwp" value="" placeholder="NPWP">
                                            @error('npwp')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="birth_place">Birth Place</label>
                                            <input type="text" id="birth_place" class="form-control" name="birth_place" value="" placeholder="Birth Place" required>
                                            @error('birth_place')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="birth_date">Birth Date</label>
                                            <input type="date" id="birth_date" class="form-control datepicker" name="birth_date" value="" placeholder="Birth Date" required>
                                            @error('birth_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" id="address" class="form-control" name="address" value="" placeholder="Address" required>
                                            @error('address')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" id="phone" class="form-control" name="phone" value="" placeholder="Phone" required>
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="supervisor_name">Supervisor Name</label>
                                            <select class="form-select" id="supervisor_id" name="supervisor_id">
                                                <option value="" selected>Select Supervisor</option>
                                                @foreach ($employees as $supervisor)
                                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('supervisor_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                    </div>

                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Update Employee</button>
                                        <a href="{{ route('employees.index') }}" class="btn btn-secondary me-1 mb-1">Cancel</a>
                                    </div>
                                </div>
                            </form>

    </section>

</div>

@endsection

