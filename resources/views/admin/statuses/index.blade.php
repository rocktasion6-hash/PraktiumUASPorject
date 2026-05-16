<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FFFFFF; }
    </style>

    <div class="max-w-7xl mx-auto p-6 min-h-screen bg-white">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-5 border-b border-gray-100">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0A2540] tracking-tight">Manajemen Status</h1>
                <p class="text-sm text-gray-400 mt-1">Tambah, ubah, atau hapus status tugas.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="p-3 inline-flex items-center text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition shadow-sm" 
                   title="Kembali ke Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                
                <div class="bg-gray-50 border border-gray-200 px-4 py-2 rounded-xl text-center min-w-[100px]">
                    <span class="text-[9px] text-gray-400 uppercase font-bold block tracking-wider leading-none mb-1">Total Status</span>
                    <span class="text-xl font-black text-[#0A2540]">{{ $statuses->count() }}</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 text-sm font-semibold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 sticky top-6">
                    <h2 class="text-base font-bold text-[#0A2540] mb-5 uppercase tracking-widest border-b pb-3">Tambah Status</h2>
                    
                    <form method="POST" action="{{ route('admin.statuses.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Nama Status</label>
                            <input type="text" name="name" required
                                class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-sm text-gray-700 placeholder:text-gray-300"
                                placeholder="Contoh: Selesai">
                            @error('name')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit"
                            class="w-full bg-[#FF6B00] hover:bg-[#e05e00] text-white font-bold py-3 rounded-xl transition-all shadow-md shadow-orange-100 uppercase tracking-wider text-xs active:scale-95">
                            Tambah Status
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="border border-gray-100 rounded-2xl shadow-sm overflow-hidden bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0A2540] text-[11px] font-bold text-white uppercase tracking-widest border-b border-gray-200">
                                <th class="px-6 py-4">Nama Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($statuses as $status)
                            <tr class="hover:bg-gray-50/40 transition-all group">
                                <td class="px-6 py-4 font-bold text-gray-700 text-sm">{{ $status->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-4">
                                        <button onclick="openEditStatus({{ $status->id }}, '{{ $status->name }}')"
                                            class="text-[#FF6B00] hover:text-[#e05e00] transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        
                                        <form method="POST" action="{{ route('admin.statuses.destroy', $status->id) }}"
                                            onsubmit="return confirm('Hapus status ini?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600 transition pt-1" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-20 text-center text-gray-400 italic">Belum ada status.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="editStatusModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md border border-gray-100">
            <h2 class="text-lg font-bold text-[#0A2540] mb-4 uppercase tracking-wider text-xs border-b pb-2">Edit Status</h2>
            <form id="editStatusForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Nama Status</label>
                    <input type="text" name="name" id="editStatusName" required
                        class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-sm text-gray-700">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-[#FF6B00] hover:bg-[#e05e00] text-white font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider transition active:scale-95 shadow-sm">Simpan</button>
                    <button type="button" onclick="closeEditStatus()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2.5 rounded-xl text-xs uppercase tracking-wider transition">Batal</button>
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