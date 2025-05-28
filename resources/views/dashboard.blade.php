@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .dashboard-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        width: 100%;
        max-width: 1100px;
        backdrop-filter: blur(5px);
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .dashboard-header h2 {
        font-weight: 700;
        color: #0b2c48;
    }

    .dashboard-header p {
        color: #333;
        font-size: 1rem;
    }

    .card {
        border: none;
        border-radius: 1rem;
        background-color: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .card-title {
        color: #0b2c48;
        font-weight: 600;
    }

    .card-text {
        color: #444;
    }

    .list-group-item {
        font-size: 0.95rem;
        border: none;
        border-bottom: 1px solid #eee;
        padding-left: 0;
        padding-right: 0;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .btn {
        background-color: #ff914d;
        color: #fff;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        border-radius: 999px;
        padding: 0.5rem 1rem;
    }

    .btn:hover {
        background-color: #e57732;
        transform: scale(1.03);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #0b2c48;
    }

    .badge.bg-primary {
        background-color: #0b2c48 !important;
    }

    .badge.bg-success {
        background-color: #28a745 !important;
    }

    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <h2>Welcome to Taskaroo</h2>
            <p>Manage your tasks and notes in one organized place.</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Tasks</h5>
                    <p class="card-text">You have <strong>{{ $tasksCount }}</strong> tasks pending.</p>
                    <a href="{{ route('projects.index') }}" class="btn mt-auto">View Tasks</a>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Notes</h5>
                    <p class="card-text">You have <strong>{{ $notesCount }}</strong> notes saved.</p>
                    <a href="{{ route('notes.index') }}" class="btn mt-auto">View Notes</a>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card p-3 h-100">
                    <h5 class="card-title">Completed Tasks</h5>
                    <p class="card-text">You have <strong>{{ $completedTasksCount }}</strong> completed tasks.</p>
                    <a href="{{ route('projects.index') }}" class="btn mt-auto">View Completed</a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card p-3 h-100">
                    <div class="section-title">Recent Tasks</div>
                    <ul class="list-group list-group-flush">
                        @forelse($recentTasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $task->title }}
                                <span class="badge 
                                    {{ $task->status == 'to_do' ? 'bg-primary' : ($task->status == 'in_progress' ? 'bg-warning text-dark' : 'bg-success') }} 
                                    rounded-pill">
                                    {{
                                        $task->status == 'to_do' ? 'To Do' :
                                        ($task->status == 'in_progress' ? 'In Progress' : 'Completed')
                                    }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No recent tasks available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card p-3 h-100">
                    <div class="section-title">Recent Notes</div>
                    <ul class="list-group list-group-flush">
                        @forelse($recentNotes as $note)
                            <li class="list-group-item">{{ $note->title }}</li>
                        @empty
                            <li class="list-group-item text-muted">No recent notes available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
