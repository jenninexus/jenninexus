<!-- ====================================================================
     SVG ICONS & GRAPHICS SHOWCASE
     Custom SVG assets with theme-aware fill colors
     ==================================================================== -->
<section id="svg-showcase" class="theme-section bg-pastel">
    <h2 class="display-5 mb-4">🎨 Custom SVG Graphics</h2>
    
    <!-- Game Logos -->
    <h3 class="h4 mb-3">Game Logos</h3>
    <div class="row g-3 mb-4">
        <div class="col-md-3 text-center">
            <div class="p-3 border rounded">
                <img src="<?= RES_ROOT ?>/images/gamedev/logos/martiangames-logo.svg" alt="Martian Games" style="max-width: 100px; height: auto;">
                <p class="mt-2 mb-0 small">Martian Games</p>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="p-3 border rounded">
                <img src="<?= RES_ROOT ?>/images/gamedev/logos/purgatoryfell-logo.svg" alt="Purgatory Fell" style="max-width: 100px; height: auto;">
                <p class="mt-2 mb-0 small">Purgatory Fell</p>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="p-3 border rounded">
                <img src="<?= RES_ROOT ?>/images/gamedev/logos/botborgs-logo.svg" alt="Bot Borgs" style="max-width: 100px; height: auto;">
                <p class="mt-2 mb-0 small">Bot Borgs</p>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="p-3 border rounded">
                <img src="<?= RES_ROOT ?>/images/gamedev/logos/tankoff-logo.svg" alt="Tank Off" style="max-width: 100px; height: auto;">
                <p class="mt-2 mb-0 small">Tank Off</p>
            </div>
        </div>
    </div>
    
    <!-- Brand SVGs -->
    <h3 class="h4 mb-3 mt-5">Brand Elements</h3>
    <div class="row g-3 mb-4">
        <div class="col-md-4 text-center">
            <div class="p-4 border rounded">
                <svg width="80" height="80" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="40" fill="var(--primary)" opacity="0.2"/>
                    <circle cx="50" cy="50" r="30" fill="var(--primary)" opacity="0.5"/>
                    <circle cx="50" cy="50" r="20" fill="var(--primary)"/>
                    <text x="50" y="60" text-anchor="middle" fill="white" font-size="30" font-weight="bold">J</text>
                </svg>
                <p class="mt-2 mb-0 small">Primary Color Circle</p>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-4 border rounded">
                <svg width="80" height="80" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="10" width="80" height="80" rx="10" fill="var(--secondary)" opacity="0.3"/>
                    <rect x="20" y="20" width="60" height="60" rx="8" fill="var(--secondary)" opacity="0.6"/>
                    <rect x="30" y="30" width="40" height="40" rx="5" fill="var(--secondary)"/>
                    <text x="50" y="60" text-anchor="middle" fill="white" font-size="30" font-weight="bold">N</text>
                </svg>
                <p class="mt-2 mb-0 small">Secondary Color Square</p>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-4 border rounded">
                <svg width="80" height="80" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="50,10 90,90 10,90" fill="var(--accent)" opacity="0.3"/>
                    <polygon points="50,25 75,80 25,80" fill="var(--accent)" opacity="0.6"/>
                    <polygon points="50,40 60,70 40,70" fill="var(--accent)"/>
                    <text x="50" y="65" text-anchor="middle" fill="white" font-size="20" font-weight="bold">△</text>
                </svg>
                <p class="mt-2 mb-0 small">Accent Color Triangle</p>
            </div>
        </div>
    </div>
    
    <!-- Icon Set -->
    <h3 class="h4 mb-3 mt-5">Custom Icon Set</h3>
    <div class="row g-3 mb-4">
        <div class="col-md-2 text-center">
            <svg width="60" height="60" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="none" stroke="var(--primary)" stroke-width="5"/>
                <path d="M 30 50 L 45 65 L 70 35" fill="none" stroke="var(--primary)" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p class="mt-2 mb-0 small">Check</p>
        </div>
        <div class="col-md-2 text-center">
            <svg width="60" height="60" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="none" stroke="var(--secondary)" stroke-width="5"/>
                <path d="M 30 30 L 70 70 M 70 30 L 30 70" fill="none" stroke="var(--secondary)" stroke-width="8" stroke-linecap="round"/>
            </svg>
            <p class="mt-2 mb-0 small">Close</p>
        </div>
        <div class="col-md-2 text-center">
            <svg width="60" height="60" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" fill="none" stroke="var(--accent)" stroke-width="5"/>
                <circle cx="50" cy="35" r="5" fill="var(--accent)"/>
                <rect x="45" y="45" width="10" height="30" rx="3" fill="var(--accent)"/>
            </svg>
            <p class="mt-2 mb-0 small">Info</p>
        </div>
        <div class="col-md-2 text-center">
            <svg width="60" height="60" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <polygon points="50,15 90,85 10,85" fill="none" stroke="var(--primary)" stroke-width="5"/>
                <circle cx="50" cy="40" r="5" fill="var(--primary)"/>
                <rect x="45" y="50" width="10" height="20" rx="3" fill="var(--primary)"/>
            </svg>
            <p class="mt-2 mb-0 small">Warning</p>
        </div>
        <div class="col-md-2 text-center">
            <svg width="60" height="60" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M 50 20 L 60 40 L 85 45 L 65 63 L 70 88 L 50 75 L 30 88 L 35 63 L 15 45 L 40 40 Z" fill="var(--secondary)"/>
            </svg>
            <p class="mt-2 mb-0 small">Star</p>
        </div>
        <div class="col-md-2 text-center">
            <svg width="60" height="60" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M 20 50 Q 20 20 50 20 Q 80 20 80 50 Q 80 70 50 85 Q 20 70 20 50 Z" fill="var(--accent)"/>
            </svg>
            <p class="mt-2 mb-0 small">Heart</p>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <h3 class="h4 mb-3 mt-5">Decorative Patterns</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <svg width="100%" height="150" viewBox="0 0 400 150" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:var(--primary);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:var(--secondary);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M 0 75 Q 50 25, 100 75 T 200 75 T 300 75 T 400 75" fill="none" stroke="url(#grad1)" stroke-width="8"/>
                <circle cx="100" cy="75" r="8" fill="var(--primary)"/>
                <circle cx="200" cy="75" r="8" fill="var(--secondary)"/>
                <circle cx="300" cy="75" r="8" fill="var(--accent)"/>
            </svg>
            <p class="text-center small">Gradient Wave</p>
        </div>
        <div class="col-md-6">
            <svg width="100%" height="150" viewBox="0 0 400 150" xmlns="http://www.w3.org/2000/svg">
                <rect x="50" y="25" width="80" height="80" fill="var(--primary)" opacity="0.6" transform="rotate(15 90 65)"/>
                <rect x="160" y="25" width="80" height="80" fill="var(--secondary)" opacity="0.6" transform="rotate(-10 200 65)"/>
                <rect x="270" y="25" width="80" height="80" fill="var(--accent)" opacity="0.6" transform="rotate(20 310 65)"/>
            </svg>
            <p class="text-center small">Rotated Squares</p>
        </div>
    </div>
</section>
