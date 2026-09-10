<?php
// cart.php
require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Shopping Cart - TechHive Electronic';
include 'includes/header.php';

$cartItems = [];
$subtotal = 0;

if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $productIds = array_keys($_SESSION['cart']);
    
    $stmt = $pdo->prepare("
        SELECT p.*, b.name as brand_name 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.brand_id 
        WHERE p.product_id IN ($placeholders)
    ");
    $stmt->execute($productIds);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product) {
        $pid = $product['product_id'];
        $qty = $_SESSION['cart'][$pid]['quantity'];
        
        // Check stock
        if ($qty > $product['stock_quantity']) {
            $qty = $product['stock_quantity'];
            $_SESSION['cart'][$pid]['quantity'] = $qty;
        }
        
        $price = $product['discount_price'] ?: $product['price'];
        $total = $price * $qty;
        $subtotal += $total;
        
        $product['cart_quantity'] = $qty;
        $product['cart_total'] = $total;
        $product['current_price'] = $price;
        $cartItems[] = $product;
    }
}

// Discount logic could be applied here if a coupon is stored in session
$discount = $_SESSION['coupon_discount'] ?? 0;
// Delivery logic
$delivery = $subtotal > 0 ? ($subtotal > 100 ? 0 : 15) : 0; 
$grandTotal = $subtotal - $discount + $delivery;
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 2rem; border-bottom: 1px solid var(--border); margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">Shopping Cart</h1>
    </div>
</div>

<section class="container section-padding" style="padding-top: 0;">
    <?php if (empty($cartItems)): ?>
        <div style="text-align: center; padding: 4rem 0;">
            <i data-lucide="shopping-cart" style="width: 64px; height: 64px; color: var(--muted); margin-bottom: 1rem;"></i>
            <h2>Your cart is waiting for something amazing.</h2>
            <p style="color: var(--muted); margin-bottom: 2rem;">Discover our premium technology collection.</p>
            <a href="shop.php" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div class="cart-items">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th colspan="2">Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cartItems as $item): ?>
                            <?php
                            $imgUrl = "assets/images/products/" . ($item['product_image'] ?: 'default.jpg');
                            if (!file_exists($imgUrl)) {
                                $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80"; // fallback
                            }
                            ?>
                            <tr class="cart-item">
                                <td style="width: 100px;">
                                    <a href="product.php?slug=<?= $item['slug'] ?>">
                                        <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="cart-product-img">
                                    </a>
                                </td>
                                <td>
                                    <div class="cart-product-brand"><?= htmlspecialchars($item['brand_name']) ?></div>
                                    <a href="product.php?slug=<?= $item['slug'] ?>" class="cart-product-title"><?= htmlspecialchars($item['product_name']) ?></a>
                                    
                                    <form action="cart_action.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <button type="submit" class="cart-remove"><i data-lucide="trash-2" class="icon-sm"></i> Remove</button>
                                    </form>
                                </td>
                                <td>
                                    <span class="price">₹<?= number_format($item['current_price'], 2) ?></span>
                                    <?php if($item['discount_price']): ?>
                                        <br><span class="price-original" style="font-size: 0.8rem;">₹<?= number_format($item['price'], 2) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="cart_action.php" method="POST">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <div class="quantity-selector" style="height: 40px; width: 120px;">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.form.submit();">-</button>
                                            <input type="number" name="quantity" value="<?= $item['cart_quantity'] ?>" min="1" max="<?= $item['stock_quantity'] ?>" onchange="this.form.submit();">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.form.submit();">+</button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <strong>₹<?= number_format($item['cart_total'], 2) ?></strong>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-summary-box">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Order Summary</h3>
                
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
                
                <a href="checkout.php" class="btn btn-primary" style="width: 100%; margin-top: 2rem;">Proceed to Checkout</a>
                
                <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <form action="coupon_action.php" method="POST" style="display: flex; gap: 0.5rem;">
                        <input type="text" name="coupon_code" placeholder="Promo Code" class="form-control" style="padding: 0.5rem; font-size: 0.9rem;" required>
                        <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; border-radius: var(--radius-md);">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
