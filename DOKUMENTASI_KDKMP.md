# 📚 DOKUMENTASI LENGKAP SISTEM KDKMP
## Komoditas Desa dan Keuangan Modern - Alur Kerja & Arsitektur

**Dibuat untuk:** Persiapan Presentasi & Demo Depan Dosen  
**Tanggal:** 13 Juni 2026  
**Status:** Lengkap & Siap Presentasi

---

## 📖 DAFTAR ISI
1. [Pengenalan Sistem](#pengenalan-sistem)
2. [Alur Kerja dari Awal](#alur-kerja-dari-awal)
3. [Struktur File & Fungsi Setiap Module](#struktur-file--fungsi-setiap-module)
4. [Arsitektur Database](#arsitektur-database)
5. [Alur Autentikasi & Otorisasi](#alur-autentikasi--otorisasi)
6. [Workflow Fitur Utama](#workflow-fitur-utama)
7. [FAQ Pertanyaan Dosen (10+ Q&A)](#faq-pertanyaan-dosen)

---

## Pengenalan Sistem

### Apa itu KDKMP?
**KDKMP** adalah sistem manajemen **Komoditas Desa dan Keuangan Modern** yang dirancang untuk:
- Mengelola transaksi keuangan desa
- Mencatat komoditas barter yang tersedia
- Mengorganisir pengguna dalam 2 role: **Keuangan** dan **Barter**

### Tujuan Sistem
✅ Digitalisasi sistem barter desa  
✅ Manajemen inventaris komoditas terpusat  
✅ Pencatatan transaksi finansial yang terstruktur  
✅ Pembatasan akses berdasarkan peran pengguna  

### Stack Teknologi
- **Backend:** Laravel 11 (PHP Framework)
- **Frontend:** Blade Template + Tailwind CSS
- **Database:** MySQL
- **Authentication:** Laravel Breeze (Email & Password)
- **Authorization:** Laravel Gates & Policies

---

## Alur Kerja dari Awal

### 1️⃣ **FASE 1: Setup & Konfigurasi Dasar**

```
├─ Composer Install
│  └─ Install semua dependency Laravel
├─ Database Setup (MySQL)
│  ├─ Create database 'kdkmp'
│  └─ Konfigurasi di .env
├─ Migration & Seeding
│  ├─ Buat tabel users, transactions, commodities, barter_requests, termins
│  └─ Insert data seed (pengguna dummy, komoditas sample)
└─ Generate APP_KEY
   └─ php artisan key:generate
```

**Hasil:** Aplikasi siap running dengan database terstruktur.

---

### 2️⃣ **FASE 2: Authentication & Authorization**

```
User Mengakses http://localhost:8000
    ↓
[Landing Page - welcome.blade.php]
    ├─ Login → /login (email & password)
    ├─ Register → /register (buat akun baru)
    └─ Redirect ke Dashboard jika sudah login
        ↓
[Dashboard - dashboard.blade.php]
    ├─ Menampilkan ringkasan global:
    │  ├─ Total Transaksi Keuangan (semua user)
    │  ├─ Total Komoditas Barter (semua user role='barter')
    │  └─ Riwayat Transaksi Terbaru (5 terakhir)
    │
    └─ Menu navigasi dinamis:
       ├─ Role 'keuangan':
       │  ├─ Keuangan (Create/Read Transaction)
       │  ├─ Termin (Manage payment terms)
       │  └─ Laporan (Reports)
       │
       └─ Role 'barter':
          ├─ Barter (CRUD Komoditas milik sendiri)
          └─ Transaksi Barter (Log internal transactions)
```

**Logika Authorization:**
- Middleware `CheckRole` memastikan user hanya akses fitur sesuai role
- Gates: `akses-keuangan`, `akses-barter`
- Policies: `BarterRequestPolicy` untuk destroy transaction

---

### 3️⃣ **FASE 3: Fitur Utama per Role**

#### 👤 Role: KEUANGAN

```
[Keuangan Module - KeuanganController.php]
  ├─ index()
  │  └─ Tampilkan daftar transaksi finansial (Create/Edit/Delete)
  │
  ├─ create()
  │  └─ Form input transaksi: description, amount, category, date
  │
  ├─ store()
  │  ├─ Validasi input
  │  ├─ Save ke Transaction table
  │  └─ Redirect dengan success message
  │
  ├─ edit() / update()
  │  ├─ Edit transaksi yang sudah tercatat
  │  └─ Validasi & update database
  │
  └─ destroy()
     └─ Hapus transaksi (soft delete recommended)

[Categories]
  ├─ Material
  ├─ Upah
  └─ Operasional
```

#### 🔄 Role: BARTER

```
[Barter Module - BarterController.php]
  ├─ index()
  │  ├─ Query: Commodity::where('user_id', auth()->id())->paginate(12)
  │  └─ Tampilkan katalog komoditas milik pengguna login
  │
  ├─ create()
  │  └─ Form tambah komoditas: name, village, unit, stock, value, description
  │
  ├─ store()
  │  ├─ Validasi input
  │  ├─ Save ke Commodity table dengan user_id = auth()->id()
  │  └─ Redirect dengan success message
  │
  ├─ show() / edit() / update()
  │  ├─ Detail komoditas
  │  ├─ Validasi ownership (user_id === auth()->id())
  │  └─ Update/Hapus jika pemilik
  │
  └─ destroy()
     └─ Soft delete atau hard delete komoditas

[Internal Transaction Logging - BarterRequestController.php]
  ├─ index()
  │  ├─ Query: BarterRequest::where('user_id', auth()->id())->latest()
  │  └─ Tampilkan riwayat transaksi barter yang sudah dicatat
  │
  ├─ create()
  │  ├─ Query: Commodity::where('user_id', auth()->id())->get()
  │  ├─ Tampilkan form: pilih komoditas MILIK SENDIRI
  │  └─ Input quantity & notes
  │
  ├─ store()
  │  ├─ Validasi input
  │  ├─ DB::transaction() untuk atomicity:
  │  │  ├─ Decrement komoditas stock
  │  │  ├─ Create BarterRequest record
  │  │  │  ├─ user_id = auth()->id()
  │  │  │  ├─ target_user_id = auth()->id() (INTERNAL)
  │  │  │  └─ status = 'accepted' (langsung selesai)
  │  │  └─ Commit/Rollback otomatis
  │  └─ Redirect dengan success message
  │
  └─ destroy()
     └─ Hapus record transaksi barter yang tidak diinginkan
```

---

## Struktur File & Fungsi Setiap Module

### 📁 **app/Models/** (Data Model)

| File | Fungsi | Relasi |
|------|--------|--------|
| `User.php` | Model pengguna dengan role enum (keuangan/barter) | hasMany(Transaction), hasMany(Commodity), hasMany(BarterRequest) |
| `Transaction.php` | Model transaksi finansial | belongsTo(User), belongsTo(Termin) |
| `Commodity.php` | Model komoditas barter | belongsTo(User), hasMany(BarterRequest) |
| `BarterRequest.php` | Model pencatatan transaksi barter internal | belongsTo(User), belongsTo(Commodity) |
| `Termin.php` | Model payment terms/cicilan | hasMany(Transaction) |

**Enum Role User:**
```php
// app/Models/User.php
protected $casts = [
    'role' => 'string', // enum('keuangan', 'barter')
];
```

---

### 📁 **app/Http/Controllers/** (Business Logic)

| File | Fungsi | Routes |
|------|--------|--------|
| `DashboardController.php` | Dashboard dengan stats global | GET /dashboard |
| `KeuanganController.php` | CRUD Transaksi Keuangan | resource('keuangan') |
| `BarterController.php` | CRUD Komoditas Barter | resource('barter') |
| `BarterRequestController.php` | Pencatatan Transaksi Barter Internal | resource('barter-requests') - except show/edit/update |
| `TerminController.php` | CRUD Payment Terms | resource('termins') |
| `ReportController.php` | Generate Reports | GET /reports, POST /reports/generate |
| `ProfileController.php` | Edit Profile User | profile edit/update/destroy |

**Middleware Autentikasi:** `AuthorizesRoles` trait di Controller.php

---

### 📁 **routes/** (Routing)

```php
// routes/web.php - STRUKTUR

Route::get('/', fn() => view('welcome'));  // Landing page

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fitur Keuangan (Role: keuangan)
    Route::resource('keuangan', KeuanganController::class)->except(['show']);
    Route::resource('termins', TerminController::class)->except(['show']);
    Route::resource('reports', ReportController::class)->only(['index']);
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');

    // Fitur Barter (Role: barter)
    Route::resource('barter', BarterController::class);
    Route::resource('barter-requests', BarterRequestController::class)->except(['show', 'edit', 'update']);
});

require __DIR__.'/auth.php';  // Login/Register routes
```

---

### 📁 **resources/views/** (Frontend/UI)

| Path | Fungsi |
|------|--------|
| `dashboard.blade.php` | Dashboard utama (global stats) |
| `welcome.blade.php` | Landing page |
| `keuangan/` | Form & list transaksi keuangan |
| `barter/` | Katalog & form komoditas barter |
| `barter-requests/` | Form & riwayat pencatatan transaksi internal |
| `termins/` | Payment terms management |
| `reports/` | Report generation & display |
| `auth/` | Login, register, password reset (Breeze default) |
| `components/` | Reusable Blade components (nav-link, input-error, etc) |
| `layouts/` | Master layout (navigation, header, footer) |

**UI Framework:** Tailwind CSS + custom rounded design (border-radius: 24px - 36px)

---

### 📁 **database/migrations/** (Schema)

| Migration | Tabel | Kolom Utama |
|-----------|-------|-------------|
| `0001_01_01_000000_create_users_table.php` | users | id, name, email, password, role (enum), created_at |
| `0001_01_01_000001_create_cache_table.php` | cache | key, value |
| `0001_01_01_000002_create_jobs_table.php` | jobs | id, queue, payload |
| `2026_05_14_000001_create_transactions_table.php` | transactions | id, user_id, description, category, amount, transaction_date, termin_id, note |
| `2026_05_14_000002_create_commodities_table.php` | commodities | id, user_id, name, village, unit, stock, estimated_value, description |
| `2026_05_15_000001_add_role_to_users_table.php` | ALTER users | Tambah kolom role enum |
| `2026_05_15_000002_create_termins_table.php` | termins | id, name, description, created_at |
| `2026_05_15_000003_add_termin_id_to_transactions_table.php` | ALTER transactions | Tambah foreign key termin_id |
| `2026_05_15_000004_add_user_id_to_commodities_table.php` | ALTER commodities | Tambah foreign key user_id |
| `2026_05_15_000005_create_barter_requests_table.php` | barter_requests | id, user_id, commodity_id, target_user_id, quantity, status, notes |
| `2026_05_16_000001_add_quantity_to_barter_requests_table.php` | ALTER barter_requests | Tambah kolom quantity |

---

### 📁 **app/Policies/** (Authorization)

| Policy | Method | Logika |
|--------|--------|--------|
| `BarterRequestPolicy.php` | delete() | Hanya pemilik transaksi (user_id) yang bisa delete |

---

### 📁 **app/Providers/** (Service Providers)

```php
// app/Providers/AppServiceProvider.php

public function boot(): void {
    // Gates
    Gate::define('akses-keuangan', fn($user) => $user->role === 'keuangan');
    Gate::define('akses-barter', fn($user) => $user->role === 'barter');
    
    // Policies
    Gate::policy(BarterRequest::class, BarterRequestPolicy::class);
}
```

---

## Arsitektur Database

### 📊 ERD (Entity Relationship Diagram)

```
┌─────────────────┐
│     USERS       │
├─────────────────┤
│ id (PK)         │
│ name            │
│ email           │
│ password        │
│ role (enum)     │◄─────────┐
│ created_at      │          │
└─────────────────┘          │
        │                    │
        ├─────────────┬──────┼────────────┐
        │             │      │            │
        ▼             ▼      ▼            ▼
    HAS MANY:  TRANSACTION  COMMODITY  BARTER_REQUEST
    ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
    │  TRANSACTIONS    │  │  COMMODITIES     │  │ BARTER_REQUESTS  │
    ├──────────────────┤  ├──────────────────┤  ├──────────────────┤
    │ id (PK)          │  │ id (PK)          │  │ id (PK)          │
    │ user_id (FK) ────┼─ │ user_id (FK) ────┼─ │ user_id (FK) ────┼─ (pengguna pembuat)
    │ description      │  │ name             │  │ commodity_id (FK)├──┐
    │ category         │  │ village          │  │ target_user_id ──┼─ (pengguna penerima/internal)
    │ amount           │  │ unit             │  │ quantity         │
    │ transaction_date │  │ stock            │  │ status (enum)    │
    │ termin_id (FK) ──┼──┼────────┐         │  │ notes            │
    │ note             │  │ est_value        │  │ created_at       │
    │ created_at       │  │ description      │  └──────────────────┘
    └──────────────────┘  │ created_at       │
            │             └──────────────────┘
            │
            ▼
    ┌──────────────────┐
    │     TERMINS      │
    ├──────────────────┤
    │ id (PK)          │
    │ name             │
    │ description      │
    │ created_at       │
    └──────────────────┘
```

### 🔑 Primary Keys & Foreign Keys

```sql
-- Users
ALTER TABLE users ADD CONSTRAINT role_enum CHECK (role IN ('keuangan', 'barter'));

-- Transactions
ALTER TABLE transactions ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE transactions ADD FOREIGN KEY (termin_id) REFERENCES termins(id) ON DELETE SET NULL;

-- Commodities
ALTER TABLE commodities ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

-- Barter Requests
ALTER TABLE barter_requests ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE barter_requests ADD FOREIGN KEY (commodity_id) REFERENCES commodities(id) ON DELETE CASCADE;
ALTER TABLE barter_requests ADD FOREIGN KEY (target_user_id) REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE barter_requests ADD CONSTRAINT status_enum CHECK (status IN ('pending', 'accepted', 'rejected'));
```

---

## Alur Autentikasi & Otorisasi

### 🔐 **LOGIN FLOW**

```
1. User klik Login → /login

2. [LoginController::store()]
   ├─ Validasi email & password
   ├─ Auth::attempt(['email' => $email, 'password' => $password])
   ├─ Session & Cookie diset
   └─ Redirect ke /dashboard

3. [Middleware: auth, verified]
   ├─ Cek apakah user sudah login
   ├─ Cek apakah email sudah verified
   └─ Jika belum → force logout

4. [DashboardController::index()]
   ├─ Get global stats (transactions, commodities)
   └─ Return view('dashboard') dengan data
```

### 🛡️ **AUTHORIZATION FLOW**

```
User akses route tertentu (misal: /keuangan)
    ↓
[Middleware: auth]
    ├─ Cek login status
    └─ Jika tidak login → redirect /login
        ↓
[Trait: AuthorizesRoles]
    ├─ Method: authorizeRole(['keuangan', 'barter'])
    ├─ Check: auth()->user()->hasAnyRole($roles)
    └─ Jika tidak punya role → abort(403)
        ↓
[Action Dijalankan - misal: KeuanganController@index()]
```

### 🗝️ **GATES & POLICIES**

```php
// Gates (Simple boolean checks)
if (auth()->user()->can('akses-keuangan')) {
    // User punya role 'keuangan'
}

// Policies (Model-based authorization)
$user->can('delete', $barterRequest);  // Check via BarterRequestPolicy@delete()
```

---

## Workflow Fitur Utama

### 📋 **WORKFLOW 1: Manajemen Transaksi Keuangan**

```
USER KEUANGAN
    ↓
[Route: GET /keuangan]
    └─ KeuanganController@index()
       ├─ Validasi role = 'keuangan'
       ├─ Query: Transaction::all() atau dengan filter
       └─ Return view('keuangan.index', compact('transactions'))
    ↓
[View: keuangan/index.blade.php]
    ├─ Tampilkan tabel transaksi
    ├─ Tombol "Create", "Edit", "Delete"
    └─ User klik "Tambah" → GET /keuangan/create
    ↓
[Route: GET /keuangan/create]
    └─ KeuanganController@create()
       ├─ Validasi role = 'keuangan'
       ├─ Get Termin::all() untuk dropdown
       └─ Return view('keuangan.create')
    ↓
[View: keuangan/create.blade.php]
    ├─ Form: description, category, amount, transaction_date, termin_id, note
    ├─ User input & submit
    └─ POST /keuangan
    ↓
[Route: POST /keuangan]
    └─ KeuanganController@store(Request $request)
       ├─ Validasi input
       ├─ $validated = $request->validate([...])
       ├─ Transaction::create([
       │    'user_id' => auth()->id(),
       │    'description' => $validated['description'],
       │    'category' => $validated['category'],
       │    'amount' => $validated['amount'],
       │    'transaction_date' => $validated['transaction_date'],
       │    'termin_id' => $validated['termin_id'],
       │    'note' => $validated['note'] ?? null,
       │  ])
       └─ Redirect ke /keuangan dengan success message
    ↓
[Route: PUT|PATCH /keuangan/{id}]
    └─ KeuanganController@update()
       ├─ Find transaction
       ├─ Update dengan $validated data
       └─ Redirect dengan success message
    ↓
[Route: DELETE /keuangan/{id}]
    └─ KeuanganController@destroy()
       ├─ Find transaction
       ├─ Delete (atau soft delete)
       └─ Redirect dengan success message
```

---

### 🛍️ **WORKFLOW 2: Manajemen Komoditas Barter**

```
USER BARTER
    ↓
[Route: GET /barter]
    └─ BarterController@index()
       ├─ Validasi role = 'barter'
       ├─ Query: Commodity::where('user_id', auth()->id())->paginate(12)
       └─ Return view('barter.index', compact('commodities'))
    ↓
[View: barter/index.blade.php]
    ├─ Grid tampilan komoditas milik user
    ├─ Tombol: "Lihat", "Edit", "Hapus"
    └─ Tombol: "+ Tambah Komoditas" → GET /barter/create
    ↓
[Route: GET /barter/create]
    └─ BarterController@create()
       ├─ Return view('barter.create')
    ↓
[View: barter/create.blade.php]
    ├─ Form: name, village, unit, stock, estimated_value, description
    ├─ User input & submit
    └─ POST /barter
    ↓
[Route: POST /barter]
    └─ BarterController@store(Request $request)
       ├─ Validasi input
       ├─ Commodity::create([
       │    'user_id' => auth()->id(),
       │    'name' => $validated['name'],
       │    'village' => $validated['village'],
       │    'unit' => $validated['unit'],
       │    'stock' => $validated['stock'],
       │    'estimated_value' => $validated['estimated_value'],
       │    'description' => $validated['description'],
       │  ])
       └─ Redirect ke /barter dengan success message
    ↓
[Route: GET /barter/{id}]
    └─ BarterController@show()
       ├─ Validasi ownership (user_id === auth()->id())
       ├─ Return view('barter.show', compact('commodity'))
    ↓
[Route: GET /barter/{id}/edit]
    └─ BarterController@edit()
       ├─ Validasi ownership
       └─ Return view('barter.edit', compact('commodity'))
    ↓
[Route: PUT|PATCH /barter/{id}]
    └─ BarterController@update()
       ├─ Validasi ownership
       ├─ $commodity->update($validated)
       └─ Redirect dengan success message
    ↓
[Route: DELETE /barter/{id}]
    └─ BarterController@destroy()
       ├─ Validasi ownership
       ├─ $commodity->delete()
       └─ Redirect dengan success message
```

---

### 📝 **WORKFLOW 3: Pencatatan Transaksi Barter Internal**

```
USER BARTER
    ↓
[Route: GET /barter-requests]
    └─ BarterRequestController@index()
       ├─ Validasi role = 'barter'
       ├─ Query: BarterRequest::where('user_id', auth()->id())->latest()->get()
       └─ Return view('barter-requests.index', compact('transactions'))
    ↓
[View: barter-requests/index.blade.php]
    ├─ Tampilkan tabel riwayat transaksi barter (internal)
    ├─ Kolom: Nama Komoditas, Jumlah, Status, Tanggal, Catatan
    ├─ Tombol: "+ Catat Transaksi Baru"
    └─ Tombol: "Hapus"
    ↓
[Route: GET /barter-requests/create]
    └─ BarterRequestController@create()
       ├─ Validasi role = 'barter'
       ├─ Query: Commodity::where('user_id', auth()->id())->get()
       │  (HANYA komoditas milik user sendiri!)
       └─ Return view('barter-requests.create', compact('commodities'))
    ↓
[View: barter-requests/create.blade.php]
    ├─ Form: 
    │  ├─ Dropdown Komoditas (hanya milik sendiri)
    │  ├─ Input Quantity
    │  └─ Textarea Notes
    ├─ Instruksi: "Pilih komoditas Anda yang ingin dicatat dalam transaksi barter ini."
    └─ Submit → POST /barter-requests
    ↓
[Route: POST /barter-requests]
    └─ BarterRequestController@store(Request $request)
       ├─ Validasi role = 'barter'
       ├─ Validasi input (commodity_id, quantity, notes)
       ├─ Find commodity
       ├─ Check apakah commodity milik user login
       ├─ Check stock >= quantity
       ├─ DB::transaction() untuk atomicity:
       │  ├─ Decrement commodity stock
       │  │  $commodity->decrement('stock', $quantity)
       │  │
       │  └─ Create BarterRequest record
       │     BarterRequest::create([
       │       'user_id' => auth()->id(),
       │       'commodity_id' => $commodity->id,
       │       'target_user_id' => auth()->id(),  ← INTERNAL!
       │       'quantity' => $quantity,
       │       'notes' => $notes ?? null,
       │       'status' => 'accepted',  ← Langsung selesai!
       │     ])
       ├─ Commit transaksi
       └─ Redirect ke /barter-requests dengan success message
    ↓
[Route: DELETE /barter-requests/{id}]
    └─ BarterRequestController@destroy()
       ├─ Validasi role = 'barter'
       ├─ Cek via Policy: $this->authorize('delete', $barterRequest)
       ├─ Check apakah user_id === auth()->id()
       ├─ $barterRequest->delete()
       └─ Redirect dengan success message
```

---

## FAQ Pertanyaan Dosen

### ❓ **PERTANYAAN 1: Jelaskan alur sistem dari user login hingga melihat dashboard!**

**JAWABAN:**

1. **User mengunjungi halaman login** → `http://localhost:8000/login`
2. **Input email & password** → Submit form ke route `POST /login`
3. **Controller melakukan validasi:**
   - Email ada di database
   - Password sesuai dengan hash di database
4. **Session & cookie dibuat** oleh Laravel Auth
5. **Redirect ke `/dashboard`**
6. **Dashboard menampilkan:**
   - Total transaksi keuangan (global) = `Transaction::count()`
   - Total komoditas barter (global) = `Commodity::whereHas('user', where role='barter')->count()`
   - Riwayat transaksi terbaru (5 terakhir) = `Transaction::latest()->limit(5)->get()`

**Apa yang membedakan dashboard user keuangan vs barter?**
- Dashboard itu sama untuk semua role (sama data, beda menu sidebar)
- Menu sidebar yang berbeda:
  - Role keuangan: Keuangan, Termin, Laporan
  - Role barter: Barter, Transaksi Barter

---

### ❓ **PERTANYAAN 2: Apa perbedaan Role 'keuangan' dan 'barter' dalam sistem ini?**

**JAWABAN:**

| Aspek | Keuangan | Barter |
|-------|----------|--------|
| **Tabel Akses** | Transactions, Termins, Reports | Commodities, BarterRequests |
| **CRUD Transaksi** | ✅ Create, Read, Update, Delete | ❌ Hanya Read |
| **CRUD Komoditas** | ❌ Tidak punya | ✅ CRUD milik sendiri |
| **Pencatatan Barter** | ❌ Tidak punya | ✅ Log internal transaction |
| **Data Terlihat** | Semua transaksi finansial | Komoditas milik sendiri |
| **Laporan** | ✅ Generate report | ❌ Tidak ada |

---

### ❓ **PERTANYAAN 3: Bagaimana sistem mencegah user keuangan mengakses menu Barter?**

**JAWABAN:**

Menggunakan **Middleware + Traits Autentikasi:**

```php
// app/Http/Controllers/Concerns/AuthorizesRoles.php
protected function authorizeRole(array|string $roles): void {
    $roles = is_array($roles) ? $roles : [$roles];
    $user = auth()->user();
    
    if (! $user || ! $user->hasAnyRole($roles)) {
        abort(Response::HTTP_FORBIDDEN, 'Unauthorized');
    }
}

// Di controller: 
// BarterController@index()
public function index() {
    $this->authorizeRole(['barter']);  // ← Enforce role!
    // ...
}

// Jika user role='keuangan' akses /barter
// → authorizeRole(['barter']) akan trigger
// → abort(403) - Forbidden
```

**Alternative dengan Laravel Gates:**

```php
// app/Providers/AppServiceProvider.php
Gate::define('akses-barter', fn($user) => $user->role === 'barter');

// Di route atau middleware:
Route::get('/barter', [BarterController::class, 'index'])
    ->middleware('can:akses-barter');
```

---

### ❓ **PERTANYAAN 4: Jelaskan workflow pencatatan transaksi barter internal!**

**JAWABAN:**

**Tujuan:** User barter dapat mencatat transaksi komoditas mereka (mengurangi stok) tanpa perlu konfirmasi dari user lain.

**Langkah-langkah:**

1. **User klik menu "Transaksi Barter"** → GET `/barter-requests`
   - Tampilkan daftar transaksi yang sudah dicatat (history)

2. **User klik "+ Catat Transaksi Baru"** → GET `/barter-requests/create`
   - Form menampilkan dropdown komoditas **MILIK SENDIRI SAJA**
   - Bukan komoditas dari user lain!

3. **User pilih komoditas, input quantity & notes**
   - Misal: Pilih "Pupuk Organik" (milik sendiri), qty=5, notes="Untuk transaksi barter"

4. **Submit form** → POST `/barter-requests`
   
5. **Backend melakukan:**
   ```php
   DB::transaction(function () use ($commodity, $quantity) {
       // Step 1: Kurangi stok komoditas
       $commodity->decrement('stock', $quantity);
       // Stok: 10 → 5
       
       // Step 2: Catat transaksi (langsung "accepted")
       BarterRequest::create([
           'user_id' => auth()->id(),           // Pemilik komoditas
           'commodity_id' => $commodity->id,
           'target_user_id' => auth()->id(),    // ← INTERNAL!
           'quantity' => $quantity,
           'status' => 'accepted',              // ← Langsung selesai!
           'notes' => $notes,
       ]);
   });
   ```

6. **Redirect ke `/barter-requests`** dengan success message
   - User lihat transaksi sudah tercatat di history

**Keuntungan:**
- ✅ Langsung selesai (tidak perlu approval)
- ✅ Atomik (stock & record update bersamaan)
- ✅ Tracking history transaksi

---

### ❓ **PERTANYAAN 5: Bagaimana database memastikan data konsisten (atomicity)?**

**JAWABAN:**

Menggunakan **DB::transaction()** untuk atomic operations:

```php
DB::transaction(function () use ($commodity, $quantity) {
    // Operasi 1: Update stock
    $commodity->decrement('stock', $quantity);
    
    // Operasi 2: Create record
    BarterRequest::create([...]);
    
    // Jika ada error di operasi 2 → automatic rollback operasi 1
    // Jika semua sukses → automatic commit kedua operasi
});
```

**Skenario:**
- ✅ Sukses: Stock berkurang + Record tercatat
- ❌ Gagal (error): Stock kembali normal + Record tidak tercatat

**Tanpa transaction (BAHAYA):**
- ❌ Stock berkurang tapi record gagal → Data inconsistent!

---

### ❓ **PERTANYAAN 6: Bagaimana sistem menghitung total komoditas barter di dashboard?**

**JAWABAN:**

```php
// app/Http/Controllers/DashboardController.php
public function index() {
    $commodityCount = Commodity::whereHas('user', function ($query) {
        $query->where('role', 'barter');
    })->count();
    
    return view('dashboard', [
        'commodityCount' => $commodityCount,
    ]);
}
```

**Penjelasan:**
- Query mencari semua Commodity yang pemiliknya (user) punya role='barter'
- **Tidak menggunakan auth()->id()** → GLOBAL, bukan hanya milik user login
- Hasil: Sama untuk semua user (keuangan ataupun barter)

**Contoh:**
- User A (role=barter): 3 komoditas
- User B (role=barter): 2 komoditas
- Total ditampilkan di dashboard: **5** (sama untuk semua role)

---

### ❓ **PERTANYAAN 7: Jelaskan relasi database dan foreign key constraints!**

**JAWABAN:**

```
USERS (Parent)
  ├─ 1 ─→ N TRANSACTIONS
  │       └─ foreign key: user_id → users.id
  │
  ├─ 1 ─→ N COMMODITIES
  │       └─ foreign key: user_id → users.id
  │
  └─ 1 ─→ N BARTER_REQUESTS (2 relations)
          ├─ foreign key: user_id → users.id
          └─ foreign key: target_user_id → users.id

COMMODITIES (Parent)
  └─ 1 ─→ N BARTER_REQUESTS
          └─ foreign key: commodity_id → commodities.id

TERMINS (Parent)
  └─ 1 ─→ N TRANSACTIONS
          └─ foreign key: termin_id → termins.id
```

**Constraints (ON DELETE CASCADE):**
- Jika user dihapus → semua transaction/commodity/barter_request juga dihapus
- Jika commodity dihapus → semua barter_request untuk commodity itu dihapus
- Jika termin dihapus → termin_id di transaction jadi NULL

---

### ❓ **PERTANYAAN 8: Apa itu Middleware dan bagaimana middleware 'auth' bekerja?**

**JAWABAN:**

**Middleware** = Lapisan filter yang memeriksa request sebelum sampai ke controller.

**Middleware 'auth':**
```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::resource('keuangan', KeuanganController::class);
    Route::resource('barter', BarterController::class);
});
```

**Flow ketika user akses `/keuangan` tanpa login:**
```
1. Request masuk ke `/keuangan`
2. Middleware 'auth' cek: apakah user sudah login?
3. Jika TIDAK → redirect ke `/login`
4. Jika YA → lanjut ke KeuanganController@index()
```

**Flow ketika user akses `/keuangan` dengan role='barter':**
```
1. Request masuk ke `/keuangan`
2. Middleware 'auth' cek login → OK (sudah login)
3. Controller KeuanganController@index()
   → Cek: $this->authorizeRole(['keuangan'])
4. TIDAK punya role 'keuangan' → abort(403) Forbidden
```

---

### ❓ **PERTANYAAN 9: Bagaimana validasi input di Laravel?**

**JAWABAN:**

```php
// app/Http/Controllers/KeuanganController.php
public function store(Request $request) {
    $validated = $request->validate([
        'description' => 'required|string|max:255',
        'category' => 'required|in:Material,Upah,Operasional',
        'amount' => 'required|integer|min:1',
        'transaction_date' => 'required|date',
        'termin_id' => 'nullable|exists:termins,id',
        'note' => 'nullable|string|max:500',
    ]);
    
    // Jika validation gagal → Laravel otomatis redirect ke form dengan error message
    // Jika sukses → $validated berisi data yang valid
    
    Transaction::create($validated + ['user_id' => auth()->id()]);
    return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil ditambahkan');
}
```

**Aturan Validasi:**
- `required` = Wajib diisi
- `string` = Harus text
- `max:255` = Maksimal 255 karakter
- `integer` = Harus angka bulat
- `min:1` = Minimal 1
- `in:Material,Upah,Operasional` = Hanya boleh nilai-nilai ini
- `date` = Format tanggal valid
- `exists:termins,id` = Termin ID harus ada di tabel termins
- `nullable` = Boleh kosong (optional)

---

### ❓ **PERTANYAAN 10: Apa keuntungan menggunakan Laravel Eloquent ORM dibanding raw SQL?**

**JAWABAN:**

**Eloquent ORM:**
```php
// Cara Laravel
$transactions = Transaction::where('user_id', auth()->id())
    ->latest('created_at')
    ->limit(5)
    ->get();

// Keuntungan:
// 1. Readable & maintainable
// 2. SQL injection protection otomatis
// 3. Relationship management mudah
// 4. Model casting & mutation
```

**vs Raw SQL:**
```php
// Cara traditional (SQL query string)
$transactions = DB::select('
    SELECT * FROM transactions
    WHERE user_id = ?
    ORDER BY created_at DESC
    LIMIT 5
', [auth()->id()]);

// Kekurangan:
// 1. Rawan SQL injection jika tidak hati-hati
// 2. Susah manipulasi data
// 3. Coupling dengan schema database
```

**Keuntungan Eloquent:**
- ✅ **Security**: Parameter binding automatic
- ✅ **Readability**: Code lebih natural bahasa inggris
- ✅ **Relationships**: Akses relasi dengan mudah
  ```php
  $user->transactions;     // Auto query transactions milik user
  $commodity->user->name;  // Chain relasi
  ```
- ✅ **Casting**: Type conversion automatic
- ✅ **Migrations**: Schema versioning & rollback

---

### ❓ **PERTANYAAN 11: Bagaimana sistem menghandle soft delete untuk data sensitive?**

**JAWABAN:**

Soft delete adalah menandai record sebagai "dihapus" tanpa benar-benar menghapus dari database.

```php
// app/Models/Transaction.php
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model {
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}

// migration
Schema::table('transactions', function (Blueprint $table) {
    $table->softDeletes();  // Tambah kolom deleted_at
});
```

**Behavior:**
```php
// Delete (soft)
$transaction->delete();
// deleted_at = 2026-06-13 14:30:00

// Query otomatis exclude soft deleted
Transaction::all();  // Tidak termasuk deleted records

// Query termasuk soft deleted
Transaction::withTrashed()->all();

// Hanya soft deleted
Transaction::onlyTrashed()->all();

// Restore
$transaction->restore();
// deleted_at = NULL (kembali normal)

// Force delete (benar-benar hapus)
$transaction->forceDelete();
```

**Keuntungan:**
- ✅ Audit trail (tahu siapa yg hapus & kapan)
- ✅ Recovery data jika perlu
- ✅ Report akurat (masa lalu tetap ada)

---

### ❓ **PERTANYAAN 12: Bagaimana sistem handle pagination di Laravel?**

**JAWABAN:**

```php
// app/Http/Controllers/BarterController.php
public function index() {
    $commodities = Commodity::where('user_id', auth()->id())
        ->orderBy('name')
        ->paginate(12);  // ← 12 item per page
    
    return view('barter.index', compact('commodities'));
}

// View
@forelse($commodities as $commodity)
    <div>{{ $commodity->name }}</div>
@endforelse

// Pagination links
{{ $commodities->links() }}
// Tampilkan: Previous | 1 2 3 | Next
```

**Keuntungan Pagination:**
- ✅ Performance: Query hanya ambil 12 data, bukan 10.000
- ✅ UX: Loading cepat
- ✅ Memory: Hemat RAM

**Default Laravel pagination:**
- URL: `?page=1`, `?page=2`, dst
- Items per page: 15 (default), bisa custom dengan `paginate(12)`

---

## 🎓 Tips Presentasi Depan Dosen

### 1. **Persiapan Demo**
- ✅ Siapkan 2 akun test: 1 role keuangan, 1 role barter
- ✅ Insert sample data ke database (transactions, commodities)
- ✅ Test semua flow: login, CRUD, dashboard, authorization
- ✅ Cek error log jika ada (`storage/logs/laravel.log`)

### 2. **Penjelasan yang Jelas**
- Mulai dari **alur login** → dashboard → fitur spesifik
- Jelaskan **perbedaan role** dengan demo langsung
- Tunjukkan **error handling** (validasi input)
- Jelaskan **database flow** dengan diagram

### 3. **Siapkan Jawaban untuk**
- "Mengapa menggunakan 2 role saja?"
- "Bagaimana keamanan aplikasi?"
- "Bagaimana scalability ke depannya?"
- "Apa kelebihan dan kekurangan sistem?"

### 4. **Dokumentasi Tambahan**
- Buat API documentation (jika ada)
- Siapkan User Manual (panduan pengguna)
- Screenshot workflow penting
- Testing report (PHPUnit/Pest)

### 5. **Saat Presentasi**
- ✅ Mulai dengan **big picture** (tujuan sistem)
- ✅ Lanjut **arsitektur & tech stack**
- ✅ Demo **user workflow**
- ✅ Tunjukkan **code quality** (clean code, comments)
- ✅ Diskusi **challenges & solutions** yang dihadapi

---

## 📎 Quick Reference - Folder Structure

```
kdkmp/
├── app/
│   ├── Http/
│   │   ├── Controllers/          ← Business Logic
│   │   │   ├── DashboardController.php
│   │   │   ├── KeuanganController.php
│   │   │   ├── BarterController.php
│   │   │   ├── BarterRequestController.php
│   │   │   ├── TerminController.php
│   │   │   └── ...
│   │   └── Middleware/           ← Filters
│   │       ├── CheckRole.php
│   │       └── ...
│   ├── Models/                   ← Data Models
│   │   ├── User.php
│   │   ├── Transaction.php
│   │   ├── Commodity.php
│   │   ├── BarterRequest.php
│   │   └── Termin.php
│   ├── Policies/                 ← Authorization
│   │   └── BarterRequestPolicy.php
│   └── Providers/                ← Service Providers
│       └── AppServiceProvider.php
├── routes/
│   ├── web.php                   ← Web Routes
│   └── auth.php                  ← Auth Routes (Breeze)
├── database/
│   ├── migrations/               ← Schema Versions
│   └── seeders/                  ← Sample Data
├── resources/
│   └── views/                    ← Blade Templates
│       ├── dashboard.blade.php
│       ├── welcome.blade.php
│       ├── keuangan/
│       ├── barter/
│       ├── barter-requests/
│       ├── auth/
│       └── layouts/
├── storage/
│   └── logs/
│       └── laravel.log           ← Error Log
├── .env                          ← Configuration
├── artisan                       ← CLI Tool
└── composer.json                 ← Dependencies
```

---

## 📞 Kontak & Support

- **Database Issue**: Cek `.env` DB_* config
- **Route Error**: `php artisan route:list`
- **Migration Error**: `php artisan migrate:status`
- **View Error**: `php artisan view:clear`
- **Logs**: `tail -f storage/logs/laravel.log`

---

**Dokumen ini siap untuk presentasi depan dosen. Semua fitur telah dijelaskan dengan diagram, workflow, dan Q&A lengkap. Good luck! 🚀**

