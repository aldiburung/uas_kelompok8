<?php
// Migrate data from SQLite (DB_DATABASE_OLD) to MySQL using PDO
// Configure MySQL connection here or via CLI args
$mysqlHost = $argv[1] ?? '127.0.0.1';
$mysqlPort = $argv[2] ?? '3306';
$mysqlDb = $argv[3] ?? 'kdkmp';
$mysqlUser = $argv[4] ?? 'root';
$mysqlPass = $argv[5] ?? '';

$projectRoot = realpath(__DIR__ . '/..');
$sqlitePath = $projectRoot . '/database/database.sqlite';
if (!file_exists($sqlitePath)) {
    echo "SQLite database not found at: $sqlitePath\n";
    exit(1);
}

try {
    $sqlite = new PDO('sqlite:' . $sqlitePath);
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Failed to open SQLite: " . $e->getMessage() . "\n";
    exit(1);
}

try {
    $mysqlDsn = "mysql:host=$mysqlHost;port=$mysqlPort;dbname=$mysqlDb;charset=utf8mb4";
    $mysql = new PDO($mysqlDsn, $mysqlUser, $mysqlPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    ]);
} catch (Exception $e) {
    echo "Failed to connect to MySQL: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Connected to SQLite and MySQL. Beginning migration...\n";

// Disable foreign key checks
$mysql->exec('SET FOREIGN_KEY_CHECKS=0');

// Create tables in MySQL if not exist (simple mapping based on migrations)
$createStatements = [
    // users
    "CREATE TABLE IF NOT EXISTS users (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        email_verified_at DATETIME NULL,
        password VARCHAR(255) NOT NULL,
        remember_token VARCHAR(100) NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        role VARCHAR(100) NOT NULL DEFAULT 'user'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    // termins
    "CREATE TABLE IF NOT EXISTS termins (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL UNIQUE,
        description TEXT NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    // transactions
    "CREATE TABLE IF NOT EXISTS transactions (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        user_id BIGINT NOT NULL,
        description VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL,
        termin_id BIGINT NULL,
        amount INT NOT NULL,
        transaction_date DATE NOT NULL,
        note TEXT NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (termin_id) REFERENCES termins(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    // commodities
    "CREATE TABLE IF NOT EXISTS commodities (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        user_id BIGINT NULL,
        name VARCHAR(255) NOT NULL,
        village VARCHAR(255) NOT NULL,
        unit VARCHAR(50) NOT NULL,
        stock INT NOT NULL,
        estimated_value INT NOT NULL,
        description TEXT NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    // barter_requests
    "CREATE TABLE IF NOT EXISTS barter_requests (
        id BIGINT PRIMARY KEY AUTO_INCREMENT,
        user_id BIGINT NOT NULL,
        commodity_id BIGINT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        target_user_id BIGINT NOT NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'pending',
        notes TEXT NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (commodity_id) REFERENCES commodities(id) ON DELETE CASCADE,
        FOREIGN KEY (target_user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
];

foreach ($createStatements as $sql) {
    $mysql->exec($sql);
}

echo "Tables ensured in MySQL.\n";

// Copy data from SQLite -> MySQL for each table if data exists
function copyTable($fromPdo, $toPdo, $table, $columns, $mapFn = null) {
    $colsSql = implode(', ', $columns);
    $placeholders = implode(', ', array_fill(0, count($columns), '?'));

    $rows = $fromPdo->query("SELECT $colsSql FROM $table")->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        echo "No rows for $table to copy.\n";
        return;
    }

    $toPdo->beginTransaction();
    $insert = $toPdo->prepare("INSERT INTO $table ($colsSql) VALUES ($placeholders)");
    foreach ($rows as $row) {
        $vals = array_values($row);
        if ($mapFn) $vals = $mapFn($row);
        $insert->execute($vals);
    }
    $toPdo->commit();
    echo "Copied " . count($rows) . " rows into $table.\n";
}

// Users: ensure email unique - skip duplicates
$users = $sqlite->query('SELECT id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role FROM users')->fetchAll(PDO::FETCH_ASSOC);
if ($users) {
    $mysql->beginTransaction();
    $ins = $mysql->prepare('INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $count = 0;
    foreach ($users as $u) {
        try {
            $ins->execute([$u['id'], $u['name'], $u['email'], $u['email_verified_at'], $u['password'], $u['remember_token'], $u['created_at'], $u['updated_at'], $u['role'] ?? 'user']);
            $count++;
        } catch (Exception $e) {
            // skip duplicates or errors
        }
    }
    $mysql->commit();
    echo "Users copied: $count\n";
} else {
    echo "No users in SQLite to copy.\n";
}

// Termins
copyTable($sqlite, $mysql, 'termins', ['id','name','description','created_at','updated_at']);

// Because transactions reference users and termins, copy transactions next
copyTable($sqlite, $mysql, 'transactions', ['id','user_id','description','category','termin_id','amount','transaction_date','note','created_at','updated_at']);

// Commodities
copyTable($sqlite, $mysql, 'commodities', ['id','user_id','name','village','unit','stock','estimated_value','description','created_at','updated_at']);

// Barter requests - include quantity if present in sqlite
$cols = [];
try {
    $res = $sqlite->query("PRAGMA table_info(barter_requests)")->fetchAll(PDO::FETCH_ASSOC);
    $colNames = array_column($res, 'name');
    $cols = $colNames;
} catch (Exception $e) {
    // table may not exist
}
if ($cols) {
    // ensure destination has same set (we created with quantity)
    $allowed = ['id','user_id','commodity_id','quantity','target_user_id','status','notes','created_at','updated_at'];
    $present = array_values(array_intersect($allowed, $cols));
    if ($present) {
        copyTable($sqlite, $mysql, 'barter_requests', $present);
    }
} else {
    echo "No barter_requests table in SQLite to copy.\n";
}

// Re-enable foreign key checks
$mysql->exec('SET FOREIGN_KEY_CHECKS=1');

echo "Migration complete. Verify data in MySQL (users, termins, transactions, commodities, barter_requests).\n";

?>
