<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual Add Timetable Entry') }}
        </h2>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/timetables/create.blade.php | Controller: TimetableController@create | Route: timetables.create
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-[#008751]">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('timetables.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="academic_session" class="block text-sm font-medium text-gray-700">Academic Session <span class="text-red-500">*</span></label>
                                <select name="academic_session" id="academic_session" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                    <option value="">-- Select Session --</option>
                                    @foreach($sessionOptions as $option)
                                        <option value="{{ $option }}" {{ old('academic_session', date('Y').'/'.(date('Y')+1)) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_session') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semester <span class="text-red-500">*</span></label>
                                <select name="semester" id="semester" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                    <option value="">-- Select Semester --</option>
                                    <option value="First Semester" {{ old('semester') == 'First Semester' ? 'selected' : '' }}>First Semester</option>
                                    <option value="Second Semester" {{ old('semester') == 'Second Semester' ? 'selected' : '' }}>Second Semester</option>
                                </select>
                                @error('semester') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="course_id" class="block text-sm font-medium text-gray-700">Course <span class="text-red-500">*</span></label>
                            <select name="course_id" id="course_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->code }} - {{ $course->name }} ({{ $course->total_students }} students)
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="time_slot_id" class="block text-sm font-medium text-gray-700">Time Slot <span class="text-red-500">*</span></label>
                            <select name="time_slot_id" id="time_slot_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                <option value="">-- Select Time Slot --</option>
                                @foreach($timeSlots as $slot)
                                    <option value="{{ $slot->id }}" {{ old('time_slot_id') == $slot->id ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($slot->date)->format('D, M j, Y') }} | {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('time_slot_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="hall_id" class="block text-sm font-medium text-gray-700">Hall <span class="text-red-500">*</span></label>
                                <select name="hall_id" id="hall_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                    <option value="">-- Select Hall --</option>
                                    @foreach($halls as $hall)
                                        <option value="{{ $hall->id }}" {{ old('hall_id') == $hall->id ? 'selected' : '' }}>
                                            {{ $hall->name }} (Cap: {{ $hall->capacity }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('hall_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="invigilator_id" class="block text-sm font-medium text-gray-700">Invigilator</label>
                                <select name="invigilator_id" id="invigilator_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                    <option value="">-- No Invigilator --</option>
                                    @foreach($invigilators as $invigilator)
                                        <option value="{{ $invigilator->id }}" {{ old('invigilator_id') == $invigilator->id ? 'selected' : '' }}>
                                            {{ $invigilator->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('invigilator_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="matric_range" class="block text-sm font-medium text-gray-700">Matriculation Numbers Range</label>
                                <input type="text" name="matric_range" id="matric_range" value="{{ old('matric_range') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50" placeholder="e.g. 24-01-06-0001 to 24-01-06-0060">
                                @error('matric_range') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="student_count" class="block text-sm font-medium text-gray-700">Total Students in this Hall <span class="text-red-500">*</span></label>
                                <input type="number" name="student_count" id="student_count" value="{{ old('student_count', 1) }}" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                @error('student_count') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('timetables.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-[#008751] hover:bg-green-700 text-white rounded-md font-medium transition shadow-sm">
                                Save Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>