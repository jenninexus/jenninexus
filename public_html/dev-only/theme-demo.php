<?php
/**
 * Theme Demo Page - Development & Testing Only
 * 
 * Purpose: Preview all JenniNexus page themes, Bootstrap 5.3.8 components, 
 *          and FontAwesome icon integrations before deploying to production.
 * 
 * IMPORTANT: This page is for LOCAL DEVELOPMENT ONLY
 * Excluded from production deployment by deploy.ps1 (line ~110)
 * 
 * See also: buttons.php - Comprehensive button pattern showcase
 * 
 * Last Updated: November 24, 2025
 * Bootstrap Version: 5.3.8
 * FontAwesome Version: 6.7.2
 * 
 * Note: Page width is consistent across light/dark modes via Bootstrap .container class
 */

// Define resource root for asset loading
define('RES_ROOT', '/resources');

// Check if running locally (basic security check)
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;

if (!$isLocal && !isset($_GET['force'])) {
    http_response_code(404);
    die('Page not found');
}

$pageTitle = "Theme Demo - JenniNexus Development";
$pageDescription = "Preview all page themes, Bootstrap components, and FontAwesome icons";
$activePage = 'theme-demo'; // For header navigation highlighting

// Additional theme CSS files for demo purposes
$customCSS = [
    RES_ROOT . '/css/home-theme.css',
    RES_ROOT . '/css/patreon-theme.css',
    RES_ROOT . '/css/gamedev-theme.css',
    RES_ROOT . '/css/gaming-theme.css',
    RES_ROOT . '/css/live-theme.css',
    RES_ROOT . '/css/diy-theme.css',
    RES_ROOT . '/css/tags-theme.css',
    RES_ROOT . '/css/pastel-backgrounds.css'
];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/../includes/head.php'; ?>
    <style>
        /* Demo-specific styling */
        .theme-section {
            margin-bottom: 4rem;
            padding: 3rem 0;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Light/Dark Mode Text Handling */
        :root[data-bs-theme="light"] .theme-section {
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            min-height: 200px;
            /* Default: Use Bootstrap's theme-aware text colors */
            color: var(--bs-body-color);
        }
        
        /* Force white text only on colored backgrounds */
        .theme-preview.text-white,
        .theme-preview.steam-gradient,
        .theme-preview.gaming-hero,
        .theme-preview.live-hero,
        .theme-preview.diy-hero {
            color: white !important;
        }
        
        /* Tags hero should adapt to theme */
        .theme-preview.tags-hero {
            color: var(--bs-body-color);
        }
        
        :root[data-bs-theme="light"] .theme-preview.tags-hero {
            color: #212529; /* Dark text in light mode */
        }
        
        :root[data-bs-theme="dark"] .theme-preview.tags-hero {
            color: #f0f6fc; /* Light text in dark mode */
        }
        
        .code-preview {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 1.5rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }
        
        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .icon-demo {
            text-align: center;
            padding: 1rem;
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
        }
        
        :root[data-bs-theme="light"] .icon-demo {
            background: rgba(0, 0, 0, 0.05);
        }
        
        .icon-demo i, .icon-demo svg {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .component-demo {
            background: var(--glass-panel-bg);
            -webkit-backdrop-filter: blur(var(--glass-panel-blur));
            backdrop-filter: blur(var(--glass-panel-blur));
            border: 1px solid var(--glass-panel-border);
            padding: 2rem;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        
        :root[data-bs-theme="light"] .component-demo {
            background: var(--glass-panel-bg);
        }
        
        .icon-demo {
            background: var(--glass-panel-bg);
            -webkit-backdrop-filter: blur(var(--glass-panel-blur));
            backdrop-filter: blur(var(--glass-panel-blur));
            border: 1px solid var(--glass-panel-border);
        }
        
        /* CRITICAL: Fix button icon vertical centering */
        /* Note: We now use display: inline-flex on .btn in custom.css */
        /* This ensures perfect centering without vertical-align hacks */
        .btn {
            /* line-height: 1.5; - handled by Bootstrap */
        }
        
        .btn svg,
        .btn i {
            /* vertical-align: middle; - not needed with flexbox */
            /* line-height: 1; - not needed with flexbox */
        }
    </style>
</head>
<body class="theme-demo-page">
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section py-5 mb-5" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary));">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <div class="glass-panel p-5 rounded-4 shadow-lg">
                        <h1 class="display-2 mb-4">Theme Demo</h1>
                        <p class="lead mb-4">Comprehensive showcase of JenniNexus design system, components, and themes.</p>
                        
                        <!-- Logo Component Showcase -->
                        <div class="mt-5 p-4 glass-panel rounded-3">
                            <h3 class="h5 mb-4 opacity-75">Logo Component Showcase</h3>
                            <div class="d-flex flex-wrap justify-content-center gap-5 align-items-center">
                                <div class="text-center">
                                    <p class="small opacity-50 mb-2">Default</p>
                                    <?php include __DIR__ . '/../includes/logo.php'; ?>
                                </div>
                                <div class="text-center">
                                    <p class="small opacity-50 mb-2">DIY Variant</p>
                                    <?php $logoVariant = 'diy'; include __DIR__ . '/../includes/logo.php'; ?>
                                </div>
                                <div class="text-center">
                                    <p class="small opacity-50 mb-2">Large (fs-1)</p>
                                    <?php $logoSize = 'fs-1'; $logoVariant = 'default'; include __DIR__ . '/../includes/logo.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theme Demo Content Container (adds padding below fixed navbar) -->
    <main class="container mb-5 pb-5">
        <!-- Development Notice -->
        <div class="alert alert-warning mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <strong>Development Only</strong> - This page is excluded from production deployment
        </div>
        
        <!-- Button Showcase Reference -->
        <div class="alert alert-info mb-4" role="alert">
            <i class="fa-solid fa-circle-info me-2"></i>
            <strong>Looking for button patterns?</strong> See <a href="buttons.php" class="alert-link fw-bold">buttons.php</a> for the official comprehensive button showcase with usage examples, sizes, colors, and responsive patterns.
        </div>
        
        <!-- Section Index -->
        <nav class="mb-5">
            <h3 class="h5 mb-3">Section Index</h3>
            <ul class="list-unstyled ms-3">
                <li><a href="#svg-system">🎨 SVG Icon System</a> <span class="badge bg-primary">New</span></li>
                <li><a href="#theme-system">🎨 Theme System & Color Palettes</a> <span class="badge bg-primary">New</span></li>
                <li><a href="#design-protocol">🎨 Design Protocol & Preferences</a></li>
                <li><a href="#glass-components">🔮 Glass Component System</a> <span class="badge bg-primary">New</span></li>
                <li><a href="#interactive-features">⚡ Interactive UI Features</a> <span class="badge bg-primary">New</span></li>
                <li><a href="#svg-animations">🎭 SVG Animation System</a> <span class="badge bg-success">New</span></li>
                <li><a href="#social-cards">📱 Enhanced Social Cards</a> <span class="badge bg-success">New</span></li>
                <li><a href="#button-showcase">🔘 Button Showcase Reference</a> <span class="badge bg-info">See buttons.php</span></li>
                <li><a href="#implementation-guide">📘 Implementation Guide</a> <span class="badge bg-success">New</span></li>
                <li><a href="#color-palette">🎨 Light/Dark Mode Color Palettes</a></li>
                <li><a href="#color-swatches">🎨 Color Swatch Palettes</a> <span class="badge bg-success">New</span></li>
                <li><a href="#typography-styles">✒️ Typography & Logo Text Styles</a> <span class="badge bg-success">New</span></li>
                <li><a href="#bootstrap-components">🧩 Bootstrap 5.3.8 Components</a></li>
                <li><a href="#fontawesome-icons">🎭 FontAwesome 6.7.2 Icons</a></li>
                <li><a href="#button-system">🔘 Button & Icon Sizing System</a></li>
                <li><a href="#button-responsive">🔘 Button Responsiveness & Architecture</a></li>
                <li><a href="#social-buttons">📱 Social Media Buttons</a></li>
                <li><a href="#theme-home">🏠 Home Page Theme</a> <span class="badge bg-success">New</span></li>
                <li><a href="#hover-protocol">🖱️ Sitewide Hover Protocol</a> <span class="badge bg-success">New</span></li>
                <li><a href="#grid-best-practices">📊 Bootstrap Grid Best Practices</a></li>
                <li><a href="#video-grid-showcase">🎬 Video Grid System Showcase</a> <span class="badge bg-success">New</span></li>
                <li><a href="#carousel-showcase">🎠 Carousel Showcase</a> <span class="badge bg-success">New</span></li>
                <li><a href="#content-protocols">📐 Content Display Protocols</a></li>
                <li><a href="#video-display-demo">🎬 Video Display Demo</a> <span class="badge bg-warning">New - Dev Only</span></li>
                <li><a href="#video-grid-showcase">🎬 Video Grid System Showcase</a> <span class="badge bg-success">New</span></li>
                <li><a href="#youtube-testing">🎞️ YouTube Thumbnail & Aspect Ratio Testing</a></li>
                <li><a href="#documentation-reference">📚 Documentation Reference</a></li>
                <li><a href="#theme-patreon">💖 Patreon Theme</a></li>
                <li><a href="#theme-gamedev">🎮 Game Dev Theme</a></li>
                <li><a href="#theme-gaming">🕹️ Gaming Theme</a></li>
                <li><a href="#theme-live">📺 Live Streaming Theme</a></li>
                <li><a href="#theme-diy">💅 DIY Theme</a></li>
                <li><a href="#theme-tags">🏷️ Tags Theme</a></li>
                <li><a href="#responsive-grid">📱 Responsive Grid Demonstration</a></li>
            </ul>
        </nav>

        <!-- ====================================================================
             NEW SECTIONS: SVG System & Theme System (January 2, 2026)
             ==================================================================== -->
        <?php include __DIR__ . '/svgs.php'; ?>
        <?php include __DIR__ . '/themes.php'; ?>
        
        <!-- ====================================================================
             EXTRACTED PARTIALS: Using CSS Variables (January 2, 2026)
             These partials dynamically update when all-themes.css changes
             ==================================================================== -->
        <?php include __DIR__ . '/bootstrap-components.php'; ?>
        <?php include __DIR__ . '/fontawesome-icons.php'; ?>
        <?php include __DIR__ . '/svg-showcase.php'; ?>
        <?php include __DIR__ . '/typography-samples.php'; ?>
        <?php include __DIR__ . '/theme-variations.php'; ?>

        <!-- ====================================================================
             SECTION -1: Design Protocol & Preferences (December 30, 2025)
             ==================================================================== -->
        <section id="design-protocol" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🎨 Design Protocol & Preferences</h2>
            <p class="lead">Core principles and standards for JenniNexus design system</p>
            
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100">
                        <h4 class="mb-3"><i class="fa-solid fa-palette me-2"></i>Visual Hierarchy</h4>
                        <ul class="mb-0">
                            <li><strong>Glassmorphism First:</strong> Use glass panels for all major content blocks</li>
                            <li><strong>Consistent Hover States:</strong> 3D tilt + lift + glow on interactive elements</li>
                            <li><strong>SVG Animations:</strong> Subtle animations respect <code>prefers-reduced-motion</code></li>
                            <li><strong>FontAwesome 6.7.2:</strong> Standardized icon system sitewide</li>
                            <li><strong>Bootstrap 5.3.8:</strong> Never override grid/spacing, extend with custom classes</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100">
                        <h4 class="mb-3"><i class="fa-solid fa-code me-2"></i>Code Standards</h4>
                        <ul class="mb-0">
                            <li><strong>Single Source of Truth:</strong> Colors in CSS variables, not hex codes</li>
                            <li><strong>Theme-Adaptive:</strong> All components work in light/dark mode</li>
                            <li><strong>Isolated Architecture:</strong> 100% self-contained, no external dependencies</li>
                            <li><strong>Asset Management:</strong> Use <code>RES_ROOT</code> (PHP) / <code>window.RES_ROOT</code> (JS)</li>
                            <li><strong>Build Pipeline:</strong> Source in <code>src/assets</code>, built to <code>public_html/resources</code></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100">
                        <h4 class="mb-3"><i class="fa-solid fa-hand-pointer me-2"></i>Interaction Patterns</h4>
                        <ul class="mb-0">
                            <li><strong>Copy-to-Clipboard:</strong> Use <code>data-copy</code> attribute with toast feedback</li>
                            <li><strong>Stat Counters:</strong> Animated numbers with <code>data-target</code> attribute</li>
                            <li><strong>3D Tilt:</strong> Desktop-only, disabled on touch devices</li>
                            <li><strong>Parallax:</strong> Subtle 0.15x movement on hero sections</li>
                            <li><strong>Hover Lift:</strong> Three variants (-sm, default, -lg) for different intensities</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="glass-card p-4 h-100">
                        <h4 class="mb-3"><i class="fa-solid fa-mobile-screen me-2"></i>Responsive Philosophy</h4>
                        <ul class="mb-0">
                            <li><strong>Mobile First:</strong> Design for smallest screens, enhance for larger</li>
                            <li><strong>Touch Friendly:</strong> Auto-disable hover effects on touch devices</li>
                            <li><strong>Accessibility:</strong> WCAG AA contrast, keyboard navigation, focus states</li>
                            <li><strong>Performance:</strong> Minified assets, optimized images, lazy loading</li>
                            <li><strong>Progressive Enhancement:</strong> Core functionality works without JS</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-success">
                <h5 class="alert-heading"><i class="fa-solid fa-lightbulb me-2"></i>Key Design Decisions</h5>
                <ul class="mb-0">
                    <li><strong>Bootstrap Grid:</strong> Never modify core Bootstrap classes, extend with custom utilities</li>
                    <li><strong>Glass Panels:</strong> Systematic component library (<code>.glass-card</code>, <code>.glass-badge</code>, etc.)</li>
                    <li><strong>Platform Colors:</strong> Social media button colors defined in <code>all-themes.css</code></li>
                    <li><strong>Theme Files:</strong> Page-specific styles in <code>*-theme.css</code> (patreon, gamedev, gaming, etc.)</li>
                    <li><strong>UI Effects:</strong> Centralized in <code>ui-effects.js</code> for consistency</li>
                </ul>
            </div>
        </section>

        <!-- ====================================================================
             SECTION -0.5: Glass Component System (December 30, 2025)
             ==================================================================== -->
        <section id="glass-components" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🔮 Glass Component System</h2>
            <p class="lead">Systematic glassmorphism utilities for cohesive design</p>
            
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="glass-card p-4 text-center hover-lift">
                        <i class="fa-solid fa-gem svg-2xl text-primary mb-3 svg-pulse"></i>
                        <h5>.glass-card</h5>
                        <p class="text-muted small mb-3">Standard content blocks with hover effects</p>
                        <button class="btn btn-sm btn-outline-primary" data-copy="glass-card">
                            <i class="fa-solid fa-copy me-1"></i>Copy Class
                        </button>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-4 text-center hover-lift">
                        <h5 class="mb-3">.glass-badge</h5>
                        <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
                            <span class="glass-badge">Featured</span>
                            <span class="glass-badge">New</span>
                            <span class="glass-badge">Popular</span>
                        </div>
                        <p class="text-muted small mb-0">Theme-adaptive pills</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="glass-shimmer glass-medium p-4 rounded-3 text-center hover-lift">
                        <i class="fa-solid fa-sparkles svg-2xl text-warning mb-3 svg-beat"></i>
                        <h5>.glass-shimmer</h5>
                        <p class="text-muted small mb-0">Animated shimmer effect</p>
                    </div>
                </div>
            </div>
            
            <div class="code-preview mb-4">
&lt;!-- Glass Card Usage --&gt;
&lt;div class="glass-card p-4 hover-lift"&gt;
  &lt;h5&gt;Card Title&lt;/h5&gt;
  &lt;p&gt;Card content with glassmorphism effect&lt;/p&gt;
&lt;/div&gt;

&lt;!-- Glass Badge Usage --&gt;
&lt;span class="glass-badge"&gt;Featured&lt;/span&gt;

&lt;!-- Glass Shimmer Effect --&gt;
&lt;div class="glass-shimmer glass-medium p-4"&gt;
  Content with shimmer overlay
&lt;/div&gt;</div>
            
            <h4 class="mb-3">Available Glass Components</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Purpose</th>
                            <th>Blur</th>
                            <th>Use Case</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>.glass-card</code></td>
                            <td>Standard content blocks</td>
                            <td>12px</td>
                            <td>Project cards, feature sections</td>
                        </tr>
                        <tr>
                            <td><code>.glass-navbar</code></td>
                            <td>Navigation bars</td>
                            <td>12px</td>
                            <td>Sticky headers, sidebars</td>
                        </tr>
                        <tr>
                            <td><code>.glass-modal</code></td>
                            <td>Modal dialogs</td>
                            <td>16px</td>
                            <td>Popups, overlays</td>
                        </tr>
                        <tr>
                            <td><code>.glass-badge</code></td>
                            <td>Tags and pills</td>
                            <td>8px</td>
                            <td>Category tags, status badges</td>
                        </tr>
                        <tr>
                            <td><code>.glass-tooltip</code></td>
                            <td>Enhanced tooltips</td>
                            <td>10px</td>
                            <td>Hover information</td>
                        </tr>
                        <tr>
                            <td><code>.glass-sidebar</code></td>
                            <td>Side navigation</td>
                            <td>14px</td>
                            <td>Navigation panels</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ====================================================================
             SECTION -0.4: Interactive UI Features (December 30, 2025)
             ==================================================================== -->
        <section id="interactive-features" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">⚡ Interactive UI Features</h2>
            <p class="lead">Enhanced interactions powered by ui-effects.js</p>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="glass-card p-4 interactive-card text-theme-safe" tabindex="0">
                        <h5 class="mb-3 text-theme-safe"><i class="fa-solid fa-copy me-2"></i>Copy to Clipboard</h5>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary" data-copy="jenninexus@gmail.com">
                                <i class="fa-solid fa-envelope me-2"></i>Copy Email
                            </button>
                            <button class="btn btn-outline-secondary" data-copy="https://github.com/jenninexus">
                                <i class="fa-brands fa-github me-2"></i>Copy GitHub URL
                            </button>
                        </div>
                        <div class="code-preview mt-3 mb-0">
&lt;button data-copy="text-to-copy"&gt;
  Copy Me
&lt;/button&gt;</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="glass-card p-4 interactive-card text-theme-safe" tabindex="0">
                        <h5 class="mb-3 text-theme-safe"><i class="fa-solid fa-chart-line me-2"></i>Animated Counters</h5>
                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <h3 class="text-primary"><span class="stat-number" data-target="150">0</span>+</h3>
                                <small class="text-theme-safe-muted">Videos</small>
                            </div>
                            <div class="col-4">
                                <h3 class="text-success"><span class="stat-number" data-target="5000">0</span>+</h3>
                                <small class="text-theme-safe-muted">Followers</small>
                            </div>
                            <div class="col-4">
                                <h3 class="text-warning"><span class="stat-number" data-target="25">0</span>+</h3>
                                <small class="text-theme-safe-muted">Projects</small>
                            </div>
                        </div>
                        <div class="code-preview mb-0">
&lt;span class="stat-number" data-target="5000"&gt;0&lt;/span&gt;</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="glass-card p-4 text-center hover-lift-sm text-theme-safe">
                        <i class="fa-solid fa-feather svg-2xl text-info mb-3"></i>
                        <h6 class="text-theme-safe">.hover-lift-sm</h6>
                        <small class="text-theme-safe-muted">Subtle lift effect</small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="glass-card p-4 text-center hover-lift text-theme-safe">
                        <i class="fa-solid fa-rocket svg-2xl text-primary mb-3"></i>
                        <h6 class="text-theme-safe">.hover-lift</h6>
                        <small class="text-theme-safe-muted">Standard lift</small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="glass-card p-4 text-center hover-lift-lg text-theme-safe">
                        <i class="fa-solid fa-star svg-2xl text-warning mb-3"></i>
                        <h6 class="text-theme-safe">.hover-lift-lg</h6>
                        <small class="text-theme-safe-muted">Dramatic lift</small>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info">
                <h5 class="alert-heading"><i class="fa-solid fa-info-circle me-2"></i>Feature Notes</h5>
                <ul class="mb-0">
                    <li><strong>Copy Buttons:</strong> Automatic toast notification on successful copy</li>
                    <li><strong>Stat Counters:</strong> Animate when element enters viewport (IntersectionObserver)</li>
                    <li><strong>Hover Effects:</strong> Automatically disabled on touch devices</li>
                    <li><strong>Accessibility:</strong> All interactive elements keyboard navigable with focus states</li>
                    <li><strong>Performance:</strong> Animations respect <code>prefers-reduced-motion</code></li>
                </ul>
            </div>
        </section>

        <!-- ====================================================================
             SECTION 0: Complete Theme Variables & Functional Palette Display
             ==================================================================== -->
        <section id="color-palette" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🎨 Complete Theme Variables & Functional Palette</h2>
            <p class="lead">All CSS variables from <code>all-themes.css</code> with live examples - Toggle theme to see changes!</p>
            
            <div class="alert alert-info mb-4">
                <h4 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Interactive Theme Display</h4>
                <p class="mb-2"><strong>Toggle the theme switcher in the header</strong> to see all variables update in real-time!</p>
                <p class="mb-0"><small>All variables are pulled directly from <code>all-themes.css</code> and displayed with their computed values.</small></p>
            </div>

            <!-- Base Theme Variables -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <h3 class="mb-4 text-theme-safe">
                        <i class="fa-solid fa-palette me-2"></i>Base Theme Variables (from all-themes.css)
                    </h3>
                </div>
                
                <!-- Light Mode Variables -->
                <div class="col-lg-6">
                    <div class="glass-card p-4">
                        <h4 class="mb-3 text-theme-safe">
                            <i class="fa-solid fa-sun me-2"></i>Light Mode Variables
                        </h4>
                        
                        <!-- Background Variables -->
                        <div class="mb-4">
                            <h5 class="text-theme-safe mb-3">Background & Base Colors</h5>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="glass-card p-3 text-center text-theme-safe" style="background: var(--background);">
                                        <strong class="text-theme-safe d-block mb-1">--background</strong>
                                        <code class="small d-block mb-1" id="var-background-light">#F9F3FB</code>
                                        <span class="badge bg-success small">WCAG AA</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="glass-card p-3 text-center text-theme-safe" style="background: var(--bs-secondary-bg);">
                                        <strong class="text-theme-safe d-block mb-1">--bs-secondary-bg</strong>
                                        <code class="small d-block mb-1" id="var-secondary-bg-light">#F5F3FF</code>
                                        <span class="badge bg-success small">WCAG AA</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Primary/Secondary/Accent -->
                        <div class="mb-4">
                            <h5 class="text-theme-safe mb-3">Brand Colors</h5>
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="glass-card p-3 text-center" style="background: var(--primary); color: white;">
                                        <strong class="d-block mb-1">--primary</strong>
                                        <code class="small d-block mb-1" id="var-primary-light">#6750A4</code>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="glass-card p-3 text-center" style="background: var(--secondary); color: white;">
                                        <strong class="d-block mb-1">--secondary</strong>
                                        <code class="small d-block mb-1" id="var-secondary-light">#E91E63</code>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="glass-card p-3 text-center" style="background: var(--accent); color: white;">
                                        <strong class="d-block mb-1">--accent</strong>
                                        <code class="small d-block mb-1" id="var-accent-light">#F06292</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Glass Variables -->
                        <div class="mb-4">
                            <h5 class="text-theme-safe mb-3">Glass Morphism</h5>
                            <div class="glass-card p-4 mb-3" style="background: var(--glass-panel-bg); backdrop-filter: blur(var(--glass-panel-blur)); border: 1px solid var(--glass-panel-border);">
                                <h6 class="text-theme-safe mb-2">Glass Panel Example</h6>
                                <p class="text-theme-safe-secondary small mb-2"><code>--glass-panel-bg</code>: <span id="var-glass-bg-light">rgba(249, 243, 251, 0.85)</span></p>
                                <p class="text-theme-safe-secondary small mb-2"><code>--glass-panel-blur</code>: <span id="var-glass-blur-light">10px</span></p>
                                <p class="text-theme-safe-secondary small mb-0"><code>--glass-panel-border</code>: <span id="var-glass-border-light">rgba(165, 99, 209, 0.2)</span></p>
                            </div>
                        </div>
                        
                        <!-- Text Variables -->
                        <div class="mb-3">
                            <h5 class="text-theme-safe mb-3">Text Colors</h5>
                            <div class="glass-card p-3 mb-2">
                                <p class="text-theme-safe mb-1"><code>--bs-body-color</code>: <span id="var-body-color-light">#2C2A33</span></p>
                                <p class="text-theme-safe-secondary mb-1"><code>--text-secondary</code>: <span id="var-text-secondary-light">#495057</span></p>
                                <p class="text-theme-safe-muted mb-0"><code>--text-muted</code>: <span id="var-text-muted-light">#6C757D</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dark Mode Variables -->
                <div class="col-lg-6">
                    <div class="glass-card p-4">
                        <h4 class="mb-3 text-theme-safe">
                            <i class="fa-solid fa-moon me-2"></i>Dark Mode Variables
                        </h4>
                        
                        <!-- Background Variables -->
                        <div class="mb-4">
                            <h5 class="text-theme-safe mb-3">Background & Base Colors</h5>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="glass-card p-3 text-center text-theme-safe" style="background: var(--background);">
                                        <strong class="text-theme-safe d-block mb-1">--background</strong>
                                        <code class="small d-block mb-1" id="var-background-dark">#0A0A0A</code>
                                        <span class="badge bg-success small">WCAG AA</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="glass-card p-3 text-center text-theme-safe" style="background: var(--bs-body-bg);">
                                        <strong class="text-theme-safe d-block mb-1">--bs-body-bg</strong>
                                        <code class="small d-block mb-1" id="var-body-bg-dark">#0A0A0A</code>
                                        <span class="badge bg-success small">WCAG AA</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Primary/Secondary/Accent -->
                        <div class="mb-4">
                            <h5 class="text-theme-safe mb-3">Brand Colors</h5>
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="glass-card p-3 text-center" style="background: var(--primary); color: white;">
                                        <strong class="d-block mb-1">--primary</strong>
                                        <code class="small d-block mb-1" id="var-primary-dark">#D14BFF</code>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="glass-card p-3 text-center" style="background: var(--secondary); color: white;">
                                        <strong class="d-block mb-1">--secondary</strong>
                                        <code class="small d-block mb-1" id="var-secondary-dark">#A563D1</code>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="glass-card p-3 text-center" style="background: var(--accent); color: white;">
                                        <strong class="d-block mb-1">--accent</strong>
                                        <code class="small d-block mb-1" id="var-accent-dark">#FF6EC4</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Glass Variables -->
                        <div class="mb-4">
                            <h5 class="text-theme-safe mb-3">Glass Morphism</h5>
                            <div class="glass-card p-4 mb-3" style="background: var(--glass-panel-bg); backdrop-filter: blur(var(--glass-panel-blur)); border: 1px solid var(--glass-panel-border);">
                                <h6 class="text-theme-safe mb-2">Glass Panel Example</h6>
                                <p class="text-theme-safe-secondary small mb-2"><code>--glass-panel-bg</code>: <span id="var-glass-bg-dark">rgba(0, 0, 0, 0.6)</span></p>
                                <p class="text-theme-safe-secondary small mb-2"><code>--glass-panel-blur</code>: <span id="var-glass-blur-dark">12px</span></p>
                                <p class="text-theme-safe-secondary small mb-0"><code>--glass-panel-border</code>: <span id="var-glass-border-dark">rgba(255, 255, 255, 0.1)</span></p>
                            </div>
                        </div>
                        
                        <!-- Text Variables -->
                        <div class="mb-3">
                            <h5 class="text-theme-safe mb-3">Text Colors</h5>
                            <div class="glass-card p-3 mb-2">
                                <p class="text-theme-safe mb-1"><code>--bs-body-color</code>: <span id="var-body-color-dark">#E0D5EB</span></p>
                                <p class="text-theme-safe-secondary mb-1"><code>--text-secondary</code>: <span id="var-text-secondary-dark">#C9BBDD</span></p>
                                <p class="text-theme-safe-muted mb-0"><code>--text-muted</code>: <span id="var-text-muted-dark">#B8A8CC</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Platform Colors -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <h3 class="mb-4 text-theme-safe">
                        <i class="fa-brands fa-youtube me-2"></i>Social Media Platform Colors
                    </h3>
                    <div class="row g-4">
                        <!-- YouTube -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-youtube fa-2x me-3" style="color: var(--youtube-red);"></i>
                                    <h5 class="mb-0">YouTube</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--youtube-red);">
                                        Primary: #FF0000
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--youtube-red-dark);">
                                        Dark: #CC0000
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discord -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-discord fa-2x me-3" style="color: var(--discord-blurple);"></i>
                                    <h5 class="mb-0">Discord</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--discord-blurple);">
                                        Blurple: #5865F2
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--discord-blurple-dark);">
                                        Dark: #4752C4
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--discord-blurple-light);">
                                        Light: #7289DA
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Twitch -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-twitch fa-2x me-3" style="color: var(--twitch-purple);"></i>
                                    <h5 class="mb-0">Twitch</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--twitch-purple);">
                                        Purple: #9146FF
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--twitch-purple-dark);">
                                        Dark: #7C38CC
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--twitch-purple-light);">
                                        Light: #A970FF
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Patreon -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-patreon fa-2x me-3" style="color: var(--patreon-coral);"></i>
                                    <h5 class="mb-0">Patreon</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--patreon-coral);">
                                        Coral: #FF424D
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--patreon-coral-dark);">
                                        Dark: #E73843
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--patreon-coral-light);">
                                        Light: #FF6B76
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Steam -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-steam fa-2x me-3" style="color: var(--steam-blue);"></i>
                                    <h5 class="mb-0">Steam</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--steam-blue);">
                                        Blue: #66C0F4
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--steam-navy);">
                                        Navy: #1B2838
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--steam-navy-dark);">
                                        Dark: #171A21
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Spotify -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-spotify fa-2x me-3" style="color: var(--spotify-green);"></i>
                                    <h5 class="mb-0">Spotify</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--spotify-green);">
                                        Green: #1DB954
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--spotify-green-dark);">
                                        Dark: #1AA34A
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Instagram -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-instagram fa-2x me-3" style="color: var(--instagram-magenta);"></i>
                                    <h5 class="mb-0">Instagram</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--instagram-magenta);">
                                        Magenta: #E4405F
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--instagram-gradient);">
                                        Gradient Palette
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- TikTok -->
                        <div class="col-md-4 col-lg-3">
                            <div class="glass-card p-3 h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fa-brands fa-tiktok fa-2x me-3" style="color: var(--tiktok-pink);"></i>
                                    <h5 class="mb-0">TikTok</h5>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <div class="p-2 rounded small text-white" style="background: var(--tiktok-black);">
                                        Black: #000000
                                    </div>
                                    <div class="p-2 rounded small text-white" style="background: var(--tiktok-pink);">
                                        Pink: #FF0050
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Live Component Examples -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <h3 class="mb-4 text-theme-safe">
                        <i class="fa-solid fa-cube me-2"></i>Live Component Examples
                    </h3>
                </div>
                
                <!-- Cards -->
                <div class="col-md-4">
                    <div class="glass-card p-4 hover-lift">
                        <h5 class="text-theme-safe mb-3">Glass Card</h5>
                        <p class="text-theme-safe-secondary mb-3">Uses <code>--glass-panel-bg</code> with backdrop blur</p>
                        <div class="glass-badge mb-2">Featured</div>
                        <div class="glass-badge mb-3">New</div>
                        <button class="btn btn-primary btn-sm">Action</button>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h5 class="text-theme-safe mb-3">Platform Buttons</h5>
                        <div class="d-flex flex-column gap-2">
                            <button class="btn btn-youtube btn-sm">
                                <i class="fa-brands fa-youtube me-2"></i>YouTube
                            </button>
                            <button class="btn btn-discord btn-sm">
                                <i class="fa-brands fa-discord me-2"></i>Discord
                            </button>
                            <button class="btn btn-twitch btn-sm">
                                <i class="fa-brands fa-twitch me-2"></i>Twitch
                            </button>
                            <button class="btn btn-patreon btn-sm">
                                <i class="fa-brands fa-patreon me-2"></i>Patreon
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Badges & Animations -->
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h5 class="text-theme-safe mb-3">Badges & Effects</h5>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary">Primary</span>
                            <span class="badge bg-secondary">Secondary</span>
                            <span class="glass-badge">Glass</span>
                            <span class="badge bg-success">Success</span>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-sparkles fa-2x text-warning svg-pulse"></i>
                            <p class="text-theme-safe-secondary small mt-2 mb-0">Animated Icon</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- JavaScript to update variable values dynamically -->
            <script>
            (function() {
                function updateVariableValues() {
                    const root = document.documentElement;
                    const computed = getComputedStyle(root);
                    const isDark = root.getAttribute('data-bs-theme') === 'dark';
                    
                    // Update all variable displays
                    const vars = {
                        'background': computed.getPropertyValue('--background').trim(),
                        'secondary-bg': computed.getPropertyValue('--bs-secondary-bg').trim(),
                        'body-bg': computed.getPropertyValue('--bs-body-bg').trim(),
                        'primary': computed.getPropertyValue('--primary').trim(),
                        'secondary': computed.getPropertyValue('--secondary').trim(),
                        'accent': computed.getPropertyValue('--accent').trim(),
                        'glass-bg': computed.getPropertyValue('--glass-panel-bg').trim(),
                        'glass-blur': computed.getPropertyValue('--glass-panel-blur').trim(),
                        'glass-border': computed.getPropertyValue('--glass-panel-border').trim(),
                        'body-color': computed.getPropertyValue('--bs-body-color').trim(),
                        'text-secondary': computed.getPropertyValue('--text-secondary').trim(),
                        'text-muted': computed.getPropertyValue('--text-muted').trim()
                    };
                    
                    // Update light/dark mode displays
                    const suffix = isDark ? 'dark' : 'light';
                    Object.keys(vars).forEach(key => {
                        const el = document.getElementById(`var-${key}-${suffix}`);
                        if (el) el.textContent = vars[key];
                    });
                }
                
                // Update on load
                updateVariableValues();
                
                // Update on theme change
                const observer = new MutationObserver(updateVariableValues);
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['data-bs-theme']
                });
            })();
            </script>
        </section>

        <!-- ====================================================================
             COLOR SWATCH PALETTES
             ==================================================================== -->
        <?php include __DIR__ . '/color-swatch-palettes.php'; ?>

        <!-- ====================================================================
             SECTION 3: Button & Icon Sizing System
             ====================================================================== -->
                    <button class="btn btn-danger">Danger</button>
                    <button class="btn btn-warning">Warning</button>
                    <button class="btn btn-info">Info</button>
                    <button class="btn btn-light">Light</button>
                    <button class="btn btn-dark">Dark</button>
                </div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button class="btn btn-outline-primary">Outline Primary</button>
                    <button class="btn btn-outline-secondary">Outline Secondary</button>
                    <button class="btn btn-outline-success">Outline Success</button>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-primary">Small</button>
                    <button class="btn btn-primary">Default</button>
                    <button class="btn btn-lg btn-primary">Large</button>
                </div>
            </div>

            <!-- Cards -->
            <div class="component-demo">
                <h3>Cards</h3>
                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Card Title</h5>
                                <p class="card-text">This is a basic Bootstrap 5.3.8 card component.</p>
                                <a href="#" class="btn btn-primary">Action</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Primary Card</h5>
                                <p class="card-text">Card with primary background color.</p>
                                <a href="#" class="btn btn-light">Action</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title text-success">Success Card</h5>
                                <p class="card-text">Card with success border.</p>
                                <a href="#" class="btn btn-success">Action</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Badges -->
            <div class="component-demo">
                <h3>Badges</h3>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-primary">Primary</span>
                    <span class="badge bg-secondary">Secondary</span>
                    <span class="badge bg-success">Success</span>
                    <span class="badge bg-danger">Danger</span>
                    <span class="badge bg-warning text-dark">Warning</span>
                    <span class="badge bg-info">Info</span>
                    <span class="badge rounded-pill bg-primary">Rounded Pill</span>
                </div>
            </div>

            <!-- Alerts -->
            <div class="component-demo">
                <h3>Alerts</h3>
                <div class="alert alert-primary" role="alert">
                    <i class="fa-solid fa-circle-info me-2"></i>
                    This is a primary alert with a FontAwesome icon!
                </div>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    This is a success alert with a Bootstrap Icon!
                </div>
            </div>
        </section>

        <!-- ====================================================================
             SECTION 3: Button & Icon Sizing System
             ==================================================================== -->
        <section id="button-system" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🔘 Button & Icon Sizing System</h2>
            <p class="lead">Unified em-based icon sizing across Bootstrap Icons, FontAwesome, and SVG</p>

            <div class="component-demo">
                <h3>Small Buttons (.btn-sm)</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-primary">
                        <i class="bi bi-star-fill"></i> Bootstrap Icon
                    </button>
                    <button class="btn btn-sm btn-success">
                        <i class="fa-solid fa-check"></i> FontAwesome Solid
                    </button>
                    <button class="btn btn-sm btn-info">
                        <i class="fa-brands fa-github"></i> FontAwesome Brand
                    </button>
                </div>
                <div class="code-preview mt-3">
