@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-xl">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Edit Task</h2>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block mb-2 font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" required
                value="{{ $task->title }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent" />
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block mb-2 font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent">{{ $task->description }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="due_date" class="block mb-2 font-medium text-gray-700">Due Date</label>
            <input type="date" name="due_date" id="due_date"
                value="{{ $task->due_date }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent" />
            @error('due_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="priority" class="block mb-2 font-medium text-gray-700">Priority</label>
            <select name="priority" id="priority" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent">
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
            @error('priority')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400">
            Update Task
        </button>
    </form>
</div>
@endsection
