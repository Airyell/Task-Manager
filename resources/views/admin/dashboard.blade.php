@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Total Users</p>
                <h2 class="text-2xl font-bold text-orange-500">{{ $userCount }}</h2>
            </div>
            <svg class="circular-chart w-16 h-16" viewBox="0 0 36 36">
                <path class="circle-bg" fill="none" stroke="#eee" stroke-width="3.8"
                      d="M18 2.0845
                         a 15.9155 15.9155 0 0 1 0 31.831
                         a 15.9155 15.9155 0 0 1 0 -31.831"/>
                <path class="circle" fill="none" stroke="#f97316" stroke-width="3.8"
                      stroke-dasharray="{{ round($userPercentage) }}, 100"
                      d="M18 2.0845
                         a 15.9155 15.9155 0 0 1 0 31.831
                         a 15.9155 15.9155 0 0 1 0 -31.831"/>
                <text x="18" y="20.35" class="fill-orange-500 text-xs" text-anchor="middle">
                    {{ round($userPercentage) }}%
                </text>
            </svg>
        </div>

        <!-- Total Tasks -->
        <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Total Tasks</p>
                <h2 class="text-2xl font-bold text-blue-600">{{ $taskCount }}</h2>
            </div>
            <svg class="circular-chart w-16 h-16" viewBox="0 0 36 36">
                <path class="circle-bg" fill="none" stroke="#eee" stroke-width="3.8"
                      d="M18 2.0845
                         a 15.9155 15.9155 0 0 1 0 31.831
                         a 15.9155 15.9155 0 0 1 0 -31.831"/>
                <path class="circle" fill="none" stroke="#2563eb" stroke-width="3.8"
                      stroke-dasharray="{{ round($taskPercentage) }}, 100"
                      d="M18 2.0845
                         a 15.9155 15.9155 0 0 1 0 31.831
                         a 15.9155 15.9155 0 0 1 0 -31.831"/>
                <text x="18" y="20.35" class="fill-blue-600 text-xs" text-anchor="middle">
                    {{ round($taskPercentage) }}%
                </text>
            </svg>
        </div>

        <!-- Total Projects -->
        <div class="bg-white p-4 rounded-xl shadow flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Total Projects</p>
                <h2 class="text-2xl font-bold text-green-600">{{ $projectCount }}</h2>
            </div>
            <svg class="circular-chart w-16 h-16" viewBox="0 0 36 36">
                <path class="circle-bg" fill="none" stroke="#eee" stroke-width="3.8"
                      d="M18 2.0845
                         a 15.9155 15.9155 0 0 1 0 31.831
                         a 15.9155 15.9155 0 0 1 0 -31.831"/>
                <path class="circle" fill="none" stroke="#16a34a" stroke-width="3.8"
                      stroke-dasharray="{{ round($projectPercentage) }}, 100"
                      d="M18 2.0845
                         a 15.9155 15.9155 0 0 1 0 31.831
                         a 15.9155 15.9155 0 0 1 0 -31.831"/>
                <text x="18" y="20.35" class="fill-green-600 text-xs" text-anchor="middle">
                    {{ round($projectPercentage) }}%
                </text>
            </svg>
        </div>
    </div>

    <!-- Recent Tasks Table -->
    <div class="bg-white p-4 shadow rounded-xl">
        <h2 class="text-xl font-semibold mb-4">Recent Tasks</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border">Task Title</th>
                        <th class="p-3 border">Assigned User</th>
                        <th class="p-3 border">Priority</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks->take(5) as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">{{ $task->title }}</td>
                            <td class="p-3 border">{{ $task->user->name ?? 'Unassigned' }}</td>
                            <td class="p-3 border capitalize">{{ $task->priority }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
