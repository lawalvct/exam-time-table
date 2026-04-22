<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Time Slot') }}: {{ \Carbon\Carbon::parse($timeslot->date)->format('M j, Y') }} ({{ \Carbon\Carbon::parse($timeslot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($timeslot->end_time)->format('h:i A') }})
        </h2>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/timeslots/edit.blade.php | Controller: TimeSlotController@edit | Route: timeslots.edit
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-[#008751]">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('timeslots.update', $timeslot) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Exam Date <span class="text-red-500">*</span></label>
                            <input type="date" name="date" id="date" value="{{ old('date', $timeslot->date) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                            @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time <span class="text-red-500">*</span></label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($timeslot->start_time)->format('H:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time <span class="text-red-500">*</span></label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($timeslot->end_time)->format('H:i')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                                @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-6 flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $timeslot->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-[#008751] shadow-sm focus:border-[#008751] focus:ring focus:ring-[#008751] focus:ring-opacity-50">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active Time Slot (Available for timetable generation)
                            </label>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('timeslots.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-[#008751] hover:bg-green-700 text-white rounded-md font-medium transition shadow-sm">
                                Update Time Slot
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>