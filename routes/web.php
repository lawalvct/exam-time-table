<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\InvigilatorController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\TimetableController;
use App\Models\Course;
use App\Models\Department;
use App\Models\Hall;
use App\Models\Timetable;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $stats = [
        'departments' => Department::count(),
        'courses' => Course::count(),
        'active_courses' => Course::where('is_active', true)->count(),
        'students' => Course::sum('total_students'),
        'halls' => Hall::count(),
        'total_capacity' => Hall::sum('capacity'),
        'scheduled_exams' => Timetable::count(),
    ];

    $recentTimetables = Timetable::query()
        ->with(['course.department', 'hall', 'timeSlot'])
        ->orderByDesc('exam_date')
        ->orderByDesc('id')
        ->limit(5)
        ->get();

    return view('dashboard', compact('stats', 'recentTimetables'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('faculties', FacultyController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('halls', HallController::class);
    Route::resource('invigilators', InvigilatorController::class);
    Route::resource('timeslots', TimeSlotController::class);

    Route::delete('timetables/destroy_all', [TimetableController::class, 'destroyAll'])->name('timetables.destroy_all');
    Route::get('timetables/generate', [TimetableController::class, 'generate'])->name('timetables.generate');
    Route::post('timetables/generate', [TimetableController::class, 'storeGenerate'])->name('timetables.store_generate');
    Route::get('timetables/print', [TimetableController::class, 'print'])->name('timetables.print');
    Route::patch('timetables/{timetable}/matric-range', [TimetableController::class, 'updateMatricRange'])->name('timetables.update_matric_range');
    Route::resource('timetables', TimetableController::class);
});

require __DIR__.'/auth.php';
