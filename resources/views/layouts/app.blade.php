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
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col selection:bg-blue-500 selection:text-white">

    <!-- Light Glassmorphism Navbar (Semi-Transparan Blur saat scroll) -->
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

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-xs bg-amber-500/10 hover:bg-amber-500/20 text-amber-700 border border-amber-500/30 px-3.5 py-2 rounded-xl font-bold transition flex items-center gap-1.5 shadow-sm">
                                <span>🔑</span> Panel Admin
                            </a>
                        @else
                            <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 transition flex items-center gap-1.5">
                                <span>📦</span> Pesanan Saya
                            </a>
                        @endif
                    @endauth

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

                    <!-- Auth Dropdown / Action Buttons -->
                    @auth
                        <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                            <div class="hidden sm:block text-right">
                                <span class="text-xs font-bold text-slate-900 block">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] text-blue-600 block uppercase font-bold">{{ auth()->user()->role }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 px-3 py-2 rounded-xl transition font-bold">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2 pl-3 border-l border-slate-200">
                            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-blue-600 px-3.5 py-2 rounded-xl hover:bg-slate-100 transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="text-xs font-extrabold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow-md shadow-blue-500/20 transition">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-lg">✅</span>
                    <span class="text-xs font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl mb-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-lg">⚠️</span>
                    <span class="text-xs font-bold">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        {{ $slot }}
    </main>

    <!-- Premium Light Footer -->
    <footer class="bg-white border-t border-slate-200/80 text-slate-600 py-12 mt-16 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-200">
                <!-- Column 1: Brand Info -->
                <div class="space-y-3 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Wahyu Gadget Pedia" class="h-10 w-auto object-contain">
                        <div>
                            <span class="block text-base font-extrabold text-slate-900">Wahyu Gadget</span>
                            <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest block">Pedia Store</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pusat belanja kebutuhan gadget terlengkap — Casing, Charger, Earphone, Powerbank & Aksesori HP berkualitas tinggi dengan garansi resmi.
                    </p>
                </div>

                <!-- Column 2: Kategori Populer -->
                <div>
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Kategori Populer</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}?category=casing-pelindung" class="hover:text-blue-600 transition">📱 Casing & Pelindung</a></li>
                        <li><a href="{{ route('home') }}?category=kabel-charger" class="hover:text-blue-600 transition">⚡ Charger & Fast Cable</a></li>
                        <li><a href="{{ route('home') }}?category=audio-earphone" class="hover:text-blue-600 transition">🎧 Audio TWS & Headset</a></li>
                        <li><a href="{{ route('home') }}?category=powerbank-baterai" class="hover:text-blue-600 transition">🔋 Powerbank Kapasitas Besar</a></li>
                    </ul>
                </div>

                <!-- Column 3: Bantuan & Layanan -->
                <div>
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Layanan & Bantuan</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('orders.index') }}" class="hover:text-blue-600 transition">📦 Cek Status Pesanan</a></li>
                        <li><span class="text-slate-400">🚚 Pengiriman COD & Kurir Ekspres</span></li>
                        <li><span class="text-slate-400">🛡️ Garansi Produk Original</span></li>
                        <li><span class="text-slate-400">💬 Layanan Pelanggan 24/7</span></li>
                    </ul>
                </div>

                <!-- Column 4: Metode Pembayaran -->
                <div>
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Metode Pembayaran</h4>
                    <div class="flex flex-wrap gap-2 text-xs font-bold">
                        <span class="bg-slate-100 border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg">🏦 Transfer BCA</span>
                        <span class="bg-slate-100 border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg">🏦 Mandiri</span>
                        <span class="bg-slate-100 border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg">📲 QRIS</span>
                        <span class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-1.5 rounded-lg">💵 COD (Bayar di Tempat)</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & BNSP Tag -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>Wahyu Gadget Pedia &copy; {{ date('Y') }} — Seluruh Hak Cipta Dilindungi.</p>
                <span class="bg-slate-100 border border-slate-200 text-slate-600 px-3 py-1 rounded-full text-[11px] font-semibold">
                    🎓 Project Uji Kompetensi BNSP Junior Web Programming
                </span>
            </div>
        </div>
    </footer>

</body>
</html>
