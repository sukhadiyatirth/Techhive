<?php
// admin/delete_product.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    // Optionally fetch image and delete it from disk
    $stmt = $pdo->prepare("SELECT product_image FROM products WHERE product_id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if ($img && file_exists('../assets/images/products/' . $img)) {
        unlink('../assets/images/products/' . $img);
    }

    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$id]);
}

header("Location: products.php");
exit();
