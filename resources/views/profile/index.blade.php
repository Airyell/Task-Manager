@extends('layouts.app') {{-- or your layout file --}}

@section('content')
<div class="container" style="max-width: 700px; margin: auto; padding-top: 30px;">
    <h1 style="margin-bottom: 20px;">User Profile</h1>

    <div style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        @if ($user->profile && isset($user->profile['bio']))
            <p><strong>Bio:</strong> {{ $user->profile['bio'] }}</p>
        @endif

        <div style="margin-top: 20px;">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
