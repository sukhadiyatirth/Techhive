<?php
// order-details.php
require_once 'includes/auth.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

$order_id = $_GET['id'] ?? 0;
$userId = $_SESSION['user_id'];

// Fetch Order
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->execute([$order_id, $userId]);
$order = $stmt->fetch();

if (!$order) {
    redirect('orders.php');
}

// Fetch Order Items
$stmt = $pdo->prepare("SELECT oi.*, p.slug, p.product_image, b.name as brand_name FROM order_items oi LEFT JOIN products p ON oi.product_id = p.product_id LEFT JOIN brands b ON p.brand_id = b.brand_id WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

$pageTitle = 'Order Details - ' . htmlspecialchars($order['order_number']);
include 'includes/header.php';

function getStatusBadge($status) {
    switch ($status) {
        case 'pending': return '<span class="badge" style="background: #ffc107; color: #000;">Pending</span>';
        case 'confirmed': return '<span class="badge" style="background: #17a2b8; color: #fff;">Confirmed</span>';
        case 'processing': return '<span class="badge" style="background: #007bff; color: #fff;">Processing</span>';
        case 'shipped': return '<span class="badge" style="background: #6f42c1; color: #fff;">Shipped</span>';
        case 'out_for_delivery': return '<span class="badge" style="background: #fd7e14; color: #fff;">Out for Delivery</span>';
        case 'delivered': return '<span class="badge badge-success" style="background: var(--success); color: #fff;">Delivered</span>';
        case 'cancelled': return '<span class="badge badge-error" style="background: var(--error); color: #fff;">Cancelled</span>';
        default: return '<span class="badge">Unknown</span>';
    }
}
?>

<div style="background: var(--surface); padding-top: 100px; padding-bottom: 2rem; border-bottom: 1px solid var(--border);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">Order Details</h1>
                <p style="color: var(--muted); margin-top: 0.5rem;">Order #<?= htmlspecialchars($order['order_number']) ?></p>
            </div>
            <div>
                <a href="orders.php" class="btn btn-outline" style="padding: 0.5rem 1rem;">Back to Orders</a>
            </div>
        </div>
    </div>
</div>

<section class="container section-padding" style="padding-top: 3rem;">
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" style="margin-bottom: 2rem;">
            <i data-lucide="check-circle" style="vertical-align: middle; margin-right: 0.5rem;"></i>
            Thank you! Your order has been placed successfully.
        </div>
    <?php endif; ?>
    
    <div class="dashboard-layout">
        
        <div style="flex-grow: 1;">
            <div style="background: var(--surface); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--border); margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border);">
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem; display: block; margin-bottom: 0.25rem;">Order Date</span>
                        <strong style="font-size: 1.1rem;"><?= date('F d, Y', strtotime($order['created_at'])) ?></strong>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem; display: block; margin-bottom: 0.25rem;">Status</span>
                        <?= getStatusBadge($order['order_status']) ?>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem; display: block; margin-bottom: 0.25rem;">Payment Method</span>
                        <strong style="font-size: 1.1rem; text-transform: uppercase;"><?= htmlspecialchars($order['payment_method']) ?></strong>
                    </div>
                </div>
                
                <h3 style="margin-bottom: 1.5rem;">Items in your order</h3>
                
                <table class="cart-table" style="width: 100%; border-collapse: collapse;">
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 1rem 0; width: 60px;">
                                <?php
                                $imgUrl = "assets/images/products/" . ($item['product_image'] ?: 'default.jpg');
                                if (!file_exists($imgUrl)) {
                                    $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=100&q=80";
                                }
                                ?>
                                <img src="<?= $imgUrl ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td style="padding: 1rem;">
                                <div style="color: var(--muted); font-size: 0.8rem;"><?= htmlspecialchars($item['brand_name'] ?? '') ?></div>
                                <?php if($item['slug']): ?>
                                    <a href="product.php?slug=<?= $item['slug'] ?>" style="font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></a>
                                <?php else: ?>
                                    <span style="font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1rem; text-align: center;">Qty: <?= $item['quantity'] ?></td>
                            <td style="padding: 1rem; text-align: right; font-weight: 500;">₹<?= number_format($item['total'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            </div>
        </div>
        
        <div style="width: 350px; flex-shrink: 0;">
            <div style="background: var(--surface); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--border); margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹<?= number_format($order['subtotal'], 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Delivery</span>
                    <span><?= $order['shipping_charge'] == 0 ? 'Free' : '₹'.number_format($order['shipping_charge'], 2) ?></span>
                </div>
                <?php if($order['discount'] > 0): ?>
                <div class="summary-row" style="color: var(--success);">
                    <span>Discount</span>
                    <span>-₹<?= number_format($order['discount'], 2) ?></span>
                </div>
                <?php endif; ?>
                
                <div class="summary-row summary-total">
                    <span>Grand Total</span>
                    <span style="color: var(--accent);">₹<?= number_format($order['total_amount'], 2) ?></span>
                </div>
            </div>
            
            <div style="background: var(--surface); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--border);">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Shipping Address</h3>
                <p style="color: var(--muted); line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($order['shipping_address'])) ?>
                </p>
            </div>
        </div>
        
    </div>
</section>

<?php include 'includes/footer.php'; ?>
