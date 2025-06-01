@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    @if (session('status'))
        <div class="bg-green-100 text-green-800 text-sm font-medium px-4 py-2 rounded mt-4 mb-6">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex justify-center">
        <div class="w-full max-w-2xl">
            <!-- User Profile -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-[#0f2d4e] text-white flex justify-between items-center px-6 py-4">
                    <h4 class="text-lg font-semibold mb-0">User Profile</h4>
                    <a href="{{ route('profile.edit') }}"
                       class="text-sm uppercase bg-white text-[#0f2d4e] hover:bg-gray-200 font-medium px-3 py-1.5 rounded transition duration-150">
                        Edit
                    </a>
                </div>

                <div class="px-6 py-6">
                    <div class="mb-4 flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 font-semibold text-gray-700 mb-1 sm:mb-0 text-sm sm:text-right">Name</div>
                        <div class="sm:w-2/3 bg-gray-100 text-sm text-gray-600 px-4 py-2 rounded-md">{{ $user->name }}</div>
                    </div>

                    <div class="mb-4 flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 font-semibold text-gray-700 mb-1 sm:mb-0 text-sm sm:text-right">Email</div>
                        <div class="sm:w-2/3 bg-gray-100 text-sm text-gray-600 px-4 py-2 rounded-md">{{ $user->email }}</div>
                    </div>

                    <div class="mb-4 flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 font-semibold text-gray-700 mb-1 sm:mb-0 text-sm sm:text-right">Username</div>
                        <div class="sm:w-2/3 bg-gray-100 text-sm text-gray-600 px-4 py-2 rounded-md">{{ $user->username ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <!-- /User Profile -->
        </div>
    </div>
</div>
@endsection
