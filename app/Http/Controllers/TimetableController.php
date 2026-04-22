<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Course;
use App\Models\TimeSlot;
use App\Models\Hall;
use App\Models\Invigilator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $query = Timetable::with(['course', 'timeSlot', 'hall', 'invigilator']);

        // Filtering
        if ($request->filled('academic_session')) {
            $query->where('academic_session', $request->academic_session);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $timetables = $query->orderBy('academic_session', 'desc')
            ->orderBy('semester', 'asc')
            ->orderBy('exam_date', 'asc')
            ->paginate(20)->withQueryString();

        $sessions = Timetable::select('academic_session')->distinct()->pluck('academic_session');
        $semesters = Timetable::select('semester')->distinct()->pluck('semester');
            
        return view('timetables.index', compact('timetables', 'sessions', 'semesters'));
    }

    // Printable View
    public function print(Request $request)
    {
        $query = Timetable::with(['course.department', 'course.level', 'timeSlot', 'hall', 'invigilator']);

        if ($request->filled('academic_session')) {
            $query->where('academic_session', $request->academic_session);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Group by Time Slot so each period can be on its own page or clearly separated
        $timetablesBySlot = $query->orderBy('exam_date', 'asc')
            ->get()
            ->groupBy('time_slot_id');

        $sessionLabel = $request->academic_session ?? 'ALL SESSIONS';
        $semesterLabel = $request->semester ?? 'ALL SEMESTERS';

        return view('timetables.print', compact('timetablesBySlot', 'sessionLabel', 'semesterLabel'));
    }

    // Displays the Auto-Generate Form
    public function generate()
    {
        // Pre-generate some session options for the dropdown
        $currentYear = date('Y');
        $sessionOptions = [
            ($currentYear-1) . '/' . $currentYear,
            $currentYear . '/' . ($currentYear+1),
            ($currentYear+1) . '/' . ($currentYear+2),
            ($currentYear+2) . '/' . ($currentYear+3),
        ];

        return view('timetables.generate', compact('sessionOptions'));
    }

    // Handles the automatic generation logic
    public function storeGenerate(Request $request)
    {
        $request->validate([
            'academic_session' => 'required|string',
            'semester' => 'required|string',
        ]);

        // 1. Fetch active entities
        $courses = Course::where('is_active', true)->orderBy('total_students', 'desc')->get();
        $timeSlots = TimeSlot::where('is_active', true)->orderBy('date')->orderBy('start_time')->get();
        $halls = Hall::orderBy('capacity', 'desc')->get();
        $invigilators = Invigilator::where('is_active', true)->get();

        if ($courses->isEmpty() || $timeSlots->isEmpty() || $halls->isEmpty()) {
            return back()->with('error', 'Ensure you have active Courses, Time Slots, and Halls before generating.');
        }

        // Clear existing timetable for this specific session and semester
        Timetable::where('academic_session', $request->academic_session)
                 ->where('semester', $request->semester)
                 ->delete();

        $scheduled = 0;
        $failed = [];
        $invigilatorIndex = 0;

        foreach ($courses as $course) {
            $remainingStudents = $course->total_students;
            $courseAssigned = false;

            foreach ($timeSlots as $slot) {
                // Check if department/level already has an exam in this timeslot (prevent student clashes)
                $departmentClash = Timetable::where('time_slot_id', $slot->id)
                    ->whereHas('course', function ($query) use ($course) {
                        $query->where('department_id', $course->department_id)
                              ->where('level_id', $course->level_id);
                    })->exists();

                if ($departmentClash) {
                    continue; // Try next timeslot
                }

                // Calculate available capacities for all halls in this timeslot
                $hallAvailabilities = [];
                $totalAvailableInSlot = 0;

                foreach ($halls as $hall) {
                    $usedCapacity = Timetable::where('time_slot_id', $slot->id)
                        ->where('hall_id', $hall->id)
                        ->sum('student_count');
                    
                    $available = $hall->capacity - $usedCapacity;
                    if ($available > 0) {
                        $hallAvailabilities[$hall->id] = $available;
                        $totalAvailableInSlot += $available;
                    }
                }

                // If this timeslot has enough space across all its available halls
                if ($totalAvailableInSlot >= $remainingStudents) {
                    
                    // Allocate students to halls
                    foreach ($halls as $hall) {
                        if ($remainingStudents <= 0) break;

                        $available = $hallAvailabilities[$hall->id] ?? 0;
                        if ($available > 0) {
                            $allocCount = min($remainingStudents, $available);

                            // Assign Invigilator (Round Robin)
                            $invigilatorId = null;
                            if ($invigilators->count() > 0) {
                                $invigilatorId = $invigilators[$invigilatorIndex % $invigilators->count()]->id;
                                $invigilatorIndex++;
                            }

                            Timetable::create([
                                'academic_session' => $request->academic_session,
                                'semester' => $request->semester,
                                'course_id' => $course->id,
                                'time_slot_id' => $slot->id,
                                'hall_id' => $hall->id,
                                'invigilator_id' => $invigilatorId,
                                'matric_range' => null, // Admin will update manually
                                'student_count' => $allocCount,
                                'exam_date' => $slot->date
                            ]);

                            $remainingStudents -= $allocCount;
                        }
                    }

                    if ($remainingStudents <= 0) {
                        $courseAssigned = true;
                        $scheduled++;
                        break; // Move to the next course
                    }
                }
            }

            if (!$courseAssigned) {
                $failed[] = $course->code;
            }
        }

        $message = "Successfully scheduled $scheduled courses.";
        if (count($failed) > 0) {
            $message .= " Failed to schedule: " . implode(', ', $failed) . " (Check hall capacities or timeslot availability).";
            return redirect()->route('timetables.index')->with('warning', $message);
        }

        return redirect()->route('timetables.index')->with('success', $message);
    }
    
    // Displays the Manual Add Form
    public function create()
    {
        $currentYear = date('Y');
        $sessionOptions = [
            ($currentYear-1) . '/' . $currentYear,
            $currentYear . '/' . ($currentYear+1),
            ($currentYear+1) . '/' . ($currentYear+2),
            ($currentYear+2) . '/' . ($currentYear+3),
        ];

        $courses = Course::orderBy('name')->get();
        $timeSlots = TimeSlot::orderBy('date')->orderBy('start_time')->get();
        $halls = Hall::orderBy('name')->get();
        $invigilators = Invigilator::orderBy('name')->get();

        return view('timetables.create', compact('sessionOptions', 'courses', 'timeSlots', 'halls', 'invigilators'));
    }

    // Handles the Manual Store logic
    public function store(Request $request)
    {
        $request->validate([
            'academic_session' => 'required|string',
            'semester' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'hall_id' => 'required|exists:halls,id',
            'invigilator_id' => 'nullable|exists:invigilators,id',
            'matric_range' => 'nullable|string|max:255',
            'student_count' => 'required|integer|min:1',
        ]);

        $timeSlot = TimeSlot::findOrFail($request->time_slot_id);

        Timetable::create([
            'academic_session' => $request->academic_session,
            'semester' => $request->semester,
            'course_id' => $request->course_id,
            'time_slot_id' => $request->time_slot_id,
            'hall_id' => $request->hall_id,
            'invigilator_id' => $request->invigilator_id,
            'matric_range' => $request->matric_range,
            'student_count' => $request->student_count,
            'exam_date' => $timeSlot->date
        ]);

        return redirect()->route('timetables.index')->with('success', 'Timetable entry added successfully.');
    }

    // Displays the Manual Edit Form
    public function edit(Timetable $timetable)
    {
        $currentYear = date('Y');
        $sessionOptions = [
            ($currentYear-1) . '/' . $currentYear,
            $currentYear . '/' . ($currentYear+1),
            ($currentYear+1) . '/' . ($currentYear+2),
            ($currentYear+2) . '/' . ($currentYear+3),
        ];

        $courses = Course::orderBy('name')->get();
        $timeSlots = TimeSlot::orderBy('date')->orderBy('start_time')->get();
        $halls = Hall::orderBy('name')->get();
        $invigilators = Invigilator::orderBy('name')->get();

        return view('timetables.edit', compact('timetable', 'sessionOptions', 'courses', 'timeSlots', 'halls', 'invigilators'));
    }

    // Handles the Manual Update logic
    public function update(Request $request, Timetable $timetable)
    {
        $request->validate([
            'academic_session' => 'required|string',
            'semester' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'hall_id' => 'required|exists:halls,id',
            'invigilator_id' => 'nullable|exists:invigilators,id',
            'matric_range' => 'nullable|string|max:255',
            'student_count' => 'required|integer|min:1',
        ]);

        $timeSlot = TimeSlot::findOrFail($request->time_slot_id);

        $timetable->update([
            'academic_session' => $request->academic_session,
            'semester' => $request->semester,
            'course_id' => $request->course_id,
            'time_slot_id' => $request->time_slot_id,
            'hall_id' => $request->hall_id,
            'invigilator_id' => $request->invigilator_id,
            'matric_range' => $request->matric_range,
            'student_count' => $request->student_count,
            'exam_date' => $timeSlot->date
        ]);

        return redirect()->route('timetables.index')->with('success', 'Timetable entry updated successfully.');
    }

    // Deletes a single timetable entry
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('timetables.index')->with('success', 'Timetable entry deleted successfully.');
    }

    // Quick update for Matriculation Range
    public function updateMatricRange(Request $request, Timetable $timetable)
    {
        $request->validate([
            'matric_range' => 'nullable|string|max:255',
        ]);

        $timetable->update([
            'matric_range' => $request->matric_range
        ]);

        return back()->with('success', 'Matriculation range updated successfully.');
    }

    // Clear all timetables
    public function destroyAll()
    {
        Timetable::truncate();
        return redirect()->route('timetables.index')->with('success', 'All timetables cleared successfully.');
    }
}