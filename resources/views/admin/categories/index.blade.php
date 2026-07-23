<x-admin-layout>
    <x-slot name="header">Kelola Kategori Produk</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-white">Daftar Kategori Aksesori</h3>
        <a href="{{ route('admin.kategori.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/30 flex items-center gap-2">
            <span>➕</span> Tambah Kategori Baru
        </a>
    </div>

    <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 shadow-xl">
        @if($categories->isEmpty())
            <p class="text-sm text-slate-500 text-center py-6">Belum ada kategori ditambahkan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-900 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Jumlah Produk</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($categories as $category)
                            <tr class="hover:bg-slate-900/50 transition">
                                <td class="py-3 px-4 font-mono text-slate-500">#{{ $category->id }}</td>
                                <td class="py-3 px-4 font-bold text-white">{{ $category->name }}</td>
                                <td class="py-3 px-4 font-mono text-xs text-slate-400">{{ $category->slug }}</td>
                                <td class="py-3 px-4">
                                    <span class="text-xs bg-slate-800 px-2.5 py-1 rounded-full font-semibold border border-slate-700 text-cyan-400">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <a href="{{ route('admin.kategori.edit', $category->id) }}" class="text-xs bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30 px-3 py-1.5 rounded-lg transition font-semibold">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.kategori.destroy', $category->id) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus kategori ini?')" class="text-xs bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg transition font-semibold">
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
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
