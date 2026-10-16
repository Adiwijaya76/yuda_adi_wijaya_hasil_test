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
