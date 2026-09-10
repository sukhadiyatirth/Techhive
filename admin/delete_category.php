<?php
// admin/delete_category.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        // Ignore if linked to existing products without cascade
    }
}
header("Location: categories.php");
exit();
