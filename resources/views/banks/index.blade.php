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
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('banks.create') }}" class="btn btn-primary">Add Bank Account</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Account Number</th>
                            <th>Bank</th>
                            <th>Account Type</th>
                            <th>Currency</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banks as $bank)

                        <tr>
                            <td>{{ $bank->account_name }}</td>
                            <td>{{ $bank->account_number }}</td>
                            <td>{{ $bank->financialInstitution ? $bank->financialInstitution->name : 'No Bank' }}</td>
                            <td>{{ $bank->account_type }}</td>
                            <td>{{ $bank->currency }}</td>
                            <td>
                                <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

@include('components.sweet-alert-delete')

@endsection

