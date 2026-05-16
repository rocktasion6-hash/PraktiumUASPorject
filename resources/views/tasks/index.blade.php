<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <div class="max-w-6xl mx-auto p-6 min-h-screen bg-white">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-5 border-b border-gray-100">
            <div>
                <h1 class="text-4xl font-extrabold text-[#0A2540] tracking-tight">Daftar Tugas</h1>
                <p class="text-sm text-gray-400 mt-1">Kelola produktivitas harianmu di SIMANJA.</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center bg-[#FF6B00] hover:bg-[#e05e00] text-white px-5 py-3 rounded-xl font-bold shadow-md transition-all active:scale-95 text-xs gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
                <a href="{{ route('tasks.create') }}" 
                   class="inline-flex items-center bg-[#FF6B00] hover:bg-[#e05e00] text-white px-5 py-3 rounded-xl font-bold shadow-md transition-all active:scale-95 text-xs gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Tambah Tugas
                </a>

            </div>
        </div>

        @if($tasks->count() > 0)
            <div class="border border-gray-100 rounded-2xl shadow-sm overflow-hidden bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0A2540] text-[11px] font-bold text-white uppercase tracking-widest">
                            <th class="p-4 pl-6">Judul</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Prioritas</th>
                            <th class="p-4">Deadline</th>
                            <th class="p-4 pr-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($tasks as $task)
                            <tr class="hover:bg-gray-50/50 transition-all">
                                <td class="p-4 pl-6"><span class="font-bold text-slate-800 text-sm">{{ $task->title }}</span></td>
                                <td class="p-4"><span class="text-[11px] font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $task->category->name }}</span></td>
                                <td class="p-4"><span class="text-[11px] font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full border border-orange-100/50">{{ $task->status->name }}</span></td>
                                <td class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $task->priority }}</td>
                                <td class="p-4"><span class="text-xs text-gray-500 italic font-medium">{{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y H:i') }}</span></td>
                                <td class="p-4 pr-6">
                                    <div class="flex items-center justify-center gap-4">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="text-[#FF6B00] hover:text-[#e05e00] transition" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-[#FF6B00] hover:text-[#e05e00] transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600 transition pt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white border p-12 text-center max-w-md mx-auto mt-10"><a href="{{ route('tasks.create') }}" class="inline-flex bg-[#FF6B00] text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider">Buat Tugas Pertama</a></div>
        @endif
    </div>
</x-app-layout>