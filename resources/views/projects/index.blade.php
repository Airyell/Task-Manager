@extends('layouts.app')

@section('title')
    Projects
@endsection

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .page-header {
        background-color: #fff;
        padding: 1.25rem 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .page-header h2 {
        color: #0b2c48;
        font-weight: 700;
        margin: 0;
    }

    .btn-add {
        background-color: #ff914d;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 999px;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-add:hover {
        background-color: #e57732;
    }

    .card {
        border: none;
        border-radius: 1rem;
        background-color: #ffffff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0b2c48;
    }

    .card-text {
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .text-danger {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .card-body .btn {
        margin-right: 0.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        padding: 0.4rem 0.6rem;
    }

    .alert-success {
        background-color: #d1f0dc;
        border: 1px solid #b0e1c7;
        color: #1e5631;
        border-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
    }

</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center page-header">
        <h2>Projects</h2>
        <a href="{{ route('projects.create') }}" class="btn btn-add">+ Add Project</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                        <p class="card-text mb-3">
                            <strong>Status:</strong>
                            {{ 
                                $project->status === 'pending' ? 'Pending' : 
                                ($project->status === 'on_going' ? 'In Progress' : 'Completed') 
                            }}<br>
                            <strong>Deadline:</strong>
                            @if($project->end_date && $project->end_date->isFuture())
                                {{ $project->end_date->diffForHumans() }}
                            @else
                                <span class="text-danger">Deadline Passed</span>
                            @endif
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-primary" title="Tasks">
                                <i class="bi bi-list"></i>
                            </a>
                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                No projects found.
            </div>
        @endforelse
    </div>
</div>
@endsection
