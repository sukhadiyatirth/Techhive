<?php
// admin/edit_customer.php
require_once 'includes/auth.php';
require_once '../config/database.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: customers.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $status = $_POST['status'] ?? 'active';

    if (empty($full_name) || empty($email)) {
        $error = "Name and email are required.";
    } else {
        try {
            // Check if email already exists for another user
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
            $stmt->execute([$email, $id]);
            if ($stmt->fetch()) {
                $error = "Email is already taken by another user.";
            } else {
                $stmt = $pdo->prepare("UPDATE users SET full_name=?, email=?, phone=?, status=? WHERE user_id=?");
                $stmt->execute([$full_name, $email, $phone, $status, $id]);
                $success = "Customer updated successfully!";
            }
        } catch (PDOException $e) {
            $error = "Error updating customer: " . $e->getMessage();
        }
    }
}

// Fetch current customer data
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    header("Location: customers.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer - Admin</title>
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
            <h1>Edit Customer</h1>
            <a href="customers.php" class="btn">Back to Customers</a>
        </div>
        
        <?php if ($error): ?>
            <div style="color: var(--error); padding: 1rem; border: 1px solid var(--error); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: var(--success); padding: 1rem; border: 1px solid var(--success); border-radius: 4px; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div style="background: var(--surface); padding: 2rem; border-radius: 8px; border: 1px solid var(--border);">
            <form action="edit_customer.php?id=<?= $id ?>" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($customer['full_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="active" <?= $customer['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $customer['status'] == 'inactive' ? 'selected' : '' ?>>Inactive (Disabled)</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Customer</button>
            </form>
        </div>
    </main>
</body>
</html>
