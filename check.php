<?php
require_once 'config/db.php';
$tables = ['users', 'residents', 'applications', 'room_assignments', 'payments', 'attendance', 'cleanliness_logs', 'maintenance_requests', 'announcements'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        echo $table . ": " . $stmt->fetchColumn() . "\n";
    } catch (Exception $e) {
        echo $table . ": Error - " . $e->getMessage() . "\n";
    }
}
