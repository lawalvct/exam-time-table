<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Hall;
use App\Models\Level;
use App\Models\TimeSlot;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_live_statistics_and_recent_exam_updates(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();

        $faculty = Faculty::create([
            'name' => 'School of Science',
            'code' => 'SOS',
        ]);

        $department = Department::create([
            'faculty_id' => $faculty->id,
            'name' => 'Computer Science',
            'code' => 'CSC',
        ]);

        $level = Level::create([
            'name' => 'ND II',
        ]);

        $course = Course::create([
            'department_id' => $department->id,
            'name' => 'Algorithms',
            'code' => 'CSC 401',
            'level_id' => $level->id,
            'total_students' => 120,
            'is_active' => true,
        ]);

        $hall = Hall::create([
            'name' => 'Main Hall',
            'capacity' => 250,
        ]);

        $timeSlot = TimeSlot::create([
            'date' => '2026-05-10',
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'is_active' => true,
        ]);

        Timetable::create([
            'course_id' => $course->id,
            'time_slot_id' => $timeSlot->id,
            'hall_id' => $hall->id,
            'exam_date' => '2026-05-10',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('stats', fn (array $stats) => $stats['departments'] === 1
            && $stats['courses'] === 1
            && $stats['active_courses'] === 1
            && $stats['students'] === 120
            && $stats['halls'] === 1
            && $stats['total_capacity'] === 250
            && $stats['scheduled_exams'] === 1);
        $response->assertSeeText('CSC 401');
        $response->assertSeeText('Main Hall');
        $response->assertSeeText('Generate Timetable');
    }
}
