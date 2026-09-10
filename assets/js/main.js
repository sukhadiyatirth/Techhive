document.addEventListener("DOMContentLoaded", () => {
    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.15
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    animatedElements.forEach(el => observer.observe(el));
    
    // Search Overlay Toggle
    const searchToggleBtn = document.querySelector('.search-toggle');
    const closeSearchBtn = document.querySelector('.close-search');
    const searchOverlay = document.querySelector('.search-overlay');
    const searchInput = searchOverlay ? searchOverlay.querySelector('input[name="q"]') : null;

    if (searchToggleBtn && searchOverlay) {
        searchToggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            searchOverlay.classList.add('active');
            if (searchInput) setTimeout(() => searchInput.focus(), 300);
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchOverlay.querySelector('.search-form').submit();
            }
        });
    }

    if (closeSearchBtn && searchOverlay) {
        closeSearchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            searchOverlay.classList.remove('active');
        });
    }

    // Newsletter Subscription AJAX
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterMessage = document.getElementById('newsletter-message');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('newsletter-email').value;
            const btn = newsletterForm.querySelector('button');
            const originalBtnText = btn.innerHTML;
            
            btn.innerHTML = '<i data-lucide="loader-2" class="spin"></i>';
            if(window.lucide) window.lucide.createIcons();
            btn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('email', email);
                
                const response = await fetch('subscribe.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                newsletterMessage.style.display = 'block';
                newsletterMessage.textContent = data.message;
                
                if (data.success) {
                    newsletterMessage.style.color = 'var(--success)';
                    newsletterForm.reset();
                } else {
                    newsletterMessage.style.color = '#ff4444';
                }
            } catch (err) {
                newsletterMessage.style.display = 'block';
                newsletterMessage.style.color = '#ff4444';
                newsletterMessage.textContent = 'An error occurred. Please try again later.';
            } finally {
                btn.innerHTML = originalBtnText;
                btn.disabled = false;
            }
        });
    }
});
