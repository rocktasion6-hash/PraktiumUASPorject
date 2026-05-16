@php use Illuminate\Support\Str; @endphp
<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <div class="max-w-4xl mx-auto p-6 min-h-screen bg-white">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-5 border-b border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540] tracking-tight">Detail Tugas</h1>
                <p class="text-sm text-gray-400 mt-1">Informasi lengkap tugas dan analisis asisten AI.</p>
            </div>
            <div>
                <a href="{{ route('tasks.index') }}" class="p-3 inline-flex items-center text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition shadow-sm" title="Kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
            </div>
        </div>

        <div class="border border-gray-100 rounded-2xl shadow-sm overflow-hidden bg-white mb-8">
            <div class="bg-[#0A2540] px-6 py-4"><h2 class="text-sm font-bold text-white uppercase tracking-widest">Informasi Utama</h2></div>
            <div class="divide-y divide-gray-50 text-sm">
                <div class="grid grid-cols-1 md:grid-cols-3 p-4 pl-6 items-center"><span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Judul Tugas</span><span class="md:col-span-2 text-base font-extrabold text-[#0A2540]">{{ $task->title }}</span></div>
                <div class="grid grid-cols-1 md:grid-cols-3 p-4 pl-6 items-center"><span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Kategori</span><span class="md:col-span-2 text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full border w-fit">{{ $task->category->name }}</span></div>
                <div class="grid grid-cols-1 md:grid-cols-3 p-4 pl-6 items-center"><span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Status</span><span class="md:col-span-2 text-xs font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full border w-fit">{{ $task->status->name }}</span></div>
                <div class="grid grid-cols-1 md:grid-cols-3 p-4 pl-6 items-center"><span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Prioritas</span><span class="md:col-span-2 text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $task->priority }}</span></div>
                <div class="grid grid-cols-1 md:grid-cols-3 p-4 pl-6 items-center"><span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Deadline</span><span class="md:col-span-2 text-gray-600 font-semibold italic">{{ $task->deadline }}</span></div>
                <div class="grid grid-cols-1 md:grid-cols-3 p-4 pl-6 items-center"><span class="font-bold text-gray-400 uppercase tracking-wider text-[11px]">Dibuat Oleh</span><span class="md:col-span-2 text-slate-700 font-bold">{{ $task->user->name }}</span></div>
            </div>
        </div>

        <div class="mb-8 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-extrabold text-[#0A2540] mb-4">Deskripsi</h2>
            <div class="text-sm text-gray-600 font-medium leading-relaxed bg-gray-50 p-4 rounded-xl border whitespace-pre-line">{{ $task->description }}</div>
        </div>

        <div class="mb-8 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-extrabold text-[#0A2540] mb-4">Komentar</h2>
            <div class="space-y-4">
                @forelse($task->comments as $comment)
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                        <div class="flex justify-between items-center border-b pb-2"><p class="font-bold text-sm text-[#0A2540]">{{ $comment->user->name }}</p><p class="text-[11px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</p></div>
                        <p class="mt-2 text-sm text-gray-600">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <div class="text-center py-6 text-sm text-gray-400 italic">Belum ada komentar untuk tugas ini.</div>
                @endif
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h2 class="text-xl font-extrabold text-[#0A2540]">Rekomendasi AI</h2>
                <form action="{{ route('tasks.analyze', $task->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#FF6B00] hover:bg-[#e05e00] text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm active:scale-95 inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Analisis dengan AI
                    </button>
                </form>
            </div>
            <div class="space-y-4">
                @forelse($task->recommendations as $ai)
                    <div class="bg-orange-50/40 border border-orange-100 p-6 rounded-xl">{!! Str::markdown($ai->recommendation) !!}</div>
                @empty
                    <div class="text-center py-6 text-sm text-gray-400 italic bg-gray-50 border rounded-xl">Belum ada analisis. Silakan tekan tombol di atas.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>