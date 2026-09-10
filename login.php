<?php
// login.php
require_once 'config/database.php';
require_once 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isLoggedIn()) {
    redirect('profile.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter email and password.';
    } else {
        // 1. Check if it is an admin
        $stmtAdmin = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmtAdmin->execute([$email]);
        $admin = $stmtAdmin->fetch();
        
        if ($admin && password_verify($password, $admin['password_hash'])) {
            // Admin Login Success
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['name'];
            redirect('admin/index.php');
        } else {
            // 2. Not an admin (or wrong password for admin), check if it is a regular user
            $stmtUser = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
            $stmtUser->execute([$email]);
            $user = $stmtUser->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // User Login Success
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                
                // Redirect to intended page or profile
                $redirect = $_SESSION['redirect_url'] ?? 'profile.php';
                unset($_SESSION['redirect_url']);
                redirect($redirect);
            } else {
                $error = 'Invalid email or password.';
            }
        }
    }
}

$pageTitle = 'Login - TechHive Electronic';
include 'includes/header.php';
?>

<div class="container" style="padding-top: 100px; padding-bottom: 4rem;">
    <div class="auth-container">
        <h1>Welcome Back</h1>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
            
            <div class="auth-links">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
