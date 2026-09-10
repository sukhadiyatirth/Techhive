<?php
// admin/categories.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$stmt = $pdo->query("SELECT * FROM categories ORDER BY created_at DESC");
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Categories</h1>
            <a href="add_category.php" class="btn btn-primary">Add Category</a>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $cat): ?>
                <tr>
                    <td>#<?= $cat['category_id'] ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td><?= htmlspecialchars(substr($cat['description'], 0, 50)) ?>...</td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: var(--border); border-radius: 4px; font-size: 0.8rem; color: <?= $cat['status'] == 'active' ? 'var(--success)' : 'var(--error)' ?>;">
                            <?= htmlspecialchars($cat['status']) ?>
                        </span>
                    </td>
                    <td><?= date('M d, Y', strtotime($cat['created_at'])) ?></td>
                    <td>
                        <a href="edit_category.php?id=<?= $cat['category_id'] ?>" class="btn">Edit</a>
                        <a href="delete_category.php?id=<?= $cat['category_id'] ?>" class="btn" style="color: var(--error); margin-left: 0.5rem;" onclick="return confirm('Delete this category?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
