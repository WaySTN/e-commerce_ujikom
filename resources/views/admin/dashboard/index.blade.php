<x-admin-layout>
    <x-slot name="header">Dashboard Analisa Bisnis & Penjualan</x-slot>

    <!-- Top KPI Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue Lunas -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-3xl flex items-center justify-between shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Pendapatan Lunas</span>
                <span class="text-2xl font-extrabold text-emerald-400 mt-1 block">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
                <span class="text-[11px] text-slate-500 block mt-1">Terverifikasi dari order lunas</span>
            </div>
            <div class="bg-emerald-600/20 text-emerald-400 p-3.5 rounded-2xl border border-emerald-500/30 text-2xl">
                💰
            </div>
        </div>

        <!-- Revenue This Month -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-3xl flex items-center justify-between shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Pendapatan Bulan Ini</span>
                <span class="text-2xl font-extrabold text-blue-400 mt-1 block">
                    Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}
                </span>
                <span class="text-[11px] text-slate-500 block mt-1">{{ now()->translatedFormat('F Y') }}</span>
            </div>
            <div class="bg-blue-600/20 text-blue-400 p-3.5 rounded-2xl border border-blue-500/30 text-2xl">
                📈
            </div>
        </div>

        <!-- Total & Pending Orders -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-3xl flex items-center justify-between shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Pesanan</span>
                <span class="text-2xl font-extrabold text-white mt-1 block">
                    {{ number_format($totalOrders) }} <span class="text-xs font-semibold text-slate-400">Order</span>
                </span>
                <span class="text-[11px] text-amber-400 font-semibold block mt-1">
                    ⚡ {{ number_format($pendingOrders) }} Order Pending
                </span>
            </div>
            <div class="bg-amber-600/20 text-amber-400 p-3.5 rounded-2xl border border-amber-500/30 text-2xl">
                🛒
            </div>
        </div>

        <!-- Total Products & Low Stock Warning -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-3xl flex items-center justify-between shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-cyan-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Katalog Produk</span>
                <span class="text-2xl font-extrabold text-cyan-400 mt-1 block">
                    {{ number_format($totalProducts) }} <span class="text-xs font-semibold text-slate-400">Item</span>
                </span>
                @if($lowStockProducts->count() > 0)
                    <span class="text-[11px] text-rose-400 font-semibold block mt-1">
                        ⚠️ {{ $lowStockProducts->count() }} Stok Menipis
                    </span>
                @else
                    <span class="text-[11px] text-emerald-400 font-semibold block mt-1">
                        ✅ Stok Aman
                    </span>
                @endif
            </div>
            <div class="bg-cyan-600/20 text-cyan-400 p-3.5 rounded-2xl border border-cyan-500/30 text-2xl">
                📦
            </div>
        </div>
    </div>

    <!-- Analytics Breakdown Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Order Status Breakdown Widget -->
        <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                <h3 class="font-extrabold text-white text-base flex items-center gap-2">
                    <span>📊</span> Analisa Status Pesanan
                </h3>
                <span class="text-xs text-slate-400 font-semibold">{{ $totalOrders }} Total Transaksi</span>
            </div>

            <div class="space-y-4">
                @php
                    $statusConfig = [
                        'pending' => ['label' => 'Pending (Menunggu Admin)', 'color' => 'bg-amber-500', 'text' => 'text-amber-400'],
                        'diproses' => ['label' => 'Diproses Admin', 'color' => 'bg-blue-500', 'text' => 'text-blue-400'],
                        'dikirim' => ['label' => 'Sedang Dikirim', 'color' => 'bg-cyan-500', 'text' => 'text-cyan-400'],
                        'selesai' => ['label' => 'Selesai', 'color' => 'bg-emerald-500', 'text' => 'text-emerald-400'],
                        'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'bg-rose-500', 'text' => 'text-rose-400'],
                    ];
                @endphp

                @foreach($statusConfig as $key => $cfg)
                    @php
                        $cnt = $orderStatusCounts[$key] ?? 0;
                        $pct = $totalOrders > 0 ? round(($cnt / $totalOrders) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-xs font-semibold mb-1">
                            <span class="text-slate-300">{{ $cfg['label'] }}</span>
                            <span class="{{ $cfg['text'] }} font-extrabold">{{ $cnt }} <span class="text-slate-500 font-normal">({{ $pct }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-900 rounded-full overflow-hidden border border-slate-800">
                            <div class="{{ $cfg['color'] }} h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Status Breakdown Widget -->
        <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                <h3 class="font-extrabold text-white text-base flex items-center gap-2">
                    <span>💳</span> Analisa Status Pembayaran
                </h3>
                @if($pendingPayments > 0)
                    <span class="text-xs bg-amber-500/20 text-amber-300 border border-amber-500/30 px-3 py-1 rounded-full font-bold animate-pulse">
                        ⚡ {{ $pendingPayments }} Butuh Verifikasi
                    </span>
                @endif
            </div>

            <div class="space-y-4">
                @php
                    $totalPayments = array_sum($paymentStatusCounts);
                    $paymentConfig = [
                        'menunggu' => ['label' => 'Menunggu Verifikasi Admin', 'color' => 'bg-amber-500', 'text' => 'text-amber-400'],
                        'lunas' => ['label' => 'Pembayaran LUNAS', 'color' => 'bg-emerald-500', 'text' => 'text-emerald-400'],
                        'ditolak' => ['label' => 'Pembayaran Ditolak', 'color' => 'bg-rose-500', 'text' => 'text-rose-400'],
                    ];
                @endphp

                @foreach($paymentConfig as $key => $cfg)
                    @php
                        $cnt = $paymentStatusCounts[$key] ?? 0;
                        $pct = $totalPayments > 0 ? round(($cnt / $totalPayments) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-xs font-semibold mb-1">
                            <span class="text-slate-300">{{ $cfg['label'] }}</span>
                            <span class="{{ $cfg['text'] }} font-extrabold">{{ $cnt }} <span class="text-slate-500 font-normal">({{ $pct }}%)</span></span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-900 rounded-full overflow-hidden border border-slate-800">
                            <div class="{{ $cfg['color'] }} h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Low Stock Alert & Top Selling Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Low Stock Alert Widget -->
        <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
            <h3 class="font-extrabold text-white text-base border-b border-slate-800 pb-4 mb-4 flex items-center justify-between">
                <span class="flex items-center gap-2">⚠️ Peringatan Stok Menipis</span>
                <span class="text-xs bg-rose-500/20 text-rose-300 px-2.5 py-0.5 rounded-full font-bold border border-rose-500/30">
                    <= 5 Unit
                </span>
            </h3>

            @if($lowStockProducts->isEmpty())
                <div class="text-center py-8">
                    <span class="text-3xl block mb-2">🎉</span>
                    <p class="text-xs font-bold text-emerald-400">Semua Stok Produk Aman!</p>
                    <p class="text-[11px] text-slate-500 mt-1">Tidak ada produk dengan stok di bawah 5 unit.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($lowStockProducts as $low)
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800 last:border-b-0 text-xs">
                            <div class="max-w-[70%]">
                                <span class="font-bold text-white block truncate">{{ $low->name }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $low->category->name ?? '-' }}</span>
                            </div>
                            <div class="text-right">
                                <span class="font-extrabold text-rose-400 block">{{ $low->stock }} unit</span>
                                <a href="{{ route('admin.produk.edit', $low->id) }}" class="text-[10px] text-cyan-400 hover:underline font-semibold">
                                    Tambah Stok ➔
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Top 5 Selling Products Widget -->
        <div class="lg:col-span-2 bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
            <h3 class="font-extrabold text-white text-base border-b border-slate-800 pb-4 mb-4 flex items-center gap-2">
                <span>🔥</span> Top 5 Produk Terlaris
            </h3>

            @if($topProducts->isEmpty())
                <p class="text-xs text-slate-500 text-center py-8">Belum ada data produk terpesan.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="text-slate-400 uppercase bg-slate-900 border-b border-slate-800">
                            <tr>
                                <th class="py-3 px-4">Peringkat</th>
                                <th class="py-3 px-4">Nama Produk Aksesori</th>
                                <th class="py-3 px-4 text-center">Total Terjual</th>
                                <th class="py-3 px-4 text-right">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($topProducts as $index => $top)
                                <tr class="hover:bg-slate-900/50 transition">
                                    <td class="py-3 px-4 font-mono font-bold text-cyan-400">#{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-bold text-white">{{ $top->product_name }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full font-extrabold border border-blue-500/30">
                                            {{ number_format($top->total_qty) }} Qty
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right font-extrabold text-emerald-400">
                                        Rp {{ number_format($top->total_sales, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
            <h3 class="font-extrabold text-lg text-white flex items-center gap-2">
                <span>⏱️</span> Pesanan Terbaru Masuk
            </h3>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs font-bold text-cyan-400 hover:underline">
                Lihat Semua Pesanan ➔
            </a>
        </div>

        @if($recentOrders->isEmpty())
            <p class="text-sm text-slate-500 text-center py-6">Belum ada pesanan masuk.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-900 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">No. Invoice</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status Order</th>
                            <th class="py-3 px-4">Status Bayar</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-900/50 transition">
                                <td class="py-3 px-4 font-bold text-white">{{ $order->order_number }}</td>
                                <td class="py-3 px-4">{{ $order->user->name ?? 'Tamu' }}</td>
                                <td class="py-3 px-4 font-bold text-cyan-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-700 bg-slate-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($order->payment)
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-lg border border-slate-700 bg-slate-800">
                                            {{ ucfirst($order->payment->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" class="text-xs bg-blue-600 hover:bg-blue-500 text-white font-bold px-3 py-1.5 rounded-lg transition shadow-md shadow-blue-600/30">
                                        Detail & Verifikasi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-admin-layout>
