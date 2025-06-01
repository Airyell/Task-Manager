@extends('layouts.admin') {{-- Or whatever your admin layout file is --}}

@section('title', 'Edit Task')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Task: {{ $task->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Task Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Use PUT method for updates --}}

                <div class="form-group">
                    <label for="title">Task Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $task->description) }}</textarea>
                </div>

                {{-- Assuming task status (e.g., pending, in_progress, completed) --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        {{-- Add other statuses if applicable --}}
                    </select>
                </div>

                {{-- Assuming a due date field --}}
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
                </div>

                {{-- If you want to change the assigned project or user --}}
                {{-- Example for assigning to a project (you'd need to pass $projects from controller)
                <div class="form-group">
                    <label for="project_id">Project</label>
                    <select class="form-control" id="project_id" name="project_id">
                        <option value="">-- Select Project --</option>
                        @foreach ($projects as $projectOption)
                            <option value="{{ $projectOption->id }}" {{ old('project_id', $task->project_id) == $projectOption->id ? 'selected' : '' }}>
                                {{ $projectOption->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                --}}
                {{-- Example for assigning to a user (you'd need to pass $users from controller)
                <div class="form-group">
                    <label for="user_id">Assigned To</label>
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">-- Select User --</option>
                        @foreach ($users as $userOption)
                            <option value="{{ $userOption->id }}" {{ old('user_id', $task->user_id) == $userOption->id ? 'selected' : '' }}>
                                {{ $userOption->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                --}}

                <button type="submit" class="btn btn-primary">Update Task</button>
                <a href="{{ route('admin.tasks') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection