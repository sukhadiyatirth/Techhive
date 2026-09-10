<?php
// cart_action.php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';
$product_id = $_POST['product_id'] ?? 0;
$quantity = (int)($_POST['quantity'] ?? 1);

if ($product_id && $action) {
    // Basic verification of product
    $stmt = $pdo->prepare("SELECT product_id, stock_quantity FROM products WHERE product_id = ? AND status = 'active'");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if ($product) {
        if ($action == 'add') {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity
                ];
            }
            // Ensure we don't exceed stock
            if ($_SESSION['cart'][$product_id]['quantity'] > $product['stock_quantity']) {
                $_SESSION['cart'][$product_id]['quantity'] = $product['stock_quantity'];
            }
        } elseif ($action == 'update') {
            if ($quantity > 0 && $quantity <= $product['stock_quantity']) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } elseif ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        } elseif ($action == 'remove') {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// Redirect back to cart or referring page
if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'cart.php') === false) {
    // If coming from product page, maybe go to cart directly
    redirect('cart.php');
} else {
    redirect('cart.php');
}
