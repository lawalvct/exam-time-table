<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::latest()->paginate(10);
        return view('halls.index', compact('halls'));
    }

    public function create()
    {
        return view('halls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:halls',
            'capacity' => 'required|integer|min:1'
        ]);

        Hall::create($request->all());

        return redirect()->route('halls.index')->with('success', 'Hall created successfully.');
    }

    public function edit(Hall $hall)
    {
        return view('halls.edit', compact('hall'));
    }

    public function update(Request $request, Hall $hall)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:halls,name,' . $hall->id,
            'capacity' => 'required|integer|min:1'
        ]);

        $hall->update($request->all());

        return redirect()->route('halls.index')->with('success', 'Hall updated successfully.');
    }

    public function destroy(Hall $hall)
    {
        $hall->delete();
        return redirect()->route('halls.index')->with('success', 'Hall deleted successfully.');
    }
}