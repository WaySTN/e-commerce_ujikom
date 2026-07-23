# Project Requirements Document (PRD)
## Aplikasi E-Commerce Sederhana — Uji Kompetensi BNSP "Junior Web Programming"

> Dokumen ini adalah spesifikasi lengkap untuk AI coding agent. Ikuti struktur, penamaan, dan alur di bawah ini secara konsisten saat implementasi.

---

## 1. Latar Belakang & Tujuan

Project ini dibuat untuk memenuhi syarat kelulusan mahasiswa berupa Uji Kompetensi BNSP skema **Junior Web Programming**. Requirement dari dosen/asesor:

> "Aplikasi bebas (dicek kembali di dokumen resmi). Paling tidak seperti E-Commerce, terdapat entitas Admin dan Tamu. Tamu bisa registrasi, order, dan proses pembayaran. Admin bisa cek Order dan proses pemesanan, dan cek Laporan."

**Prinsip pengerjaan:** implementasi harus **fungsional dan memenuhi seluruh kriteria di atas**, tanpa over-engineering. Prioritaskan kelengkapan alur kerja (workflow) dibanding fitur tambahan yang tidak diminta.

---

## 2. Tech Stack

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel (versi terbaru stabil, gunakan MVC pattern) |
| Auth Scaffolding | Laravel Breeze (Blade + Tailwind stack) |
| Frontend/Styling | Tailwind CSS (bawaan dari Breeze) |
| Database | MySQL |
| Template Engine | Blade |
| Cart Storage | Session-based (tidak perlu tabel `carts` terpisah, cukup array di session) |

Tidak menggunakan Vue/React/Livewire kecuali disebutkan lain — cukup Blade + sedikit vanilla JS/Alpine.js (opsional, sudah tersedia di Breeze) untuk interaktivitas ringan.

---

## 3. Entitas / Role Pengguna

| Role | Deskripsi | Middleware |
|---|---|---|
| **Tamu (Guest)** | Pengunjung belum login. Bisa lihat katalog, register, login. | - |
| **Customer** | User terdaftar dengan `role = customer` (default saat register). Bisa order & bayar. | `auth` |
| **Admin** | User dengan `role = admin`. Dibuat via seeder, tidak ada form register untuk admin. | `auth` + custom `admin` middleware |

Kolom `role` ditambahkan ke tabel `users` bawaan Laravel (enum: `admin`, `customer`, default `customer`).

---

## 4. Functional Requirements

### 4.1 Tamu (Guest / belum login)
- Melihat halaman utama berisi daftar produk (dengan pagination).
- Melihat detail satu produk.
- Bisa mencari produk (search by name) dan filter by kategori.
- Registrasi akun baru (name, email, password, password_confirmation).
- Login.
- Mencoba akses fitur order/checkout tanpa login → redirect ke halaman login.

### 4.2 Customer (setelah login)
- Menambahkan produk ke keranjang (session cart).
- Melihat isi keranjang, mengubah jumlah (qty), menghapus item.
- Checkout: isi alamat pengiriman & catatan (opsional), pilih metode pembayaran.
- Metode pembayaran yang didukung:
  - **Transfer Bank (manual)** → setelah order dibuat, customer upload bukti transfer (gambar).
  - **COD (Cash on Delivery)** → tidak perlu bukti bayar, status pembayaran otomatis "menunggu" sampai admin konfirmasi barang diterima.
- Setelah checkout berhasil → order dibuat dengan status `pending`, stok produk berkurang sesuai qty.
- Melihat riwayat pesanan sendiri (list order + status).
- Melihat detail satu pesanan (item, total, status pembayaran, status order).
- Logout.

### 4.3 Admin
- Login (tidak ada halaman register untuk admin; akun dibuat lewat seeder).
- **Dashboard**: ringkasan total order, total pendapatan (dari order dengan payment status `lunas`), jumlah order berstatus `pending`, jumlah produk.
- **Kelola Produk** (CRUD): nama, kategori, harga, stok, deskripsi, gambar, status aktif/nonaktif.
- **Kelola Kategori** (CRUD): nama kategori.
- **Kelola Order**:
  - Melihat semua order (filter by status order & status pembayaran).
  - Melihat detail order (data customer, item, alamat, bukti bayar jika ada).
  - Verifikasi pembayaran: ubah status payment dari `menunggu` → `lunas` atau `ditolak`.
  - Update status order: `pending` → `diproses` → `dikirim` → `selesai` (atau `dibatalkan`).
