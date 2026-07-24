<x-guest-layout>
    <x-slot name="title">Masuk — Wahyu Gadget Pedia</x-slot>

    <div class="w-full max-w-md bg-white/90 backdrop-blur-xl border border-slate-200/80 rounded-3xl p-8 shadow-xl shadow-slate-200/50 space-y-6">
        <!-- Title & Subtitle -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-50 border border-blue-100 rounded-2xl shadow-sm mb-2 text-blue-600">
                <span class="text-2xl">🔐</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang Kembali!</h2>
            <p class="text-xs text-slate-500">Masukkan akun Anda untuk melanjutkan belanja & kelola pesanan</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-emerald-600 text-xs font-semibold text-center" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Alamat Email
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">✉️</span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">🔑</span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition">
                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 text-xs">
                        👁️
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600 font-semibold" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-50 border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="ms-2 text-xs font-medium text-slate-600">Ingat Saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-blue-500/25 transition transform hover:-translate-y-0.5">
                Masuk Ke Akun ➔
            </button>
        </form>

        <!-- Quick Demo Login Helpers for Assessment/Testing -->
        <div class="pt-4 border-t border-slate-200/80 space-y-2">
            <span class="block text-[11px] font-bold text-slate-400 uppercase text-center tracking-wider">Tombol Cepat Demo (Uji Coba)</span>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="fillDemoCredentials('admin@wahyugadget.com', 'password')"
                    class="py-2 px-3 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-xs font-bold transition text-center flex items-center justify-center gap-1 shadow-sm">
                    <span>🔑</span> Admin Demo
                </button>
                <button type="button" onclick="fillDemoCredentials('customer@example.com', 'password')"
                    class="py-2 px-3 bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200 rounded-xl text-xs font-bold transition text-center flex items-center justify-center gap-1 shadow-sm">
                    <span>🛒</span> Customer Demo
                </button>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function fillDemoCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</x-guest-layout>
