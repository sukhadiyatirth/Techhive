<?php
// admin/delete_customer.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    // Soft delete to preserve order history
    try {
        $stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE user_id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        // Handle error if needed
    }
}
header("Location: customers.php");
exit();
