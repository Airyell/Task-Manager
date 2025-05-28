@extends('layouts.app')

@section('title')
    Notes
@endsection

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .notes-header {
        background-color: #ffffff;
        color: #0b2c48;
        font-weight: bold;
        padding: 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 6px 12px rgba(0,0,0,0.06);
        margin-bottom: 2rem;
    }

    .btn-primary {
        background-color: #ff914d;
        border-color: #ff914d;
        border-radius: 0.5rem;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #e57732;
        border-color: #e57732;
    }

    .btn-warning {
        background-color: #ffd07b;
        border-color: #ffc107;
        color: #0b2c48;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .btn-danger {
        background-color: #f87171;
        border-color: #ef4444;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        background-color: #ffffff;
    }

    .card-title {
        color: #0b2c48;
        font-weight: bold;
    }

    .card-text {
        color: #333;
    }

    .alert-success {
        border-radius: 0.75rem;
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center notes-header">
        <h2>Notes</h2>
        <a href="{{ route('notes.create') }}" class="btn btn-primary">Add Note</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($notes as $note)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $note->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($note->content, 150) }}</p>
                        <p class="card-text"><strong>Date:</strong> {{ $note->date }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">No notes found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
