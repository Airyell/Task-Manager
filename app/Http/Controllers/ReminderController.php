<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\ActivityLog; // ✅ Import ActivityLog
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Auth::user()->reminders()->latest()->get();
        return view('reminders.index', compact('reminders'));
    }

    public function create()
    {
        return view('reminders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        $reminder = Auth::user()->reminders()->create($request->all());

        // ✅ Log create reminder activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Reminder',
            'description' => 'Created reminder "' . $reminder->title . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully.');
    }

    public function edit(Reminder $reminder)
    {
        return view('reminders.edit', compact('reminder'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        $reminder->update($request->all());

        // ✅ Log update reminder activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Reminder',
            'description' => 'Updated reminder "' . $reminder->title . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('reminders.index')->with('success', 'Reminder updated successfully.');
    }

    public function destroy(Reminder $reminder)
    {
        // ✅ Log delete reminder activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Reminder',
            'description' => 'Deleted reminder "' . $reminder->title . '" on ' . now()->format('F j, Y'),
        ]);

        $reminder->delete();
        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully.');
    }
}
