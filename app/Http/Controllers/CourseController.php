<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'level'])->latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        return view('courses.create', compact('departments', 'levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses',
            'total_students' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $departments = Department::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();
        return view('courses.edit', compact('course', 'departments', 'levels'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'level_id' => 'required|exists:levels,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'total_students' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}