@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; }
    </style>

    <div class="p-8 bg-[#FFFFFF] min-h-screen">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-gray-100 pb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540]">Panel Kendali Admin</h1>
                <p class="text-gray-500 mt-1">
                    Halo, <span class="font-bold text-[#0A2540]">{{ auth()->user()->name }}</span>! Pantau seluruh aktivitas tugas global pengguna dalam satu layar. 🛠️
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-[#0A2540] uppercase tracking-wider">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
                
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-[#0A2540] text-[#0A2540] px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                    <svg class="w-4 h-4 text-[#FF6B00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Kelola Kategori
                </a>

                <a href="{{ route('admin.statuses.index') }}"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:border-[#0A2540] text-[#0A2540] px-4 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                    <svg class="w-4 h-4 text-[#FF6B00]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path>
                    </svg>
                    Kelola Status
                </a>

                <a href="{{ route('tasks.create') }}"
                    class="inline-flex items-center gap-2 bg-[#FF6B00] hover:bg-[#e05e00] text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Tugas
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <div class="p-4 bg-emerald-50 rounded-full text-emerald-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Tugas Selesai</p>
                    <h3 class="text-2xl font-bold text-[#0A2540]">{{ $completedTasks }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-blue-50 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Dalam Progres</p>
                    <h3 class="text-2xl font-bold text-[#0A2540]">{{ $pendingTasks }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100 bg-gradient-to-br from-white to-orange-50/30">
                <div class="p-4 bg-orange-100 rounded-full text-[#FF6B00] shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[#FF6B00] text-sm font-medium uppercase tracking-wider">Total Pengguna</p>
                    <h3 class="text-2xl font-bold text-[#0A2540]">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-[#0A2540]">Statistik Aktivitas Global</h2>
                        <p class="text-sm text-gray-500">Akumulasi tren penyelesaian tugas harian</p>
                    </div>
                </div>
                <div class="h-[280px] w-full">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-[#0A2540]">Penyebaran Kategori</h2>
                    <p class="text-sm text-gray-500">Visualisasi tugas berdasarkan rumpun warna</p>
                </div>
                <div class="h-[280px] w-full flex justify-center">
                    <canvas id="categoryPieChart"></canvas>
                </div>
            </div>
        </div>

        @if($overdueTasks->count() > 0)
        <div class="mb-8 bg-white rounded-2xl border border-red-200 overflow-hidden shadow-sm">
            <div class="p-4 bg-red-600 flex justify-between items-center text-white">
                <h2 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tugas Macet di Seluruh Pengguna ({{ $overdueTasks->count() }})
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-red-50">
                        @foreach($overdueTasks as $task)
                        <tr class="hover:bg-red-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-red-700">{{ $task->title }}</td>
                            <td class="px-6 py-4 text-gray-600 font-medium italic">Oleh: {{ $task->user->name }}</td>
                            <td class="px-6 py-4 text-gray-500 italic">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d M Y') }}</td>
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
                    <h2 class="text-xl font-bold text-[#0A2540]">Monitoring Tugas</h2>
                    <a href="{{ route('admin.tasks.index') }}" class="text-[#FF6B00] hover:text-[#e05e00] text-sm font-bold">Kelola Semua Tugas →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#0A2540] text-white text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-bold">Judul Tugas</th>
                                <th class="px-6 py-4 font-bold">Pemilik</th>
                                <th class="px-6 py-4 font-bold">Kategori</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($latestTasks as $task)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-700 line-clamp-1">{{ $task->title }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center text-[10px] font-bold border border-orange-100">
                                            {{ strtoupper(substr($task->user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm text-gray-600 font-medium">{{ $task->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm font-medium">{{ $task->category->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-orange-50 text-[#FF6B00]">
                                        {{ $task->status->name }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data aktivitas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit flex flex-col justify-between min-h-[380px]">
                <div>
                    <h2 class="text-xl font-bold text-[#0A2540] mb-6">Deadline Terdekat</h2>
                    @if($nearestDeadline)
                    <div class="relative p-6 bg-orange-50/50 rounded-2xl border border-orange-100 overflow-hidden">
                        <div class="absolute -right-4 -top-4 h-24 w-24 bg-orange-100/40 rounded-full"></div>
                        <div class="relative">
                            <span class="text-[#FF6B00] text-xs font-bold uppercase tracking-widest">Urgent Global</span>
                            <h3 class="text-lg font-bold text-[#0A2540] mt-1 line-clamp-1">{{ $nearestDeadline->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1 font-medium">Pemilik: {{ $nearestDeadline->user->name }}</p>
                            <div class="flex items-center gap-2 mt-4 text-[#0A2540]">
                                 <svg class="w-5 h-5 text-[#FF6B00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($nearestDeadline->deadline)->translatedFormat('d F Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-10 text-gray-400 italic">Semua tugas berjalan aman.</div>
                    @endif
                </div>
                
                <div class="pt-6">
                    <div class="mb-6">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-400 font-bold text-xs uppercase tracking-tight">Progres Penyelesaian Global</span>
                            <span class="font-black text-[#FF6B00] text-xs">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div class="bg-[#FF6B00] h-2.5 rounded-full" style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <hr class="mb-6 border-gray-100">
                    <a href="{{ route('admin.tasks.index') }}" class="block text-center w-full py-3 bg-[#FF6B00] hover:bg-[#e05e00] text-white rounded-xl font-bold transition uppercase tracking-wider text-xs shadow-md shadow-orange-100 active:scale-95">
                        Manajemen Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Line Chart Aktivitas Mingguan
        const ctxLine = document.getElementById('taskChart').getContext('2d');
        new Chart(ctxLine, {
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
                    y: { beginAtZero: true, suggestedMax: 10, ticks: { stepSize: 1, color: '#0A2540', font: { weight: 'bold' } }, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false }, ticks: { color: '#0A2540', font: { weight: 'bold' } } }
                }
            }
        });

        // 2. Pie Chart Kategori Dinamis Sesuai Warna DB (Pilihan Temanmu)
        const ctxPie = document.getElementById('categoryPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: {!! json_encode($categoryLabels) !!},
                datasets: [{
                    data: {!! json_encode($categoryCounts) !!},
                    backgroundColor: {!! json_encode($categoryColors) !!},
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 },
                            color: '#0A2540'
                        }
                    }
                }
            }
        });
    });
    </script>
</x-app-layout>