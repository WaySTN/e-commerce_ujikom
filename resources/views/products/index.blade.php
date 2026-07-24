<x-app-layout>
    <x-slot name="title">Wahyu Gadget Pedia — Toko Aksesori Gadget Terlengkap</x-slot>

    <!-- Animated Gadget Hero Slider (3 Banners) -->
    <div x-data="{
            activeSlide: 0,
            slides: [
                {
                    title: 'Wahyu Gadget Pedia',
                    badge: '⚡ Promo Aksesori Charger & Powerbank',
                    subtitle: 'Fast Charger 65W GaN, Kabel Data Braided & Powerbank Kapasitas Besar Garansi Resmi.',
                    image: '{{ asset('images/banner1.png') }}',
                    link: '?category=kabel-charger'
                },
                {
                    title: 'Suara Jernih & Extra Bass',
                    badge: '🎧 Collection TWS & Headset Gaming',
                    subtitle: 'Nikmati kualitas audio definisi tinggi dengan fitur Noise Cancelling & Bluetooth 5.3.',
                    image: '{{ asset('images/banner2.png') }}',
                    link: '?category=audio-earphone'
                },
                {
                    title: 'Pelindung Gadget Premium',
                    badge: '🛡️ Casing & Tempered Glass Anti-Drop',
                    subtitle: 'Lindungi smartphone kesayangan Anda dengan Clear Case Hybrid & Tempered Glass Anti-Spy.',
                    image: '{{ asset('images/banner3.png') }}',
                    link: '?category=casing-pelindung'
                }
            ],
            next() {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            },
            prev() {
                this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
            },
            timer: null
        }"
        x-init="timer = setInterval(() => next(), 4500)"
        @mouseenter="clearInterval(timer)"
        @mouseleave="timer = setInterval(() => next(), 4500)"
        class="relative w-full rounded-3xl overflow-hidden shadow-2xl border border-slate-800 mb-10 bg-slate-950 group">

        <!-- Slide Track Wrapper -->
        <div class="relative min-h-[280px] sm:min-h-[360px] w-full overflow-hidden">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index"
                    x-transition:enter="transform transition ease-out duration-700"
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transform transition ease-in duration-700"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="-translate-x-full opacity-0"
                    class="absolute inset-0 w-full h-full flex items-center justify-between p-8 sm:p-12">
                    
                    <!-- Background Banner Image with Dark Overlay -->
                    <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover opacity-45 mix-blend-luminosity">
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-transparent"></div>

                    <!-- Slide Text Content -->
                    <div class="relative z-10 max-w-xl space-y-3">
                        <span class="inline-block bg-blue-500/20 text-cyan-300 border border-blue-500/30 text-xs font-bold px-3.5 py-1.5 rounded-full backdrop-blur shadow-sm"
                            x-text="slide.badge"></span>
                        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight"
                            x-text="slide.title"></h1>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed"
                            x-text="slide.subtitle"></p>
                        <div class="pt-2">
                            <a :href="slide.link" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-extrabold text-xs sm:text-sm px-6 py-3 rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5">
                                Belanja Kategori Ini ➔
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Previous Button (⬅) -->
        <button @click="prev()" type="button"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-2xl bg-slate-900/80 backdrop-blur border border-slate-700 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-blue-600 transition duration-300 shadow-lg">
            ❮
        </button>

        <!-- Next Button (➔) -->
        <button @click="next()" type="button"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-2xl bg-slate-900/80 backdrop-blur border border-slate-700 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-blue-600 transition duration-300 shadow-lg">
            ❯
        </button>

        <!-- Dot Navigation Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 bg-slate-950/60 backdrop-blur px-3 py-1.5 rounded-full border border-slate-800">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" type="button"
                    :class="activeSlide === index ? 'w-6 bg-cyan-400' : 'w-2 bg-slate-600 hover:bg-slate-400'"
                    class="h-2 rounded-full transition-all duration-300"></button>
            </template>
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
