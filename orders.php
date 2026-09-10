<?php
// orders.php
require_once 'includes/auth.php';
require_once 'config/database.php';

$pageTitle = 'My Orders - TechHive Electronic';
include 'includes/header.php';

$userId = $_SESSION['user_id'];

// Fetch Orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll();

// Helper for status badge
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
        <h1 style="font-size: 2.5rem; letter-spacing: -0.03em;">My Orders</h1>
    </div>
</div>

<section class="container section-padding" style="padding-top: 3rem;">
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar">
            <nav class="dashboard-nav">
                <a href="profile.php"><i data-lucide="layout-dashboard"></i> Dashboard</a>
                <a href="orders.php" class="active"><i data-lucide="package"></i> My Orders</a>
                <a href="wishlist.php"><i data-lucide="heart"></i> Wishlist</a>
                <a href="#"><i data-lucide="map-pin"></i> Addresses</a>
                <a href="#"><i data-lucide="user"></i> Account Details</a>
                <a href="logout.php" style="color: var(--error);"><i data-lucide="log-out"></i> Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="dashboard-main">
            <?php if (empty($orders)): ?>
                <div style="text-align: center; padding: 2rem 0;">
                    <i data-lucide="package-open" style="width: 48px; height: 48px; color: var(--muted); margin-bottom: 1rem;"></i>
                    <p style="color: var(--muted); margin-bottom: 1.5rem;">You haven't placed any orders yet.</p>
                    <a href="shop.php" class="btn btn-primary">Start Shopping</a>
                </div>
            <?php else: ?>
                <table class="cart-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--border); text-align: left;">Order ID</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--border); text-align: left;">Date</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--border); text-align: left;">Total</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--border); text-align: left;">Status</th>
                            <th style="padding: 1rem; border-bottom: 1px solid var(--border); text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 1rem; font-weight: 500;"><?= htmlspecialchars($order['order_number']) ?></td>
                            <td style="padding: 1rem; color: var(--muted);"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                            <td style="padding: 1rem; font-weight: 500;">₹<?= number_format($order['total_amount'], 2) ?></td>
                            <td style="padding: 1rem;"><?= getStatusBadge($order['order_status']) ?></td>
                            <td style="padding: 1rem; text-align: center;">
                                <a href="order-details.php?id=<?= $order['order_id'] ?>" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.8rem;">View</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
