<?php
// privacy.php
$pageTitle = 'Privacy Policy - TechHive Electronic';
require_once 'includes/header.php';
?>

<div class="page-header" style="padding-top: 120px; text-align: center; margin-bottom: 3rem;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">Privacy <span style="color: var(--accent);">Policy</span></h1>
        <p class="text-muted" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">Last Updated: August 2026</p>
    </div>
</div>

<section class="policy-section container" style="margin-bottom: 6rem; max-width: 900px;">
    <div class="policy-content" style="background: var(--surface); padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-soft);">
        
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">1. Introduction</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">Welcome to TechHive Electronic. We respect your privacy and are committed to protecting your personal data. This privacy policy will inform you as to how we look after your personal data when you visit our website (regardless of where you visit it from) and tell you about your privacy rights and how the law protects you.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">2. The Data We Collect About You</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">Personal data, or personal information, means any information about an individual from which that person can be identified. We may collect, use, store and transfer different kinds of personal data about you which we have grouped together as follows:</p>
            <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem; list-style-type: disc;">
                <li><strong>Identity Data</strong> includes first name, last name, username or similar identifier.</li>
                <li><strong>Contact Data</strong> includes billing address, delivery address, email address and telephone numbers.</li>
                <li><strong>Financial Data</strong> includes payment card details (processed securely via our payment gateways).</li>
                <li><strong>Transaction Data</strong> includes details about payments to and from you and other details of products you have purchased from us.</li>
                <li><strong>Technical Data</strong> includes internet protocol (IP) address, your login data, browser type and version, time zone setting and location.</li>
            </ul>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">3. How We Use Your Personal Data</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">We will only use your personal data when the law allows us to. Most commonly, we will use your personal data in the following circumstances:</p>
            <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem; list-style-type: disc;">
                <li>Where we need to perform the contract we are about to enter into or have entered into with you (e.g., processing your order).</li>
                <li>Where it is necessary for our legitimate interests (or those of a third party) and your interests and fundamental rights do not override those interests.</li>
                <li>Where we need to comply with a legal obligation.</li>
            </ul>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">4. Data Security</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">We have put in place appropriate security measures to prevent your personal data from being accidentally lost, used, or accessed in an unauthorized way, altered, or disclosed. In addition, we limit access to your personal data to those employees, agents, contractors, and other third parties who have a business need to know. They will only process your personal data on our instructions and they are subject to a duty of confidentiality.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">5. Your Legal Rights</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">Under certain circumstances, you have rights under data protection laws in relation to your personal data, including the right to:</p>
            <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem; list-style-type: disc;">
                <li>Request access to your personal data.</li>
                <li>Request correction of your personal data.</li>
                <li>Request erasure of your personal data.</li>
                <li>Object to processing of your personal data.</li>
                <li>Request restriction of processing your personal data.</li>
            </ul>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">If you wish to exercise any of the rights set out above, please contact us at <a href="mailto:privacy@techhive.com" style="color: var(--accent); text-decoration: underline;">privacy@techhive.com</a>.</p>
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
