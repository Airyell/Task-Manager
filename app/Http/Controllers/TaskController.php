<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->get()->groupBy('status');
        $users = $project->users()->get();
        return view('tasks.index', compact('project', 'tasks', 'users'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = $project->tasks()->create($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATED THE TASK: ' . $task->title,
            'model_name' => $task->title,
            'created_at' => now(),
        ]);

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,completed',
        ]);

        $task->update($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATED THE TASK: ' . $task->title,
            'model_name' => $task->title,
            'created_at' => now(),
        ]);

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $newStatus = $request->input('status');
        $task->status = $newStatus;
        $task->save();

        // Define specific action messages based on status
        $statusActions = [
            'to_do' => 'MOVED TASK TO TO DO',
            'in_progress' => 'STARTED WORKING ON',
            'completed' => 'COMPLETED THE TASK',
        ];

        $action = isset($statusActions[$newStatus]) ? $statusActions[$newStatus] . ': ' . $task->title : 'UPDATED TASK STATUS: ' . $task->title;

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_name' => $task->title,
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Task status updated and logged.']);
    }

    public function destroy(Project $project, Task $task)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETED THE TASK: ' . $task->title,
            'model_name' => $task->title,
            'created_at' => now(),
        ]);

        $task->delete();

        return redirect()->route('projects.tasks.index', $project->id)->with('success', 'Task deleted successfully.');
    }
}
