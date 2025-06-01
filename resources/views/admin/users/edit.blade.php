<<<<<<< HEAD
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
=======
@extends('layouts.admin') {{-- Assuming you have a layout file --}}

@section('title', 'Edit User: ' . $user->name) {{-- Set the page title --}}

@section('content')
<div class="space-y-6 max-w-4xl mx-auto py-6"> {{-- Centering and spacing for the whole form content --}}

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit User: {{ $user->name }}</h2>

    <div class="bg-white rounded-lg shadow-md p-6"> {{-- Card-like container for the form --}}
        <div class="border-b pb-4 mb-4"> {{-- Header for the form card --}}
            <h3 class="text-xl font-semibold text-gray-800">User Profile</h3>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT') {{-- Use PUT method for updates --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4"> {{-- Grid for form fields --}}
                {{-- Name --}}
                <div class="col-span-full">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                    <input id="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="col-span-full">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                    <input id="username" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('username') border-red-500 @enderror" name="username" value="{{ old('username', $user->username) }}" required autocomplete="username">
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-span-full">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input id="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="col-span-full">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                    <select id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('role') border-red-500 @enderror" name="role" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
>>>>>>> ddbdec20ebf3a8cf9c7c82e1cb2c5d5b4a962c5e
                    @enderror
                </div>
            </div>

<<<<<<< HEAD
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
=======
            {{-- Password Section (Optional) --}}
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold text-gray-800">Change Password (Optional)</h3>
                <p class="text-sm text-gray-500 mt-2">Leave these fields empty if you don't want to change the password.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                    {{-- New Password --}}
                    <div class="col-span-full">
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('password') border-red-500 @enderror" name="password" autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="col-span-full">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input id="password-confirm" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-3"> {{-- Buttons --}}
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update User Profile
                </button>
                <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
>>>>>>> ddbdec20ebf3a8cf9c7c82e1cb2c5d5b4a962c5e
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
