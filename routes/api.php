<?php

Route::get('/dashboard', function () {
    return response()->json([
        'tasksCount' => \App\Models\Task::where('status', '!=', 'completed')->count(),
        'notesCount' => \App\Models\Note::count(),
        'completedTasksCount' => \App\Models\Task::where('status', 'completed')->count(),
        'recentTasks' => \App\Models\Task::latest()->take(5)->get(),
        'recentNotes' => \App\Models\Note::latest()->take(5)->get(),
    ]);
});
