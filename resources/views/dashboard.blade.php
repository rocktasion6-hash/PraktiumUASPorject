<x-app-layout>
    <div class="p-8 bg-[#FFFFFF] min-h-screen">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540]">Dashboard Saya</h1>
                <p class="text-gray-500 mt-1">
                    Selamat datang kembali, <span class="font-bold text-[#0A2540]">{{ auth()->user()->name }}</span>! Mari selesaikan tugas Anda hari ini. ✨
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-[#0A2540] uppercase tracking-wider">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-orange-50 rounded-full text-[#FF6B00]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Tugas</p>
                    <h3 class="text-2xl font-bold text-[#0A2540]">{{ $totalTasks }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-orange-50 rounded-full text-[#FF6B00]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Tugas Selesai</p>
                    <h3 class="text-2xl font-bold text-[#0A2540]">{{ $completedTasks }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-slate-50 rounded-full text-[#FF6B00]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Sedang Berjalan</p>
                    <h3 class="text-2xl font-bold text-[#0A2540]">{{ $pendingTasks }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-[#0A2540]">Statistik Aktivitas</h2>
                    <p class="text-sm text-gray-500">Visualisasi progres tugas Anda</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-[#FF6B00]"></span><span class="text-xs font-medium text-gray-600">Selesai</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-[#0A2540]"></span><span class="text-xs font-medium text-gray-600">Proses</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-yellow-500"></span><span class="text-xs font-medium text-gray-600">Belum</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-red-500"></span><span class="text-xs font-medium text-gray-600">Ditunda</span></div>
                </div>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="taskChart"></canvas>
            </div>
        </div>

        @if($overdueTasks->count() > 0)
        <div class="mb-8 bg-white rounded-2xl border border-red-200 overflow-hidden shadow-sm">
            <div class="p-4 bg-red-600 flex justify-between items-center text-white">
                <h2 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tugas Melewati Deadline ({{ $overdueTasks->count() }})
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-red-50">
                        @foreach($overdueTasks as $task)
                        <tr class="hover:bg-red-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-red-700">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-gray-500 italic">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('tasks.show', $task->id) }}" class="inline-block bg-red-100 text-red-700 px-4 py-1.5 rounded-lg hover:bg-red-200 font-bold text-xs uppercase">Selesaikan →</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 flex justify-between items-center border-b border-gray-50">
                    <h2 class="text-xl font-bold text-[#0A2540]">Tugas Terbaru</h2>
                    <a href="{{ route('tasks.index') }}" class="text-[#FF6B00] hover:text-[#e05e00] text-sm font-bold">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#0A2540] text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold">Judul Tugas</th>
                                <th class="px-6 py-4 font-bold">Kategori</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold">Deadline</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($latestTasks as $task)
                            <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('tasks.show', $task->id) }}'">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-orange-50 flex items-center justify-center text-[#FF6B00] border border-orange-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h15.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <span class="font-bold text-gray-700">{{ $task->title }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm font-medium">{{ $task->category->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-[#FF6B00]">
                                        {{ $task->status->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm font-semibold">
                                    {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M, H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada tugas tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit flex flex-col justify-between min-h-[350px]">
                <div>
                    <h2 class="text-xl font-bold text-[#0A2540] mb-6">Deadline Terdekat</h2>
                    @if($nearestDeadline)
                    <div class="relative p-6 bg-orange-50/50 rounded-2xl border border-orange-100 overflow-hidden">
                        <div class="absolute -right-4 -top-4 h-24 w-24 bg-orange-100/30 rounded-full"></div>
                        <div class="relative">
                            <span class="text-[#FF6B00] text-xs font-bold uppercase tracking-widest">Mendesak</span>
                            <h3 class="text-lg font-bold text-[#0A2540] mt-1">{{ $nearestDeadline->title }}</h3>
                            <div class="flex items-center gap-2 mt-4 text-[#0A2540]">
                                <svg class="w-5 h-5 text-[#FF6B00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($nearestDeadline->deadline)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-10 text-gray-400 italic">Tidak ada deadline mendesak.</div>
                    @endif
                </div>

                <div class="pt-6">
                    <hr class="mb-6 border-gray-100">
                    @if($nearestDeadline)
                    <a href="{{ route('tasks.show', $nearestDeadline->id) }}" class="block text-center w-full py-3 bg-[#FF6B00] hover:bg-[#e05e00] text-white rounded-xl font-bold transition uppercase tracking-wider text-xs shadow-md shadow-orange-100 active:scale-95">
                        Kerjakan Sekarang
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('taskChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                { label: 'Selesai', data: @json($chartSelesai), borderColor: '#FF6B00', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 },
                { label: 'Proses', data: @json($chartProses), borderColor: '#0A2540', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 },
                { label: 'Belum', data: @json($chartBelum), borderColor: '#eab308', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 },
                { label: 'Ditunda', data: @json($chartDitunda), borderColor: '#ef4444', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, suggestedMax: 7, ticks: { stepSize: 1, color: '#0A2540', font: { weight: 'bold' } }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { color: '#0A2540', font: { weight: 'bold' } } }
            }
        }
    });
    </script>
</x-app-layout>