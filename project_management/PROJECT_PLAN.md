# Project Plan — Sistem Informasi (KDKMP)

## Goal
Sediakan modul Keuangan, Barter, Permintaan Barter, Termin, dan Reporting dengan sistem hak akses berbasis peran (Role-Based Access Control) yang terbagi menjadi 2 role utama: Keuangan dan Barter. Sertakan dokumentasi, QA, dan deployment ke MySQL (phpMyAdmin).

## Team Roles & Responsibilities (Actual Team: 2 Members)
- **Aldi Burung (Project Manager / Fullstack Developer)**: Inisialisasi git, setup database MySQL, desain interface (dashboard, form, sidebar), dan optimasi tampilan responsive.
- **Julia (System Analyst / Fullstack Developer)**: Analisis kebutuhan (SRS), logika backend keuangan/barter, middleware keamanan (CheckRole), unit/feature testing, dan dokumentasi lengkap.

## Deliverables
- Role-based access (2 roles: keuangan & barter) — done (code-level)
- DB migration & MySQL data (migration scripts) — done
- UI updates (sidebar, dashboard, forms) — done
- Policies & controllers hardened — done
- Tests (unit + feature) — done
- ERD, Gantt Chart Excel, Laporan Akhir — done

## High-level Tasks (3-Week Roadmap)
1. **Fase 1: Persiapan & Setup (Minggu 1)**
   - Penyusunan Dokumen SRS & Perancangan ERD.
   - Inisiasi Project & Git repository.
   - Setup Laragon & MySQL database.
2. **Fase 2: Pembangunan Backend & Database (Minggu 2)**
   - Database Migration & Seeding data awal.
   - Pembuatan logic backend Keuangan & Termin.
   - Pembuatan logic backend Barter & Stok Komoditas.
   - Implementasi CheckRole Middleware & Security Policies.
3. **Fase 3: Frontend, Testing, & Deployment (Minggu 3)**
   - Desain Layout Dashboard & Sidebar dinamis responsif.
   - Desain Form Input & Validasi UI.
   - Pembuatan Automated Testing Suite.
   - Finalisasi Dokumentasi & Handover.

## Acceptance Criteria
- Setiap user hanya bisa mengakses route yang diperbolehkan sesuai perannya (role: keuangan / barter).
- User dengan role 'keuangan' tidak bisa mengakses fitur 'barter', begitu juga sebaliknya (menghasilkan status HTTP 403).
- Pengurangan stok komoditas dan pencatatan transaksi barter berjalan secara atomik menggunakan database transaction.
- Aplikasi berjalan lancar menggunakan database MySQL.
- Automated tests meloloskan skenario otorisasi dan fungsionalitas dasar.
