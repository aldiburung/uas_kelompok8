# Panduan Presentasi KDKMP (Tanpa Teks di Slide)
*Khusus untuk presentasi visual (Gambar) karena dosen melarang membaca slide.*

Aturan Main: Di dalam file PPT (PowerPoint), **jangan menaruh paragraf**. Cukup taruh **Judul besar dan Gambar/Screenshot**. Kamu dan tim yang akan berbicara menjelaskan gambar tersebut. 

Bagikan tugas bicara ini ke Aldi, Julia, dan Sopyan!

---

### SLIDE 1: Cover (Pembukaan)
* **Isi Slide (Visual):** Judul "Sistem Informasi Komoditas Desa & Keuangan Modern (KDKMP)", Logo Kampus, dan Nama Anggota (Aldi, Julia, Sopyan).
* **Yang Diucapkan (Script):** 
  *"Selamat pagi Pak Nana dan rekan-rekan. Kami dari Kelompok 8 akan mendemonstrasikan sistem KDKMP. Sistem ini lahir dari permasalahan di desa, di mana pencatatan keuangan sering tidak transparan, dan sistem barter hasil bumi belum terdigitalisasi."*

### SLIDE 2: Manajemen Proyek (Gambar Gantt Chart)
* **Isi Slide (Visual):** *Hanya screenshot gambar `Gantt_Chart_12_Minggu.xlsx`*.
* **Yang Diucapkan (Script):** 
  *"Dalam membangun sistem ini, kami menggunakan waktu efektif selama 12 Minggu. Seperti yang terlihat di timeline, pembagian tugas sangat jelas. Saya (Aldi) fokus di setup dan manajemen, Julia di keamanan dan backend, sedangkan Sopyan berfokus di UI/UX dan testing."*

### SLIDE 3: Arsitektur Database (Gambar ERD)
* **Isi Slide (Visual):** *Hanya screenshot gambar `ERD.mmd` dari Mermaid*.
* **Yang Diucapkan (Script):** 
  *"Sistem kami dirancang dengan keamanan tertutup (Private). Terlihat di ERD, kami memisahkan secara tegas antara sirkulasi uang (tabel Transactions) dan sirkulasi barang (tabel Commodities dan Barter Requests). Kami tidak menaruh fitur Register bebas karena akun hanya dikelola oleh sistem desa (Seeder)."*

### SLIDE 4: Alur Logika (Gambar Activity / Sequence Diagram)
* **Isi Slide (Visual):** *Pilih salah satu, misalnya screenshot `ACTIVITY.mmd` (Proses Barter).*
* **Yang Diucapkan (Script):** 
  *"Sebelum coding, kami mendesain logika bisnisnya terlebih dahulu. Di gambar ini terlihat alur transaksi barter, di mana sistem akan otomatis memvalidasi stok barang sebelum membiarkan warga me-request barter ke warga lainnya."*

### SLIDE 5: Keamanan & Autentikasi (Screenshot Halaman Login)
* **Isi Slide (Visual):** *Screenshot halaman muka web/Login KDKMP (yang tidak ada tombol registernya).*
* **Yang Diucapkan (Script):** 
  *"Ini adalah gerbang utama aplikasi kami. Sistem mengunci akses publik. Hanya warga atau petugas yang sudah didaftarkan yang memiliki email dan password untuk masuk ke dashboard."*

### SLIDE 6: Hak Akses Keuangan (Screenshot Halaman Keuangan)
* **Isi Slide (Visual):** *Screenshot dashboard/menu khusus petugas Keuangan.*
* **Yang Diucapkan (Script):** 
  *"Setelah login sebagai Petugas Keuangan, sistem langsung menyesuaikan menunya. Petugas ini hanya bisa melihat dan mencatat arus kas, serta memfilter laporan keuangan berdasarkan termin/waktu. Dia tidak bisa melihat transaksi barter."*

### SLIDE 7: Hak Akses Barter (Screenshot Halaman Barter)
* **Isi Slide (Visual):** *Screenshot dashboard/menu khusus Warga (Barter).*
* **Yang Diucapkan (Script):** 
  *"Sebaliknya, jika login sebagai Warga, dia hanya bisa mengelola katalog komoditas hasil buminya dan merespon tawaran barter dari tetangganya tanpa bisa mengintip keuangan desa."*

### SLIDE 8: Demo (Penutup)
* **Isi Slide (Visual):** Tulisan besar "LIVE DEMO".
* **Yang Diucapkan (Script):** 
  *"Daripada sekadar melihat gambar, izinkan kami mendemonstrasikan langsung aplikasinya di browser untuk membuktikan bahwa sistem berjalan dengan baik. Terima kasih."* (Lalu langsung buka browser localhost:8000).

---
**TIPS PENTING SAAT PRESENTASI:**
1. Jangan menghafal kata per kata, pahami intinya saja.
2. Tunjuk bagian gambar di layar saat kalian berbicara (Misal: *"Pak, di bagian kotak merah ini sistem melakukan validasi..."*). Dosen sangat suka presentasi yang interaktif dengan diagram!
