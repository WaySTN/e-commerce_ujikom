<x-app-layout>
    <x-slot name="title">Keranjang Belanja — Wahyu Gadget Pedia</x-slot>

    <h1 class="text-2xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
        <span>🛒</span> Keranjang Belanja Anda
    </h1>

    @if(empty($cart))
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm my-8">
            <span class="text-6xl block mb-4">🛒</span>
            <h2 class="text-xl font-bold text-slate-800">Keranjang Belanja Masih Kosong</h2>
            <p class="text-sm text-slate-500 mt-1">Anda belum menambahkan produk aksesori ke dalam keranjang.</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                Mulai Belanja Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-16 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">🔌</div>
                                @endif
                            </div>

                            <div>
                                <a href="{{ route('products.show', $item['slug']) }}" class="font-bold text-slate-900 hover:text-blue-600 text-sm">
                                    {{ $item['name'] }}
                                </a>
                                <p class="text-xs text-slate-500 mt-0.5">Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Quantity Update & Subtotal & Delete -->
                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                            <!-- Qty Form -->
                            <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="{{ $item['stock'] }}"
                                    class="w-16 py-1.5 px-2 border border-slate-300 rounded-lg text-center text-xs font-bold focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-2.5 py-1.5 rounded-lg transition">
                                    Update
                                </button>
                            </form>

                            <!-- Subtotal -->
                            <div class="text-right">
                                <span class="text-xs text-slate-400 block font-medium">Subtotal</span>
                                <span class="text-sm font-extrabold text-blue-600">
                                    Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Remove Form with SweetAlert2 Modal -->
                            <form method="POST" action="{{ route('cart.destroy', $id) }}" onsubmit="event.preventDefault(); confirmCartDelete(this, '{{ addslashes($item['name']) }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 p-2 rounded-lg hover:bg-rose-50 transition" title="Hapus">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cart Summary Box -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm h-fit space-y-6">
                <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-4">Ringkasan Belanja</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Item</span>
                        <span class="font-bold text-slate-900">{{ array_sum(array_column($cart, 'qty')) }} item</span>
                    </div>

                    <div class="flex justify-between text-slate-600 pt-3 border-t border-slate-100">
                        <span class="font-bold text-slate-900">Total Tagihan</span>
                        <span class="font-extrabold text-xl text-blue-600">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-extrabold text-sm rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 transition">
                    Lanjut ke Checkout ➔
                </a>

                <a href="{{ route('home') }}" class="block text-center text-xs font-semibold text-slate-500 hover:text-blue-600">
                    ← Tambah Produk Lain
                </a>
            </div>
        </div>
    @endif
</x-app-layout>
