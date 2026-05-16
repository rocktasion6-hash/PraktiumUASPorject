<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold text-[#0A2540]">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-500">Perbarui informasi profil akun dan alamat email Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf @method('patch')

        <div>
            <label for="name" class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        </div>

        <div>
            <label for="email" class="text-xs font-bold text-[#0A2540] uppercase tracking-widest block mb-2">Alamat Email</label>
            <input id="email" name="email" type="email" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#FF6B00] focus:border-[#FF6B00] font-semibold text-gray-700" value="{{ old('email', $user->email) }}" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 bg-orange-50 p-3 rounded-xl border border-orange-100">
                    <p class="text-sm text-gray-700 font-medium">Email belum diverifikasi. <button form="send-verification" class="underline text-[#FF6B00] font-bold">Klik untuk kirim ulang.</button></p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-[#FF6B00] hover:bg-[#e05e00] text-white px-8 py-2.5 rounded-xl font-bold shadow-md transition-all active:scale-95 uppercase tracking-wider text-[11px]">
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>