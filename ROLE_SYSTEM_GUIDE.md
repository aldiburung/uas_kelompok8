# 2-Level Role-Based Access Control System

## Overview
Sistem otorisasi berbasis peran (Role-Based Access Control) pada aplikasi KDKMP dirancang dengan memisahkan wewenang kerja menjadi 2 peran utama: **Keuangan** dan **Barter**. Hal ini meminimalkan risiko kesalahan input data dan menjaga keamanan informasi finansial desa.

## Roles & Access Control

### 1. **Keuangan** (role: `keuangan`)
* **Hak Akses:** Modul Keuangan (`keuangan`), Modul Termin (`termins`), dan Modul Laporan (`reports`).
* **Fitur:** 
  * CRUD Catatan Keuangan (Pemasukan & Pengeluaran).
  * CRUD Termin/Cicilan Pembayaran.
  * Menghasilkan Laporan Keuangan berdasarkan filter tanggal.
* **Akses Dilarang:** Modul Barter dan Modul Permintaan Barter (akan dialihkan ke halaman error 403).

### 2. **Barter** (role: `barter`)
* **Hak Akses:** Modul Katalog Komoditas (`barter`) dan Modul Transaksi Barter Internal (`barter-requests`).
* **Fitur:**
  * CRUD Komoditas/Hasil Bumi milik sendiri.
  * Mencatat transaksi barter secara internal (otomatis mengurangi stok komoditas miliknya).
  * Melihat riwayat catatan transaksi barter yang dilakukan.
* **Akses Dilarang:** Modul Keuangan, Modul Laporan, dan Modul Termin (akan dialihkan ke halaman error 403).

---

## Implementasi Teknis

### 1. Model User
Didefinisikan di `app/Models/User.php` dengan helper method:
```php
// Cek kecocokan single role
public function hasRole(string $role): bool

// Cek kecocokan multiple roles
public function hasAnyRole(array $roles): bool
```

### 2. CheckRole Middleware
* **Lokasi file:** `app/Http/Middleware/CheckRole.php`
* **Registrasi:** Didaftarkan sebagai alias `role` pada konfigurasi routing middleware.
* **Logika:** Membandingkan role user yang sedang aktif dengan daftar role yang diizinkan untuk route tersebut. Jika tidak cocok, sistem akan menolak akses secara langsung dengan status **HTTP 403 Forbidden**.

### 3. Database Seeder
Dua akun pengujian utama telah dikonfigurasi pada `database/seeders/DatabaseSeeder.php`:
1. **Keuangan:**
   * Email: `keuangan@example.com`
   * Password: `password`
2. **Barter:**
   * Email: `barter@example.com`
   * Password: `password`
