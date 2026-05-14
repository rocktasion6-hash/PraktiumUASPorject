<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna untuk Admin.
     */
    public function index()
{
    $users = User::latest()->paginate(10);

    // Diubah dari admin.users.index menjadi admin.index
    return view('admin.index', compact('users'));
}

public function show(User $user)
{
    $user->load(['tasks.status', 'tasks.category']);
    
    // Diubah dari admin.users.show menjadi admin.show
    return view('admin.show', compact('user'));
}
}