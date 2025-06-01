<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $activeUsers = $users->count();

        $projects = Project::all();
        $ongoingProjects = Project::where('status', 'ongoing')->count();

        $tasks = Task::all();
        $completedTasks = Task::where('status', 'completed')->count();

        $userCount = $users->count();
        $projectCount = $projects->count();
        $taskCount = $tasks->count();

        $userPercentage = $userCount > 0 ? ($activeUsers / $userCount) * 100 : 0;
        $taskPercentage = $taskCount > 0 ? ($completedTasks / $taskCount) * 100 : 0;
        $projectPercentage = $projectCount > 0 ? ($ongoingProjects / $projectCount) * 100 : 0;

        return view('admin.dashboard', compact(
            'userCount',
            'projectCount',
            'taskCount',
            'userPercentage',
            'taskPercentage',
            'projectPercentage',
            'tasks'
        ));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function projects()
    {
        $projects = Project::with(['user', 'users'])
            ->latest()
            ->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function editProject(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $project->update($request->only(['name', 'description']));

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function tasks()
    {
        $tasks = Task::with('user', 'project')->latest()->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function editTask(Task $task)
    {
        return view('admin.tasks.edit', compact('task'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required', // Or replace with status if needed
        ]);

        $task->update($request->only(['title', 'description', 'priority']));

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
