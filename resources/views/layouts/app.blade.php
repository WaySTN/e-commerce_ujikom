<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Wahyu Gadget Pedia — Toko Aksesori Gadget Terlengkap' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-slate-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl tracking-tight text-white hover:text-cyan-400 transition">
                    <span class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white p-2 rounded-xl text-lg shadow-lg">⚡</span>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-cyan-300 to-white">
                        Wahyu Gadget Pedia
                    </span>
                </a>

                <!-- Nav Menu & Actions -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-300 hover:text-white transition">Katalog</a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-amber-500/20 text-amber-300 border border-amber-500/30 px-3 py-1.5 rounded-lg font-semibold hover:bg-amber-500/30 transition">
                                🔑 Panel Admin
                            </a>
                        @else
                            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-slate-300 hover:text-white transition">
                                Pesanan Saya
                            </a>
                        @endif
                    @endauth

                    <!-- Cart Icon -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'qty'));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-300 hover:text-white transition rounded-lg bg-slate-800 hover:bg-slate-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-cyan-500 text-slate-950 font-extrabold text-xs w-5 h-5 rounded-full flex items-center justify-center shadow-md animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Auth Dropdown / Buttons -->
                    @auth
                        <div class="relative flex items-center gap-3 pl-2 border-l border-slate-700">
                            <span class="text-sm font-medium text-slate-200 hidden sm:inline">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs bg-slate-800 hover:bg-red-600/30 text-slate-300 hover:text-red-300 border border-slate-700 px-3 py-1.5 rounded-lg transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2 pl-2 border-l border-slate-700">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-white px-3 py-1.5 rounded-lg hover:bg-slate-800 transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="text-sm font-semibold bg-blue-600 hover:bg-blue-500 text-white px-4 py-1.5 rounded-lg shadow-sm transition">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-lg">✅</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-700 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-lg">⚠️</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 text-slate-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <p class="font-semibold text-slate-300">Wahyu Gadget Pedia &copy; {{ date('Y') }}</p>
            <p class="text-xs text-slate-500 mt-1">Uji Kompetensi BNSP Junior Web Programming</p>
        </div>
    </footer>

</body>
</html>
