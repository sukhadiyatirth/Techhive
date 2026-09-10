<?php
// terms.php
$pageTitle = 'Terms of Service - TechHive Electronic';
require_once 'includes/header.php';
?>

<div class="page-header" style="padding-top: 120px; text-align: center; margin-bottom: 3rem;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">Terms of <span style="color: var(--accent);">Service</span></h1>
        <p class="text-muted" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">Last Updated: August 2026</p>
    </div>
</div>

<section class="policy-section container" style="margin-bottom: 6rem; max-width: 900px;">
    <div class="policy-content" style="background: var(--surface); padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-soft);">
        
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">1. Agreement to Terms</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">These Terms of Service constitute a legally binding agreement made between you, whether personally or on behalf of an entity ("you") and TechHive Electronic ("we," "us" or "our"), concerning your access to and use of our website as well as any other media form, media channel, mobile website or mobile application related, linked, or otherwise connected thereto.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">2. Intellectual Property Rights</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site (collectively, the "Content") and the trademarks, service marks, and logos contained therein (the "Marks") are owned or controlled by us or licensed to us, and are protected by copyright and trademark laws and various other intellectual property rights and unfair competition laws.</p>
        </div>

        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--text);">3. User Representations</h2>
            <p style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem;">By using the Site, you represent and warrant that:</p>
            <ul style="color: var(--muted); line-height: 1.8; margin-bottom: 1rem; padding-left: 1.5rem; list-style-type: disc;">
                <li>All registration information you submit will be true, accurate, current, and complete.</li>
                <li>You will maintain the accuracy of such information and promptly update such registration information as necessary.</li>
                <li>You have the legal capacity and you agree to comply with these Terms of Service.</li>
                <li>You will not use the Site for any illegal or unauthorized purpose.</li>
            </ul>
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
