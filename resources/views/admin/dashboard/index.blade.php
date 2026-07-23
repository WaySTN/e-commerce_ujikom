<x-admin-layout>
    <x-slot name="header">Dashboard Ikhtisar</x-slot>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders Card -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between shadow-lg">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Pesanan</span>
                <span class="text-3xl font-extrabold text-white mt-1 block">{{ number_format($totalOrders) }}</span>
            </div>
            <div class="bg-blue-600/20 text-blue-400 p-3 rounded-2xl border border-blue-500/30 text-2xl">
                🛒
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between shadow-lg">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Pendapatan</span>
                <span class="text-2xl font-extrabold text-emerald-400 mt-1 block">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
            </div>
            <div class="bg-emerald-600/20 text-emerald-400 p-3 rounded-2xl border border-emerald-500/30 text-2xl">
                💰
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between shadow-lg">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Order Pending</span>
                <span class="text-3xl font-extrabold text-amber-400 mt-1 block">{{ number_format($pendingOrders) }}</span>
            </div>
            <div class="bg-amber-600/20 text-amber-400 p-3 rounded-2xl border border-amber-500/30 text-2xl">
                ⏳
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-slate-950 border border-slate-800 p-6 rounded-2xl flex items-center justify-between shadow-lg">
            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Jumlah Produk</span>
                <span class="text-3xl font-extrabold text-cyan-400 mt-1 block">{{ number_format($totalProducts) }}</span>
            </div>
            <div class="bg-cyan-600/20 text-cyan-400 p-3 rounded-2xl border border-cyan-500/30 text-2xl">
                📦
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-800">
            <h3 class="font-extrabold text-lg text-white flex items-center gap-2">
                <span>⏱️</span> Pesanan Terbaru
            </h3>
            <a href="{{ route('admin.pesanan.index') }}" class="text-xs font-bold text-cyan-400 hover:underline">
                Lihat Semua Order ➔
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
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" class="text-xs bg-blue-600 hover:bg-blue-500 text-white font-bold px-3 py-1.5 rounded-lg transition">
                                        Detail
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
