<?php
// admin/add_coupon.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = strtoupper($_POST['code'] ?? '');
    $type = $_POST['discount_type'] ?? 'percentage';
    $value = $_POST['discount_value'] ?? 0;
    $min_order = $_POST['minimum_order'] ?? 0;
    $limit = $_POST['usage_limit'] ?? null;
    $status = $_POST['status'] ?? 'active';

    if (empty($code) || $value <= 0) {
        $error = "Code and discount value are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO coupons (code, discount_type, discount_value, minimum_order, usage_limit, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$code, $type, $value, $min_order, $limit ?: null, $status]);
            $success = "Coupon created successfully!";
        } catch (PDOException $e) {
            $error = "Error adding coupon: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Coupon - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .form-group { margin-bottom: 1.5rem; max-width: 400px; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text); }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 4px; background: var(--bg); color: var(--text); }
        .form-row { display: flex; gap: 1rem; max-width: 800px; }
        .form-row .form-group { flex: 1; max-width: none; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Create Coupon</h1>
            <a href="coupons.php" class="btn">Back to Coupons</a>
        </div>
        
        <?php if ($error): ?>
            <div style="color: var(--error); padding: 1rem; border: 1px solid var(--error); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: var(--success); padding: 1rem; border: 1px solid var(--success); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div style="background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
            <form action="add_coupon.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Coupon Code</label>
                        <input type="text" name="code" placeholder="e.g. SUMMER20" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select name="discount_type">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (₹)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Discount Value</label>
                        <input type="number" step="0.01" name="discount_value" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Minimum Order Amount (₹)</label>
                        <input type="number" step="0.01" name="minimum_order" value="0">
                    </div>
                    <div class="form-group">
                        <label>Usage Limit (Leave blank for unlimited)</label>
                        <input type="number" name="usage_limit">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Coupon</button>
            </form>
        </div>
    </main>
</body>
</html>
