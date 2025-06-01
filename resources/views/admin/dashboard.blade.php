@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>

        {{-- Users Section --}}
        <section class="mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Users</h2>
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">{{ $user->role }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Tasks Section --}}
        <section class="mb-10">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Tasks</h2>
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned User ID</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($tasks as $task)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->user_id }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Projects Section --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Projects</h2>
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Name</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($projects as $project)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $project->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
