<?php
// wishlist_action.php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isLoggedIn()) {
    // Return or redirect to login
    redirect('login.php');
}

$action = $_POST['action'] ?? '';
$product_id = $_POST['product_id'] ?? 0;
$user_id = $_SESSION['user_id'];

if ($product_id && $action) {
    if ($action == 'add') {
        // Check if already in wishlist
        $stmt = $pdo->prepare("SELECT wishlist_id FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        if ($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $product_id]);
        }
    } elseif ($action == 'remove') {
        $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
    }
}

// Redirect back
if (isset($_SERVER['HTTP_REFERER'])) {
    redirect($_SERVER['HTTP_REFERER']);
} else {
    redirect('wishlist.php');
}
