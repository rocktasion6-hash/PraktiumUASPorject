<x-app-layout>

    <div class="max-w-4xl mx-auto p-6">

        <div class="bg-white shadow-lg rounded-xl p-6">

            <h1 class="text-2xl font-bold mb-6">
                Edit Tugas
            </h1>

            @if ($errors->any())

                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">

                    <ul class="list-disc pl-5">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('tasks.update', $task->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- Judul -->

                <div class="mb-4">

                    <label class="block font-semibold mb-2">
                        Judul Tugas
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ $task->title }}"
                           class="w-full border rounded-lg p-3">

                </div>

                <!-- Deskripsi -->

                <div class="mb-4">

                    <label class="block font-semibold mb-2">
                        Deskripsi
                    </label>

                    <textarea name="description"
                              rows="5"
                              class="w-full border rounded-lg p-3">{{ $task->description }}</textarea>

                </div>

                <!-- Kategori -->

                <div class="mb-4">

                    <label class="block font-semibold mb-2">
                        Kategori
                    </label>

                    <select name="category_id"
                            class="w-full border rounded-lg p-3">

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ $task->category_id == $category->id ? 'selected' : '' }}>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Status -->

                <div class="mb-4">

                    <label class="block font-semibold mb-2">
                        Status
                    </label>

                    <select name="status_id"
                            class="w-full border rounded-lg p-3">

                        @foreach($statuses as $status)

                            <option value="{{ $status->id }}"
                                {{ $task->status_id == $status->id ? 'selected' : '' }}>

                                {{ $status->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Priority -->

                <div class="mb-4">

                    <label class="block font-semibold mb-2">
                        Prioritas
                    </label>

                    <select name="priority"
                            class="w-full border rounded-lg p-3">

                        <option value="low"
                            {{ $task->priority == 'low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option value="medium"
                            {{ $task->priority == 'medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option value="high"
                            {{ $task->priority == 'high' ? 'selected' : '' }}>
                            High
                        </option>

                    </select>

                </div>

                <!-- Deadline -->

                <div class="mb-6">

                    <label class="block font-semibold mb-2">
                        Deadline
                    </label>

                    <input type="date"
                           name="deadline"
                           value="{{ $task->deadline }}"
                           class="w-full border rounded-lg p-3">

                </div>

                <!-- Button -->

                <div class="flex gap-3">

                    <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg">

                        Update

                    </button>

                    <a href="{{ route('tasks.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>