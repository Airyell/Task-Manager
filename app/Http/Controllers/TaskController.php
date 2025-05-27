<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;  // Import ActivityLog
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

        // ✅ Log create task activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Task',
            'description' => 'Created task "' . $task->title . '" on ' . now()->format('F j, Y'),
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

        // ✅ Log update task activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Task',
            'description' => 'Updated task "' . $task->title . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->status = $request->input('status');
        $task->save();

        // Optional: log status update
        /*
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Task Status',
            'description' => 'Updated status of task "' . $task->title . '" to ' . $task->status . ' on ' . now()->format('F j, Y'),
        ]);
        */

        return response()->json(['message' => 'Task status updated successfully.']);
    }

    public function destroy(Project $project, Task $task)
    {
        // ✅ Log delete task activity before deletion
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Task',
            'description' => 'Deleted task "' . $task->title . '" on ' . now()->format('F j, Y'),
        ]);

        $task->delete();

        return redirect()->route('projects.tasks.index', $project->id)->with('success', 'Task deleted successfully.');
    }
}
