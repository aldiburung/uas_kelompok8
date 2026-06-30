# Sistem Informasi Komoditas Desa dan Keuangan Modern (KDKMP)

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 📌 Deskripsi Proyek
**KDKMP** adalah aplikasi berbasis web yang dirancang untuk memfasilitasi transaksi keuangan modern desa serta manajemen sistem barter komoditas desa secara digital. Sistem ini dibangun sebagai pemenuhan tugas Ujian Akhir Semester (UAS) mata kuliah Rekayasa Perangkat Lunak.

Proyek ini dikembangkan secara penuh oleh **Kelompok 8**:
- **Aldi Burung** (Project Manager / Fullstack Developer)
- **Julia** (System Analyst / Fullstack Developer)
- **Sopyan** (Frontend Developer / UI/UX Designer)

*Waktu Pengerjaan: 3 Minggu (21 Hari)*

---

## 🚀 Fitur Utama & Hak Akses (Role-Based Access Control)
Sistem memisahkan wewenang kerja melalui hak akses peran pengguna (RBAC) menjadi 2 role utama:

1. **Role: Keuangan**
   - Mengelola (CRUD) Transaksi Keuangan Desa (Pemasukan/Pengeluaran).
   - Manajemen Termin (Cicilan Pembayaran).
   - Menghasilkan dan memfilter Laporan Keuangan Global.

2. **Role: Barter**
   - Mengelola (CRUD) Katalog Komoditas hasil bumi miliknya.
   - Mencatat Transaksi Barter secara internal (Otomatis mengurangi stok komoditas).
   - Melihat Riwayat Transaksi Barter.

---

## 🛠️ Panduan Instalasi (Development Setup)

### Persyaratan Sistem:
- PHP >= 8.2 (Disarankan PHP 8.3 via Laragon / XAMPP)
- Composer 2.x
- Node.js & NPM
- MySQL / MariaDB

### Langkah-langkah Instalasi:
1. **Clone Repository**
   ```bash
   git clone https://github.com/aldiburung/uas_kelompok8.git
   cd uas_kelompok8
   ```

2. **Install Dependencies (PHP & Node.js)**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   - Copy file `.env.example` menjadi `.env`
   - Sesuaikan konfigurasi koneksi database di file `.env`
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kdkmp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding Data Awal**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Catatan: Proses ini akan mengenerate data contoh transaksi dan komoditas, serta 2 akun pengujian)*

6. **Build Frontend Assets**
   ```bash
   npm run build
   # Atau jika sedang development: npm run dev
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Buka browser dan akses: `http://localhost:8000`

---

## 🔑 Akun Uji Coba (Testing Accounts)
Untuk mencoba fitur aplikasi sesuai role, gunakan kredensial berikut (dibuat otomatis oleh seeder):

| Role | Email | Password |
|------|-------|----------|
| **Keuangan** | `keuangan@example.com` | `password` |
| **Barter** | `barter@example.com` | `password` |

---

## 📚 Dokumentasi Lebih Lanjut
Untuk panduan yang lebih detail mengenai arsitektur sistem, struktur database, alur kerja (workflow), dan rancangan jadwal, silakan periksa dokumen berikut:
- [DOKUMENTASI LENGKAP KDKMP](DOKUMENTASI_KDKMP.md)
- [PANDUAN SISTEM ROLE](ROLE_SYSTEM_GUIDE.md)
- [LAPORAN PROGRES & GANTT CHART](project_management/cetak_laporan.html)
- [SOFTWARE REQUIREMENTS SPECIFICATION](project_management/SRS.md)