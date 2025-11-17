<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Unit;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    // Other CRUD methods (create, store, show, edit, update, destroy) would go here
    public function create()
    {
        $positions = Position::all();
        $units = Unit::all();
        return view('employees.create', compact('positions', 'units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_code' => 'required|string|max:100|unique:employees',
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'unit_id' => 'required|exists:units,id',
            'employment_status' => 'required|string|max:100',
            'hire_date' => 'required|date',
            'end_date' => 'nullable|date',
            'nik' => 'nullable|string|max:50',
            'npwp' => 'nullable|string|max:50',
            'gender' => 'required',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
        ]);

        // Create the employee
        Employee::create($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $units = Unit::all();
        $employees = Employee::where('id', '!=', $employee->id)->get(); // Exclude current employee from supervisor list
        return view('employees.edit', compact('employee', 'positions', 'units', 'employees'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'employee_code' => 'required|string|max:100|unique:employees,employee_code,' . $employee->id,
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'unit_id' => 'required|exists:units,id',
            'employment_status' => 'required|string|max:100',
            'hire_date' => 'required|date',
            'end_date' => 'nullable|date',
            'nik' => 'nullable|string|max:50',
            'npwp' => 'nullable|string|max:50',
            'gender' => 'required',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'supervisor_id' => 'nullable|exists:employees,id',
        ]);
        // Update the employee
        $employee->update($validatedData);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }
}
