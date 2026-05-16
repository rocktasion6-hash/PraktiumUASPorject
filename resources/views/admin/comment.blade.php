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