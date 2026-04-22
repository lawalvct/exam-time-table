<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/dashboard.blade.php | Route: dashboard
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-[#008751]">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage the AAP Examination & Timetable System from here.</p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Stat Card: Departments -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Departments</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>

                <!-- Stat Card: Courses -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-[#008751] mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Courses</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>

                <!-- Stat Card: Halls -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-red-50 text-[#E3000F] mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Exam Halls</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>

                <!-- Stat Card: Scheduled Exams -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Scheduled Exams</p>
                        <p class="text-2xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-1">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Quick Actions</h4>
                    </div>
                    <div class="p-4 flex flex-col gap-3">
                        <a href="#" class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md text-sm font-medium text-gray-700 transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add New Course
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md text-sm font-medium text-gray-700 transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Exam Hall
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 bg-[#008751] hover:bg-green-700 text-white rounded-md text-sm font-medium transition shadow-sm">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Generate Timetable
                        </a>
                    </div>
                </div>

                <!-- Recent Activity / Overview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-2">
                    <div class="p-6 border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800">Recent Updates</h4>
                    </div>
                    <div class="p-6 flex flex-col justify-center items-center h-48 text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>No recent activities found.</p>
                        <p class="text-sm mt-1">Start by adding departments and courses.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>