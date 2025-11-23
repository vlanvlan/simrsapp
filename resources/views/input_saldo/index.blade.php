@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Saldo</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Saldo</li>
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
                    <a href="{{ route('units.create') }}" class="btn btn-primary">Add New Unit</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                    <table class="table table-striped table-bordered" id="table1">
                        <thead>
                            <tr>
                                <th>Bank Account</th>
                                <th>Balance Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($input_saldos as $input_saldo)
                                <tr>
                                    <td>{{ $input_saldo->bankAccount ? $input_saldo->bankAccount->account_name : 'No Bank Account' }}</td>
                                    <td>{{ $input_saldo->balance_date }}</td>
                                    <td>{{ number_format($input_saldo->amount, 2) }}</td>
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

