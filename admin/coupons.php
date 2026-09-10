<?php
// admin/coupons.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$stmt = $pdo->query("SELECT * FROM coupons ORDER BY created_at DESC");
$coupons = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coupons - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Coupons</h1>
            <a href="add_coupon.php" class="btn btn-primary">Create Coupon</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Min Order</th>
                    <th>Usage</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($coupons as $coupon): ?>
                <tr>
                    <td><strong style="color: var(--accent);"><?= htmlspecialchars($coupon['code']) ?></strong></td>
                    <td>
                        <?= $coupon['discount_type'] == 'percentage' ? htmlspecialchars($coupon['discount_value']) . '%' : '₹' . number_format($coupon['discount_value'], 2) ?>
                    </td>
                    <td>₹<?= number_format($coupon['minimum_order'], 2) ?></td>
                    <td><?= $coupon['used_count'] ?> / <?= $coupon['usage_limit'] ?: '∞' ?></td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: var(--border); border-radius: 4px; font-size: 0.8rem; color: <?= $coupon['status'] == 'active' ? 'var(--success)' : 'var(--error)' ?>;">
                            <?= htmlspecialchars($coupon['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_coupon.php?id=<?= $coupon['coupon_id'] ?>" class="btn">Edit</a>
                        <a href="delete_coupon.php?id=<?= $coupon['coupon_id'] ?>" class="btn" style="color: var(--error); margin-left: 0.5rem;" onclick="return confirm('Delete this coupon?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
