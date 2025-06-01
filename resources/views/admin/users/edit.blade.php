@extends('layouts.admin') {{-- Or your admin layout --}}

@section('content')
<div class="max-w-3xl mx-auto mt-12 px-4">
    <div class="bg-white shadow rounded-lg p-8">
        <h2 class="text-xl font-semibold mb-6">Edit User: {{ $user->name }}</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row md:items-center">
                <label for="name" class="md:w-1/3 text-gray-700 font-medium mb-2 md:mb-0">Name <span class="text-red-600">*</span></label>
                <div class="md:w-2/3">
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $user->name) }}"
                        required
                        autocomplete="name"
                        autofocus
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center">
                <label for="username" class="md:w-1/3 text-gray-700 font-medium mb-2 md:mb-0">Username <span class="text-red-600">*</span></label>
                <div class="md:w-2/3">
                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username', $user->username) }}"
                        required
                        autocomplete="username"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror"
                    >
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center">
                <label for="email" class="md:w-1/3 text-gray-700 font-medium mb-2 md:mb-0">Email <span class="text-red-600">*</span></label>
                <div class="md:w-2/3">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Password Section --}}
            <div>
                <h3 class="text-lg font-semibold mt-8 mb-2">Change Password (Optional)</h3>
                <p class="text-gray-500 mb-4">Leave these fields empty if you don't want to change the password.</p>
            </div>

            <div class="flex flex-col md:flex-row md:items-center">
                <label for="password" class="md:w-1/3 text-gray-700 font-medium mb-2 md:mb-0">New Password</label>
                <div class="md:w-2/3">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                    >
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center">
                <label for="password-confirm" class="md:w-1/3 text-gray-700 font-medium mb-2 md:mb-0">Confirm New Password</label>
                <div class="md:w-2/3">
                    <input
                        id="password-confirm"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                </div>
            </div>

            <div class="flex justify-start md:justify-start space-x-4 mt-6">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-md transition"
                >
                    Update User Profile
                </button>
                <a
                    href="{{ route('admin.users.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-md transition"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
