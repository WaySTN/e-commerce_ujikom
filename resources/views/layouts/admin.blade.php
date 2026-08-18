<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel — Wahyu Gadget Pedia' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Cropper.js CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased min-h-screen flex">

    <!-- Fixed Sidebar (Tidak tergeser saat scroll) -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between fixed top-0 left-0 bottom-0 z-50 h-screen overflow-y-auto">
        <div>
            <!-- Sidebar Brand (Klik logo langsung ke Halaman Utama Toko) -->
            <a href="{{ route('home') }}" class="h-16 flex items-center px-5 border-b border-slate-800 gap-3 group hover:bg-slate-900/50 transition">
                <img src="{{ asset('images/logo.png') }}" alt="Wahyu Gadget Pedia" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
                <div>
                    <h1 class="font-extrabold text-sm text-white tracking-wide">Wahyu Gadget</h1>
                    <p class="text-[9px] text-cyan-400 font-bold uppercase tracking-widest">Admin Control Panel</p>
                </div>
            </a>

            <!-- Sidebar Navigation -->
            <nav class="px-4 py-6 space-y-1.5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    <span>📊</span> Dashboard Analisa
                </a>

                <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    <span>🏷️</span> Kelola Kategori
                </a>

                <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.produk.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    <span>📦</span> Kelola Produk
                </a>

                <a href="{{ route('admin.pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.pesanan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    <span>🛒</span> Kelola Order
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                    <span>📈</span> Laporan Penjualan
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom Actions (Lihat Toko & Tombol Keluar) -->
        <div class="p-4 border-t border-slate-800 space-y-2 bg-slate-950">
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-cyan-400 border border-slate-800 transition">
                <span>🌐</span> Lihat Toko Storefront
            </a>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button" onclick="confirmLogout()" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 transition">
                    <span>🚪</span> Keluar Sesi Admin
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Wrapper (Dengan padding-left ml-64 untuk menampung fixed sidebar) -->
    <div class="flex-1 flex flex-col min-w-0 pl-64">
        <!-- Top Bar Header -->
        <header class="h-16 bg-slate-950/80 backdrop-blur border-b border-slate-800 px-8 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <h2 class="font-bold text-lg text-white">{{ $header ?? 'Dashboard Analisa' }}</h2>
            </div>

            <!-- Profile Action Button -->
            <div class="flex items-center gap-4">
                <a href="{{ route('profile.edit') }}" class="text-xs bg-slate-800 hover:bg-slate-700 text-slate-200 px-3.5 py-2 rounded-xl border border-slate-700 font-bold transition flex items-center gap-2 shadow-sm">
                    <span>👤</span> Profil: {{ auth()->user()->name }}
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-8 flex-1">
            {{ $slot }}
        </main>
    </div>

    <!-- Image Cropper Modal Component -->
    <div id="cropper-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-950/80 backdrop-blur p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-xl w-full p-6 shadow-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                <h3 class="font-bold text-white text-base flex items-center gap-2">
                    <span>✂️</span> Potong & Sesuaikan Foto Produk (1:1 Square)
                </h3>
                <button type="button" onclick="closeCropperModal()" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>

            <!-- Cropper Image Target Container -->
            <div class="h-80 bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden flex items-center justify-center p-2">
                <img id="cropper-target-img" class="max-h-full max-w-full block">
            </div>

            <!-- Cropper Action Controls -->
            <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="cropperInstance && cropperInstance.zoom(0.1)" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold" title="Perbesar">🔍 +</button>
                    <button type="button" onclick="cropperInstance && cropperInstance.zoom(-0.1)" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold" title="Perkecil">🔍 -</button>
                    <button type="button" onclick="cropperInstance && cropperInstance.rotate(-90)" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold" title="Putar Kiri">🔄 -90°</button>
                    <button type="button" onclick="cropperInstance && cropperInstance.rotate(90)" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold" title="Putar Kanan">🔄 +90°</button>
                    <button type="button" onclick="cropperInstance && cropperInstance.reset()" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold" title="Reset">⏮️ Reset</button>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeCropperModal()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs px-4 py-2.5 rounded-xl">Batal</button>
                    <button type="button" onclick="applyCroppedImage()" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-lg shadow-blue-600/30 flex items-center gap-1.5">
                        <span>✂️</span> Potong & Gunakan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Scripts & Global Confirmation Handlers -->
    <script>
        // Toast Notification System
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            background: '#0f172a',
            color: '#f8fafc',
            customClass: {
                popup: 'border border-slate-800 rounded-2xl shadow-2xl'
            }
        });

        // Trigger Flash Messages from Session
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: "{{ session('error') }}",
                background: '#0f172a',
                color: '#f8fafc',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'border border-slate-800 rounded-3xl shadow-2xl'
                }
            });
        @endif

        // Reusable Confirmation Popup Function
        function confirmFormAction(form, options = {}) {
            const title = options.title || 'Konfirmasi Aksi';
            const text = options.text || 'Apakah Anda yakin ingin melanjutkan aksi ini?';
            const icon = options.icon || 'question';
            const confirmButtonText = options.confirmButtonText || 'Ya, Lanjutkan';
            const confirmButtonColor = options.confirmButtonColor || '#2563eb';

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#475569',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
                background: '#0f172a',
                color: '#f8fafc',
                customClass: {
                    popup: 'border border-slate-800 rounded-3xl shadow-2xl p-6',
                    confirmButton: 'rounded-xl px-5 py-2.5 text-xs font-bold',
                    cancelButton: 'rounded-xl px-5 py-2.5 text-xs font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Quick confirm helpers for onclick events
        function confirmDelete(form, itemName = 'data ini') {
            confirmFormAction(form, {
                title: 'Hapus Data?',
                text: `Apakah Anda yakin ingin menghapus ${itemName}? Aksi ini tidak dapat dibatalkan!`,
                icon: 'warning',
                confirmButtonText: 'Ya, Hapus!',
                confirmButtonColor: '#dc2626'
            });
        }

        function confirmPayment(form, statusName = 'LUNAS') {
            const isLunas = statusName.toUpperCase() === 'LUNAS';
            confirmFormAction(form, {
                title: `Verifikasi Pembayaran ${statusName}?`,
                text: isLunas ? 'Status pembayaran pesanan akan diubah menjadi LUNAS.' : 'Bukti pembayaran akan DITOLAK.',
                icon: isLunas ? 'success' : 'warning',
                confirmButtonText: isLunas ? 'Ya, Konfirmasi Lunas' : 'Ya, Tolak Bayar',
                confirmButtonColor: isLunas ? '059669' : '#dc2626'
            });
        }

        function confirmStatusUpdate(form, statusName) {
            confirmFormAction(form, {
                title: `Update Status Order?`,
                text: `Status pesanan akan diubah menjadi "${statusName}".`,
                icon: 'info',
                confirmButtonText: 'Ya, Update Status',
                confirmButtonColor: '#2563eb'
            });
        }

        function confirmLogout() {
            const form = document.getElementById('logout-form');
            confirmFormAction(form, {
                title: 'Keluar dari Admin?',
                text: 'Sesi login admin Anda akan diakhiri.',
                icon: 'question',
                confirmButtonText: 'Ya, Keluar',
                confirmButtonColor: '#dc2626'
            });
        }

        // ==========================================
        // IMAGE CROPPER GLOBAL COMPONENT CONTROLLER
        // ==========================================
        let cropperInstance = null;
        let activeFileInput = null;
        let activePreviewImg = null;
        let activeFileName = 'cropped-product.jpg';

        function triggerImageCropper(fileInput, previewImgId) {
            const file = fileInput.files[0];
            if (!file) return;

            activeFileInput = fileInput;
            activePreviewImg = document.getElementById(previewImgId);
            activeFileName = file.name || 'cropped-product.jpg';

            const reader = new FileReader();
            reader.onload = function (e) {
                const targetImg = document.getElementById('cropper-target-img');
                targetImg.src = e.target.result;

                const modal = document.getElementById('cropper-modal');
                modal.classList.remove('hidden');

                if (cropperInstance) {
                    cropperInstance.destroy();
                }

                cropperInstance = new Cropper(targetImg, {
                    aspectRatio: 1, // 1:1 Square aspect ratio for Product images
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        }

        function closeCropperModal() {
            const modal = document.getElementById('cropper-modal');
            modal.classList.add('hidden');
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
        }

        async function applyCroppedImage() {
            if (!cropperInstance) return;

            const canvas = cropperInstance.getCroppedCanvas({
                width: 800,
                height: 800,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Convert canvas to Blob
            const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.9));
            const croppedFile = new File([blob], activeFileName, { type: 'image/jpeg' });

            // Set file to input using DataTransfer API
            const container = new DataTransfer();
            container.items.add(croppedFile);
            activeFileInput.files = container.files;

            // Set preview image src
            if (activePreviewImg) {
                activePreviewImg.src = canvas.toDataURL('image/jpeg', 0.9);
                activePreviewImg.classList.remove('hidden');
            }

            closeCropperModal();

            Toast.fire({
                icon: 'success',
                title: 'Foto Terpotong!',
                text: 'Gambar berhasil dipotong (1:1) & diterapkan.'
            });
        }
    </script>
</body>
</html>
