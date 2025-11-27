@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Deposits</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Deposit</li>
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
                    <a href="{{ route('deposits.create') }}" class="btn btn-primary">Add Deposit</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>No Bilyet</th>
                            <th>Bank Account</th>
                            <th>Deposit Date</th>
                            <th>Total Amount</th>
                            <th>Interest Rate</th>
                            <th>Interest Amount</th>
                            <th>Principal Amount</th>
                            <th>Penempatan</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deposits as $deposit)
                        <tr>
                            <td>
                                <span class="badge bg-primary">{{ $deposit->code ?: 'Not Generated' }}</span>
                            </td>
                            <td>{{ $deposit->no_bilyet }}</td>
                            <td>{{ $deposit->bankAccount ? $deposit->bankAccount->account_number : 'No Bank Account' }}</td>
                            <td>{{ $deposit->deposit_date }}</td>
                            <td><strong>{{ number_format($deposit->amount, 2, ',', '.') }}</strong></td>
                            <td>{{ $deposit->interest_rate }}%</td>
                            <td>{{ number_format($deposit->interest_amount, 2, ',', '.') }}</td>
                            <td>{{ number_format($deposit->total_amount, 2, ',', '.') }}</td>
                            <td>
                                @if ($deposit->penempatan == 'pembukaan')
                                    <span class="badge bg-success">Pembukaan</span>
                                @elseif ($deposit->penempatan == 'perpanjangan')
                                    <span class="badge bg-warning">Perpanjangan</span>
                                @elseif ($deposit->penempatan == 'pencairan')
                                    <span class="badge bg-danger">Pencairan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('deposits.edit', $deposit->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('deposits.destroy', $deposit->id) }}" method="POST" class="d-inline">
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

