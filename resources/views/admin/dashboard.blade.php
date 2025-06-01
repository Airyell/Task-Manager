@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    @if(auth()->user()->role === 'admin')
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">{{ $users->count() }} total users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Projects</h5>
                        <p class="card-text">{{ $projects->count() }} total projects</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tasks</h5>
                        <p class="card-text">{{ $tasks->count() }} total tasks</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tasks Table -->
        <div class="card">
            <div class="card-header">Recent Tasks</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Assigned User</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks->take(5) as $task)
                            <tr>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                                <td>{{ ucfirst($task->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-danger">You are not authorized to view this page.</div>
    @endif
</div>
@endsection
