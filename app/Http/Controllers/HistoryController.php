<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class HistoryController extends Controller
{
    // Display activity history
    public function index()
    {
        $user = Auth::user();

        $activities = ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('history.index', compact('activities'));
    }

    // Delete a specific log
    public function destroy($id)
    {
        $activity = ActivityLog::findOrFail($id);

        if ($activity->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $activity->delete();

        return redirect()->back()->with('success', 'Activity deleted successfully.');
    }

    // Helper function to store activity
    public static function logActivity($action, $modelName = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_name' => $modelName ?? 'General',
        ]);
    }
}
