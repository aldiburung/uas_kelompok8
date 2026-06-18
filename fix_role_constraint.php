<?php
// Fix role constraint in SQLite database

$dbPath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "⏳ Fixing role constraint...\n\n";
    
    // SQLite doesn't support ALTER COLUMN or DROP CONSTRAINT,
    // so we need to recreate the table without the constraint
    
    // Step 1: Backup data
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "✓ Backed up " . count($users) . " existing users\n";
    
    // Step 2: Rename old table
    $pdo->exec("ALTER TABLE users RENAME TO users_old");
    echo "✓ Renamed users table to users_old\n";
    
    // Step 3: Create new table without enum constraint
    $pdo->exec("
        CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            name VARCHAR NOT NULL,
            email VARCHAR NOT NULL,
            email_verified_at DATETIME,
            password VARCHAR NOT NULL,
            remember_token VARCHAR,
            created_at DATETIME,
            updated_at DATETIME,
            role VARCHAR NOT NULL DEFAULT 'user'
        )
    ");
    echo "✓ Created new users table without role constraint\n";
    
    // Step 4: Restore data
    if (!empty($users)) {
        $stmt = $pdo->prepare("
            INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        foreach ($users as $user) {
            $stmt->execute([
                $user['id'],
                $user['name'],
                $user['email'],
                $user['email_verified_at'],
                $user['password'],
                $user['remember_token'],
                $user['created_at'],
                $user['updated_at'],
                $user['role'] ?? 'user'
            ]);
        }
        echo "✓ Restored " . count($users) . " users\n";
    }
    
    // Step 5: Drop old table
    $pdo->exec("DROP TABLE users_old");
    echo "✓ Dropped old table\n";
    
    echo "\n✅ Role constraint removed successfully!\n";
    echo "   Now roles can be: keuangan, barter\n";
    
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}
?>
