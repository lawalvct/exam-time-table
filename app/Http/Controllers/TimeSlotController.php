<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::orderBy('date', 'desc')->orderBy('start_time', 'asc')->paginate(10);
        return view('timeslots.index', compact('timeSlots'));
    }

    public function create()
    {
        return view('timeslots.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'boolean'
        ]);

        TimeSlot::create($request->all());

        return redirect()->route('timeslots.index')->with('success', 'Time slot created successfully.');
    }

    public function edit(TimeSlot $timeslot)
    {
        return view('timeslots.edit', compact('timeslot'));
    }

    public function update(Request $request, TimeSlot $timeslot)
    {
        $request->merge(['is_active' => $request->has('is_active')]);

        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_active' => 'boolean'
        ]);

        $timeslot->update($request->all());

        return redirect()->route('timeslots.index')->with('success', 'Time slot updated successfully.');
    }

    public function destroy(TimeSlot $timeslot)
    {
        $timeslot->delete();
        return redirect()->route('timeslots.index')->with('success', 'Time slot deleted successfully.');
    }
}