@extends('layouts.app')

@section('title')
    {{ $project->name }} - Project Details
@endsection

@section('content')
<div class="bg-[#fdf1e5] font-sans min-h-screen py-12 px-4 md:px-8">
    <h2 class="bg-white text-[#0b2c48] font-bold text-2xl md:text-3xl text-center rounded-xl shadow-md py-5 mb-8">
        {{ $project->name }}
    </h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-5 py-3 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="md:flex md:space-x-6">
        <!-- Project Details -->
        <div class="md:w-7/12 mb-8 md:mb-0">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h5 class="text-xl font-semibold text-[#0b2c48] mb-3">{{ $project->name }}</h5>
                <p class="text-gray-700 mb-3">{{ $project->description }}</p>

                <p class="mb-1"><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') }}</p>
                <p class="mb-1"><strong>End Date:</strong> {{ \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') }}</p>
                <p class="mb-1">
                    <strong>Status:</strong> 
                    {{ $project->status == 'pending' ? 'Pending' : ($project->status == 'on_going' ? 'In Progress' : 'Completed') }}
                </p>
                <p class="mb-4"><strong>Budget:</strong> ${{ $project->budget }}</p>

                @php
                    $totalTasks = $project->tasks->count();
                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                    $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                @endphp

                <h5 class="text-lg font-semibold mb-3">Project Progress</h5>
                <div class="w-full bg-gray-300 rounded-full h-5 mb-6 overflow-hidden">
                    <div class="bg-[#ff914d] text-white font-bold text-sm h-5 flex items-center justify-center transition-all duration-300"
                         style="width: {{ $progress }}%;">
                        {{ round($progress) }}%
                    </div>
                </div>

                <a href="{{ route('projects.index') }}" 
                   class="inline-block bg-gray-200 text-gray-700 rounded-md px-4 py-2 hover:bg-gray-300 transition">
                   ← Back to Projects
                </a>
            </div>
        </div>

        <!-- Team Members -->
        <div class="md:w-5/12">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-xl font-semibold text-[#0b2c48] m-0">Team Members</h5>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addMemberModal"
                            class="bg-[#ff914d] hover:bg-[#e57732] text-white rounded-md p-2 transition" title="Add Team Member">
                        <i class="bi bi-plus-circle"></i>
                    </button>
                </div>

                @forelse ($teamMembers as $user)
                    <div class="bg-white shadow-sm rounded-lg p-4 mb-3">
                        <p class="font-semibold text-gray-900 mb-0">{{ $user->name }}</p>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    </div>
                @empty
                    <p class="text-gray-400 italic">No team members assigned.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-xl">
            <form action="{{ route('projects.addMember') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="modal-header flex justify-between items-center mb-4">
                    <h5 class="modal-title text-xl font-semibold" id="addMemberModalLabel">Add Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-4">
                    <label for="user_id" class="block mb-2 font-medium">Select User</label>
                    <select id="user_id" name="user_id" required class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff914d]">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer flex justify-end space-x-3">
                    <button type="button" class="bg-gray-300 text-gray-700 rounded-md px-4 py-2 hover:bg-gray-400 transition" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="bg-[#ff914d] hover:bg-[#e57732] text-white rounded-md px-4 py-2 transition">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
