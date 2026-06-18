<?php
// Check role column constraints

$dbPath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check table creation SQL
    $stmt = $pdo->query("SELECT sql FROM sqlite_master WHERE type='table' AND name='users'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "=== CREATE TABLE SQL ===\n";
    echo $result['sql'] . "\n\n";
    
    // Try inserting with role = 'user' (the default)
    echo "=== Testing role values ===\n";
    
    $testRoles = ['user', 'admin', 'administrator', 'bendahara'];
    foreach ($testRoles as $role) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(["Test $role", "test_$role@test.com", password_hash('password', PASSWORD_BCRYPT), $role]);
            echo "✓ Role '$role' accepted\n";
            // Rollback
            $pdo->exec("DELETE FROM users WHERE email = 'test_$role@test.com'");
        } catch (Exception $e) {
            echo "✗ Role '$role' rejected: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}
?>
