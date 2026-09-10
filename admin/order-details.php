<?php
// admin/order-details.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$order_id = $_GET['id'] ?? 0;
$success = '';
$error = '';

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['order_status'] ?? '';
    if ($new_status) {
        try {
            $stmt = $pdo->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
            $stmt->execute([$new_status, $order_id]);
            $success = "Order status updated successfully.";
        } catch (PDOException $e) {
            $error = "Failed to update status.";
        }
    }
}

// Fetch Order and User details
$stmt = $pdo->prepare("SELECT o.*, u.full_name, u.email, u.phone FROM orders o JOIN users u ON o.user_id = u.user_id WHERE o.order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    header("Location: orders.php");
    exit();
}

// Fetch Order Items
$stmt = $pdo->prepare("SELECT oi.*, p.slug, p.product_image, b.name as brand_name FROM order_items oi LEFT JOIN products p ON oi.product_id = p.product_id LEFT JOIN brands b ON p.brand_id = b.brand_id WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

function getStatusBadge($status) {
    switch ($status) {
        case 'pending': return '<span style="padding: 4px 8px; border-radius: 4px; background: #ffc107; color: #000; font-size: 0.8rem; font-weight: 600;">Pending</span>';
        case 'confirmed': return '<span style="padding: 4px 8px; border-radius: 4px; background: #17a2b8; color: #fff; font-size: 0.8rem; font-weight: 600;">Confirmed</span>';
        case 'processing': return '<span style="padding: 4px 8px; border-radius: 4px; background: #007bff; color: #fff; font-size: 0.8rem; font-weight: 600;">Processing</span>';
        case 'shipped': return '<span style="padding: 4px 8px; border-radius: 4px; background: #6f42c1; color: #fff; font-size: 0.8rem; font-weight: 600;">Shipped</span>';
        case 'out_for_delivery': return '<span style="padding: 4px 8px; border-radius: 4px; background: #fd7e14; color: #fff; font-size: 0.8rem; font-weight: 600;">Out for Delivery</span>';
        case 'delivered': return '<span style="padding: 4px 8px; border-radius: 4px; background: var(--success); color: #fff; font-size: 0.8rem; font-weight: 600;">Delivered</span>';
        case 'cancelled': return '<span style="padding: 4px 8px; border-radius: 4px; background: var(--error); color: #fff; font-size: 0.8rem; font-weight: 600;">Cancelled</span>';
        default: return '<span style="padding: 4px 8px; border-radius: 4px; background: var(--border); color: var(--text); font-size: 0.8rem; font-weight: 600;">Unknown</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .grid-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start; }
        .card { background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 2rem; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--muted); }
        .summary-total { border-top: 1px solid var(--border); padding-top: 1rem; margin-top: 1rem; font-size: 1.1rem; font-weight: 600; color: var(--text); }
        .form-control { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 4px; background: var(--bg); color: var(--text); }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <div>
                <h1>Order #<?= htmlspecialchars($order['order_number']) ?></h1>
                <p style="color: var(--muted); margin-top: 0.5rem; font-size: 0.9rem;">Placed on <?= date('F d, Y h:i A', strtotime($order['created_at'])) ?></p>
            </div>
            <a href="orders.php" class="btn">Back to Orders</a>
        </div>
        
        <?php if ($error): ?>
            <div style="color: var(--error); padding: 1rem; border: 1px solid var(--error); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: var(--success); padding: 1rem; border: 1px solid var(--success); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="grid-layout">
            <!-- Left Column: Items and Customer -->
            <div>
                <div class="card">
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Order Items</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            <?php foreach($items as $item): ?>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 1rem 0; width: 60px;">
                                    <?php
                                    $imgUrl = "../assets/images/products/" . ($item['product_image'] ?: 'default.jpg');
                                    if (!file_exists($imgUrl)) {
                                        $imgUrl = "https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=100&q=80";
                                    }
                                    ?>
                                    <img src="<?= $imgUrl ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td style="padding: 1rem;">
                                    <div style="color: var(--muted); font-size: 0.8rem;"><?= htmlspecialchars($item['brand_name'] ?? '') ?></div>
                                    <div style="font-weight: 500;"><?= htmlspecialchars($item['product_name']) ?></div>
                                </td>
                                <td style="padding: 1rem; text-align: center;">Qty: <?= $item['quantity'] ?></td>
                                <td style="padding: 1rem; text-align: right; font-weight: 500;">₹<?= number_format($item['total'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Customer Details</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <span style="color: var(--muted); font-size: 0.9rem; display: block;">Name</span>
                            <strong style="font-size: 1rem;"><?= htmlspecialchars($order['full_name']) ?></strong>
                        </div>
                        <div>
                            <span style="color: var(--muted); font-size: 0.9rem; display: block;">Email</span>
                            <strong style="font-size: 1rem;"><?= htmlspecialchars($order['email']) ?></strong>
                        </div>
                        <div>
                            <span style="color: var(--muted); font-size: 0.9rem; display: block;">Phone</span>
                            <strong style="font-size: 1rem;"><?= htmlspecialchars($order['phone'] ?? 'N/A') ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Status & Summary -->
            <div>
                <div class="card" style="background: var(--bg); border: 2px solid var(--accent); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--accent);"></div>
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; color: var(--accent);">Update Status</h3>
                    
                    <div style="margin-bottom: 1rem;">
                        <span style="color: var(--muted); font-size: 0.9rem; display: block; margin-bottom: 0.25rem;">Current Status</span>
                        <?= getStatusBadge($order['order_status']) ?>
                    </div>

                    <form action="order-details.php?id=<?= $order_id ?>" method="POST" style="margin-top: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--text); font-weight: 500;">Change Status To</label>
                            <select name="order_status" class="form-control" style="border-color: var(--accent); box-shadow: 0 0 0 1px var(--accent) inset;">
                                <?php
                                $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'out_for_delivery', 'delivered', 'cancelled'];
                                foreach ($statuses as $st) {
                                    $selected = ($st == $order['order_status']) ? 'selected' : '';
                                    
                                    // Determine color for this option
                                    $color = 'var(--text)';
                                    switch ($st) {
                                        case 'pending': $color = '#ffc107'; break; // Yellow
                                        case 'confirmed': $color = '#17a2b8'; break; // Teal
                                        case 'processing': $color = '#007bff'; break; // Blue
                                        case 'shipped': $color = '#6f42c1'; break; // Purple
                                        case 'out_for_delivery': $color = '#fd7e14'; break; // Orange
                                        case 'delivered': $color = 'var(--success)'; break; // Green
                                        case 'cancelled': $color = 'var(--error)'; break; // Red
                                    }
                                    
                                    echo "<option value=\"$st\" $selected style=\"color: $color; font-weight: 600; background: var(--bg);\">" . ucfirst(str_replace('_', ' ', $st)) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="update_status" class="btn btn-primary" style="width: 100%; font-weight: 600;">Update Order Status</button>
                    </form>
                </div>

                <div class="card">
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Payment Method</span>
                        <span style="text-transform: uppercase; font-weight: 500; color: var(--text);"><?= htmlspecialchars($order['payment_method']) ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Payment Status</span>
                        <span style="font-weight: 500; color: <?= $order['payment_status'] == 'paid' ? 'var(--success)' : 'var(--error)' ?>;">
                            <?= ucfirst($order['payment_status']) ?>
                        </span>
                    </div>
                    
                    <hr style="border: none; border-top: 1px solid var(--border); margin: 1rem 0;">

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

                <div class="card">
                    <h3 style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Shipping Address</h3>
                    <p style="color: var(--muted); line-height: 1.8; font-size: 0.95rem;">
                        <?= nl2br(htmlspecialchars($order['shipping_address'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
