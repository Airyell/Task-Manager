@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('{{ asset('assets/img/Background.png') }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .register-card {
        background: rgba(255, 248, 241, 0.85);
        border-radius: 1rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(100, 90, 80, 0.2);
        padding: 2rem 2.5rem;
        max-width: 500px;
        width: 100%;
    }

    .register-card h2 {
        font-weight: 700;
        text-align: center;
        color: #0f2d4e;
        margin-bottom: 1.75rem;
        font-size: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #0f2d4e;
    }

    .form-control {
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        border: 1px solid #ccc;
        background-color: #fdf9f3;
    }

    .form-control:focus {
        border-color: #0f2d4e;
        box-shadow: 0 0 0 0.2rem rgba(15, 45, 78, 0.2);
    }

    .btn-primary {
        background-color: #0f2d4e;
        color: #fff;
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem;
        font-weight: 600;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 1rem;
    }

    .btn-primary:hover {
        background-color: #0c233c;
    }

    .form-note {
        text-align: center;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #7a6e58;
    }

    @media (max-width: 576px) {
        .register-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <h2>Create an Account</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>

            <div class="form-note">
                Already have an account? <a href="{{ route('login') }}" style="color: #f28b2c; font-weight: 500;">Login</a>
            </div>
        </form>
    </div>
</div>
@endsection
