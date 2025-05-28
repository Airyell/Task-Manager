@extends('layouts.app')

@section('title')
    {{ $project->name }} - Project Details
@endsection

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .section-header {
        background-color: #fff;
        color: #0b2c48;
        font-weight: bold;
        padding: 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 6px 12px rgba(0,0,0,0.06);
        margin-bottom: 2rem;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .card-title {
        font-weight: 600;
        color: #0b2c48;
    }

    .btn-primary {
        background-color: #ff914d;
        border-color: #ff914d;
        border-radius: 0.5rem;
    }

    .btn-primary:hover {
        background-color: #e57732;
        border-color: #e57732;
    }

    .btn-secondary {
        border-radius: 0.5rem;
    }

    .progress {
        height: 20px;
        border-radius: 999px;
        background-color: #e0e0e0;
    }

    .progress-bar {
        background-color: #ff914d;
        font-weight: bold;
    }

    .modal-content {
        border-radius: 1rem;
    }

    .alert-success {
        background-color: #d1f0dc;
        border: 1px solid #b0e1c7;
        color: #1e5631;
        border-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
    }

    .team-card {
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 0.75rem 1rem;
        background-color: #ffffff;
    }

    .team-card p {
        margin: 0;
    }
</style>

<div class="container py-5">
    <h2 class="section-header text-center">{{ $project->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Project Details -->
        <div class="col-md-7 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $project->name }}</h5>
                    <p class="card-text">{{ $project->description }}</p>
                    <p class="card-text"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') }}</p>
                    <p class="card-text"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') }}</p>
                    <p class="card-text"><strong>Status:</strong> 
                        {{ $project->status == 'pending' ? 'Pending' : ($project->status == 'on_going' ? 'In Progress' : 'Completed') }}
                    </p>
                    <p class="card-text"><strong>Budget:</strong> ${{ $project->budget }}</p>

                    @php
                        $totalTasks = $project->tasks->count();
                        $completedTasks = $project->tasks->where('status', 'completed')->count();
                        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                    @endphp

                    <h5 class="mt-4">Project Progress</h5>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" 
                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ round($progress) }}%
                        </div>
                    </div>

                    <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">← Back to Projects</a>
                </div>
            </div>
        </div>

        <!-- Team Members -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Team Members</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>

                    @forelse ($teamMembers as $user)
                        <div class="team-card mb-2">
                            <p class="fw-bold">{{ $user->name }}</p>
                            <p class="text-muted small">{{ $user->email }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No team members assigned.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('projects.addMember') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Select User</label>
                        <select class="form-select" name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
