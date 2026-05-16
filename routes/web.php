<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminStatusController;
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

    // Manajemen Kategori
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Manajemen Status
    Route::get('/statuses', [AdminStatusController::class, 'index'])->name('statuses.index');
    Route::post('/statuses', [AdminStatusController::class, 'store'])->name('statuses.store');
    Route::put('/statuses/{status}', [AdminStatusController::class, 'update'])->name('statuses.update');
    Route::delete('/statuses/{status}', [AdminStatusController::class, 'destroy'])->name('statuses.destroy');
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