# Kumpulan Q&A (Pertanyaan & Jawaban) Seputar ERD KDKMP
*Disusun Khusus untuk Persiapan Presentasi & Ujian (Menghadapi Dosen)*

Dokumen ini berisi 15 pertanyaan kritis yang sering ditanyakan oleh dosen penguji yang teliti terkait perancangan ERD (Entity Relationship Diagram) dan struktur database. Pahami jawaban ini agar lancar saat ditanya!

---

### 1. Kenapa Role pengguna (Keuangan & Barter) hanya dibuat sebagai kolom `VARCHAR` di tabel `USERS`, bukan dipisah menjadi tabel `ROLES` tersendiri?
**Jawaban:** Karena sistem ini dirancang spesifik dengan skala yang terukur, di mana hanya terdapat 2 role statis yang sudah pasti (Keuangan dan Barter). Memisahkannya menjadi tabel baru akan membuat query database menjadi lebih lambat karena harus melakukan `JOIN` (over-engineering). Dengan menjadikan `role` sebagai kolom di tabel `USERS`, sistem menjadi lebih ringan, cepat, dan tetap memenuhi kebutuhan otorisasi (Role-Based Access Control).

### 2. Di tampilan web, tombol "Register" dan "Forgot Password" dihilangkan. Lalu kenapa tabel `USERS` tetap memiliki kolom `password` dan `email`?
**Jawaban:** Walaupun pendaftaran mandiri (Register) ditutup karena ini adalah sistem tertutup (Private System), pengguna tetap harus melakukan **Login** untuk mengakses dashboard. Kolom `email` dan `password` mutlak dibutuhkan untuk proses autentikasi (mencocokkan data saat login). Akun-akun tersebut didaftarkan langsung oleh administrator/seeder di dalam sistem.

### 3. Kenapa tabel `BARTER_REQUESTS` memiliki dua relasi yang mengarah ke tabel `USERS`?
**Jawaban:** Karena sebuah transaksi barter melibatkan 2 belah pihak dari entitas yang sama (yaitu User). Relasi pertama (`user_id`) adalah user yang *meminta/melakukan* barter. Relasi kedua (`target_user_id`) adalah user yang *menerima* permintaan barter. Ini adalah penerapan *Self-Referencing/Multi-relational concept* yang menghubungkan dua record berbeda di dalam satu tabel `USERS`.

### 4. Bagaimana cara sistem memastikan bahwa stok komoditas tidak sampai minus saat proses barter terjadi?
**Jawaban:** Di level ERD, `stock` diatur menggunakan tipe data `INTEGER`. Namun untuk proteksinya, kami menerapkannya di level *Application Logic* (Backend Middleware/Controller). Sebelum data masuk ke tabel `BARTER_REQUESTS`, sistem akan memvalidasi apakah jumlah `quantity` yang di-request lebih besar dari `stock` yang ada di tabel `COMMODITIES`. Jika ya, transaksi akan ditolak sebelum menyentuh database.

### 5. Kenapa nilai uang di tabel `TRANSACTIONS` (`amount`) menggunakan tipe data `INTEGER`, bukan `FLOAT` atau `DECIMAL`?
**Jawaban:** Menggunakan tipe data `FLOAT` untuk nilai mata uang sangat berisiko karena masalah presisi desimal (floating-point error). Kami menggunakan `INTEGER` (atau `BIGINT`) karena transaksi mata uang Rupiah pada umumnya tidak menggunakan angka di belakang koma (sen). Ini membuat perhitungan matematis di dalam database menjadi sangat akurat dan terhindar dari *rounding error*.

### 6. Apakah ERD ini sudah memenuhi bentuk Normalisasi Ketiga (3NF)?
**Jawaban:** Ya, ERD ini sudah memenuhi kaidah 3NF. 
- **1NF:** Setiap kolom memiliki nilai atomik (tidak ada multiple values).
- **2NF:** Semua atribut non-key bergantung penuh pada Primary Key.
- **3NF:** Tidak ada atribut non-key yang bergantung pada atribut non-key lainnya (tidak ada *transitive dependency*). Semua atribut bergantung langsung pada Primary Key masing-masing tabel.

### 7. Kenapa tabel `TRANSACTIONS` (Keuangan) tidak direlasikan dengan tabel `COMMODITIES` (Barter)?
**Jawaban:** Karena sistem KDKMP memisahkan secara tegas antara sirkulasi uang (Keuangan Modern) dan sirkulasi barang (Barter Desa). `TRANSACTIONS` murni mencatat arus kas (uang masuk/keluar) yang dikelola oleh Role Keuangan. Sedangkan `COMMODITIES` adalah pencatatan barang (hasil bumi) yang ditransaksikan tanpa uang fiat, melainkan menggunakan sistem tukar menukar (barter).