/* Icon size: 0.875em (small) */
.btn-sm .fa, .btn-sm .fa-solid, .btn-sm .fa-brands { width: 0.875em; height: 0.875em; }</div>
            </div>

            <div class="component-demo">
                <h3>Default Buttons (.btn)</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-download"></i> Bootstrap Icon
                    </button>
                    <button class="btn btn-success">
                        <i class="fa-solid fa-envelope"></i> FontAwesome Solid
                    </button>
                    <button class="btn btn-info">
                        <i class="fa-brands fa-discord"></i> FontAwesome Brand
                    </button>
                </div>
                <div class="code-preview mt-3">
/* Icon size: 1em (default) */
.btn .fa, .btn .fa-solid, .btn .fa-brands { width: 1em; height: 1em; }</div>
            </div>

            <div class="component-demo">
                <h3>Large Buttons (.btn-lg)</h3>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-lg btn-primary">
                        <i class="bi bi-play-fill"></i> Bootstrap Icon
                    </button>
                    <button class="btn btn-lg btn-success">
                        <i class="fa-solid fa-rocket"></i> FontAwesome Solid
                    </button>
                    <button class="btn btn-lg btn-info">
                        <i class="fa-brands fa-youtube"></i> FontAwesome Brand
                    </button>
                </div>
                <div class="code-preview mt-3">
