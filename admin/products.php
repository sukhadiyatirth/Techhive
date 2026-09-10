<?php
// admin/products.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$stmt = $pdo->query("SELECT p.*, c.name as cat_name, b.name as brand_name FROM products p LEFT JOIN categories c ON p.category_id = c.category_id LEFT JOIN brands b ON p.brand_id = b.brand_id ORDER BY p.created_at DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Products</h1>
            <a href="add_product.php" class="btn btn-primary">Add Product</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $p): ?>
                <tr>
                    <td>
                        <img src="../assets/images/products/<?= htmlspecialchars($p['product_image'] ?: 'default.jpg') ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                    </td>
                    <td><?= htmlspecialchars($p['product_name']) ?></td>
                    <td><?= htmlspecialchars($p['cat_name']) ?></td>
                    <td><?= htmlspecialchars($p['brand_name']) ?></td>
                    <td>₹<?= number_format($p['price'], 2) ?></td>
                    <td><?= $p['stock_quantity'] ?></td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: var(--border); border-radius: 4px; font-size: 0.8rem; color: <?= $p['status'] == 'active' ? 'var(--success)' : 'var(--muted)' ?>;">
                            <?= htmlspecialchars($p['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_product.php?id=<?= $p['product_id'] ?>" class="btn">Edit</a>
                        <a href="delete_product.php?id=<?= $p['product_id'] ?>" class="btn" style="color: var(--error); margin-left: 0.5rem;" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
