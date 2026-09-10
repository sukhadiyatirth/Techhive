<?php
// contact.php
require_once 'config/database.php';
$pageTitle = 'Contact Us - TechHive Electronic';
require_once 'includes/header.php';

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            $successMessage = "Thank you, $name! Your message has been sent successfully. Our team will get back to you shortly.";
        } catch(PDOException $e) {
            $errorMessage = "Sorry, there was an error sending your message. Please try again later.";
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}
?>

<div class="page-header" style="padding-top: 120px; text-align: center; margin-bottom: 3rem;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">Get in <span style="color: var(--accent);">Touch</span></h1>
        <p class="text-muted" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">Have a question about our products or need support? We're here to help.</p>
    </div>
</div>

<section class="contact-section container" style="margin-bottom: 6rem;">
    <?php if ($successMessage): ?>
        <div class="alert alert-success" style="background: rgba(0, 200, 81, 0.1); color: var(--success); border: 1px solid var(--success); padding: 1.5rem; border-radius: var(--radius-md); text-align: center; margin-bottom: 3rem;">
            <i data-lucide="check-circle" style="display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" style="background: rgba(255, 68, 68, 0.1); color: #ff4444; border: 1px solid #ff4444; padding: 1.5rem; border-radius: var(--radius-md); text-align: center; margin-bottom: 3rem;">
            <i data-lucide="alert-circle" style="display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>

    <div class="contact-grid" style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 4rem;">
        
        <!-- Contact Information -->
        <div class="contact-info">
            <h2 style="font-size: 2rem; margin-bottom: 2rem;">Contact Information</h2>
            
            <div class="info-item" style="display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: flex-start;">
                <div class="icon-box" style="background: var(--surface); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid var(--border);">
                    <i data-lucide="map-pin" style="color: var(--accent);"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Our Store</h3>
                    <p style="color: var(--muted); line-height: 1.6;">123 Premium Tech Avenue,<br>Silicon District, City 40001<br>United States</p>
                </div>
            </div>
            
            <div class="info-item" style="display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: flex-start;">
                <div class="icon-box" style="background: var(--surface); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid var(--border);">
                    <i data-lucide="phone" style="color: var(--accent);"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Phone Number</h3>
                    <p style="color: var(--muted); line-height: 1.6;">+1 (555) 123-4567<br>Mon-Fri, 9am - 6pm EST</p>
                </div>
            </div>
            
            <div class="info-item" style="display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: flex-start;">
                <div class="icon-box" style="background: var(--surface); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid var(--border);">
                    <i data-lucide="mail" style="color: var(--accent);"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Email Address</h3>
                    <p style="color: var(--muted); line-height: 1.6;">support@techhive.com<br>sales@techhive.com</p>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="contact-form-wrapper" style="background: var(--surface); padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-soft);">
            <h2 style="font-size: 2rem; margin-bottom: 2rem;">Send us a Message</h2>
            
            <form action="contact.php" method="POST" class="contact-form">
                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="name" style="display: block; margin-bottom: 0.5rem; color: var(--muted);">Your Name</label>
                        <input type="text" id="name" name="name" required style="width: 100%; padding: 1rem; background: var(--background); border: 1px solid var(--border); border-radius: var(--radius-md); color: var(--text); font-family: inherit; transition: var(--transition);">
                    </div>
                    <div class="form-group">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; color: var(--muted);">Your Email</label>
                        <input type="email" id="email" name="email" required style="width: 100%; padding: 1rem; background: var(--background); border: 1px solid var(--border); border-radius: var(--radius-md); color: var(--text); font-family: inherit; transition: var(--transition);">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="subject" style="display: block; margin-bottom: 0.5rem; color: var(--muted);">Subject</label>
                    <input type="text" id="subject" name="subject" required style="width: 100%; padding: 1rem; background: var(--background); border: 1px solid var(--border); border-radius: var(--radius-md); color: var(--text); font-family: inherit; transition: var(--transition);">
                </div>
                
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="message" style="display: block; margin-bottom: 0.5rem; color: var(--muted);">Message</label>
                    <textarea id="message" name="message" rows="6" required style="width: 100%; padding: 1rem; background: var(--background); border: 1px solid var(--border); border-radius: var(--radius-md); color: var(--text); font-family: inherit; transition: var(--transition); resize: vertical;"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 1.1rem; display: flex; justify-content: center; gap: 10px; align-items: center;">
                    Send Message <i data-lucide="send"></i>
                </button>
            </form>
        </div>
        
    </div>
</section>

<!-- Mobile responsiveness styles for Contact page -->
<style>
    .form-group input:focus, .form-group textarea:focus {
        border-color: var(--accent) !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }
    
    @media (max-width: 900px) {
        .contact-grid {
            grid-template-columns: 1fr !important;
            gap: 3rem !important;
        }
    }
    @media (max-width: 600px) {
        .form-grid {
            grid-template-columns: 1fr !important;
        }
        .contact-form-wrapper {
            padding: 2rem !important;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>

<?php require_once 'includes/footer.php'; ?>