### 8. Apa fungsi tabel `TERMINS` dan kenapa ia dipisah dari `TRANSACTIONS`?
**Jawaban:** Tabel `TERMINS` berfungsi sebagai referensi (Master Data) untuk mengelompokkan transaksi keuangan berdasarkan periode atau termin pembayaran tertentu (misalnya: Termin Panen 1, Termin Bantuan 2). Dipisahkan untuk menghindari duplikasi data teks kategori secara berulang-ulang di tabel `TRANSACTIONS` (menerapkan normalisasi) dan memudahkan pengelolaan (CRUD) daftar termin secara dinamis tanpa mengubah transaksi lama.

### 9. Jika seorang User dihapus dari sistem, apa yang terjadi pada data Transaksi dan Komoditas miliknya?
**Jawaban:** Dalam perancangan relasionalnya, kami menerapkan prinsip **Restricted Delete** atau merubah statusnya menjadi Non-Aktif (Soft Deletes). Jika menggunakan `ON DELETE CASCADE`, maka riwayat keuangan desa akan hilang secara otomatis jika user dihapus, dan ini sangat fatal untuk akuntabilitas laporan keuangan. 

### 10. Di tabel `COMMODITIES`, kenapa namanya `estimated_value` (Estimasi Nilai) bukan `price` (Harga)?
**Jawaban:** Karena konsep utama dari komoditas ini adalah untuk dibarter, bukan untuk dijualbelikan secara langsung dengan uang di dalam platform. Nilai tersebut (`estimated_value`) hanya berfungsi sebagai taksiran/estimasi harga pasar agar pengguna bisa mengukur seberapa setara barang yang akan dibarter dengan pengguna lain.

### 11. Kolom apa yang bertindak sebagai Foreign Key di tabel `TRANSACTIONS`?
**Jawaban:** Terdapat dua Foreign Key di tabel `TRANSACTIONS`:
1. `user_id`: Mereferensikan siapa petugas/pengguna yang mencatat transaksi keuangan tersebut (terhubung ke tabel `USERS`).
2. `termin_id`: Mereferensikan jenis termin pembayaran (terhubung ke tabel `TERMINS`).

### 12. Tabel mana yang memfasilitasi "Many-to-Many Relationship" dalam ERD ini?
**Jawaban:** Tabel `BARTER_REQUESTS` secara konseptual bertindak layaknya tabel Pivot (Junction Table) yang memecah relasi *Many-to-Many* antara entitas `USERS` dan entitas `COMMODITIES`. Seorang User bisa merequest banyak Komoditas, dan satu Komoditas bisa direquest oleh banyak User.

### 13. Apa kegunaan kolom `email_verified_at` di tabel `USERS`?
**Jawaban:** Kolom tersebut adalah standar keamanan bawaan dari framework (Laravel). Meskipun untuk saat ini aplikasinya tertutup (dibuat manual), kolom ini dipersiapkan (Future-proof) seandainya ke depan sistem KDKMP ingin dibuka untuk warga desa secara luas dan membutuhkan proses verifikasi email agar terhindar dari akun fiktif/spam.

### 14. Kenapa Primary Key di semua tabel menggunakan tipe data `INTEGER` (Auto Increment) bukannya `UUID`?
**Jawaban:** Penggunaan `INTEGER` (Auto Increment) mempercepat proses indeksasi dan eksekusi query (pencarian data) secara drastis dibandingkan `UUID`. Mengingat skala pengguna sistem ini adalah lingkup desa (skala kecil-menengah) dan datanya tidak di-distribusi ke multi-server (bukan arsitektur microservices yang kompleks), maka `INTEGER` adalah pilihan yang jauh lebih optimal dan efisien.

### 15. Bagaimana ERD ini memfasilitasi fitur "Riwayat Transaksi Barter"?
**Jawaban:** Riwayat transaksi barter dapat ditarik dengan melakukan *Query* ke tabel `BARTER_REQUESTS`. Karena tabel tersebut menyimpan informasi lengkap tentang siapa yang meminta (`user_id`), siapa targetnya (`target_user_id`), barang apa yang dibarter (`commodity_id`), jumlah (`quantity`), dan status transaksinya (`status` seperti pending, success, rejected), kita bisa memfilter riwayat secara detail per user.
