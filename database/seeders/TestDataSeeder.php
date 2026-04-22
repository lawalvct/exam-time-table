<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Course;
use App\Models\Invigilator;
use App\Models\Hall;
use App\Models\TimeSlot;
use App\Models\Level;
use Carbon\Carbon;
use Faker\Factory as Faker;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Faculties (5)
        $facultyNames = [
            'School of Science', 
            'School of Engineering', 
            'School of Management', 
            'School of Environmental Studies', 
            'School of Arts and Design'
        ];
        
        $faculties = [];
        foreach ($facultyNames as $index => $name) {
            $faculties[] = Faculty::firstOrCreate(
                ['name' => $name],
                ['code' => 'FAC' . ($index + 1), 'description' => $faker->sentence]
            );
        }

        // 2. Departments (10)
        $departmentNames = [
            'Computer Science', 'Science Laboratory Technology', 'Microbiology', // Science
            'Electrical Engineering', 'Civil Engineering', 'Mechanical Engineering', // Engineering
            'Business Administration', 'Accounting', // Management
            'Urban and Regional Planning', 'Architecture' // Env/Arts
        ];

        $departments = [];
        foreach ($departmentNames as $name) {
            $departments[] = Department::firstOrCreate(
                ['name' => $name],
                [
                    'faculty_id' => $faker->randomElement($faculties)->id,
                    'code' => strtoupper(substr(str_replace(' ', '', $name), 0, 3)),
                    'description' => $faker->sentence
                ]
            );
        }

        // 3. Levels
        $levels = Level::all();
        if ($levels->isEmpty()) {
            $this->call(LevelSeeder::class);
            $levels = Level::all();
        }

        // 4. Courses (50)
        for ($i = 1; $i <= 50; $i++) {
            $dept = $faker->randomElement($departments);
            $level = $faker->randomElement($levels);
            
            Course::firstOrCreate(
                ['code' => $dept->code . ' ' . $faker->numberBetween(100, 499)],
                [
                    'department_id' => $dept->id,
                    'name' => $faker->words(3, true) . ' ' . $faker->randomElement(['I', 'II', 'Fundamentals', 'Advanced']),
                    'level_id' => $level->id,
                    'total_students' => $faker->numberBetween(30, 200),
                    'is_active' => true
                ]
            );
        }

        // 5. Invigilators (20)
        for ($i = 1; $i <= 20; $i++) {
            Invigilator::firstOrCreate(
                ['staff_id' => 'AAP/STF/' . str_pad($i, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => ($faker->randomElement(['Mr.', 'Mrs.', 'Dr.', 'Prof.'])) . ' ' . $faker->lastName . ' ' . $faker->firstName,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'is_active' => true
                ]
            );
        }

        // 6. Halls
        $hallNames = [
            'Auditorium', 'Multipurpose Hall 1', 'Multipurpose Hall 2',
            'TetFUND Hall 1', 'TetFUND Hall 2', 'TetFUND Building 1', 'TetFUND Building 2',
            'Ogunnaiya Building', 'Kaka', 'Science Complex (Up)', 'Science Complex (down)',
            'Science Room I', 'Science Room II', 'Olusanya Building', 'NEEDS Lab I', 'NEEDS Lab II',
            'SOET Hall 1', 'SOET Hall 2', 'SOET Hall 3', 'SOET Studio 1', 'SOET Studio 2',
            'Software Lab', 'Hardware Lab', 'Biology Lab'
        ];

        foreach ($hallNames as $name) {
            Hall::firstOrCreate(
                ['name' => $name],
                ['capacity' => $faker->randomElement([50, 100, 150, 200, 250, 300, 500])]
            );
        }

        // 7. Time Slots (May 2026)
        $startDate = Carbon::create(2026, 5, 4); // A Monday in May 2026
        
        for ($day = 0; $day < 10; $day++) { // 10 days of exams
            $currentDate = $startDate->copy()->addDays($day);
            
            // Skip weekends
            if ($currentDate->isWeekend()) {
                continue;
            }

            // Morning Slot
            TimeSlot::firstOrCreate([
                'date' => $currentDate->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '12:00:00',
            ], ['is_active' => true]);

            // Afternoon Slot
            TimeSlot::firstOrCreate([
                'date' => $currentDate->format('Y-m-d'),
                'start_time' => '13:00:00',
                'end_time' => '16:00:00',
            ], ['is_active' => true]);
        }
    }
}