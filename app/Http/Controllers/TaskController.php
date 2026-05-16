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
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas.
     * Menggunakan role === 'admin' agar sinkron dengan dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Cek jika user yang login adalah Admin (menggunakan kolom role)
        if ($user->role === 'admin') {
            // Mengambil SEMUA tugas tanpa filter user_id agar Monitoring penuh
            $allTasks = Task::with(['category', 'status', 'user'])
                ->latest()
                ->get(); 

            return view('admin.index', compact('allTasks'));
        }

        // Jika User Biasa, hanya lihat miliknya
        $tasks = Task::with(['category', 'status'])
            ->where('user_id', $user->id)
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

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan');
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

        // Cek admin untuk menentukan view
        if (Auth::user()->role === 'admin') {
            return view('admin.show', compact('task'));
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

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

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.tasks.index' : 'tasks.index';

        return redirect()->route($redirectRoute)->with('success', 'Tugas berhasil diupdate');
    }

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

    public function analyze(string $id)
{
    $task = Task::with(['category', 'status', 'user'])->findOrFail($id);

    if ($task->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        abort(403);
    }

    try {
        $now = now();
        $deadline = Carbon::parse($task->deadline);

        if ($deadline->isPast()) {
            $statusDeadline = 'Deadline sudah terlewat / terlambat';
            $urgensiDeadline = 'Sangat mendesak';
        } elseif ($deadline->isToday()) {
            $statusDeadline = 'Deadline hari ini';
            $urgensiDeadline = 'Sangat mendesak';
        } elseif ($deadline->isTomorrow()) {
            $statusDeadline = 'Deadline besok';
            $urgensiDeadline = 'Mendesak';
        } elseif ($now->diffInDays($deadline, false) <= 3) {
            $statusDeadline = 'Deadline kurang dari atau sama dengan 3 hari';
            $urgensiDeadline = 'Cukup mendesak';
        } else {
            $statusDeadline = 'Deadline masih cukup jauh';
            $urgensiDeadline = 'Belum terlalu mendesak';
        }

        $selisihHari = $now->diffInDays($deadline, false);

        if ($selisihHari < 0) {
            $keteranganSelisih = 'Terlambat sekitar ' . abs($selisihHari) . ' hari';
        } elseif ($selisihHari == 0) {
            $keteranganSelisih = 'Deadline hari ini';
        } else {
            $keteranganSelisih = 'Tersisa sekitar ' . $selisihHari . ' hari';
        }

        $prompt = "
Analisis tugas berikut dengan akurat berdasarkan deadline.

Data tugas:
- Judul: {$task->title}
- Deskripsi: {$task->description}
- Kategori: " . ($task->category->name ?? '-') . "
- Status tugas: " . ($task->status->name ?? '-') . "
- Prioritas awal: {$task->priority}
- Tanggal sekarang: {$now->format('d-m-Y H:i')}
- Deadline tugas: {$deadline->format('d-m-Y H:i')}
- Status deadline berdasarkan sistem: {$statusDeadline}
- Keterangan selisih deadline: {$keteranganSelisih}
- Tingkat urgensi berdasarkan sistem: {$urgensiDeadline}

Aturan penting:
1. Gunakan tanggal sekarang dan deadline yang diberikan.
2. Jika status deadline sudah terlewat, jangan mengatakan deadline masih lama.
3. Jika deadline sudah lewat, nyatakan bahwa tugas terlambat.
4. Jika deadline hari ini atau besok, beri saran agar tugas segera dikerjakan.
5. Jangan menebak tanggal sendiri.
6. Berikan jawaban singkat, jelas, dan rapi.

Format jawaban:
Status deadline:
Tingkat urgensi:
Analisis:
Saran pengerjaan:
Tips produktivitas:
";

        $response = TaskAgent::make()->prompt($prompt);

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