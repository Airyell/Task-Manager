@extends('layouts.admin') {{-- Use your new admin layout --}}

@section('title', 'Task Management Dashboard') {{-- Set the page title --}}

@section('content')
<div class="space-y-6"> {{-- Use Tailwind for spacing, replaces container-fluid py-4 --}}

    <h2 class="text-2xl font-bold text-gray-800 mb-4">Task Management Dashboard</h2>

    {{-- Gauge Section --}}
    {{-- Use flex to create a horizontal layout.
         flex-nowrap ensures they stay on one line.
         overflow-x-auto adds a horizontal scrollbar if content overflows.
         gap-4 adds spacing between items.
         justify-center centers the flex items horizontally. --}}
    <div class="flex flex-nowrap overflow-x-auto pb-4 -mx-2 justify-center"> {{-- Added justify-center here --}}

        {{-- Completed Tasks Gauge --}}
        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2"> {{-- flex-shrink-0 to prevent shrinking --}}
            <div class="bg-[#f7e0c4] rounded-lg p-4 text-center shadow-md border border-[#f7e0c4]"> {{-- Light orange background --}}
                <div class="mb-2">
                    {{-- Placeholder for gauge image/SVG. You would integrate a charting library here. --}}
                    <img src="https://via.placeholder.com/100x70/f8a846/FFFFFF?text=Gauge" alt="Completed Tasks Gauge" class="mx-auto rounded-full mb-2">
                </div>
                <h4 class="text-lg font-semibold text-gray-800">Completed Tasks</h4>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $completedTasksCount ?? 0 }}</p> {{-- Dynamic count from controller --}}
            </div>
        </div>

        {{-- Tasks in Progress Gauge --}}
        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
            <div class="bg-[#f9d5d5] rounded-lg p-4 text-center shadow-md border border-[#f9d5d5]"> {{-- Light red background --}}
                <div class="mb-2">
                    <img src="https://via.placeholder.com/100x70/e74c3c/FFFFFF?text=Gauge" alt="Tasks in Progress Gauge" class="mx-auto rounded-full mb-2">
                </div>
                <h4 class="text-lg font-semibold text-gray-800">Tasks in Progress</h4>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $inProgressTasksCount ?? 0 }}</p> {{-- Dynamic count from controller --}}
            </div>
        </div>

        {{-- Not Started Tasks Gauge --}}
        <div class="flex-shrink-0 w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
            <div class="bg-[#d1ecf1] rounded-lg p-4 text-center shadow-md border border-[#d1ecf1]"> {{-- Light blue background --}}
                <div class="mb-2">
                    <img src="https://via.placeholder.com/100x70/3498db/FFFFFF?text=Gauge" alt="Not Started Tasks Gauge" class="mx-auto rounded-full mb-2">
                </div>
                <h4 class="text-lg font-semibold text-gray-800">Not Started Tasks</h4>
                <p class="text-4xl font-bold text-gray-900 mt-2">{{ $notStartedTasksCount ?? 0 }}</p> {{-- Dynamic count from controller --}}
            </div>
        </div>

        {{-- If you have more gauges, add them here following the same structure --}}

    </div>

    {{-- Task List Table Section --}}
    <div class="bg-white rounded-lg shadow-md p-6"> {{-- This wraps the entire table section --}}
        <div class="border-b pb-4 mb-4"> {{-- Separator for "All Tasks" title --}}
            <h5 class="text-lg font-bold text-gray-800">All Tasks</h5>
        </div>
        <div class="overflow-x-auto"> {{-- Make table horizontally scrollable if needed --}}
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-amber-500 uppercase tracking-wider">Task #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned to</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-amber-500 uppercase tracking-wider">Complete</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th> {{-- Added Actions column for admin --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $task->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->assignedUser->name ?? 'N/A' }}</td> {{-- Assuming 'assignedUser' relationship --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $priorityClass = '';
                                $priorityIcon = '';
                                switch (strtolower($task->priority)) {
                                    case 'high':
                                        $priorityClass = 'text-red-600';
                                        $priorityIcon = '&#9679;'; // Red diamond/circle
                                        break;
                                    case 'normal':
                                        $priorityClass = 'text-blue-600';
                                        $priorityIcon = '&#9650;'; // Blue triangle
                                        break;
                                    case 'low':
                                        $priorityClass = 'text-green-600';
                                        $priorityIcon = '&#9660;'; // Green inverted triangle
                                        break;
                                    default:
                                        $priorityClass = 'text-gray-500';
                                        $priorityIcon = '&mdash;'; // Dash
                                        break;
                                }
                            @endphp
                            <span class="{{ $priorityClass }}">{{ $priorityIcon }} {{ $task->priority }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $statusClass = '';
                                switch (strtolower($task->status)) {
                                    case 'done':
                                    case 'completed':
                                        $statusClass = 'text-green-600';
                                        break;
                                    case 'in progress':
                                        $statusClass = 'text-sky-500'; // Tailwind blue
                                        break;
                                    case 'not started':
                                        $statusClass = 'text-gray-500'; // Gray
                                        break;
                                    case 'canceled':
                                        $statusClass = 'text-red-600';
                                        break;
                                    default:
                                        $statusClass = 'text-gray-900';
                                        break;
                                }
                            @endphp
                            <span class="{{ $statusClass }}">&#9679;</span> {{ $task->status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @php
                                $progress = $task->progress_percentage ?? 0;
                                $progressBarColor = 'bg-green-500';
                                if ($progress < 25) { $progressBarColor = 'bg-red-500'; }
                                else if ($progress < 75) { $progressBarColor = 'bg-yellow-400'; }
                            @endphp
                            <div class="flex items-center">
                                <span class="mr-2">{{ $progress }}%</span>
                                <div class="w-24 bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                    <div class="{{ $progressBarColor }} h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Edit Task">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this task?')" title="Delete Task">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No tasks found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Ensure Font Awesome is loaded for icons --}}
{{-- <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script> --}}

{{-- Optional: If you use a JS library for the gauges, include it here and initialize it --}}
{{-- Example for Chart.js (you'd need to install it via npm or link CDN) --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example: Render a gauge chart if you integrate a charting library
    // This would be more complex and depend on the chosen library.
</script> --}}
@endpush