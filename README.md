# ⚡ Wahyu Gadget Pedia — E-Commerce Aksesori Gadget

[![Laravel Version](https://img.shields.io/badge/Laravel-v12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.4.x-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.x-38bdf8.svg)](https://tailwindcss.com)
[![Tests Status](https://img.shields.io/badge/Tests-26%20Passed-emerald.svg)](https://phpunit.de)
[![BNSP Certification](https://img.shields.io/badge/BNSP-Junior_Web_Programming-gold.svg)](#)

Aplikasi Web **E-Commerce Wahyu Gadget Pedia** dibangun menggunakan framework **Laravel 12**, **Tailwind CSS v4**, dan **MySQL** sebagai bagian dari **Uji Kompetensi Sertifikasi BNSP Skema "Junior Web Programming"**.

Aplikasi ini menyediakan platform belanja online komprehensif untuk produk aksesori gadget (charger, casing, earphone TWS, powerbank, dll.) yang dilengkapi dengan peran **Tamu (Guest)**, **Customer (Pembeli)**, dan **Admin (Pengelola Toko)**.

---

## 🚀 Fitur Utama Aplikasi

### 🛒 1. Fitur Tamu & Customer (Pembeli)
* **Katalog Produk Publik**: Pencarian produk secara *real-time* berdasarkan nama & filter kategori lengkap dengan pagination.
* **Hero Banner Carousel**: Slider 3 banner gadget dengan animasi geser kanan (*autoplay rightward slide* 4.5s), tombol kontrol `❮` & `❯`, dan indikator titik.
* **Pop-Up Validasi Login Guest (SweetAlert2)**: Saat pengunjung yang belum login menekan tombol `+ Keranjang`, muncul modal dialog interaktif pilihan *Masuk ke Akun* atau *Daftar Baru* tanpa me-redirect paksa.
* **Persistent User Cart (Keranjang Tersimpan)**: Keranjang belanja akun customer diikat ke `user_id` sehingga isi keranjang tidak pernah hilang meskipun customer melakukan *logout* dan *login kembali*.
* **Checkout & Transaksi Transparan**: Form alamat pengiriman, catatan, serta pilihan metode pembayaran **Transfer Bank (BCA/Mandiri/BRI)** atau **COD (Cash On Delivery)**. Pembuatan pesanan bersifat *atomic* yang langsung mengunci stok produk di database.
* **Riwayat & Detail Pesanan**: Pemantauan status order, invoice timeline (`INV-YYYYMMDD-XXXX`), serta form pengunggahan bukti transfer bank.

### 📊 2. Fitur Admin Panel Control (`/admin/dashboard`)
* **Dashboard Analisa Bisnis & Penjualan**:
  * KPI Matriks: Total Pendapatan Lunas (Rp), Pendapatan Bulan Ini, Total Orders, Pending Orders, dan Low Stock Warning (Stok <= 5 unit).
  * Visual Breakdown Progress Bar Status Order & Status Pembayaran.
  * Widget Peringatan Stok Menipis (*Low Stock Alert*) & Top 5 Produk Terlaris (*Best Sellers*).
* **Komponen Image Cropper (Cropper.js 1:1 Square)**: Modal cropper interaktif saat upload/edit foto produk dengan kontrol Zoom, Rotate, & Reset. Hasil potongan dikonversi otomatis menjadi file JPEG 800x800px presisi.
* **Sistem Pop-Up Modal Validasi & Konfirmasi (SweetAlert2)**: Modal konfirmasi sebelum menghapus data (Kategori/Produk), verifikasi pembayaran (`LUNAS`/`DITOLAK`), update status order, serta Toast alert animasi sukses/gagal.
* **Fixed Sidebar & Navigation**: Sidebar mengusung posisi *fixed* (tidak tergeser saat scroll) dengan tombol logout & link storefront di bagian bawah.
* **Kelola Kategori & Produk**: Full CRUD (Create, Read, Update, Delete) dengan filter search & kategori.
* **Kelola Order & Verifikasi Pembayaran**: Verifikasi bukti transfer customer & perbaruan status order (`pending` → `diproses` → `dikirim` → `selesai` / `dibatalkan`).
* **Laporan Penjualan**: Filter rentang tanggal transaksi, total pendapatan lunas, & rekapitulasi barang terlaris.

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework**: Laravel 12.x (MVC Pattern)
* **Auth Scaffolding**: Laravel Breeze (Blade Stack)
* **Styling & UI Design**: Tailwind CSS v4 + Google Fonts (Outfit)
* **Database Engine**: MySQL 8.x
* **Interaktivitas Frontend**: Alpine.js & Vanilla JavaScript
* **Pop-Up & Toast System**: SweetAlert2 (v11)
* **Image Processing**: Cropper.js (v1.6) & DataTransfer API
* **Automated Testing**: PHPUnit / Laravel Test Runner (26 Feature Tests)

---

## 🔑 Kredensial Akun Demo Asesmen

Gunakan akun demo berikut untuk menguji seluruh fitur aplikasi:

| Peran (Role) | Alamat Email | Kata Sandi (Password) | URL Akses |
|---|---|---|---|
| **Admin** | `admin@wahyugadget.com` | `password` | `http://localhost:8000/admin/dashboard` |
| **Customer** | `customer@example.com` | `password` | `http://localhost:8000/login` |

> *Catatan: Pada halaman Login tersedia tombol **Auto-Fill Demo** yang dapat diklik untuk langsung mengisi kredensial di atas secara cepat.*

---

## 💻 Panduan Instalasi & Menjalankan Project

### 1. Prasyarat Sistem
* PHP >= 8.2 (Disarankan PHP 8.4)
* Composer >= 2.x
* Node.js >= 18.x & NPM
* MySQL / MariaDB Server (misal via Laragon atau XAMPP)

### 2. Langkah-Langkah Instalasi

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/WaySTN/e-commerce_ujikom.git
   cd e-commerce_ujikom
   ```

2. **Instal Dependensi PHP & JavaScript**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`)**:
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan pengaturan database di file `.env` disesuaikan dengan MySQL lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=e_commerce_ujikom
   DB_USERNAME=root
   DB_PASSWORD=
   
   SESSION_DRIVER=file
   ```

4. **Migrasi Database & Seeder Data Demo**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Buat Symlink Storage Gambar**:
   ```bash
   php artisan storage:link
   ```

6. **Kompilasi Aset Frontend Produksi**:
   ```bash
   npm run build
   ```

7. **Jalankan Web Server**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada URL: **`http://127.0.0.1:8000`**

---

## 🧪 Pengujian Otomatis (Automated Testing)

Project ini dilengkapi dengan **26 Feature & Integration Tests** untuk menjamin kestabilan fitur auth, role middleware, cart persistence, checkout, dan admin CRUD.

Jalankan pengujian otomatis menggunakan perintah:
```bash
php artisan test
```

*Seluruh pengujian berjalan di database terpisah (`e_commerce_ujikom_testing`) sehingga data utama di database MySQL Anda aman dan tidak terhapus.*

---

## 📜 Lisensi & Penutup

Project ini dibuat untuk memenuhi tugas **Uji Kompetensi BNSP Skema Junior Web Programming**. Hak cipta dilindungi undang-undang.
