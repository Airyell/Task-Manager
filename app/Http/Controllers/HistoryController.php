<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog; // Make sure this model exists

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all activity logs of the authenticated user
        $activities = ActivityLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('history.index', compact('activities'));
    }
}
