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

                <form action="{{ route('deposits.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" readonly style="background-color: #f8f9fa; font-weight: bold; color: #6c757d;" placeholder="Will be auto-generated: DEP-####">
                        <small class="text-muted">📋 Auto-generated format: DEP-0001, DEP-0002, etc. (assigned after saving)</small>
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="penempatan" class="form-label">Penempatan (Placement Type)</label>
                        <select class="form-select" id="penempatan" name="penempatan" required>
                            <option value="">Select Placement Type</option>
                            <option value="pembukaan" {{ old('penempatan') == 'pembukaan' ? 'selected' : '' }}>Pembukaan (Opening)</option>
                            <option value="perpanjangan" {{ old('penempatan') == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan (Extension)</option>
                            <option value="pencairan" {{ old('penempatan') == 'pencairan' ? 'selected' : '' }}>Pencairan (Withdrawal/Liquidation)</option>
                        </select>
                        @error('penempatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_bilyet" class="form-label">No Bilyet</label>
                        <input type="text" class="form-control" id="no_bilyet" name="no_bilyet" value="{{ old('no_bilyet') }}" required>
                        <select class="form-select" id="no_bilyet_select" name="no_bilyet_select" style="display: none;">
                            <option value="">Select Existing No Bilyet</option>
                            @foreach($existingDeposits->unique('no_bilyet') as $existingDeposit)
                                <option value="{{ $existingDeposit->no_bilyet }}">
                                    {{ $existingDeposit->no_bilyet }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted" id="no_bilyet_help">Enter new bilyet number for new deposits</small>
                        @error('no_bilyet')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="code_field" style="display: none;">
                        <label for="code_select" class="form-label">Code</label>
                        <select class="form-select" id="code_select" name="code_select">
                            <option value="">Select Code from No Bilyet</option>
                        </select>
                        <small class="text-muted">Select code from the chosen no bilyet</small>
                        @error('code_select')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bank_account_id" class="form-label">Bank Account (Deposit Type Only)</label>
                        <select class="form-select" id="bank_account_id" name="bank_account_id" required>
                            <option value="">Select Bank Account</option>
                            @forelse($bankAccounts as $bankAccount)
                                <option value="{{ $bankAccount->id }}" {{ old('bank_account_id') == $bankAccount->id ? 'selected' : '' }}>
                                    {{ $bankAccount->account_number }} - {{ $bankAccount->account_name }} ({{ $bankAccount->financialInstitution->name ?? 'N/A' }})
                                </option>
                            @empty
                                <option value="" disabled>No deposit bank accounts available</option>
                            @endforelse
                        </select>
                        @if($bankAccounts->isEmpty())
                            <small class="text-warning">⚠️ No bank accounts with 'deposit' instrument type found. Please create bank accounts with deposit type first.</small>
                        @else
                            <small class="text-muted">Only bank accounts with 'deposit' instrument type are shown</small>
                        @endif
                        @error('bank_account_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deposit_date" class="form-label">Deposit Date</label>
                        <input type="date" class="form-control datepicker" id="deposit_date" name="deposit_date" value="{{ old('deposit_date') }}" required>
                        @error('deposit_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Total Amount (Principal + Interest)</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                        <small class="text-muted" id="amount_help">Enter the total deposit amount including interest</small>
                        @error('amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="interest_rate" class="form-label">Interest Rate (%)</label>
                        <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" value="{{ old('interest_rate') }}" required>
                        @error('interest_rate')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="interest_amount" class="form-label">Interest Amount</label>
                        <input type="number" step="0.01" class="form-control" id="interest_amount" name="interest_amount" value="{{ old('interest_amount') }}" required>
                        <small class="text-muted">Enter interest amount manually</small>
                        @error('interest_amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Principal Amount</label>
                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" readonly style="background-color: #f8f9fa; font-weight: bold; color: #28a745;" required>
                        <small class="text-muted">Auto-calculated: Total Amount + Interest Amount</small>
                        @error('total_amount')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                    <a href="{{ route('deposits.index') }}" class="btn btn-secondary">Back</a>
                </form>

            </div>
        </div>

    </section>
</div>

@endsection

@section('scripts')
<script>
// Existing deposits data for cascading dropdowns
const existingDepositsData = @json($existingDeposits);

document.addEventListener('DOMContentLoaded', function() {
    const penempatanSelect = document.getElementById('penempatan');
    const amountField = document.getElementById('amount');
    const interestRateField = document.getElementById('interest_rate');
    const interestAmountField = document.getElementById('interest_amount');
    const totalAmountField = document.getElementById('total_amount');
    const noBilyetInput = document.getElementById('no_bilyet');
    const noBilyetSelect = document.getElementById('no_bilyet_select');
    const codeField = document.getElementById('code_field');
    const codeSelect = document.getElementById('code_select');
    const noBilyetHelp = document.getElementById('no_bilyet_help');
    const bankAccountSelect = document.getElementById('bank_account_id');

    // Function to handle penempatan type change
    function handlePenempatanChange() {
        const selectedType = penempatanSelect.value;

        // Reset fields
        clearFieldHints();

        switch(selectedType) {
            case 'pembukaan':
                // New deposit opening
                showInputField();
                showFieldHints('New deposit opening - enter new bilyet number and details');
                break;
            case 'perpanjangan':
                // Extension - show dropdown for existing bilyet
                showSelectField();
                showFieldHints('Deposit extension - select existing bilyet number');
                break;
            case 'pencairan':
                // Withdrawal/liquidation
                showSelectField();
                showFieldHints('Deposit withdrawal/liquidation - select existing bilyet number');
                break;
            default:
                showInputField();
                clearFieldHints();
                break;
        }
    }

    function showInputField() {
        noBilyetInput.style.display = 'block';
        noBilyetSelect.style.display = 'none';
        codeField.style.display = 'none';
        noBilyetInput.name = 'no_bilyet';
        noBilyetSelect.name = '';
        noBilyetInput.required = true;
        noBilyetSelect.required = false;
        noBilyetHelp.textContent = 'Enter new bilyet number for new deposits';
    }

    function showSelectField() {
        noBilyetInput.style.display = 'none';
        noBilyetSelect.style.display = 'block';
        codeField.style.display = 'block';
        noBilyetInput.name = '';
        noBilyetSelect.name = 'no_bilyet';
        noBilyetInput.required = false;
        noBilyetSelect.required = true;
        noBilyetHelp.textContent = 'Select existing bilyet number for extension/withdrawal';
    }

    function showFieldHints(message) {
        clearFieldHints();

        const hint = document.createElement('small');
        hint.className = 'text-info d-block mt-1 penempatan-hint';
        hint.innerHTML = '💡 ' + message;
        penempatanSelect.parentNode.appendChild(hint);
    }

    function clearFieldHints() {
        const existingHints = document.querySelectorAll('.penempatan-hint');
        existingHints.forEach(hint => hint.remove());
    }

    // Calculate principal amount automatically (Total Amount + Interest Amount)
    function calculateTotalAmount() {
        const penempatanType = penempatanSelect.value;
        const totalAmount = parseFloat(amountField.value) || 0; // This could be existing principal or new total
        const interestAmount = parseFloat(interestAmountField.value) || 0;

        let principal;

        if (penempatanType === 'perpanjangan' && codeSelect.value) {
            // For perpanjangan with selected code: Principal = Existing Principal + New Interest
            principal = totalAmount + interestAmount;
        } else {
            // For new deposits or no code selected: Principal = Total + Interest
            principal = totalAmount + interestAmount;
        }

        totalAmountField.value = principal.toFixed(2); // This field now shows new principal

        if (principal > 0) {
            totalAmountField.style.color = '#28a745';
        } else {
            totalAmountField.style.color = '#6c757d';
        }
    }    // Handle existing bilyet selection for extensions
    // Handle no_bilyet selection to populate code dropdown
    function handleNoBilyetSelection() {
        const selectedNoBilyet = noBilyetSelect.value;
        const codeSelectElement = codeSelect;
        const amountHelpText = document.getElementById('amount_help');

        // Clear previous code options
        codeSelectElement.innerHTML = '<option value="">Select Code from No Bilyet</option>';

        // Reset Total Amount field when bilyet changes
        amountField.readOnly = false;
        amountField.style.backgroundColor = '';
        amountField.style.fontWeight = '';
        amountField.style.color = '';
        amountField.value = '';
        amountHelpText.textContent = 'Enter the total deposit amount including interest';
        amountHelpText.className = 'text-muted';

        if (selectedNoBilyet) {
            // Filter deposits by selected no_bilyet and populate code dropdown
            const filteredDeposits = existingDepositsData.filter(deposit =>
                deposit.no_bilyet === selectedNoBilyet
            );

            filteredDeposits.forEach(deposit => {
                const option = document.createElement('option');
                option.value = deposit.code;
                option.textContent = `${deposit.code} (Principal: ${parseFloat(deposit.principal_amount).toLocaleString('id-ID')})`;
                option.dataset.principalAmount = deposit.principal_amount;
                option.dataset.interestRate = deposit.interest_rate;
                option.dataset.bankAccount = deposit.bank_account_id;
                codeSelectElement.appendChild(option);
            });
        }

        // Clear principal amount when no_bilyet changes
        totalAmountField.value = '';
        totalAmountField.style.color = '#6c757d';
    }    // Handle code selection to fill form data
    function handleCodeSelection() {
        const selectedOption = codeSelect.options[codeSelect.selectedIndex];
        const amountHelpText = document.getElementById('amount_help');
        const penempatanType = penempatanSelect.value;

        if (selectedOption.value) {
            const principalAmount = selectedOption.dataset.principalAmount;
            const interestRate = selectedOption.dataset.interestRate;
            const bankAccountId = selectedOption.dataset.bankAccount;

            if (penempatanType === 'pencairan') {
                // For pencairan (withdrawal): all fields show existing values, all readonly
                amountField.value = parseFloat(principalAmount).toFixed(2);
                amountField.readOnly = true;
                amountField.style.backgroundColor = '#f8f9fa';
                amountField.style.fontWeight = 'bold';
                amountField.style.color = '#dc3545'; // Red color for withdrawal

                // Set principal amount same as total amount for withdrawal
                totalAmountField.value = parseFloat(principalAmount).toFixed(2);
                totalAmountField.style.color = '#dc3545';

                // Interest amount should be 0 for withdrawal
                interestAmountField.value = '0.00';
                interestAmountField.readOnly = true;
                interestAmountField.style.backgroundColor = '#f8f9fa';

                // Update help text
                amountHelpText.textContent = `Withdrawing deposit code: ${selectedOption.value}`;
                amountHelpText.className = 'text-danger';
            } else {
                // For perpanjangan (extension): existing principal in total amount, new interest can be added
                amountField.value = parseFloat(principalAmount).toFixed(2);
                amountField.readOnly = true;
                amountField.style.backgroundColor = '#f8f9fa';
                amountField.style.fontWeight = 'bold';
                amountField.style.color = '#28a745';

                // Clear interest amount for new input
                interestAmountField.value = '';
                interestAmountField.readOnly = false;
                interestAmountField.style.backgroundColor = '';

                // Clear principal amount initially
                totalAmountField.value = '';
                totalAmountField.style.color = '#6c757d';

                // Update help text
                amountHelpText.textContent = `Principal amount from selected code: ${selectedOption.value}`;
                amountHelpText.className = 'text-success';
            }

            // Pre-fill other fields for both types
            interestRateField.value = interestRate;
            bankAccountSelect.value = bankAccountId;
        } else {
            // Reset all fields when no code is selected
            amountField.readOnly = false;
            amountField.style.backgroundColor = '';
            amountField.style.fontWeight = '';
            amountField.style.color = '';
            amountField.value = '';

            interestAmountField.readOnly = false;
            interestAmountField.style.backgroundColor = '';
            interestAmountField.value = '';

            // Reset help text
            amountHelpText.textContent = 'Enter the total deposit amount including interest';
            amountHelpText.className = 'text-muted';

            // Clear principal amount when no code is selected
            totalAmountField.value = '';
            totalAmountField.style.color = '#6c757d';
        }
    }    // Event listeners for real-time calculation and cascading dropdowns
    penempatanSelect.addEventListener('change', handlePenempatanChange);
    amountField.addEventListener('input', calculateTotalAmount);
    interestAmountField.addEventListener('input', calculateTotalAmount);
    noBilyetSelect.addEventListener('change', handleNoBilyetSelection);
    codeSelect.addEventListener('change', handleCodeSelection);

    // Initial calculation on page load
    calculateTotalAmount();
    handlePenempatanChange();

    // Recalculate when fields are focused (in case of browser autofill)
    amountField.addEventListener('focus', calculateTotalAmount);
    interestAmountField.addEventListener('focus', calculateTotalAmount);

    // Note: Interest rate auto-calculation is removed - users must enter interest amount manually

    // Form submission debugging
    const saveButton = document.getElementById('saveButton');
    const form = document.querySelector('form');

    saveButton.addEventListener('click', function(e) {
        console.log('Save button clicked');

        // Check if form is valid
        if (!form.checkValidity()) {
            console.log('Form validation failed');
            e.preventDefault();
            form.reportValidity();
            return false;
        }

        // Check penempatan-specific validation
        const penempatan = penempatanSelect.value;
        const noBilyetValue = penempatan === 'perpanjangan' || penempatan === 'pencairan'
            ? noBilyetSelect.value
            : noBilyetInput.value;

        if (!noBilyetValue) {
            console.log('No bilyet validation failed');
            alert('Please select or enter a bilyet number');
            e.preventDefault();
            return false;
        }

        console.log('Form submission allowed');
    });
});
</script>
