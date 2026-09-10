<?php
// admin/brands.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$stmt = $pdo->query("SELECT * FROM brands ORDER BY created_at DESC");
$brands = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Brands - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Brands</h1>
            <a href="add_brand.php" class="btn btn-primary">Add Brand</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($brands as $b): ?>
                <tr>
                    <td>#<?= $b['brand_id'] ?></td>
                    <td><?= htmlspecialchars($b['name']) ?></td>
                    <td><?= htmlspecialchars($b['slug']) ?></td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: var(--border); border-radius: 4px; font-size: 0.8rem; color: <?= $b['status'] == 'active' ? 'var(--success)' : 'var(--error)' ?>;">
                            <?= htmlspecialchars($b['status']) ?>
                        </span>
                    </td>
                    <td><?= date('M d, Y', strtotime($b['created_at'])) ?></td>
                    <td>
                        <a href="edit_brand.php?id=<?= $b['brand_id'] ?>" class="btn">Edit</a>
                        <a href="delete_brand.php?id=<?= $b['brand_id'] ?>" class="btn" style="color: var(--error); margin-left: 0.5rem;" onclick="return confirm('Delete this brand?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
