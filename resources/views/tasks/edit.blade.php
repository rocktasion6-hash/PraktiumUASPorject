<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; }
    </style>

    <div class="max-w-3xl mx-auto p-6 bg-white min-h-screen">
        
        <div class="flex justify-between items-end mb-10 border-b border-gray-100 pb-5">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540] tracking-tight">Edit Tugas</h1>
                <p class="text-sm text-gray-400 mt-1">Perbarui dan sesuaikan rincian jadwal tugas Anda di SIMANJA.</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-sm font-bold text-[#FF6B00] hover:text-[#e05e00] transition">
                &larr; Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm font-semibold">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Judul Tugas</label>
                    <input type="text" name="title" 
                           class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700 transition-all"
                           value="{{ old('title', $task->title) }}" placeholder="Masukkan judul tugas" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Deskripsi</label>
                    <textarea name="description" rows="5"
                              class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700 transition-all"
                              placeholder="Masukkan deskripsi tugas">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Kategori</label>
                        <select name="category_id" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700 bg-white transition-all">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Status</label>
                        <select name="status_id" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700 bg-white transition-all">
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ $task->status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Prioritas</label>
                        <select name="priority" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700 bg-white transition-all">
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Deadline</label>
                        <input type="datetime-local" name="deadline" step="60"
                               class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700 transition-all"
                               value="{{ old('deadline', $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-6 border-t border-gray-50">
                    <button type="submit"
                            class="bg-[#FF6B00] hover:bg-[#e05e00] text-white px-8 py-3 rounded-xl font-bold shadow-md shadow-orange-100 transition-all active:scale-95 uppercase tracking-wider text-[11px]">
                        Update
                    </button>

                    <a href="{{ route('tasks.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl font-bold transition-all uppercase tracking-wider text-[11px] text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>