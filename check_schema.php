<?php
// Check database schema

$dbPath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get table info
    $stmt = $pdo->query("PRAGMA table_info(users)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "=== Users Table Schema ===\n";
    foreach ($columns as $col) {
        echo $col['name'] . " - " . $col['type'] . (empty($col['notnull']) ? " (nullable)" : " (NOT NULL)") . "\n";
    }
    
    // Check existing users
    echo "\n=== Existing Users ===\n";
    $stmt = $pdo->query("SELECT id, email, role FROM users LIMIT 10");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo "ID: {$user['id']}, Email: {$user['email']}, Role: " . ($user['role'] ?? 'NULL') . "\n";
    }
    
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}
?>
