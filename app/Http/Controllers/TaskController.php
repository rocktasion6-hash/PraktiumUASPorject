<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use App\Models\AiRecommendation;
use App\Ai\Agents\TaskAgent;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas.
     * Admin melihat halaman Monitoring dengan variabel $allTasks.
     * User melihat daftar tugas miliknya sendiri dengan variabel $tasks.
     */
    public function index()
    {
        // Cek jika user yang login adalah Admin
        if (Auth::user()->is_admin) {
            // Mengambil semua tugas untuk halaman Monitoring
            // Nama variabel disamakan dengan file Blade: $allTasks
            $allTasks = Task::with(['category', 'status', 'user'])
                ->latest()
                ->get(); 

            // Mengarah ke resources/views/admin/index.blade.php
            return view('admin.index', compact('allTasks'));
        }

        // Jika User Biasa
        $tasks = Task::with(['category', 'status'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Form tambah tugas (Hanya untuk User)
     */
    public function create()
    {
        $categories = Category::all();
        $statuses = TaskStatus::all();

        return view('tasks.create', compact('categories', 'statuses'));
    }

    /**
     * Simpan tugas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
            'priority' => 'required',
            'deadline' => 'required|date',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status_id' => $request->status_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil ditambahkan');
    }

    /**
     * Tampilkan Detail Tugas
     */
    public function show(Task $task)
    {
        $task->load([
            'category',
            'status',
            'user',
            'comments.user',
            'recommendations'
        ]);

        // Jika Admin yang melihat detail, gunakan view khusus feedback
        if (Auth::user()->is_admin) {
            return view('admin.show', compact('task'));
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Form edit tugas
     */
    public function edit(Task $task)
    {
        // Pastikan user hanya bisa edit tugas miliknya sendiri
        if ($task->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        $categories = Category::all();
        $statuses = TaskStatus::all();

        return view('tasks.edit', compact('task', 'categories', 'statuses'));
    }

    /**
     * Update tugas
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
            'priority' => 'required',
            'deadline' => 'required',
        ]);

        $task->update($request->all());

        // Redirect kembali ke halaman yang sesuai dengan role
        $redirectRoute = Auth::user()->is_admin ? 'admin.index' : 'tasks.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Tugas berhasil diupdate');
    }

    /**
     * Hapus tugas
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Tugas berhasil dihapus');
    }

    /**
     * Simpan Komentar dari Admin (Feedback)
     */
    public function storeComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $task->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Komentar/Feedback berhasil dikirim.');
    }

    /**
     * Analisis Tugas menggunakan AI
     */
    public function analyze(string $id)
    {
        $task = Task::findOrFail($id);
        try {
            $response = TaskAgent::make()->prompt(
                "Judul: {$task->title}
                 Deskripsi: {$task->description}
                 Deadline: {$task->deadline}
                 Prioritas: {$task->priority}"
            );

            AiRecommendation::create([
                'task_id' => $task->id,
                'recommendation' => $response,
                'generated_at' => now(),
            ]);

            return back()->with('success', 'Rekomendasi AI berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'AI Error: ' . $e->getMessage());
        }
    }
}