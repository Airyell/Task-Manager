@extends('layouts.app')

@section('title')
    Projects
@endsection

@section('content')
<div class="min-h-screen bg-[#fdf1e5] font-sans py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center bg-white rounded-2xl shadow-md px-6 py-5 mb-8">
            <h2 class="text-[#0b2c48] font-extrabold text-2xl m-0">Projects</h2>
            <a href="{{ route('projects.create') }}" 
               class="bg-[#ff914d] text-white rounded-full px-5 py-2.5 hover:bg-[#e57732] transition-colors duration-200">
                + Add Project
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-5 py-3 mb-6 max-w-xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 flex flex-col h-full">
                    <div class="p-6 flex flex-col flex-grow">
                        <h5 class="text-[#0b2c48] font-semibold text-lg mb-2">{{ $project->name }}</h5>
                        <p class="text-gray-700 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                        <p class="text-gray-800 text-sm mb-6">
                            <strong>Status:</strong>
                            {{
                                $project->status === 'pending' ? 'Pending' :
                                ($project->status === 'on_going' ? 'In Progress' : 'Completed')
                            }}<br>
                            <strong>Deadline:</strong>
                            @if($project->end_date && $project->end_date->isFuture())
                                {{ $project->end_date->diffForHumans() }}
                            @else
                                <span class="text-red-600 font-semibold">Deadline Passed</span>
                            @endif
                        </p>
                        <div class="mt-auto flex space-x-2">
                            <a href="{{ route('projects.tasks.index', $project->id) }}" 
                               class="bg-[#ff914d] hover:bg-[#e57732] text-white rounded-md px-3 py-1.5 text-sm flex items-center justify-center" 
                               title="Tasks">
                                <i class="bi bi-list"></i>
                            </a>
                            <a href="{{ route('projects.show', $project->id) }}" 
                               class="bg-[#ff914d] hover:bg-[#e57732] text-white rounded-md px-3 py-1.5 text-sm flex items-center justify-center" 
                               title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('projects.edit', $project->id) }}" 
                               class="bg-yellow-400 hover:bg-yellow-500 text-white rounded-md px-3 py-1.5 text-sm flex items-center justify-center" 
                               title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this project?')" 
                                        title="Delete"
                                        class="bg-red-600 hover:bg-red-700 text-white rounded-md px-3 py-1.5 text-sm flex items-center justify-center">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 text-lg">
                    No projects found.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