/* Icon size: 1.25em (large) */
.btn-lg .fa, .btn-lg .fa-solid, .btn-lg .fa-brands { width: 1.25em; height: 1.25em; }</div>
            </div>

            <div class="component-demo">
                <h3>Flexbox Alignment</h3>
                <p>All buttons use <code>display: inline-flex</code> with <code>align-items: center</code> for perfect icon centering:</p>
                <div class="code-preview">
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem; /* 6px spacing between icon and text */
  font-weight: 600;
  transition: all 0.3s ease;
}</div>
            </div>
        </section>

        <!-- ====================================================================
             SECTION 3.5: Social Media Buttons - All Sizes
             ==================================================================== -->
        <section id="social-buttons" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🌐 Social Media Buttons - Size Reference</h2>
            <p class="lead">YouTube, Discord, Patreon, Twitch, Instagram - All Button Sizes</p>

            <!-- Small Buttons -->
            <div class="component-demo">
                <h3>Small Social Buttons (.btn-sm)</h3>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="#" class="btn btn-sm btn-outline-youtube">
                        <i class="bi bi-youtube"></i> Subscribe
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-discord">
                        <i class="fa-brands fa-discord"></i> Discord
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-patreon">
                        <i class="fa-brands fa-patreon"></i> Patreon
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-twitch">
                        <i class="fa-brands fa-twitch"></i> Twitch
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-instagram">
                        <i class="fa-brands fa-instagram"></i> Instagram
                    </a>
                </div>
                <div class="code-preview mt-3">
&lt;a href="#" class="btn btn-sm btn-outline-youtube"&gt;
  &lt;i class="bi bi-youtube"&gt;&lt;/i&gt; Subscribe
&lt;/a&gt;
/* Uses .btn-outline-youtube from all-themes.css */
/* Icon: 0.875em | Text: 0.875rem | Padding: 0.25rem 0.5rem */</div>
            </div>

            <!-- Default Buttons -->
            <div class="component-demo">
                <h3>Default Social Buttons (.btn)</h3>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="#" class="btn btn-outline-youtube">
                        <i class="bi bi-youtube"></i> Subscribe
                    </a>
                    <a href="#" class="btn btn-outline-discord">
                        <i class="fa-brands fa-discord"></i> Join Discord
                    </a>
                    <a href="#" class="btn btn-outline-patreon">
                        <i class="fa-brands fa-patreon"></i> Support on Patreon
                    </a>
                    <a href="#" class="btn btn-outline-twitch">
                        <i class="fa-brands fa-twitch"></i> Follow on Twitch
                    </a>
                    <a href="#" class="btn btn-outline-instagram">
                        <i class="fa-brands fa-instagram"></i> Follow
                    </a>
                </div>
                <div class="code-preview mt-3">
&lt;a href="#" class="btn btn-outline-youtube"&gt;
  &lt;i class="bi bi-youtube"&gt;&lt;/i&gt; Subscribe
&lt;/a&gt;
/* Uses .btn-outline-youtube from all-themes.css */
/* Icon: 1em | Text: 1rem | Padding: 0.375rem 0.75rem */</div>
            </div>

            <!-- Large Buttons -->
            <div class="component-demo">
                <h3>Large Social Buttons (.btn-lg)</h3>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="#" class="btn btn-lg btn-outline-youtube">
                        <i class="bi bi-youtube"></i> Subscribe to Channel
                    </a>
                    <a href="#" class="btn btn-lg btn-outline-discord">
                        <i class="fa-brands fa-discord"></i> Join Discord Server
                    </a>
                    <a href="#" class="btn btn-lg btn-outline-patreon">
                        <i class="fa-brands fa-patreon"></i> Become a Patron
                    </a>
                </div>
                <div class="code-preview mt-3">
&lt;a href="#" class="btn btn-lg btn-outline-youtube"&gt;
  &lt;i class="bi bi-youtube"&gt;&lt;/i&gt; Subscribe to Channel
&lt;/a&gt;
/* Uses .btn-outline-youtube from all-themes.css */
/* Icon: 1.25em | Text: 1.25rem | Padding: 0.5rem 1rem */</div>
            </div>

            <!-- Rounded Pill Buttons (DIY Page Style) -->
            <div class="component-demo">
                <h3>Rounded Pill Buttons (.rounded-pill)</h3>
                <p>Social media buttons with rounded pill styling (as seen on DIY page):</p>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="#" class="btn btn-youtube btn-lg rounded-pill">
                        <i class="fa-brands fa-youtube"></i> Sub on YouTube
                    </a>
                    <a href="#" class="btn btn-discord btn-lg rounded-pill">
                        <i class="fa-brands fa-discord"></i> Join Discord
                    </a>
                    <a href="#" class="btn btn-instagram btn-lg rounded-pill">
                        <i class="fa-brands fa-instagram"></i> Instagram
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg rounded-pill">
                        <i class="fa-brands fa-tiktok"></i> Tiktok
                    </a>
                </div>
                <div class="code-preview mt-3">
&lt;a href="#" class="btn btn-youtube btn-lg rounded-pill"&gt;
  &lt;i class="fa-brands fa-youtube"&gt;&lt;/i&gt; Sub on YouTube
&lt;/a&gt;
/* Platform color + rounded-pill class */
/* Enhanced with diy-theme.css for shadow effects */</div>
            </div>

            <!-- Responsive Preview -->
            <div class="component-demo">
                <h3>📱 Responsive Behavior</h3>
                <p>Buttons automatically adjust on mobile devices:</p>
                <div class="code-preview">
/* Mobile (<576px) */
.btn {
  font-size: 1rem;           /* Larger for readability */
  padding: 0.75rem 1.25rem;  /* More touch-friendly */
}
.btn svg, .btn i.bi { font-size: 1em; }

/* Tablet (576-767px) */
.btn {
  font-size: 0.9375rem;      /* Slightly smaller */
  padding: 0.5rem 1rem;
}

