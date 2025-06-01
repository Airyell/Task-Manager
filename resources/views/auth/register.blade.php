@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('assets/img/Background.png') }}'); font-family: 'Poppins', sans-serif;">
    <div class="bg-white/85 max-w-lg w-full p-8 md:p-10 rounded-2xl shadow-lg border border-[rgba(100,90,80,0.2)] backdrop-blur-md">
        <h2 class="text-3xl font-bold text-center text-[#0f2d4e] mb-7">Create an Account</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-semibold text-[#0f2d4e] mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block font-semibold text-[#0f2d4e] mb-1">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                    class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]">
                @error('username')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block font-semibold text-[#0f2d4e] mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]">
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-semibold text-[#0f2d4e] mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]">
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold text-[#0f2d4e] mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full rounded-xl px-4 py-2 border border-gray-300 bg-[#fdf9f3] focus:outline-none focus:ring-2 focus:ring-[#0f2d4e]">
            </div>

            <button type="submit"
                class="w-full bg-[#0f2d4e] text-white font-semibold py-3 rounded-xl hover:bg-[#0c233c] transition duration-300 mt-4">
                Register
            </button>

            <div class="text-center mt-5 text-sm text-[#7a6e58]">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#f28b2c] font-medium hover:underline">Login</a>
            </div>
        </form>
    </div>
</div>
@endsection
