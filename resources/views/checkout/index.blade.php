<x-app-layout>
    <x-slot name="title">Checkout Pesanan — Wahyu Gadget Pedia</x-slot>

    <h1 class="text-2xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
        <span>📋</span> Checkout Pesanan
    </h1>

    <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8" onsubmit="event.preventDefault(); confirmCheckoutSubmit(this);">
        @csrf

        <!-- Shipping & Payment Details (Left Column) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer & Shipping Address -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4">
                <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>📍</span> Alamat Pengiriman
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Pemesan</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled
                        class="w-full py-2.5 px-4 bg-slate-100 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700">
                </div>

                <div>
                    <label for="shipping_address" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Alamat Lengkap Pengiriman <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="shipping_address" name="shipping_address" rows="3" required
                        placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kecamatan, kota, dan nomor HP aktif..."
                        class="w-full py-3 px-4 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Catatan Pengiriman (Opsional)
                    </label>
                    <input type="text" id="notes" name="notes" value="{{ old('notes') }}"
                        placeholder="Contoh: Titipkan di satpam / Warna casing hitam"
                        class="w-full py-2.5 px-4 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <!-- Payment Method Selection -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4">
                <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>💳</span> Pilih Metode Pembayaran
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Option Transfer -->
                    <label class="relative border-2 border-slate-200 rounded-2xl p-5 cursor-pointer hover:border-blue-500 transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50 block">
                        <input type="radio" name="payment_method" value="transfer" checked class="sr-only">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🏦</span>
                            <div>
                                <span class="font-bold text-sm text-slate-900 block">Transfer Bank</span>
                                <span class="text-xs text-slate-500">BCA/Mandiri/BRI (Manual Upload Bukti)</span>
                            </div>
                        </div>
                    </label>

                    <!-- Option COD -->
                    <label class="relative border-2 border-slate-200 rounded-2xl p-5 cursor-pointer hover:border-blue-500 transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50 block">
                        <input type="radio" name="payment_method" value="cod" class="sr-only">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">💵</span>
                            <div>
                                <span class="font-bold text-sm text-slate-900 block">COD (Cash on Delivery)</span>
                                <span class="text-xs text-slate-500">Bayar tunai saat kurir sampai</span>
                            </div>
                        </div>
                    </label>
                </div>
                @error('payment_method')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Order Summary (Right Column) -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm h-fit space-y-6">
            <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-4">Ringkasan Pesanan</h3>

            <!-- Item List -->
            <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                @foreach($cart as $item)
                    <div class="flex justify-between items-center text-xs text-slate-600 pb-2 border-b border-slate-100">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $item['name'] }}</span>
                            <span class="text-slate-400">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                        </div>
                        <span class="font-bold text-slate-900">
                            Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Total Price -->
            <div class="pt-3 border-t border-slate-200 flex justify-between items-center">
                <span class="font-bold text-slate-900">Total Pembayaran</span>
                <span class="font-extrabold text-xl text-blue-600">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>

            <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/30 transition">
                <span>✅</span> Buat Pesanan Sekarang
            </button>
        </div>
    </form>
</x-app-layout>
