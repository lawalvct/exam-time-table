<?php

namespace App\Http\Controllers;

use App\Models\Invigilator;
use Illuminate\Http\Request;

class InvigilatorController extends Controller
{
    public function index()
    {
        $invigilators = Invigilator::latest()->paginate(10);
        return view('invigilators.index', compact('invigilators'));
    }

    public function create()
    {
        return view('invigilators.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        $request->validate([
            'name' => 'required|string|max:255',
            'staff_id' => 'required|string|max:100|unique:invigilators',
            'email' => 'nullable|email|max:255|unique:invigilators',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        Invigilator::create($request->all());

        return redirect()->route('invigilators.index')->with('success', 'Invigilator created successfully.');
    }

    public function edit(Invigilator $invigilator)
    {
        return view('invigilators.edit', compact('invigilator'));
    }

    public function update(Request $request, Invigilator $invigilator)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        $request->validate([
            'name' => 'required|string|max:255',
            'staff_id' => 'required|string|max:100|unique:invigilators,staff_id,' . $invigilator->id,
            'email' => 'nullable|email|max:255|unique:invigilators,email,' . $invigilator->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        $invigilator->update($request->all());

        return redirect()->route('invigilators.index')->with('success', 'Invigilator updated successfully.');
    }

    public function destroy(Invigilator $invigilator)
    {
        $invigilator->delete();
        return redirect()->route('invigilators.index')->with('success', 'Invigilator deleted successfully.');
    }
}