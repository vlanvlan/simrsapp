@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <h3>Dashboard - SIMRS Application</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon purple mb-2">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Employees</h6>
                                    <h6 class="font-extrabold mb-0">{{ App\Models\Employee::count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi bi-building"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Units</h6>
                                    <h6 class="font-extrabold mb-0">{{ App\Models\Unit::count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Positions</h6>
                                    <h6 class="font-extrabold mb-0">{{ App\Models\Position::count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi bi-bank"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Bank Accounts</h6>
                                    <h6 class="font-extrabold mb-0">{{ App\Models\Bank::count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Welcome to SIMRS Application</h4>
                </div>
                <div class="card-body">
                    <p>Welcome, <strong>{{ Auth::user()->name }}</strong>! You are logged in as <span class="badge bg-primary">{{ Auth::user()->role ?? 'User' }}</span>.</p>

                    @if(Auth::user()->employee)
                    <div class="alert alert-success">
                        <h6><i class="bi bi-check-circle"></i> Employee Information</h6>
                        <p class="mb-1"><strong>Employee Code:</strong> {{ Auth::user()->employee->employee_code }}</p>
                        <p class="mb-1"><strong>Position:</strong> {{ Auth::user()->employee->position->name ?? 'N/A' }}</p>
                        <p class="mb-0"><strong>Unit:</strong> {{ Auth::user()->employee->unit->name ?? 'N/A' }}</p>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Account Information</h6>
                        <p class="mb-0">Your account is not linked to an employee record.</p>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6>Quick Actions</h6>
                            <div class="list-group">
                                <a href="{{ route('employees.index') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-people me-2"></i> Manage Employees
                                </a>
                                <a href="{{ route('units.index') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-building me-2"></i> Manage Units
                                </a>
                                <a href="{{ route('positions.index') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-briefcase me-2"></i> Manage Positions
                                </a>
                                <a href="{{ route('banks.index') }}" class="list-group-item list-group-item-action">
                                    <i class="bi bi-bank me-2"></i> Manage Bank Accounts
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>System Status</h6>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i> System is running normally
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> Database connection: Active
                            </div>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i> Last backup: Check logs
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

