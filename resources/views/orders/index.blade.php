<x-app-layout>
    <x-slot name="title">Pesanan Saya — Wahyu Gadget Pedia</x-slot>

    <h1 class="text-2xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
        <span>📦</span> Riwayat Pesanan Saya
    </h1>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm my-8">
            <span class="text-6xl block mb-4">📭</span>
            <h2 class="text-xl font-bold text-slate-800">Belum Ada Pesanan</h2>
            <p class="text-sm text-slate-500 mt-1">Anda belum melakukan pemesanan produk di Wahyu Gadget Pedia.</p>
            <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                Jelajahi Produk
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center pb-4 border-b border-slate-100 gap-2">
                        <div>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">No. Invoice</span>
                            <span class="font-extrabold text-slate-900 text-base">{{ $order->order_number }}</span>
                            <span class="text-xs text-slate-400 block mt-0.5">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>

                        <div class="flex flex-wrap gap-2 items-center">
                            <!-- Status Order Badge -->
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
                                    'diproses' => 'bg-blue-100 text-blue-800 border-blue-300',
                                    'dikirim' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
                                    'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    'dibatalkan' => 'bg-rose-100 text-rose-800 border-rose-300',
                                ];
                            @endphp
                            <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $statusColors[$order->status] ?? 'bg-slate-100' }}">
                                Status: {{ ucfirst($order->status) }}
                            </span>

                            <!-- Status Payment Badge -->
                            @if($order->payment)
                                @php
                                    $payColors = [
                                        'menunggu' => 'bg-amber-100 text-amber-800 border-amber-300',
                                        'lunas' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                        'ditolak' => 'bg-rose-100 text-rose-800 border-rose-300',
                                    ];
                                @endphp
                                <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $payColors[$order->payment->status] ?? 'bg-slate-100' }}">
                                    Bayar: {{ ucfirst($order->payment->status) }} ({{ strtoupper($order->payment->method) }})
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Items Summary -->
                    <div class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="text-xs text-slate-600 space-y-1">
                            @foreach($order->items->take(2) as $item)
                                <p class="font-medium text-slate-800">
                                    • {{ $item->product_name }} <span class="text-slate-400">({{ $item->qty }}x)</span>
                                </p>
                            @endforeach
                            @if($order->items->count() > 2)
                                <p class="text-slate-400 italic">+ {{ $order->items->count() - 2 }} item lainnya...</p>
                            @endif
                        </div>

                        <div class="text-right w-full sm:w-auto flex justify-between sm:block items-center">
                            <div>
                                <span class="text-xs text-slate-400 font-medium block">Total Belanja</span>
                                <span class="text-lg font-extrabold text-blue-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 text-right">
                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-xl transition">
                            Lihat Detail & Upload Bukti ➔
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    @endif
</x-app-layout>
