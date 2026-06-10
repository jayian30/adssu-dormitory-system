<?php
// Read Railway environment variables, fallback to local XAMPP configuration
$db_host = getenv('MYSQLHOST') ?: '127.0.0.1';
$db_port = getenv('MYSQLPORT') ?: '3307';
$db_name = getenv('MYSQLDATABASE') ?: 'adssu_dorm_db';
$db_user = getenv('MYSQLUSER') ?: 'root';
$db_pass = getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
