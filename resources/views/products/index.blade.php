<x-app-layout>
    <x-slot name="title">Wahyu Gadget Pedia — Toko Aksesori Gadget Terlengkap</x-slot>

    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 text-white rounded-3xl p-8 sm:p-12 mb-10 overflow-hidden shadow-2xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block bg-blue-500/20 text-cyan-300 border border-blue-500/30 text-xs font-semibold px-3.5 py-1 rounded-full mb-4">
                ⚡ Aksesori Original & Garansi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Wahyu Gadget Pedia
            </h1>
            <p class="text-slate-300 mt-3 text-base sm:text-lg">
                Pusat belanja kebutuhan gadget terlengkap — Casing, Charger, Earphone, Powerbank & Aksesori HP berkualitas tinggi.
            </p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 mb-8">
        <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari charger, casing, earphone..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <span class="absolute left-3 top-3 text-slate-400 text-sm">🔍</span>
            </div>

            <!-- Category Filter -->
            <div class="md:w-64">
                <select name="category" onchange="this.form.submit()"
                    class="w-full py-2.5 px-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                Filter
            </button>
            @if(request('search') || request('category'))
                <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-4 py-2.5 rounded-xl transition flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Products Grid -->
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-900">Daftar Aksesori</h2>
        <span class="text-xs text-slate-500 font-medium">Menampilkan {{ $products->total() }} produk</span>
    </div>

    @if($products->isEmpty())
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-sm my-8">
            <span class="text-5xl block mb-3">📱</span>
            <h3 class="text-lg font-bold text-slate-800">Produk Tidak Ditemukan</h3>
            <p class="text-sm text-slate-500 mt-1">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 text-sm font-semibold text-blue-600 hover:underline">
                Lihat Semua Produk
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                    <!-- Image Thumbnail -->
                    <a href="{{ route('products.show', $product->slug) }}" class="relative aspect-square bg-slate-100 overflow-hidden block">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                <span class="text-4xl">🔌</span>
                            </div>
                        @endif

                        @if($product->category)
                            <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur text-cyan-300 text-[11px] font-semibold px-2.5 py-1 rounded-lg">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </a>

                    <!-- Product Info -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-slate-900 text-base hover:text-blue-600 transition line-clamp-2">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                {{ Str::limit($product->description, 80, '...') ?? 'Aksesori berkualitas untuk gadget kesayangan Anda.' }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 font-medium block">Harga</span>
                                <span class="text-base font-extrabold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="text-right">
                                <span class="text-xs font-semibold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                    {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                                </span>
                            </div>
                        </div>

                        <!-- Add to Cart Form -->
                        <form method="POST" action="{{ route('cart.store', $product->id) }}" class="mt-4">
                            @csrf
                            <button type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}
                                class="w-full py-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-2 transition shadow-sm {{ $product->stock > 0 ? 'bg-slate-900 hover:bg-blue-600 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}">
                                <span>🛒</span> {{ $product->stock > 0 ? '+ Keranjang' : 'Stok Habis' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @endif
</x-app-layout>