/* Desktop (≥768px) */
.btn {
  /* Bootstrap defaults */
}</div>
            </div>
        </section>

        <!-- ====================================================================
             SECTION 4: Patreon Theme
             ==================================================================== -->
        <section id="theme-patreon" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">💖 Patreon Theme</h2>
            <p class="lead">Patreon coral brand color (#FF424D) with VIP content access</p>

            <div class="theme-preview" style="background: linear-gradient(135deg, #FF424D 0%, #E73843 100%);">
                <div class="text-white">
                    <h3>Patreon Hero Section</h3>
                    <p>Support JenniNexus on Patreon for exclusive content, early access, and VIP perks!</p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-patreon-coral">
                            <i class="fa-brands fa-patreon"></i> Join on Patreon
                        </button>
                        <button class="btn btn-outline-patreon">
                            <i class="fa-solid fa-crown"></i> VIP Benefits
                        </button>
                    </div>
                </div>
            </div>

            <div class="component-demo mt-4">
                <h4 class="mb-3"><i class="bi bi-shield-lock"></i> VIP Content Gating (Blur/Reveal)</h4>
                <p>The JenniNexus Patreon system uses a client-side "Blur-to-Reveal" mechanism for VIP content. This allows guests to see that content exists (previews) while keeping the actual data protected.</p>
                
                <div class="row g-4 mb-3">
                    <div class="col-md-6">
                        <div class="card h-100 bg-glass-light border-theme-accent">
                            <div class="card-header bg-theme-accent text-white">
                                <h6 class="mb-0"><i class="bi bi-gear"></i> Core Gating Classes</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><code>.vip-blur</code> - Applies backdrop blur filter (8px)</li>
                                    <li class="mb-2"><code>.vip-revealed</code> - Removes blur (authorized state)</li>
                                    <li class="mb-0"><code>.vip-guest-view</code> - Guest-specific container styling</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 bg-glass-light border-theme-accent">
                            <div class="card-header bg-theme-accent text-white">
                                <h6 class="mb-0">📋 Patreon Reveal List</h6>
                            </div>
                            <div class="card-body small">
                                <ul class="mb-0">
                                    <li class="mb-1"><strong>Patreon Posts:</strong> <code>#vipGrid</code> (patreon.php)</li>
                                    <li class="mb-1"><strong>VIP Playlists:</strong> <code>#vip-playlists</code> (patreon.php)</li>
                                    <li class="mb-1"><strong>CC4 PDF Guide:</strong> <code>#cc4Preview</code> (patreon.php)</li>
                                    <li class="mb-0"><strong>Member Downloads:</strong> <code>#vipDownloads</code> (patreon.php)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info small mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Mechanism:</strong> JavaScript calls <code>/resources/api/check-patreon-membership.php</code> and executes <code>revealVIP()</code> to remove blur classes if <code>is_patron</code> is true.
                </div>
            </div>

            <div class="code-preview">
/* Patreon Theme CSS Variables */
:root {
  --patreon-coral: #FF424D;
  --patreon-dark-coral: #E73843;
}

/* Patreon Buttons (with flexbox alignment) */
.btn-patreon-coral {
  background: var(--patreon-coral);
  color: white;
  border: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
}

.btn-outline-patreon {
  border: 2px solid var(--patreon-coral);
  color: var(--patreon-coral);
  background: transparent;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
}</div>
        </section>

        <!-- ====================================================================
             SECTION 5: Game Dev Theme
             ==================================================================== -->
        <section id="theme-gamedev" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🎮 Game Dev Theme</h2>
            <p class="lead">Steam navy (#171a21), YouTube red, and Patreon coral for game development content</p>

            <div class="theme-preview steam-gradient text-white">
                <h3>Game Dev Hero Section</h3>
                <p>Indie game development journey with Steam, YouTube, and Patreon integration</p>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-steam">
                        <i class="fa-brands fa-steam"></i> Steam Page
                    </button>
                    <button class="btn btn-youtube">
                        <i class="fa-brands fa-youtube"></i> YouTube Devlogs
                    </button>
                    <button class="btn btn-patreon-mg">
                        <i class="fa-brands fa-patreon"></i> Support Dev
                    </button>
                </div>
            </div>

            <div class="code-preview">
/* Game Dev Theme CSS Variables */
:root {
  --steam-navy: #171a21;
  --steam-blue: #66c0f4;
  --youtube-red: #ff0000;
}

/* Steam Button (with flexbox) */
.btn-steam {
  background: linear-gradient(135deg, #171a21, #1b2838);
  color: #66c0f4;
  border: 2px solid #66c0f4;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
}

/* YouTube Button */
.btn-youtube {
  background: linear-gradient(135deg, #ff0000, #cc0000);
  color: white;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
}</div>
        </section>

        <!-- ====================================================================
             SECTION 6: Gaming Theme
             ==================================================================== -->
        <section id="theme-gaming" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🎯 Gaming Theme</h2>
            <p class="lead">Steam-inspired dark navy (#171a21) with bright blue accents (#66c0f4)</p>

            <div class="theme-preview gaming-hero">
                <h3>Gaming Hero Section</h3>
                <p class="text-gaming-accent">Professional gaming aesthetic with Steam color palette</p>
                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-gamepad"></i> View Games
                    </button>
                    <button class="btn btn-outline-light">
                        <i class="fa-brands fa-twitch"></i> Watch Streams
                    </button>
                </div>
            </div>

            <div class="code-preview">
/* Gaming Theme CSS Variables */
:root {
  --gaming-navy: #171a21;          /* Steam dark navy */
  --gaming-dark-blue: #1b2838;     /* Steam medium blue */
  --gaming-accent-blue: #66c0f4;   /* Steam bright blue */
  --gaming-bright-blue: #c7d5e0;   /* Steam bright text */
}

/* Gaming Hero with Animation */
.gaming-hero {
  background: linear-gradient(135deg, var(--gaming-navy), var(--gaming-dark-blue));
  position: relative;
  overflow: hidden;
  color: var(--gaming-bright-blue);
}

@keyframes steam-pulse {
  0%, 100% { opacity: 0.5; transform: scale(1); }
  50% { opacity: 0.8; transform: scale(1.1); }
}</div>
        </section>

        <!-- ====================================================================
             SECTION 7: Live Streaming Theme
             ==================================================================== -->
        <section id="theme-live" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">📺 Live Streaming Theme</h2>
            <p class="lead">Twitch purple (#9146ff) and YouTube red (#ff0000) with live pulse animation</p>

            <div class="theme-preview live-hero">
                <div class="text-white">
                    <h3>Live Streaming Hero</h3>
                    <p>Dynamic theming for Twitch and YouTube live streams</p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-danger pulse-animation">
                            <i class="fa-solid fa-circle"></i> LIVE NOW
                        </button>
                        <button class="btn btn-light">
                            <i class="fa-brands fa-twitch"></i> Watch on Twitch
                        </button>
                    </div>
                </div>
            </div>

            <div class="code-preview">
/* Live Theme CSS Variables */
:root {
  --live-twitch: #9146ff;
  --live-youtube: #ff0000;
}

/* Live Pulse Animation */
.pulse-animation {
  animation: live-pulse 2s ease-in-out infinite;
  box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
}

@keyframes live-pulse {
  0%, 100% {
    transform: scale(1);
    box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
  }
  50% {
    transform: scale(1.05);
    box-shadow: 0 0 30px rgba(255, 0, 0, 0.8);
  }
}</div>
        </section>

        <!-- ====================================================================
             SECTION 8: DIY Theme
             ==================================================================== -->
        <section id="theme-diy" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">💅 DIY Theme</h2>
            <p class="lead">Beautiful gradient: Pink (#FF6EC4) → Purple (#A563D1) → Lavender (#C590E3)</p>

            <div class="theme-preview diy-hero">
                <div class="text-white">
                    <h3>DIY Beauty & Fashion Hero</h3>
                    <p>Vibrant color palette for beauty, fashion, and nails content</p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-light">
                            <i class="fa-solid fa-palette"></i> View Tutorials
                        </button>
                        <button class="btn btn-outline-light">
                            <i class="fa-brands fa-youtube"></i> DIY Videos
                        </button>
                    </div>
                </div>
            </div>

            <div class="code-preview">
/* DIY Theme CSS Variables */
:root[data-bs-theme="light"] {
  --diy-pink: #FF6EC4;
  --diy-purple: #A563D1;
  --diy-lavender: #C590E3;
  --diy-peach: #FFB6C1;
  --diy-coral: #FF7F7F;
  --diy-mint: #00D4AA;
  --diy-gold: #FFD700;
}

/* DIY Hero Gradient */
.diy-hero {
  background: linear-gradient(135deg, 
    var(--diy-pink) 0%, 
    var(--diy-purple) 50%, 
    var(--diy-lavender) 100%
  );
  position: relative;
  overflow: hidden;
}</div>
        </section>

        <!-- ====================================================================
             SECTION 9: Tags Theme
             ==================================================================== -->
        <section id="theme-tags" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">🏷️ Tags Theme</h2>
            <p class="lead">JenniNexus hot pink (#FF2E88) and purple (#A563D1) for unified tag system</p>

            <div class="theme-preview tags-hero">
                <h3>Tags System Hero</h3>
                <p>Multi-page tag filtering with consistent brand colors</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="tag-badge">Gaming</span>
                    <span class="tag-badge">Game Dev</span>
                    <span class="tag-badge">DIY</span>
                    <span class="tag-badge">Music</span>
                    <span class="tag-badge">Live</span>
                </div>
            </div>

            <div class="code-preview">
/* Tags Theme CSS Variables */
:root {
  --tag-primary: #FF2E88;      /* JenniNexus hot pink */
  --tag-secondary: #A563D1;    /* JenniNexus purple */
  --tag-accent: #FF6EC4;       /* JenniNexus light pink */
  --tag-info: #5352ED;         /* JenniNexus blue */
  --tag-success: #00D4AA;      /* JenniNexus teal */
}

/* Tag Badge Styles */
.tag-badge {
  background: rgba(255, 46, 136, 0.1);
  color: var(--tag-primary);
  border: 1px solid var(--tag-primary);
  padding: 0.4rem 0.8rem;
  border-radius: 0.375rem;
}</div>
        </section>

        <!-- ====================================================================
             TAG SYSTEM ARCHITECTURE & USAGE
             ==================================================================== -->
        <section id="tag-system" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-tags-fill"></i> Tag System Architecture</h2>
            
            <div class="alert alert-info mb-4">
                <h5 class="mb-3"><i class="bi bi-info-circle"></i> Tag System Overview</h5>
                <p class="mb-2"><strong>Version:</strong> 6.1 (198 tags, multi-tag filtering, card previews)</p>
                <p class="mb-2"><strong>Architecture:</strong> YAML-driven content tagging with client-side filtering (no database required)</p>
                <p class="mb-0"><strong>Full Documentation:</strong> <code>storage/docs/TAG-SYSTEM.md</code> | <code>.config/tag-deps.json</code></p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card h-100 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-database"></i> Core Files</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <code>tags.json</code> - Tag definitions (198 tags)<br>
                                    <small class="text-muted">Contains: id, name, slug, category for each tag</small>
                                </li>
                                <li class="mb-2">
                                    <code>content_tags.json</code> - Tag mappings<br>
                                    <small class="text-muted">Generated by PowerShell script, maps tags to content IDs</small>
                                </li>
                                <li class="mb-2">
                                    <code>tag-system.js</code> - Client-side filtering<br>
                                    <small class="text-muted">Loads tags, handles offcanvas UI, filters content</small>
                                </li>
                                <li class="mb-0">
                                    <code>generate-playlist-tags.ps1</code> - Tag indexing<br>
                                    <small class="text-muted">Reads YAML files, generates content_tags.json</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-file-earmark-code"></i> Integration Points</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong>Page Headers:</strong><br>
                                    <small class="text-muted">index.php, gaming.php, gamedev.php, diy.php - Tag filter offcanvas</small>
                                </li>
                                <li class="mb-2">
                                    <strong>Playlist Cards:</strong><br>
                                    <small class="text-muted">YAML files (gaming.yaml, gamedev.yaml, etc.) - Tags array per playlist</small>
                                </li>
                                <li class="mb-2">
                                    <strong>Blog Posts:</strong><br>
                                    <small class="text-muted">blog/*.php - Tag badge buttons with onclick handlers</small>
                                </li>
                                <li class="mb-0">
                                    <strong>Filter Results:</strong><br>
                                    <small class="text-muted">/tags.php?filters=slug1,slug2 - Multi-tag card previews</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning mb-4">
                <h5 class="mb-3"><i class="bi bi-exclamation-triangle"></i> Tag System Workflow</h5>
                <ol class="mb-0">
                    <li class="mb-2"><strong>Edit YAML/PHP:</strong> Add/update tags in gaming.yaml, blog/*.php</li>
                    <li class="mb-2"><strong>Verify tags.json:</strong> Check all tags exist in tags.json</li>
                    <li class="mb-2"><strong>Run:</strong> <code>pwsh -File scripts/generate-playlist-tags.ps1 -Verbose</code></li>
                    <li class="mb-2"><strong>Verify:</strong> Check content_tags.json updated</li>
                    <li class="mb-0"><strong>Test:</strong> Visit /tags.php?filters=yourtag</li>
                </ol>
            </div>

            <div class="alert alert-danger mb-4">
                <h5 class="mb-3"><i class="bi bi-exclamation-octagon"></i> Common Mistakes</h5>
                <ul class="mb-0">
                    <li><strong>Spaces in slugs:</strong> Use <code>game-development</code> not <code>game development</code></li>
                    <li><strong>Mismatched slug/onclick:</strong> data-tag-slug must match onclick parameter</li>
                    <li><strong>Missing definitions:</strong> All YAML tags must exist in tags.json</li>
                    <li><strong>Forgetting to regenerate:</strong> Always run generate-playlist-tags.ps1 after YAML changes</li>
                </ul>
            </div>
        </section>

        <!-- ====================================================================
             BUTTON SYSTEM ARCHITECTURE & RESPONSIVENESS
             ==================================================================== -->
        <section id="button-responsive" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-toggle-on"></i> Button System Architecture</h2>
            
            <div class="alert alert-info">
                <h5 class="mb-3"><i class="bi bi-info-circle"></i> Global Button Management</h5>
                <p><strong>Loaded Globally:</strong> <code>custom.css</code> is loaded on ALL pages via <code>includes/head.php</code> (line 149)</p>
                <p class="mb-2"><strong>Key Features:</strong></p>
                <ul class="mb-2">
                    <li><strong>Flexbox Gap:</strong> <code>gap: 0.375rem</code> (6px) for icon-text spacing - NO margin classes needed (no me-1, me-2)</li>
                    <li><strong>Em-Based Icons:</strong> Scale with button text size (btn-sm: 0.875em, btn: 1em, btn-lg: 1.25em)</li>
                    <li><strong>Responsive Breakpoints:</strong> Size-class-aware mobile rules maintain hierarchy</li>
                    <li><strong>Theme-Aware Hover:</strong> Dark mode glow, light mode elevation</li>
                    <li><strong>Vertical Centering:</strong> <code>display: inline-flex</code> + <code>align-items: center</code> ensures perfect icon/text alignment</li>
                </ul>
                <p class="mb-0"><strong>Documentation:</strong> See <code>storage/docs/CSS-SCSS.md</code> → "Button Management & Consistency System"</p>
            </div>

            <div class="component-demo">
                <h4 class="mb-3">Button Responsiveness Across Breakpoints</h4>
                <p class="text-muted">All buttons scale appropriately on mobile, tablet, and desktop (see <code>custom.css</code> lines 118-192)</p>
                
                <h5 class="mt-4">Mobile (&lt;576px) - Touch-Friendly Sizing</h5>
                <div class="code-preview">
/* Mobile - Larger for readability and touch targets */
.btn {
  font-size: 1rem;           /* Larger text */
  padding: 0.75rem 1.25rem;  /* More padding for fat fingers */
}
.btn svg, .btn i.bi, .btn .fa { 
  font-size: 1em;            /* Icons scale with text */
}

.btn-sm {
  font-size: 0.875rem;
  padding: 0.5rem 1rem;
}
.btn-sm svg, .btn-sm i.bi, .btn-sm .fa {
  font-size: 0.875em;        /* Proportionally smaller */
}

.btn-lg {
  font-size: 1.125rem;
  padding: 0.875rem 1.5rem;
}
.btn-lg svg, .btn-lg i.bi, .btn-lg .fa {
  font-size: 1.25em;         /* Proportionally larger */
}</div>

                <h5 class="mt-4">Tablet (576px-768px) - Balanced Sizing</h5>
                <div class="code-preview">
/* Tablet - Medium sizing for touch + mouse */
.btn {
  font-size: 0.9375rem;
  padding: 0.625rem 1.125rem;
}

.btn-sm {
  font-size: 0.8125rem;
  padding: 0.4375rem 0.875rem;
}

.btn-lg {
  font-size: 1.0625rem;
  padding: 0.75rem 1.375rem;
}</div>

                <h5 class="mt-4">Desktop (≥768px) - Bootstrap Defaults</h5>
                <div class="code-preview">
/* Desktop - Use Bootstrap 5.3.8 defaults */
.btn {
  font-size: 1rem;
  padding: 0.375rem 0.75rem;
}

.btn-sm {
  font-size: 0.875rem;
  padding: 0.25rem 0.5rem;
}

.btn-lg {
  font-size: 1.25rem;
  padding: 0.5rem 1rem;
}</div>
            </div>

            <div class="alert alert-success mt-4">
                <h5 class="mb-3"><i class="bi bi-check-circle"></i> Correct Button Usage</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>✅ CORRECT - Uses flexbox gap:</strong></p>
                        <div class="code-preview">
&lt;button class="btn btn-primary"&gt;
  &lt;i class="fa-brands fa-youtube"&gt;&lt;/i&gt;
  Subscribe
&lt;/button&gt;

&lt;button class="btn btn-sm btn-outline-secondary"&gt;
  &lt;i class="bi bi-x-circle"&gt;&lt;/i&gt;
  Clear All
&lt;/button&gt;</div>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>❌ INCORRECT - Manual margins:</strong></p>
                        <div class="code-preview">
&lt;!-- DON'T DO THIS --&gt;
&lt;button class="btn btn-primary"&gt;
  &lt;i class="fa-brands fa-youtube me-2"&gt;&lt;/i&gt;
  Subscribe
&lt;/button&gt;

&lt;!-- me-1, me-2 are redundant --&gt;
&lt;!-- gap: 0.375rem handles spacing --&gt;</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ====================================================================
             HOME PAGE THEME (home-theme.css)
             ==================================================================== -->
        <section id="theme-home" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-house-heart-fill"></i> Home Page Theme</h2>
            
            <div class="alert alert-info mb-4">
                <h4 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Purpose</h4>
                <p class="mb-2"><strong>File:</strong> <code>home-theme.css</code></p>
                <p class="mb-0"><strong>Unique Features:</strong> Surface helper class, responsive social icons, project card zoom effects, icon pulse glow animations</p>
            </div>

            <h3 class="mb-3">0. Home Surface Helper Pattern</h3>
            <div class="card border-success mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-palette"></i> Recent Implementation (Jan 1, 2026)</h5>
                </div>
                <div class="card-body">
                    <p><strong>Problem Solved:</strong> White text on white backgrounds caused by <code>bg-body-secondary</code> in light mode</p>
                    <p class="mb-3"><strong>Solution:</strong> Created <code>.home-surface</code> helper class matching pattern from DIY, Gaming, and Game Dev pages</p>
                    
                    <h6 class="mt-3">Pattern Usage:</h6>
                    <div class="code-preview small mb-3">
&lt;!-- Section with proper text contrast --&gt;
&lt;section class="section-pastel home-surface"&gt;
  &lt;div class="container"&gt;
    &lt;h2&gt;About Me&lt;/h2&gt;
    &lt;p class="lead"&gt;Content with proper contrast&lt;/p&gt;
  &lt;/div&gt;
&lt;/section&gt;

&lt;!-- Individual cards use glass-card --&gt;
&lt;div class="card glass-card hover-lift"&gt;
  &lt;div class="card-body"&gt;
    &lt;h3 class="card-title"&gt;Game Development&lt;/h3&gt;
  &lt;/div&gt;
&lt;/div&gt;</div>

                    <h6>Replaced <code>bg-body-secondary</code> with <code>section-pastel home-surface</code> on:</h6>
                    <ul class="small">
                        <li><strong>About section</strong> (#about) - Biography and introduction</li>
                        <li><strong>Content section</strong> (#content) - Streaming schedule</li>
                        <li><strong>Channels section</strong> (#channels) - Platform links</li>
                        <li><strong>Resume section</strong> (#resume) - Professional experience</li>
                    </ul>

                    <h6 class="mt-3">Replaced <code>bg-body-secondary</code> with <code>glass-card</code> on:</h6>
                    <ul class="small mb-3">
                        <li><strong>Game Development card</strong> - Project showcase</li>
                        <li><strong>3D Art Services card</strong> - Blender services</li>
                        <li><strong>Professional Affiliations card</strong> - Organizations</li>
                    </ul>

                    <h6>.home-surface CSS (from home-theme.css):</h6>
                    <div class="code-preview small">
/* Home Surface Helper - Ensures proper text contrast */
.home-surface {
  background: var(--glass-bg);
  border-radius: 0.75rem;
  padding: 2rem 1rem;
}

/* Light mode: Dark text on lavender backgrounds */
:root[data-bs-theme="light"] .home-surface h1,
:root[data-bs-theme="light"] .home-surface h2,
:root[data-bs-theme="light"] .home-surface h3,
:root[data-bs-theme="light"] .home-surface p,
:root[data-bs-theme="light"] .home-surface .lead {
  color: #2C2A33; /* Dark purple-gray */
}

/* Dark mode: Light text on dark backgrounds */
:root[data-bs-theme="dark"] .home-surface h1,
:root[data-bs-theme="dark"] .home-surface h2,
:root[data-bs-theme="dark"] .home-surface h3,
:root[data-bs-theme="dark"] .home-surface p,
:root[data-bs-theme="dark"] .home-surface .lead {
  color: #F5F3FF; /* Light lavender */
}

/* Cards inside home-surface use glass panel styling */
.home-surface .card {
  background: var(--glass-panel-bg);
  -webkit-backdrop-filter: blur(var(--glass-panel-blur));
  backdrop-filter: blur(var(--glass-panel-blur));
  border: 1px solid var(--glass-panel-border);
}</div>

                    <div class="alert alert-warning mt-3 mb-0">
                        <strong><i class="bi bi-lightbulb"></i> Design Principle:</strong> Consistent surface helper pattern across all pages ensures proper text contrast in both light and dark modes. Always use <code>section-pastel [page]-surface</code> for major sections and <code>glass-card</code> for individual cards.
                    </div>
                </div>
            </div>

            <h3 class="mb-3">2. Parallax & Stat Counter Demos</h3>
            <div class="row g-4 mb-4">
              <div class="col-md-6">
                <div class="card border-info h-100">
                  <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-arrows-move"></i> Playlist Card Parallax (Demo)</h5>
                  </div>
                  <div class="card-body">
                    <p class="mb-2"><strong>Live Demo:</strong> Below is a static example of a playlist card configured to use the parallax system. In production this is rendered by <code>youtube-grid.js</code> and can be toggled per-section via YAML.</p>

                    <div class="row g-3 align-items-start">
                      <div class="col-12 col-lg-6">
                        <!-- Demo playlist card (static example) -->
                        <div class="card glass-card playlist-card-single parallax-layer" data-parallax-speed="0.08">
                          <div class="ratio ratio-16x9 bg-dark">
                            <img src="<?= RES_ROOT ?>/images/placeholder/playlist_demo.jpg" alt="Demo thumbnail" class="object-fit-cover w-100 h-100" loading="lazy">
                          </div>
                          <div class="card-body">
                            <h5 class="card-title mb-1">Demo Playlist · <small class="text-muted">Parallax 0.08</small></h5>
                            <p class="small text-muted mb-2">This card demonstrates parallax movement on scroll. The <code>parallax-layer</code> class and <code>data-parallax-speed</code> attribute are picked up by <code>ui-effects.js</code>.</p>
                            <div class="d-flex gap-2">
                              <a href="#" class="btn btn-sm btn-outline-primary"><i class="fa-brands fa-youtube me-1"></i>View</a>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-lg-6">
                        <h6 class="small mb-2">YAML Flags (per-section)</h6>
                        <div class="code-preview small mb-2">
# Example: Include in section YAML
featured_section:
  playlists:
    - id: PLxxxxx
  enable_parallax: true      # default: true
  parallaxSpeed: 0.08       # optional - speed multiplier (0.02 - 0.12 common range)
</div>
                        <p class="small text-muted">Set <code>enable_parallax: false</code> to opt-out a section from parallax. The default behavior is enabled; specify <code>parallaxSpeed</code> to fine-tune motion.</p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card border-primary h-100">
                  <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Stat Counter (Demo)</h5>
                  </div>
                  <div class="card-body">
                    <p class="mb-2">Stat counters animate when scrolled into view. Use <code>span.stat-number[data-target]</code> and include an accessible label.</p>

                    <div class="d-flex align-items-center gap-4">
                      <div class="text-center">
                        <h3 class="display-6 mb-0"><span class="stat-number" data-target="5000">0</span></h3>
                        <p class="small text-muted mb-0">YouTube Subscribers</p>
                      </div>
                      <div class="text-center">
                        <h3 class="display-6 mb-0"><span class="stat-number" data-target="120">0</span></h3>
                        <p class="small text-muted mb-0">Projects</p>
                      </div>
                    </div>

                    <h6 class="mt-3 small">JS Integration</h6>
                    <div class="code-preview small">
/* Add anywhere in markup */
&lt;h3&gt;&lt;span class="stat-number" data-target="12345"&gt;0&lt;/span&gt;&lt;/h3&gt;
/* ui-effects.js will animate when in view */
</div>

                  </div>
                </div>
              </div>
            </div>

            <h3 class="mb-3">1. Responsive Social Icons (Mobile vs Desktop)</h3>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-phone"></i> Mobile (< 768px)</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Design:</strong> Stacked full-width buttons with icon + text</p>
                            <ul class="mb-2">
                                <li>Vertical stack (<code>flex-direction: column</code>)</li>
                                <li>Full width with padding</li>
                                <li>Text labels visible (<code>::after { content: attr(aria-label) }</code>)</li>
                                <li>Rounded rectangles (<code>border-radius: 0.5rem</code>)</li>
                            </ul>
                            <div class="code-preview small">
/* Mobile: Stacked with text */
.hero-section .social-links {
  flex-direction: column;
  gap: 0.75rem;
}
.hero-section .social-links .btn {
  width: 100%;
  padding: 0.75rem 1.5rem;
}
.hero-section .social-links .btn::after {
  content: attr(aria-label);
}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-display"></i> Desktop (≥ 768px)</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Design:</strong> Single row of icon-only squares</p>
                            <ul class="mb-2">
                                <li>Horizontal row (<code>flex-direction: row</code>)</li>
                                <li>Fixed 56px × 56px squares</li>
                                <li>Icon only (<code>::after { content: none }</code>)</li>
                                <li>Rounded squares (<code>border-radius: 0.5rem</code>)</li>
                            </ul>
                            <div class="code-preview small">
/* Desktop: Icon-only squares */
@media (min-width: 768px) {
  .hero-section .social-links {
    flex-direction: row;
  }
  .hero-section .social-links .btn {
    width: 56px;
    height: 56px;
    padding: 0;
  }
  .hero-section .social-links .btn::after {
    content: none; /* Hide text */
  }
}</div>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="mb-3">2. Project Card Zoom + Icon Glow</h3>
            <div class="card border-warning mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-stars"></i> Unique Home Page Hover Effect</h5>
                </div>
                <div class="card-body">
                    <p><strong>Behavior:</strong> Cards zoom (no lateral lift) + icons get pulsing glow animation</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6>Card Zoom Effect:</h6>
                            <ul class="small mb-2">
                                <li><code>transform: scale(1.05)</code> - Centered zoom</li>
                                <li>Pink glow shadow (theme-adaptive)</li>
                                <li>No <code>translateY</code> - stays in place</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Icon Pulse Glow:</h6>
                            <ul class="small mb-2">
                                <li><code>@keyframes iconPulseGlow</code></li>
                                <li>Infinite pulse animation (1.5s)</li>
                                <li>Drop-shadow filters (8px → 12px)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="code-preview small">
/* Project Card - Zoom without lift */
.project-card:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 40px rgba(255, 46, 136, 0.25);
}

/* Icon Pulse Glow Animation */
.project-card:hover .project-icon {
  animation: iconPulseGlow 1.5s ease-in-out infinite;
  filter: drop-shadow(0 0 8px rgba(255, 46, 136, 0.6))
          drop-shadow(0 0 16px rgba(255, 46, 136, 0.4));
}

@keyframes iconPulseGlow {
  0%, 100% {
    filter: drop-shadow(0 0 8px rgba(255, 46, 136, 0.6));
  }
  50% {
    filter: drop-shadow(0 0 12px rgba(255, 46, 136, 0.8))
            drop-shadow(0 0 24px rgba(255, 46, 136, 0.6));
  }
}</div>
                </div>
            </div>

            <h3 class="mb-3">3. Platform-Specific Hover Colors</h3>
            <div class="alert alert-secondary">
                <p class="mb-2"><strong>Social icons inherit platform colors on hover:</strong></p>
                <div class="row g-2 small">
                    <div class="col-md-4">• YouTube: <code>#FF0000</code></div>
                    <div class="col-md-4">• Twitch: <code>#9146FF</code></div>
                    <div class="col-md-4">• Discord: <code>#5865F2</code></div>
                    <div class="col-md-4">• GitHub: <code>#fff</code></div>
                    <div class="col-md-4">• LinkedIn: <code>#0A66C2</code></div>
                    <div class="col-md-4">• Email: <code>#FF2E88</code> (JenniNexus pink)</div>
                </div>
            </div>
        </section>

        <!-- ====================================================================
             SITEWIDE HOVER PROTOCOL
             ==================================================================== -->
        <section id="hover-protocol" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-mouse2"></i> Sitewide Hover Protocol</h2>
            
            <div class="alert alert-primary">
                <h4 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Core Principle</h4>
                <p class="mb-0"><strong>All interactive elements should provide visual feedback on hover:</strong></p>
                <ul class="mt-2 mb-0">
                    <li><strong>Color Change</strong> - Brand/accent color on hover</li>
                    <li><strong>Glow Effect</strong> - Box-shadow with platform/theme color</li>
                    <li><strong>Animation</strong> - Smooth transitions (translateY, scale, or filter)</li>
                </ul>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card h-100 border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-check-circle"></i> Button Hover Protocol</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Standard Pattern:</strong></p>
                            <ul class="mb-3">
                                <li>Color darkens/lightens on hover</li>
                                <li>Box-shadow glow appears (rgba with 0.4-0.5 alpha)</li>
                                <li>Slight lift: <code>transform: translateY(-2px)</code></li>
                                <li>Smooth transition: <code>all 0.3s ease</code></li>
                            </ul>
                            <div class="code-preview">
.btn-platform {
  transition: all 0.3s ease;
}
.btn-platform:hover {
  background-color: var(--platform-dark);
  box-shadow: 0 4px 16px rgba(color, 0.5);
  transform: translateY(-2px);
}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 border-info">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-card-image"></i> Card Hover Protocol</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Standard Pattern:</strong></p>
                            <ul class="mb-3">
                                <li>Zoom: <code>transform: scale(1.05)</code></li>
                                <li>Theme-colored glow on border</li>
                                <li>Icon inside gains glow animation</li>
                                <li>Smooth easing: <code>cubic-bezier(0.175, 0.885, 0.32, 1.275)</code></li>
                            </ul>
                            <div class="code-preview">
.card:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 40px rgba(255, 46, 136, 0.25);
  border-color: var(--jenni-primary);
}
.card:hover .icon {
  animation: iconPulseGlow 1.5s ease-in-out infinite;
}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-stars"></i> Icon Glow Animation</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Used on:</strong> Feature cards, project cards, icon buttons</p>
                            <div class="code-preview">
@keyframes iconPulseGlow {
  0%, 100% {
    filter: drop-shadow(0 0 8px rgba(255, 46, 136, 0.6))
            drop-shadow(0 0 16px rgba(255, 46, 136, 0.4));
  }
  50% {
    filter: drop-shadow(0 0 12px rgba(255, 46, 136, 0.8))
            drop-shadow(0 0 24px rgba(255, 46, 136, 0.6));
  }
}

.card:hover .icon {
  animation: iconPulseGlow 1.5s ease-in-out infinite;
}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-success">
                <h5 class="mb-3"><i class="bi bi-palette"></i> Theme Consistency</h5>
                <p class="mb-2"><strong>Social Media Buttons:</strong></p>
                <ul class="mb-3">
                    <li><strong>YouTube:</strong> #ff0000 → #cc0000 (dark), glow: rgba(255, 0, 0, 0.4)</li>
                    <li><strong>Discord:</strong> #5865F2 → #4752c4 (dark), glow: rgba(88, 101, 242, 0.5)</li>
                    <li><strong>Twitch:</strong> #9146FF → #7c38cc (dark), glow: rgba(145, 70, 255, 0.5)</li>
                    <li><strong>Patreon:</strong> #FF424D → #e73843 (dark), glow: rgba(255, 66, 77, 0.5)</li>
                    <li><strong>Instagram:</strong> Gradient, glow: rgba(228, 64, 95, 0.5) + brightness(1.1)</li>
                    <li><strong>Steam:</strong> Navy bg → #171a21, blue border, glow: rgba(102, 192, 244, 0.4)</li>
                    <li><strong>Spotify:</strong> #1DB954 → #1aa34a (dark), glow: rgba(29, 185, 84, 0.5)</li>
                    <li><strong>TikTok:</strong> Black → #1a1a1a, pink border, glow: rgba(255, 0, 80, 0.5)</li>
                    <li><strong>GitHub:</strong> #333333 → #24292e, glow: rgba(51, 51, 51, 0.5)</li>
                </ul>
                <p class="mb-0"><strong>All documented in:</strong> <code>public_html/resources/css/all-themes.css</code></p>
            </div>

            <div class="alert alert-danger">
                <h5 class="mb-3"><i class="bi bi-exclamation-triangle"></i> What NOT to Do</h5>
                <ul class="mb-0">
                    <li>❌ No hover feedback (static elements)</li>
                    <li>❌ Hover effects that break layout (lateral shifts)</li>
                    <li>❌ Same color for fill and outline (low contrast)</li>
                    <li>❌ Inconsistent transitions (mix of 0.2s and 0.5s)</li>
                    <li>❌ Over-aggressive animations (scale > 1.1)</li>
                    <li>❌ Missing webkit prefixes for filters/animations</li>
                </ul>
            </div>
        </section>

        <!-- ====================================================================
             BOOTSTRAP 5.3.8 GRID SYSTEM BEST PRACTICES
             ==================================================================== -->
        <section id="grid-best-practices" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-grid-3x3"></i> Bootstrap 5.3.8 Grid System</h2>
            
            <div class="alert alert-primary">
                <h5 class="mb-3">📊 Grid System Overview</h5>
                <p>JenniNexus uses Bootstrap 5.3.8's 12-column responsive grid with mobile-first breakpoints.</p>
                <p class="mb-2"><strong>Breakpoints:</strong></p>
                <ul class="mb-2">
                    <li><code>xs</code> - Extra small (&lt;576px) - iPhone 13/14 (390px), mobile devices</li>
                    <li><code>sm</code> - Small (≥576px) - Large phones (landscape)</li>
                    <li><code>md</code> - Medium (≥768px) - Tablets</li>
                    <li><code>lg</code> - Large (≥992px) - Small desktops</li>
                    <li><code>xl</code> - Extra large (≥1200px) - Desktops</li>
                    <li><code>xxl</code> - Extra extra large (≥1400px) - Large desktops</li>
                </ul>
                <p class="mb-0"><strong>Full Documentation:</strong> <code>storage/docs/BOOTSTRAP-5.3.8.md</code> → "Layout & Grid System"</p>
            </div>

            <div class="component-demo">
                <h4 class="mb-3">Responsive Grid Patterns Used Site-Wide</h4>
                
                <h5 class="mt-4">Pattern 1: Gallery Grid (4 → 3 → 2 columns)</h5>
                <p class="text-muted"><strong>Used for:</strong> Game screenshots, image galleries</p>
                <div class="row g-2 g-md-3 mb-3">
                    <div class="col-6 col-md-4 col-lg-3"><div class="bg-primary text-white p-3 rounded text-center">Gallery Item</div></div>
                    <div class="col-6 col-md-4 col-lg-3"><div class="bg-primary text-white p-3 rounded text-center">Gallery Item</div></div>
                    <div class="col-6 col-md-4 col-lg-3"><div class="bg-primary text-white p-3 rounded text-center">Gallery Item</div></div>
                    <div class="col-6 col-md-4 col-lg-3"><div class="bg-primary text-white p-3 rounded text-center">Gallery Item</div></div>
                </div>
                <div class="code-preview">
&lt;div class="row g-2 g-md-3"&gt;
  &lt;div class="col-6 col-md-4 col-lg-3"&gt;...&lt;/div&gt;
&lt;/div&gt;
/* Mobile: 2 cols (col-6) | Tablet: 3 cols (col-md-4) | Desktop: 4 cols (col-lg-3) */</div>

                <h5 class="mt-4">Pattern 2: Playlist Grid (3 → 2 → 1 columns)</h5>
                <p class="text-muted"><strong>Used for:</strong> Video playlists, blog posts, featured content cards</p>
                <div class="row g-4 mb-3">
                    <div class="col-12 col-md-6 col-lg-4"><div class="card"><div class="card-body">Playlist Card</div></div></div>
                    <div class="col-12 col-md-6 col-lg-4"><div class="card"><div class="card-body">Playlist Card</div></div></div>
                    <div class="col-12 col-md-6 col-lg-4"><div class="card"><div class="card-body">Playlist Card</div></div></div>
                </div>
                <div class="code-preview">
&lt;div class="row g-4"&gt;
  &lt;div class="col-12 col-md-6 col-lg-4"&gt;...&lt;/div&gt;
&lt;/div&gt;
/* Mobile: 1 col (col-12) | Tablet: 2 cols (col-md-6) | Desktop: 3 cols (col-lg-4) */</div>

                <h5 class="mt-4">Pattern 3: Main/Sidebar Layout</h5>
                <p class="text-muted"><strong>Used for:</strong> Blog posts, game pages with sidebar content</p>
                <div class="row g-4 mb-3">
                    <div class="col-12 col-lg-8"><div class="card"><div class="card-body">Main Content Area</div></div></div>
                    <div class="col-12 col-lg-4"><div class="card"><div class="card-body">Sidebar</div></div></div>
                </div>
                <div class="code-preview">
&lt;div class="row g-4"&gt;
  &lt;div class="col-12 col-lg-8"&gt;Main content&lt;/div&gt;
  &lt;div class="col-12 col-lg-4"&gt;Sidebar&lt;/div&gt;
&lt;/div&gt;
/* Mobile: Stacked (col-12) | Desktop: 8/4 split (col-lg-8, col-lg-4) */</div>
            </div>

            <div class="alert alert-warning mt-4">
                <h5 class="mb-3"><i class="bi bi-exclamation-triangle"></i> Common Grid Pitfalls</h5>
                <ul class="mb-0">
                    <li><strong>DON'T override Bootstrap's <code>.row</code> with CSS Grid</strong> - Use Bootstrap column classes instead</li>
                    <li><strong>DON'T mix flexbox and grid</strong> - Bootstrap uses flexbox for <code>.row</code>, let it do its job</li>
                    <li><strong>DO use <code>.row</code> wrapper</code> - YouTube Grid API automatically creates responsive columns</li>
                    <li><strong>DO use responsive gutter classes</strong> - <code>g-2 g-md-4</code> for mobile-friendly spacing</li>
                </ul>
                <p class="mt-2 mb-0"><strong>Troubleshooting:</strong> <code>storage/docs/VIDEO-GRID.md</code> → "Grid Structure Comparison"</p>
            </div>
        </section>

        <!-- ====================================================================
             CONTENT DISPLAY PROTOCOLS
             ==================================================================== -->
        <section id="content-protocols" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-layout-text-window"></i> Content Display Protocols</h2>
            
            <div class="alert alert-success">
                <h5 class="mb-3">🎬 Video Content Display</h5>
                <p class="mb-2"><strong>System:</strong> YouTube Grid API (<code>youtube-grid.js</code> v3.0)</p>
                <ul class="mb-2">
                    <li><strong>Playlists:</strong> Configure via YAML in <code>/resources/playlists/</code></li>
                    <li><strong>RSS Feeds:</strong> Use internal proxy <code>get-youtube.php</code> (10-min server cache, 24-hr client cache)</li>
                    <li><strong>Responsive Grid:</strong> Columns object <code>{xs: 1, sm: 2, md: 3, lg: 3}</code></li>
                    <li><strong>Lazy Loading:</strong> <code>loading="lazy"</code> on thumbnails for performance</li>
                    <li><strong>Aspect Ratio:</strong> <code>.ratio.ratio-16x9</code> for consistent sizing</li>
                </ul>
                <p class="mb-0"><strong>Documentation:</strong> <code>storage/docs/VIDEO-GRID.md</code>, <code>YOUTUBE.md</code>, <code>YOUTUBE-RSS-ARCHITECTURE.md</code></p>
            </div>

            <div class="alert alert-info">
                <h5 class="mb-3">📝 Blog Post Display</h5>
                <p class="mb-2"><strong>System:</strong> YAML-based blog system (<code>blog-posts.yaml</code>)</p>
                <ul class="mb-2">
                    <li><strong>Card Layout:</strong> <code>col-12 col-md-6 col-lg-4</code> (3 → 2 → 1 columns)</li>
                    <li><strong>Image Sizing:</strong> <code>height: 200px; object-fit: cover;</code> for thumbnails</li>
                    <li><strong>Tag Filtering:</strong> Multi-tag selection via <code>tag-system.js</code></li>
                    <li><strong>Markdown Content:</strong> Full posts in <code>/blog/*.md</code> with frontmatter</li>
                    <li><strong>SEO Optimization:</strong> Meta tags, Open Graph, structured data</li>
                </ul>
                <p class="mb-0"><strong>Documentation:</strong> <code>storage/docs/BLOG-SYSTEM.md</code>, <code>BOOTSTRAP-YAML-BLOG-UPDATE-NOV3.md</code></p>
            </div>

            <div class="alert alert-warning">
                <h5 class="mb-3">🎮 Game/Featured Cards Display</h5>
                <p class="mb-2"><strong>System:</strong> Custom card components with Bootstrap grid</p>
                <ul class="mb-2">
                    <li><strong>Game Pages:</strong> <code>col-6 col-md-4 col-lg-3</code> for screenshot galleries</li>
                    <li><strong>Featured Content:</strong> <code>col-12 col-md-6 col-lg-4</code> for playlist/game cards</li>
                    <li><strong>Hover Effects:</strong> <code>transform: translateY(-3px)</code> with box-shadow transition</li>
                    <li><strong>CTA Buttons:</strong> Steam, YouTube, Discord buttons with brand colors</li>
                    <li><strong>Theme Integration:</strong> Page-specific theme CSS (gaming-theme.css, gamedev-theme.css, etc.)</li>
                </ul>
                <p class="mb-0"><strong>Documentation:</strong> <code>storage/docs/GAME-DEV-PAGES.md</code>, <code>GAMING-PAGE.md</code>, <code>PLAYLIST-MAPPING.md</code></p>
            </div>

            <div class="component-demo">
                <h4 class="mb-3">Best Practices Summary</h4>
                <div class="code-preview">
<strong>✅ DO:</strong>
- Use Bootstrap column classes (col-12 col-md-6 col-lg-4)
- Configure responsive columns in YAML: {xs: 1, sm: 2, md: 3}
- Use flexbox gap for button spacing (NO me-1/me-2 margin classes)
- Lazy load images with loading="lazy"
- Use .ratio.ratio-16x9 for video embeds
- Follow mobile-first approach (design for 390px iPhone first)
- Use em-based icon sizing (scales with button text)
- Reference existing documentation instead of creating new files

<strong>❌ DON'T:</strong>
- Override Bootstrap .row with CSS Grid
- Use relative paths (use &lt;?= RES_ROOT ?&gt; instead)
- Add manual margin classes to buttons (gap handles spacing)
- Hard-code pixel sizes (use clamp() for responsive scaling)
- Create new documentation files (update existing docs)
- Fight Bootstrap defaults (use them, extend minimally)</div>
            </div>
        </section>

        <!-- ====================================================================
             DOCUMENTATION REFERENCE
             ==================================================================== -->
        <section id="documentation-reference" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="bi bi-book"></i> Documentation Reference</h2>
            
            <div class="alert alert-warning mb-4">
                <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill me-2"></i>Dependency Graphs</h4>
                <p class="mb-2"><strong>Before modifying core systems, check the dependency graphs (versioned, dated):</strong></p>
                <ul class="mb-0">
                    <li><code>.config/tag-deps.json</code> - Tag system architecture (v6.1, 2025-11-08: 198 tags, scripts, workflows)</li>
                    <li><code>.config/video-deps.json</code> - Video/RSS system (v3.1, 2025-11-08: NO API, RSS-only, caching)</li>
                    <li><code>.config/assets-deps.json</code> - CSS/JS assets (v1.0, 2025-11-08: injection points, themes, minification)</li>
                </ul>
            </div>
            
            <div class="alert alert-danger">
                <h5 class="mb-3"><i class="bi bi-exclamation-octagon"></i> IMPORTANT: Don't Create New Docs!</h5>
                <p class="mb-0">Before documenting new features, <strong>UPDATE EXISTING DOCUMENTATION</strong> listed below. Only create new docs if the topic genuinely doesn't fit anywhere.</p>
            </div>

            <div class="row g-4">
                <!-- Bootstrap & CSS -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-bootstrap"></i> Bootstrap & CSS</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong><code>BOOTSTRAP-5.3.8.md</code></strong><br>
                                    <small class="text-muted">Grid system, components, theme toggle, responsive breakpoints, layout patterns. <strong>INCLUDES:</strong> Nov 3 validation & YAML updates</small>
                                </li>
                                <li class="mb-2">
                                    <strong><code>CSS-SCSS.md</code></strong><br>
                                    <small class="text-muted">Button management, theme CSS, minification, SCSS architecture, responsive design</small>
                                </li>
                                <li class="mb-0">
                                    <strong><code>FONTAWESOME-SVGS.md</code></strong><br>
                                    <small class="text-muted">FontAwesome 6.7.2 integration, icon usage, SVG optimization</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Video & Content Systems -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="bi bi-play-circle"></i> Video & Content</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong><code>VIDEO-GRID.md</code></strong><br>
                                    <small class="text-muted">YouTube Grid API, responsive rendering, troubleshooting grid issues</small>
                                </li>
                                <li class="mb-2">
                                    <strong><code>YOUTUBE.md</code></strong><br>
                                    <small class="text-muted">YouTube integration, playlist system, YAML configuration. <strong>INCLUDES:</strong> RSS Architecture (no API required)</small>
                                </li>
                                <li class="mb-2">
                                    <strong><code>BLOG-SYSTEM.md</code></strong><br>
                                    <small class="text-muted">YAML blog posts (blog-posts.yaml), nested directory RES_ROOT patterns, video embedding with data-playlist attribute, resources/images/blog/. <strong>SEE:</strong> .config/video-deps.json for blog embedding examples</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Page-Specific Docs -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-file-earmark-code"></i> Page-Specific</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong><code>GAME-DEV-PAGES.md</code></strong><br>
                                    <small class="text-muted">Game page structure, RES_ROOT/__DIR__ patterns, video embedding (youtube-grid.js), YAML configs, Steam integration. <strong>SEE:</strong> .config/video-deps.json for complete embedding patterns</small>
                                </li>
                                <li class="mb-0">
                                    <strong><code>GAMING-PAGE.md</code></strong><br>
                                    <small class="text-muted">Gaming hub layout, playlist categories, tag filtering. <strong>INCLUDES:</strong> Game Jams page system. <strong>EXAMPLE:</strong> gaming.php shows proper YAML-driven video rendering</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Systems & Configuration -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-gear"></i> Systems & Config</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong><code>TAG-SYSTEM.md</code></strong><br>
                                    <small class="text-muted">Multi-tag filtering, tag-system.js API, offcanvas panels. <strong>INCLUDES:</strong> Patreon tag integration & OAuth system</small>
                                </li>
                                <li class="mb-2">
                                    <strong><code>ROUTING-SYSTEM.md</code></strong><br>
                                    <small class="text-muted">Clean URLs, Nginx routing, subdirectory navigation</small>
                                </li>
                                <li class="mb-2">
                                    <strong><code>PLAYLIST-MAPPING.md</code></strong><br>
                                    <small class="text-muted">YAML configuration reference, playlist structure, grid configs</small>
                                </li>
                                <li class="mb-0">
                                    <strong><code>JS.md</code></strong><br>
                                    <small class="text-muted">JavaScript architecture, Bootstrap integration, minification</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Deployment & Development -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="bi bi-rocket"></i> Deployment & Dev</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <strong><code>DEPLOYMENT-GUIDE.md</code></strong><br>
                                    <small class="text-muted">Build scripts, SSH deployment, production checklist</small>
                                </li>
                                <li class="mb-2">
                                    <strong><code>LOCAL-DEV.md</code></strong><br>
                                    <small class="text-muted">Local development setup, PHP server, testing workflow</small>
                                </li>
                                <li class="mb-0">
                                    <strong><code>QUICKSTART.md</code></strong><br>
                                    <small class="text-muted">Getting started guide, project structure, first steps</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Patreon Integration -->
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Patreon</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-0">
                                    <strong><code>PATREON-SECRETS.md</code></strong><br>
                                    <small class="text-muted">OAuth setup, client secrets, VIP content access</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="alert alert-success mt-4">
                <h5 class="mb-3"><i class="bi bi-check-circle"></i> Documentation Consolidation Complete</h5>
                <p class="mb-2"><strong>Status:</strong> Docs consolidated from 21 → 17 files (November 8, 2025)</p>
                <p class="mb-2"><strong>Completed Merges:</strong></p>
                <ul class="mb-2">
                    <li><strong>Bootstrap files:</strong> <code>BOOTSTRAP-VALIDATION-NOV3.md</code> + <code>BOOTSTRAP-YAML-BLOG-UPDATE-NOV3.md</code> → merged into <code>BOOTSTRAP-5.3.8.md</code></li>
                    <li><strong>YouTube files:</strong> <code>YOUTUBE-RSS-ARCHITECTURE.md</code> → already documented in <code>YOUTUBE.md</code></li>
                    <li><strong>Patreon files:</strong> <code>PATREON-TAG-AUDIT-NOV3.md</code> → merged into <code>TAG-SYSTEM.md</code></li>
                    <li><strong>Gaming files:</strong> <code>GAME-JAM-PAGE.md</code> → merged into <code>GAMING-PAGE.md</code></li>
                </ul>
                <p class="mb-0"><small><i class="bi bi-archive"></i> Archived files preserved in <code>storage/docs/archived/</code> for reference.</small></p>
            </div>
        </section>

        <!-- ====================================================================
             SECTION 10: Responsive Grid System
             ==================================================================== -->
        <section id="responsive-grid" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">📱 Responsive Grid System</h2>
            <p class="lead">Bootstrap 5.3.8 12-column grid with mobile-first breakpoints</p>

            <div class="component-demo">
                <h3>Breakpoint Reference</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Breakpoint</th>
                            <th>Class Prefix</th>
                            <th>Screen Width</th>
                            <th>Example Device</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Extra Small</td>
                            <td><code>xs</code></td>
                            <td>&lt;576px</td>
                            <td>iPhone 13/14 (390px)</td>
                        </tr>
                        <tr>
                            <td>Small</td>
                            <td><code>sm</code></td>
                            <td>≥576px</td>
                            <td>Phones (landscape)</td>
                        </tr>
                        <tr>
                            <td>Medium</td>
                            <td><code>md</code></td>
                            <td>≥768px</td>
                            <td>Tablets</td>
                        </tr>
                        <tr>
                            <td>Large</td>
                            <td><code>lg</code></td>
                            <td>≥992px</td>
                            <td>Small desktops</td>
                        </tr>
                        <tr>
                            <td>Extra Large</td>
                            <td><code>xl</code></td>
                            <td>≥1200px</td>
                            <td>Desktops</td>
                        </tr>
                        <tr>
                            <td>Extra Extra Large</td>
                            <td><code>xxl</code></td>
                            <td>≥1400px</td>
                            <td>Large desktops</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="component-demo">
                <h3>Grid Pattern Examples</h3>
                
                <h4>Pattern 1: 4 → 3 → 2 → 1 Columns</h4>
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="bg-primary text-white p-3 rounded text-center">1</div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="bg-primary text-white p-3 rounded text-center">2</div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="bg-primary text-white p-3 rounded text-center">3</div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="bg-primary text-white p-3 rounded text-center">4</div>
                    </div>
                </div>
                <div class="code-preview">
&lt;div class="row g-3"&gt;
  &lt;div class="col-6 col-md-4 col-lg-3"&gt;...&lt;/div&gt;
&lt;/div&gt;
/* Mobile: 2 cols (col-6) | Tablet: 3 cols (col-md-4) | Desktop: 4 cols (col-lg-3) */</div>

                <h4 class="mt-4">Pattern 2: 3 → 2 → 1 Columns</h4>
                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="bg-success text-white p-3 rounded text-center">1</div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="bg-success text-white p-3 rounded text-center">2</div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="bg-success text-white p-3 rounded text-center">3</div>
                    </div>
                </div>
                <div class="code-preview">
&lt;div class="row g-4"&gt;
  &lt;div class="col-12 col-md-6 col-lg-4"&gt;...&lt;/div&gt;
&lt;/div&gt;
/* Mobile: 1 col (col-12) | Tablet: 2 cols (col-md-6) | Desktop: 3 cols (col-lg-4) */</div>
            </div>
        </section>

        <!-- ====================================================================
             VIDEO GRID SYSTEM SHOWCASE
             ==================================================================== -->
        <section id="video-grid-showcase" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="fa-solid fa-grid-2-plus me-2"></i>Video Grid System Showcase</h2>
            
            <div class="alert alert-info">
                <h4 class="alert-heading"><i class="fa-solid fa-circle-info me-2"></i>Live Examples</h4>
                <p class="mb-2"><strong>Purpose:</strong> Demonstrate the three video grid layout patterns used across JenniNexus</p>
                <p class="mb-0"><strong>Documentation:</strong> See <code>storage/docs/VIDEO-GRID.md</code> for complete technical details</p>
            </div>

            <!-- Pattern 1: Single-Card Layout (Gaming/GameDev) -->
            <div class="component-demo mb-5">
                <h3 class="mb-3">Pattern 1: Single-Card Layout</h3>
                <p class="text-muted mb-3"><strong>Used on:</strong> gaming.php, gamedev.php, youtube.php</p>
                
                <div class="alert alert-secondary mb-3">
                    <strong>Features:</strong>
                    <ul class="mb-0">
                        <li>Grid of playlist cards (3 columns on desktop)</li>
                        <li>1 large video preview per card (latest/first video)</li>
                        <li>Interactive hover lift effect</li>
                        <li>Bootstrap ratio classes (16:9 aspect ratio)</li>
                    </ul>
                </div>

                <div class="row g-4 mb-3">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card glass-card playlist-card-single h-100">
                            <div class="ratio ratio-16x9 bg-dark">
                                <img src="https://i.ytimg.com/vi/dQw4w9WgXcQ/mqdefault.jpg" 
                                     alt="Example Video" 
                                     class="w-100 h-100 object-fit-cover">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 4rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-danger mb-2">Horror</span>
                                <h5 class="card-title">
                                    <a href="#" class="playlist-title-link text-decoration-none">Horror Game Playthroughs</a>
                                </h5>
                                <p class="card-text small text-muted">Spooky games and scary moments collection</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">12 videos</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card glass-card playlist-card-single h-100">
                            <div class="ratio ratio-16x9 bg-dark">
                                <img src="https://i.ytimg.com/vi/9bZkp7q19f0/mqdefault.jpg" 
                                     alt="Example Video" 
                                     class="w-100 h-100 object-fit-cover">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 4rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">RPG</span>
                                <h5 class="card-title">
                                    <a href="#" class="playlist-title-link text-decoration-none">RPG Adventures</a>
                                </h5>
                                <p class="card-text small text-muted">Epic role-playing game series</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">24 videos</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card glass-card playlist-card-single h-100">
                            <div class="ratio ratio-16x9 bg-dark">
                                <img src="https://i.ytimg.com/vi/kJQP7kiw5Fk/mqdefault.jpg" 
                                     alt="Example Video" 
                                     class="w-100 h-100 object-fit-cover">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 4rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="badge bg-success mb-2">Indie</span>
                                <h5 class="card-title">
                                    <a href="#" class="playlist-title-link text-decoration-none">Indie Game Showcase</a>
                                </h5>
                                <p class="card-text small text-muted">Hidden gems and indie favorites</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">18 videos</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="code-preview">
<strong>YAML Configuration (gaming.yaml):</strong>
grid_config:
  columns: { xs: 1, sm: 2, md: 3, lg: 3 }
  show_single_video: true
  layout: "single-card"
  aspect_ratio: "16:9"

<strong>CSS (custom.css):</strong>
.playlist-card-single:hover {
  transform: translateY(-8px);
  z-index: 10;
}

<strong>Result:</strong> 3-column responsive grid (1 col mobile → 2 col tablet → 3 col desktop)</div>
            </div>

            <!-- Pattern 2: Multi-Video Layout (DIY Featured) -->
            <div class="component-demo mb-5">
                <h3 class="mb-3">Pattern 2: Multi-Video Layout</h3>
                <p class="text-muted mb-3"><strong>Used on:</strong> diy.php (featured section)</p>
                
                <div class="alert alert-secondary mb-3">
                    <strong>Features:</strong>
                    <ul class="mb-0">
                        <li>Full-width playlist panels (1 column)</li>
                        <li>3 videos displayed horizontally per playlist</li>
                        <li>No hover lift (static container)</li>
                        <li>Clickable playlist title links to YouTube</li>
                    </ul>
                </div>

                <div class="alert alert-warning mb-3">
                    <strong>Hover Behavior:</strong> Hover over individual video thumbnails to see the lift effect. The panel container stays static.
                </div>

                <div class="mb-3">
                    <div class="card glass-card playlist-card-multi">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa-solid fa-scissors fs-4 me-2 text-primary"></i>
                                <h5 class="card-title mb-0">
                                    <a href="#" class="playlist-title-link text-decoration-none">Fashion & Style Tutorials</a>
                                </h5>
                            </div>
                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <div class="ratio ratio-16x9 bg-dark">
                                        <img src="https://i.ytimg.com/vi/dQw4w9WgXcQ/mqdefault.jpg" 
                                             alt="Video 1" 
                                             class="w-100 h-100 object-fit-cover">
                                        <div class="play-overlay">
                                            <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                        </div>
                                    </div>
                                    <p class="small text-muted mt-2 mb-0">Summer Fashion Lookbook 2025</p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="ratio ratio-16x9 bg-dark">
                                        <img src="https://i.ytimg.com/vi/9bZkp7q19f0/mqdefault.jpg" 
                                             alt="Video 2" 
                                             class="w-100 h-100 object-fit-cover">
                                        <div class="play-overlay">
                                            <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                        </div>
                                    </div>
                                    <p class="small text-muted mt-2 mb-0">DIY Clothing Hacks</p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="ratio ratio-16x9 bg-dark">
                                        <img src="https://i.ytimg.com/vi/kJQP7kiw5Fk/mqdefault.jpg" 
                                             alt="Video 3" 
                                             class="w-100 h-100 object-fit-cover">
                                        <div class="play-overlay">
                                            <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                        </div>
                                    </div>
                                    <p class="small text-muted mt-2 mb-0">Thrift Store Fashion Finds</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="code-preview">
<strong>YAML Configuration (diy.yaml):</strong>
featured_section:
  container_id: "diyPlaylistsContainer"
  columns: { xs: 1, sm: 1, md: 1, lg: 1 }  # Full width
  show_single_video: false
  layout: "multi-video"
  videos_per_playlist: 3

<strong>CSS (custom.css):</strong>
.playlist-card-multi {
  transform: none !important;  /* No lift effect */
}

<strong>Result:</strong> Full-width stacked panels, 3 videos horizontal (stacked on mobile)</div>
            </div>

            <!-- Pattern 3: Vertical Video (Gaming Shorts) -->
            <div class="component-demo mb-5">
                <h3 class="mb-3">Pattern 3: Vertical Video Layout (9:16)</h3>
                <p class="text-muted mb-3"><strong>Used on:</strong> gaming.php (YouTube Shorts section)</p>
                
                <div class="alert alert-secondary mb-3">
                    <strong>Features:</strong>
                    <ul class="mb-0">
                        <li>Portrait aspect ratio (9:16 for Shorts/TikTok)</li>
                        <li>Narrower cards for vertical content</li>
                        <li>Same hover effects as single-card layout</li>
                        <li>4-column grid on desktop for space efficiency</li>
                    </ul>
                </div>

                <div class="row g-4 mb-3">
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card glass-card gaming-short-card h-100">
                            <div class="ratio ratio-9x16 bg-dark">
                                <img src="https://i.ytimg.com/vi/dQw4w9WgXcQ/mqdefault.jpg" 
                                     alt="Short Video" 
                                     class="w-100 h-100 object-fit-cover"
                                     style="object-position: center;">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title small mb-0">Epic Gaming Moment #1</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card glass-card gaming-short-card h-100">
                            <div class="ratio ratio-9x16 bg-dark">
                                <img src="https://i.ytimg.com/vi/9bZkp7q19f0/mqdefault.jpg" 
                                     alt="Short Video" 
                                     class="w-100 h-100 object-fit-cover"
                                     style="object-position: center;">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title small mb-0">Quick Tips & Tricks</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card glass-card gaming-short-card h-100">
                            <div class="ratio ratio-9x16 bg-dark">
                                <img src="https://i.ytimg.com/vi/kJQP7kiw5Fk/mqdefault.jpg" 
                                     alt="Short Video" 
                                     class="w-100 h-100 object-fit-cover"
                                     style="object-position: center;">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title small mb-0">Funny Fails Compilation</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card glass-card gaming-short-card h-100">
                            <div class="ratio ratio-9x16 bg-dark">
                                <img src="https://i.ytimg.com/vi/jNQXAC9IVRw/mqdefault.jpg" 
                                     alt="Short Video" 
                                     class="w-100 h-100 object-fit-cover"
                                     style="object-position: center;">
                                <div class="play-overlay">
                                    <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white;"></i>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title small mb-0">Behind the Scenes</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="code-preview">
<strong>YAML Configuration (gaming.yaml - Shorts section):</strong>
recent_shorts:
  title: "Latest Gaming Shorts"
  aspect_ratio: "9:16"  # Portrait orientation
  columns: { xs: 2, sm: 3, md: 4, lg: 4 }

<strong>CSS (gaming-theme.css):</strong>
.gaming-short-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(102, 192, 244, 0.3);
}

<strong>Result:</strong> 4-column grid on desktop, 2 columns on mobile (portrait videos)</div>
            </div>

            <!-- CSS Layer Architecture -->
            <div class="component-demo">
                <h3 class="mb-3">CSS Customization Layers</h3>
                <p class="text-muted mb-3"><strong>How styling is organized:</strong></p>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Layer</th>
                                <th>File</th>
                                <th>Controls</th>
                                <th>Example</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-primary">1. Foundation</span></td>
                                <td><code>Bootstrap 5.3.8</code></td>
                                <td>Grid system, aspect ratios, card structure</td>
                                <td><code>.ratio-16x9</code>, <code>.col-md-4</code></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success">2. Global</span></td>
                                <td><code>custom.css</code></td>
                                <td>Hover effects, play overlay, title links</td>
                                <td><code>.playlist-card-single:hover</code></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">3. Page Theme</span></td>
                                <td><code>gaming-theme.css</code></td>
                                <td>Page-specific colors, shadows, gradients</td>
                                <td><code>.gaming-playlist-card:hover</code></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-info">4. Dynamic</span></td>
                                <td><code>youtube-grid.js</code></td>
                                <td>RSS feed fetching, HTML generation</td>
                                <td><code>fetchPlaylistVideos()</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="code-preview">
<strong>CSS Loading Order (cascade priority):</strong>
1. bootstrap.min.css           ← Foundation (grid, ratios)
2. custom.css                   ← Global behaviors (all pages)
3. gaming-theme.css             ← Page-specific styling
4. youtube-grid.js generates    ← Dynamic HTML with classes

<strong>Example: Gaming page hover effect</strong>
1. Bootstrap: .card { border: 1px solid #dee2e6; }
2. custom.css: .playlist-card-single:hover { transform: translateY(-8px); }
3. gaming-theme.css: .gaming-playlist-card:hover { 
     box-shadow: 0 8px 16px rgba(102, 192, 244, 0.2); 
   }

<strong>Result:</strong> Combined effect - lift + Steam-blue glow on hover</div>
            </div>

            <!-- YouTube JS & CSS Explainer -->
            <div class="component-demo">
                <h3 class="mb-3">YouTube JS & CSS Explainer</h3>
                <p class="text-muted mb-3"><strong>Purpose:</strong> Quick reference for implementing responsive YouTube/playlist grids using our JS and CSS layers.</p>

                <div class="row g-4 mb-3">
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100">
                            <h5 class="mb-2">Where to edit</h5>
                            <ul class="mb-0">
                                <li><code>src/assets/js/youtube-grid.js</code> — rendering, responsive column logic, RSS proxy calls</li>
                                <li><code>src/assets/css/media.css</code> — video card, ratio, play-overlay, hover states</li>
                                <li><code>public_html/resources/playlists/*.yaml</code> — per-page layout configs (columns, videos_per_playlist)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100">
                            <h5 class="mb-2">Quick Usage</h5>
                            <p class="small text-muted">YAML example (multi or single-card):</p>
                            <pre class="small bg-dark text-light p-2 rounded">featured_section:
  container_id: "live-playlists-grid"
  columns: { xs: 1, sm: 2, md: 3, lg: 4, xl: 6 }
  videos_per_playlist: 6
  show_single_video: false</pre>
                        </div>
                    </div>
                </div>

                <div class="code-preview mb-3">
<strong>HTML (render target)</strong>
<pre>&lt;div id="live-playlists-grid" class="row g-3"&gt;
  &lt;!-- youtube-grid.js will insert .col- classes with responsive widths, e.g. col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 --&gt;
&lt;/div&gt;</pre>

<strong>JS (manual render)</strong>
<pre class="small">// Programmatically render a playlist into a container
YouTubeGrid.renderPlaylist('live-playlists-grid', 'PL6WnzXOaRqA1q_0XZ2fPo0LIEErxxyoT1', {
  columns: 6,
  videos_per_playlist: 6,
  layout: 'multi-video'
});</pre>

<strong>Notes:</strong> The JS adds Bootstrap column classes (default: <code>col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2</code>) so the row will always match the container width responsively.</div>

                <h4 class="mb-3">SVG Protocol & Usage</h4>
                <p class="text-muted mb-3">Best practices for icons & SVGs in JenniNexus</p>

                <div class="row g-4 mb-4">
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100">
                            <h5 class="mb-2">Sizing & Classes</h5>
                            <ul class="mb-0">
                                <li>Use <code>.svg-inline</code> for inline SVGs to allow <code>currentColor</code> fills</li>
                                <li>Sizing utilities: <code>.svg-xs</code>, <code>.svg-sm</code>, <code>.svg-md</code>, <code>.svg-lg</code>, <code>.svg-xl</code>, <code>.svg-2xl</code></li>
                                <li>Animation utilities: <code>.svg-spin</code>, <code>.svg-pulse</code>, <code>.svg-beat</code>, <code>.svg-fade</code></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3 h-100">
                            <h5 class="mb-2">Inline vs. Image</h5>
                            <p class="mb-0 small text-muted">Prefer inline SVG for animated or color-adaptive icons (use <code>fill="currentColor"</code>). Use <code>&lt;img&gt;</code> for static icons where accessibility (alt text) is required.</p>
                        </div>
                    </div>
                </div>

                <div class="code-preview">
<strong>Inline SVG (recommended for animated/adaptive icons)</strong>
<pre>&lt;svg class="svg-inline svg-md svg-pulse" role="img" aria-hidden="true" viewBox="0 0 24 24" fill="currentColor"&gt;
  &lt;path d="M12 5l-7 7h14l-7-7z" /&gt;
&lt;/svg&gt;</pre>

<strong>Image SVG (static)</strong>
<pre>&lt;img src="/resources/images/icons/chevron-up-solid.svg" class="svg-md" alt="Back to top" /&gt;</pre>

<strong>Back-to-Top Recommendation</strong>
<p class="small text-muted">Either use the inline SVG with <code>fill="currentColor"</code> for theme-aware coloring, or use the shipped <code>chevron-up-solid.svg</code> with appropriate <code>alt</code> text. Our JS expects the element with id <code>#scroll-to-top</code> to contain the icon.</p>
</div>
            </div>
        </section>

        <!-- ====================================================================
             CAROUSEL SHOWCASE
             ==================================================================== -->
        <section id="carousel-showcase" class="theme-section bg-pastel">
            <h2 class="display-5 mb-4"><i class="fa-solid fa-images me-2"></i>Carousel Showcase</h2>
            <p class="lead">Bootstrap 5.3.8 carousel component with gradient backgrounds and video embeds</p>
            
            <div class="alert alert-info">
                <h4 class="alert-heading"><i class="fa-solid fa-circle-info me-2"></i>Usage</h4>
                <p class="mb-2"><strong>Example:</strong> Featured playlists carousel on gaming.php</p>
                <p class="mb-0"><strong>Features:</strong> Responsive layout with YouTube iframes, gradient backgrounds, carousel controls</p>
            </div>

            <div class="component-demo">
                <h3 class="mb-3">Featured Content Carousel</h3>
                
                <div id="themeDemoCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#themeDemoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#themeDemoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#themeDemoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner rounded">
                        <!-- Example Slide 1 - Purple Gradient -->
                        <div class="carousel-item active">
                            <div class="row g-0 bg-gradient p-4 text-white align-items-center" style="min-height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="col-md-5 d-flex align-items-center p-3">
                                    <div>
                                        <h3 class="display-6 fw-bold mb-3">Example Playlist Title</h3>
                                        <p class="lead mb-4">Engaging description text that explains what viewers can expect from this content series</p>
                                        <a href="#" target="_blank" class="btn btn-light btn-lg">
                                            <i class="fa-brands fa-youtube me-2"></i>Watch Playlist
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                                                title="Example Video"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen 
                                                loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Example Slide 2 - Blue Gradient -->
                        <div class="carousel-item">
                            <div class="row g-0 bg-gradient p-4 text-white align-items-center" style="min-height: 400px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <div class="col-md-5 d-flex align-items-center p-3">
                                    <div>
                                        <h3 class="display-6 fw-bold mb-3">Second Feature</h3>
                                        <p class="lead mb-4">Additional content highlight with compelling description text</p>
                                        <a href="#" target="_blank" class="btn btn-light btn-lg">
                                            <i class="fa-brands fa-youtube me-2"></i>Watch Playlist
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/9bZkp7q19f0" 
                                                title="Example Video 2"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen 
                                                loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Example Slide 3 - Pink Gradient -->
                        <div class="carousel-item">
                            <div class="row g-0 bg-gradient p-4 text-white align-items-center" style="min-height: 400px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <div class="col-md-5 d-flex align-items-center p-3">
                                    <div>
                                        <h3 class="display-6 fw-bold mb-3">Third Highlight</h3>
                                        <p class="lead mb-4">Final featured content with engaging preview description</p>
                                        <a href="#" target="_blank" class="btn btn-light btn-lg">
                                            <i class="fa-brands fa-youtube me-2"></i>Watch Playlist
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/kJQP7kiw5Fk" 
                                                title="Example Video 3"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen 
                                                loading="lazy"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#themeDemoCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#themeDemoCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="code-preview mt-4">
<strong>HTML Structure:</strong>
&lt;div id="featuredCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel"&gt;
  &lt;div class="carousel-indicators"&gt;...&lt;/div&gt;
  &lt;div class="carousel-inner rounded"&gt;
    &lt;div class="carousel-item active"&gt;
      &lt;div class="row g-0 bg-gradient p-4 text-white align-items-center" 
           style="min-height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"&gt;
        &lt;div class="col-md-5"&gt;...title, description, button...&lt;/div&gt;
        &lt;div class="col-md-7"&gt;
          &lt;div class="ratio ratio-16x9"&gt;
            &lt;iframe src="..."&gt;&lt;/iframe&gt;
          &lt;/div&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;button class="carousel-control-prev"&gt;...&lt;/button&gt;
  &lt;button class="carousel-control-next"&gt;...&lt;/button&gt;
&lt;/div&gt;

<strong>Key Bootstrap Classes:</strong>
- .carousel, .carousel-slide: Core carousel structure
- .carousel-indicators: Dots navigation at bottom
- .carousel-inner: Container for slides
- .carousel-item: Individual slide (add .active to first)
- .carousel-control-prev/next: Arrow navigation buttons
- .ratio-16x9: Maintains video aspect ratio

<strong>Responsive Behavior:</strong>
- Mobile: Stacks vertically (text above video)
- Desktop: Side-by-side layout (5/7 column split)
- Auto-plays on page load with data-bs-ride="carousel"
                </div>
            </div>

            <div class="alert alert-success mt-4">
                <h5 class="mb-2"><i class="fa-solid fa-check-circle me-2"></i>Best Practices</h5>
                <ul class="mb-0">
                    <li>Use unique carousel IDs for multiple carousels on same page</li>
                    <li>Add aria-labels to carousel controls for accessibility</li>
                    <li>Include loading="lazy" on iframes for performance</li>
                    <li>Use gradient backgrounds with sufficient contrast for white text (WCAG AA)</li>
                    <li>Test on mobile devices to ensure text remains readable when stacked</li>
                </ul>
            </div>
        </section>

        <!-- Implementation Notes -->
        <section class="theme-section bg-pastel">
            <h2 class="display-5 mb-4">📚 Implementation Notes</h2>
            
            <div class="alert alert-info">
                <h4 class="alert-heading"><i class="fa-solid fa-circle-info me-2"></i>Bootstrap 5.3.8 Implementation</h4>
                <p><strong>File:</strong> <code>storage/docs/BOOTSTRAP-5.3.8.md</code></p>
                <ul class="mb-0">
                    <li>Uses CDN with SRI hash verification for security</li>
                    <li>Dark mode enabled globally via <code>data-bs-theme="dark"</code></li>
                    <li>Custom CSS extends Bootstrap without overriding core components</li>
                    <li>Mobile-first responsive design (iPhone 390px optimized)</li>
                    <li>All 14 JavaScript files verified Bootstrap 5.3.8 compatible</li>
                </ul>
            </div>

            <div class="alert alert-success">
                <h4 class="alert-heading"><i class="fa-solid fa-palette me-2"></i>FontAwesome 6.7.2 Integration</h4>
                <p><strong>File:</strong> <code>storage/docs/FONTAWESOME-SVGS.md</code></p>
                <ul class="mb-0">
                    <li>Loaded via <code>fontawesome-all.min.css</code> in <code>includes/head.php</code></li>
                    <li>Used in <code>sitemap.php</code> and <code>services.php</code></li>
                    <li>Em-based sizing: 0.875em (sm), 1em (default), 1.25em (lg)</li>
                    <li>Supports solid, brands, and regular icon sets</li>
                    <li>Animation support: fa-spin, fa-beat, custom durations</li>
                </ul>
            </div>

            <div class="alert alert-warning">
                <h4 class="alert-heading"><i class="fa-solid fa-wrench me-2"></i>Minification Pipeline</h4>
                <p><strong>File:</strong> <code>scripts/optimize-assets.ps1</code></p>
                <ul class="mb-0">
                    <li>Called by <code>build-all.ps1</code> in STEP 2.5</li>
                    <li>PurgeCSS removes unused Bootstrap/FontAwesome CSS</li>
                    <li>CSS minification: ~32-39% file size reduction</li>
                    <li>JavaScript minification: ~62% average reduction</li>
                    <li>Total savings: ~40KB+ per page load</li>
                </ul>
            </div>
        </section>

        <!-- ====================================================================
             SUBDIRECTORY PAGES (/game/ and /blog/)
             ==================================================================== -->
        <section id="subdirectory-pages" class="theme-section bg-pastel">
            <h2 class="mb-4"><i class="fa-solid fa-folder-tree me-2"></i>Subdirectory Pages: /game/ and /blog/</h2>
            
            <div class="alert alert-info">
                <h4 class="alert-heading"><i class="fa-solid fa-circle-info me-2"></i>RES_ROOT Path Resolution</h4>
                <p><strong>Why it matters:</strong> Pages in subdirectories need correct paths to /resources/</p>
                <div class="code-preview mt-3">
<strong>Root-level pages (index.php, gamedev.php):</strong>
&lt;?php define('RES_ROOT', '/resources'); ?&gt;
&lt;img src="&lt;?= RES_ROOT ?&gt;/images/logo.png"&gt;  
<!-- Resolves to: /resources/images/logo.png -->

<strong>Subdirectory pages (/game/jennistyles.php, /blog/pax-west.php):</strong>
&lt;?php 
  include __DIR__ . '/../includes/head.php';  // Navigate up one level
?&gt;
&lt;img src="&lt;?= RES_ROOT ?&gt;/images/gamedev/jennistyles/hi.png"&gt;
<!-- Still resolves to: /resources/images/... (browser-relative) -->

<strong>Key Rule:</strong> RES_ROOT uses absolute paths starting with / so it works 
from ANY directory depth. Always use &lt;?= RES_ROOT ?&gt; instead of relative paths.</div>
            </div>

            <div class="alert alert-success">
                <h4 class="alert-heading"><i class="fa-brands fa-youtube me-2"></i>Playlist Grid Integration</h4>
                <p><strong>Files:</strong> <code>resources/js/youtube-grid.js</code> + YAML configs</p>
                <div class="code-preview mt-3">
<strong>1. Create YAML config (e.g., jennistyles.yaml):</strong>
page: jennistyles
title: "Jenni Styles Dress Up Game"
featured_section:
  container_id: "jennistyles-playlists"
  columns:
    xs: 1    # Mobile: 1 column
    sm: 2    # Tablet: 2 columns
    md: 3    # Desktop: 3 columns
  playlists:
    - id: "PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g"
      title: "Jenni Styles Videos"
      icon: "palette"
      tags: ["jennistyles", "flash-game"]

<strong>2. Add container in PHP:</strong>
&lt;div id="jennistyles-playlists" class="row g-4" data-tags="jennistyles,gamedev"&gt;
  &lt;!-- Playlist cards render here --&gt;
&lt;/div&gt;

<strong>3. Load config in JavaScript:</strong>
&lt;script&gt;
  window.YouTubeGrid.loadPageConfig('jennistyles');
&lt;/script&gt;

<strong>Result:</strong> Responsive playlist cards automatically render with:
- Bootstrap 5.3.8 grid layout (col-12 col-md-6 col-lg-4)
- Lazy-loaded thumbnails
- Play button overlays
- Tag filtering support</div>
            </div>

            <div class="alert alert-primary">
                <h4 class="alert-heading"><i class="fa-solid fa-file-code me-2"></i>Blog Posts with YAML Metadata</h4>
                <p><strong>File:</strong> <code>resources/playlists/blog-posts.yaml</code></p>
                <div class="code-preview mt-3">
<strong>YAML Structure:</strong>
- slug: pax-west-gaming-con
  title: "PAX West 2025: My Experience"
  date: "2025-03-15"
  category: "Gaming & Events"
  excerpt: "Join me as I share my PAX West adventure..."
  image: "/blog/pax-west-2024.jpg"  # Path relative to /resources/images/
  tags: ["gaming", "conventions", "pax-west"]
  playlist: "PL9QBjNDhgNwRIS4WXfKy4oLrPKxoK_Jra"

<strong>Loading in PHP/JavaScript:</strong>
fetch('&lt;?= RES_ROOT ?&gt;/playlists/blog-posts.yaml')
  .then(res =&gt; res.text())
  .then(txt =&gt; jsyaml.load(txt))
  .then(posts =&gt; {
    // Filter by category, tags, or slug
    const gamingPosts = posts.filter(p =&gt; 
      p.tags.includes('gaming')
    );
  });

<strong>Image Resolution:</strong>
image: "/blog/pax-west-2024.jpg"
→ &lt;img src="&lt;?= RES_ROOT ?&gt;/images/blog/pax-west-2024.jpg"&gt;
→ Browser resolves to: /resources/images/blog/pax-west-2024.jpg</div>
            </div>

            <div class="alert alert-secondary">
                <h4 class="alert-heading"><i class="fa-solid fa-sitemap me-2"></i>Directory Structure Best Practices</h4>
                <ul class="mb-0">
                    <li><strong>/game/</strong> - Individual game pages (jennistyles.php, catgame.php, etc.)</li>
                    <li><strong>/blog/</strong> - Blog post pages (pax-west.php, ai-tools.php, etc.)</li>
                    <li><strong>/resources/playlists/</strong> - YAML configs for each page (gamedev.yaml, jennistyles.yaml, blog-posts.yaml)</li>
                    <li><strong>/resources/images/</strong> - All images organized by category (gamedev/, blog/, ai/)</li>
                    <li><strong>includes/</strong> - Shared PHP components (head.php, header.php, footer.php, game-cta-helper.php)</li>
                </ul>
                <div class="code-preview mt-3">
<strong>Example: /game/jennistyles.php structure:</strong>
&lt;?php
include __DIR__ . '/../includes/head.php';          // Go up one level
include __DIR__ . '/../includes/game-cta-helper.php';
?&gt;
&lt;img src="&lt;?= RES_ROOT ?&gt;/images/gamedev/jennistyles/hi.png"&gt;

&lt;div id="jennistyles-playlists" class="row g-4"&gt;&lt;/div&gt;

&lt;script src="&lt;?= RES_ROOT ?&gt;/js/youtube-grid.js"&gt;&lt;/script&gt;
&lt;script&gt;
  window.YouTubeGrid.loadPageConfig('jennistyles');
&lt;/script&gt;

&lt;?php include '../includes/footer.php'; ?&gt;  // Relative path OK for includes</div>
            </div>

            <div class="alert alert-warning">
                <h4 class="alert-heading"><i class="fa-solid fa-triangle-exclamation me-2"></i>Common Pitfalls to Avoid</h4>
                <ul class="mb-0">
                    <li><strong>❌ Relative paths in subdirectories:</strong> <code>../resources/css/custom.css</code> breaks on different depths</li>
                    <li><strong>✅ Use RES_ROOT:</strong> <code>&lt;?= RES_ROOT ?&gt;/css/custom.css</code> works everywhere</li>
                    <li><strong>❌ Hardcoded domains:</strong> <code>https://jenninexus.com/resources/</code> fails in dev</li>
                    <li><strong>✅ Root-relative paths:</strong> <code>/resources/</code> works in dev and production</li>
                    <li><strong>❌ Missing YAML config:</strong> Playlists won't render without matching .yaml file</li>
                    <li><strong>✅ Create YAML first:</strong> Copy gamedev.yaml structure and customize</li>
                    <li><strong>❌ Duplicate container IDs:</strong> youtube-grid.js needs unique IDs per section</li>
                    <li><strong>✅ Naming convention:</strong> <code>{page}-playlists</code> (e.g., jennistyles-playlists)</li>
                </ul>
            </div>
        </section>

        <!-- End of Implementation Notes -->
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>