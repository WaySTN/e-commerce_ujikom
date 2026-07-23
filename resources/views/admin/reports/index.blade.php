<x-admin-layout>
    <x-slot name="header">Laporan Penjualan Toko</x-slot>

    <!-- Date Range Filter Form -->
    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl mb-8">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label for="start_date" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                    class="bg-slate-900 border border-slate-700 text-white text-xs rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="end_date" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                    class="bg-slate-900 border border-slate-700 text-white text-xs rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-lg shadow-blue-600/30">
                Filter Laporan
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between shadow-lg">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Transaksi Selesai</span>
                <span class="text-3xl font-extrabold text-white mt-1 block">{{ number_format($totalTransactions) }} pesanan</span>
            </div>
            <div class="bg-blue-600/20 text-blue-400 p-3 rounded-2xl border border-blue-500/30 text-2xl">
                📑
            </div>
        </div>

        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between shadow-lg">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Pendapatan Lunas</span>
                <span class="text-3xl font-extrabold text-emerald-400 mt-1 block">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
            </div>
            <div class="bg-emerald-600/20 text-emerald-400 p-3 rounded-2xl border border-emerald-500/30 text-2xl">
                💳
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Top Selling Products Card -->
        <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl h-fit">
            <h3 class="font-extrabold text-white text-base border-b border-slate-800 pb-3 mb-4 flex items-center gap-2">
                <span>🔥</span> Top 5 Produk Terlaris
            </h3>

            @if($topProducts->isEmpty())
                <p class="text-xs text-slate-500 text-center py-4">Belum ada data produk terjual.</p>
            @else
                <div class="space-y-3">
                    @foreach($topProducts as $top)
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800 last:border-b-0 text-xs">
                            <div>
                                <span class="font-bold text-white block">{{ $top->product_name }}</span>
                                <span class="text-slate-400">Terjual: {{ number_format($top->total_qty) }} unit</span>
                            </div>
                            <span class="font-extrabold text-cyan-400">
                                Rp {{ number_format($top->total_sales, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Detailed Transactions Table -->
        <div class="lg:col-span-2 bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
            <h3 class="font-extrabold text-white text-base border-b border-slate-800 pb-4 mb-4">
                Daftar Transaksi Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </h3>

            @if($orders->isEmpty())
                <p class="text-sm text-slate-500 text-center py-6">Tidak ada transaksi pada rentang tanggal ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="text-slate-400 uppercase bg-slate-900 border-b border-slate-800">
                            <tr>
                                <th class="py-2.5 px-3">No. Invoice</th>
                                <th class="py-2.5 px-3">Tanggal</th>
                                <th class="py-2.5 px-3">Customer</th>
                                <th class="py-2.5 px-3">Status Order</th>
                                <th class="py-2.5 px-3">Pembayaran</th>
                                <th class="py-2.5 px-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-900/50 transition">
                                    <td class="py-2.5 px-3 font-bold text-white">{{ $order->order_number }}</td>
                                    <td class="py-2.5 px-3 text-slate-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-2.5 px-3">{{ $order->user->name ?? 'Tamu' }}</td>
                                    <td class="py-2.5 px-3 font-semibold">{{ ucfirst($order->status) }}</td>
                                    <td class="py-2.5 px-3 font-semibold text-emerald-400">
                                        {{ $order->payment ? ucfirst($order->payment->status) : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 font-bold text-cyan-400 text-right">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
