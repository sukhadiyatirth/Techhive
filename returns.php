<?php
// returns.php
$pageTitle = 'Returns & Refunds - TechHive Electronic';
require_once 'includes/header.php';
?>

<div class="page-header" style="padding-top: 120px; text-align: center; margin-bottom: 3rem;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">Returns & <span style="color: var(--accent);">Refunds</span></h1>
        <p class="text-muted" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">Hassle-free returns because your satisfaction is our priority.</p>
    </div>
</div>

<section class="policy-section container" style="margin-bottom: 6rem; max-width: 900px;">
    <div class="policy-content" style="background: var(--surface); padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-soft);">
        
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">1. 14-Day Return Window</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">We accept returns up to 14 days after delivery, provided the item is unused, in its original pristine condition, and returned with all original packaging, tags, and accessories intact. We want you to be completely satisfied with your premium tech purchase.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">2. Return Process</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">To initiate a return, please follow these steps:</p>
            <ol style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem;">
                <li>Log into your TechHive account and navigate to the <strong>Orders</strong> section.</li>
                <li>Select the order containing the item you wish to return and click "Request Return".</li>
                <li>Follow the instructions to generate a prepaid return shipping label.</li>
                <li>Pack the item securely and drop it off at the designated carrier location.</li>
            </ol>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">3. Refunds</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">Once your return is received and inspected by our quality assurance team, we will send you an email to notify you that we have received your returned item. If the return is approved, your refund will be processed, and a credit will automatically be applied to your credit card or original method of payment within 5-7 business days.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">4. Defective or Damaged Items</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">In the unlikely event that your order arrives damaged or defective, please contact our support team immediately at <a href="mailto:support@techhive.com" style="color: var(--accent); text-decoration: underline;">support@techhive.com</a> with your order number and photos of the item's condition. We will arrange a replacement or full refund as quickly as possible.</p>
        </div>
        
    </div>
</section>

<!-- Mobile responsiveness styles -->
<style>
    @media (max-width: 768px) {
        .policy-content {
            padding: 2rem !important;
        }
    }
</style>

<?php require_once 'includes/footer.php'; ?>
