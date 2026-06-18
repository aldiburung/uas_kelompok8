<?php
// Direct database seeding script - bypasses Composer version check

$dbPath = __DIR__ . '/database/database.sqlite';

if (!file_exists($dbPath)) {
    die("❌ Database file not found at: $dbPath\n");
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if users table exists
    $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    if (!$result->fetch()) {
        die("❌ Users table not found. Run migrations first.\n");
    }
    
    // Clear existing test data
    $pdo->exec("DELETE FROM users WHERE email LIKE '%@example.com'");
    
    $now = date('Y-m-d H:i:s');
    
    // Hash password: 'password'
    $hashedPassword = password_hash('password', PASSWORD_BCRYPT);
    
    // Insert test users (keuangan and barter)
    $users = [
        ['User Keuangan', 'keuangan@example.com', 'keuangan'],
        ['User Barter', 'barter@example.com', 'barter'],
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    foreach ($users as [$name, $email, $role]) {
        $stmt->execute([$name, $email, $hashedPassword, $role, $now, $now, $now]);
        echo "✓ Created: $email ($role)\n";
    }
    
    echo "\n✅ Test users created successfully!\n";
    echo "\nLogin credentials:\n";
    echo "─────────────────────────────────────────────\n";
    foreach ($users as [$name, $email, $role]) {
        echo "Email: $email\n";
        echo "Role: $role\n";
        echo "Password: password\n\n";
    }
    
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}
?>
