<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">

        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Status</h1>
                <p class="text-gray-500 mt-1">Tambah, ubah, atau hapus status tugas.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                <span class="text-xs text-gray-400 uppercase font-bold block">Total Status</span>
                <span class="text-xl font-bold text-indigo-600">{{ $statuses->count() }}</span>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Status</h2>
                <form method="POST" action="{{ route('admin.statuses.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Status</label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            placeholder="Contoh: Selesai">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl text-sm transition">
                        Tambah Status
                    </button>
                </form>
            </div>

            <!-- Tabel Status -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Nama Status</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($statuses as $status)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="px-6 py-4 font-semibold text-gray-700">{{ $status->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="openEditStatus({{ $status->id }}, '{{ $status->name }}')"
                                            class="inline-flex items-center gap-1 bg-white border border-gray-200 hover:border-indigo-600 hover:text-indigo-600 text-gray-600 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.statuses.destroy', $status->id) }}"
                                            onsubmit="return confirm('Hapus status ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 bg-white border border-gray-200 hover:border-red-500 hover:text-red-500 text-gray-600 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-20 text-center text-gray-400">Belum ada status.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Status -->
    <div id="editStatusModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Edit Status</h2>
            <form id="editStatusForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Status</label>
                    <input type="text" name="name" id="editStatusName" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl text-sm transition">Simpan</button>
                    <button type="button" onclick="closeEditStatus()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-xl text-sm transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditStatus(id, name) {
            document.getElementById('editStatusForm').action = `/admin/statuses/${id}`;
            document.getElementById('editStatusName').value = name;
            document.getElementById('editStatusModal').classList.remove('hidden');
        }
        function closeEditStatus() {
            document.getElementById('editStatusModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
