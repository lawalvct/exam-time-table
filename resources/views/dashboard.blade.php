<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/dashboard.blade.php | Route: dashboard
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-[#008751]">
                <div class="p-6 text-gray-900 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage the AAP Examination &amp; Timetable System from here.</p>
                        <p class="mt-4 text-sm text-gray-600">
                            {{ $stats['departments'] }} departments, {{ $stats['courses'] }} courses, and {{ $stats['scheduled_exams'] }} scheduled exams are currently tracked.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="rounded-xl bg-gray-50 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Active Courses</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats['active_courses']) }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Seat Capacity</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats['total_capacity']) }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 px-4 py-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Enrolled Students</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats['students']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Departments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['departments']) }}</p>
                        <p class="mt-1 text-xs text-gray-400">Academic units ready for scheduling</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-[#008751] mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Courses</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['courses']) }}</p>
                        <p class="mt-1 text-xs text-gray-400">{{ number_format($stats['active_courses']) }} active and ready to schedule</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-red-50 text-[#E3000F] mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Exam Halls</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['halls']) }}</p>
                        <p class="mt-1 text-xs text-gray-400">{{ number_format($stats['total_capacity']) }} total seats available</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Scheduled Exams</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['scheduled_exams']) }}</p>
                        <p class="mt-1 text-xs text-gray-400">Latest schedules are listed below</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-1">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Quick Actions</h4>
                    </div>
                    <div class="p-4 flex flex-col gap-3">
                        <a href="{{ route('departments.create') }}" class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md text-sm font-medium text-gray-700 transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Department
                        </a>
                        <a href="{{ route('courses.create') }}" class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md text-sm font-medium text-gray-700 transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add New Course
                        </a>
                        <a href="{{ route('halls.create') }}" class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md text-sm font-medium text-gray-700 transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Exam Hall
                        </a>
                        <a href="{{ route('timetables.generate') }}" class="flex items-center px-4 py-2 bg-[#008751] hover:bg-green-700 text-white rounded-md text-sm font-medium transition shadow-sm">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Generate Timetable
                        </a>
                        <a href="{{ route('timetables.index') }}" class="flex items-center px-4 py-2 bg-gray-900 hover:bg-black rounded-md text-sm font-medium text-white transition shadow-sm">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            View Full Timetable
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-2">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Recent Schedule Updates</h4>
                    </div>
                    @if($recentTimetables->isEmpty())
                        <div class="p-6 flex flex-col justify-center items-center h-48 text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p>No exam schedules available yet.</p>
                            <p class="text-sm mt-1">Start by adding departments, courses, halls, and then generate a timetable.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach($recentTimetables as $timetable)
                                <div class="p-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h5 class="text-base font-semibold text-gray-900">{{ $timetable->course?->code ?? 'Course pending' }}</h5>
                                            @if($timetable->course?->department?->code)
                                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">{{ $timetable->course->department->code }}</span>
                                            @endif
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">{{ $timetable->course?->name ?? 'Course details unavailable' }}</p>
                                        <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                            <span class="rounded-full bg-blue-50 px-3 py-1 font-medium text-blue-700">{{ \Illuminate\Support\Carbon::parse($timetable->exam_date)->format('D, d M Y') }}</span>
                                            @if($timetable->timeSlot)
                                                <span class="rounded-full bg-emerald-50 px-3 py-1 font-medium text-emerald-700">{{ \Illuminate\Support\Carbon::parse($timetable->timeSlot->start_time)->format('h:i A') }} - {{ \Illuminate\Support\Carbon::parse($timetable->timeSlot->end_time)->format('h:i A') }}</span>
                                            @endif
                                            <span class="rounded-full bg-rose-50 px-3 py-1 font-medium text-rose-700">{{ $timetable->hall?->name ?? 'Hall pending' }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('timetables.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                                        Open Timetable
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
