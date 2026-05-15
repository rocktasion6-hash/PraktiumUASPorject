<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
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
    
    // Monitoring Global (Daftar semua tugas)
    Route::get('/monitoring', [TaskController::class, 'index'])->name('tasks.index');

    // Detail Tugas
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    // Simpan Komentar Admin (Feedback)
    Route::post('/tasks/{task}/comments', [TaskController::class, 'storeComment'])->name('tasks.comments');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// --- AREA LOGIN USER ---
Route::middleware('auth')->group(function () {
    // CRUD Tugas User (index, create, store, edit, update, destroy)
    Route::resource('tasks', TaskController::class);

    // Profile Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fitur AI
    Route::post('/tasks/{task}/analyze', [TaskController::class, 'analyze'])->name('tasks.analyze');
});

require __DIR__.'/auth.php';