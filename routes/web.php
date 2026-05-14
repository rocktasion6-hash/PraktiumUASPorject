<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard Global (Otomatis mendeteksi Admin/User di Controller)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- GRUP ROUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/monitoring', [TaskController::class, 'index'])->name('index');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('show');

    // Gunakan nama 'admin.dashboard' agar tidak bentrok dengan dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Monitoring Global (Kelola Semua Tugas) -> admin.index
    Route::get('/', [TaskController::class, 'index'])->name('index');

    // Detail & Komentar -> admin.show / admin.tasks.comments
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('show');
    Route::post('/tasks/{task}/comments', [TaskController::class, 'storeComment'])->name('tasks.comments');
});

// --- AREA LOGIN USER ---
Route::middleware('auth')->group(function () {
    // CRUD Tugas User (index, create, store, edit, update, destroy)
    Route::resource('tasks', TaskController::class);

    // Profile & AI
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/tasks/{task}/analyze', [TaskController::class, 'analyze'])->name('tasks.analyze');
});

require __DIR__.'/auth.php';