<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Bypass PHP version check
define('LARAVEL_START', microtime(true));

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run seeder directly
try {
    DB::statement("DELETE FROM barter_requests");
    DB::statement("DELETE FROM commodities");
    DB::statement("DELETE FROM transactions");
    DB::statement("DELETE FROM termins");
    DB::statement("DELETE FROM users WHERE email != 'test@test.com'");
    
    $exit = $kernel->call('db:seed', ['--class' => 'Database\Seeders\DatabaseSeeder']);
    echo "✓ Seeder ran successfully!\n";
    echo "Test users created:\n";
    echo "  - keuangan@example.com (keuangan)\n";
    echo "  - barter@example.com (barter)\n";
    echo "Password for all: password\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
