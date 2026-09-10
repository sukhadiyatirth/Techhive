<?php
// admin/edit_product.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: products.php");
    exit();
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
$brands = $pdo->query("SELECT * FROM brands ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $cat_id = $_POST['category_id'] ?? null;
    $brand_id = $_POST['brand_id'] ?? null;
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock_quantity'] ?? 0;
    $status = $_POST['status'] ?? 'active';
    $short_desc = $_POST['short_description'] ?? '';
    $full_desc = $_POST['full_description'] ?? '';
    $specs = $_POST['specifications'] ?? '';
    
    // File upload logic
    $imageUpdateSql = "";
    $imageName = null;
    
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['product_image']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['product_image']['name']);
        $uploadDir = '../assets/images/products/';
        
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        
        if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
            $imageName = $fileName;
            $imageUpdateSql = ", product_image = ?";
        } else {
            $error = "Failed to upload image.";
        }
    }

    if (empty($error)) {
        try {
            $sql = "UPDATE products SET product_name=?, slug=?, sku=?, category_id=?, brand_id=?, price=?, stock_quantity=?, status=?, short_description=?, full_description=?, specifications=? $imageUpdateSql WHERE product_id=?";
            $stmt = $pdo->prepare($sql);
            
            $params = [$name, $slug, $sku, $cat_id, $brand_id, $price, $stock, $status, $short_desc, $full_desc, $specs];
            if ($imageName) $params[] = $imageName;
            $params[] = $id;
            
            $stmt->execute($params);
            $success = "Product updated successfully!";
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}

// Fetch current product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text); }
        .form-group input, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 4px; background: var(--bg); color: var(--text); }
        .form-row { display: flex; gap: 1rem; }
        .form-row .form-group { flex: 1; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="admin-main">
        <div class="admin-header">
            <h1>Edit Product</h1>
            <a href="products.php" class="btn">Back to Products</a>
        </div>
        
        <?php if ($error): ?>
            <div style="color: var(--error); padding: 1rem; border: 1px solid var(--error); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: var(--success); padding: 1rem; border: 1px solid var(--success); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div style="background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
            <form action="edit_product.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Slug (URL Friendly)</label>
                        <input type="text" name="slug" value="<?= htmlspecialchars($product['slug']) ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" value="<?= htmlspecialchars($product['sku']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach($categories as $c): ?>
                                <option value="<?= $c['category_id'] ?>" <?= $product['category_id'] == $c['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <select name="brand_id" required>
                            <option value="">Select Brand</option>
                            <?php foreach($brands as $b): ?>
                                <option value="<?= $b['brand_id'] ?>" <?= $product['brand_id'] == $b['brand_id'] ? 'selected' : '' ?>><?= htmlspecialchars($b['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Price (₹)</label>
                        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock_quantity" value="<?= $product['stock_quantity'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?= $product['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $product['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="out_of_stock" <?= $product['status'] == 'out_of_stock' ? 'selected' : '' ?>>Out of Stock</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Short Description (Used on Product Cards)</label>
                        <input type="text" name="short_description" value="<?= htmlspecialchars($product['short_description'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Full Description</label>
                        <textarea name="full_description" rows="5" placeholder="Detailed product description..."><?= htmlspecialchars($product['full_description'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Specifications (Format: Key: Value, one per line)</label>
                        <textarea name="specifications" rows="5" placeholder="Battery: 24 Hours&#10;Display: OLED"><?= htmlspecialchars($product['specifications'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Main Product Image (Leave blank to keep existing image)</label>
                    <?php if ($product['product_image']): ?>
                        <div style="margin-bottom: 0.5rem;">
                            <img src="../assets/images/products/<?= htmlspecialchars($product['product_image']) ?>" style="width: 80px; border-radius: 4px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="product_image" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </main>
</body>
</html>
