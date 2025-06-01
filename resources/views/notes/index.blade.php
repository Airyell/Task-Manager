@extends('layouts.app')

@section('title')
    Notes
@endsection

@section('content')
<div class="bg-[#fdf1e5] min-h-screen py-10 px-4 font-sans">
    <div class="flex flex-col md:flex-row md:justify-between items-center bg-white text-[#0b2c48] font-bold text-xl py-5 px-6 rounded-2xl shadow-md max-w-7xl mx-auto mb-8">
        <h2>Notes</h2>
        <a href="{{ route('notes.create') }}"
           class="mt-4 md:mt-0 inline-block bg-[#ff914d] hover:bg-[#e57732] text-white font-medium px-6 py-2 rounded-md transition duration-200">
            Add Note
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-6 py-4 rounded-xl shadow-md max-w-7xl mx-auto mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
        @forelse($notes as $note)
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col h-full">
                <h5 class="text-[#0b2c48] font-bold text-lg mb-2">{{ $note->title }}</h5>
                <p class="text-gray-700 flex-grow mb-3">{{ Str::limit($note->content, 150) }}</p>
                <p class="text-gray-600 mb-4"><strong>Date:</strong> {{ $note->date }}</p>
                <div class="flex justify-between">
                    <a href="{{ route('notes.edit', $note->id) }}"
                       class="bg-[#ffd07b] hover:bg-[#ffc107] text-[#0b2c48] font-medium px-4 py-2 rounded-md transition duration-200">
                        Edit
                    </a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this note?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-400 hover:bg-red-500 text-white font-medium px-4 py-2 rounded-md transition duration-200">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center text-gray-500">
                No notes found.
            </div>
        @endforelse
    </div>
</div>
@endsection
