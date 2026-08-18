<x-app-layout>
    <x-slot name="title">Detail Pesanan {{ $order->order_number }} — Wahyu Gadget Pedia</x-slot>

    <!-- Print Stylesheet -->
    <style>
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            header, footer, nav, button, form, .no-print {
                display: none !important;
            }
            main {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .screen-only {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .invoice-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            .invoice-table th, .invoice-table td {
                border: 1px solid #cbd5e1 !important;
                padding: 8px 10px !important;
                color: #0f172a !important;
                font-size: 12px !important;
            }
            .invoice-table th {
                background-color: #f1f5f9 !important;
                font-weight: bold !important;
            }
        }
        @media screen {
            .print-only {
                display: none;
            }
        }
    </style>

    <!-- ======================================================= -->
    <!-- PRINT-ONLY DEDICATED OFFICIAL INVOICE (Visible on Print) -->
    <!-- ======================================================= -->
    <div class="print-only p-6 bg-white text-slate-900 font-sans">
        <!-- Letterhead / Header Invoice -->
        <div class="flex justify-between items-start border-b-2 border-slate-900 pb-6 mb-6">
            <div>
                <h1 class="text-2xl font-extrabold uppercase tracking-wide text-slate-900">Wahyu Gadget Pedia</h1>
                <p class="text-xs text-slate-600 mt-1">Pusat Belanja Aksesori Gadget & Elektronik Terlengkap</p>
                <p class="text-xs text-slate-500">Skema Uji Kompetensi BNSP: Junior Web Programming</p>
            </div>
            <div class="text-right">
                <span class="inline-block bg-slate-900 text-white font-extrabold text-xs px-3 py-1 uppercase tracking-widest rounded mb-1">
                    NOTA / INVOICE PEMBELIAN
                </span>
                <h2 class="text-lg font-extrabold text-slate-900">{{ $order->order_number }}</h2>
                <p class="text-xs text-slate-500">Tanggal: {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Info Penerima & Pembayaran Grid -->
        <div class="grid grid-cols-2 gap-6 mb-6 p-4 bg-slate-50 border border-slate-200 rounded-lg text-xs">
            <div>
                <span class="font-bold text-slate-500 uppercase tracking-wider block mb-1">Tujuan Pengiriman:</span>
                <p class="font-bold text-slate-900 text-sm">{{ $order->user->name }}</p>
                <p class="text-slate-600">{{ $order->user->email }}</p>
                <p class="text-slate-800 font-medium whitespace-pre-line mt-2">{{ $order->shipping_address }}</p>
                @if($order->notes)
                    <p class="text-slate-500 italic mt-1">Catatan: "{{ $order->notes }}"</p>
                @endif
            </div>

            <div class="text-right">
                <span class="font-bold text-slate-500 uppercase tracking-wider block mb-1">Informasi Transaksi:</span>
                <p class="text-slate-700">Metode Pembayaran: <strong class="uppercase text-slate-900">{{ $order->payment?->method ?? '-' }}</strong></p>
                <p class="text-slate-700 mt-1">Status Pembayaran: <strong class="uppercase text-slate-900">{{ $order->payment?->status ?? 'menunggu' }}</strong></p>
                <p class="text-slate-700 mt-1">Status Pesanan: <strong class="uppercase text-slate-900">{{ $order->status }}</strong></p>
                @if($order->payment?->paid_at)
                    <p class="text-slate-500 text-[11px] mt-1">Waktu Lunas: {{ $order->payment->paid_at->format('d/m/Y H:i') }} WIB</p>
                @endif
            </div>
        </div>

        <!-- Table Ordered Items -->
        <table class="invoice-table mb-6">
            <thead>
                <tr>
                    <th class="text-center w-12">No.</th>
                    <th class="text-left">Nama Produk</th>
                    <th class="text-right w-32">Harga Satuan</th>
                    <th class="text-center w-20">Qty</th>
                    <th class="text-right w-36">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong class="text-slate-900">{{ $item->product_name }}</strong>
                        </td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-center font-bold">{{ $item->qty }}</td>
                        <td class="text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right font-bold text-slate-700">Total Tagihan:</td>
                    <td class="text-right font-extrabold text-slate-900 text-sm">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Invoice Signatures & Footer -->
        <div class="mt-8 pt-6 border-t border-slate-300 flex justify-between text-xs text-slate-700">
            <div class="text-center w-48">
                <p>Penerima / Pembeli,</p>
                <div class="h-16"></div>
                <p class="font-bold border-b border-slate-800 pb-1">{{ $order->user->name }}</p>
            </div>

            <div class="text-center w-48">
                <p>Wahyu Gadget Pedia,</p>
                <div class="h-16"></div>
                <p class="font-bold border-b border-slate-800 pb-1">Layanan Pelanggan</p>
            </div>
        </div>

        <div class="text-center text-[10px] text-slate-400 mt-8">
            <p>Terima kasih telah berbelanja di Wahyu Gadget Pedia. Simpan invoice ini sebagai bukti pembelian yang sah.</p>
        </div>
    </div>

    <!-- ======================================================= -->
    <!-- SCREEN-ONLY INTERACTIVE CUSTOMER VIEW (Visible on Browser) -->
    <!-- ======================================================= -->
    <div class="screen-only">
        <!-- Navigation Back & Print Action -->
        <div class="no-print flex items-center justify-between mb-6">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 transition">
                ← Kembali ke Pesanan Saya
            </a>

            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                <span>🖨️</span> Cetak Invoice
            </button>
        </div>

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

                    <!-- Customer Details & Shipping Address -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Penerima Pesanan</h3>
                            <p class="text-sm font-bold text-slate-900">{{ $order->user->name ?? 'Customer' }}</p>
                            <p class="text-xs text-slate-500">{{ $order->user->email ?? '' }}</p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Alamat Pengiriman</h3>
                            <p class="text-xs font-semibold text-slate-800 whitespace-pre-line bg-slate-50 p-3 rounded-xl border border-slate-200">
                                {{ $order->shipping_address }}
                            </p>
                            @if($order->notes)
                                <p class="text-xs text-slate-500 mt-1"><strong>Catatan:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
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

                            <!-- Proof Upload Form with SweetAlert2 Confirmation -->
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
                                    <form method="POST" action="{{ route('orders.bukti-bayar', $order->id) }}" enctype="multipart/form-data" class="space-y-3" onsubmit="event.preventDefault(); confirmUploadProof(this);">
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
    </div>
</x-app-layout>
