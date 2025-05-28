@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('{{ asset('assets/img/Background.png') }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 1rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        padding: 2rem;
        max-width: 500px;
        margin: auto;
    }

    .register-card h2 {
        font-weight: 600;
        text-align: center;
        color: #0f2d4e;
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control {
        border-radius: 0.5rem;
    }

    .btn-primary {
        width: 100%;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        background-color: #0d2a45;
    }
</style>

<div class="container mt-5">
    <div class="register-card">
        <h2>Create an Account</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" class="form-control" name="name" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>
@endsection
