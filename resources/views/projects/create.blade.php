@extends('layouts.app')

@section('title')
    Create Project
@endsection

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .container {
        padding-top: 80px;
        padding-bottom: 60px;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #0b2c48;
        background-color: #ffffff;
        padding: 1rem 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        text-align: center;
        margin-bottom: 2rem;
    }

    .card {
        border: none;
        border-radius: 1.25rem;
        background-color: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 500;
        color: #0b2c48;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #ccc;
        transition: border-color 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ff914d;
        box-shadow: 0 0 0 0.15rem rgba(255, 145, 77, 0.25);
    }

    .text-danger {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .btn-primary {
        background-color: #ff914d;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 999px;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #e57732;
    }
</style>

<div class="container d-flex justify-content-center">
    <div class="w-100" style="max-width: 700px;">
        <div class="page-title">Create Project</div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Project Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
