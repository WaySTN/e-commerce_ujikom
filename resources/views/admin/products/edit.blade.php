<x-admin-layout>
    <x-slot name="header">Edit Produk {{ $product->name }}</x-slot>

    <div class="max-w-2xl mx-auto bg-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
        <h3 class="font-bold text-lg text-white mb-6 border-b border-slate-800 pb-3">Form Edit Produk</h3>

        <form method="POST" action="{{ route('admin.produk.update', $product->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                    class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="text-xs text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category & Price Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select id="category_id" name="category_id" required
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Harga (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="100" required
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Stock & Image Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Stok <span class="text-rose-500">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="image" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Ganti Gambar (Opsional)</label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg"
                        class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                    @if($product->image)
                        <span class="text-[11px] text-slate-400 mt-1 block">Gambar saat ini: {{ basename($product->image) }}</span>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Deskripsi Produk</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Is Active Checkbox -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-blue-600 focus:ring-blue-500">
                <label for="is_active" class="text-xs font-bold text-slate-300">Aktifkan Produk</label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-lg shadow-blue-600/30">
                    Update Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs px-4 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
