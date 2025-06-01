@extends('layouts.admin')

@section('title', 'Project Records')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Project Records</h1>
            <nav class="text-sm text-gray-500 mt-1">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline text-blue-600">Dashboard</a></li>
                    <li>/</li>
                    <li class="text-gray-600">Projects</li>
                </ol>
            </nav>
        </div>
        <div>
            <select id="statusFilter" class="w-52 rounded-full border border-gray-300 shadow-sm px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Statuses</option>
                <option value="not_started">Not Started</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 shadow">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-md bg-red-100 text-red-800 shadow">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-medium text-blue-600 flex items-center gap-2">
                <i class="fas fa-project-diagram"></i>
                Project List
            </h2>
            <span class="inline-flex items-center text-sm bg-blue-600 text-white rounded-full px-3 py-1">
                <i class="fas fa-clipboard-list mr-1"></i>
                Total Projects: {{ $projects->count() }}
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700" id="projectsTable">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="py-3">Project Details</th>
                        <th class="py-3">Created By</th>
                        <th class="py-3">Team Members</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Timeline</th>
                        <th class="py-3 text-right px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($projects as $project)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-800">#{{ $project->id }}</td>
                        <td class="py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">{{ $project->name }}</span>
                                <span class="text-gray-500 text-xs">{{ Str::limit($project->description, 50) }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full font-bold text-sm">
                                    {{ strtoupper(substr($project->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $project->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $project->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($project->users->take(3) as $member)
                                    <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $member->name }}</span>
                                @endforeach
                                @if($project->users->count() > 3)
                                    <span class="bg-gray-200 text-gray-700 text-xs font-medium px-2.5 py-0.5 rounded-full">+{{ $project->users->count() - 3 }} more</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4">
                            @php
                                $statusClasses = [
                                    'not_started' => 'bg-gray-200 text-gray-700',
                                    'in_progress' => 'bg-blue-100 text-blue-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                ];
                                $statusClass = $statusClasses[$project->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="text-xs font-medium px-3 py-1 rounded-full {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </td>
                        <td class="py-4 text-xs text-gray-500">
                            <div>
                                <i class="far fa-calendar-alt mr-1"></i>
                                Start: {{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not set' }}
                            </div>
                            <div>
                                <i class="far fa-calendar-check mr-1"></i>
                                End: {{ $project->end_date ? $project->end_date->format('M d, Y') : 'Not set' }}
                            </div>
                        </td>
                        <td class="py-4 text-right px-6">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="inline-flex items-center gap-1 border border-blue-500 text-blue-500 px-3 py-1 rounded-full text-sm hover:bg-blue-50">
                                    <i class="fas fa-edit"></i>Edit
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 border border-red-500 text-red-500 px-3 py-1 rounded-full text-sm hover:bg-red-50">
                                        <i class="fas fa-trash-alt"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">
                            <i class="fas fa-folder-open text-3xl mb-2"></i>
                            <p>No projects found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('#projectsTable tbody tr');

        filter.addEventListener('change', () => {
            const value = filter.value.toLowerCase();

            rows.forEach(row => {
                const status = row.querySelector('td:nth-child(5) span')?.textContent.toLowerCase() || '';
                row.style.display = !value || status.includes(value) ? '' : 'none';
            });
        });
    });
</script>
@endpush
