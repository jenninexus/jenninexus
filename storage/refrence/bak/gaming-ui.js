// html/resources/js/gaming-ui.js
(function () {
    'use strict';

    const CONFIG = {
        TOUCH_DEVICE: 'ontouchstart' in window || navigator.maxTouchPoints > 0,
        REDUCED_MOTION: window.matchMedia('(prefers-reduced-motion: reduce)').matches
    };

    function getTheme() {
        // Default to dark now that the toggle is disabled
        return document.documentElement.getAttribute('data-theme') || 'dark';
    }

    function getCssVariable(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name).trim() || null;
    }

    function resolvePrimaryColor(theme) {
        // Prefer canonical --primary-color, fall back to legacy --color-primary and hardcoded defaults
        return getCssVariable('--primary-color') || getCssVariable('--color-primary') || (theme === 'dark' ? '#42f4c8' : '#FF6B00');
    }

    function updateColorElements(theme) {
        const color = resolvePrimaryColor(theme);

        document.querySelectorAll('.neon-glow').forEach(el => {
            el.style.color = color;
            el.style.textShadow = `0 0 10px ${color}, 0 0 20px ${color}`;
        });

        document.querySelectorAll('.glow-bg').forEach(el => {
            el.style.background = `radial-gradient(circle at center, ${color}55, transparent 70%)`;
        });
    }

    let _gamingInit = false;
    function initializeGamingEffects() {
        if (_gamingInit) return; _gamingInit = true;
        document.querySelectorAll('.neon-glow').forEach(el => {
            el.style.transition = 'color 0.3s ease, text-shadow 0.3s ease';
        });

        initializeParticles();
        updateColorElements(getTheme());

        document.addEventListener('themeChange', (e) => {
            updateColorElements(e.detail?.theme || getTheme());
        });
        // ensure particles use CSS var for color
        function syncParticleColors() {
            const cssColor = getCssVariable('--primary-color') || getCssVariable('--color-primary') || '#FF6B00';
            document.querySelectorAll('.particle').forEach(p => { p.style.background = `var(--primary-color, ${cssColor})`; });
        }
        // run once and also when theme events fire
        syncParticleColors();
        document.addEventListener('themeChange', syncParticleColors);
    }

    function initializeParticles() {
        const body = document.body;
        const particleCount = CONFIG.TOUCH_DEVICE ? 10 : 30;

        for (let i = 0; i < particleCount; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.width = p.style.height = Math.random() * 4 + 2 + 'px';
            p.style.opacity = Math.random() * 0.3 + 0.1;
            p.style.animationDuration = Math.random() * 10 + 10 + 's';
            body.appendChild(p);
        }
    }

    /**
     * Cookie Banner Functionality
     * Shows policy acceptance banner on homepage for first-time visitors
     */
    function initializeCookieBanner() {
        const banner = document.querySelector('#policy-banner');
        const acceptButton = document.querySelector('#accept-policies');

        if (!banner || !acceptButton) {
            return; // Elements don't exist on this page
        }

        // Check if user has already accepted
        const hasAccepted = localStorage.getItem('mg_policies_accepted') === 'true' ||
            document.cookie.includes('cookies_accepted=true');

        // Only show on homepage
        const path = window.location.pathname.replace(/\/index\.php$/i, '/');
        const isHome = path === '/';

        if (!isHome || hasAccepted) {
            banner.style.display = 'none';
            return;
        }

        // Show banner with fade-in animation
        banner.style.display = 'block';
        banner.style.opacity = '0';
        banner.style.transform = 'translateY(20px)';
        banner.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';

        // Animate in after brief delay
        setTimeout(() => {
            banner.style.opacity = '1';
            banner.style.transform = 'translateY(0)';
        }, 100);

        // Handle accept button click
        acceptButton.addEventListener('click', function () {
            // Store acceptance
            localStorage.setItem('mg_policies_accepted', 'true');
            document.cookie = 'cookies_accepted=true; path=/; max-age=31536000; SameSite=Lax';

            // Animate out
            banner.style.transform = 'translateY(20px)';
            banner.style.opacity = '0';

            // Remove from DOM after animation
            setTimeout(() => {
                banner.style.display = 'none';
            }, 400);
        });
    }

    /**
     * Animated Counter Functionality
     * Animates numbers from 0 to their target value when they come into view
     */
    function initializeStatCounters() {
        const statNumbers = document.querySelectorAll('.stat-number');
        if (!statNumbers.length) return;

        // Parse number from text (handles 25, 8+, 12M+, 4,600+, etc.)
        function parseStatValue(text) {
            const clean = text.replace(/,/g, '').trim();
            const hasSuffix = clean.match(/[KMB+]/i);
            const suffix = hasSuffix ? hasSuffix[0] : '';
            const value = parseFloat(clean);
            return { value, suffix, original: text };
        }

        // Format number back with suffix and commas
        function formatStatValue(current, target, suffix) {
            let formatted = Math.floor(current);
            
            // Add commas for thousands
            if (formatted >= 1000) {
                formatted = formatted.toLocaleString('en-US');
            }
            
            return formatted + suffix;
        }

        // Animate a single stat number
        function animateStat(element, targetValue, suffix, duration = 2000) {
            const start = 0;
            const range = targetValue - start;
            const startTime = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (ease-out quad)
                const easeProgress = 1 - Math.pow(1 - progress, 3);
                const current = start + (range * easeProgress);
                
                element.textContent = formatStatValue(current, targetValue, suffix);
                
                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    // Ensure final value matches exactly
                    element.textContent = formatStatValue(targetValue, targetValue, suffix);
                }
            }
            
            requestAnimationFrame(update);
        }

        // Set up Intersection Observer to trigger animations when visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.animated) {
                    entry.target.dataset.animated = 'true';
                    
                    // Check for data-target attribute first (for dynamic values), then fall back to textContent
                    const targetText = entry.target.dataset.target || entry.target.textContent;
                    const parsed = parseStatValue(targetText);
                    animateStat(entry.target, parsed.value, parsed.suffix);
                }
            });
        }, {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        });

        statNumbers.forEach(stat => observer.observe(stat));
    }

    // Ensure this module initializes once when DOM is ready
    // Back to Top Button Handler
    function initializeBackToTop() {
        const backToTopBtn = document.getElementById('back-to-top');
        if (!backToTopBtn) return;

        // Show/hide button based on scroll position
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        // Smooth scroll to top on click
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Smooth Scroll Anchors
     * Enables smooth scrolling for all anchor links on the page
     */
    function initializeSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#!') return; // Skip placeholder links
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }
            });
        });
    }

    /**
     * Game Card 3D Tilt Effect
     * Adds subtle 3D tilt to game cards on mouse movement
     */
    function initializeCardTilt() {
        // Skip on touch devices or if reduced motion is preferred
        if (CONFIG.TOUCH_DEVICE || CONFIG.REDUCED_MOTION) return;
        
        const cards = document.querySelectorAll('.game-card');
        if (!cards.length) return;

        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'transform 0.1s ease-out';
            });

            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // Calculate rotation (max ±8 degrees)
                const rotateX = ((y - centerY) / centerY) * -8;
                const rotateY = ((x - centerX) / centerX) * 8;
                
                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
            });

            card.addEventListener('mouseleave', function() {
                this.style.transition = 'transform 0.3s ease';
                this.style.transform = '';
            });
        });
    }

    /**
     * Scroll Progress Bar
     * Visual progress indicator at top of page
     */
    function initializeScrollProgress() {
        // Only show on long pages (more than 2 viewports of content)
        const contentHeight = document.documentElement.scrollHeight;
        const viewportHeight = window.innerHeight;
        if (contentHeight < viewportHeight * 2) return;

        const progress = document.createElement('div');
        progress.id = 'scroll-progress';
        progress.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            z-index: 10000;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            transition: width 0.1s ease;
            pointer-events: none;
        `;
        document.body.appendChild(progress);

        function updateProgress() {
            const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progress.style.width = Math.min(scrolled, 100) + '%';
        }

        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress(); // Initial state
    }

    /**
     * Copy to Clipboard with Toast Notification
     * Utility for copying text and showing user feedback
     */
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `mg-toast toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            bottom: 80px;
            right: 20px;
            z-index: 9999;
            background: var(--color-${type === 'success' ? 'primary' : 'secondary'});
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            font-weight: 600;
        `;
        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);

        // Animate out and remove
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function initializeCopyButtons() {
        document.querySelectorAll('[data-copy]').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                const text = this.dataset.copy || this.textContent.trim();
                
                try {
                    await navigator.clipboard.writeText(text);
                    showToast('Copied to clipboard!', 'success');
                } catch (err) {
                    // Fallback for older browsers
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        document.execCommand('copy');
                        showToast('Copied to clipboard!', 'success');
                    } catch (fallbackErr) {
                        showToast('Failed to copy', 'error');
                    }
                    document.body.removeChild(textarea);
                }
            });
        });
    }

    /**
     * Parallax Scroll Effect
     * Subtle parallax movement for hero sections
     */
    function initializeParallax() {
        // Skip on touch devices or if reduced motion is preferred
        if (CONFIG.TOUCH_DEVICE || CONFIG.REDUCED_MOTION) return;
        
        const heroes = document.querySelectorAll('.page-title-hero, .display-1');
        if (!heroes.length) return;

        function updateParallax() {
            const scrolled = window.pageYOffset;
            heroes.forEach(hero => {
                // Only apply parallax if element is in viewport
                const rect = hero.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    hero.style.transform = `translateY(${scrolled * 0.15}px)`;
                }
            });
        }

        window.addEventListener('scroll', updateParallax, { passive: true });
        updateParallax(); // Initial state
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initializeGamingEffects();
            initializeCookieBanner();
            initializeBackToTop();
            initializeStatCounters();
            initializeSmoothScroll();
            initializeCardTilt();
            initializeScrollProgress();
            initializeCopyButtons();
            initializeParallax();
        });
    } else {
        initializeGamingEffects();
        initializeCookieBanner();
        initializeBackToTop();
        initializeStatCounters();
        initializeSmoothScroll();
        initializeCardTilt();
        initializeScrollProgress();
        initializeCopyButtons();
        initializeParallax();
    }

    // Expose toast function for external use
    window.mgShowToast = showToast;

}());
