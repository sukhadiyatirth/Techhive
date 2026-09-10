<?php
// admin/edit_brand.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: brands.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $status = $_POST['status'] ?? 'active';

    if (empty($name) || empty($slug)) {
        $error = "Name and slug are required.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE brands SET name=?, slug=?, status=? WHERE brand_id=?");
            $stmt->execute([$name, $slug, $status, $id]);
            $success = "Brand updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating brand: " . $e->getMessage();
        }
    }
}

// Fetch current brand data
$stmt = $pdo->prepare("SELECT * FROM brands WHERE brand_id = ?");
$stmt->execute([$id]);
$brand = $stmt->fetch();

if (!$brand) {
    header("Location: brands.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Brand - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .form-group { margin-bottom: 1.5rem; max-width: 400px; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text); }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 4px; background: var(--bg); color: var(--text); }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Edit Brand</h1>
            <a href="brands.php" class="btn">Back to Brands</a>
        </div>
        
        <?php if ($error): ?>
            <div style="color: var(--error); padding: 1rem; border: 1px solid var(--error); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: var(--success); padding: 1rem; border: 1px solid var(--success); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div style="background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
            <form action="edit_brand.php?id=<?= $id ?>" method="POST">
                <div class="form-group">
                    <label>Brand Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($brand['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Slug (URL Friendly)</label>
                    <input type="text" name="slug" value="<?= htmlspecialchars($brand['slug']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="active" <?= $brand['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $brand['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Brand</button>
            </form>
        </div>
    </main>
</body>
</html>
