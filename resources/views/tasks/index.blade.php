@extends('layouts.app')
@section('title')
    {{ $project->name }} - Tasks
@endsection
@section('content')

<style>
    .kanban-item {
        cursor: move;
    }

    .kanban-item.invisible {
        opacity: 0.4;
    }
</style>

<div class="container mx-auto px-4">
    <div class="bg-white shadow-sm p-4 rounded mb-6 flex justify-center">
        <h2 class="text-2xl font-semibold">{{ $project->name }} - Tasks</h2>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        <!-- To Do Column -->
        <div class="md:w-1/3 bg-gray-100 rounded p-3 flex flex-col h-full">
            <div class="flex justify-between items-center bg-blue-600 text-white rounded-t px-4 py-2 shadow-sm">
                <h4 class="font-bold text-lg m-0">To Do</h4>
                <button type="button" data-bs-toggle="modal" data-bs-target="#createTaskModal" data-status="to_do" class="bg-white text-blue-600 rounded px-3 py-1 font-bold hover:bg-gray-200 transition">
                    +
                </button>
            </div>
            <div id="to_do" class="bg-gray-200 rounded-b p-3 min-h-[500px] flex flex-col gap-3 overflow-y-auto">
                @foreach ($tasks['to_do'] ?? [] as $task)
                    <div class="bg-white rounded shadow p-4 kanban-item" data-id="{{ $task->id }}" draggable="true">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-lg flex-grow">{{ $task->title }}</h5>
                            <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold
                                {{ $task->priority == 'low' ? 'bg-green-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-400 text-gray-900' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $task->description }}</p>
                        <p class="text-sm text-gray-500 mb-2">Due: {{ $task->due_date }}</p>
                        <span class="text-xs px-2 py-1 rounded bg-blue-200 text-blue-800 font-medium">Status: To Do</span>
                        <div class="flex justify-end gap-2 mt-3">
                            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="md:w-1/3 bg-gray-100 rounded p-3 flex flex-col h-full">
            <div class="flex justify-between items-center bg-yellow-400 text-white rounded-t px-4 py-2 shadow-sm">
                <h4 class="font-bold text-lg m-0">In Progress</h4>
            </div>
            <div id="in_progress" class="bg-gray-200 rounded-b p-3 min-h-[500px] flex flex-col gap-3 overflow-y-auto">
                @foreach ($tasks['in_progress'] ?? [] as $task)
                    <div class="bg-white rounded shadow p-4 kanban-item" data-id="{{ $task->id }}" draggable="true">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-lg flex-grow">{{ $task->title }}</h5>
                            <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold
                                {{ $task->priority == 'low' ? 'bg-green-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-400 text-gray-900' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $task->description }}</p>
                        <p class="text-sm text-gray-500 mb-2">Due: {{ $task->due_date }}</p>
                        <span class="text-xs px-2 py-1 rounded bg-yellow-200 text-yellow-900 font-medium">Status: In Progress</span>
                        <div class="flex justify-end gap-2 mt-3">
                            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Completed Column -->
        <div class="md:w-1/3 bg-gray-100 rounded p-3 flex flex-col h-full">
            <div class="flex justify-between items-center bg-green-600 text-white rounded-t px-4 py-2 shadow-sm">
                <h4 class="font-bold text-lg m-0">Completed</h4>
            </div>
            <div id="completed" class="bg-gray-200 rounded-b p-3 min-h-[500px] flex flex-col gap-3 overflow-y-auto">
                @foreach ($tasks['completed'] ?? [] as $task)
                    <div class="bg-white rounded shadow p-4 kanban-item" data-id="{{ $task->id }}" draggable="true">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-lg flex-grow">{{ $task->title }}</h5>
                            <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold
                                {{ $task->priority == 'low' ? 'bg-green-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-400 text-gray-900' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $task->description }}</p>
                        <p class="text-sm text-gray-500 mb-2">Due: {{ $task->due_date }}</p>
                        <span class="text-xs px-2 py-1 rounded bg-green-200 text-green-800 font-medium">Status: Completed</span>
                        <div class="flex justify-end gap-2 mt-3">
                            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTaskModalLabel">Create Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            @error('title')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                            @error('description')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            @error('due_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority" id="priority" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            @error('priority')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="status" id="status" value="to_do">
                    </div>
                    <div class="modal-footer flex justify-end space-x-3 p-4 border-t">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', () => {
            const status = button.getAttribute('data-status');
            document.getElementById('status').value = status;
        });
    });
</script>

@endsection
