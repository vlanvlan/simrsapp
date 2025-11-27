<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputSaldo;
use App\Models\Bank;
use App\Models\FinancialInstitution;

class InputSaldoController extends Controller
{
    public function index()
    {
        $input_saldos = InputSaldo::with('bankAccount')->get();
        return view('input_saldo.index', compact('input_saldos'));
    }

    public function create()
    {
        $financialInstitutions = FinancialInstitution::all();
        return view('input_saldo.create', compact('financialInstitutions'));
    }

    public function getBankAccountsByInstitution(Request $request)
    {
        $institutionId = $request->get('institution_id');
        // For balance input, show current accounts and savings (typical operational accounts)
        $bankAccounts = Bank::where('institution_id', $institutionId)
                          ->where('is_active', true)
                          ->whereIn('instrument_type', ['current_account', 'savings'])
                          ->with(['financialInstitution', 'branch'])
                          ->get();

        return response()->json($bankAccounts);
    }

    public function getLastBalance(Request $request)
    {
        $bankAccountId = $request->get('bank_account_id');

        $lastBalance = InputSaldo::where('bank_account_id', $bankAccountId)
                                ->orderBy('balance_date', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->first();

        $previousBalance = $lastBalance ? $lastBalance->balance_amount : 0;

        return response()->json(['previous_balance' => $previousBalance]);
    }    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'balance_date' => 'required|date',
            'previous_balance' => 'required|numeric',
            'in' => 'required|numeric|min:0',
            'out' => 'required|numeric|min:0',
            'masuk_pindah_buku' => 'required|numeric|min:0',
            'keluar_pindah_buku' => 'required|numeric|min:0',
            'masuk_from_institution_id' => 'nullable|exists:financial_institutions,id',
            'masuk_from_account_id' => 'nullable|exists:bank_accounts,id',
            'keluar_to_institution_id' => 'nullable|exists:financial_institutions,id',
            'keluar_to_account_id' => 'nullable|exists:bank_accounts,id',
            'balance_amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        // Only keep the fields that exist in the table
        $inputSaldoData = [
            'bank_account_id' => $validated['bank_account_id'],
            'balance_date' => $validated['balance_date'],
            'previous_balance' => $validated['previous_balance'],
            'in' => $validated['in'],
            'out' => $validated['out'],
            'masuk_pindah_buku' => $validated['masuk_pindah_buku'],
            'keluar_pindah_buku' => $validated['keluar_pindah_buku'],
            'masuk_from_account_id' => $validated['masuk_from_account_id'],
            'keluar_to_account_id' => $validated['keluar_to_account_id'],
            'balance_amount' => $validated['balance_amount'],
            'notes' => $validated['notes'],
        ];

        InputSaldo::create($inputSaldoData);
        return redirect()->route('input-saldo.create')->with('success', 'Input Saldo created successfully.');
    }

    // Other methods (show, edit, update, destroy) can be added here as needed


}
