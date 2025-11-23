<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialInstitution;

class FinancialInstitutionController extends Controller
{
    public function index()
    {
        $institutions = FinancialInstitution::all();

        return view('financial_institutions.index', compact('institutions'));
    }

    public function create()
    {
        return view('financial_institutions.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:financial_institutions,code',
            'institution_category' => 'required|string|max:100',
        ]);

        FinancialInstitution::create($validatedData);

        return redirect()->route('financial-institutions.index')->with('success', 'Financial Institution created successfully.');
    }

    public function edit($id)
    {
        $institution = FinancialInstitution::findOrFail($id);
        return view('financial_institutions.edit', compact('institution'));
    }

    public function update(Request $request, $id)
    {
        $institution = FinancialInstitution::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:financial_institutions,code,' . $institution->id,
            'institution_category' => 'required|string|max:100',
        ]);

        $institution->update($validatedData);

        return redirect()->route('financial-institutions.index')->with('success', 'Financial Institution updated successfully.');
    }

    public function destroy($id)
    {
        $institution = FinancialInstitution::findOrFail($id);
        $institution->delete();

        return redirect()->route('financial-institutions.index')->with('success', 'Financial Institution deleted successfully.');
    }
}
