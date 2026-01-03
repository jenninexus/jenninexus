<?php
/**
 * Button Showcase - Development & Testing Only
 * 
 * Purpose: Comprehensive showcase of ALL button patterns used across JenniNexus
 * 
 * IMPORTANT: This page is for LOCAL DEVELOPMENT ONLY
 * Not included in deployment manifest - excluded by deploy.ps1
 * 
 * Last Updated: December 25, 2025
 * Bootstrap Version: 5.3.3 (5.3.8 methodology)
 * Bootstrap Icons: 1.11.3
 * FontAwesome Version: 6.7.2
 * 
 * 🎯 NEW: Sitewide Protocol - Theme-Adaptive Platform Colors (Section 4)
 * All platform buttons maintain brand identity across light/dark modes
 * with adaptive shadows, glows, and hover effects.
 */

define('RES_ROOT', '/resources');

// Check if running locally (basic security check)
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;

if (!$isLocal && !isset($_GET['force'])) {
    http_response_code(404);
    die('Page not found');
}

$pageTitle = "Button Showcase - JenniNexus Development";
$pageDescription = "Comprehensive showcase of all button patterns, sizes, and styles used across JenniNexus";
$activePage = 'buttons-demo';

// Additional theme CSS files for demo purposes
$customCSS = [
    RES_ROOT . '/css/home-theme.css',
    RES_ROOT . '/css/diy-theme.css',
    RES_ROOT . '/css/gamedev-theme.css',
    RES_ROOT . '/css/patreon-theme.css',
    RES_ROOT . '/css/pastel-backgrounds.css'
];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/../includes/head.php'; ?>
<body class="theme-demo-page">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <style>
        /* Demo-specific styling */
        .showcase-section {
            background: var(--background-elevated);
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--glass-border);
        }
        
        /* Enhanced Dark Mode Glows for Demo */
        :root[data-bs-theme="dark"] .btn-outline-youtube:hover {
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
            border-color: #ff0000;
            color: #ff0000;
            background: transparent;
        }
        
        :root[data-bs-theme="dark"] .btn-outline-twitch:hover {
            box-shadow: 0 0 15px rgba(145, 70, 255, 0.4);
            border-color: #9146FF;
            color: #9146FF;
            background: transparent;
        }
        
        :root[data-bs-theme="dark"] .btn-outline-discord:hover {
            box-shadow: 0 0 15px rgba(88, 101, 242, 0.4);
            border-color: #5865F2;
            color: #5865F2;
            background: transparent;
        }

        /* Ensure vertical centering is explicit */
        .btn i, .btn svg, .btn .bi {
            vertical-align: middle;
            margin-top: -1px; /* Micro-adjustment for perfect visual center */
        }
        
        .code-preview {
            background: var(--bs-dark-bg-subtle);
            color: var(--bs-light-text-emphasis);
            padding: 1rem;
            border-radius: 0.375rem;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.875rem;
            overflow-x: auto;
            white-space: pre;
            margin-top: 1rem;
        }
        
        :root[data-bs-theme="light"] .code-preview {
            background: #f8f9fa;
            color: #212529;
        }
        
        .button-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .button-demo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        :root[data-bs-theme="light"] .button-demo {
            background: rgba(0, 0, 0, 0.03);
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        .button-label {
            font-size: 0.75rem;
            color: var(--bs-secondary-color);
            font-family: 'Consolas', monospace;
            margin-top: 0.5rem;
        }
        
        /* Social icon buttons (square) */
        .social-icon-square {
            width: 64px;
            height: 64px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (min-width: 768px) and (max-width: 991px) {
            .social-icon-square {
                width: 68px;
                height: 68px;
            }
        }
        
        @media (min-width: 992px) {
            .social-icon-square {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>
    
    <main class="container mb-5 pb-5" style="padding-top: 80px;">
        <!-- Development Notice -->
        <div class="alert alert-warning mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Development Only:</strong> This page showcases button patterns used across JenniNexus. Not included in production deployment.
        </div>
        
        <!-- Page Header -->
        <div class="mb-5 text-center">
            <h1 class="display-4 fw-bold mb-3">Button Showcase</h1>
            <p class="lead">Comprehensive reference for all button patterns, sizes, and styles</p>
            <div class="alert alert-success d-inline-block mt-2">
                <i class="bi bi-star-fill me-2"></i><strong>NEW:</strong> Theme-Adaptive Platform Colors (Section 4) - Color change + glow on hover
            </div>
        </div>

        <!-- Usage Frequency Summary -->
        <div class="alert alert-primary mb-5">
            <h3 class="alert-heading"><i class="bi bi-bar-chart-fill me-2"></i>Usage Frequency Guide</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>⭐ Most Used (~80%)</h5>
                    <ul class="mb-3">
                        <li><strong>Outline Buttons:</strong> btn-outline-* pattern</li>
                        <li>Used for: CTAs, navigation, platform links, filters</li>
                        <li>Why: Clean, modern, works perfectly with dark mode</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>⭐ Very Common (~15%)</h5>
                    <ul class="mb-3">
                        <li><strong>Platform Buttons:</strong> YouTube, Discord, Steam, Patreon</li>
                        <li><strong>Social Icons:</strong> Square 64-80px icon-only buttons</li>
                        <li><strong>Tag Filters:</strong> Small outline buttons with badges</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Specialized (~5%)</h5>
                    <ul class="mb-0">
                        <li><strong>Pill Buttons:</strong> DIY page branded social buttons (YouTube, Instagram, TikTok)</li>
                        <li><strong>Solid Buttons:</strong> Occasional primary/danger for critical actions</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Table of Contents -->
        <nav class="mb-5">
            <h3>Quick Navigation</h3>
            <ul class="list-unstyled ms-3">
                <li><a href="#standard-buttons">1. Standard Bootstrap Buttons</a></li>
                <li><a href="#outline-buttons">2. Outline Buttons</a> <span class="badge bg-success">⭐ MOST USED</span></li>
                <li><a href="#social-icons">3. Social Icon Buttons (Square)</a> <span class="badge bg-info">Common</span></li>
                <li><a href="#theme-adaptive-colors">4. Theme-Adaptive Platform Colors</a> <span class="badge bg-success">🎯 NEW</span></li>
                <li><a href="#social-pills">5. Social Pill Buttons (DIY Style)</a></li>
                <li><a href="#platform-buttons">6. Platform-Specific Buttons (Legacy)</a></li>
                <li><a href="#tag-filter">7. Tag Filter Buttons</a> <span class="badge bg-info">Common</span></li>
                <li><a href="#responsive-sizing">8. Responsive Sizing Patterns</a></li>
                <li><a href="#icon-positioning">9. Icon + Text Patterns</a> <span class="badge bg-primary">Best Practice</span></li>
                <li><a href="#usage-locations">10. Where Each Pattern is Used</a></li>
            </ul>
        </nav>

        <!-- ====================================================================
             1. STANDARD BOOTSTRAP BUTTONS
             ==================================================================== -->
        <section id="standard-buttons" class="showcase-section bg-pastel">
            <h2 class="mb-4">1. Standard Bootstrap Buttons</h2>
            <p>Default Bootstrap 5.3.8 button styles with flexbox alignment for icons</p>
            
            <div class="button-grid">
                <div class="button-demo">
                    <button class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Primary
                    </button>
                    <span class="button-label">.btn-primary</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-secondary">
                        <i class="bi bi-gear"></i> Secondary
                    </button>
                    <span class="button-label">.btn-secondary</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-success">
                        <i class="bi bi-check-lg"></i> Success
                    </button>
                    <span class="button-label">.btn-success</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-danger">
                        <i class="bi bi-x-circle"></i> Danger
                    </button>
                    <span class="button-label">.btn-danger</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-warning">
                        <i class="bi bi-exclamation-triangle"></i> Warning
                    </button>
                    <span class="button-label">.btn-warning</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-info">
                        <i class="bi bi-info-circle"></i> Info
                    </button>
                    <span class="button-label">.btn-info</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-light">
                        <i class="bi bi-sun"></i> Light
                    </button>
                    <span class="button-label">.btn-light</span>
                </div>
                
                <div class="button-demo">
                    <button class="btn btn-dark">
                        <i class="bi bi-moon"></i> Dark
                    </button>
                    <span class="button-label">.btn-dark</span>
                </div>
            </div>
            
            <div class="code-preview">
&lt;button class="btn btn-primary"&gt;
  &lt;i class="bi bi-check-circle"&gt;&lt;/i&gt; Primary
&lt;/button&gt;

/* Icons auto-align with flexbox - NO me-1/me-2 margin classes needed */
/* Gap is handled by custom.css: gap: 0.375rem */</div>
        </section>

        <!-- ====================================================================
             2. OUTLINE BUTTONS ⭐ MOST USED
             ==================================================================== -->
        <section id="outline-buttons" class="showcase-section bg-pastel">
            <div class="alert alert-success mb-4">
                <h3 class="alert-heading"><i class="bi bi-star-fill me-2"></i>Most Used Pattern ⭐</h3>
                <p class="mb-2"><strong>Usage:</strong> ~80% of all buttons across JenniNexus use this pattern</p>
                <p class="mb-0"><strong>Why:</strong> Cleaner, modern look with transparent background. Provides strong visual hierarchy without being too heavy. Works perfectly with dark mode.</p>
            </div>
            <h2 class="mb-4">2. Outline Buttons</h2>
            <p><strong>Primary Pattern:</strong> Transparent background with colored border and text. Fills on hover.</p>
            
            <div class="button-grid">
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-right"></i> Primary
                    </a>
                    <span class="button-label">Used: Blog, LinkedIn</span>
                </div>
                
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-funnel"></i> Secondary
                    </a>
                    <span class="button-label">Used: Filters, Index</span>
                </div>
                
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-success">
                        <i class="bi bi-discord"></i> Success
                    </a>
                    <span class="button-label">Used: Discord Links</span>
                </div>
                
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-danger">
                        <i class="bi bi-youtube"></i> Danger
                    </a>
                    <span class="button-label">Used: YouTube Subscribe</span>
                </div>
                
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-warning">
                        <i class="bi bi-discord"></i> Warning
                    </a>
                    <span class="button-label">Used: Discord (Alternate)</span>
                </div>
                
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-light">
                        <i class="bi bi-house"></i> Light
                    </a>
                    <span class="button-label">Used: Hero CTAs, Footer</span>
                </div>
                
                <div class="button-demo">
                    <a href="#" class="btn btn-outline-dark">
                        <i class="fa-brands fa-itch-io"></i> Dark
                    </a>
                    <span class="button-label">Used: Itch.io Links</span>
                </div>
            </div>
            
            <h4 class="mt-4">Size Variants</h4>
            <div class="d-flex gap-3 align-items-center justify-content-center mt-3">
                <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-filter"></i> Small
                </button>
                <button class="btn btn-outline-primary">
                    <i class="bi bi-filter"></i> Default
                </button>
                <button class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-filter"></i> Large
                </button>
            </div>
            
            <div class="code-preview">
/* Small Button (Tag Filter, Footer) */
&lt;button class="btn btn-outline-primary btn-sm"&gt;
  &lt;i class="bi bi-filter"&gt;&lt;/i&gt; Small
&lt;/button&gt;

/* Default Button (Most CTAs) */
&lt;a href="#" class="btn btn-outline-danger"&gt;
  &lt;i class="bi bi-youtube"&gt;&lt;/i&gt; Subscribe
&lt;/a&gt;

/* Large Button (Hero Section, DIY) */
&lt;a href="#" class="btn btn-outline-secondary btn-lg px-4"&gt;
  YouTube Channels
&lt;/a&gt;</div>
        </section>

        <!-- ====================================================================
             3. SOCIAL ICON BUTTONS (SQUARE) ⭐ COMMON
             ==================================================================== -->
        <section id="social-icons" class="showcase-section bg-pastel">
            <h2 class="mb-4">3. Social Icon Buttons (Square) <span class="badge bg-info">Common</span></h2>
            <p><strong>Usage:</strong> index.php hero section, footer social links</p>
            <p>Icon-only, responsive square buttons that scale across breakpoints</p>
            
            <h4>Mobile (64px) → Tablet (68px) → Desktop (80px)</h4>
            <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                <a href="#" class="btn btn-outline-light btn-lg social-icon-square" title="YouTube">
                    <i class="bi bi-youtube" style="font-size: 2.25rem;"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-lg social-icon-square" title="Twitch">
                    <i class="bi bi-twitch" style="font-size: 2.25rem;"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-lg social-icon-square" title="LinkedIn">
                    <i class="bi bi-linkedin" style="font-size: 2.25rem;"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-lg social-icon-square" title="GitHub">
                    <i class="bi bi-github" style="font-size: 2.25rem;"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-lg social-icon-square" title="Email">
                    <i class="bi bi-envelope-fill" style="font-size: 2.25rem;"></i>
                </a>
                <a href="#" class="btn btn-outline-light btn-lg social-icon-square" title="Discord">
                    <i class="bi bi-discord" style="font-size: 2.25rem;"></i>
                </a>
            </div>
            
            <div class="code-preview">
/* Mobile: 64px buttons, 2.25rem icons */
&lt;a href="https://youtube.com/@jenninexus" 
   target="_blank" 
   class="btn btn-outline-light btn-lg d-flex align-items-center justify-content-center" 
   title="YouTube" 
   style="width: 64px; height: 64px;"&gt;
  &lt;i class="bi bi-youtube" style="font-size: 2.25rem;"&gt;&lt;/i&gt;
&lt;/a&gt;

/* Tablet (768-991px): 68px buttons, 2.5rem icons */
@media (min-width: 768px) and (max-width: 991px) {
  .social-links a { width: 68px; height: 68px; }
  .social-links a i { font-size: 2.5rem; }
}

/* Desktop (992px+): 80px buttons, 3.5rem icons */
@media (min-width: 992px) {
  .social-links a { width: 80px !important; height: 80px !important; }
  .social-links a i { font-size: 3.5rem !important; }
}</div>
        </section>

        <!-- ====================================================================
             4. THEME-ADAPTIVE PLATFORM COLORS 🎯 NEW
             ==================================================================== -->
        <section id="theme-adaptive-colors" class="showcase-section bg-pastel">
            <div class="alert alert-success mb-4">
                <h3 class="alert-heading"><i class="bi bi-palette-fill me-2"></i>🎯 Sitewide Protocol: Theme-Adaptive Platform Colors</h3>
                <p class="mb-2"><strong>Updated:</strong> December 25, 2025</p>
                <p class="mb-2"><strong>Key Principle:</strong> Platform brand colors remain consistent across light/dark themes, but shadows, glows, and contrast adapt automatically.</p>
                <p class="mb-0"><strong>Hover Effects:</strong> Color change + glow + smooth lift (translateY -2px) + 0.3s ease transitions</p>
            </div>
            
            <h2 class="mb-4">4. Theme-Adaptive Platform Colors</h2>
            <p>All platform buttons maintain brand identity while adapting shadows/glows to the active theme</p>
            
            <h4 class="mt-4">🎨 Platform Color Reference</h4>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card h-100 bg-glass-light border-theme-accent">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0"><i class="bi bi-youtube me-2"></i>YouTube</h6>
                        </div>
                        <div class="card-body small">
                            <p class="mb-2"><strong>Primary:</strong> <code>--youtube-red: #ff0000</code></p>
                            <p class="mb-2"><strong>Hover:</strong> <code>--youtube-red-dark: #cc0000</code></p>
                            <p class="mb-0"><strong>Glow:</strong> rgba(255, 0, 0, 0.4-0.6)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 bg-glass-light border-theme-accent">
                        <div class="card-header text-white" style="background-color: #5865F2;">
                            <h6 class="mb-0"><i class="bi bi-discord me-2"></i>Discord</h6>
                        </div>
                        <div class="card-body small">
                            <p class="mb-2"><strong>Primary:</strong> <code>--discord-blurple: #5865F2</code></p>
                            <p class="mb-2"><strong>Hover:</strong> <code>--discord-blurple-dark: #4752c4</code></p>
                            <p class="mb-0"><strong>Glow:</strong> rgba(88, 101, 242, 0.5-0.6)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 bg-glass-light border-theme-accent">
                        <div class="card-header text-white" style="background-color: #9146FF;">
                            <h6 class="mb-0"><i class="bi bi-twitch me-2"></i>Twitch</h6>
                        </div>
                        <div class="card-body small">
                            <p class="mb-2"><strong>Primary:</strong> <code>--twitch-purple: #9146FF</code></p>
                            <p class="mb-2"><strong>Hover:</strong> <code>--twitch-purple-dark: #7c38cc</code></p>
                            <p class="mb-0"><strong>Glow:</strong> rgba(145, 70, 255, 0.5-0.6)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 bg-glass-light border-theme-accent">
                        <div class="card-header text-white" style="background-color: #FF424D;">
                            <h6 class="mb-0"><i class="bi bi-heart-fill me-2"></i>Patreon</h6>
                        </div>
                        <div class="card-body small">
                            <p class="mb-2"><strong>Primary:</strong> <code>--patreon-coral: #FF424D</code></p>
                            <p class="mb-2"><strong>Hover:</strong> <code>--patreon-coral-dark: #e73843</code></p>
                            <p class="mb-0"><strong>Glow:</strong> rgba(255, 66, 77, 0.5-0.6)</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <h4 class="mt-4">Interactive Examples - Solid Buttons</h4>
            <p class="text-muted small">Hover to see color change + glow effect (adapts to current theme)</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <button class="btn btn-youtube">
                    <i class="fa-brands fa-youtube"></i> YouTube
                </button>
                <button class="btn btn-discord">
                    <i class="fa-brands fa-discord"></i> Discord
                </button>
                <button class="btn btn-twitch">
                    <i class="fa-brands fa-twitch"></i> Twitch
                </button>
                <button class="btn btn-patreon">
                    <i class="fa-brands fa-patreon"></i> Patreon
                </button>
                <button class="btn btn-instagram">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </button>
                <button class="btn btn-steam">
                    <i class="fa-brands fa-steam"></i> Steam
                </button>
                <button class="btn btn-spotify">
                    <i class="fa-brands fa-spotify"></i> Spotify
                </button>
                <button class="btn btn-github">
                    <i class="fa-brands fa-github"></i> GitHub
                </button>
            </div>
            
            <h4 class="mt-4">Interactive Examples - Outline Buttons</h4>
            <p class="text-muted small">Transparent → fills with brand color on hover + glow</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <button class="btn btn-outline-youtube">
                    <i class="fa-brands fa-youtube"></i> YouTube
                </button>
                <button class="btn btn-outline-discord">
                    <i class="fa-brands fa-discord"></i> Discord
                </button>
                <button class="btn btn-outline-twitch">
                    <i class="fa-brands fa-twitch"></i> Twitch
                </button>
                <button class="btn btn-outline-patreon">
                    <i class="fa-brands fa-patreon"></i> Patreon
                </button>
                <button class="btn btn-outline-instagram">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </button>
                <button class="btn btn-outline-steam">
                    <i class="fa-brands fa-steam"></i> Steam
                </button>
                <button class="btn btn-outline-spotify">
                    <i class="fa-brands fa-spotify"></i> Spotify
                </button>
                <button class="btn btn-outline-github">
                    <i class="fa-brands fa-github"></i> GitHub
                </button>
            </div>
            
            <div class="alert alert-info mt-4 small mb-0">
                <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Theme Adaptation Details</h6>
                <ul class="mb-0">
                    <li><strong>Light Mode:</strong> Softer shadows (0.4 opacity), subtle contrast</li>
                    <li><strong>Dark Mode:</strong> Enhanced glows (0.6 opacity), stronger visibility</li>
                    <li><strong>Platform Colors:</strong> Never change - maintain brand consistency</li>
                    <li><strong>Hover Effects:</strong> Uniform across all buttons (translateY -2px + glow)</li>
                </ul>
            </div>
        </section>

        <!-- ====================================================================
             5. SOCIAL PILL BUTTONS (DIY STYLE) - THEME ADAPTIVE
             ==================================================================== -->
        <section id="social-pills" class="showcase-section bg-pastel">
            <h2 class="mb-4">5. Social Pill Buttons (DIY Style) <span class="badge bg-info">Theme Adaptive</span></h2>
            <p>Used on diy.php - branded platform colors with rounded-pill styling</p>
            <p class="text-muted small">✨ Platform colors maintained, shadows/glows adapt to light/dark mode</p>
            
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <a href="#" class="btn btn-youtube btn-lg rounded-pill">
                    <i class="fa-brands fa-youtube"></i> Sub on YouTube
                </a>
                <a href="#" class="btn btn-discord btn-lg rounded-pill">
                    <i class="fa-brands fa-discord"></i> Join Discord
                </a>
                <a href="#" class="btn btn-instagram btn-lg rounded-pill">
                    <i class="fa-brands fa-instagram"></i> Follow Instagram
                </a>
                <a href="#" class="btn btn-tiktok btn-lg rounded-pill">
                    <i class="fa-brands fa-tiktok"></i> Watch TikTok
                </a>
            </div>
            
            <div class="code-preview">
/* Platform-specific button classes defined in diy-theme.css AND custom.css */
/* THEME ADAPTIVE: Maintains platform colors while adapting shadows */

&lt;a href="https://www.youtube.com/@diywjenni?sub_confirmation=1" 
   target="_blank" 
   class="btn btn-youtube btn-lg rounded-pill"&gt;
  &lt;i class="fa-brands fa-youtube"&gt;&lt;/i&gt; Sub on YouTube
&lt;/a&gt;

/* Platform Color Variables (all-themes.css) */
:root {
  --youtube-red: #ff0000;
  --discord-blurple: #5865F2;
  --twitch-purple: #9146FF;
  --instagram-magenta: #E4405F;
  --patreon-coral: #FF424D;
}

/* Theme-Adaptive Buttons (diy-theme.css & custom.css) */
.btn-youtube {
  background: linear-gradient(135deg, var(--youtube-red), #cc0000);
  color: white;
  border: none;
}

/* Light mode: softer shadows */
[data-bs-theme="light"] .btn-youtube:hover {
  box-shadow: 0 4px 15px rgba(255, 0, 0, 0.4);
}

/* Dark mode: enhanced glows */
[data-bs-theme="dark"] .btn-youtube:hover {
  box-shadow: 0 6px 20px rgba(255, 0, 0, 0.6);
}

/* Same pattern for Discord, Instagram, etc. */
.btn-discord {
  background: linear-gradient(135deg, var(--discord-blurple), #4752C4);
  color: white;
}

.btn-instagram {
  background: linear-gradient(135deg, #833AB4, #E1306C, #FD1D1D);
  color: white;
}</div>
        </section>

        <!-- ====================================================================
             6. PLATFORM-SPECIFIC BUTTONS (LEGACY REFERENCE)
             ==================================================================== -->
        <section id="platform-buttons" class="showcase-section bg-pastel">
            <h2 class="mb-4">6. Platform-Specific Buttons (Legacy Reference)</h2>
            <p class="text-muted"><strong>Note:</strong> See Section 4 above for the updated theme-adaptive platform color showcase. This section remains for code reference.</p>
            <p><strong>Usage:</strong> YouTube Subscribe, Discord Join, Steam links, Patreon CTAs</p>
            <p>Custom branded buttons for various platforms across the site</p>
            <p class="text-muted small">✨ All platform buttons maintain brand colors while shadows/glows adapt to active theme</p>
            
            <h4>Solid Platform Buttons (Primary Style)</h4>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <a href="#" class="btn btn-youtube">
                    <i class="fa-brands fa-youtube"></i> YouTube
                </a>
                <a href="#" class="btn btn-discord">
                    <i class="fa-brands fa-discord"></i> Discord
                </a>
                <a href="#" class="btn btn-twitch">
                    <i class="fa-brands fa-twitch"></i> Twitch
                </a>
                <a href="#" class="btn btn-patreon">
                    <i class="fa-brands fa-patreon"></i> Patreon
                </a>
                <a href="#" class="btn btn-instagram">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </a>
                <a href="#" class="btn btn-steam">
                    <i class="fa-brands fa-steam"></i> Steam
                </a>
                <a href="#" class="btn btn-tiktok">
                    <i class="fa-brands fa-tiktok"></i> TikTok
                </a>
                <a href="#" class="btn btn-github">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </div>
            
            <h4 class="mt-4">Outline Platform Buttons (Secondary Style)</h4>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <a href="#" class="btn btn-outline-youtube">
                    <i class="fa-brands fa-youtube"></i> YouTube
                </a>
                <a href="#" class="btn btn-outline-discord">
                    <i class="fa-brands fa-discord"></i> Discord
                </a>
                <a href="#" class="btn btn-outline-twitch">
                    <i class="fa-brands fa-twitch"></i> Twitch
                </a>
                <a href="#" class="btn btn-outline-patreon">
                    <i class="fa-brands fa-patreon"></i> Patreon
                </a>
                <a href="#" class="btn btn-outline-instagram">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </a>
                <a href="#" class="btn btn-outline-steam">
                    <i class="fa-brands fa-steam"></i> Steam
                </a>
                <a href="#" class="btn btn-outline-tiktok">
                    <i class="fa-brands fa-tiktok"></i> TikTok
                </a>
                <a href="#" class="btn btn-outline-github">
                    <i class="fa-brands fa-github"></i> GitHub
                </a>
            </div>
            
            <div class="code-preview">
/* Platform Colors (all-themes.css) */
:root {
  --youtube-red: #ff0000;
  --discord-blurple: #5865F2;
  --twitch-purple: #9146FF;
  --patreon-coral: #FF424D;
  --instagram-magenta: #E4405F;
  --steam-blue: #66c0f4;
  --steam-navy: #1b2838;
  --tiktok-black: #000000;
  --tiktok-pink: #ff0050;
  --github-dark: #333333;
}

/* Solid Buttons (custom.css with gradient enhancements) */
.btn-youtube {
  background: linear-gradient(135deg, var(--youtube-red), #cc0000);
  color: white;
}

.btn-steam {
  background: linear-gradient(135deg, var(--steam-navy), var(--steam-blue));
  color: var(--steam-blue);
  border: 2px solid var(--steam-blue);
}

/* Outline Buttons (all-themes.css) */
.btn-outline-youtube {
  color: var(--youtube-red);
  border-color: var(--youtube-red);
}

.btn-outline-youtube:hover {
  background-color: var(--youtube-red);
  color: white;
}</div>
        </section>

        <!-- ====================================================================
             7. TAG FILTER BUTTONS ⭐ COMMON
             ==================================================================== -->
        <section id="tag-filter" class="showcase-section bg-pastel">
            <h2 class="mb-4">7. Tag Filter Buttons <span class="badge bg-info">Common</span></h2>
            <p><strong>Usage:</strong> Offcanvas tag filters on index.php, diy.php, tags.php, gaming.php, gamedev.php</p>
            <p>Small outline buttons with badges for filtering content by tags</p>
            
            <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-funnel"></i> Filter Tags
                </button>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </button>
                <span class="badge bg-primary rounded-pill px-3 py-2">gaming</span>
                <span class="badge bg-secondary rounded-pill px-3 py-2">tutorials</span>
                <span class="badge bg-info rounded-pill px-3 py-2">live-streams</span>
            </div>
            
            <div class="code-preview">
/* Tag Filter Toggle Button */
&lt;button class="btn btn-outline-primary btn-sm" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#tagFilterOffcanvas"&gt;
  &lt;i class="bi bi-funnel"&gt;&lt;/i&gt; Filter Tags
&lt;/button&gt;

/* Clear Filters Button */
&lt;button id="clearFilters" class="btn btn-outline-secondary btn-sm"&gt;
  &lt;i class="bi bi-x-circle"&gt;&lt;/i&gt; Clear
&lt;/button&gt;

/* Tag Badges (clickable filters) */
/* Use d-inline-flex and align-items-center for perfect vertical centering */
&lt;span class="badge bg-primary rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2" 
      data-tag="gaming" 
      style="cursor: pointer;"&gt;
  &lt;i class="bi bi-controller"&gt;&lt;/i&gt;
  gaming
  &lt;span class="badge bg-white text-primary rounded-pill"&gt;36&lt;/span&gt;
&lt;/span&gt;</div>
        </section>

        <!-- ====================================================================
             8. RESPONSIVE SIZING PATTERNS
             ==================================================================== -->
        <section id="responsive-sizing" class="showcase-section bg-pastel">
            <h2 class="mb-4">8. Responsive Sizing Patterns</h2>
            <p>How buttons adapt across mobile, tablet, and desktop</p>
            
            <h4>Pattern 1: Standard Responsive (Most Buttons)</h4>
            <div class="alert alert-info">
                <strong>Mobile (< 576px):</strong> Larger text (1rem), more padding (0.75rem 1.25rem)<br>
                <strong>Tablet (576-768px):</strong> Medium sizing (0.9375rem, 0.625rem 1.125rem)<br>
                <strong>Desktop (≥ 768px):</strong> Bootstrap defaults
            </div>
            
            <h4>Pattern 2: Social Icons (Index Hero)</h4>
            <div class="alert alert-info">
                <strong>Mobile (< 768px):</strong> 64px × 64px, 2.25rem icons<br>
                <strong>Tablet (768-991px):</strong> 68px × 68px, 2.5rem icons<br>
                <strong>Desktop (≥ 992px):</strong> 80px × 80px, 3.5rem icons
            </div>
            
            <h4>Pattern 3: Hero CTAs (Fixed Size)</h4>
            <div class="alert alert-info">
                <strong>All Screens:</strong> .btn-lg with .px-4 padding for consistent prominent CTAs
            </div>
            
            <div class="code-preview">
/* Standard Responsive Pattern (custom.css) */
@media (max-width: 575.98px) {
  .btn {
    font-size: 1rem;
    padding: 0.75rem 1.25rem;
  }
}

@media (min-width: 576px) and (max-width: 767.98px) {
  .btn {
    font-size: 0.9375rem;
    padding: 0.625rem 1.125rem;
  }
}

/* Social Icon Pattern (index.php inline styles) */
.social-links a {
  width: 64px;
  height: 64px;
}

@media (min-width: 768px) and (max-width: 991px) {
  .social-links a {
    width: 68px;
    height: 68px;
  }
}

@media (min-width: 992px) {
  .social-links a {
    width: 80px !important;
    height: 80px !important;
  }
}</div>
        </section>

        <!-- ====================================================================
             9. ICON + TEXT PATTERNS ⭐ BEST PRACTICE
             ==================================================================== -->
        <section id="icon-positioning" class="showcase-section bg-pastel">
            <div class="alert alert-primary mb-4">
                <h3 class="alert-heading"><i class="bi bi-lightbulb-fill me-2"></i>Best Practice</h3>
                <p class="mb-0"><strong>Key Rule:</strong> Never add .me-1/.me-2/.ms-2 margin classes. Flexbox gap handles all icon spacing automatically via custom.css.</p>
            </div>
            <h2 class="mb-4">9. Icon + Text Patterns</h2>
            <p>Proper flexbox alignment - NO manual margin classes needed</p>
            
            <h4>✅ CORRECT: Use Flexbox Gap</h4>
            <div class="d-flex flex-wrap gap-3 justify-content-center mt-3">
                <button class="btn btn-primary">
                    <i class="bi bi-play-fill"></i> Play Video
                </button>
                <button class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Confirm
                </button>
                <button class="btn btn-danger">
                    <i class="bi bi-x-lg"></i> Cancel
                </button>
            </div>
            
            <div class="code-preview">
/* ✅ CORRECT - Flexbox handles spacing automatically */
&lt;button class="btn btn-primary"&gt;
  &lt;i class="bi bi-play-fill"&gt;&lt;/i&gt; Play Video
&lt;/button&gt;

/* custom.css sets gap: 0.375rem on all buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
}</div>
            
            <h4 class="mt-4">❌ WRONG: Manual Margin Classes</h4>
            <div class="alert alert-danger">
                <strong>Don't do this:</strong> Adding .me-1, .me-2, .ms-2 classes is redundant and breaks consistency
            </div>
            
            <div class="code-preview">
/* ❌ WRONG - Manual margins are unnecessary */
&lt;button class="btn btn-primary"&gt;
  &lt;i class="bi bi-play-fill me-2"&gt;&lt;/i&gt; Play Video
&lt;/button&gt;

/* Gap handles spacing, margin classes are redundant */</div>
        </section>

        <!-- ====================================================================
             10. WHERE EACH PATTERN IS USED
             ==================================================================== -->
        <section id="usage-locations" class="showcase-section bg-pastel">
            <h2 class="mb-4">10. Where Each Pattern is Used</h2>
            
            <h4>Square Social Icons (64-80px)</h4>
            <ul>
                <li><strong>index.php</strong> - Hero section social links (lines 32-50)</li>
            </ul>
            
            <h4>Pill Social Buttons (rounded-pill)</h4>
            <ul>
                <li><strong>diy.php</strong> - Hero CTAs (YouTube, Discord, Instagram, TikTok)</li>
            </ul>
            
            <h4>Outline Buttons (btn-outline-*)</h4>
            <ul>
                <li><strong>index.php</strong> - Channel CTAs, Discord links, footer services button</li>
                <li><strong>footer.php</strong> - Services button (btn-outline-light btn-sm)</li>
                <li><strong>blog.php</strong> - "Read More" buttons</li>
                <li><strong>game/*.php</strong> - Platform links (Steam, GameJolt, Kotaku)</li>
                <li><strong>gamejams.php</strong> - Itch.io CTA, clear filters</li>
            </ul>
            
            <h4>Tag Filter Buttons</h4>
            <ul>
                <li><strong>index.php</strong> - Tag filter offcanvas toggle, clear button</li>
                <li><strong>diy.php</strong> - Tag filter system</li>
                <li><strong>tags.php</strong> - Tag management interface</li>
            </ul>
            
            <h4>Platform-Specific Buttons</h4>
            <ul>
                <li><strong>martiangames.php</strong> - Steam button (btn-steam)</li>
                <li><strong>patreon.php</strong> - Patreon buttons (btn-patreon-coral)</li>
                <li><strong>gamedev.php</strong> - Steam, YouTube platform buttons</li>
            </ul>
            
            <h4>Standard CTAs</h4>
            <ul>
                <li><strong>All pages</strong> - "Back to [Page]" navigation buttons</li>
                <li><strong>Blog posts</strong> - Social share buttons</li>
                <li><strong>Resume section</strong> - LinkedIn, Services buttons</li>
            </ul>
        </section>

        <!-- Implementation Best Practices -->
        <section class="showcase-section bg-pastel">
            <h2 class="mb-4">Implementation Best Practices</h2>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <h4 class="text-success">✅ DO</h4>
                    <ul>
                        <li>Use flexbox gap for icon spacing (automatic)</li>
                        <li>Use em-based icon sizing (scales with button text)</li>
                        <li>Use Bootstrap utility classes (.btn-lg, .btn-sm)</li>
                        <li>Test on mobile (390px iPhone), tablet (768px), desktop (1920px)</li>
                        <li>Use .rounded-pill for DIY page branded buttons</li>
                        <li>Use .d-flex .align-items-center for consistent alignment</li>
                        <li>Follow responsive patterns from custom.css</li>
                    </ul>
                </div>
                
                <div class="col-md-6">
                    <h4 class="text-danger">❌ DON'T</h4>
                    <ul>
                        <li>Add manual margin classes (.me-1, .me-2, .ms-2)</li>
                        <li>Hard-code pixel font sizes (use em/rem)</li>
                        <li>Override Bootstrap flex defaults unnecessarily</li>
                        <li>Mix Bootstrap Icons and FontAwesome in same button</li>
                        <li>Create new button styles without documenting here</li>
                        <li>Use inline styles except for responsive social icons</li>
                        <li>Forget to test button hover states in light/dark modes</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Quick Reference -->
        <section class="showcase-section bg-pastel">
            <h2 class="mb-4">Quick Reference</h2>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pattern</th>
                            <th>Classes</th>
                            <th>Icon Library</th>
                            <th>Used On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Square Social Icons</td>
                            <td>.btn-outline-light .btn-lg</td>
                            <td>Bootstrap Icons</td>
                            <td>index.php hero</td>
                        </tr>
                        <tr>
                            <td>Pill Social Buttons</td>
                            <td>.btn-youtube .btn-lg .rounded-pill</td>
                            <td>FontAwesome Brands</td>
                            <td>diy.php hero</td>
                        </tr>
                        <tr>
                            <td>Standard CTAs</td>
                            <td>.btn-outline-danger</td>
                            <td>Bootstrap Icons</td>
                            <td>YouTube subscribe links</td>
                        </tr>
                        <tr>
                            <td>Tag Filters</td>
                            <td>.btn-outline-primary .btn-sm</td>
                            <td>Bootstrap Icons</td>
                            <td>Offcanvas tag filters</td>
                        </tr>
                        <tr>
                            <td>Platform Buttons</td>
                            <td>.btn-steam</td>
                            <td>FontAwesome Brands</td>
                            <td>Game pages</td>
                        </tr>
                        <tr>
                            <td>Clear Buttons</td>
                            <td>.btn-outline-secondary</td>
                            <td>Bootstrap Icons</td>
                            <td>Filter clear actions</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
