<x-app-layout>
    <x-slot name="title">Detail Pesanan {{ $order->order_number }} — Wahyu Gadget Pedia</x-slot>

    <!-- Navigation Back -->
    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 mb-6">
        ← Kembali ke Pesanan Saya
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order & Items Detail (Left Column) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Information -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-100 pb-4 gap-2">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">No. Invoice</span>
                        <h1 class="text-2xl font-extrabold text-slate-900">{{ $order->order_number }}</h1>
                        <span class="text-xs text-slate-400 block mt-0.5">Dibuat pada: {{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <!-- Status Order -->
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'diproses' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'dikirim' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
                                'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'dibatalkan' => 'bg-rose-100 text-rose-800 border-rose-300',
                            ];
                        @endphp
                        <span class="text-xs font-bold px-3.5 py-1.5 rounded-full border {{ $statusColors[$order->status] }}">
                            Status Order: {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="pt-2">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Alamat Pengiriman</h3>
                    <p class="text-sm font-semibold text-slate-800 whitespace-pre-line bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        {{ $order->shipping_address }}
                    </p>
                    @if($order->notes)
                        <p class="text-xs text-slate-500 mt-2"><strong>Catatan:</strong> {{ $order->notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Ordered Items List -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-4 mb-4">
                    Item Produk Pesanan
                </h3>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 last:border-b-0 last:pb-0">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">🔌</div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $item->product_name }}</h4>
                                    <span class="text-xs text-slate-500">
                                        {{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <span class="font-extrabold text-sm text-slate-900">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Payment Info & Proof Upload (Right Column) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>💳</span> Status Pembayaran
                </h3>

                @if($order->payment)
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Metode</span>
                            <span class="font-bold uppercase text-slate-900">{{ $order->payment->method }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500">Status Pembayaran</span>
                            @php
                                $payColors = [
                                    'menunggu' => 'text-amber-600 bg-amber-50',
                                    'lunas' => 'text-emerald-600 bg-emerald-50',
                                    'ditolak' => 'text-rose-600 bg-rose-50',
                                ];
                            @endphp
                            <span class="font-extrabold px-2.5 py-0.5 rounded-lg text-xs {{ $payColors[$order->payment->status] }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </div>

                        <div class="flex justify-between pt-3 border-t border-slate-100">
                            <span class="font-bold text-slate-900">Total Tagihan</span>
                            <span class="font-extrabold text-lg text-blue-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Instructions for Transfer -->
                    @if($order->payment->method === 'transfer')
                        <div class="mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs space-y-2">
                            <p class="font-bold text-slate-900">Instruksi Transfer Bank:</p>
                            <p class="text-slate-600">Bank BCA: <strong>123-456-7890</strong><br>a.n. <strong>Wahyu Gadget Pedia</strong></p>
                        </div>

                        <!-- Proof Upload Form -->
                        <div class="pt-4 border-t border-slate-100">
                            <h4 class="font-bold text-slate-900 text-xs uppercase mb-2">Upload Bukti Transfer</h4>

                            @if($order->payment->proof_image)
                                <div class="mb-3">
                                    <span class="text-[11px] text-slate-500 block mb-1 font-semibold">Bukti Terunggah:</span>
                                    <a href="{{ asset('storage/' . $order->payment->proof_image) }}" target="_blank" class="block aspect-video bg-slate-100 rounded-xl overflow-hidden border border-slate-200 hover:opacity-90">
                                        <img src="{{ asset('storage/' . $order->payment->proof_image) }}" class="w-full h-full object-cover">
                                    </a>
                                </div>
                            @endif

                            @if($order->payment->status !== 'lunas')
                                <form method="POST" action="{{ route('orders.bukti-bayar', $order->id) }}" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <input type="file" name="proof_image" accept="image/jpeg,image/png,image/jpg" required
                                        class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @error('proof_image')
                                        <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                                    @enderror

                                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-sm">
                                        Upload Bukti Bayar
                                    </button>
                                </form>
                            @else
                                <p class="text-xs text-emerald-600 font-bold bg-emerald-50 p-3 rounded-xl border border-emerald-200 text-center">
                                    Pembayaran Anda Telah Dikonfirmasi Lunas oleh Admin 🎉
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-200 text-xs text-amber-800">
                            <strong>Info COD:</strong> Pembayaran dilakukan secara tunai langsung kepada kurir saat barang diantarkan ke alamat Anda.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
