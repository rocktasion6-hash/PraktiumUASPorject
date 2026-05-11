<x-app-layout>

    <div class="p-6">

        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Daftar Tugas</h1>

            <a href="{{ route('tasks.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Tugas
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-200 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white shadow rounded">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Prioritas</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($tasks as $task)

                <tr class="border-b">

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
                        {{ $task->priority }}
                    </td>

                    <td class="p-3">
                        {{ $task->deadline }}
                    </td>

                    <td class="p-3 flex gap-2">

                        <a href="{{ route('tasks.edit', $task->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <a href="{{ route('tasks.show', $task->id) }}"
                            class="bg-green-500 text-white px-3 py-1 rounded">
                            Detail
                        </a>

                        <form action="{{ route('tasks.destroy', $task->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-3 py-1 rounded">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>