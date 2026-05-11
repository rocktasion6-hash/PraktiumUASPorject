<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AiRecommendation;
use App\Ai\Agents\TaskAgent;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['category', 'status'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $categories = Category::all();
        $statuses = TaskStatus::all();

        return view('tasks.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
            'priority' => 'required',
            'deadline' => 'required',
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

    public function edit(Task $task)
    {
        $categories = Category::all();
        $statuses = TaskStatus::all();

        return view('tasks.edit', compact('task', 'categories', 'statuses'));
    }

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

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil diupdate');
    }

    public function show(Task $task)
    {
        $task->load([
            'category',
            'status',
            'user',
            'comments.user',
            'recommendations'
        ]);

        return view('tasks.show', compact('task'));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dihapus');
    }

    public function analyze(string $id)
    {
        $task = Task::findOrFail($id);
        try {
            $response = TaskAgent::make()->prompt(
                "
                Judul: {$task->title}
                Deskripsi: {$task->description}
                Deadline: {$task->deadline}
                Prioritas: {$task->priority}
                "
                );
                AiRecommendation::create([
                    'task_id' => $task->id,
                    'recommendation' => $response,
                    'generated_at' => now(),
                    ]);
                return back()->with(
                    'success',
                    'Rekomendasi AI berhasil dibuat'
                    );
    } catch (\Exception $e) {

        return back()->with(
            'error',
            'AI Error: ' . $e->getMessage()
        );
    }
    }
}