<?php
// coupon_action.php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['coupon_code'])) {
    $code = sanitizeInput($_POST['coupon_code']);
    
    $stmt = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND status = 'active' AND (expiry_date IS NULL OR expiry_date >= CURDATE())");
    $stmt->execute([$code]);
    $coupon = $stmt->fetch();
    
    if ($coupon) {
        // Calculate subtotal to check minimum order
        $subtotal = 0;
        if (!empty($_SESSION['cart'])) {
            $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
            $productIds = array_keys($_SESSION['cart']);
            $pStmt = $pdo->prepare("SELECT product_id, price, discount_price FROM products WHERE product_id IN ($placeholders)");
            $pStmt->execute($productIds);
            while($p = $pStmt->fetch()) {
                $qty = $_SESSION['cart'][$p['product_id']]['quantity'];
                $price = $p['discount_price'] ?: $p['price'];
                $subtotal += ($price * $qty);
            }
        }
        
        if ($subtotal >= $coupon['minimum_order']) {
            $discount = 0;
            if ($coupon['discount_type'] == 'percentage') {
                $discount = $subtotal * ($coupon['discount_value'] / 100);
                if ($coupon['maximum_discount'] && $discount > $coupon['maximum_discount']) {
                    $discount = $coupon['maximum_discount'];
                }
            } else {
                $discount = $coupon['discount_value'];
            }
            
            $_SESSION['coupon_code'] = $coupon['code'];
            $_SESSION['coupon_discount'] = $discount;
        }
    }
}

redirect('cart.php');
