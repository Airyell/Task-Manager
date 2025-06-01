@extends('layouts.app')

@section('title')
    Create Project
@endsection

@section('content')
<div class="min-h-screen bg-[#fdf1e5] font-sans pt-20 pb-16 px-4">
    <div class="max-w-xl mx-auto w-full">
        <div class="bg-white rounded-2xl shadow-md px-6 py-6 mb-8 text-center">
            <h1 class="text-2xl font-semibold text-[#0b2c48]">Create Project</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-lg">
            <div class="p-8">
                <form action="{{ route('projects.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block mb-2 font-medium text-[#0b2c48]">Project Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 transition 
                                   focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-[#ff914d]"
                            value="{{ old('name') }}"
                        >
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block mb-2 font-medium text-[#0b2c48]">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 transition 
                                   focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-[#ff914d]"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="start_date" class="block mb-2 font-medium text-[#0b2c48]">Start Date</label>
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 transition 
                                   focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-[#ff914d]"
                            value="{{ old('start_date') }}"
                        >
                        @error('start_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="end_date" class="block mb-2 font-medium text-[#0b2c48]">End Date</label>
                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 transition 
                                   focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-[#ff914d]"
                            value="{{ old('end_date') }}"
                        >
                        @error('end_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="status" class="block mb-2 font-medium text-[#0b2c48]">Status</label>
                        <select
                            name="status"
                            id="status"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 transition 
                                   focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-[#ff914d]"
                        >
                            <option value="not_started" {{ old('status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-right">
                        <button
                            type="submit"
                            class="bg-[#ff914d] hover:bg-[#e57732] text-white font-medium rounded-full px-6 py-2 transition"
                        >
                            Create Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
