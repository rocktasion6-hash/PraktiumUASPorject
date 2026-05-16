<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">

        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Kategori</h1>
                <p class="text-gray-500 mt-1">Tambah, ubah, atau hapus kategori tugas.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                <span class="text-xs text-gray-400 uppercase font-bold block">Total Kategori</span>
                <span class="text-xl font-bold text-indigo-600">{{ $categories->count() }}</span>
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
                <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Kategori</h2>
                <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kategori</label>
                        <input type="text" name="name" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            placeholder="Contoh: Kuliah">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Warna</label>
                        <select name="color" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            <option value="">-- Pilih Warna --</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="red">Red</option>
                            <option value="yellow">Yellow</option>
                            <option value="purple">Purple</option>
                            <option value="orange">Orange</option>
                            <option value="gray">Gray</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl text-sm transition">
                        Tambah Kategori
                    </button>
                </form>
            </div>

            <!-- Tabel Kategori -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Nama</th>
                                <th class="px-6 py-4 font-semibold">Warna</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="px-6 py-4 font-semibold text-gray-700">{{ $category->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-gray-100 text-gray-600">
                                        {{ $category->color ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <!-- Tombol Edit (modal trigger) -->
                                        <button onclick="openEditCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->color }}')"
                                            class="inline-flex items-center gap-1 bg-white border border-gray-200 hover:border-indigo-600 hover:text-indigo-600 text-gray-600 px-3 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                                            Edit
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}"
                                            onsubmit="return confirm('Hapus kategori ini?')">
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
                                <td colspan="3" class="px-6 py-20 text-center text-gray-400">Belum ada kategori.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Edit Kategori</h2>
            <form id="editCategoryForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Kategori</label>
                    <input type="text" name="name" id="editCategoryName" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Warna</label>
                    <select name="color" id="editCategoryColor" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <option value="">-- Pilih Warna --</option>
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                        <option value="red">Red</option>
                        <option value="yellow">Yellow</option>
                        <option value="purple">Purple</option>
                        <option value="orange">Orange</option>
                        <option value="gray">Gray</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl text-sm transition">Simpan</button>
                    <button type="button" onclick="closeEditCategory()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-xl text-sm transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditCategory(id, name, color) {
            document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
            document.getElementById('editCategoryName').value = name;
            document.getElementById('editCategoryColor').value = color;
            document.getElementById('editCategoryModal').classList.remove('hidden');
        }
        function closeEditCategory() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
