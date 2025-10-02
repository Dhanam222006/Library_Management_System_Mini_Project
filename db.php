<?php
// db.php - central DB connection using PDO
// update these values to your DB
$DB_HOST = 'localhost';
$DB_NAME = 'regist';
$DB_USER = 'root';
$DB_PASS = 'Dhanam@2006';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    // in production, log this instead of echoing
    exit('Database connection failed: ' . $e->getMessage());
}
