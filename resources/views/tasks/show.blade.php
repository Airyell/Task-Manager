@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    <h1 class="text-2xl font-bold mb-4">{{ $task->title }}</h1>

    <!-- Time Tracker -->
    <div class="mb-6 p-4 border rounded shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">Time Tracker</h2>
        <div id="time-display" class="text-3xl font-mono mb-3">00:00:00</div>
        <div class="space-x-2">
            <button id="start-btn" class="btn btn-success">Start</button>
            <button id="pause-btn" class="btn btn-warning">Pause</button>
            <button id="reset-btn" class="btn btn-danger">Reset</button>
        </div>
    </div>

    <!-- Checklist Section -->
    <div class="mb-6 p-4 border rounded shadow-sm bg-white">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-xl font-semibold">Checklist</h2>
            <!-- Add Checklist Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addChecklistModal">
                <i class="bi bi-plus-lg"></i> Add Item
            </button>
        </div>

        <ul class="list-group">
            @foreach ($task->checklistItems as $item)
            <li class="list-group-item flex items-center justify-between">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="checklist-item-checkbox-{{ $item->id }}"
                        {{ $item->completed ? 'checked' : '' }}
                        onchange="toggleChecklistItem({{ $item->id }})"
                    />
                    <label
                        class="form-check-label {{ $item->completed ? 'text-decoration-line-through text-muted' : '' }}"
                        for="checklist-item-checkbox-{{ $item->id }}"
                    >
                        {{ $item->name }}
                    </label>
                </div>
                <div class="space-x-2">
                    <!-- Edit Checklist Item Button -->
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editChecklistModal-{{ $item->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <!-- Delete Checklist Item Button -->
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteChecklistItem({{ $item->id }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- History Button -->
    <div class="mb-6">
        <button type="button" class="btn btn-indigo btn-outline-indigo" data-bs-toggle="modal" data-bs-target="#historyModal">
            <i class="bi bi-clock-history"></i> Show History
        </button>
    </div>

    <!-- History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content rounded shadow-lg">
                <div class="modal-header border-b px-4 py-2">
                    <h5 class="modal-title" id="historyModalLabel">Task History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body px-4 py-4">
                    @if ($task->history->isEmpty())
                        <p>No history found for this task.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($task->history as $history)
                                <li class="list-group-item">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <strong>{{ $history->action }}</strong> 
                                            @if($history->user)
                                                by {{ $history->user->name }}
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $history->created_at->format('M d, Y h:i A') }}</small>
                                        </div>
                                        <div>
                                            <small>{{ $history->details ?? '' }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer border-t px-4 py-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Checklist Modal -->
    <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('checklist-items.store', $task->id) }}" class="modal-content rounded shadow-lg">
                @csrf
                <div class="modal-header border-b px-4 py-2">
                    <h5 class="modal-title" id="addChecklistModalLabel">Add Checklist Item</h5>
                    <button type="button" class="btn-close text-gray-500 hover:text-gray-700" data-bs-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body px-4 py-4">
                    <input type="text" name="name" class="form-input w-full rounded border px-3 py-2" placeholder="Checklist item name" required>
                </div>
                <div class="modal-footer flex justify-end border-t px-4 py-2 space-x-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Checklist Modals -->
    @foreach ($task->checklistItems as $item)
        <div class="modal fade" id="editChecklistModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editChecklistModalLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('checklist-items.update', [$task->id, $item->id]) }}" class="modal-content rounded shadow-lg">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-b px-4 py-2">
                        <h5 class="modal-title" id="editChecklistModalLabel-{{ $item->id }}">Edit Checklist Item</h5>
                        <button type="button" class="btn-close text-gray-500 hover:text-gray-700" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <input type="text" name="name" class="form-input w-full rounded border px-3 py-2" value="{{ $item->name }}" required>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" name="completed" value="1" {{ $item->completed ? 'checked' : '' }} class="form-checkbox text-blue-600">
                            <span class="ml-2 text-gray-700">Completed</span>
                        </label>
                    </div>
                    <div class="modal-footer flex justify-end border-t px-4 py-2 space-x-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>

<script>
    // Time Tracker JS
    let timer = null;
    let seconds = 0;

    function updateTimeDisplay() {
        const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
        const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
        const s = String(seconds % 60).padStart(2, '0');
        document.getElementById('time-display').textContent = `${h}:${m}:${s}`;
    }

    document.getElementById('start-btn').addEventListener('click', () => {
        if (!timer) {
            timer = setInterval(() => {
                seconds++;
                updateTimeDisplay();
            }, 1000);
        }
    });

    document.getElementById('pause-btn').addEventListener('click', () => {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    });

    document.getElementById('reset-btn').addEventListener('click', () => {
        clearInterval(timer);
        timer = null;
        seconds = 0;
        updateTimeDisplay();
    });

    // Checklist toggle function (add AJAX to update backend if needed)
    function toggleChecklistItem(itemId) {
        const checkbox = document.getElementById(`checklist-item-checkbox-${itemId}`);
        const label = checkbox.nextElementSibling;
        if (checkbox.checked) {
            label.classList.add('text-decoration-line-through', 'text-muted');
        } else {
            label.classList.remove('text-decoration-line-through', 'text-muted');
        }
        // TODO: send AJAX request to update the completed status on server
    }

    // Delete checklist item with confirmation
    function deleteChecklistItem(itemId) {
        if (confirm('Are you sure you want to delete this checklist item?')) {
            // You can either:
            // 1) Submit a form to your delete route
            // 2) Redirect to a delete URL
            // 3) Use AJAX to delete (recommended)
            // For simplicity, redirecting here:
            window.location.href = `/checklist-items/{{ $task->id }}/delete/${itemId}`;
        }
    }
</script>
@endsection
