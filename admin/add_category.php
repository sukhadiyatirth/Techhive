<?php
// admin/add_category.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'active';

    if (empty($name) || empty($slug)) {
        $error = "Name and slug are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $slug, $description, $status]);
            $success = "Category added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding category: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .form-group { margin-bottom: 1.5rem; max-width: 600px; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text); }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 4px; background: var(--bg); color: var(--text); }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Add Category</h1>
            <a href="categories.php" class="btn">Back to Categories</a>
        </div>
        
        <?php if ($error): ?>
            <div style="color: var(--error); padding: 1rem; border: 1px solid var(--error); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: var(--success); padding: 1rem; border: 1px solid var(--success); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div style="background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
            <form action="add_category.php" method="POST">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Slug (URL Friendly)</label>
                    <input type="text" name="slug" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Category</button>
            </form>
        </div>
    </main>
</body>
</html>
