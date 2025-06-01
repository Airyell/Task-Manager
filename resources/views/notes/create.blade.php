@extends('layouts.app')

@section('title')
    Add Note
@endsection

@section('content')
<div class="py-10 px-4">
    <h2 class="text-2xl lg:text-3xl font-bold text-[#0b2c48] bg-white text-center py-5 rounded-2xl shadow-md max-w-xl mx-auto mb-8">
        Add Note
    </h2>

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-xl mx-auto">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-[#0b2c48] font-medium mb-2">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-transparent"
                    required
                >
                @error('title')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-[#0b2c48] font-medium mb-2">Content</label>
                <textarea
                    name="content"
                    id="content"
                    rows="5"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-transparent"
                    required
                ></textarea>
                @error('content')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="date" class="block text-[#0b2c48] font-medium mb-2">Date</label>
                <input
                    type="date"
                    name="date"
                    id="date"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff914d] focus:border-transparent"
                >
                @error('date')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-[#ff914d] hover:bg-[#e57732] text-white font-semibold py-2 px-4 rounded-md transition duration-200"
            >
                Add Note
            </button>
        </form>
    </div>
</div>
@endsection
