<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\PositionLevel;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positionLevels = PositionLevel::all();
        $positions = Position::all();
        return view('positions.create', compact('positionLevels', 'positions'));
    }

    public function store(Request $request)
    {
        // Store logic here
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:positions,code',
            'description' => 'nullable|string',
            'is_managerial' => 'required|in:Y,N',
            'position_level_id' => 'required|exists:position_levels,id',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        Position::create($validated);
        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    // Other methods (show, edit, update, destroy) can be added here as needed
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        $positionLevels = PositionLevel::all();
        $positions = Position::all();
        return view('positions.edit', compact('position', 'positionLevels', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:positions,code,' . $position->id,
            'description' => 'nullable|string',
            'is_managerial' => 'required|in:Y,N',
            'position_level_id' => 'required|exists:position_levels,id',
            'parent_id' => 'nullable|exists:positions,id',
        ]);

        $position->update($validated);
        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }

}
