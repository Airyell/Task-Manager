@extends('layouts.app')

@section('title')
    User Profile
@endsection

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }

    .profile-container {
        max-width: 700px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 1rem;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
    }

    .profile-container h1 {
        color: #0b2c48;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .profile-container p {
        font-size: 1rem;
        color: #333;
        margin-bottom: 0.75rem;
    }

    .profile-container strong {
        color: #0b2c48;
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
</style>

<div class="container">
    <div class="profile-container">
        <h1>User Profile</h1>

        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        @if ($user->profile && isset($user->profile['bio']))
            <p><strong>Bio:</strong> {{ $user->profile['bio'] }}</p>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
