<?php
// admin/customers.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$customers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Manage Customers</h1>
        </div>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($customers as $c): ?>
                <tr>
                    <td>#<?= $c['user_id'] ?></td>
                    <td><?= htmlspecialchars($c['full_name']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['phone'] ?? 'N/A') ?></td>
                    <td>
                        <span style="padding: 0.25rem 0.5rem; background: var(--border); border-radius: 4px; font-size: 0.8rem; color: <?= $c['status'] == 'active' ? 'var(--success)' : 'var(--error)' ?>;">
                            <?= htmlspecialchars($c['status']) ?>
                        </span>
                    </td>
                    <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                    <td>
                        <a href="edit_customer.php?id=<?= $c['user_id'] ?>" class="btn">Edit</a>
                        <?php if ($c['status'] == 'active'): ?>
                            <a href="delete_customer.php?id=<?= $c['user_id'] ?>" class="btn" style="color: var(--error); margin-left: 0.5rem;" onclick="return confirm('Are you sure you want to disable this user?');">Disable</a>
                        <?php else: ?>
                            <span style="color: var(--muted); margin-left: 0.5rem;">Removed</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
