<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Panel Kendali Admin</h1>
                <p class="text-gray-500">Pantau seluruh aktivitas tugas dan produktivitas pengguna dalam satu layar.</p>
            </div>
        </div>

        <!-- Statistik Cards (4 Kolom untuk Admin) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Card 1: Total Seluruh Tugas -->
            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-orange-100 rounded-full text-orange-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Tugas</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalTasks }}</h3>
                </div>
            </div>

            <!-- Card 2: Total Selesai -->
            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-green-100 rounded-full text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Tugas Selesai</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $completedTasks }}</h3>
                </div>
            </div>

            <!-- Card 3: Sedang Berjalan -->
            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-gray-100">
                <div class="p-4 bg-blue-100 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Dalam Progres</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingTasks }}</h3>
                </div>
            </div>

            <!-- Card 4: Total Pengguna (Highlight Khusus Admin) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4 border border-indigo-100 bg-gradient-to-br from-white to-indigo-50">
                <div class="p-4 bg-indigo-100 rounded-full text-indigo-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-indigo-400 text-sm font-medium uppercase tracking-wider">Total Pengguna</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <!-- Chart Section (Full Activity) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Statistik Aktivitas Global</h2>
                    <p class="text-sm text-gray-500">Akumulasi seluruh tugas pengguna dalam periode ini</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-green-500"></span><span class="text-xs font-medium text-gray-600">Selesai</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-blue-500"></span><span class="text-xs font-medium text-gray-600">Proses</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-yellow-500"></span><span class="text-xs font-medium text-gray-600">Belum</span></div>
                    <div class="flex items-center gap-1.5"><span class="h-3 w-3 rounded-full bg-red-500"></span><span class="text-xs font-medium text-gray-600">Ditunda</span></div>
                </div>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="taskChart"></canvas>
            </div>
        </div>

        <!-- Overdue Tasks (Admin view often needs higher visibility for errors) -->
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
                        <tr class="hover:bg-red-50 transition">
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
            <!-- Global Tasks Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 flex justify-between items-center border-b border-gray-50">
                    <h2 class="text-xl font-bold text-gray-800">Monitoring Tugas</h2>
                    <a href="{{ route('admin.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-semibold">Kelola Semua Tugas</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-400 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4 font-medium">Judul Tugas</th>
                                <th class="px-6 py-4 font-medium text-indigo-600">Pemilik</th>
                                <th class="px-6 py-4 font-medium">Kategori</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($latestTasks as $task)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-700 line-clamp-1">{{ $task->title }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-bold">
                                            {{ strtoupper(substr($task->user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm text-gray-600">{{ $task->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $task->category->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                        {{ $task->status->name == 'Selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        {{ $task->status->name }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada data aktivitas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistik User Singkat (New for Admin) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Deadline Terdekat</h2>
                 @if($nearestDeadline)
                <div class="relative p-6 bg-indigo-50 rounded-2xl border border-indigo-100 overflow-hidden">
                    <div class="absolute -right-4 -top-4 h-24 w-24 bg-indigo-100 rounded-full opacity-50"></div>
                    <div class="relative">
                        <span class="text-indigo-500 text-xs font-bold uppercase tracking-widest">Urgent Global</span>
                        <h3 class="text-lg font-bold text-gray-800 mt-1 line-clamp-1">{{ $nearestDeadline->title }}</h3>
                        <p class="text-sm text-indigo-600 mt-1 font-medium">Pemilik: {{ $nearestDeadline->user->name }}</p>
                        <div class="flex items-center gap-2 mt-4 text-indigo-600">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($nearestDeadline->deadline)->translatedFormat('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-10 text-gray-400">Semua tugas berjalan aman.</div>
                @endif
                
                <hr class="my-6 border-gray-50">
                <a href="{{ route('tasks.index') }}" class="block text-center w-full py-3 bg-gray-800 text-white rounded-xl font-semibold hover:bg-gray-900 transition">
                    Manajemen Pengguna
                </a>
            </div>
        </div>
    </div>

    <!-- Chart.js Script (Admin version is similar, but represents Global Data) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('taskChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                { label: 'Selesai', data: @json($chartSelesai), borderColor: '#22c55e', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 },
                { label: 'Proses', data: @json($chartProses), borderColor: '#3b82f6', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 },
                { label: 'Belum', data: @json($chartBelum), borderColor: '#eab308', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 },
                { label: 'Ditunda', data: @json($chartDitunda), borderColor: '#ef4444', backgroundColor: 'transparent', tension: 0.4, borderWidth: 3, pointRadius: 3 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, suggestedMax: 10, ticks: { stepSize: 1, color: '#9ca3af' }, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
            }
        }
    });
    </script>
</x-app-layout>