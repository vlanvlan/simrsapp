@extends('layouts.dashboard')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Saldo Input</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Saldo Input</li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('input-saldo.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Financial Institution</label>
                        <select class="form-select" id="institution_id" name="institution_id" required>
                            <option value="">Select Financial Institution</option>
                            @foreach($financialInstitutions as $institution)
                                <option value="{{ $institution->id }}" {{ old('institution_id') == $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bank_account_id" class="form-label">Bank Account</label>
                        <select class="form-select" id="bank_account_id" name="bank_account_id" required disabled>
                            <option value="">Select Financial Institution first</option>
                        </select>
                        <small class="text-muted">Select a financial institution above to see available accounts</small>
                        @error('bank_account_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="balance_date" class="form-label">Balance Date</label>
                        <input type="date" class="form-control datepicker" id="balance_date" name="balance_date" value="{{ old('balance_date') }}" required>
                        @error('balance_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="in" class="form-label">In</label>
                                <input type="number" step="0.01" class="form-control" id="in" name="in" value="{{ old('in', 0) }}" required>
                                @error('in')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="out" class="form-label">Out</label>
                                <input type="number" step="0.01" class="form-control" id="out" name="out" value="{{ old('out', 0) }}" required>
                                @error('out')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="masuk_pindah_buku" class="form-label">Masuk Pindah Buku</label>
                                <input type="number" step="0.01" class="form-control" id="masuk_pindah_buku" name="masuk_pindah_buku" value="{{ old('masuk_pindah_buku', 0) }}" required>
                                @error('masuk_pindah_buku')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="masuk_from_institution_id" class="form-label">From Financial Institution</label>
                                <select class="form-select" id="masuk_from_institution_id" name="masuk_from_institution_id">
                                    <option value="">Select Institution</option>
                                    @foreach($financialInstitutions as $institution)
                                        <option value="{{ $institution->id }}" {{ old('masuk_from_institution_id') == $institution->id ? 'selected' : '' }}>
                                            {{ $institution->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('masuk_from_institution_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="masuk_from_account_id" class="form-label">From Bank Account</label>
                                <select class="form-select" id="masuk_from_account_id" name="masuk_from_account_id" disabled>
                                    <option value="">Select Institution first</option>
                                </select>
                                <small class="text-muted">Select institution above to see available accounts</small>
                                @error('masuk_from_account_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="keluar_pindah_buku" class="form-label">Keluar Pindah Buku</label>
                                <input type="number" step="0.01" class="form-control" id="keluar_pindah_buku" name="keluar_pindah_buku" value="{{ old('keluar_pindah_buku', 0) }}" required>
                                @error('keluar_pindah_buku')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="keluar_to_institution_id" class="form-label">To Financial Institution</label>
                                <select class="form-select" id="keluar_to_institution_id" name="keluar_to_institution_id">
                                    <option value="">Select Institution</option>
                                    @foreach($financialInstitutions as $institution)
                                        <option value="{{ $institution->id }}" {{ old('keluar_to_institution_id') == $institution->id ? 'selected' : '' }}>
                                            {{ $institution->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('keluar_to_institution_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="keluar_to_account_id" class="form-label">To Bank Account</label>
                                <select class="form-select" id="keluar_to_account_id" name="keluar_to_account_id" disabled>
                                    <option value="">Select Institution first</option>
                                </select>
                                <small class="text-muted">Select institution above to see available accounts</small>
                                @error('keluar_to_account_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="previous_balance" class="form-label">Previous Balance</label>
                                <input type="number" step="0.01" class="form-control" id="previous_balance" name="previous_balance" value="{{ old('previous_balance', 0) }}" readonly style="background-color: #f8f9fa; color: #007bff; font-weight: bold;" required>
                                <small class="text-muted">Auto-loaded from last balance record</small>
                                @error('previous_balance')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="balance_amount" class="form-label">Final Balance Amount</label>
                                <input type="number" step="0.01" class="form-control" id="balance_amount" name="balance_amount" value="{{ old('balance_amount', 0) }}" readonly style="background-color: #f8f9fa; color: #007bff; font-weight: bold;">
                                <small class="text-muted">Auto-calculated: Previous Balance + In + Masuk Pindah Buku - Out - Keluar Pindah Buku</small>
                                @error('balance_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                    <a href="{{ route('input-saldo.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>

    </section>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const institutionSelect = document.getElementById('institution_id');
    const bankAccountSelect = document.getElementById('bank_account_id');

    const masukFromInstitutionSelect = document.getElementById('masuk_from_institution_id');
    const masukFromAccountSelect = document.getElementById('masuk_from_account_id');

    const keluarToInstitutionSelect = document.getElementById('keluar_to_institution_id');
    const keluarToAccountSelect = document.getElementById('keluar_to_account_id');

    // Balance calculation elements
    const previousBalanceInput = document.getElementById('previous_balance');
    const inInput = document.getElementById('in');
    const outInput = document.getElementById('out');
    const masukPindahBukuInput = document.getElementById('masuk_pindah_buku');
    const keluarPindahBukuInput = document.getElementById('keluar_pindah_buku');
    const balanceAmountInput = document.getElementById('balance_amount');

    // Function to calculate balance amount
    function calculateBalanceAmount() {
        const previousBalance = parseFloat(previousBalanceInput.value) || 0;
        const inAmount = parseFloat(inInput.value) || 0;
        const outAmount = parseFloat(outInput.value) || 0;
        const masukPindahBuku = parseFloat(masukPindahBukuInput.value) || 0;
        const keluarPindahBuku = parseFloat(keluarPindahBukuInput.value) || 0;

        const finalBalance = previousBalance + inAmount + masukPindahBuku - outAmount - keluarPindahBuku;
        balanceAmountInput.value = finalBalance.toFixed(2);
    }

    // Add event listeners for auto-calculation (previous_balance is auto-loaded, not user input)
    inInput.addEventListener('input', calculateBalanceAmount);
    outInput.addEventListener('input', calculateBalanceAmount);
    masukPindahBukuInput.addEventListener('input', calculateBalanceAmount);
    keluarPindahBukuInput.addEventListener('input', calculateBalanceAmount);

    // Initial calculation
    calculateBalanceAmount();

    // Function to fetch and populate bank accounts
    function populateBankAccounts(institutionId, targetSelect, placeholderText) {
        targetSelect.innerHTML = `<option value="">${placeholderText}</option>`;
        targetSelect.disabled = true;

        if (institutionId) {
            fetch(`{{ route('input_saldo.bank_accounts') }}?institution_id=${institutionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(bankAccount => {
                            const option = document.createElement('option');
                            option.value = bankAccount.id;
                            option.textContent = `${bankAccount.account_number} - ${bankAccount.account_name}`;
                            targetSelect.appendChild(option);
                        });
                        targetSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error fetching bank accounts:', error);
                });
        }
    }

    // Main institution change event
    institutionSelect.addEventListener('change', function() {
        const institutionId = this.value;
        populateBankAccounts(institutionId, bankAccountSelect, 'Select Bank Account');
    });

    // Bank account change event - fetch previous balance
    bankAccountSelect.addEventListener('change', function() {
        const bankAccountId = this.value;

        if (bankAccountId) {
            fetch(`{{ route('input_saldo.last_balance') }}?bank_account_id=${bankAccountId}`)
                .then(response => response.json())
                .then(data => {
                    previousBalanceInput.value = data.previous_balance;
                    calculateBalanceAmount();
                })
                .catch(error => {
                    console.error('Error fetching previous balance:', error);
                    previousBalanceInput.value = 0;
                    calculateBalanceAmount();
                });
        } else {
            previousBalanceInput.value = 0;
            calculateBalanceAmount();
        }
    });

    // Masuk pindah buku institution change event
    masukFromInstitutionSelect.addEventListener('change', function() {
        const institutionId = this.value;
        populateBankAccounts(institutionId, masukFromAccountSelect, 'Select Source Account');
    });

    // Keluar pindah buku institution change event
    keluarToInstitutionSelect.addEventListener('change', function() {
        const institutionId = this.value;
        populateBankAccounts(institutionId, keluarToAccountSelect, 'Select Destination Account');
    });

    // SweetAlert for success
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Reset form
                document.querySelector('form').reset();
                // Reset all dropdowns to default state
                const selects = document.querySelectorAll('select');
                selects.forEach(select => {
                    if (!select.id.includes('institution')) {
                        select.disabled = true;
                        select.innerHTML = '<option value="">Select Institution first</option>';
                    }
                });
                // Recalculate balance after reset
                calculateBalanceAmount();
            }
        });
    @endif

    // SweetAlert for validation errors
    @if($errors->any())
        Swal.fire({
            title: 'Validation Error!',
            html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
});
</script>
@endsection
