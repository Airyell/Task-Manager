@extends('layouts.app')

@section('title')
    {{ $project->name }} – Edit Project
@endsection

@section('content')
<div class="bg-[#fdf1e5] font-sans min-h-screen pt-20 pb-16 flex justify-center">
    <div class="w-full max-w-2xl px-4">
        <div class="text-center mb-8 bg-white rounded-2xl shadow-md py-4 px-6 text-[#0b2c48] font-semibold text-2xl">
            Edit Project – {{ $project->name }}
        </div>

        <div class="bg-white rounded-3xl shadow-lg">
            <div class="p-8">
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="name" class="block font-medium text-[#0b2c48] mb-2">Project Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="w-full rounded-lg border border-gray-300 focus:border-[#ff914d] focus:ring-2 focus:ring-[#ff914d] focus:outline-none px-4 py-2"
                            value="{{ $project->name }}" 
                            required>
                        @error('name')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block font-medium text-[#0b2c48] mb-2">Description</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4" 
                            class="w-full rounded-lg border border-gray-300 focus:border-[#ff914d] focus:ring-2 focus:ring-[#ff914d] focus:outline-none px-4 py-2">{{ $project->description }}</textarea>
                        @error('description')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="start_date" class="block font-medium text-[#0b2c48] mb-2">Start Date</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            class="w-full rounded-lg border border-gray-300 focus:border-[#ff914d] focus:ring-2 focus:ring-[#ff914d] focus:outline-none px-4 py-2"
                            value="{{ \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') }}">
                        @error('start_date')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="end_date" class="block font-medium text-[#0b2c48] mb-2">End Date</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            class="w-full rounded-lg border border-gray-300 focus:border-[#ff914d] focus:ring-2 focus:ring-[#ff914d] focus:outline-none px-4 py-2"
                            value="{{ \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') }}">
                        @error('end_date')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="status" class="block font-medium text-[#0b2c48] mb-2">Status</label>
                        <select 
                            name="status" 
                            id="status" 
                            class="w-full rounded-lg border border-gray-300 focus:border-[#ff914d] focus:ring-2 focus:ring-[#ff914d] focus:outline-none px-4 py-2" 
                            required>
                            <option value="not_started" {{ $project->status == 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-right">
                        <button 
                            type="submit" 
                            class="bg-[#ff914d] hover:bg-[#e57732] text-white font-medium rounded-full px-6 py-2 transition-colors duration-200">
                            Update Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
