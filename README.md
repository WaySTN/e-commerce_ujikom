# ⚡ Wahyu Gadget Pedia — E-Commerce Aksesori Gadget

[![Laravel Version](https://img.shields.io/badge/Laravel-v12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.4.x-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.x-38bdf8.svg)](https://tailwindcss.com)
[![Chart.js](https://img.shields.io/badge/Chart.js-v4.x-ff6384.svg)](https://www.chartjs.org)
[![Tests Status](https://img.shields.io/badge/Tests-31%20Passed%20(94%20Assertions)-emerald.svg)](https://phpunit.de)
[![BNSP Certification](https://img.shields.io/badge/BNSP-Junior_Web_Programming-gold.svg)](#)

Aplikasi Web **E-Commerce Wahyu Gadget Pedia** dibangun menggunakan framework **Laravel 12**, **Tailwind CSS v4**, **Chart.js**, dan **MySQL** sebagai pemenuhan standar kelulusan **Uji Kompetensi Sertifikasi BNSP Skema "Junior Web Programming"**.

Aplikasi ini menyediakan platform belanja online lengkap untuk produk aksesori gadget (charger, casing, earphone TWS, kabel data, dll.) dengan 3 entitas pengguna: **Tamu (Guest)**, **Customer (Pembeli Terdaftar)**, dan **Admin (Pengelola Toko)**.

---

## 🚀 Fitur Unggulan Aplikasi

### 🛒 1. Fitur Tamu & Customer (Storefront)
* **Katalog Produk Publik**: Pencarian *real-time* berdasarkan nama produk dan filter kategori dengan pagination.
* **Hero Banner Carousel**: Slider 3 banner promo gadget dengan animasi geser halus (*autoplay* 4.5 detik), tombol navigasi `❮` & `❯`, dan indikator titik.
* **Interaktif SweetAlert2 Login Dialog**: Pengunjung belum login yang menekan tombol `+ Keranjang` akan diarahkan dengan modal dialog interaktif (*Masuk ke Akun* atau *Daftar Baru*) tanpa kehilangan konteks halaman.
* **Persistent User Cart**: Keranjang belanja customer terikat dengan `user_id` di database session, sehingga item belanja tidak pernah hilang saat *logout* dan *login kembali*.
* **Checkout Atomic & Manajemen Stok**: Alamat pengiriman, catatan khusus, pilihan pembayaran **Transfer Bank** atau **COD (Cash On Delivery)**. Stok produk berkurang otomatis secara *atomic* saat order dibuat.
* **Unggah Bukti Pembayaran**: Form upload file bukti transfer (*image validator*) pada pesanan transfer.
* **Cetak Struk / Invoice Resmi (A4)**: Dilengkapi tombol cetak invoice ber-kop surat resmi, rincian barang, total tagihan, dan kolom tanda tangan pembeli/admin toko yang *clean & print-ready*.

### 📊 2. Fitur Admin Control Panel (`/admin/dashboard`)
* **Dashboard Analisa Bisnis & Penjualan (Chart.js)**:
  * **KPI Real-Time**: Total Pendapatan Lunas (Rp), Pendapatan Bulan Ini, Total Pesanan, Pesanan Pending, dan Peringatan Stok Menipis ($\le$ 5 unit).
  * **Grafik Tren Omset 7 Hari**: Line/Area chart interaktif yang merefleksikan dinamika pendapatan harian dan volume pesanan.
  * **Grafik Distribusi Kategori**: Doughnut chart proporsi penjualan unit per kategori aksesori.
  * **Visual Breakdown**: Progress bar persentase status pesanan & status pembayaran.
  * **Widget Stok Menipis & Top 5 Produk Terlaris**.
* **Kelola Produk & Square Image Cropper (Cropper.js 1:1)**: Full CRUD produk dilengkapi modal pemotong foto rasio 1:1 presisi 800x800px dengan kontrol Zoom, Rotate, & Reset.
* **Kelola Kategori**: Full CRUD kategori aksesori dengan auto-slug generator dan hitungan relasi produk.
* **Kelola Pesanan & Logika Bisnis Otomatis**:
  * Verifikasi bukti transfer (`LUNAS` / `DITOLAK`).
  * Perbaruan alur status pesanan (`pending` → `diproses` → `dikirim` → `selesai` / `dibatalkan`).
  * **Rollback Stok Otomatis**: Saat pesanan dibatalkan admin, stok produk otomatis dikembalikan (*restored*).
  * **COD Lunas Otomatis**: Saat pesanan COD diselesaikan admin, status pembayaran otomatis berubah menjadi *Lunas* dengan timestamp `paid_at`.
* **Laporan Penjualan & Cetak PDF**:
  * Filter rentang tanggal adaptif (**Agregasi Harian** jika $\le$ 60 hari, **Agregasi Bulanan** jika > 60 hari).
  * Grafik Chart.js visualisasi omset periode terpilih.
  * Rekapitulasi omset, total pesanan, Top 5 produk terlaris, dan tabel seluruh rincian transaksi.
  * Format cetak resmi ber-kop surat dengan kolom tanda tangan Administrator & Asesor Penguji BNSP.

### 📱 3. Responsive Design Mobile-First (Semua Halaman)
* **Off-Canvas Drawer Sidebar**: Pada smartphone & tablet (`< 1024px`), sidebar tersimpan rapi dan dapat dibuka via tombol Hamburger (`☰`) dengan animasi mulus dan backdrop gelap (`#sidebar-backdrop`).
* **Fluid Grid & Scrollable Tables**: Semua tabel administrasi, chart, dan form dapat diakses dengan nyaman di semua resolusi layar (Mobile 375px hingga Desktop 4K).

### 🛡️ 4. Error Pages & Keamanan
* Halaman kustom **403 Forbidden** & **404 Not Found** dengan UI modern, responsif, dan tombol navigasi kembali.
* Validasi hak akses ketat via `AdminMiddleware` dan otorisasi kepemilikan pesanan (*authorization check*).

---

## 🛠️ Teknologi yang Digunakan

| Layer / Komponen | Teknologi | Keterangan |
|---|---|---|
| **Backend Framework** | Laravel 12.x | Arsitektur MVC, Eloquent ORM, Form Request |
| **Auth Scaffolding** | Laravel Breeze | Autentikasi berbasis Blade & Session |
| **Styling & Design** | Tailwind CSS v4 | Dark Mode Admin, Glassmorphism Storefront |
| **Visual Charting** | Chart.js v4.x | Line, Bar, & Doughnut Charts interaktif |
| **Image Processing** | Cropper.js v1.6 | 1:1 Square Image Cropping via Canvas & DataTransfer |
| **Pop-Up & Alerts** | SweetAlert2 v11 | Modal konfirmasi hapus, verifikasi, & flash toast |
| **Database Engine** | MySQL 8.x | 6 Tabel relasional dengan foreign key constraints |
| **Automated Testing** | PHPUnit | 31 Feature Tests & 94 Assertions (100% Passed) |

---

## 🏗️ Struktur Direktori Project (Laravel MVC)

```text
e_commerce_ujikom/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── CategoryController.php   # CRUD Kategori
│   │   │   │   ├── DashboardController.php  # Analytics, KPI & Chart Data
│   │   │   │   ├── OrderController.php      # Verifikasi & Status Workflow
│   │   │   │   ├── ProductController.php    # CRUD Produk & Cropper Integration
│   │   │   │   └── ReportController.php     # Laporan & Agregasi Adaptif
│   │   │   ├── Auth/                        # Controller Autentikasi
│   │   │   ├── CartController.php           # Persistent User Cart
│   │   │   ├── CheckoutController.php       # Transaksi Checkout & Stok
│   │   │   ├── OrderController.php          # Riwayat Order & Bukti Transfer
│   │   │   ├── ProductController.php        # Katalog Publik & Filter
│   │   │   └── ProfileController.php        # Profil User
│   │   └── Middleware/
│   │       └── AdminMiddleware.php          # Gatekeeper Khusus Role Admin
│   └── Models/                              # Eloquent Models (User, Category, Product, Order, OrderItem, Payment)
├── database/
│   ├── migrations/                          # Migrasi Skema Database
│   └── seeders/                             # Seeder Akun Admin, Customer, Produk, & 13 Demo Orders
├── resources/
│   └── views/
│       ├── admin/                           # Tampilan Admin Panel (Dark Theme & Responsive Drawer)
│       │   ├── categories/                  # View Index, Create, Edit Kategori
│       │   ├── dashboard/                   # View Analytics, KPI, & Chart.js
│       │   ├── orders/                      # View Daftar, Detail, & Struk Invoice
│       │   ├── products/                    # View Katalog Admin & Image Cropper
│       │   └── reports/                     # View Laporan Penjualan & Cetak PDF
│       ├── errors/                          # Custom Error Pages (403.blade.php & 404.blade.php)
│       ├── layouts/                         # Master Layouts (admin.blade.php & app.blade.php)
│       ├── cart/ & checkout/ & orders/      # View Customer Journey
│       └── products/                        # View Katalog Publik & Hero Carousel
└── tests/
    └── Feature/                             # 31 Automated Feature Tests (OrderWorkflowTest, etc.)
```

---

## 🔑 Kredensial Akun Demo Pengujian

Tersedia akun demo bawaan yang siap digunakan saat ujian/asesmen:

| Peran (Role) | Alamat Email | Password | URL Akses |
|---|---|---|---|
| **Admin** | `admin@wahyugadget.com` | `password` | `http://localhost:8000/admin/dashboard` |
| **Customer** | `customer@example.com` | `password` | `http://localhost:8000/login` |

> *Tip: Pada halaman Login tersedia tombol **Auto-Fill Demo** untuk mengisi kredensial Admin atau Customer secara instan dengan 1 klik.*

---

## 💻 Panduan Instalasi & Menjalankan Project

### 1. Prasyarat Sistem
* PHP $\ge$ 8.2 (Disarankan PHP 8.4)
* Composer $\ge$ 2.x
* Node.js $\ge$ 18.x & NPM
* MySQL / MariaDB Server (misal via Laragon atau XAMPP)

### 2. Langkah Instalasi

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/WaySTN/e-commerce_ujikom.git
   cd e-commerce_ujikom
   ```

2. **Instal Dependensi**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi File Environment (`.env`)**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan konfigurasi database pada `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=e_commerce_ujikom
   DB_USERNAME=root
   DB_PASSWORD=
   
   SESSION_DRIVER=file
   ```

4. **Migrasi Database & Seeder Data Lengkap**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Buat Symlink Penyimpanan Gambar**:
   ```bash
   php artisan storage:link
   ```

6. **Kompilasi Aset Frontend**:
   ```bash
   npm run build
   ```

7. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka browser pada: **`http://127.0.0.1:8000`**

---

## 🧪 Pengujian Otomatis (Automated Testing)

Project ini dilengkapi dengan **31 Feature & Integration Tests (94 Assertions)** yang mencakup seluruh alur bisnis:
* Checkout & pengurangan stok produk.
* Rollback stok saat admin membatalkan pesanan.
* Otomasi status pembayaran LUNAS pada pesanan COD yang diselesaikan.
* Otorisasi isolasi data order antar customer (HTTP 403).
* Filter laporan penjualan rentang pendek (harian), rentang panjang (bulanan), dan tanggal terbalik.

Jalankan pengujian kapan saja dengan perintah:
```bash
php artisan test
```

---

## 📋 Checklist Kesesuaian Requirement Uji Kompetensi BNSP

| Persyaratan Asesor / Skema BNSP | Status | Implementasi Solusi |
|---|:---:|---|
| **Entitas Admin & Tamu** | ✅ **Selesai** | Role `admin` dan `customer` (+ guest sebelum login) dengan `AdminMiddleware` |
| **Tamu bisa Registrasi & Login** | ✅ **Selesai** | Halaman register & login lengkap dengan auto-fill demo & SweetAlert2 popup |
| **Tamu bisa Order (Keranjang & Checkout)** | ✅ **Selesai** | Persistent Cart, form checkout alamat, kalkulasi subtotal/total otomatis |
| **Proses Pembayaran (Transfer & COD)** | ✅ **Selesai** | Upload bukti bayar transfer & otomatisasi status pada metode COD |
| **Admin Cek Order Masuk** | ✅ **Selesai** | Halaman `/admin/pesanan` dengan filter status order & status bayar |
| **Admin Proses Pemesanan** | ✅ **Selesai** | Verifikasi bayar (`LUNAS`/`DITOLAK`) & update tahapan pesanan + rollback stok |
| **Admin Cek Laporan** | ✅ **Selesai** | Halaman `/admin/laporan` dengan filter tanggal, metrik omset, top seller & rincian |
| **Visualisasi Grafik (Permintaan Asesor)** | ✅ **Selesai** | Chart.js Tren Omset 7 Hari, Donat Kategori, & Grafik Laporan Penjualan Adaptif |
| **Fitur Cetak Struk & Laporan (PDF)** | ✅ **Selesai** | Dual-mode screen & print layout (A4 official letterhead + signature block) |
| **Responsive Design All Viewports** | ✅ **Selesai** | Off-canvas drawer sidebar, hamburger toggle, dan layout adaptif 375px - 4K |

---

## 📜 Lisensi
Dikembangkan untuk keperluan **Uji Kompetensi BNSP Skema Junior Web Programming**. Hak cipta dilindungi.

