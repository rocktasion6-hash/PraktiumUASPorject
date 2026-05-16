<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class AdminStatusController extends Controller
{
    public function index()
    {
        return view('admin.statuses.index', ['statuses' => TaskStatus::latest()->get()]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        TaskStatus::create($request->only('name'));
        return back()->with('success', 'Status berhasil ditambahkan.');
    }

    public function update(Request $request, TaskStatus $status)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $status->update($request->only('name'));
        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(TaskStatus $status)
    {
        $status->delete();
        return back()->with('success', 'Status berhasil dihapus.');
    }
}
