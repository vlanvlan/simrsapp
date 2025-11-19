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
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Employee Details</h5>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>Employee Code:</strong></label>
                            <p>{{ $employee->employee_code }}</p>
                            <label class="form-label"><strong>Name:</strong></label>
                            <p>{{ $employee->name }}</p>
                            <label class="form-label"><strong>Position:</strong></label>
                            <p>{{ $employee->position ? $employee->position->name : 'No Position' }}</p>
                            <label class="form-label"><strong>Unit:</strong></label>
                            <p>{{ $employee->unit ? $employee->unit->name : 'No Unit' }}</p>
                            <label class="form-label"><strong>Employee Status:</strong></label>
                            <p>{{ $employee->employee_status }}</p>
                            <label class="form-label"><strong>Hire Date:</strong></label>
                            <p>{{ \Carbon\Carbon::parse($employee->hire_date)->format('d F Y') }}</p>
                            <label class="form-label"><strong>End Date:</strong></label>
                            <p>{{ $employee->end_date ? \Carbon\Carbon::parse($employee->end_date)->format('d F Y') : '-' }}</p>
                            <label class="form-label"><strong>NIK</strong></label>
                            <p>{{ $employee->nik ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><strong>NPWP</strong></label>
                            <p>{{ $employee->npwp ?? '-' }}</p>
                            <label class="form-label"><strong>Gender</strong></label>
                            <p>
                                @if($employee->gender === 'male')Male
                                @elseif($employee->gender === 'female')Female
                                @else -
                                @endif
                            </p>
                            <label class="form-label"><strong>Birth Place</strong></label>
                            <p>{{ $employee->birth_place ?? '-' }}</p>
                            <label class="form-label"><strong>Birth Date</strong></label>
                            <p>{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d F Y') : '-' }}</p>
                            <label class="form-label"><strong>Address</strong></label>
                            <p>{{ $employee->address ?? '-' }}</p>
                            <label class="form-label"><strong>Phone</strong></label>
                            <p>{{ $employee->phone ?? '-' }}</p>
                            <label class="form-label"><strong>Supervisor</strong></label>
                            <p>{{ $employee->supervisor ? $employee->supervisor->name : '-' }}</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

    </section>
</div>

@endsection

