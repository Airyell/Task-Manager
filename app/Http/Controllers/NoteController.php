<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\ActivityLog; // ✅ Add this
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Auth::user()->notes()->latest()->get();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        $note = Auth::user()->notes()->create($request->all());

        // ✅ Log create note activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Created Note',
            'description' => 'Created note "' . $note->title . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note created successfully.');
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        $note->update($request->all());

        // ✅ Log update note activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Updated Note',
            'description' => 'Updated note "' . $note->title . '" on ' . now()->format('F j, Y'),
        ]);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        // ✅ Log delete note activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted Note',
            'description' => 'Deleted note "' . $note->title . '" on ' . now()->format('F j, Y'),
        ]);

        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
