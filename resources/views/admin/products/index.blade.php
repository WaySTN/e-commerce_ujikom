<x-admin-layout>
    <x-slot name="header">Kelola Produk Aksesori</x-slot>

    <!-- Top Action & Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <form method="GET" action="{{ route('admin.produk.index') }}" class="flex flex-wrap gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
                class="bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-blue-500 w-60">

            <select name="category_id" onchange="this.form.submit()"
                class="bg-slate-950 border border-slate-800 text-slate-200 text-xs rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs px-4 py-2.5 rounded-xl transition">
                Cari
            </button>
        </form>

        <a href="{{ route('admin.produk.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/30 flex items-center gap-2">
            <span>➕</span> Tambah Produk Baru
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
        @if($products->isEmpty())
            <p class="text-sm text-slate-500 text-center py-6">Belum ada produk ditambahkan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-900 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">Gambar</th>
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Stok</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-900/50 transition">
                                <td class="py-3 px-4">
                                    <div class="w-12 h-12 bg-slate-900 rounded-xl overflow-hidden border border-slate-800">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-500 text-xs">🔌</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-bold text-white max-w-xs truncate">{{ $product->name }}</td>
                                <td class="py-3 px-4 text-xs text-slate-400 font-semibold">{{ $product->category->name ?? '-' }}</td>
                                <td class="py-3 px-4 font-bold text-cyan-400">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg border {{ $product->stock > 0 ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : 'bg-rose-500/10 text-rose-400 border-rose-500/30' }}">
                                        {{ $product->stock }} unit
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg border {{ $product->is_active ? 'bg-blue-500/10 text-blue-400 border-blue-500/30' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <a href="{{ route('admin.produk.edit', $product->id) }}" class="text-xs bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 px-3 py-1.5 rounded-lg transition font-semibold">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.produk.destroy', $product->id) }}" class="inline-block" onsubmit="event.preventDefault(); confirmDelete(this, 'produk {{ addslashes($product->name) }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg transition font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
