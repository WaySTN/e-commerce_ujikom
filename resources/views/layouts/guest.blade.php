<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Masuk / Daftar — Wahyu Gadget Pedia' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col justify-between relative overflow-x-hidden selection:bg-blue-500 selection:text-white">

    <!-- Background Subtle Ambient Soft Glow -->
    <div class="fixed -top-40 -left-40 w-96 h-96 bg-blue-400/10 rounded-full blur-[128px] pointer-events-none z-0"></div>
    <div class="fixed -bottom-40 -right-40 w-96 h-96 bg-cyan-400/10 rounded-full blur-[128px] pointer-events-none z-0"></div>

    <!-- Light Glassmorphism Sticky Navbar (Seragam dengan Halaman Utama Katalog) -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 text-slate-900 sticky top-0 z-50 transition-all duration-300 shadow-sm shadow-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                <!-- Brand Logo Image -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group py-1">
                    <img src="{{ asset('images/logo.png') }}" alt="Wahyu Gadget Pedia" class="h-11 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
                    <div class="hidden sm:block">
                        <span class="block text-base font-extrabold text-slate-900 tracking-tight leading-none">Wahyu Gadget</span>
                        <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest block mt-0.5">Pedia Store</span>
                    </div>
                </a>

                <!-- Nav Menu & Actions -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition flex items-center gap-1.5">
                        <span>📱</span> Katalog
                    </a>

                    <!-- Cart Icon with Live Counter -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'qty'));
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-slate-700 hover:text-blue-600 hover:bg-slate-100 transition rounded-xl bg-slate-100/80 border border-slate-200/80 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-blue-600 text-white font-extrabold text-[11px] w-5 h-5 rounded-full flex items-center justify-center shadow-md animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Auth Action Buttons -->
                    <div class="flex items-center gap-2 pl-3 border-l border-slate-200">
                        <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-blue-600 px-3.5 py-2 rounded-xl hover:bg-slate-100 transition {{ request()->routeIs('login') ? 'bg-slate-100 text-blue-600' : '' }}">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-xs font-extrabold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-md shadow-blue-500/20 transition">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="relative z-10 flex-grow flex items-center justify-center p-4 sm:p-6 w-full my-6">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-6 py-6 text-center text-xs text-slate-500 border-t border-slate-200">
        <p>Wahyu Gadget Pedia &copy; {{ date('Y') }} · Uji Kompetensi BNSP Junior Web Programming</p>
    </footer>

</body>
</html>
