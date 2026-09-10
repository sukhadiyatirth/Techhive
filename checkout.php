<?php
// checkout.php
require_once 'includes/auth.php'; // Require login to checkout
require_once 'config/database.php';
require_once 'includes/functions.php';

if (empty($_SESSION['cart'])) {
    redirect('cart.php');
}

$pageTitle = 'Checkout - TechHive Electronic';
include 'includes/header.php';

$userId = $_SESSION['user_id'];

// Calculate Totals
$subtotal = 0;
$placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
$productIds = array_keys($_SESSION['cart']);

$stmt = $pdo->prepare("SELECT product_id, product_name, price, discount_price, stock_quantity, product_image FROM products WHERE product_id IN ($placeholders)");
$stmt->execute($productIds);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$cartItems = [];
foreach ($products as $p) {
    $qty = $_SESSION['cart'][$p['product_id']]['quantity'];
    $price = $p['discount_price'] ?: $p['price'];
    $subtotal += ($price * $qty);
    $p['cart_quantity'] = $qty;
    $p['current_price'] = $price;
    $cartItems[] = $p;
}

$discount = $_SESSION['coupon_discount'] ?? 0;
$delivery = $subtotal > 0 ? ($subtotal > 100 ? 0 : 15) : 0; 
$grandTotal = $subtotal - $discount + $delivery;

// Fetch user addresses (if any)
$stmt = $pdo->prepare("SELECT * FROM addresses WHERE user_id = ? ORDER BY is_default DESC");
$stmt->execute([$userId]);
$addresses = $stmt->fetchAll();
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 2rem; border-bottom: 1px solid var(--border); margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">Checkout</h1>
    </div>
</div>

<section class="container section-padding" style="padding-top: 0;">
    <form action="process_checkout.php" method="POST" class="cart-layout">
        
        <!-- Left: Form -->
        <div class="cart-items" style="background: var(--surface); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--border);">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Shipping Address</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Address Line 1 *</label>
                    <input type="text" name="address_line1" class="form-control" required>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label>Address Line 2 (Optional)</label>
                    <input type="text" name="address_line2" class="form-control">
                </div>
                <div class="form-group">
                    <label>City *</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>State *</label>
                    <input type="text" name="state" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Pincode/ZIP *</label>
                    <input type="text" name="pincode" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Country *</label>
                    <input type="text" name="country" class="form-control" required>
                </div>
            </div>
            
            <h3 style="margin-bottom: 1.5rem; margin-top: 2rem; font-size: 1.2rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Payment Method</h3>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; cursor: pointer; color: var(--text);">
                    <input type="radio" name="payment_method" value="cod" checked onchange="toggleUPI(false)">
                    Cash on Delivery (COD)
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; cursor: pointer; color: var(--text);">
                    <input type="radio" name="payment_method" value="online" onchange="toggleUPI(false)">
                    Demo Online Payment (Credit Card / Netbanking)
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--text);">
                    <input type="radio" name="payment_method" value="upi" onchange="toggleUPI(true)">
                    UPI / QR Code Scan
                </label>
            </div>
            
            <div id="upi-qr-section" style="display: none; margin-top: 1.5rem; padding: 1.5rem; background: var(--bg); border: 1px dashed var(--accent); border-radius: 8px; text-align: center;">
                <h4 style="margin-bottom: 1rem; color: var(--text);">Scan to Pay ₹<?= number_format($grandTotal, 2) ?></h4>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=techhive@upi%26pn=TechHive%26am=<?= $grandTotal ?>%26cu=INR" alt="UPI QR Code" style="background: white; padding: 10px; border-radius: 8px; margin-bottom: 1rem;">
                <p style="color: var(--muted); font-size: 0.9rem;">Use Google Pay, PhonePe, Paytm, or any UPI app to scan and pay.</p>
            </div>

            <script>
            function toggleUPI(show) {
                document.getElementById('upi-qr-section').style.display = show ? 'block' : 'none';
            }
            </script>
            
        </div>
        
        <!-- Right: Summary -->
        <div class="cart-summary-box">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Order Summary</h3>
            
            <div style="margin-bottom: 1.5rem; max-height: 300px; overflow-y: auto;">
                <?php foreach($cartItems as $item): ?>
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                    <?php
                    $imgUrl = "assets/images/products/" . ($item['product_image'] ?: 'default.jpg');
                    if (!file_exists($imgUrl)) {
                        $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80";
                    }
                    ?>
                    <img src="<?= $imgUrl ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    <div style="flex-grow: 1;">
                        <div style="font-size: 0.9rem; font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></div>
                        <div style="color: var(--muted); font-size: 0.8rem;">Qty: <?= $item['cart_quantity'] ?></div>
                    </div>
                    <div style="font-size: 0.9rem; font-weight: 600;">₹<?= number_format($item['current_price'] * $item['cart_quantity'], 2) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="summary-row">
                <span>Subtotal</span>
                <span>₹<?= number_format($subtotal, 2) ?></span>
            </div>
            <div class="summary-row">
                <span>Delivery</span>
                <span><?= $delivery == 0 ? 'Free' : '₹'.number_format($delivery, 2) ?></span>
            </div>
            <?php if($discount > 0): ?>
            <div class="summary-row" style="color: var(--success);">
                <span>Discount</span>
                <span>-₹<?= number_format($discount, 2) ?></span>
            </div>
            <?php endif; ?>
            
            <div class="summary-row summary-total">
                <span>Grand Total</span>
                <span style="color: var(--accent);">₹<?= number_format($grandTotal, 2) ?></span>
            </div>
            
            <!-- Hidden fields for totals -->
            <input type="hidden" name="subtotal" value="<?= $subtotal ?>">
            <input type="hidden" name="discount" value="<?= $discount ?>">
            <input type="hidden" name="shipping_charge" value="<?= $delivery ?>">
            <input type="hidden" name="total_amount" value="<?= $grandTotal ?>">
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 2rem;">Place Order</button>
        </div>
        
    </form>
</section>

<?php include 'includes/footer.php'; ?>
