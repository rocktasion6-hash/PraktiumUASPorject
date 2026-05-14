<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User; // Tambahkan ini jika ingin menghitung total user
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin'; // Cek role sekali di awal
        $today = now()->toDateString();

        // --- 1. Statistik Utama ---
        // Jika admin, hitung semua. Jika user, hitung miliknya saja.
        $totalTasks = Task::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->count();

        $completedTasks = Task::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->whereHas('status', fn($q) => $q->where('name', 'Selesai'))
            ->count();

        $pendingTasks = Task::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->whereHas('status', fn($q) => $q->where('name', 'Belum Dikerjakan'))
            ->count();

        // Tambahan statistik khusus Admin (Opsional)
        $totalUsers = $isAdmin ? User::count() : 0;

        // --- 2. Tugas Prioritas (Maksimal 7) ---
        $latestTasks = Task::with(['category', 'status', 'user']) // Eager load 'user' agar admin tahu tugas siapa
            ->when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->whereDate('deadline', '>=', $today)
            ->whereHas('status', fn($q) => $q->where('name', '!=', 'Selesai'))
            ->orderBy('deadline', 'asc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low') ASC")
            ->take(7)
            ->get();

        // --- 3. Tugas Terlewat ---
        $overdueTasks = Task::with(['category', 'status', 'user'])
            ->when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->whereDate('deadline', '<', $today)
            ->whereHas('status', fn($q) => $q->where('name', '!=', 'Selesai'))
            ->orderBy('deadline', 'desc')
            ->get();

        // --- 4. Deadline Terdekat ---
        $nearestDeadline = Task::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->whereDate('deadline', '>=', $today)
            ->whereHas('status', fn($q) => $q->where('name', '!=', 'Selesai'))
            ->orderBy('deadline', 'asc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low') ASC")
            ->first();

        // --- 5. Persiapan Data Chart (7 Hari Terakhir) ---
        $lastSevenDays = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));

        $getStatusData = function($statusName) use ($lastSevenDays, $user, $isAdmin) {
            $data = Task::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
                ->whereHas('status', fn($q) => $q->where('name', $statusName))
                ->where('updated_at', '>=', now()->subDays(6))
                ->selectRaw('DATE(updated_at) as date, count(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date');

            return $lastSevenDays->map(fn($date) => $data->get($date, 0));
        };

        $chartLabels    = $lastSevenDays->map(fn($date) => Carbon::parse($date)->translatedFormat('l'));
        $chartSelesai   = $getStatusData('Selesai');
        $chartDitunda   = $getStatusData('Ditunda');
        $chartProses    = $getStatusData('Sedang Dikerjakan');
        $chartBelum     = $getStatusData('Belum Dikerjakan');

        $view = $isAdmin ? 'dashboard-admin' : 'dashboard';

        return view($view, compact(
            'totalTasks', 
            'completedTasks', 
            'pendingTasks', 
            'overdueTasks',
            'nearestDeadline', 
            'latestTasks',
            'chartLabels',
            'chartSelesai',
            'chartDitunda',
            'chartProses',
            'chartBelum',
            'totalUsers'
        ));
    }
}