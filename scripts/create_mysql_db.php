<?php
$host = $argv[1] ?? '127.0.0.1';
$port = $argv[2] ?? '3306';
$db = $argv[3] ?? 'kdkmp';
$user = $argv[4] ?? 'root';
$pass = $argv[5] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$db' ensured.\n";
} catch (Exception $e) {
    echo "Failed to create database: " . $e->getMessage() . "\n";
    exit(1);
}
?>
