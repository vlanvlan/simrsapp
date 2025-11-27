<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Bank;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('bankAccount')->get();
        return view('deposits.index', compact('deposits'));
    }

    public function create()
    {
        // Only show active bank accounts with instrument_type 'deposit'
        $bankAccounts = Bank::activeDeposits()->with('financialInstitution')->get();

        // Get existing deposits for perpanjangan (extension) - only active deposits
        $existingDeposits = Deposit::where('penempatan', '!=', 'pencairan')
                                  ->whereNotNull('no_bilyet')
                                  ->select('no_bilyet', 'code', 'total_amount as principal_amount', 'interest_rate', 'bank_account_id')
                                  ->get();

        return view('deposits.create', compact('bankAccounts', 'existingDeposits'));
    }

    public function store(Request $request)
    {
        // Custom validation rules based on penempatan type
        $rules = [
            'code' => 'nullable|string|max:100',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'deposit_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'interest_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'penempatan' => 'required|string|in:pembukaan,perpanjangan,pencairan',
        ];

        // Different validation for no_bilyet based on penempatan type
        if ($request->penempatan === 'perpanjangan' || $request->penempatan === 'pencairan') {
            $rules['no_bilyet'] = 'required|string|exists:deposits,no_bilyet';
        } else {
            $rules['no_bilyet'] = 'required|string|max:100|unique:deposits,no_bilyet';
        }

        $validated = $request->validate($rules);

        // Now 'amount' is the base total amount, and 'total_amount' is the principal
        // Ensure calculation is correct: principal = total_amount + interest_amount
        $totalAmount = $validated['amount']; // This is the base total amount
        $interestAmount = $validated['interest_amount'];
        $calculatedPrincipal = $totalAmount + $interestAmount; // Principal = Total + Interest

        // Check if submitted principal matches calculated principal
        if (abs($validated['total_amount'] - $calculatedPrincipal) > 0.01) {
            return back()->withErrors(['total_amount' => 'Principal amount must equal total amount plus interest amount.'])->withInput();
        }

        $validated['total_amount'] = $calculatedPrincipal;

        // Remove code from validated data since we'll generate it after creation
        unset($validated['code']);

        // Create the deposit first to get the ID
        $deposit = Deposit::create($validated);

        // Generate and update the code based on ID
        $generatedCode = 'DEP-' . str_pad($deposit->id, 4, '0', STR_PAD_LEFT);

        // Ensure code uniqueness (in case of data integrity issues)
        $counter = 1;
        $originalCode = $generatedCode;
        while (Deposit::where('code', $generatedCode)->where('id', '!=', $deposit->id)->exists()) {
            $generatedCode = $originalCode . '-' . $counter;
            $counter++;
        }

        // Update the deposit with the generated code
        $deposit->update(['code' => $generatedCode]);

        // Verify the code was saved correctly
        if (!$deposit->fresh()->code) {
            return back()->withErrors(['code' => 'Failed to generate deposit code. Please try again.'])->withInput();
        }

        return redirect()->route('deposits.index')->with('success', "Deposit created successfully with code: {$generatedCode}");
    }
}
