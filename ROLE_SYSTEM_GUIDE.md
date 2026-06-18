# 5-Level Role-Based Access Control System

## Overview
A comprehensive role-based authorization system has been implemented with 5 user roles. All routes and functionality are now protected by role-based middleware and controller checks.

## Roles & Access

### 1. **Administrator** (role: `administrator`)
- **Full access** to all features
- Can manage: Keuangan, Barter, Termins, Reports, Barter Requests
- Can see all users' data

### 2. **Bendahara** (role: `bendahara`)
- Access to: **Keuangan**, **Reports**
- Can only view and manage their own transactions
- Can view all reports

### 3. **Pengurus** (role: `pengurus`)
- Access to: **Keuangan**, **Termins**
- Can manage transactions and payment terms
- Can only view and manage their own transactions

### 4. **Viewer** (role: `viewer`)
- Access to: **Reports** (read-only)
- Can only view and generate reports
- Cannot modify any data

### 5. **Pengurus Desa Barter** (role: `pengurus_desa_barter`)
- Access to: **Barter**, **Barter Requests**
- Can manage commodities for barter
- Can view and manage barter requests

## Technical Implementation

### 1. User Model Helper Methods
Located in `app/Models/User.php`:

```php
// Check single role
public function hasRole(string $role): bool

// Check multiple roles
public function hasAnyRole(array $roles): bool

// Legacy methods (still available)
public function isAdmin(): bool        // deprecated
public function isUser(): bool         // deprecated
```

### 2. Middleware
- **Registered in**: `bootstrap/app.php`
- **Alias**: `role`
- **Class**: `App\Http\Middleware\CheckRole`

**Usage in routes:**
```php
Route::middleware(['auth', 'role:administrator'])->group(function () {
    // routes here
});
```

### 3. Route Structure
Located in `routes/web.php`:

All routes are organized into **role-based groups**:
- `Route::middleware(['auth', 'role:administrator'])->group()` - Administrator
- `Route::middleware(['auth', 'role:bendahara'])->group()` - Bendahara
- `Route::middleware(['auth', 'role:pengurus'])->group()` - Pengurus
- `Route::middleware(['auth', 'role:viewer'])->group()` - Viewer
- `Route::middleware(['auth', 'role:pengurus_desa_barter'])->group()` - Pengurus Desa Barter

### 4. Controller Authorization
Each controller method now includes role checks:

```php
// Example from KeuanganController
public function index()
{
    if (!auth()->user()->hasAnyRole(['administrator', 'bendahara', 'pengurus'])) {
        abort(403, 'Unauthorized access to keuangan.');
    }
    // ... rest of method
}
```

**Protected Controllers:**
- `KeuanganController` - All methods
- `BarterController` - All methods
- `BarterRequestController` - All methods
- `ReportController` - All methods
- `TerminController` - All methods

### 5. Navigation UI
Located in `resources/views/layouts/navigation.blade.php`:

- **Desktop & Mobile menus** show only authorized links
- **User role badge** displayed in dropdown
- Menu items conditionally show based on role:

```blade
@if(auth()->user()->hasAnyRole(['administrator', 'bendahara', 'pengurus']))
    <x-nav-link href="{{ route('keuangan.index') }}">
        {{ __('Keuangan') }}
    </x-nav-link>
@endif
```

### 6. Database Seeder
Located in `database/seeders/DatabaseSeeder.php`:

5 test users created with different roles:
1. **admin@example.com** - Administrator
2. **bendahara@example.com** - Bendahara
3. **pengurus@example.com** - Pengurus
4. **viewer@example.com** - Viewer
5. **pengurus_barter@example.com** - Pengurus Desa Barter

All have password: `password`

## Authorization Flow

### Route Level Protection
Routes are protected by middleware:
```
HTTP Request → CheckRole Middleware → Verify role matches → Allow/Deny (403)
```

### Controller Level Protection
Controllers verify role before executing:
```
Method Called → hasAnyRole() check → Verify authorization → abort(403) if not authorized
```

### View Level Control
Blade views conditionally render elements:
```
View → hasRole() check → Show/Hide UI elements
```

## Testing the System

### For Each Role:

**Administrator:**
- Login: `admin@example.com` | Password: `password`
- Expected: See all menu items, can access all routes

**Bendahara:**
- Login: `bendahara@example.com` | Password: `password`
- Expected: See only Keuangan, Laporan menus

**Pengurus:**
- Login: `pengurus@example.com` | Password: `password`
- Expected: See only Keuangan, Termin menus

**Viewer:**
- Login: `viewer@example.com` | Password: `password`
- Expected: See only Laporan menu (read-only)

**Pengurus Desa Barter:**
- Login: `pengurus_barter@example.com` | Password: `password`
- Expected: See only Barter, Permintaan Barter menus

## Role Badge Display

When logged in, the user's role appears in the navigation dropdown:
- 🔴 **Red** - Administrator
- 🔵 **Blue** - Bendahara
- 🟢 **Green** - Pengurus
- ⚫ **Gray** - Viewer
- 🟡 **Yellow** - Pengurus Desa Barter

## Error Handling

**Unauthorized Access:**
- Routes: Returns **403 Forbidden** from middleware
- Controllers: Returns **403 Unauthorized** with custom message
- Views: UI elements simply don't render

## Notes

- **No migration changes** - Uses existing `role` column in `users` table
- **Default role** for new registrations: `'user'` (can be updated in UserFactory)
- **All existing data preserved** - Authorization layer added on top
- **Fully auditable** - All authorization checks logged at controller level
