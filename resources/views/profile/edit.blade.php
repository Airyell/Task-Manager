@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .container {
        padding-top: 80px;
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .card-header {
        background-color: transparent;
        border-bottom: none;
        padding-bottom: 0;
    }

    .card-header h4 {
        color: #0b2c48;
        font-weight: 600;
    }

    .form-group label {
        color: #0b2c48;
        font-weight: 500;
    }

    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #ccc;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #ff914d;
        box-shadow: 0 0 0 0.1rem rgba(255, 145, 77, 0.25);
    }

    .alert-danger {
        border-radius: 0.5rem;
        background-color: #ffe0e0;
        border: none;
        color: #b10000;
    }

    .btn-success {
        background-color: #ff914d;
        border: none;
        font-weight: 500;
        padding: 0.5rem 1.25rem;
        border-radius: 999px;
        transition: all 0.2s ease-in-out;
    }

    .btn-success:hover {
        background-color: #e57732;
    }

    .btn-secondary {
        border-radius: 999px;
        padding: 0.5rem 1.25rem;
    }

    .card-footer {
        background-color: transparent;
        border-top: none;
    }
</style>

<div class="container d-flex justify-content-center align-items-start">
    <div class="col-md-8">

        <form class="card w-100" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="card-header text-center">
                <h4 class="mb-0 mt-2">Edit Profile</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group row mb-3">
                    <label for="name" class="col-sm-4 col-form-label text-sm-right">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="username" class="col-sm-4 col-form-label text-sm-right">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username', $user->username ?? '') }}">
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="email" class="col-sm-4 col-form-label text-sm-right">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <hr>

                <div class="form-group row mb-3">
                    <label for="current_password" class="col-sm-4 col-form-label text-sm-right">Current Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="new_password" class="col-sm-4 col-form-label text-sm-right">New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="new_password_confirmation" class="col-sm-4 col-form-label text-sm-right">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('profile.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>

    </div>
</div>
@endsection