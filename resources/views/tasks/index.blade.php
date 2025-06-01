@extends('layouts.app')
@section('title')
    {{ $project->name }} - Tasks
@endsection
@section('content')

<style>
    .kanban-item {
        cursor: move;
    }
    .kanban-item.dragging {
        opacity: 0.5;
    }
    .kanban-column.drag-over {
        background-color: rgba(0, 0, 0, 0.1);
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
            <div id="to_do" class="kanban-column bg-gray-200 rounded-b p-3 min-h-[500px] flex flex-col gap-3 overflow-y-auto">
                @foreach ($tasks['to_do'] ?? [] as $task)
                    <div class="kanban-item bg-white rounded shadow p-4" draggable="true" data-id="{{ $task->id }}">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-lg flex-grow">{{ $task->title }}</h5>
                            <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold
                                {{ $task->priority == 'low' ? 'bg-green-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-400 text-gray-900' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $task->description }}</p>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm text-gray-500">Assigned to:</span>
                            <span class="text-sm font-medium {{ $task->user_id === Auth::id() ? 'text-blue-600' : 'text-gray-700' }}">
                                {{ $task->user_id === Auth::id() ? 'You' : $task->user->name }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">Due: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}</p>
                        <span class="text-xs px-2 py-1 rounded bg-blue-200 text-blue-800 font-medium">Status: To Do</span>
                        <div class="flex justify-end gap-2 mt-3">
                            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">Delete</button>
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
            <div id="in_progress" class="kanban-column bg-gray-200 rounded-b p-3 min-h-[500px] flex flex-col gap-3 overflow-y-auto">
                @foreach ($tasks['in_progress'] ?? [] as $task)
                    <div class="kanban-item bg-white rounded shadow p-4" draggable="true" data-id="{{ $task->id }}">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-lg flex-grow">{{ $task->title }}</h5>
                            <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold
                                {{ $task->priority == 'low' ? 'bg-green-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-400 text-gray-900' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $task->description }}</p>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm text-gray-500">Assigned to:</span>
                            <span class="text-sm font-medium {{ $task->user_id === Auth::id() ? 'text-blue-600' : 'text-gray-700' }}">
                                {{ $task->user_id === Auth::id() ? 'You' : $task->user->name }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">Due: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}</p>
                        <span class="text-xs px-2 py-1 rounded bg-yellow-200 text-yellow-900 font-medium">Status: In Progress</span>
                        <div class="flex justify-end gap-2 mt-3">
                            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">Delete</button>
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
            <div id="completed" class="kanban-column bg-gray-200 rounded-b p-3 min-h-[500px] flex flex-col gap-3 overflow-y-auto">
                @foreach ($tasks['completed'] ?? [] as $task)
                    <div class="kanban-item bg-white rounded shadow p-4" draggable="true" data-id="{{ $task->id }}">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-semibold text-lg flex-grow">{{ $task->title }}</h5>
                            <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold
                                {{ $task->priority == 'low' ? 'bg-green-500 text-white' : ($task->priority == 'medium' ? 'bg-yellow-400 text-gray-900' : 'bg-red-600 text-white') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $task->description }}</p>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm text-gray-500">Assigned to:</span>
                            <span class="text-sm font-medium {{ $task->user_id === Auth::id() ? 'text-blue-600' : 'text-gray-700' }}">
                                {{ $task->user_id === Auth::id() ? 'You' : $task->user->name }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">Due: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}</p>
                        <span class="text-xs px-2 py-1 rounded bg-green-200 text-green-800 font-medium">Status: Completed</span>
                        <div class="flex justify-end gap-2 mt-3">
                            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">Delete</button>
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
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Assign To</label>
                            <select name="user_id" id="user_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <!-- Self Assignment Option -->
                                <option value="{{ Auth::id() }}">Assign to myself</option>
                                
                                <!-- Project Team Members -->
                                @if($project->users->isNotEmpty())
                                    <optgroup label="Project Team">
                                        @foreach($project->users as $user)
                                            @if($user->id !== Auth::id())
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endif

                                <!-- Project Owner -->
                                @if($project->user->id !== Auth::id())
                                    <optgroup label="Project Owner">
                                        <option value="{{ $project->user->id }}">{{ $project->user->name }}</option>
                                    </optgroup>
                                @endif

                                <!-- Other Users -->
                                @if($users->whereNotIn('id', $project->users->pluck('id')->push($project->user->id)->push(Auth::id()))->isNotEmpty())
                                    <optgroup label="Other Users">
                                        @foreach($users->whereNotIn('id', $project->users->pluck('id')->push($project->user->id)->push(Auth::id())) as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                            @error('user_id')
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
    document.addEventListener('DOMContentLoaded', function() {
        const currentUserId = {{ Auth::id() }};
        const projectId = {{ $project->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Task Creation
        const taskForm = document.querySelector('#createTaskModal form');
        const createTaskModal = document.getElementById('createTaskModal');
        const bsModal = new bootstrap.Modal(createTaskModal);

        taskForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw { errors: data.errors || { general: ['Failed to create task'] } };
                }

                // Close modal
                bsModal.hide();

                // Store success message in session storage
                sessionStorage.setItem('taskSuccess', 'Task created successfully!');

                // Refresh the page
                window.location.reload();

            } catch (error) {
                console.error('Error:', error);
                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());

                if (error.errors) {
                    Object.keys(error.errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'error-message text-red-600 text-sm mt-1';
                            errorDiv.textContent = error.errors[field][0];
                            input.parentNode.appendChild(errorDiv);
                        }
                    });
                }
            } finally {
                submitButton.disabled = false;
            }
        });

        // Check for success message in session storage when page loads
        window.addEventListener('load', function() {
            const successMessage = sessionStorage.getItem('taskSuccess');
            if (successMessage) {
                const successAlert = document.createElement('div');
                successAlert.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6';
                successAlert.role = 'alert';
                successAlert.textContent = successMessage;
                
                const container = document.querySelector('.container');
                container.insertBefore(successAlert, container.firstChild);

                // Remove success message after 3 seconds
                setTimeout(() => {
                    successAlert.remove();
                }, 3000);

                // Clear the success message from session storage
                sessionStorage.removeItem('taskSuccess');
            }
        });

        // Function to create a new task card
        function createTaskCard(task) {
            const card = document.createElement('div');
            card.className = 'kanban-item bg-white rounded shadow p-4';
            card.draggable = true;
            card.dataset.id = task.id;

            const priorityClass = task.priority === 'low' ? 'bg-green-500 text-white' : 
                                task.priority === 'medium' ? 'bg-yellow-400 text-gray-900' : 
                                'bg-red-600 text-white';

            const statusClass = task.status === 'to_do' ? 'bg-blue-200 text-blue-800' : 
                              task.status === 'in_progress' ? 'bg-yellow-200 text-yellow-900' : 
                              'bg-green-200 text-green-800';

            const statusText = task.status === 'to_do' ? 'To Do' : 
                             task.status === 'in_progress' ? 'In Progress' : 
                             'Completed';

            const dueDate = task.due_date ? new Date(task.due_date).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }) : 'No due date';

            const isCurrentUser = task.user_id === currentUserId;

            card.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h5 class="font-semibold text-lg flex-grow">${task.title}</h5>
                    <span class="inline-block px-2 py-0.5 rounded text-sm font-semibold ${priorityClass}">
                        ${task.priority.charAt(0).toUpperCase() + task.priority.slice(1)}
                    </span>
                </div>
                <p class="text-gray-700 mb-2">${task.description || ''}</p>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-sm text-gray-500">Assigned to:</span>
                    <span class="text-sm font-medium ${isCurrentUser ? 'text-blue-600' : 'text-gray-700'}">
                        ${isCurrentUser ? 'You' : task.user_name}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mb-2">Due: ${dueDate}</p>
                <span class="text-xs px-2 py-1 rounded font-medium ${statusClass}">Status: ${statusText}</span>
                <div class="flex justify-end gap-2 mt-3">
                    <form action="/projects/${projectId}/tasks/${task.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded">Delete</button>
                    </form>
                </div>
            `;

            return card;
        }

        // Drag and Drop
        const kanbanColumns = document.querySelectorAll('.kanban-column');
        let draggedItem = null;

        // Initialize draggable items
        function initDraggable() {
            document.querySelectorAll('.kanban-item').forEach(item => {
                item.draggable = true;

                item.addEventListener('dragstart', (e) => {
                    draggedItem = item;
                    setTimeout(() => item.classList.add('opacity-50'), 0);
                });

                item.addEventListener('dragend', () => {
                    item.classList.remove('opacity-50');
                });
            });
        }

        // Initialize drop zones
        kanbanColumns.forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
                column.classList.add('bg-gray-300');
            });

            column.addEventListener('dragleave', () => {
                column.classList.remove('bg-gray-300');
            });

            column.addEventListener('drop', async (e) => {
                e.preventDefault();
                column.classList.remove('bg-gray-300');

                if (!draggedItem) return;

                const taskId = draggedItem.dataset.id;
                const newStatus = column.id;

                try {
                    const response = await fetch(`/tasks/${taskId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to update task status');
                    }

                    // Move the task card
                    column.appendChild(draggedItem);

                    // Update status badge
                    const statusBadge = draggedItem.querySelector('span:last-of-type');
                    const statusText = newStatus === 'to_do' ? 'To Do' : 
                                     newStatus === 'in_progress' ? 'In Progress' : 
                                     'Completed';
                    const statusClass = newStatus === 'to_do' ? 'bg-blue-200 text-blue-800' : 
                                      newStatus === 'in_progress' ? 'bg-yellow-200 text-yellow-900' : 
                                      'bg-green-200 text-green-800';
                    
                    statusBadge.textContent = `Status: ${statusText}`;
                    statusBadge.className = `text-xs px-2 py-1 rounded font-medium ${statusClass}`;

                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to update task status. Please try again.');
                }
            });
        });

        // Initialize draggable items
        initDraggable();

        // Set status when opening create task modal
        document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', () => {
                const status = button.getAttribute('data-status');
                document.getElementById('status').value = status;
            });
        });
    });
</script>

@endsection
