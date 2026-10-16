# Marketplace Katering

Aplikasi marketplace B2B yang menghubungkan **perusahaan katering (merchant)** dengan **kantor (customer)** yang membutuhkan katering untuk karyawannya.

Dibangun dengan **Laravel 13**, **Blade**, **Bootstrap 5**, dan **MySQL**.

## Fitur

### Portal Merchant
- Registrasi & login.
- Kelola profil perusahaan.
- CRUD menu (nama, deskripsi, foto, harga, status ketersediaan).
- Lihat pesanan masuk & perbarui status pesanan.
- Lihat invoice.

### Portal Customer (Kantor)
- Registrasi & login.
- Cari katering (filter lokasi & jenis makanan).
- Lihat profil & menu katering.
- Checkout (pilih menu, jumlah porsi, tanggal pengiriman, alamat).
- Riwayat pesanan & invoice.

### Portal Admin (tambahan)
- Dashboard statistik.
- Kelola pengguna (CRUD), daftar merchant, semua pesanan.

## Aturan bisnis penting
- Harga & total dihitung ulang di server (tidak dipercaya dari browser).
- Checkout dibungkus database transaction — tidak ada transaksi parsial.
- Nama menu & harga disimpan sebagai **snapshot** pada `order_items`.
- Invoice dibuat otomatis & unik, dapat diakses kedua pihak.
- Kepemilikan data diperiksa (merchant/customer hanya akses datanya sendiri).

## Kebutuhan
- PHP 8.3+
- Composer
- MySQL

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database pada `.env`, lalu:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Buka `http://localhost:8000`.

## Akun Demo (dari seeder)

| Role     | Email                     | Password |
|----------|---------------------------|----------|
| Admin    | admin@example.com         | password |
| Merchant | merchant@example.com      | password |
| Merchant | merchant2@example.com     | password |
| Customer | customer@example.com      | password |

## Pengujian

```bash
php artisan test
vendor/bin/pint --test
```

## Struktur Singkat

```
app/
├── Http/
│   ├── Controllers/  (Admin, Auth, Customer, Merchant, Concerns)
│   ├── Middleware/   (EnsureUserHasRole)
│   └── Requests/
├── Models/
└── Services/         (OrderService, InvoiceService)

resources/views/
├── layouts/  (Bootstrap 5 + Font Awesome)
├── components/
├── admin/
├── merchant/
└── customer/
```

## Teknologi Frontend
- Bootstrap 5 (CDN)
- Font Awesome (CDN)
- jQuery + DataTables (CDN) — DataTables dijalankan **server-side** memakai query Eloquent manual (tanpa package tambahan).