- **Laporan**:
  - Laporan penjualan dengan filter rentang tanggal.
  - Menampilkan: total transaksi, total pendapatan, daftar order dalam rentang tersebut.
  - (Opsional/nilai tambah) Produk terlaris — hitung dari total qty terjual per produk.

---

## 5. Database Schema

### `users` (extend tabel bawaan Laravel)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | string | |
| email | string, unique | |
| password | string (hashed) | |
| role | enum('admin','customer') | default `customer` |
| email_verified_at, remember_token, timestamps | default Laravel | |

### `categories`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | string | |
| slug | string, unique | |
| timestamps | | |

### `products`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| category_id | bigint, FK → categories.id, nullable | |
| name | string | |
| slug | string, unique | |
| description | text, nullable | |
| price | decimal(10,2) | |
| stock | integer, default 0 | |
| image | string, nullable | path file gambar |
| is_active | boolean, default true | |
| timestamps | | |

### `orders`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| user_id | bigint, FK → users.id | |
| order_number | string, unique | format contoh: `INV-20260723-0001` |
| total_price | decimal(10,2) | |
| shipping_address | text | |
| notes | text, nullable | |
| status | enum('pending','diproses','dikirim','selesai','dibatalkan') | default `pending` |
| timestamps | | |

### `order_items`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| order_id | bigint, FK → orders.id | |
| product_id | bigint, FK → products.id | |
| product_name | string | snapshot nama produk saat order dibuat |
| price | decimal(10,2) | snapshot harga saat order dibuat |
| qty | integer | |
| subtotal | decimal(10,2) | |
| timestamps | | |

### `payments`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| order_id | bigint, FK → orders.id, unique | 1 order = 1 payment |
| method | enum('transfer','cod') | |
| proof_image | string, nullable | wajib diisi jika method = transfer |
| status | enum('menunggu','lunas','ditolak') | default `menunggu` |
| paid_at | timestamp, nullable | |
| timestamps | | |

### Relasi Eloquent
- `User hasMany Order`
- `Category hasMany Product`
- `Product belongsTo Category`
- `Order belongsTo User`
- `Order hasMany OrderItem`
- `Order hasOne Payment`
- `OrderItem belongsTo Product`

---

## 6. Alur Aplikasi (User Journey)

```
Tamu buka katalog → lihat produk → klik "Beli"
      │
      ▼ (belum login)
   Redirect ke Login/Register
      │
      ▼ (sudah login sebagai Customer)
   Tambah ke keranjang → Checkout
      │
      ▼
   Isi alamat + pilih metode bayar → Order dibuat (status: pending)
      │
      ├─ Transfer: upload bukti bayar → menunggu verifikasi admin
      └─ COD: langsung menunggu diproses admin
      │
      ▼
   Admin cek order masuk → verifikasi pembayaran (lunas/ditolak)
      │
      ▼
   Admin update status order: diproses → dikirim → selesai
      │
      ▼
   Customer bisa pantau status di halaman "Pesanan Saya"
      │
      ▼
   Admin lihat rekap di halaman Laporan
```

---

## 7. Routing (ringkasan)

### Public / Guest
```
GET  /                          -> katalog produk
GET  /produk/{slug}             -> detail produk
GET  /register | POST /register
GET  /login    | POST /login
POST /logout
```

### Customer (middleware: auth)
```
GET   /keranjang
POST  /keranjang/{product}
PATCH /keranjang/{product}
DELETE /keranjang/{product}
GET   /checkout
POST  /checkout
GET   /pesanan
GET   /pesanan/{order}
POST  /pesanan/{order}/bukti-bayar
```

### Admin (middleware: auth, admin — prefix /admin)
```
GET /admin/dashboard
Resource: /admin/produk
Resource: /admin/kategori
GET   /admin/pesanan
GET   /admin/pesanan/{order}
PATCH /admin/pesanan/{order}/status
PATCH /admin/pesanan/{order}/verifikasi-bayar
GET   /admin/laporan
```

---

## 8. Validasi & Aturan Bisnis

