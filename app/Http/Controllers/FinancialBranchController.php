<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialBranch;
use App\Models\FinancialInstitution;

class FinancialBranchController extends Controller
{
    public function index()
    {
        $branches = FinancialBranch::with('financialInstitution')->get();

        return view('financial_branches.index', compact('branches'));
    }

    public function create()
    {
        $institutions = FinancialInstitution::all();
        return view('financial_branches.create', compact('institutions'));
    }

    public function getNextCode(Request $request)
    {
        $institutionId = $request->get('institution_id');

        if (!$institutionId) {
            return response()->json(['error' => 'Institution ID is required'], 400);
        }

        $institution = FinancialInstitution::find($institutionId);
        if (!$institution) {
            return response()->json(['error' => 'Institution not found'], 404);
        }

        // Get the highest branch number for this institution
        $lastBranch = FinancialBranch::where('institution_id', $institutionId)
            ->where('code', 'like', $institution->code . '%')
            ->orderBy('code', 'desc')
            ->first();

        if ($lastBranch) {
            // Extract the 3-digit number from the last code
            $lastNumber = (int) substr($lastBranch->code, strlen($institution->code));
            $nextNumber = $lastNumber + 1;
        } else {
            // First branch for this institution
            $nextNumber = 1;
        }

        // Format as 3-digit number
        $nextCode = $institution->code . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return response()->json(['code' => $nextCode]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:fi_branches,code',
            'institution_id' => 'required|exists:financial_institutions,id',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        // If no code provided, generate it
        if (empty($validatedData['code'])) {
            $institution = FinancialInstitution::find($validatedData['institution_id']);

            $lastBranch = FinancialBranch::where('institution_id', $validatedData['institution_id'])
                ->where('code', 'like', $institution->code . '%')
                ->orderBy('code', 'desc')
                ->first();

            if ($lastBranch) {
                $lastNumber = (int) substr($lastBranch->code, strlen($institution->code));
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $validatedData['code'] = $institution->code . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        FinancialBranch::create($validatedData);

        return redirect()->route('financial-branches.index')->with('success', 'Financial Branch created successfully.');
    }

    public function edit(FinancialBranch $financialBranch)
    {
        $institutions = FinancialInstitution::all();
        return view('financial_branches.edit', compact('financialBranch', 'institutions'));
    }

    public function update(Request $request, FinancialBranch $financialBranch)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:fi_branches,code,' . $financialBranch->id,
            'institution_id' => 'required|exists:financial_institutions,id',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $financialBranch->update($validatedData);

        return redirect()->route('financial-branches.index')->with('success', 'Financial Branch updated successfully.');
    }

    public function destroy(FinancialBranch $financialBranch)
    {
        $financialBranch->delete();

        return redirect()->route('financial-branches.index')->with('success', 'Financial Branch deleted successfully.');
    }
}
