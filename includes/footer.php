    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- Brand Column -->
                <div class="footer-col brand-col">
                    <a href="index.php" class="logo">TechHive<span>.</span></a>
                    <p class="tagline">Technology. Refined.</p>
                    <div class="social-icons">
                        <a href="#" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg></a>
                        <a href="#" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                        <a href="#" aria-label="YouTube"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 7.1C2.6 6.3 3.2 5.7 4 5.5C5.8 5 12 5 12 5s6.2 0 8 .5c.8.2 1.4.8 1.5 1.6.5 1.9.5 4.9.5 4.9s0 3-.5 4.9c-.1.8-.7 1.4-1.5 1.6-1.8.5-8 .5-8 .5s-6.2 0-8-.5c-.8-.2-1.4-.8-1.5-1.6-.5-1.9-.5-4.9-.5-4.9s0-3 .5-4.9z"/><path d="M9.75 15.02l5.75-3.27-5.75-3.27v6.54z"/></svg></a>
                        <a href="#" aria-label="X"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l16 16"/><path d="M4 20L20 4"/></svg></a>
                    </div>
                </div>

                <!-- Shop Column -->
                <div class="footer-col">
                    <h3>Shop</h3>
                    <ul>
                        <li><a href="shop.php?category=laptops">Laptops</a></li>
                        <li><a href="shop.php?category=earbuds">Earbuds</a></li>
                        <li><a href="shop.php?category=speakers">Speakers</a></li>
                        <li><a href="shop.php?category=accessories">Accessories</a></li>
                        <li><a href="shop.php?category=smart-watches">Smart Watches</a></li>
                    </ul>
                </div>

                <!-- Customer Column -->
                <div class="footer-col">
                    <h3>Customer</h3>
                    <ul>
                        <li><a href="profile.php">My Account</a></li>
                        <li><a href="orders.php">Orders</a></li>
                        <li><a href="wishlist.php">Wishlist</a></li>
                        <li><a href="shipping.php">Shipping</a></li>
                        <li><a href="returns.php">Returns</a></li>
                    </ul>
                </div>

                <!-- Company Column -->
                <div class="footer-col">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                        <li><a href="terms.php">Terms</a></li>
                    </ul>
                </div>

                <!-- Newsletter Column -->
                <div class="footer-col newsletter-col">
                    <h3>Newsletter</h3>
                    <p>Stay ahead of the tech.</p>
                    <form id="newsletter-form" class="newsletter-form">
                        <input type="email" name="email" id="newsletter-email" placeholder="Enter your email" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                    <div id="newsletter-message" style="margin-top: 10px; font-size: 0.9rem; display: none;"></div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> TechHive Electronic. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script src="assets/js/main.js"></script>
    <script>
      lucide.createIcons();
    </script>
    
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <?php if (basename($_SERVER['PHP_SELF']) == 'cart.php'): ?>
    <script src="assets/js/cart.js"></script>
    <?php endif; ?>
    <?php if (basename($_SERVER['PHP_SELF']) == 'checkout.php'): ?>
    <script src="assets/js/checkout.js"></script>
    <?php endif; ?>
</body>
</html>