- Register: `name` required, `email` required|email|unique, `password` required|min:8|confirmed.
- Produk: `name` required, `price` required|numeric|min:0, `stock` required|integer|min:0, `image` nullable|image|mimes:jpg,jpeg,png|max:2048.
- Checkout: `shipping_address` required, `payment_method` required|in:transfer,cod. Keranjang tidak boleh kosong.
- Upload bukti bayar: wajib jika `method = transfer`, image only, max 2MB.
- Stok produk berkurang otomatis saat order dibuat; jangan izinkan checkout jika stok tidak mencukupi.
- Order yang sudah `selesai` atau `dibatalkan` tidak bisa diubah statusnya lagi.
- Hanya admin yang bisa mengubah status order & verifikasi pembayaran.
- Customer hanya bisa melihat order miliknya sendiri (authorization check di controller/policy).

---

## 9. Folder Structure (Laravel MVC)

```
app/
 ├─ Http/
 │   ├─ Controllers/
 │   │   ├─ ProductController.php       (katalog publik)
 │   │   ├─ CartController.php
 │   │   ├─ CheckoutController.php
 │   │   ├─ OrderController.php         (riwayat order customer)
 │   │   └─ Admin/
 │   │       ├─ DashboardController.php
 │   │       ├─ ProductController.php
 │   │       ├─ CategoryController.php
 │   │       ├─ OrderController.php
 │   │       └─ ReportController.php
 │   └─ Middleware/
 │       └─ AdminMiddleware.php
 ├─ Models/
 │   ├─ User.php
 │   ├─ Category.php
 │   ├─ Product.php
 │   ├─ Order.php
 │   ├─ OrderItem.php
 │   └─ Payment.php
resources/
 └─ views/
     ├─ layouts/
     │   ├─ app.blade.php          (layout customer/guest)
     │   └─ admin.blade.php        (layout admin)
     ├─ products/
     ├─ cart/
     ├─ checkout/
     ├─ orders/
     └─ admin/
         ├─ dashboard/
         ├─ products/
         ├─ categories/
         ├─ orders/
         └─ reports/
database/
 ├─ migrations/
 └─ seeders/
     ├─ AdminUserSeeder.php   (buat 1 akun admin default)
     └─ ProductSeeder.php     (data dummy kategori & produk)
```

---

## 10. UI/UX Guidelines

- Gunakan Tailwind CSS, desain bersih dan responsif (mobile-first).
- Layout terpisah jelas antara area publik/customer dan area admin (sidebar admin berbeda dari navbar customer).
- Gunakan flash message (session) untuk feedback aksi (berhasil tambah ke keranjang, order berhasil dibuat, dll).
- Tabel admin (produk, order) sebaiknya pakai pagination bawaan Laravel.
- Badge warna berbeda untuk tiap status order/pembayaran (misal: kuning = pending/menunggu, biru = diproses, hijau = selesai/lunas, merah = dibatalkan/ditolak).

---

## 11. Seeder / Data Demo (wajib untuk keperluan demo saat ujian)

- 1 akun admin: contoh `admin@example.com` / password `password`.
- 1-2 akun customer contoh.
- Minimal 2 kategori & 6-8 produk dengan stok dan harga bervariasi.

---

## 12. Checklist Kesesuaian dengan Requirement Dosen

| Requirement Dosen | Dipenuhi Oleh |
|---|---|
| Entitas Admin & Tamu | Role `admin` & `customer` (+ guest sebelum login) |
| Tamu bisa registrasi | Halaman register (Breeze) |
| Tamu bisa order | Cart → Checkout → Order (role customer setelah login) |
| Tamu bisa proses pembayaran | Upload bukti transfer / COD di halaman checkout & pesanan |
| Admin cek Order | Halaman `/admin/pesanan` |
| Admin proses pemesanan | Update status order & verifikasi pembayaran |
| Admin cek Laporan | Halaman `/admin/laporan` |

---

## 13. Catatan untuk AI Agent

- Ikuti konvensi Laravel standar (Eloquent, Form Request untuk validasi, Route Model Binding).
- Gunakan migration terpisah per tabel sesuai skema di atas.
- Gunakan `php artisan make:model X -mcr` untuk generate model + migration + controller sekaligus bila relevan.
- Jangan tambahkan fitur di luar scope dokumen ini kecuali diminta eksplisit (payment gateway asli, multi-bahasa, dsb) — tujuan project ini kelulusan uji kompetensi, bukan produk komersial.
- Prioritaskan alur end-to-end berjalan (register → order → bayar → admin proses → laporan) sebelum polishing UI.
