<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\UnitType;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('unitType')->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        $unitTypes = UnitType::all();
        return view('units.create', compact('unitTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:units,code',
                'description' => 'nullable|string',
                'unit_type_id' => 'required|exists:unit_types,id',
                'parent_id' => 'nullable|exists:units,id',
                'cost_center_code' => 'nullable|string|max:100',
            ]);

            // Handle checkboxes - they send 'on' when checked, nothing when unchecked
            $validated['is_service_unit'] = $request->has('is_service_unit') ? 'Y' : 'N';
            $validated['is_active'] = $request->has('is_active') ? 'Y' : 'N';

            Unit::create($validated);

            return redirect()->route('units.index')->with('success', 'Unit created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating unit: ' . $e->getMessage())->withInput();
        }
    }

    // Other methods (show, edit, update, destroy) can be added here as needed
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $unitTypes = UnitType::all();
        return view('units.edit', compact('unit', 'unitTypes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $unit = Unit::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:units,code,' . $unit->id,
                'description' => 'nullable|string',
                'unit_type_id' => 'required|exists:unit_types,id',
                'parent_id' => 'nullable|exists:units,id',
                'cost_center_code' => 'nullable|string|max:100',
            ]);

            // Handle checkboxes
            $validated['is_service_unit'] = $request->has('is_service_unit') ? 'Y' : 'N';
            $validated['is_active'] = $request->has('is_active') ? 'Y' : 'N';

            $unit->update($validated);

            return redirect()->route('units.index')->with('success', 'Unit updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating unit: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }
}
