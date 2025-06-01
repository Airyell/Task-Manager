<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        // Group tasks by status for the project
        $tasks = $project->tasks()->get()->groupBy('status');
        $users = $project->users()->get();

        return view('tasks.index', compact('project', 'tasks', 'users'));
    }

    public function create(Project $project)
    {
        $users = $project->users;

        return view('tasks.create', compact('project', 'users'));
    }

    public function store(Request $request, Project $project)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'priority' => 'required|in:low,medium,high',
            ]);

            $task = $project->tasks()->create($validated);

            // Get the user name for the response
            $userName = User::find($validated['user_id'])->name;

            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'CREATED THE TASK: ' . $task->title,
                'model_name' => $task->title,
                'created_at' => now(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Task created successfully',
                    'task' => array_merge($task->toArray(), [
                        'user_name' => $userName,
                        'project_id' => $project->id
                    ])
                ]);
            }

            return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the task'
                ], 500);
            }
            throw $e;
        }
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Project $project, Task $task)
    {
        $users = $project->users;

        return view('tasks.edit', compact('project', 'task', 'users'));
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,completed',
        ]);

        $task->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATED THE TASK: ' . $task->title,
            'model_name' => 'Task',
            'model_id' => $task->id,
            'created_at' => now(),
        ]);

        return redirect()->route('projects.tasks.index', $project)
            ->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:to_do,in_progress,completed',
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $task->status;

        if ($oldStatus === $newStatus) {
            return response()->json(['message' => 'Status is already set to this value.'], 200);
        }

        $task->status = $newStatus;
        $task->save();

        $statusActions = [
            'to_do' => 'MOVED TASK TO TO DO',
            'in_progress' => 'STARTED WORKING ON',
            'completed' => 'COMPLETED THE TASK',
        ];

        $action = $statusActions[$newStatus] ?? 'UPDATED TASK STATUS';
        $action .= ': ' . $task->title;

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_name' => 'Task',
            'model_id' => $task->id,
            'created_at' => now(),
        ]);

        return response()->json(['message' => 'Task status updated and logged.']);
    }

    public function destroy(Project $project, Task $task)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETED THE TASK: ' . $task->title,
            'model_name' => 'Task',
            'model_id' => $task->id,
            'created_at' => now(),
        ]);

        $task->delete();

        return redirect()->route('projects.tasks.index', $project)
            ->with('success', 'Task deleted successfully.');
    }
}
