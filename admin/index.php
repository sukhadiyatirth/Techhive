<?php
// admin/index.php
require_once 'includes/auth.php';
require_once '../config/database.php';

// Fetch stats
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalCategories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$totalCustomers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pendingOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE order_status = 'pending'")->fetchColumn();
$deliveredOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE order_status = 'delivered'")->fetchColumn();
$totalRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE payment_status = 'paid'")->fetchColumn() ?: 0;

// Fetch Recent Orders
$recentOrders = $pdo->query("SELECT o.*, u.full_name FROM orders o JOIN users u ON o.user_id = u.user_id ORDER BY o.created_at DESC LIMIT 5")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TechHive Electronic</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    
    <?php include 'includes/sidebar.php'; ?>
    
    <main class="admin-main">
        <div class="admin-header">
            <h1>Dashboard Overview</h1>
            <div>
                Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?>
            </div>
        </div>
        
        <div class="admin-cards">
            <div class="card">
                <h3>Total Revenue</h3>
                <div class="value" style="color: var(--accent);">₹<?= number_format($totalRevenue, 2) ?></div>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <div class="value"><?= $totalOrders ?></div>
            </div>
            <div class="card">
                <h3>Pending Orders</h3>
                <div class="value" style="color: #ffc107;"><?= $pendingOrders ?></div>
            </div>
            <div class="card">
                <h3>Total Customers</h3>
                <div class="value"><?= $totalCustomers ?></div>
            </div>
            <div class="card">
                <h3>Total Products</h3>
                <div class="value"><?= $totalProducts ?></div>
            </div>
        </div>
        
        <h2 style="margin-bottom: 1rem; margin-top: 2rem;">Recent Orders</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recentOrders as $o): ?>
                <tr>
                    <td><?= htmlspecialchars($o['order_number']) ?></td>
                    <td><?= htmlspecialchars($o['full_name']) ?></td>
                    <td><?= date('M d, Y', strtotime($o['created_at'])) ?></td>
                    <td>₹<?= number_format($o['total_amount'], 2) ?></td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: var(--border); border-radius: 4px; font-size: 0.8rem; text-transform: capitalize;">
                            <?= htmlspecialchars($o['order_status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
</html>
