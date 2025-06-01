@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    body {
        background-color: #fdf1e5 !important;
        font-family: 'Noto Sans', sans-serif;
    }
</style>

<div class="flex justify-center items-center p-8 min-h-screen bg-[#fdf1e5] font-sans">
    <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] p-8 w-full max-w-[1100px]">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-[#0b2c48] mb-2">Welcome to Taskaroo</h2>
            <p class="text-gray-700 text-base">Manage your tasks and notes in one organized place.</p>
        </div>

        <div class="flex flex-wrap -mx-3 mb-8">
            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col h-full hover:-translate-y-0.5 transition-transform duration-200">
                    <h5 class="text-[#0b2c48] font-semibold text-lg mb-2">Tasks</h5>
                    <p class="text-gray-700 mb-4">You have <strong>{{ $tasksCount }}</strong> tasks pending.</p>
                    <a href="{{ route('projects.index') }}" 
                       class="mt-auto inline-block bg-[#ff914d] hover:bg-[#e57732] text-white font-medium rounded-full px-5 py-2 transition-transform duration-200 transform hover:scale-105 text-center">
                       View Tasks
                    </a>
                </div>
            </div>

            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col h-full hover:-translate-y-0.5 transition-transform duration-200">
                    <h5 class="text-[#0b2c48] font-semibold text-lg mb-2">Notes</h5>
                    <p class="text-gray-700 mb-4">You have <strong>{{ $notesCount }}</strong> notes saved.</p>
                    <a href="{{ route('notes.index') }}" 
                       class="mt-auto inline-block bg-[#ff914d] hover:bg-[#e57732] text-white font-medium rounded-full px-5 py-2 transition-transform duration-200 transform hover:scale-105 text-center">
                       View Notes
                    </a>
                </div>
            </div>

            <div class="w-full md:w-1/3 px-3">
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col h-full hover:-translate-y-0.5 transition-transform duration-200">
                    <h5 class="text-[#0b2c48] font-semibold text-lg mb-2">Completed Tasks</h5>
                    <p class="text-gray-700 mb-4">You have <strong>{{ $completedTasksCount }}</strong> completed tasks.</p>
                    <a href="{{ route('projects.index') }}" 
                       class="mt-auto inline-block bg-[#ff914d] hover:bg-[#e57732] text-white font-medium rounded-full px-5 py-2 transition-transform duration-200 transform hover:scale-105 text-center">
                       View Completed
                    </a>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-8 md:mb-0">
                <div class="bg-white rounded-xl shadow-md p-6 h-full">
                    <div class="text-[#0b2c48] text-xl font-semibold mb-4">Recent Tasks</div>
                    <ul>
                        @forelse($recentTasks as $task)
                            <li class="flex justify-between items-center border-b border-gray-200 py-2 text-sm last:border-b-0">
                                <span>{{ $task->title }}</span>
                                <span 
                                    class="rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $task->status == 'to_do' ? 'bg-[#0b2c48] text-white' : '' }}
                                    {{ $task->status == 'in_progress' ? 'bg-yellow-400 text-black' : '' }}
                                    {{ $task->status == 'completed' ? 'bg-green-600 text-white' : '' }}">
                                    {{
                                        $task->status == 'to_do' ? 'To Do' :
                                        ($task->status == 'in_progress' ? 'In Progress' : 'Completed')
                                    }}
                                </span>
                            </li>
                        @empty
                            <li class="text-gray-400 italic py-2">No recent tasks available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="w-full md:w-1/2 px-3">
                <div class="bg-white rounded-xl shadow-md p-6 h-full">
                    <div class="text-[#0b2c48] text-xl font-semibold mb-4">Recent Notes</div>
                    <ul>
                        @forelse($recentNotes as $note)
                            <li class="border-b border-gray-200 py-2 text-sm last:border-b-0">{{ $note->title }}</li>
                        @empty
                            <li class="text-gray-400 italic py-2">No recent notes available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
