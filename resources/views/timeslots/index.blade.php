<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Time Slots / Exam Periods') }}
            </h2>
            <a href="{{ route('timeslots.create') }}" class="px-4 py-2 bg-[#008751] hover:bg-green-700 text-white rounded-md text-sm font-medium transition shadow-sm">
                + Add New Time Slot
            </a>
        </div>
        @if(config('app.debug'))
            <div class="mt-2 text-xs text-gray-500 font-mono">
                View: resources/views/timeslots/index.blade.php | Controller: TimeSlotController@index | Route: timeslots.index
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-[#008751]">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($timeSlots as $slot)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($slot->date)->format('l, F j, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($slot->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-3">
                                            <a href="{{ route('timeslots.edit', $slot) }}" class="text-[#008751] hover:text-green-900">Edit</a>
                                            <form action="{{ route('timeslots.destroy', $slot) }}" method="POST" class="m-0 p-0 inline-flex" onsubmit="return confirm('Are you sure you want to delete this time slot?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No time slots found. <a href="{{ route('timeslots.create') }}" class="text-[#008751] hover:underline">Create one</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $timeSlots->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>