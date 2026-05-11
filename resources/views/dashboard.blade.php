<x-app-layout>

    <div class="p-6">

        <!-- Title -->

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard SIMANJA
            </h1>

            <p class="text-gray-500">
                Selamat datang di Sistem Manajemen Tugas
            </p>

        </div>

        <!-- Statistik -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- Total -->

            <div class="bg-blue-500 text-white p-6 rounded-2xl shadow-lg">

                <h2 class="text-lg font-semibold">
                    Total Tugas
                </h2>

                <p class="text-4xl font-bold mt-3">
                    {{ $totalTasks }}
                </p>

            </div>

            <!-- Completed -->

            <div class="bg-green-500 text-white p-6 rounded-2xl shadow-lg">

                <h2 class="text-lg font-semibold">
                    Tugas Selesai
                </h2>

                <p class="text-4xl font-bold mt-3">
                    {{ $completedTasks }}
                </p>

            </div>

            <!-- Pending -->

            <div class="bg-yellow-500 text-white p-6 rounded-2xl shadow-lg">

                <h2 class="text-lg font-semibold">
                    Belum Dikerjakan
                </h2>

                <p class="text-4xl font-bold mt-3">
                    {{ $pendingTasks }}
                </p>

            </div>

        </div>

        <!-- Deadline -->

        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">

            <h2 class="text-2xl font-bold mb-4">
                Deadline Terdekat
            </h2>

            @if($nearestDeadline)

                <div class="border-l-4 border-red-500 pl-4">

                    <h3 class="text-xl font-semibold">
                        {{ $nearestDeadline->title }}
                    </h3>

                    <p class="text-gray-600 mt-2">
                        Deadline:
                        {{ $nearestDeadline->deadline }}
                    </p>

                </div>

            @else

                <p class="text-gray-500">
                    Tidak ada tugas.
                </p>

            @endif

        </div>

        <!-- Latest Tasks -->

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-2xl font-bold">
                    Tugas Terbaru
                </h2>

                <a href="{{ route('tasks.index') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">

                    Lihat Semua

                </a>

            </div>

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="text-left p-3">Judul</th>
                        <th class="text-left p-3">Kategori</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-left p-3">Deadline</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($latestTasks as $task)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3">
                                {{ $task->title }}
                            </td>

                            <td class="p-3">
                                {{ $task->category->name }}
                            </td>

                            <td class="p-3">
                                {{ $task->status->name }}
                            </td>

                            <td class="p-3">
                                {{ $task->deadline }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4"
                                class="text-center p-6 text-gray-500">

                                Belum ada tugas

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>