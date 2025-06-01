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
        $userCount = User::count();
        $projectCount = Project::count();
        $taskCount = Task::count();

        return view('admin.dashboard', compact('userCount', 'projectCount', 'taskCount'));
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

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function projects()
    {
        $projects = Project::all();
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

        return redirect()->route('admin.projects')->with('success', 'Project updated successfully.');
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects')->with('success', 'Project deleted successfully.');
    }

    public function tasks()
    {
        $tasks = Task::all();
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
            'status' => 'required',
        ]);

        $task->update($request->only(['title', 'description', 'status']));

        return redirect()->route('admin.tasks')->with('success', 'Task updated successfully.');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks')->with('success', 'Task deleted successfully.');
    }

    public function settings()
{
    // You can pass data to the view here if needed
    return view('admin.settings');
}

}
