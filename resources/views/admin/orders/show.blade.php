<x-admin-layout>
    <x-slot name="header">Detail & Verifikasi Pesanan {{ $order->order_number }}</x-slot>

    <a href="{{ route('admin.pesanan.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white mb-6">
        ← Kembali ke Daftar Pesanan
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order & Items Detail (Left Column) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Summary Card -->
            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-800 pb-4 gap-2">
                    <div>
                        <span class="text-xs font-bold text-cyan-400 uppercase tracking-wider block">No. Invoice</span>
                        <h2 class="text-2xl font-extrabold text-white">{{ $order->order_number }}</h2>
                        <span class="text-xs text-slate-400 block mt-0.5">Tanggal: {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <div class="text-right">
                        <span class="text-xs text-slate-400 block font-medium">Customer</span>
                        <span class="font-bold text-white text-base block">{{ $order->user->name }}</span>
                        <span class="text-xs text-slate-400">{{ $order->user->email }}</span>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Pengiriman</h4>
                    <p class="text-sm text-slate-200 whitespace-pre-line bg-slate-900 p-4 rounded-2xl border border-slate-800">
                        {{ $order->shipping_address }}
                    </p>
                    @if($order->notes)
                        <p class="text-xs text-slate-400 mt-2"><strong>Catatan:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Items List -->
            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
                <h3 class="font-extrabold text-white text-lg border-b border-slate-800 pb-4 mb-4">
                    Item Produk Pesanan
                </h3>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between pb-4 border-b border-slate-800 last:border-b-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-900 rounded-xl overflow-hidden flex-shrink-0 border border-slate-800">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-500 text-xs">🔌</div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">{{ $item->product_name }}</h4>
                                    <span class="text-xs text-slate-400">
                                        {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <span class="font-extrabold text-sm text-cyan-400">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Controls & Verification (Right Column) -->
        <div class="space-y-6">
            <!-- Order Status Update Box -->
            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
                <h3 class="font-extrabold text-white text-lg border-b border-slate-800 pb-3 flex items-center gap-2">
                    <span>📦</span> Status Pesanan
                </h3>

                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-400">Status Saat Ini</span>
                    <span class="font-bold text-amber-400 bg-amber-500/10 px-3 py-1 rounded-xl border border-amber-500/30">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                @if(!in_array($order->status, ['selesai', 'dibatalkan']))
                    <form method="POST" action="{{ route('admin.pesanan.update-status', $order->id) }}" class="space-y-3 pt-3 border-t border-slate-800" onsubmit="event.preventDefault(); confirmStatusUpdate(this, this.status.value);">
                        @csrf
                        @method('PATCH')
                        <label for="status" class="block text-xs font-bold text-slate-300 uppercase">Ubah Status Order:</label>
                        <select id="status" name="status" class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-2.5 px-3 text-xs focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>

                        <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl transition shadow-lg shadow-blue-600/30">
                            Update Status Order
                        </button>
                    </form>
                @else
                    <p class="text-xs text-slate-500 italic pt-2 border-t border-slate-800">
                        Pesanan ini sudah berstatus final ({{ $order->status }}) dan tidak dapat diubah lagi.
                    </p>
                @endif
            </div>

            <!-- Payment Verification Box -->
            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
                <h3 class="font-extrabold text-white text-lg border-b border-slate-800 pb-3 flex items-center gap-2">
                    <span>💳</span> Verifikasi Pembayaran
                </h3>

                @if($order->payment)
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Metode</span>
                            <span class="font-bold text-white uppercase">{{ $order->payment->method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Status Pembayaran</span>
                            <span class="font-bold text-cyan-400">{{ ucfirst($order->payment->status) }}</span>
                        </div>
                    </div>

                    <!-- Payment Proof Image if Transfer -->
                    @if($order->payment->method === 'transfer')
                        <div class="pt-3 border-t border-slate-800">
                            <span class="block text-xs font-bold text-slate-300 uppercase mb-2">Bukti Transfer Customer:</span>
                            @if($order->payment->proof_image)
                                <a href="{{ asset('storage/' . $order->payment->proof_image) }}" target="_blank" class="block aspect-video bg-slate-900 rounded-xl overflow-hidden border border-slate-800 hover:border-blue-500 transition">
                                    <img src="{{ asset('storage/' . $order->payment->proof_image) }}" class="w-full h-full object-cover">
                                </a>
                            @else
                                <p class="text-xs text-amber-400 bg-amber-500/10 p-3 rounded-xl border border-amber-500/30">
                                    Customer belum mengunggah bukti transfer.
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Verification Buttons Form -->
                    <div class="pt-4 border-t border-slate-800 flex gap-3">
                        <form method="POST" action="{{ route('admin.pesanan.verifikasi-bayar', $order->id) }}" class="flex-1" onsubmit="event.preventDefault(); confirmPayment(this, 'LUNAS');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="payment_status" value="lunas">
                            <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl transition shadow-lg shadow-emerald-600/30">
                                ✅ Verifikasi LUNAS
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.pesanan.verifikasi-bayar', $order->id) }}" class="flex-1" onsubmit="event.preventDefault(); confirmPayment(this, 'DITOLAK');">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="payment_status" value="ditolak">
                            <button type="submit" class="w-full py-2.5 bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs rounded-xl transition shadow-lg shadow-rose-600/30">
                                ❌ Tolak Bayar
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
