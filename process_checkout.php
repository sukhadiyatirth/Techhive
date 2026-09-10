<?php
// process_checkout.php
require_once 'includes/auth.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) {
    redirect('cart.php');
}

$userId = $_SESSION['user_id'];

// Get POST data
$address1 = sanitizeInput($_POST['address_line1'] ?? '');
$address2 = sanitizeInput($_POST['address_line2'] ?? '');
$city = sanitizeInput($_POST['city'] ?? '');
$state = sanitizeInput($_POST['state'] ?? '');
$pincode = sanitizeInput($_POST['pincode'] ?? '');
$country = sanitizeInput($_POST['country'] ?? '');
$payment_method = sanitizeInput($_POST['payment_method'] ?? 'cod');

$subtotal = (float)($_POST['subtotal'] ?? 0);
$discount = (float)($_POST['discount'] ?? 0);
$shipping_charge = (float)($_POST['shipping_charge'] ?? 0);
$total_amount = (float)($_POST['total_amount'] ?? 0);

// Combine address
$full_address = "$address1" . ($address2 ? ", $address2" : "") . "\n$city, $state $pincode\n$country";

// Generate unique order number (e.g., TH-20260816-ABCD)
$order_number = 'TH-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

// Handle Coupon ID if applied
$coupon_id = null;
if (!empty($_SESSION['coupon_code'])) {
    $stmt = $pdo->prepare("SELECT coupon_id FROM coupons WHERE code = ?");
    $stmt->execute([$_SESSION['coupon_code']]);
    $coupon_id = $stmt->fetchColumn() ?: null;
}

try {
    $pdo->beginTransaction();
    
    // Save address (optional, maybe insert into addresses table if you want to reuse)
    $stmt = $pdo->prepare("INSERT INTO addresses (user_id, address_line1, address_line2, city, state, pincode, country, is_default) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
    $stmt->execute([$userId, $address1, $address2, $city, $state, $pincode, $country]);

    // Create Order
    $payment_status = ($payment_method == 'online' || $payment_method == 'upi') ? 'paid' : 'pending'; // Mock digital payments as instantly paid for demo
    
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_number, subtotal, discount, shipping_charge, total_amount, payment_method, payment_status, order_status, shipping_address, coupon_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?)");
    $stmt->execute([$userId, $order_number, $subtotal, $discount, $shipping_charge, $total_amount, $payment_method, $payment_status, $full_address, $coupon_id]);
    
    $order_id = $pdo->lastInsertId();
    
    // Insert Order Items and Update Stock
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $productIds = array_keys($_SESSION['cart']);
    $stmt = $pdo->prepare("SELECT product_id, product_name, price, discount_price, stock_quantity FROM products WHERE product_id IN ($placeholders)");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtStock = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?");
    
    foreach ($products as $p) {
        $pid = $p['product_id'];
        $qty = $_SESSION['cart'][$pid]['quantity'];
        $price = $p['discount_price'] ?: $p['price'];
        $itemTotal = $price * $qty;
        
        $stmtItem->execute([$order_id, $pid, $p['product_name'], $price, $qty, $itemTotal]);
        $stmtStock->execute([$qty, $pid]);
    }
    
    // Update coupon usage if applicable
    if ($coupon_id) {
        $pdo->prepare("UPDATE coupons SET used_count = used_count + 1 WHERE coupon_id = ?")->execute([$coupon_id]);
    }
    
    $pdo->commit();
    
    // Clear Cart & Coupon
    unset($_SESSION['cart']);
    unset($_SESSION['coupon_code']);
    unset($_SESSION['coupon_discount']);
    
    // Redirect to success/order details page
    redirect("order-details.php?id=$order_id&success=1");
    
} catch (Exception $e) {
    $pdo->rollBack();
    die("Order processing failed: " . $e->getMessage());
}
