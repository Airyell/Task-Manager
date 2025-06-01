@extends('layouts.app')

@section('title')
    User Profile
@endsection

@section('content')
<div class="bg-[#fdf1e5] min-h-screen py-10 font-['Noto_Sans']">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-md">
        <h1 class="text-2xl font-bold text-[#0b2c48] text-center mb-6">User Profile</h1>

        <p class="text-base text-gray-800 mb-3">
            <strong class="text-[#0b2c48]">Name:</strong> {{ $user->name }}
        </p>
        <p class="text-base text-gray-800 mb-3">
            <strong class="text-[#0b2c48]">Username:</strong> {{ $user->username }}
        </p>
        <p class="text-base text-gray-800 mb-3">
            <strong class="text-[#0b2c48]">Email:</strong> {{ $user->email }}
        </p>

        @if ($user->profile && isset($user->profile['bio']))
            <p class="text-base text-gray-800 mb-3">
                <strong class="text-[#0b2c48]">Bio:</strong> {{ $user->profile['bio'] }}
            </p>
        @endif

        <div class="text-center mt-6">
            <a href="{{ route('profile.edit') }}"
                class="bg-[#ff914d] hover:bg-[#e57732] text-white font-medium px-6 py-2 rounded-lg transition-colors duration-200">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection
