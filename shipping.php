<?php
// shipping.php
$pageTitle = 'Shipping Policy - TechHive Electronic';
require_once 'includes/header.php';
?>

<div class="page-header" style="padding-top: 120px; text-align: center; margin-bottom: 3rem;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">Shipping <span style="color: var(--accent);">Policy</span></h1>
        <p class="text-muted" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">Fast, reliable, and secure delivery for all your premium tech.</p>
    </div>
</div>

<section class="policy-section container" style="margin-bottom: 6rem; max-width: 900px;">
    <div class="policy-content" style="background: var(--surface); padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-soft);">
        
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">1. Order Processing Time</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">All orders are processed within 1 to 2 business days (excluding weekends and holidays) after receiving your order confirmation email. You will receive another notification when your order has shipped.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">2. Domestic Shipping Rates and Estimates</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">We offer flat-rate shipping for all domestic orders. Shipping charges for your order will be calculated and displayed at checkout.</p>
            <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem; list-style-type: disc;">
                <li><strong>Standard Shipping:</strong> 3-5 business days - ₹99 (Free on orders over ₹2000)</li>
                <li><strong>Express Shipping:</strong> 1-2 business days - ₹249</li>
                <li><strong>Same-Day Delivery:</strong> Available in select metro areas for orders placed before 12 PM - ₹499</li>
            </ul>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">3. International Shipping</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">We currently offer international shipping to select countries. Shipping rates and delivery estimates vary depending on the destination and will be calculated at checkout. Please note that international shipments may be subject to customs duties and taxes, which are the responsibility of the customer.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">4. Order Tracking</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">When your order has shipped, you will receive an email notification from us which will include a tracking number you can use to check its status. Please allow 24 hours for the tracking information to become available.</p>
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
