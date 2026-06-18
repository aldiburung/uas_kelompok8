Panduan menjalankan test otomatis (role flows)

Persyaratan:
- PHP CLI 8.3 (project composer requires >=8.3)
- ekstensi pdo_mysql
- database MySQL `kdkmp` tersedia (sudah dibuat sebelumnya)

Langkah menjalankan (jika `php` di PATH adalah PHP 8.3):

```bash
# Jalankan migrations untuk environment testing
php artisan migrate --env=testing

# Jalankan semua test (Pest atau phpunit)
vendor/bin/pest
# atau
vendor/bin/phpunit
```

Jika `php` default bukan 8.3, jalankan dengan path lengkap ke PHP 8.3 (contoh Laragon):

```bash
C:\laragon\bin\php\php-8.3.x\php.exe artisan migrate --env=testing
C:\laragon\bin\php\php-8.3.x\php.exe vendor\bin\pest
```

Catatan:
- Test ini menggunakan trait `RefreshDatabase`, jadi akan menjalankan migrasi pada database testing.
- Jika terjadi error karena koneksi DB, pastikan `phpunit.xml` atau env testing menunjuk ke DB yang benar.
- Jika ingin menjalankan test tanpa MySQL, ubah `.env.testing` untuk menggunakan SQLite in-memory:

```
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

Tetapi beberapa pengaturan dan seed mungkin diperlukan tergantung test.
