@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    body {
        background: url('{{ asset('assets/img/Background.png') }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 90vh;
    }

    .dashboard-card {
        background: rgba(255, 248, 241, 0.95);
        border-radius: 1rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(100, 90, 80, 0.2);
        max-width: 1000px;
        width: 100%;
        padding: 2rem;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .dashboard-header h2 {
        font-weight: 700;
        color: #0f2d4e;
    }

    .logo {
        max-height: 100px;
        margin-bottom: 1rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.95; }
    }

    .card-title {
        color: #0f2d4e;
        font-weight: 600;
    }

    .card-text {
        color: #333;
    }

    .list-group-item {
        font-size: 0.95rem;
    }

    .card {
        background-color: #fffdfb;
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <img src="{{ asset('assets/img/kangaroo-fixed-logo.png') }}" alt="Taskaroo Logo" class="logo" />
            <h2>Taskaroo</h2>
            <p>Welcome to your dashboard where you can manage your tasks and notes.</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Tasks</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $tasksCount }}</strong> tasks pending.</p>
                        <a href="{{ route('projects.index') }}" class="btn btn-primary mt-auto">View Tasks</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Notes</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $notesCount }}</strong> notes saved.</p>
                        <a href="{{ route('notes.index') }}" class="btn btn-primary mt-auto">View Notes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Completed Tasks</h5>
                        <p class="card-text flex-grow-1">You have <strong>{{ $completedTasksCount }}</strong> Completed Tasks Saved.</p>
                        <a href="{{ route('projects.index') }}" class="btn btn-primary mt-auto">View Tasks</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Recent Tasks</h5>
                        <ul class="list-group">
                            @foreach($recentTasks as $task)
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
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">Recent Notes</h5>
                        <ul class="list-group">
                            @foreach($recentNotes as $note)
                                <li class="list-group-item">
                                    {{ $note->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
