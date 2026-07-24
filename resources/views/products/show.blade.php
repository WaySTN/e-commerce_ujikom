<x-app-layout>
    <x-slot name="title">{{ $product->name }} — Wahyu Gadget Pedia</x-slot>

    <!-- Breadcrumb -->
    <nav class="flex text-xs font-medium text-slate-500 mb-6 gap-2 items-center">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Katalog</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">{{ $product->name }}</span>
    </nav>

    <!-- Product Detail Container -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 mb-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <!-- Image Area -->
            <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden relative border border-slate-200">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                        <span class="text-6xl">🎧</span>
                    </div>
                @endif

                @if($product->category)
                    <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur text-cyan-300 text-xs font-bold px-3 py-1.5 rounded-xl">
                        {{ $product->category->name }}
                    </span>
                @endif
            </div>

            <!-- Details Area -->
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $product->name }}
                    </h1>

                    <div class="mt-4 flex items-baseline gap-4">
                        <span class="text-3xl font-extrabold text-blue-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-xs px-3 py-1 rounded-full font-bold {{ $product->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $product->stock > 0 ? 'Tersedia: ' . $product->stock . ' unit' : 'Stok Habis' }}
                        </span>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Deskripsi Produk</h3>
                        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'Aksesori gadget original dengan bahan berkualitas tinggi dan performa optimal untuk pemakaian harian.' }}
                        </p>
                    </div>
                </div>

                <!-- Add to Cart Form (Auth vs Guest) -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    @auth
                        <form method="POST" action="{{ route('cart.store', $product->id) }}" class="space-y-4">
                            @csrf
                            <div class="flex items-center gap-4">
                                <label for="qty" class="text-xs font-bold text-slate-700 uppercase">Jumlah:</label>
                                <input type="number" id="qty" name="qty" value="1" min="1" max="{{ $product->stock }}"
                                    class="w-20 py-2 px-3 border border-slate-300 rounded-xl text-center text-sm font-bold focus:ring-2 focus:ring-blue-500">
                            </div>

                            <button type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}
                                class="w-full py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition shadow-lg shadow-blue-600/20 {{ $product->stock > 0 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}">
                                <span class="text-lg">🛒</span> {{ $product->stock > 0 ? 'Tambah ke Keranjang Belanja' : 'Stok Produk Habis' }}
                            </button>
                        </form>
                    @else
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <label for="qty" class="text-xs font-bold text-slate-700 uppercase">Jumlah:</label>
                                <input type="number" id="qty" name="qty" value="1" min="1" max="{{ $product->stock }}"
                                    class="w-20 py-2 px-3 border border-slate-300 rounded-xl text-center text-sm font-bold focus:ring-2 focus:ring-blue-500">
                            </div>

                            <button type="button" onclick="promptLoginToCart(event)" {{ $product->stock < 1 ? 'disabled' : '' }}
                                class="w-full py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition shadow-lg shadow-blue-600/20 {{ $product->stock > 0 ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-slate-200 text-slate-400 cursor-not-allowed' }}">
                                <span class="text-lg">🛒</span> {{ $product->stock > 0 ? 'Tambah ke Keranjang Belanja' : 'Stok Produk Habis' }}
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-12">
            <h3 class="text-xl font-bold text-slate-900 mb-6">Produk Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex flex-col justify-between">
                        <a href="{{ route('products.show', $rel->slug) }}" class="aspect-square bg-slate-100 rounded-xl overflow-hidden block mb-3">
                            @if($rel->image)
                                <img src="{{ asset('storage/' . $rel->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">🔌</div>
                            @endif
                        </a>
                        <div>
                            <a href="{{ route('products.show', $rel->slug) }}" class="font-bold text-sm text-slate-900 hover:text-blue-600 line-clamp-1">
                                {{ $rel->name }}
                            </a>
                            <span class="text-xs font-extrabold text-blue-600 mt-1 block">
                                Rp {{ number_format($rel->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
