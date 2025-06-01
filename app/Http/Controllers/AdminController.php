<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;      // for fetching users
use App\Models\Task;      // assuming you have a Task model
use App\Models\Project;   // assuming you have a Project model

class AdminController extends Controller
{
    // Admin dashboard page
    public function dashboard()
    {
        // Fetch all users, tasks, and projects to show in dashboard
        $users = User::all();
        $tasks = Task::all();
        $projects = Project::all();

        // Pass data to the admin dashboard view
        return view('admin.dashboard', compact('users', 'tasks', 'projects'));
    }

    // You can add CRUD methods here for users, tasks, and projects as needed
}
