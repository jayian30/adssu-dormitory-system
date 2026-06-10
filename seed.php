<?php
require_once 'config/db.php';
try {
    $sql = file_get_contents('seed.sql');
    $pdo->exec($sql);
    echo "Seed executed successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
