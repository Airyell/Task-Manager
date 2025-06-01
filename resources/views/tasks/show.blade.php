@extends('layouts.app')
@section('title')
    {{ $task->title }} - Task Details
@endsection
@section('content')
<div class="container mx-auto px-4">
    <h2 class="mb-4 shadow p-3 rounded bg-white text-center text-2xl font-semibold">
        {{ $task->title }} - Task Details
    </h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-center">
        <div class="w-full max-w-3xl">
            <div class="bg-white shadow rounded mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <div class="md:w-1/2">
                            <h5 class="text-xl font-bold mb-2">{{ $task->title }}</h5>
                            <p class="mb-2 text-gray-700">{{ $task->description }}</p>
                            <p class="mb-2"><strong>Due Date:</strong> {{ $task->due_date }}</p>
                            <p class="mb-2">
                                <strong>Priority:</strong>
                                <span
                                    class="inline-block px-2 py-1 rounded text-white
                                        {{ $task->priority == 'low' ? 'bg-green-500' : ($task->priority == 'medium' ? 'bg-yellow-400' : 'bg-red-600') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </p>
                            <p class="mb-2">
                                <strong>Status:</strong>
                                @if ($task->status == 'completed')
                                    <span class="inline-block bg-green-500 text-white px-2 py-1 rounded">Completed</span>
                                @elseif($task->status == 'to_do')
                                    <span class="inline-block bg-blue-600 text-white px-2 py-1 rounded">To Do</span>
                                @elseif($task->status == 'in_progress')
                                    <span class="inline-block bg-yellow-400 text-black px-2 py-1 rounded">In Progress</span>
                                @endif
                            </p>
                            <p class="mb-4"><strong>Assign To:</strong> {{ $task->user->name }}</p>

                            <div class="flex space-x-2">
                                <button type="button"
                                    class="bg-blue-600 hover:bg-blue-700 text-white rounded px-3 py-2 flex items-center"
                                    data-bs-toggle="modal" data-bs-target="#editTaskModal">
                                    <i class="bi bi-pencil-square mr-1"></i> Edit
                                </button>
                                <a href="{{ route('projects.tasks.index', $task->project->id) }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white rounded px-3 py-2 flex items-center">
                                    <i class="bi bi-arrow-90deg-left mr-1"></i> Back
                                </a>
                            </div>
                        </div>

                        <div class="md:w-1/2 md:border-l md:pl-6 mt-6 md:mt-0">
                            <h5 class="text-lg font-semibold mb-3">Time Tracker</h5>
                            <div id="time-tracker" class="mb-3">
                                <span id="time-display" class="text-2xl font-mono">00:00:00</span>
                                <div class="mt-2 space-x-2">
                                    <button id="start-btn"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                        <i class="bi bi-play-fill"></i>
                                    </button>
                                    <button id="pause-btn"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm">
                                        <i class="bi bi-pause-fill"></i>
                                    </button>
                                    <button id="reset-btn"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                        <i class="bi bi-stop-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="text-lg font-semibold">Checklist</h5>
                            <button type="button"
                                class="bg-blue-600 hover:bg-blue-700 text-white rounded px-3 py-1 flex items-center"
                                data-bs-toggle="modal" data-bs-target="#addChecklistModal">
                                <i class="bi bi-plus-circle mr-1"></i> Add Item
                            </button>
                        </div>

                        <ul class="space-y-2" id="checklist-items">
                            @foreach ($task->checklistItems as $item)
                                <li id="checklist-item-{{ $item->id }}"
                                    class="flex justify-between items-center border rounded p-3 bg-gray-50">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="checklist-item-checkbox-{{ $item->id }}"
                                            class="form-checkbox h-5 w-5 text-blue-600"
                                            {{ $item->completed ? 'checked' : '' }}
                                            onchange="toggleChecklistItem({{ $item->id }})">
                                        <label
                                            class="{{ $item->completed ? 'line-through text-gray-500' : '' }}"
                                            for="checklist-item-checkbox-{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                    <div class="space-x-1">
                                        <button type="button"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm"
                                            data-bs-toggle="modal" data-bs-target="#editChecklistModal-{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button"
                                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm"
                                            onclick="deleteChecklistItem({{ $item->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Checklist Modal -->
    <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded shadow-lg">
                <form id="add-checklist-form">
                    @csrf
                    <div class="modal-header flex justify-between items-center border-b px-4 py-2">
                        <h5 class="modal-title text-lg font-semibold" id="addChecklistModalLabel">Add Checklist Item</h5>
                        <button type="button" class="btn-close text-gray-500 hover:text-gray-700" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="checklist-name" class="block mb-1 font-medium">Item Name</label>
                            <input type="text" name="name" id="checklist-name" class="w-full border rounded px-3 py-2" required>
                            <div class="text-red-600 mt-1 text-sm" id="checklist-name-error"></div>
                        </div>
                        <input type="hidden" name="task_id" id="task_id" value="{{ $task->id }}">
                    </div>
                    <div class="modal-footer flex justify-end space-x-2 border-t px-4 py-2">
                        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 rounded px-4 py-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded shadow-lg">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header flex justify-between items-center border-b px-4 py-2">
                        <h5 class="modal-title text-lg font-semibold" id="editTaskModalLabel">Edit Task</h5>
                        <button type="button" class="btn-close text-gray-500 hover:text-gray-700" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="title" class="block mb-1 font-medium">Title</label>
                            <input type="text" name="title" id="title" value="{{ $task->title }}" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block mb-1 font-medium">Description</label>
                            <textarea name="description" id="description" class="w-full border rounded px-3 py-2" rows="3">{{ $task->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="due_date" class="block mb-1 font-medium">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}" class="w-full border rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label for="priority" class="block mb-1 font-medium">Priority</label>
                            <select name="priority" id="priority" class="w-full border rounded px-3 py-2">
                                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block mb-1 font-medium">Status</label>
                            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                                <option value="to_do" {{ $task->status == 'to_do' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer flex justify-end space-x-2 border-t px-4 py-2">
                        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 rounded px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Checklist Item Modals -->
    @foreach ($task->checklistItems as $item)
    <div class="modal fade" id="editChecklistModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editChecklistModalLabel-{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded shadow-lg">
                <form action="{{ route('checklist-items.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header flex justify-between items-center border-b px-4 py-2">
                        <h5 class="modal-title text-lg font-semibold" id="editChecklistModalLabel-{{ $item->id }}">Edit Checklist Item</h5>
                        <button type="button" class="btn-close text-gray-500 hover:text-gray-700" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="name-{{ $item->id }}" class="block mb-1 font-medium">Item Name</label>
                            <input type="text" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" class="w-full border rounded px-3 py-2" required>
                        </div>
                    </div>
                    <div class="modal-footer flex justify-end space-x-2 border-t px-4 py-2">
                        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 rounded px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
