<x-admin-layout>
    <x-slot name="header">Kelola Pesanan Customer</x-slot>

    <!-- Filters Bar -->
    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl mb-6">
        <form method="GET" action="{{ route('admin.pesanan.index') }}" class="flex flex-wrap gap-4 items-center">
            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Filter Status Order</label>
                <select name="status" onchange="this.form.submit()"
                    class="bg-slate-900 border border-slate-700 text-white text-xs rounded-xl py-2 px-3 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status Order</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Filter Status Bayar</label>
                <select name="payment_status" onchange="this.form.submit()"
                    class="bg-slate-900 border border-slate-700 text-white text-xs rounded-xl py-2 px-3 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status Pembayaran</option>
                    <option value="menunggu" {{ request('payment_status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="lunas" {{ request('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="ditolak" {{ request('payment_status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            @if(request('status') || request('payment_status'))
                <a href="{{ route('admin.pesanan.index') }}" class="mt-4 text-xs font-semibold text-cyan-400 hover:underline">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
        @if($orders->isEmpty())
            <p class="text-sm text-slate-500 text-center py-6">Tidak ada data pesanan ditemukan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-900 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">No. Invoice</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status Order</th>
                            <th class="py-3 px-4">Pembayaran</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($orders as $order)
                            <tr class="hover:bg-slate-900/50 transition">
                                <td class="py-3 px-4 font-bold text-white">{{ $order->order_number }}</td>
                                <td class="py-3 px-4">{{ $order->user->name ?? 'Tamu' }}</td>
                                <td class="py-3 px-4 text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-3 px-4 font-bold text-cyan-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-500/10 text-amber-400 border-amber-500/30',
                                            'diproses' => 'bg-blue-500/10 text-blue-400 border-blue-500/30',
                                            'dikirim' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/30',
                                            'selesai' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
                                            'dibatalkan' => 'bg-rose-500/10 text-rose-400 border-rose-500/30',
                                        ];
                                    @endphp
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg border {{ $statusColors[$order->status] }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($order->payment)
                                        @php
                                            $payColors = [
                                                'menunggu' => 'bg-amber-500/10 text-amber-400 border-amber-500/30',
                                                'lunas' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30',
                                                'ditolak' => 'bg-rose-500/10 text-rose-400 border-rose-500/30',
                                            ];
                                        @endphp
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-lg border {{ $payColors[$order->payment->status] }}">
                                            {{ ucfirst($order->payment->status) }} ({{ strtoupper($order->payment->method) }})
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" class="text-xs bg-blue-600 hover:bg-blue-500 text-white font-bold px-3 py-1.5 rounded-lg transition">
                                        Detail & Verifikasi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
