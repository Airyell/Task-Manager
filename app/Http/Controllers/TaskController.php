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
            'action' => 'Created Task: ' . $task->title,
            'description' => 'Created task "' . $task->title . '" on ' . now()->format('F j, Y h:i A'),
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
            'action' => 'Updated Task: ' . $task->title,
            'description' => 'Updated task "' . $task->title . '" on ' . now()->format('F j, Y h:i A'),
        ]);

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $oldStatus = $task->status;
        $newStatus = $request->input('status');

        if ($oldStatus !== $newStatus) {
            $task->status = $newStatus;
            $task->save();

            $title = $task->title;
            $timestamp = now()->format('F j, Y h:i A');
            $action = '';
            $description = '';

            if ($newStatus === 'in_progress') {
                $action = 'Started Task: ' . $title;
                $description = 'Started working on task "' . $title . '" on ' . $timestamp;
            } elseif ($newStatus === 'completed') {
                $action = 'Completed Task: ' . $title;
                $description = 'Completed the task "' . $title . '" on ' . $timestamp;
            } else {
                $action = 'Moved Task: ' . $title;
                $description = 'Moved task "' . $title . '" to "' . $newStatus . '" on ' . $timestamp;
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
            ]);
        }

        return response()->json(['message' => 'Task status updated successfully.']);
    }

    public function destroy(Project $project, Task $task)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted Task: ' . $task->title,
            'description' => 'Deleted task "' . $task->title . '" on ' . now()->format('F j, Y h:i A'),
        ]);

        $task->delete();

        return redirect()->route('projects.tasks.index', $project->id)->with('success', 'Task deleted successfully.');
    }
}
