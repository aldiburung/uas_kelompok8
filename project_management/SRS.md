# Software Requirements Specification (SRS)
## Sistem Informasi Komoditas Desa dan Keuangan Modern (KDKMP)

### Dokumen Informasi
* **Nama Proyek:** Sistem Informasi Komoditas Desa dan Keuangan Modern (KDKMP)
* **Versi:** 1.0.0
* **Tanggal:** 18 Juni 2026
* **Penulis:** 
  1. Aldi Burung (Project Manager / Developer)
  2. Julia (System Analyst / Developer)

---

## 1. Pendahuluan

### 1.1 Tujuan
Dokumen Software Requirements Specification (SRS) ini bertujuan untuk mendefinisikan kebutuhan fungsional dan non-fungsional dari pengembangan Sistem Informasi Komoditas Desa dan Keuangan Modern (KDKMP). Dokumen ini ditujukan bagi dosen penguji, tim pengembang, dan stakeholder terkait.

### 1.2 Lingkup Sistem
Sistem KDKMP adalah aplikasi berbasis web yang dirancang khusus untuk memfasilitasi transaksi keuangan modern desa serta manajemen sistem barter komoditas desa secara digital. Sistem memisahkan wewenang kerja melalui hak akses peran pengguna (Role-Based Access Control).

### 1.3 Akronim & Definisi
* **SRS:** *Software Requirements Specification*
* **KDKMP:** Komoditas Desa dan Keuangan Modern
* **RBAC:** *Role-Based Access Control*
* **CRUD:** *Create, Read, Update, Delete*

---

## 2. Deskripsi Umum

### 2.1 Perspektif Produk
Sistem KDKMP berjalan di lingkungan server berbasis PHP (Laravel Framework) dengan database relasional MySQL. Antarmuka pengguna dirancang responsif menggunakan CSS Tailwind untuk memastikan aksesibilitas yang baik dari perangkat komputer maupun mobile.

### 2.2 Peran Pengguna (User Roles)
Sistem memiliki 2 level aktor utama:
1. **Keuangan:** Pengguna yang bertanggung jawab mencatat data pemasukan/pengeluaran desa, mengelola term pembiayaan (termin), dan menghasilkan laporan keuangan global.
2. **Barter:** Pengguna (pelaku usaha/petani desa) yang dapat mencatat komoditas yang tersedia, serta mencatat transaksi barter internal desa.

---

## 3. Kebutuhan Fungsional (Functional Requirements)

### 3.1 Manajemen Autentikasi
* **FR-01 (Registrasi):** Sistem harus memungkinkan pengguna baru membuat akun dengan mengisi Nama, Email, Password, dan memilih Role (Keuangan / Barter).
* **FR-02 (Login):** Sistem harus memverifikasi kredensial pengguna (email & password) sebelum memberikan akses ke dalam sistem.
* **FR-03 (Logout):** Sistem harus mengakhiri sesi aktif pengguna dan mengembalikannya ke landing page.

### 3.2 Modul Keuangan (Khusus Role: Keuangan)
* **FR-04 (CRUD Transaksi Keuangan):** Pengguna dengan role Keuangan dapat menambah, melihat, mengupdate, dan menghapus catatan transaksi keuangan (deskripsi, kategori, jumlah, tanggal transaksi, termin terkait, dan catatan tambahan).
* **FR-05 (Manajemen Termin):** Pengguna dengan role Keuangan dapat mendefinisikan termin pembayaran untuk mempermudah kategorisasi transaksi berkala.
* **FR-06 (Laporan Keuangan):** Sistem harus menyediakan fitur untuk memfilter dan menampilkan ringkasan laporan keuangan global berdasarkan rentang tanggal tertentu.

### 3.3 Modul Barter (Khusus Role: Barter)
* **FR-07 (CRUD Komoditas):** Pengguna dengan role Barter dapat mengelola katalog komoditas mereka sendiri (Nama, Desa Asal, Satuan, Stok, Estimasi Nilai, Deskripsi).
* **FR-08 (Pencatatan Transaksi Barter):** Pengguna dapat mencatat transaksi barter secara internal yang secara otomatis akan memotong stok komoditas miliknya.
* **FR-09 (Riwayat Transaksi Barter):** Pengguna dapat melihat daftar transaksi barter internal yang pernah mereka lakukan.

### 3.4 Dashboard & Statistik Global
* **FR-10 (Statistik Global):** Dashboard sistem harus menampilkan ringkasan berupa total jumlah transaksi keuangan global, total jumlah komoditas barter desa yang tersedia, serta daftar 5 transaksi keuangan terbaru.

---

## 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)

### 4.1 Keamanan (Security)
* **NFR-01 (Enkripsi Sandi):** Kata sandi pengguna wajib dienkripsi menggunakan algoritma hashing standar industri (BCrypt) sebelum disimpan ke dalam database.
* **NFR-02 (Otorisasi Route):** Setiap route yang berkaitan dengan fitur keuangan harus menolak akses dari pengguna ber-role barter (menghasilkan status HTTP 403), begitu pula sebaliknya.

### 4.2 Performa (Performance)
* **NFR-03 (Waktu Respon):** Halaman sistem harus dapat dimuat dalam waktu kurang dari 2 detik pada koneksi internet standar (3G/4G).
* **NFR-04 (Integritas Data):** Sistem wajib menggunakan database transaction pada proses transaksi barter untuk menjamin konsistensi antara pengurangan stok komoditas dan pencatatan riwayat transaksi (Atomicity).

### 4.3 Ketersediaan (Availability)
* **NFR-05 (Kompatibilitas Browser):** Sistem harus berjalan dengan lancar pada browser Google Chrome, Mozilla Firefox, Microsoft Edge, dan Safari.
