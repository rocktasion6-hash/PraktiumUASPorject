<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-full flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-orange-50 p-2 rounded-lg text-[#FF6B00]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m11 10V5a2 2 0 00-2-2H4a2 2 0 00-2 2v15a2 2 0 002 2h7l5 5v-5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[#0A2540]">Feedback Admin</h3>
        </div>

        <form action="{{ route('admin.tasks.comments', $task->id) }}" method="POST" class="mb-8">
            @csrf
            <div class="mb-4">
                <label for="comment" class="block text-xs font-bold text-[#0A2540] uppercase mb-2 tracking-widest">Tulis Masukan</label>
                <textarea 
                    id="comment"
                    name="comment" 
                    rows="4" 
                    required
                    class="w-full rounded-xl border-gray-200 focus:border-[#FF6B00] focus:ring-[#FF6B00] font-semibold text-sm text-gray-700 placeholder:text-gray-300 placeholder:font-normal transition-all"
                    placeholder="Berikan arahan atau evaluasi untuk tugas ini..."
                ></textarea>
                @error('comment')
                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="w-full bg-[#FF6B00] hover:bg-[#e05e00] text-white font-bold py-3 rounded-xl transition-all shadow-md shadow-orange-100 flex justify-center items-center gap-2 uppercase tracking-wider text-xs active:scale-95">
                <span>Kirim Feedback</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                </svg>
            </button>
        </form>
    </div>

    <div class="border-t border-gray-50 pt-6">
        <h4 class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-wider">Riwayat Diskusi</h4>
        
        <div class="space-y-4 max-h-[320px] overflow-y-auto pr-2 custom-scrollbar">
            @forelse($task->comments as $comment)
                <div class="p-4 rounded-2xl {{ $comment->user->role === 'admin' ? 'bg-orange-50/40 border border-orange-100/60' : 'bg-gray-50 border border-gray-100' }}">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-extrabold {{ $comment->user->role === 'admin' ? 'text-[#FF6B00]' : 'text-[#0A2540]' }}">
                            {{ $comment->user->name }} 
                            @if($comment->user->role === 'admin') 
                                <span class="text-[9px] ml-1 bg-[#0A2540] text-white px-1.5 py-0.5 rounded font-black uppercase tracking-wider">Admin</span>
                            @endif
                        </span>
                        <span class="text-[10px] text-gray-400 font-medium">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 font-medium leading-relaxed">
                        {{ $comment->comment }}
                    </p>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="bg-gray-50 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3 border border-gray-100/60">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 italic">Belum ada diskusi atau feedback.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f8fafc;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>