<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class HistoryController extends Controller
{
    // Show user activity history
    public function index()
    {
        $user = Auth::user();

        // Fetch all activity logs of the authenticated user
        $activities = ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('history.index', compact('activities'));
    }

    // Delete a specific activity
    public function destroy($id)
    {
        $activity = ActivityLog::findOrFail($id);

        // Ensure user owns the activity
        if ($activity->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $activity->delete();

        return redirect()->back()->with('success', 'Activity deleted successfully.');
    }
}
