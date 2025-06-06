<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()->withCount([
            'tasks as to_do_tasks' => function ($query) {
                $query->where('status', 'to_do');
            },
            'tasks as in_progress_tasks' => function ($query) {
                $query->where('status', 'in_progress');
            },
            'tasks as completed_tasks' => function ($query) {
                $query->where('status', 'completed');
            }
        ])->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:not_started,in_progress,completed',
            'budget' => 'nullable|numeric',
        ]);

        $data = $request->except(['_token']);

        if (!empty($data['start_date'])) {
            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
        }

        if (!empty($data['end_date'])) {
            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        }

        $project = Auth::user()->projects()->create($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Created Project',
            'description' => 'Created project "' . $project->name . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $teamMembers = $project->users()->get();
        $users = User::all();

        return view('projects.show', compact('project', 'teamMembers', 'users'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'status' => 'required|in:not_started,in_progress,completed',
            'budget' => 'nullable|numeric',
        ]);

        $data = $request->except(['_token']);

        if (!empty($data['start_date'])) {
            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
        }

        if (!empty($data['end_date'])) {
            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
        }

        $project->update($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Updated',
            'description' => 'Updated project "' . $project->name . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $projectName = $project->name;
        $project->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Project Deleted',
            'description' => 'Deleted project "' . $projectName . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    public function addMember(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $project = Project::find($request->project_id);
        $user = User::find($request->user_id);

        $project->teamProjects()->attach($request->user_id);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Add Member to Project',
            'description' => 'Added member "' . $user->name . '" to project "' . $project->name . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->back()->with('success', 'User added successfully.');
    }
}
