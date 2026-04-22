<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Examination Timetable') }}
            </h2>
            <div class="flex gap-2">
                <form action="{{ route('timetables.destroy_all') }}" method="POST" onsubmit="return confirm('WARNING: This will delete the entire timetable. Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition shadow-sm">
                        Clear All
                    </button>
                </form>
                <a href="{{ route('timetables.create') }}" class="px-4 py-2 bg-white hover:bg-gray-50 text-[#008751] border border-[#008751] rounded-md text-sm font-medium transition shadow-sm">
                    Manual Add
                </a>
                <a href="{{ route('timetables.print', request()->query()) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Report
                </a>
                <a href="{{ route('timetables.generate') }}" class="px-4 py-2 bg-[#008751] hover:bg-green-700 text-white rounded-md text-sm font-medium transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Auto Generate
                </a>
            </div>
        </div>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/timetables/index.blade.php | Controller: TimetableController@index | Route: timetables.index
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="mb-4 px-4 py-3 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
                    {{ session('warning') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-gray-100 p-4">
                <form action="{{ route('timetables.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/3">
                        <label for="academic_session" class="block text-sm font-medium text-gray-700">Academic Session</label>
                        <select name="academic_session" id="academic_session" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                            <option value="">-- All Sessions --</option>
                            @foreach($sessions as $sessionOp)
                                <option value="{{ $sessionOp }}" {{ request('academic_session') == $sessionOp ? 'selected' : '' }}>{{ $sessionOp }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select name="semester" id="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                            <option value="">-- All Semesters --</option>
                            @foreach($semesters as $sem)
                                <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/3 flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-md text-sm font-medium transition shadow-sm w-full">
                            Filter
                        </button>
                        @if(request()->has('academic_session') || request()->has('semester'))
                            <a href="{{ route('timetables.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium transition shadow-sm text-center">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-[#008751]">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session/Semester</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hall</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invigilator</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($timetables as $timetable)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-bold">{{ $timetable->academic_session }}</span><br>
                                        <span class="text-gray-500 text-xs">{{ $timetable->semester }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($timetable->timeSlot->date)->format('D, M j, Y') }}<br>
                                        <span class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($timetable->timeSlot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($timetable->timeSlot->end_time)->format('h:i A') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-bold">{{ $timetable->course->code }}</span><br>
                                        <span class="text-gray-500 text-xs">{{ $timetable->course->department->code }} | {{ $timetable->course->level->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $timetable->student_count }}<br>
                                        <span class="text-xs text-blue-600">{{ $timetable->matric_range ?? 'No Range Set' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $timetable->hall->name }}<br>
                                        <span class="text-gray-500 text-xs">Cap: {{ $timetable->hall->capacity }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $timetable->invigilator->name ?? 'Unassigned' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-3">
                                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'matric-modal-{{ $timetable->id }}')" class="text-blue-600 hover:text-blue-900">Set Range</button>
                                            <a href="{{ route('timetables.edit', $timetable) }}" class="text-[#008751] hover:text-green-900">Edit</a>
                                            <form action="{{ route('timetables.destroy', $timetable) }}" method="POST" class="m-0 p-0 inline-flex" onsubmit="return confirm('Are you sure you want to delete this specific timetable entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>

                                        <!-- Matric Range Modal -->
                                        <x-modal name="matric-modal-{{ $timetable->id }}" focusable>
                                            <form method="post" action="{{ route('timetables.update_matric_range', $timetable) }}" class="p-6 text-left">
                                                @csrf
                                                @method('patch')

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    {{ __('Set Matriculation Range') }}
                                                </h2>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    Course: <strong>{{ $timetable->course->code }}</strong> | Hall: <strong>{{ $timetable->hall->name }}</strong> | Students: <strong>{{ $timetable->student_count }}</strong>
                                                </p>

                                                <div class="mt-6">
                                                    <x-input-label for="matric_range_{{ $timetable->id }}" value="{{ __('Matriculation Numbers Range') }}" />
                                                    <x-text-input id="matric_range_{{ $timetable->id }}" name="matric_range" type="text" class="mt-1 block w-full" :value="$timetable->matric_range" placeholder="e.g. 24-01-06-0001 to 24-01-06-0060" />
                                                </div>

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>

                                                    <x-primary-button class="ms-3 bg-[#008751] hover:bg-green-700">
                                                        {{ __('Save Range') }}
                                                    </x-primary-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 py-10">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        No timetable generated yet. <br>
                                        <a href="{{ route('timetables.generate') }}" class="text-[#008751] hover:underline font-medium mt-2 inline-block">Click here to auto-generate timetable</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $timetables->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>