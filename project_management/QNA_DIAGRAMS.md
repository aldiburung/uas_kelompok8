# Kumpulan Q&A (Pertanyaan & Jawaban) Seputar Diagram UML KDKMP
*Disusun untuk Persiapan Presentasi & Sidang (Use Case, Activity, & Sequence)*

Dokumen ini berisi masing-masing 5 pertanyaan jebakan yang sering ditanyakan dosen penguji terkait diagram UML (Unified Modeling Language). Pahami konteksnya agar bisa mempertahankan argumen rancangan sistem kalian!

---

## A. USE CASE DIAGRAM (Sistem KDKMP)

**1. Kenapa pada Use Case Diagram ini tidak ada fitur "Daftar Akun / Register"?**
**Jawaban:** Karena sistem KDKMP dirancang sebagai sistem tertutup (Private System) untuk menjaga keamanan data desa. Akun pengguna tidak dibuat secara mandiri oleh publik, melainkan didaftarkan langsung oleh Administrator sistem (saat ini menggunakan Seeder). Oleh karena itu, fitur Register sengaja tidak dimasukkan ke dalam use case aplikasi.

**2. Mengapa Petugas Keuangan tidak memiliki relasi ke fitur "Buat Request Barter"?**
**Jawaban:** Karena sistem ini menerapkan prinsip RBAC (Role-Based Access Control) yang ketat. Tugas Petugas Keuangan difokuskan murni pada arus kas dan termin pembayaran desa, sedangkan sistem Barter dikhususkan untuk warga pemilik hasil bumi. Pemisahan ini untuk mencegah penyalahgunaan wewenang.

**3. Apa makna dari garis panah lurus dari Aktor menuju Use Case?**
**Jawaban:** Garis panah tersebut merepresentasikan *Association* (Asosiasi). Artinya, aktor tersebut memiliki interaksi langsung dan wewenang (hak akses) untuk mengeksekusi fitur atau proses yang dituju di dalam sistem.

**4. Apakah fitur "Cetak Laporan Keuangan" bisa diakses oleh Warga (Barter)?**
**Jawaban:** Tidak bisa. Pada diagram terlihat jelas bahwa garis relasi untuk "Cetak Laporan Keuangan" hanya mengarah dari aktor Petugas Keuangan. Warga Barter hanya memiliki wewenang untuk melihat riwayat barter miliknya sendiri.

**5. Mengapa Use Case "Login ke Sistem" terhubung ke kedua aktor?**
**Jawaban:** Karena Login adalah pintu gerbang utama (Authentication) bagi semua role. Tanpa melewati proses login terlebih dahulu, baik Petugas Keuangan maupun Warga Barter tidak akan bisa mengakses fitur apa pun di dalam sistem KDKMP.

---

## B. ACTIVITY DIAGRAM (Proses Barter)

**1. Apa tujuan dari simbol "Decision" (belah ketupat) pada tahap Validasi Stok?**
**Jawaban:** Simbol belah ketupat berfungsi untuk memecah alur logika (If-Else). Jika stok komoditas mencukupi, sistem akan melanjutkan proses pengiriman *request*. Namun jika stok kurang, sistem akan menolak dan mengembalikan pengguna ke halaman form beserta pesan peringatan (Error).

**2. Kapan sebuah transaksi barter dinyatakan berstatus "Pending"?**
**Jawaban:** Transaksi berstatus "Pending" tepat setelah sistem berhasil memvalidasi stok dan menyimpan data request ke database, namun Warga tujuan (Penerima Barter) belum memberikan keputusan persetujuan.

**3. Siapa yang berhak melakukan "Evaluasi Request" (Approve / Reject)?**
**Jawaban:** Warga ke-2 (Penerima Barter). Merekalah yang memiliki otoritas untuk meninjau apakah komoditas yang ditawarkan oleh pemohon setimpal dengan barang miliknya atau tidak.

**4. Mengapa sistem harus otomatis mengurangi stok sesaat setelah di-Approve?**
**Jawaban:** Untuk menjaga integritas data dan mencegah masalah *Double-Spending* (Satu barang dibarterkan ke dua orang yang berbeda pada waktu bersamaan). Pengurangan stok otomatis menjamin barang yang sudah dibarter tidak lagi beredar di katalog.

**5. Mengapa Activity Diagram ini sangat krusial dalam rekayasa perangkat lunak?**
**Jawaban:** Karena diagram ini adalah "blueprint" bagi *Programmer*. Activity diagram mendeskripsikan secara detail *Business Logic* (Logika Bisnis) aplikasi. Setiap belah ketupat dalam diagram ini akan diterjemahkan menjadi kode `if-else` atau validasi form di dalam *Controller* Laravel.

---

## C. SEQUENCE DIAGRAM (Pencatatan Keuangan)

**1. Pada diagram, apa fungsi garis putus-putus yang mengarah kembali ke kiri (Return Message)?**
**Jawaban:** Garis putus-putus melambangkan respons (balasan) dari suatu entitas setelah sebuah proses diselesaikan. Misalnya, dari Backend mengirim garis putus-putus ke Frontend sebagai tanda bahwa data sudah divalidasi dan siap ditampilkan notifikasinya ke user.

**2. Kenapa proses Validasi Data dilakukan di Backend (Controller), bukan di Database?**
**Jawaban:** Database (MySQL) tugasnya murni sebagai media penyimpanan. Proses berfikir, pengecekan tipe data, dan aturan bisnis (misalnya Nominal wajib berupa angka, tidak boleh kosong) adalah beban kerja dari Controller (Backend) agar database terhindar dari *query error* yang berbahaya.

**3. Apa yang terjadi pada alur jika "Data Tidak Valid"?**
**Jawaban:** Sequence diagram menunjukkan blok *Alternative* (`alt`). Jika data salah/tidak lengkap, alur bawah (INSERT ke DB) tidak akan dieksekusi. Sebaliknya, Backend akan langsung memutar balik (melempar Error) ke Frontend untuk menyuruh Petugas memperbaiki inputannya.

**4. Mengapa Frontend (Halaman Web) tidak boleh berkomunikasi langsung dengan Database?**
**Jawaban:** Karena sistem KDKMP menggunakan pola arsitektur **MVC (Model-View-Controller)**. Halaman web (View) tidak boleh memiliki akses langsung ke Database demi keamanan tingkat tinggi (mencegah SQL Injection). Semua komunikasi wajib melewati pintu penjagaan Controller (Backend).

**5. Apa arti blok "Activate" (Kotak memanjang di bawah garis lifeline Backend/Database)?**
**Jawaban:** Blok tersebut disebut sebagai *Execution Specification* (atau *Activation Bar*). Kotak itu menandakan rentang waktu di mana suatu objek (misalnya Backend) sedang aktif memproses tugas atau menunggu kembalian data dari Database. Saat kotak selesai, berarti prosesnya sudah tuntas.
