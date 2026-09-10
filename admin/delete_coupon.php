<?php
// admin/delete_coupon.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM coupons WHERE coupon_id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        // Handle error if needed
    }
}
header("Location: coupons.php");
exit();
