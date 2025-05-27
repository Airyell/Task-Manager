@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl w-full bg-white rounded-lg shadow-xl overflow-hidden">

        <div class="p-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center rounded-t-lg">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-800">Welcome, {{ $user->name ?? 'User' }}</h1>
                <span class="ml-4 text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('D d F Y') }}</span>
            </div>
            <div class="flex items-center space-x-4">
                {{-- Removed the search bar as requested --}}
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr($user->name ?? 'U', 0, 1) }}
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="relative bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 h-32 rounded-lg mb-12 shadow-md"> {{-- Adjusted h-40 to h-32 and mb-16 to mb-12 for smaller image positioning --}}
                <div class="absolute -bottom-6 left-8 flex items-center"> {{-- Adjusted -bottom-8 to -bottom-6 for smaller image --}}
                    <img
                        src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://placehold.co/40x40/e2e8f0/000000?text=P' }}" {{-- Changed to 40x40 (approx 2x2 inches on screen) --}}
                        alt="Profile Picture"
                        class="w-10 h-10 object-cover rounded-full border-4 border-white shadow-lg" {{-- Changed w-16 h-16 to w-10 h-10 --}}
                    >
                    <div class="ml-4 text-white"> {{-- Adjusted ml-6 to ml-4 for closer text --}}
                        <h2 class="text-xl font-bold">{{ $user->name ?? 'Your Name' }}</h2> {{-- Adjusted text-2xl to text-xl --}}
                        <p class="text-gray-100 text-sm">{{ $user->email ?? 'your.email@example.com' }}</p> {{-- Added text-sm --}}
                    </div>
                </div>
                <label for="profile_picture" class="absolute -bottom-4 right-8 inline-block cursor-pointer bg-white text-blue-600 text-sm px-3 py-1.5 rounded-full shadow-md hover:bg-gray-100 transition"> {{-- Adjusted padding and bottom position --}}
                    Edit
                </label>
                <input type="file" name="profile_picture" id="profile_picture" class="hidden">
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 mt-8">
                @csrf
                @method('PUT')

                @error('profile_picture')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nickname" class="block text-sm font-medium text-gray-700">Nick Name</label>
                        <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('nickname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                        <input type="text" name="country" id="country" value="{{ old('country', $user->country ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                        <input type="text" name="language" id="language" value="{{ old('language', $user->language ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('language')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700">Time Zone</label>
                        <input type="text" name="timezone" id="timezone" value="{{ old('timezone', $user->timezone ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('timezone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">My email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">1 month ago</p>
                        <button type="button" class="text-blue-600 text-sm mt-2 hover:underline">+ Add Email Address</button>
                    </div>

                    {{-- Kept these existing fields as they are not explicitly removed by the image --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="number" class="block text-sm font-medium text-gray-700">Number</label>
                        <input type="text" name="number" id="number" value="{{ old('number', $user->number ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                        <input type="number" name="age" id="age" value="{{ old('age', $user->age ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('age')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePictureInput = document.getElementById('profile_picture');
        const profilePictureImg = document.querySelector('.absolute img'); // Select the image inside the absolute div

        if (profilePictureInput && profilePictureImg) {
            profilePictureInput.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePictureImg.src = e.target.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        }
    });
</script>
@endsection
