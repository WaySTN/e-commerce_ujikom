<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | Wahyu Gadget Pedia</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6 antialiased selection:bg-blue-500 selection:text-white">
    <div class="max-w-md w-full text-center space-y-6 bg-slate-950 border border-slate-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="w-20 h-20 bg-blue-500/10 text-blue-400 border border-blue-500/30 rounded-3xl mx-auto flex items-center justify-center text-4xl shadow-inner">
            🔍
        </div>

        <div class="space-y-2">
            <span class="text-xs font-bold text-cyan-400 uppercase tracking-widest bg-cyan-500/10 px-3 py-1 rounded-full border border-cyan-500/20">Error 404 — Not Found</span>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Halaman Tidak Ditemukan</h1>
            <p class="text-xs text-slate-400 leading-relaxed">
                Tautan yang Anda tuju mungkin sudah dipindahkan, dihapus, atau tidak pernah ada sebelumnya.
            </p>
        </div>

        <div class="pt-4 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl transition shadow-lg shadow-blue-600/30">
                🏠 Ke Katalog Utama
            </a>
            <a href="javascript:history.back()" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-xs rounded-xl transition">
                ← Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
