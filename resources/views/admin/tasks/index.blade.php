@extends('layouts.admin') {{-- Or whatever your admin layout file is --}}

@section('title', 'Manage Tasks')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Tasks</h1>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Task List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tasksTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Project</th> {{-- Assuming tasks are linked to projects --}}
                            <th>Assigned To</th> {{-- Assuming tasks are assigned to users --}}
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project->name ?? 'N/A' }}</td> {{-- Assuming task belongs to a project --}}
                            <td>{{ $task->user->name ?? 'N/A' }}</td> {{-- Assuming task is assigned to a user --}}
                            <td>{{ ucfirst($task->status) }}</td>
                            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-info btn-sm">Edit</a>
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No tasks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Example for a simple DataTables initialization --}}
    {{-- <script>
        $(document).ready(function() {
            $('#tasksTable').DataTable();
        });
    </script> --}}
@endpush