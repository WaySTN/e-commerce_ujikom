<x-admin-layout>
    <x-slot name="header">Laporan Penjualan Toko</x-slot>

    <!-- Print Stylesheet -->
    <style>
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            aside, header, nav, button, form, .no-print {
                display: none !important;
            }
            .pl-64 {
                padding-left: 0 !important;
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
            .print-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            .print-table th, .print-table td {
                border: 1px solid #cbd5e1 !important;
                padding: 8px 10px !important;
                color: #0f172a !important;
                font-size: 11px !important;
            }
            .print-table th {
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
    <!-- PRINT-ONLY DEDICATED OFFICIAL REPORT (Visible on Print) -->
    <!-- ======================================================= -->
    <div class="print-only p-6 bg-white text-slate-900 font-sans">
        <!-- Formal Letterhead / Kop Surat -->
        <div class="flex justify-between items-start border-b-2 border-slate-900 pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-extrabold uppercase text-slate-900 tracking-wider">Wahyu Gadget Pedia Store</h1>
                <p class="text-xs text-slate-600">Pusat Belanja Aksesori Gadget Terlengkap & Terpercaya</p>
                <p class="text-xs text-slate-500">Skema Uji Kompetensi BNSP: Junior Web Programming</p>
            </div>
            <div class="text-right text-xs text-slate-600">
                <span class="inline-block bg-slate-900 text-white font-extrabold text-xs px-3 py-1 uppercase tracking-widest rounded mb-1">
                    LAPORAN PENJUALAN
                </span>
                <p class="mt-1">Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong></p>
                <p>Waktu Cetak: {{ now()->format('d/m/Y H:i') }} WIB</p>
            </div>
        </div>

        <!-- Summary Metrics Box -->
        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-slate-50 border border-slate-200 rounded-lg text-xs">
            <div>
                <span class="font-bold text-slate-500 uppercase tracking-wider block mb-0.5">Total Transaksi Selesai:</span>
                <span class="text-xl font-extrabold text-slate-900">{{ number_format($totalTransactions) }} Pesanan</span>
            </div>
            <div class="text-right">
                <span class="font-bold text-slate-500 uppercase tracking-wider block mb-0.5">Total Pendapatan Lunas (Omset):</span>
                <span class="text-xl font-extrabold text-slate-900">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Top 5 Products Table if exists -->
        @if($topProducts->isNotEmpty())
            <div class="mb-6">
                <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider mb-2">Top 5 Produk Terlaris Periode Ini</h3>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th class="text-center w-12">No.</th>
                            <th class="text-left">Nama Produk Aksesori</th>
                            <th class="text-center w-28">Total Terjual</th>
                            <th class="text-right w-36">Total Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $idx => $tp)
                            <tr>
                                <td class="text-center font-bold">{{ $idx + 1 }}</td>
                                <td>{{ $tp->product_name }}</td>
                                <td class="text-center font-bold">{{ number_format($tp->total_qty) }} unit</td>
                                <td class="text-right font-bold">Rp {{ number_format($tp->total_sales, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Detailed Transactions Table -->
        <div class="mb-8">
            <h3 class="font-bold text-sm text-slate-900 uppercase tracking-wider mb-2">Rincian Seluruh Transaksi</h3>
            @if($orders->isEmpty())
                <p class="text-xs text-slate-500 italic py-4">Tidak ada transaksi pada rentang tanggal ini.</p>
            @else
                <table class="print-table">
                    <thead>
                        <tr>
                            <th class="text-center w-10">No.</th>
                            <th class="text-left">No. Invoice</th>
                            <th class="text-left">Waktu Order</th>
                            <th class="text-left">Customer</th>
                            <th class="text-center">Status Pesanan</th>
                            <th class="text-center">Status Bayar</th>
                            <th class="text-right">Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $idx => $order)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td class="font-bold">{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->user->name ?? 'Tamu' }}</td>
                                <td class="text-center uppercase">{{ $order->status }}</td>
                                <td class="text-center uppercase font-bold">{{ $order->payment ? $order->payment->status : '-' }}</td>
                                <td class="text-right font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right font-bold">Total Pendapatan Terverifikasi Lunas:</td>
                            <td class="text-right font-extrabold text-sm">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>

        <!-- Formal Signature Block -->
        <div class="mt-12 pt-6 border-t border-slate-300 flex justify-between text-xs text-slate-700">
            <div class="text-center w-48">
                <p>Dicetak oleh,</p>
                <div class="h-16"></div>
                <p class="font-bold border-b border-slate-800 pb-1">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-slate-500">Administrator Toko</p>
            </div>

            <div class="text-center w-48">
                <p>Mengetahui,</p>
                <div class="h-16"></div>
                <p class="font-bold border-b border-slate-800 pb-1">( ........................................ )</p>
                <p class="text-[10px] text-slate-500">Asesor / Penguji BNSP</p>
            </div>
        </div>
    </div>

    <!-- ======================================================= -->
    <!-- SCREEN-ONLY INTERACTIVE ADMIN VIEW (Visible on Browser) -->
    <!-- ======================================================= -->
    <div class="screen-only">
        <!-- Date Range Filter & Print Action Bar -->
        <div class="no-print bg-slate-950 border border-slate-800 rounded-3xl p-4 sm:p-6 shadow-xl mb-6 sm:mb-8 flex flex-col md:flex-row items-stretch md:items-end justify-between gap-4">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-end gap-3 sm:gap-4 flex-1">
                <div class="flex-1 sm:flex-initial">
                    <label for="start_date" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                        class="w-full sm:w-auto bg-slate-900 border border-slate-700 text-white text-xs rounded-xl py-2.5 px-3 sm:px-4 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex-1 sm:flex-initial">
                    <label for="end_date" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                        class="w-full sm:w-auto bg-slate-900 border border-slate-700 text-white text-xs rounded-xl py-2.5 px-3 sm:px-4 focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2">
                    <span>🔍</span> Filter Laporan
                </button>
            </form>

            <button type="button" onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 w-full md:w-auto">
                <span>🖨️</span> Cetak / Simpan PDF
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-slate-950 border border-slate-800 p-4 sm:p-6 rounded-3xl flex items-center justify-between shadow-xl">
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Transaksi Selesai</span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-white mt-1 block">{{ number_format($totalTransactions) }} pesanan</span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">Selama periode terpilih</span>
                </div>
                <div class="no-print bg-blue-600/20 text-blue-400 p-3 rounded-2xl border border-blue-500/30 text-2xl">
                    📑
                </div>
            </div>

            <div class="bg-slate-950 border border-slate-800 p-4 sm:p-6 rounded-3xl flex items-center justify-between shadow-xl">
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Total Pendapatan Lunas</span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-emerald-400 mt-1 block">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-slate-500 block mt-0.5">Omset bersih terverifikasi</span>
                </div>
                <div class="no-print bg-emerald-600/20 text-emerald-400 p-3 rounded-2xl border border-emerald-500/30 text-2xl">
                    💳
                </div>
            </div>
        </div>

        <!-- Dynamic Daily/Monthly Report Chart -->
        @if(!empty($chartLabels))
            <div class="no-print bg-slate-950 border border-slate-800 rounded-3xl p-4 sm:p-6 shadow-xl mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 border-b border-slate-800 pb-4 mb-4">
                    <div>
                        <h3 class="font-extrabold text-white text-sm sm:text-base flex items-center gap-2">
                            <span>📊</span> Grafik Pendapatan {{ ($chartPeriodType ?? 'harian') === 'bulanan' ? 'Bulanan' : 'Harian' }} Periode Terpilih
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Visualisasi omset per {{ ($chartPeriodType ?? 'harian') === 'bulanan' ? 'bulan' : 'hari' }} dari {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                        </p>
                    </div>
                    <span class="text-xs bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 px-3 py-1 rounded-full font-bold w-fit">
                        {{ ($chartPeriodType ?? 'harian') === 'bulanan' ? 'Agregasi Bulanan' : 'Agregasi Harian' }}
                    </span>
                </div>
                <div class="h-64 sm:h-72 w-full relative">
                    <canvas id="reportDailyChart"></canvas>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Top Selling Products Card -->
            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-4 sm:p-6 shadow-xl h-fit">
                <h3 class="font-extrabold text-white text-sm sm:text-base border-b border-slate-800 pb-3 mb-4 flex items-center gap-2">
                    <span>🔥</span> Top 5 Produk Terlaris
                </h3>

                @if($topProducts->isEmpty())
                    <p class="text-xs text-slate-500 text-center py-4">Belum ada data produk terjual.</p>
                @else
                    <div class="space-y-3">
                        @foreach($topProducts as $top)
                            <div class="flex items-center justify-between pb-3 border-b border-slate-800 last:border-b-0 text-xs gap-2">
                                <div class="min-w-0 flex-1">
                                    <span class="font-bold text-white block truncate">{{ $top->product_name }}</span>
                                    <span class="text-slate-400 text-[11px]">Terjual: {{ number_format($top->total_qty) }} unit</span>
                                </div>
                                <span class="font-extrabold text-cyan-400 flex-shrink-0">
                                    Rp {{ number_format($top->total_sales, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Detailed Transactions Table -->
            <div class="lg:col-span-2 bg-slate-950 border border-slate-800 rounded-3xl p-4 sm:p-6 shadow-xl">
                <h3 class="font-extrabold text-white text-sm sm:text-base border-b border-slate-800 pb-4 mb-4">
                    Rincian Transaksi ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
                </h3>

                @if($orders->isEmpty())
                    <p class="text-sm text-slate-500 text-center py-6">Tidak ada transaksi pada rentang tanggal ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-300 min-w-[650px]">
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
                                        <td class="py-2.5 px-3 font-bold text-white whitespace-nowrap">{{ $order->order_number }}</td>
                                        <td class="py-2.5 px-3 text-slate-400 whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-2.5 px-3">{{ $order->user->name ?? 'Tamu' }}</td>
                                        <td class="py-2.5 px-3 font-semibold whitespace-nowrap">{{ ucfirst($order->status) }}</td>
                                        <td class="py-2.5 px-3 font-semibold text-emerald-400 whitespace-nowrap">
                                            {{ $order->payment ? ucfirst($order->payment->status) : '-' }}
                                        </td>
                                        <td class="py-2.5 px-3 font-bold text-cyan-400 text-right whitespace-nowrap">
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
    </div>

    <!-- Chart.js Report Script (Only for Screen View) -->
    @if(!empty($chartLabels))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reportCtx = document.getElementById('reportDailyChart');
                if (reportCtx) {
                    const labels = @json($chartLabels);
                    const revenues = @json($chartRevenues);
                    const orderCounts = @json($chartOrderCounts);

                    new Chart(reportCtx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Pendapatan (Rp)',
                                    data: revenues,
                                    backgroundColor: 'rgba(14, 165, 233, 0.75)',
                                    borderColor: '#0ea5e9',
                                    borderWidth: 1,
                                    borderRadius: 6,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Jumlah Transaksi',
                                    data: orderCounts,
                                    type: 'line',
                                    borderColor: '#34d399',
                                    backgroundColor: '#34d399',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    pointRadius: 4,
                                    yAxisID: 'y1'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#cbd5e1',
                                        font: { family: "'Outfit', sans-serif", size: 11, weight: 'bold' }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleColor: '#f8fafc',
                                    bodyColor: '#cbd5e1',
                                    borderColor: '#334155',
                                    borderWidth: 1,
                                    padding: 10,
                                    cornerRadius: 10,
                                    callbacks: {
                                        label: function(context) {
                                            if (context.datasetIndex === 0) {
                                                return ' Pendapatan: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                            }
                                            return ' Transaksi: ' + context.raw + ' pesanan';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: 'rgba(51, 65, 85, 0.3)' },
                                    ticks: { color: '#94a3b8', font: { family: "'Outfit', sans-serif", size: 10 } }
                                },
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    grid: { color: 'rgba(51, 65, 85, 0.3)' },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: { family: "'Outfit', sans-serif", size: 10 },
                                        callback: function(value) {
                                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                                            return 'Rp ' + value;
                                        }
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    grid: { drawOnChartArea: false },
                                    ticks: {
                                        color: '#34d399',
                                        font: { family: "'Outfit', sans-serif", size: 10 },
                                        stepSize: 1,
                                        callback: function(value) {
                                            return value + ' tx';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endif
</x-admin-layout>
