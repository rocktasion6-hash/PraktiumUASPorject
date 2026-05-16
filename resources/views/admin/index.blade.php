<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; }
    </style>

    <div class="max-w-7xl mx-auto p-6 min-h-screen bg-white">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-5 border-b border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540] tracking-tight">Monitoring Tugas</h1>
                <p class="text-sm text-gray-400 mt-1">Pantau dan berikan feedback pada tugas seluruh pengguna.</p>
            </div>
            
            <div class="bg-gray-50 border border-gray-200 px-5 py-3 rounded-2xl text-center shadow-xs min-w-[100px]">
                <span class="text-[10px] text-gray-400 uppercase font-bold block tracking-widest leading-none mb-1">Total Tugas</span>
                <span class="text-2xl font-black text-[#0A2540]">{{ $allTasks->count() }}</span>
            </div>
        </div>

        @if($allTasks->count() > 0)
            <div class="border border-gray-100 rounded-2xl shadow-sm overflow-hidden bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0A2540] text-[11px] font-bold text-white uppercase tracking-widest border-b border-gray-200">
                            <th class="px-6 py-4 font-bold">User</th>
                            <th class="px-6 py-4 font-bold">Informasi Tugas</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Deadline</th>
                            <th class="px-6 py-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($allTasks as $task)
                            <tr class="hover:bg-gray-50/40 transition-all group">
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-orange-50 text-[#FF6B00] border border-orange-100 flex items-center justify-center text-xs font-black shadow-2xs">
                                            {{ strtoupper(substr($task->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-[#0A2540] leading-none">{{ $task->user->name }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider font-semibold">{{ $task->user->role }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="block text-sm font-bold text-gray-800 group-hover:text-[#FF6B00] transition-colors mb-1">
                                        {{ $task->title }}
                                    </span>
                                    <span class="text-[9px] px-2 py-0.5 rounded bg-gray-100 text-gray-500 font-black uppercase tracking-wider border border-gray-200/40">
                                        {{ $task->category->name ?? 'Umum' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-orange-50 text-[#FF6B00] border border-orange-100/50 shadow-2xs">
                                        {{ $task->status->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm {{ \Carbon\Carbon::parse($task->deadline)->isPast() ? 'text-red-500 font-bold' : 'text-gray-600 font-semibold' }}">
                                        {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') }}
                                    </div>
                                    <p class="text-[10px] text-gray-400 leading-none mt-1 italic font-medium">
                                        {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}" 
                                           class="inline-flex items-center justify-center bg-[#FF6B00] hover:bg-[#e05e00] text-white p-2.5 rounded-xl transition-all shadow-md shadow-orange-100 active:scale-95"
                                           title="Beri Feedback & Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center max-w-md mx-auto mt-10">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#0A2540]">Belum Ada Tugas</h3>
                <p class="text-sm text-gray-400 mt-1">Belum ada tugas yang dikirim oleh pengguna ke dalam radar monitoring panel admin.</p>
            </div>
        @endif

    </div>
</x-app-layout>