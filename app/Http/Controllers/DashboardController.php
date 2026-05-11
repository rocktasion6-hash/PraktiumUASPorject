<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalTasks = Task::where('user_id', $userId)->count();

        $completedTasks = Task::where('user_id', $userId)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Selesai');
            })
            ->count();

        $pendingTasks = Task::where('user_id', $userId)
            ->whereHas('status', function ($query) {
                $query->where('name', 'Belum Dikerjakan');
            })
            ->count();

        $latestTasks = Task::with(['category', 'status'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $nearestDeadline = Task::where('user_id', $userId)
            ->orderBy('deadline', 'asc')
            ->first();

        return view('dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'latestTasks',
            'nearestDeadline'
        ));
    }
}