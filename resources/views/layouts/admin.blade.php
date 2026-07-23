<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel — Wahyu Gadget Pedia' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col min-h-screen sticky top-0">
        <!-- Sidebar Brand -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800 gap-2">
            <span class="bg-blue-600 text-white p-1.5 rounded-lg text-base">⚡</span>
            <div>
                <h1 class="font-bold text-base text-white tracking-wide">Wahyu Gadget</h1>
                <p class="text-[10px] text-cyan-400 font-semibold uppercase tracking-widest">Admin Control Panel</p>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <span>📊</span> Dashboard
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <span>🏷️</span> Kelola Kategori
            </a>

            <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.produk.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <span>📦</span> Kelola Produk
            </a>

            <a href="{{ route('admin.pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.pesanan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <span>🛒</span> Kelola Order
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <span>📈</span> Laporan Penjualan
            </a>
        </nav>

        <!-- Sidebar Footer Link to Store -->
        <div class="p-4 border-t border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-cyan-400 border border-slate-800 transition">
                <span>🌐</span> Lihat Toko Storefront
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Bar -->
        <header class="h-16 bg-slate-950/80 backdrop-blur border-b border-slate-800 px-8 flex items-center justify-between sticky top-0 z-40">
            <h2 class="font-semibold text-lg text-white">{{ $header ?? 'Dashboard' }}</h2>

            <div class="flex items-center gap-4">
                <span class="text-xs bg-slate-800 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700 font-medium">
                    👤 {{ auth()->user()->name }} (Admin)
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 px-3 py-1.5 rounded-lg transition font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-8 mt-4">
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                    <span>✅</span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
                    <span>⚠️</span>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="p-8 flex-1">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
