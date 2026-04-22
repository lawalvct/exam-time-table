<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Timetable') }}
        </h2>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/timetables/generate.blade.php | Controller: TimetableController@create | Route: timetables.create
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-[#008751]">
                <div class="p-8 text-center text-gray-900">
                    
                    <div class="mb-6">
                        <svg class="mx-auto h-16 w-16 text-[#008751]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <h3 class="mt-4 text-2xl font-bold text-gray-900">Auto-Generate Timetable</h3>
                        <p class="mt-2 text-gray-600 max-w-xl mx-auto">
                            The system will automatically assign all <span class="font-bold">Active Courses</span> to available <span class="font-bold">Active Time Slots</span> and <span class="font-bold">Halls</span> based on student capacity. Active invigilators will be distributed evenly.
                        </p>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8 text-left text-sm text-blue-700 mx-auto max-w-2xl rounded-r-md">
                        <p class="font-bold mb-1">Important Notice:</p>
                        <ul class="list-disc pl-5">
                            <li>Generating a new timetable will <strong>overwrite and delete</strong> any existing scheduled exam assignments.</li>
                            <li>Ensure you have enough Time Slots and Halls with sufficient capacity to accommodate all registered course students.</li>
                            <li>Courses from the same department and level will not be scheduled in the same time slot to prevent student clashes.</li>
                        </ul>
                    </div>

                    <form action="{{ route('timetables.store_generate') }}" method="POST" onsubmit="return confirm('This will clear any existing timetable for the selected session and semester, and generate a new one. Proceed?');">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div class="text-left">
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

                            <div class="text-left">
                                <label for="semester" class="block text-sm font-medium text-gray-700">Semester <span class="text-red-500">*</span></label>
                                <select name="semester" id="semester" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                    <option value="">-- Select Semester --</option>
                                    <option value="First Semester" {{ old('semester') == 'First Semester' ? 'selected' : '' }}>First Semester</option>
                                    <option value="Second Semester" {{ old('semester') == 'Second Semester' ? 'selected' : '' }}>Second Semester</option>
                                </select>
                                @error('semester') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('timetables.index') }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                            <button type="submit" class="px-6 py-3 bg-[#008751] hover:bg-green-700 text-white rounded-md font-bold transition shadow-lg flex items-center transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Start Generation Process
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>