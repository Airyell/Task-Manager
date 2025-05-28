<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChecklistItemController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController; // Already present
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Mail Routes
    Route::controller(MailController::class)->prefix('mail')->name('mail.')->group(function () {
        Route::get('/', 'index')->name('inbox');
    });

    // Project Routes
    Route::resource('projects', ProjectController::class);
    Route::post('project/team', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::get('projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::get('projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
    Route::delete('projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');

    // History Routes
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

    // Profile Routes - These were already well-defined!
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ✅ ADDED: Route for displaying the profile edit form
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // ✅ ADDED: Route for your showblackchips method
    Route::get('/showblackchips', [ProfileController::class, 'showblackchips'])->name('profile.showblackchips');


    // Task Routes
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus']);
    Route::post('/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Routine Routes
    Route::resource('routines', RoutineController::class)->except(['show']);
    Route::get('routines/showAll', [RoutineController::class, 'showAll'])->name('routines.showAll');
    Route::get('routines/daily', [RoutineController::class, 'showDaily'])->name('routines.showDaily');
    Route::get('routines/weekly', [RoutineController::class, 'showWeekly'])->name('routines.showWeekly');
    Route::get('routines/monthly', [RoutineController::class, 'showMonthly'])->name('routines.showMonthly');

    // Other Resource Routes
    Route::resource('files', FileController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('reminders', ReminderController::class);
    Route::resource('checklist-items', ChecklistItemController::class);
    Route::get('checklist-items/{checklistItem}/update-status', [ChecklistItemController::class, 'updateStatus'])->name('checklist-items.update-status');

    // Dashboard Route (Home Page)
    Route::get('/', function () {
        $user = Auth::user();
        $tasksCount = $user->tasks()->where('status', '!=', 'completed')->count();
    $completedTasksCount = $user->tasks()->where('status', 'completed')->count(); // ✅ Added line
        $routinesCount = $user->routines()->count();
        $notesCount = $user->notes()->count();
        $remindersCount = $user->reminders()->count();
        $filesCount = $user->files()->count();
        $recentTasks = $user->tasks()->latest()->take(5)->get();
        $todayRoutines = $user->routines()->whereDate('start_time', now())->get();
        $recentNotes = $user->notes()->latest()->take(5)->get();
        $upcomingReminders = $user->reminders()->where('date', '>=', now())->orderBy('date')->take(5)->get();

        return view('dashboard', compact(
            'tasksCount',
            'completedTasksCount',
            'routinesCount',
            'notesCount',
            'remindersCount',
            'filesCount',
            'recentTasks',
            'todayRoutines',
            'recentNotes',
            'upcomingReminders'
        ));
    })->name('dashboard');
});

// Registration Routes
use App\Http\Controllers\Auth\RegisterController; // Already present

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
