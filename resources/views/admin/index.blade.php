<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        
        <!-- Header Section -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Monitoring Tugas</h1>
                <p class="text-gray-500 mt-1">Pantau dan berikan feedback pada tugas seluruh pengguna.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                <span class="text-xs text-gray-400 uppercase font-bold block">Total Tugas</span>
                <span class="text-xl font-bold text-indigo-600">{{ $allTasks->count() }}</span>
            </div>
        </div>

        <!-- Tabel Monitoring -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4 font-semibold">User</th>
                            <th class="px-6 py-4 font-semibold">Informasi Tugas</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Deadline</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($allTasks as $task)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <!-- Kolom User -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                        {{ strtoupper(substr($task->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-700 leading-none">{{ $task->user->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1 uppercase">{{ $task->user->role }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Judul & Kategori -->
                            <td class="px-6 py-4">
                                <span class="block text-sm font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">
                                    {{ $task->title }}
                                </span>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-gray-100 text-gray-500 font-medium">
                                    {{ $task->category->name ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Kolom Status -->
                            <td class="px-6 py-4">
                                @php
                                    $statusColor = match($task->status->name) {
                                        'Selesai' => 'bg-emerald-100 text-emerald-600',
                                        'Progres' => 'bg-amber-100 text-amber-600',
                                        default => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusColor }}">
                                    {{ $task->status->name }}
                                </span>
                            </td>

                            <!-- Kolom Deadline -->
                            <td class="px-6 py-4">
                                <div class="text-sm {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'text-red-500 font-bold' : 'text-gray-500' }}">
                                    {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') }}
                                </div>
                                <p class="text-[10px] text-gray-400 leading-none mt-1">
                                    {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                                </p>
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.tasks.show', $task->id) }}" 
                                   class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-indigo-600 hover:text-indigo-600 text-gray-600 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail & Feedback
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-100 p-4 rounded-full mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-medium">Belum ada tugas yang dikirim oleh pengguna.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>