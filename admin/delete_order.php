<?php
// admin/delete_order.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $pdo->beginTransaction();
        
        // First delete order items to prevent foreign key constraint issues
        $stmtItems = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmtItems->execute([$id]);
        
        // Then delete the order itself
        $stmtOrder = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmtOrder->execute([$id]);
        
        $pdo->commit();
    } catch(PDOException $e) {
        $pdo->rollBack();
        // Handle error if needed
    }
}
header("Location: orders.php");
exit();
