@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        <div class="bg-white shadow-lg rounded-2xl p-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Detail Tugas
                    </h1>

                    <p class="text-gray-500 mt-1">
                        Informasi lengkap tugas dan analisis AI
                    </p>
                </div>

                <a href="{{ route('tasks.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 transition text-white px-5 py-2 rounded-lg shadow">

                    Kembali

                </a>

            </div>

            <!-- Success Message -->
            @if(session('success'))

                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>

            @endif

            <!-- Error Message -->
            @if(session('error'))

                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>

            @endif

            <!-- Informasi Tugas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Judul -->
                <div class="bg-gray-50 p-5 rounded-xl border">

                    <h2 class="text-sm text-gray-500 mb-1">
                        Judul
                    </h2>

                    <p class="text-xl font-bold text-gray-800">
                        {{ $task->title }}
                    </p>

                </div>

                <!-- Kategori -->
                <div class="bg-gray-50 p-5 rounded-xl border">

                    <h2 class="text-sm text-gray-500 mb-1">
                        Kategori
                    </h2>

                    <p class="font-semibold text-gray-800">
                        {{ $task->category->name }}
                    </p>

                </div>

                <!-- Status -->
                <div class="bg-gray-50 p-5 rounded-xl border">

                    <h2 class="text-sm text-gray-500 mb-1">
                        Status
                    </h2>

                    <p class="font-semibold text-gray-800">
                        {{ $task->status->name }}
                    </p>

                </div>

                <!-- Prioritas -->
                <div class="bg-gray-50 p-5 rounded-xl border">

                    <h2 class="text-sm text-gray-500 mb-1">
                        Prioritas
                    </h2>

                    <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-bold uppercase">
                        {{ $task->priority }}
                    </span>

                </div>

                <!-- Deadline -->
                <div class="bg-gray-50 p-5 rounded-xl border">

                    <h2 class="text-sm text-gray-500 mb-1">
                        Deadline
                    </h2>

                    <p class="font-semibold text-gray-800">
                        {{ $task->deadline }}
                    </p>

                </div>

                <!-- Dibuat Oleh -->
                <div class="bg-gray-50 p-5 rounded-xl border">

                    <h2 class="text-sm text-gray-500 mb-1">
                        Dibuat Oleh
                    </h2>

                    <p class="font-semibold text-gray-800">
                        {{ $task->user->name }}
                    </p>

                </div>

            </div>

            <!-- Deskripsi -->
            <div class="mt-10">

                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Deskripsi
                </h2>

                <div class="bg-gray-100 p-5 rounded-xl border text-gray-700 leading-relaxed">

                    {{ $task->description }}

                </div>

            </div>

            <!-- Komentar -->
            <div class="mt-10">

                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Komentar
                </h2>

                @forelse($task->comments as $comment)

                    <div class="bg-gray-50 border rounded-xl p-5 mb-4">

                        <div class="flex justify-between items-center">

                            <p class="font-semibold text-gray-800">
                                {{ $comment->user->name }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $comment->created_at->diffForHumans() }}
                            </p>

                        </div>

                        <p class="mt-3 text-gray-700 leading-relaxed">
                            {{ $comment->comment }}
                        </p>

                    </div>

                @empty

                    <div class="bg-gray-50 border rounded-xl p-5 text-gray-500">
                        Belum ada komentar.
                    </div>

                @endforelse

            </div>

            <!-- Tombol AI -->
            <div class="mt-10">

                <form action="{{ route('tasks.analyze', $task->id) }}" method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="bg-purple-600 hover:bg-purple-700 transition text-white px-6 py-3 rounded-xl shadow-lg font-semibold">

                        Analisis dengan AI

                    </button>

                </form>

            </div>

            <!-- Rekomendasi AI -->
            <div class="mt-10">

                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Rekomendasi AI
                </h2>

                @forelse($task->recommendations as $ai)

                    <div class="bg-blue-50 border border-blue-200 p-6 rounded-2xl mb-5 shadow-sm">

                        <div class="prose max-w-none prose-headings:text-blue-700 prose-strong:text-gray-800 prose-li:marker:text-blue-500">

                            {!! Str::markdown($ai->recommendation) !!}

                        </div>

                        <div class="mt-4 text-sm text-gray-500">
                            Dibuat:
                            {{ $ai->generated_at->diffForHumans() }}
                        </div>

                    </div>

                @empty

                    <div class="bg-gray-50 border rounded-xl p-5 text-gray-500">
                        Belum ada rekomendasi AI.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>