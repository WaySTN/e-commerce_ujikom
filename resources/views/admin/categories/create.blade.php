<x-admin-layout>
    <x-slot name="header">Tambah Kategori Baru</x-slot>

    <div class="max-w-xl mx-auto bg-slate-950 border border-slate-800 rounded-3xl p-4 sm:p-8 shadow-xl">
        <h3 class="font-bold text-base sm:text-lg text-white mb-6 border-b border-slate-800 pb-3">Form Tambah Kategori</h3>

        <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Nama Kategori <span class="text-rose-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    placeholder="Contoh: Casing & Pelindung"
                    class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-xs text-rose-400 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-lg shadow-blue-600/30">
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs px-4 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>
