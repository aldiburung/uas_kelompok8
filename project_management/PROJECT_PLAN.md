# Project Plan — Sistem Informasi (KDKMP)

## Goal
Sediakan modul Keuangan, Barter, Permintaan Barter, Termin, dan Reporting dengan 5-level role-based access control. Sertakan dokumentasi, QA, dan deployment ke MySQL (phpMyAdmin).

## Team Roles & Responsibilities
- Project Manager (You): Prioritize features, accept deliveries, stakeholder communication.
- System Analyst: Requirement breakdown, ERD, API specs.
- Backend Developer(s): Controllers, Models, DB migrations, policies, authentication, testing.
- Frontend Developer(s): Blade/Tailwind views, navigation, responsive UI.
- QA / Tester: Test plans, write test cases (Pest/phpunit), run regression testing.
- DevOps: PHP version, server setup, database migration, deployment.
- Documentation: README, API docs, user guide.

## Deliverables
- Role-based access (5 roles) — done (code-level)
- DB migration & MySQL data (migration scripts) — todo: migrate from SQLite to MySQL
- UI updates (sidebar, pages) — partial done
- Policies & controllers hardened — done
- Tests (unit + feature) — todo
- ERD, Gantt, task assignments — created

## High-level Tasks (short roadmap)
1. Environment & DB (2 days)
   - Configure PHP 8.3 on dev machine or Laragon
   - Create MySQL database `kdkmp` and update `.env`
   - Run migrations and seeders
2. Backend Stabilization (3 days)
   - Review and finish controllers, policies, edge cases
   - Add authorization trait and centralize checks
   - Add feature tests
3. Frontend Polishing (2 days)
   - Fix navigation visibility and responsive UI
   - Improve forms and validation messages
4. QA & Regression (2 days)
   - Write test plan, run automated tests
   - Manual exploratory testing across roles
5. Documentation & Handover (1 day)
   - README, deployment steps, user manual

## Suggested Task Breakdown (example for sprint)
- Backend: 40% (controllers, policies, tests)
- Frontend: 30% (views, UX)
- QA: 15% (tests, bug fixes)
- Docs/PM: 15%

## Acceptance Criteria
- Each role can only access allowed routes (as defined)
- Admin can access and manage all data
- No 403 for permitted users; errors must return friendly messages
- Database runs on MySQL and data migrated
- Tests cover core flows (login, create transaction, create barter, accept barter)

## Next Immediate Actions For You
1. Confirm MySQL credentials (host, port, user, password).
2. If using Laragon, enable PHP 8.3 CLI or set PATH to PHP 8.3.
3. Run migration and seeder:

```bash
# create DB in mysql (via phpMyAdmin or CLI)
# then in project root
php artisan migrate --force
php artisan db:seed --class=Database\\Seeders\\DatabaseSeeder
```

If your `php` CLI gives Composer platform errors, run migrations via Laragon's PHP 8.3 or ask me to provide a direct migration script to import into MySQL.
