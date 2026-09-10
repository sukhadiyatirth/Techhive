<?php
// about.php
$pageTitle = 'About Us - TechHive Electronic';
require_once 'includes/header.php';
?>

<div class="page-header" style="padding-top: 120px; text-align: center; margin-bottom: 4rem;">
    <div class="container">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">About <span style="color: var(--accent);">TechHive</span></h1>
        <p class="text-muted" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto;">Technology. Refined.</p>
    </div>
</div>

<section class="about-section container" style="margin-bottom: 6rem;">
    <div class="about-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
        <div class="about-image" style="border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-glow);">
            <img src="assets/images/about-hero.jpg" alt="TechHive Office" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <div class="about-content">
            <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">Our Story</h2>
            <p style="color: var(--muted); margin-bottom: 1rem; font-size: 1.1rem; line-height: 1.8;">Founded with a passion for cutting-edge technology, TechHive Electronic is your premium destination for the latest gadgets and accessories. We believe that technology should not only be functional but also beautiful, blending seamlessly into your lifestyle.</p>
            <p style="color: var(--muted); margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.8;">Our curated collection features only the best products from industry-leading brands, meticulously selected to ensure exceptional quality, performance, and design.</p>
            
            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem;">
                <div class="stat-item">
                    <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 0.5rem;">10K+</h3>
                    <p style="color: var(--muted); font-size: 0.9rem;">Happy Customers</p>
                </div>
                <div class="stat-item">
                    <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 0.5rem;">50+</h3>
                    <p style="color: var(--muted); font-size: 0.9rem;">Premium Brands</p>
                </div>
                <div class="stat-item">
                    <h3 style="color: var(--accent); font-size: 2rem; margin-bottom: 0.5rem;">24/7</h3>
                    <p style="color: var(--muted); font-size: 0.9rem;">Support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="values-section" style="background: var(--surface); padding: 6rem 0;">
    <div class="container">
        <div class="text-center" style="text-align: center; margin-bottom: 4rem;">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Our Values</h2>
            <p style="color: var(--muted); max-width: 600px; margin: 0 auto;">What drives us to deliver excellence every day.</p>
        </div>
        
        <div class="values-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <!-- Value 1 -->
            <div class="value-card" style="background: var(--background); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid var(--border); transition: var(--transition);">
                <i data-lucide="shield-check" style="color: var(--accent); width: 40px; height: 40px; margin-bottom: 1.5rem;"></i>
                <h3 style="margin-bottom: 1rem;">Authenticity</h3>
                <p style="color: var(--muted); font-size: 0.95rem; line-height: 1.7;">We guarantee 100% genuine products sourced directly from authorized distributors. No compromises on quality.</p>
            </div>
            <!-- Value 2 -->
            <div class="value-card" style="background: var(--background); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid var(--border); transition: var(--transition);">
                <i data-lucide="zap" style="color: var(--accent); width: 40px; height: 40px; margin-bottom: 1.5rem;"></i>
                <h3 style="margin-bottom: 1rem;">Innovation</h3>
                <p style="color: var(--muted); font-size: 0.95rem; line-height: 1.7;">We are constantly on the lookout for the next big thing in tech, bringing you tomorrow's gadgets today.</p>
            </div>
            <!-- Value 3 -->
            <div class="value-card" style="background: var(--background); padding: 2.5rem; border-radius: var(--radius-md); border: 1px solid var(--border); transition: var(--transition);">
                <i data-lucide="heart" style="color: var(--accent); width: 40px; height: 40px; margin-bottom: 1.5rem;"></i>
                <h3 style="margin-bottom: 1rem;">Customer First</h3>
                <p style="color: var(--muted); font-size: 0.95rem; line-height: 1.7;">Your satisfaction is our priority. Our dedicated support team is always ready to assist you with any queries.</p>
            </div>
        </div>
    </div>
</section>

<!-- Mobile responsiveness styles for About page -->
<style>
    @media (max-width: 900px) {
        .about-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
        .values-grid {
            grid-template-columns: 1fr !important;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr !important;
        }
    }
    @media (max-width: 500px) {
        .stats-grid {
            grid-template-columns: 1fr !important;
        }
        .value-card:hover {
            border-color: var(--accent);
            transform: translateY(-5px);
            box-shadow: var(--shadow-glow);
        }
    }
</style>

<script>
    // Initialize icons if not already done
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
        
        // Add hover effect to value cards since we can't easily add pseudo-classes in inline styles
        const cards = document.querySelectorAll('.value-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.borderColor = 'var(--accent)';
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = 'var(--shadow-glow)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.borderColor = 'var(--border)';
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = 'none';
            });
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
