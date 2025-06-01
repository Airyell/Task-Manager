<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChecklistItemController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// ---------------------------
// Authentication Routes
// ---------------------------
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// ---------------------------
// General Authenticated Routes
// ---------------------------
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        $user = Auth::user();

        $tasksCount = $user->tasks()->where('status', '!=', 'completed')->count();
        $completedTasksCount = $user->tasks()->where('status', 'completed')->count();
        $notesCount = $user->notes()->count();
        $recentTasks = $user->tasks()->latest()->take(5)->get();
        $recentNotes = $user->notes()->latest()->take(5)->get();

        return view('dashboard', compact(
            'tasksCount',
            'completedTasksCount',
            'notesCount',
            'recentTasks',
            'recentNotes'
        ));
    })->name('dashboard');

    // Mail
    Route::controller(MailController::class)->prefix('mail')->name('mail.')->group(function () {
        Route::get('/', 'index')->name('inbox');
    });

    // Projects & Tasks
    Route::resource('projects', ProjectController::class);
    Route::post('project/team', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::get('projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::get('projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
    Route::delete('projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');

    // Tasks
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus']);
    Route::post('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Checklist Items
    Route::resource('checklist-items', ChecklistItemController::class);
    Route::get('checklist-items/{checklistItem}/update-status', [ChecklistItemController::class, 'updateStatus'])->name('checklist-items.update-status');

    // Notes
    Route::resource('notes', NoteController::class);

    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/show', [ProfileController::class, 'show'])->name('profile.show');
});

// ---------------------------
// Admin Routes using IsAdmin middleware
// ---------------------------
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Add .index to route names for list pages (fixes route not defined errors)
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects.index');
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks.index');

    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    Route::get('/tasks/{task}/edit', [AdminController::class, 'editTask'])->name('tasks.edit');
    Route::put('/tasks/{task}', [AdminController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminController::class, 'destroyTask'])->name('tasks.destroy');
});
