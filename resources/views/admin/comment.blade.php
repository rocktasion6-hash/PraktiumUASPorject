<!-- resources/views/admin/comment.blade.php -->

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header Bagian Komentar -->
    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
        <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            Instruksi & Feedback Admin
        </h3>
    </div>

    <!-- Daftar Riwayat Komentar -->
    <div class="p-6">
        <div class="space-y-4 max-h-[450px] overflow-y-auto pr-2 custom-scrollbar">
            @forelse($task->comments as $comment)
                <div class="flex gap-3 {{ $comment->user->role === 'admin' ? 'flex-row' : 'flex-row-reverse' }}">
                    <!-- Avatar Mini -->
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full flex items-center justify-center text-[10px] font-bold {{ $comment->user->role === 'admin' ? 'bg-indigo-600 text-white' : 'bg-emerald-500 text-white' }}">
                            {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                        </div>
                    </div>

                    <!-- Bubble Chat -->
                    <div class="flex-1">
                        <div class="p-3 rounded-2xl {{ $comment->user->role === 'admin' ? 'bg-indigo-50 border border-indigo-100 rounded-tl-none' : 'bg-gray-50 border border-gray-100 rounded-tr-none' }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[11px] font-extrabold {{ $comment->user->role === 'admin' ? 'text-indigo-700' : 'text-gray-700' }}">
                                    {{ $comment->user->name }}
                                </span>
                                <span class="text-[9px] text-gray-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $comment->comment }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <div class="bg-gray-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 italic">Belum ada instruksi untuk tugas ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Form Input Komentar Baru -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <form action="{{ route('admin.tasks.comments', $task->id) }}" method="POST">
                @csrf
                <div class="group">
                    <label for="comment" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">
                        Kirim Feedback Baru
                    </label>
                    <div class="relative">
                        <textarea 
                            id="comment"
                            name="comment" 
                            rows="3" 
                            class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm p-4 shadow-sm transition-all resize-none" 
                            placeholder="Tulis instruksi atau revisi di sini..."
                            required></textarea>
                        
                        <div class="absolute right-2 bottom-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-lg transition-transform active:scale-95 shadow-md flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="mt-3 text-[10px] text-gray-400 italic leading-tight">
                    Catatan: Feedback akan langsung tampil di halaman tugas milik user terkait.
                </p>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling scrollbar agar lebih minimalis */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f9fafb;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
</style>