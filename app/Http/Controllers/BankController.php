<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\FinancialBranch;
use App\Models\FinancialInstitution;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::with('financialInstitution', 'branch')->get();
        return view('banks.index', compact('banks'));
    }

    public function create()
    {
        $institutions = FinancialInstitution::all();
        $branches = FinancialBranch::all();

        return view('banks.create', compact('institutions', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number',
            'institution_id' => 'required|exists:financial_institutions,id',
            'branch_id' => 'required|exists:fi_branches,id',
            'account_type' => 'required|string|max:100',
            'currency' => 'required|string|max:10',
            'opened_date' => 'nullable|date',
            'closed_date' => 'nullable|date|after_or_equal:opened_date',
            'notes' => 'nullable|string',
            'is_active' => 'required|in:0,1',
        ]);

        // Convert is_active to boolean
        $validated['is_active'] = (bool) $validated['is_active'];

        Bank::create($validated);
        return redirect()->route('banks.index')->with('success', 'Bank account created successfully.');
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        $institutions = FinancialInstitution::all();
        $branches = FinancialBranch::all();

        return view('banks.edit', compact('bank', 'institutions', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number,' . $bank->id,
            'institution_id' => 'required|exists:financial_institutions,id',
            'branch_id' => 'required|exists:fi_branches,id',
            'account_type' => 'required|string|max:100',
            'currency' => 'required|string|max:10',
            'opened_date' => 'nullable|date',
            'closed_date' => 'nullable|date|after_or_equal:opened_date',
            'notes' => 'nullable|string',
            'is_active' => 'required|in:0,1',
        ]);

        // Convert is_active to boolean
        $validated['is_active'] = (bool) $validated['is_active'];

        $bank->update($validated);
        return redirect()->route('banks.index')->with('success', 'Bank account updated successfully.');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();
        return redirect()->route('banks.index')->with('success', 'Bank account deleted successfully.');
    }
}
