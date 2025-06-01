@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdf1e5] font-['Noto_Sans'] py-20 flex justify-center items-start">
    <div class="w-full max-w-2xl">
        <form method="POST" action="{{ route('profile.update') }}" class="bg-white rounded-2xl shadow-2xl p-8">
            @csrf
            @method('PUT')

            <div class="text-center mb-6">
                <h4 class="text-2xl font-semibold text-[#0b2c48]">Edit Profile</h4>
            </div>

            @if ($errors->any())
                <div class="bg-[#ffe0e0] text-[#b10000] rounded-lg px-4 py-3 mb-5">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Name --}}
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="name" class="w-full sm:w-1/3 text-[#0b2c48] font-medium mb-2 sm:mb-0 text-right pr-4">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full sm:w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-200"
                    value="{{ old('name', $user->name) }}">
            </div>

            {{-- Username --}}
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="username" class="w-full sm:w-1/3 text-[#0b2c48] font-medium mb-2 sm:mb-0 text-right pr-4">Username</label>
                <input type="text" id="username" name="username"
                    class="w-full sm:w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-200"
                    value="{{ old('username', $user->username ?? '') }}">
            </div>

            {{-- Email --}}
            <div class="flex flex-col sm:flex-row items-center mb-6">
                <label for="email" class="w-full sm:w-1/3 text-[#0b2c48] font-medium mb-2 sm:mb-0 text-right pr-4">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full sm:w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-200"
                    value="{{ old('email', $user->email) }}">
            </div>

            <hr class="my-6">

            {{-- Current Password --}}
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="current_password" class="w-full sm:w-1/3 text-[#0b2c48] font-medium mb-2 sm:mb-0 text-right pr-4">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                    class="w-full sm:w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-200">
            </div>

            {{-- New Password --}}
            <div class="flex flex-col sm:flex-row items-center mb-4">
                <label for="new_password" class="w-full sm:w-1/3 text-[#0b2c48] font-medium mb-2 sm:mb-0 text-right pr-4">New Password</label>
                <input type="password" id="new_password" name="new_password"
                    class="w-full sm:w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-200">
            </div>

            {{-- Confirm Password --}}
            <div class="flex flex-col sm:flex-row items-center mb-6">
                <label for="new_password_confirmation" class="w-full sm:w-1/3 text-[#0b2c48] font-medium mb-2 sm:mb-0 text-right pr-4">Confirm Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                    class="w-full sm:w-2/3 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-400 focus:ring focus:ring-orange-200">
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('profile.index') }}"
                   class="bg-gray-300 text-gray-800 px-5 py-2 rounded-full font-medium hover:bg-gray-400 transition">
                   Cancel
                </a>
                <button type="submit"
                    class="bg-[#ff914d] text-white px-5 py-2 rounded-full font-medium hover:bg-[#e57732] transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
