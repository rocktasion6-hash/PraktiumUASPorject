<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        <!-- Breadcrumbs / Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.tasks.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Monitoring
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- SISI KIRI: Detail Tugas (Span 2) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <!-- Judul & Status -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">
                                {{ $task->category->name ?? 'Tugas Projects' }}
                            </span>
                            <h1 class="text-3xl font-bold text-gray-800 mt-3">{{ $task->title }}</h1>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 mb-1">Status Saat Ini:</p>
                            <span class="px-4 py-1.5 rounded-xl text-xs font-extrabold uppercase shadow-sm 
                                {{ $task->status->name == 'Selesai' ? 'bg-emerald-500 text-white' : 'bg-amber-400 text-white' }}">
                                {{ $task->status->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="prose prose-indigo max-w-none text-gray-600">
                        <h4 class="text-sm font-bold text-gray-800 uppercase mb-2">Deskripsi Tugas:</h4>
                        <p class="leading-relaxed">
                            {{ $task->description ?? 'Tidak ada deskripsi tambahan.' }}
                        </p>
                    </div>

                    <!-- Meta Informasi (Deadline & Progress) -->
                    <div class="grid grid-cols-2 gap-4 mt-10 pt-8 border-t border-gray-50">
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                            <div class="bg-white p-2 rounded-lg shadow-sm text-rose-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Batas Waktu</p>
                                <p class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($task->deadline)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                            <div class="bg-white p-2 rounded-lg shadow-sm text-indigo-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Pemilik Tugas</p>
                                <p class="text-sm font-bold text-gray-700">{{ $task->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Attachment / Lampiran (Opsional) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Lampiran File
                    </h4>
                    @if($task->attachment)
                        <a href="{{ asset('storage/' . $task->attachment) }}" target="_blank" class="inline-flex items-center gap-3 p-3 border rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="bg-rose-100 text-rose-600 p-2 rounded-lg group-hover:bg-rose-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-600">Lihat Hasil Tugas</span>
                        </a>
                    @else
                        <p class="text-xs text-gray-400 italic font-medium">Belum ada file yang diunggah.</p>
                    @endif
                </div>
            </div>

            <!-- SISI KANAN: Partial Komentar (Span 1) -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    @include('admin.comment')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>