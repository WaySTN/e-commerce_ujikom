<x-admin-layout>
    <x-slot name="header">Tambah Produk Aksesori Baru</x-slot>

    <div class="max-w-2xl mx-auto bg-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-xl">
        <h3 class="font-bold text-lg text-white mb-6 border-b border-slate-800 pb-3">Form Tambah Produk</h3>

        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Produk <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    placeholder="Contoh: Charger Fast Charging 65W GaN"
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
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Harga (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="100" required
                        placeholder="Contoh: 150000"
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('price')
                        <p class="text-xs text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Stock & Image Cropper Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Stok Awal <span class="text-rose-500">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 10) }}" min="0" required
                        class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">
                    @error('stock')
                        <p class="text-xs text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Foto Produk (Image Cropper 1:1)
                    </label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg"
                        onchange="triggerImageCropper(this, 'cropped-preview-img')"
                        class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                    @error('image')
                        <p class="text-xs text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cropped Image Live Preview -->
            <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl flex items-center gap-4">
                <div class="w-20 h-20 bg-slate-950 rounded-xl overflow-hidden border border-slate-800 flex items-center justify-center flex-shrink-0">
                    <img id="cropped-preview-img" class="w-full h-full object-cover hidden">
                    <span id="preview-placeholder" class="text-slate-600 text-xs text-center p-1">No Image</span>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-200 block">Preview Hasil Crop (1:1 Square)</span>
                    <p class="text-[11px] text-slate-400 mt-0.5">
                        Saat gambar dipilih, modal <strong>Image Cropper</strong> akan otomatis muncul untuk memotong foto secara presisi.
                    </p>
                    <button type="button" onclick="const input = document.getElementById('image'); if(input.files[0]) triggerImageCropper(input, 'cropped-preview-img');"
                        class="mt-2 text-[10px] bg-slate-800 hover:bg-slate-700 text-cyan-400 font-bold px-3 py-1 rounded-lg border border-slate-700 transition">
                        ✂️ Potong Ulang Gambar
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Deskripsi Produk</label>
                <textarea id="description" name="description" rows="4" placeholder="Jelaskan spesifikasi, garansi, dan keunggulan produk..."
                    class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <!-- Is Active Checkbox -->
            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="is_active" name="is_active" value="1" checked class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-blue-600 focus:ring-blue-500">
                <label for="is_active" class="text-xs font-bold text-slate-300">Aktifkan Produk (Dapat dibeli di toko)</label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-lg shadow-blue-600/30">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.produk.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs px-4 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function() {
            if(this.files[0]) {
                document.getElementById('preview-placeholder').classList.add('hidden');
            }
        });
    </script>
</x-admin-layout>
