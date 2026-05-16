<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; }
    </style>

    <div class="max-w-7xl mx-auto p-8 bg-white min-h-screen">
        
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-5">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540] tracking-tight">Detail Pemantauan Tugas</h1>
                <p class="text-sm text-gray-400 mt-1">Tinjau rincian tugas pengguna dan berikan arahan evaluasi.</p>
            </div>
            <div>
                <a href="{{ route('admin.tasks.index') }}" 
                   class="p-3 inline-flex items-center text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition shadow-sm" 
                   title="Kembali ke Monitoring">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                    
                    <div class="bg-[#0A2540] px-6 py-4 flex justify-between items-center">
                        <span class="text-[10px] font-black text-white uppercase tracking-widest bg-white/10 px-3 py-1 rounded-md border border-white/20">
                            {{ $task->category->name ?? 'Tugas Projects' }}
                        </span>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-orange-50 text-[#FF6B00] border border-orange-100/50 shadow-2xs">
                                {{ $task->status->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Judul Tugas</label>
                            <h2 class="text-2xl font-extrabold text-[#0A2540] leading-tight">{{ $task->title }}</h2>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Deskripsi Tugas</label>
                            <div class="text-sm text-gray-600 font-medium leading-relaxed bg-gray-50 p-5 rounded-xl border border-gray-100 whitespace-pre-line">
                                {{ $task->description ?? 'Tidak ada deskripsi tambahan untuk tugas ini.' }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-gray-50">
                            <div class="flex items-center gap-4 p-4 bg-gray-50/60 border border-gray-100/70 rounded-xl">
                                <div class="bg-white p-2.5 rounded-lg shadow-2xs text-[#FF6B00] border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 font-black uppercase tracking-wider mb-0.5">Batas Waktu</p>
                                    <p class="text-sm font-bold text-[#0A2540]">{{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y, H:i') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 bg-gray-50/60 border border-gray-100/70 rounded-xl">
                                <div class="bg-white p-2.5 rounded-lg shadow-2xs text-[#FF6B00] border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-400 font-black uppercase tracking-wider mb-0.5">Pemilik Tugas</p>
                                    <p class="text-sm font-bold text-[#0A2540]">{{ $task->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    @include('admin.comment')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>