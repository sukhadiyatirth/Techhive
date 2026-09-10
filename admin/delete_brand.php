<?php
// admin/delete_brand.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM brands WHERE brand_id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        // Handle foreign key constraints if needed
    }
}
header("Location: brands.php");
exit();
