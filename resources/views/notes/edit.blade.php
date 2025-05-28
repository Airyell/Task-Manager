@extends('layouts.app')

@section('title')
    Edit Note
@endsection

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .section-header {
        background-color: #ffffff;
        color: #0b2c48;
        font-weight: bold;
        padding: 1.25rem;
        border-radius: 1rem;
        box-shadow: 0 6px 12px rgba(0,0,0,0.06);
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-container {
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        max-width: 600px;
        margin: auto;
    }

    .form-label {
        color: #0b2c48;
        font-weight: 500;
    }

    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #ccc;
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

    .text-danger {
        font-size: 0.9rem;
    }
</style>

<div class="container py-5">
    <h2 class="section-header">Edit Note</h2>

    <div class="form-container">
        <form action="{{ route('notes.update', $note->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $note->title }}" required>
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ $note->content }}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $note->date }}">
                @error('date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Note</button>
        </form>
    </div>
</div>
@endsection
