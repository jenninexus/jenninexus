# Page Architecture & Templates - JenniNexus
**Last Updated:** January 2, 2026  
**Status:** ✅ COMPREHENSIVE REFERENCE  
**Purpose:** Complete documentation of page structure, templates, components, asset inclusion patterns, and YAML configuration system

---

## 📁 Project Directory Structure

```
jenninexus/
├── public_html/                    # Web root (deployment target)
│   ├── index.php                   # Landing page
│   ├── gamedev.php                 # Game dev hub
│   ├── gaming.php                  # Gaming content hub
│   ├── diy.php                     # DIY/Crafts hub
│   ├── music.php                   # Music production page
│   ├── live.php                    # Streaming hub
│   ├── blog.php                    # Blog grid
│   ├── ai.php                      # AI tools showcase
│   ├── patreon.php                 # VIP content (OAuth gated)
│   ├── tags.php                    # Multi-tag filtering
│   ├── youtube.php                 # All YouTube channels
│   ├── resume.php, services.php, links.php, media.php, sitemap.php, privacy.php, tos.php, vip.php
│   ├── game/                       # Game detail pages
│   │   ├── martiangames.php        # Martian Games hub
│   │   ├── purgatoryfell.php       # VR horror game
│   │   ├── tankoff.php             # Multiplayer tank game
│   │   ├── gamejams.php            # Ludum Dare hub
│   │   └── [13 game pages total]
│   ├── blog/                       # Blog article pages
│   │   ├── ai-tools-for-technical-artists.php
│   │   ├── game-dev-in-2025.php
│   │   └── [10 blog articles total]
│   ├── dev-only/                   # Development-only pages (excluded from production)
│   │   ├── theme-demo.php          # Comprehensive theme showcase
│   │   ├── buttons.php             # Button style reference
│   │   ├── themes.php              # Theme system demo
│   │   └── svgs.php                # SVG icon showcase
│   ├── includes/                   # Shared PHP components
│   │   ├── head.php                # <head> with CSS/meta tags
│   │   ├── header.php              # Navigation + theme toggle
│   │   ├── footer.php              # Footer + Seattle Indies
│   │   ├── error-handler.php       # Whoops error handler
│   │   ├── game-cta-helper.php     # Steam/GameJolt CTAs
│   │   ├── color-swatch-palettes.php  # Color system demo
│   │   └── video-display-demo.php  # Video card showcase
│   └── resources/                  # Production assets (built from src/)
│       ├── css/                    # Compiled stylesheets (.css + .min.css)
│       ├── js/                     # JavaScript files (.js + .min.js)
│       ├── images/                 # Static images
│       ├── fonts/                  # Custom fonts
│       ├── vendor/                 # Bootstrap 5.3.8, FontAwesome 6.7.2
│       └── playlists/              # YAML configs + JSON data
│           ├── gamedev.yaml        # Game dev playlists
│           ├── gaming.yaml         # Gaming playlists
│           ├── diy.yaml            # DIY playlists
│           ├── music.yaml          # Music playlists
│           ├── ai.yaml             # AI tools playlists
│           ├── live.yaml           # Live streaming playlists
│           ├── youtube.yaml        # All channels
│           ├── patreon.yaml        # VIP content
│           ├── gamejams.yaml       # Ludum Dare playlists
│           ├── blog-posts.yaml     # Blog post metadata
│           ├── tags.json           # Tag definitions
│           ├── content_tags.json   # Content tagging
│           └── social-stats.json   # Social media metrics
├── src/                            # Source assets (pre-build)
│   └── assets/
│       ├── css/                    # Source CSS files
│       ├── js/                     # Source JavaScript
│       ├── images/                 # Source images
│       └── fonts/                  # Source fonts
├── scripts/                        # Build & deployment scripts
│   ├── build.ps1                   # Asset build pipeline
│   ├── deploy.ps1                  # SSH deployment
│   ├── watch.ps1                   # Auto-rebuild on changes
│   └── dev-server.ps1              # PHP dev server (port 8002)
└── storage/                        # Documentation & logs
    ├── docs/                       # Markdown documentation
    │   ├── PAGES.md                # This file
    │   ├── THEME-SYSTEM.md         # Theme documentation
    │   ├── PLAYLIST-MAPPING.md     # YAML configuration guide
    │   ├── JS.md                   # JavaScript architecture
    │   └── CSS-SCSS.md             # CSS architecture
    └── logs/                       # Application logs
```

---

## 🎯 YAML Configuration System

**Location:** `public_html/resources/playlists/`

JenniNexus uses YAML files to configure YouTube playlists, blog posts, and content metadata. The youtube-grid.js system reads these configurations at runtime to render dynamic content grids.

### YAML Files & Page Mappings

| YAML File | Used By Pages | Purpose | Key Features |
|-----------|---------------|---------|--------------|
| **gamedev.yaml** | gamedev.php, game/*.php | Game dev playlists & tutorials | Featured projects, Martian Games, learning resources, per-game playlists |
| **gaming.yaml** | gaming.php | Gaming content & Let's Plays | Horror games, multiplayer, shorts (9:16 videos) |
| **diy.yaml** | diy.php | DIY tutorials & crafts | Fashion, beauty, home decor, TikTok integration |
| **music.yaml** | music.php | Music production playlists | Beats, FL Studio tutorials, sound design |
| **ai.yaml** | ai.php | AI tools & research | ChatGPT, Sora, technical art AI tools |
| **live.yaml** | live.php | Live streaming content | Twitch highlights, YouTube live archives |
| **youtube.yaml** | youtube.php | All YouTube channels | Main channel, DIY channel, gaming channel RSS feeds |
| **patreon.yaml** | patreon.php, vip.php | VIP content (OAuth-gated) | Patron-only playlists, early access content |
| **gamejams.yaml** | game/gamejams.php | Ludum Dare & game jams | Event-based playlist collections |
| **blog-posts.yaml** | blog.php | Blog post metadata | Title, description, tags, publish date, thumbnail |

### YAML Structure Example (gamedev.yaml)

```yaml
sections:
  featured_projects:
    title: "Featured Game Projects"
    description: "Original games and development showcases"
    playlists:
      - id: "PLxxxxxxxxxxxxxxxxxx"
        title: "Purgatory Fell VR Development"
        description: "VR horror game development devlogs"
        tags: ["vr", "horror", "unity"]
        icon: "vr-cardboard"
        badge: "Featured"
        aspect_ratio: "16:9"
    grid_config:
      columns: {xs: 1, sm: 2, md: 3, lg: 4}
      videos_per_playlist: 6
      enable_hover_effects: true
```

### JSON Configuration Files

| JSON File | Purpose | Structure |
|-----------|---------|-----------|
| **tags.json** | Canonical tag definitions | `[{name: "Unity", slug: "unity", category: "gamedev"}]` |
| **content_tags.json** | Page content tagging | Maps pages to tag slugs for filtering |
| **social-stats.json** | Social media metrics | Follower counts, engagement stats |
| **playlist-ids.json** | Legacy playlist mapping | Used by old diy-playlists.js (deprecated) |

### YAML Features Per Page

#### gamedev.php
- Sections: `featured_projects`, `learning_resources`, `martian_games`
- Responsive columns: Mobile 1, Tablet 2, Desktop 3-4
- 16:9 aspect ratio for desktop gameplay
- Tags: gamedev, unity, unreal, blender, vr

#### gaming.php  
- Sections: `horror_games`, `multiplayer`, `shorts`
- Shorts use 9:16 aspect ratio (portrait videos)
- Horror games get special dark theme styling
- Tags: gaming, horror, fps, rpg, multiplayer

#### diy.php
- Sections: `diy_main`, `diy_secondary`, `tiktok_embeds`
- TikTok embeds handled separately (not via youtube-grid.js)
- RSS feed integration for latest videos
- Tags: diy, fashion, beauty, home-decor

#### music.php
- Static Spotify embeds (hardcoded iframes)
- YouTube playlists for music production tutorials
- Tags: music, fl-studio, beats, sound-design

#### patreon.php
- OAuth-gated content (requires Patreon login)
- VIP playlists visible only to patrons
- Early access content sections
- Tags: vip, patreon, exclusive

---

## 📊 Page Inventory

### Production Pages (public_html/)

| Page | Type | Template | Scripts | CSS | Notes |
|------|------|----------|---------|-----|-------|
| **index.php** | Landing | Home Template | tag-system, youtube-grid, patreon-auth | home-theme.css | Hero with social icons, featured carousel |
| **gamedev.php** | Content Hub | Video Grid | youtube-grid, tag-system | gamedev-theme.css, media.css | Dynamic playlist cards from gamedev.yaml (NO carousels) |
| **gaming.php** | Content Hub | Video Grid | youtube-grid, tag-system | gaming-theme.css, media.css | Gaming playlists from gaming.yaml |
| **diy.php** | Content Hub | Video Grid | diy-playlists, tag-system | diy-theme.css, media.css | DIY playlists + TikTok embeds |
| **youtube.php** | Content Hub | Video Grid | youtube-grid, tag-system | media.css | All YouTube channels |
| **music.php** | Media Page | Static Embeds | tag-system | media.css | Spotify + hardcoded YouTube iframes |
| **live.php** | Media Page | Stream Layout | live-status, youtube-grid, tag-system | live-theme.css, media.css | Twitch + YouTube live status |
| **blog.php** | Content Hub | Blog Grid | tag-system | N/A | YAML-driven blog post grid |
| **ai.php** | Content Page | Static Content | tag-system | media.css | AI tools showcase |
| **resume.php** | Static | Resume Layout | compat-resume | N/A | Professional resume |
| **services.php** | Static | Services Grid | N/A | N/A | Service offerings |
| **links.php** | Link Tree | Link Cards | N/A | link-cards.css | Social media link aggregator |
| **media.php** | Media Kit | Static Content | N/A | media.css | Press resources |
| **patreon.php** | Gated Content | VIP Layout | patreon-auth-enhanced, youtube-grid | patreon-theme.css, media.css | OAuth + VIP playlists |
| **tags.php** | Content Hub | Tag Filter | tag-system, tag-cloud | tags-theme.css | Multi-tag filtering |
| **sitemap.php** | Static | Sitemap Grid | N/A | link-cards.css | Site navigation overview |
| **privacy.php** | Legal | Static Text | N/A | N/A | Privacy policy |
| **tos.php** | Legal | Static Text | N/A | N/A | Terms of service |
| **vip.php** | Gated Content | VIP Layout | patreon-auth-enhanced | patreon-theme.css | Patron-only content |

### Game Pages (public_html/game/)

**CSS Pattern:** All game pages with YouTube playlists use `gamedev-theme.css` + `media.css`
- `gamedev-theme.css`: Brand colors, gradients, Steam/Martian Games styling
- `media.css`: Universal video card styles, thumbnails, play overlays, platform buttons

| Page | Template | Scripts | CSS | YAML Config |
|------|----------|---------|-----|-------------|
| **blueballs.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **botborgs.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **catgame.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **cleanupinisle3.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **cowdefender.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **gamejams.php** | Game Hub | youtube-grid, tag-system | gamedev-theme.css, media.css | gamedev.yaml |
| **graveyardsmashers.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **jennistyles.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **martiangames.php** | Game Hub | youtube-grid, tag-system | gamedev-theme.css, media.css | gamedev.yaml |
| **momshouse.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **purgatoryfell.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **soccercow.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |
| **tankoff.php** | Game Detail | youtube-grid, tag-system, game-cta-helper | gamedev-theme.css, media.css | gamedev.yaml |

### Blog Pages (public_html/blog/)

| Page | Type | Scripts | CSS | Tags |
|------|------|---------|-----|------|
| **ai-tools-for-technical-artists.php** | Article | tag-system | N/A | ai, productivity, tools |
| **ai-tools-using-ai.php** | Article | tag-system | N/A | ai, technical-art, 3d-modeling |
| **build-and-deploy-2024.php** | Tutorial | tag-system | N/A | devops, deployment, automation |
| **diy-beauty-trends-2025.php** | Article | tag-system | N/A | diy, beauty, fashion |
| **game-dev-in-2025.php** | Article | tag-system | N/A | gamedev, unity, unreal |
| **pax-west-2022.php** | Event | tag-system | N/A | gaming, events, pax |
| **pax-west-gaming-con.php** | Event | tag-system | N/A | gaming, events, pax |
| **sora-ai-2025.php** | Article | tag-system | N/A | ai, video-generation |
| **summercon-2024.php** | Event | tag-system | N/A | gaming, events, convention |
| **voice-acting-in-games.php** | Article | tag-system | N/A | voice-acting, gamedev |

### Dev-Only Pages (public_html/dev-only/) 🔧

**Purpose:** Development testing and component showcase - **EXCLUDED FROM PRODUCTION**

| Page | Purpose | Status | Production Deployment |
|------|---------|--------|----------------------|
| **theme-demo.php** | Complete theme showcase + Bootstrap components | ✅ Active | ❌ Excluded via build-and-deploy.ps1 |
| **buttons.php** | Button style testing + platform colors | ✅ Active | ❌ Excluded via build-and-deploy.ps1 |
| **themes.php** | Theme switcher widget | ✅ Active | Included in theme-demo.php |
| **svgs.php** | SVG icon library showcase | ✅ Active | Included in theme-demo.php |

**Exclusion Pattern (build-and-deploy.ps1 line 305-307):**
```powershell
$enforcedExcludes = @(
    'dev-only/**',
    'theme-demo.php',
    'buttons.php'
)
```

**Access:** Local dev only - `http://localhost:8002/dev-only/theme-demo.php`

---

## 🏗️ Page Templates

### Template 1: Home Page Template (index.php)

**Purpose:** Landing page with hero, social icons, featured content carousel, and stats

**Structure:**
```php
<?php
$activePage = 'home';
$pageTitle = 'JenniNexus - Game Developer & 3D Artist | Seattle/Tacoma';
$pageDescription = 'Professional game developer, 3D artist...';
$customCSS = ['/resources/css/home-theme.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Hero Section with Logo & Social Icons -->
    <section class="hero-section reveal-on-scroll">
      <div class="glass-panel">
        <?php $logoLink = false; include __DIR__ . '/includes/logo.php'; ?>
        <div class="social-links">
          <!-- Platform social buttons -->
        </div>
      </div>
    </section>

    <!-- Featured Content Carousel -->
    <section class="py-5 bg-theme-adaptive">
      <div id="featuredCarousel" class="carousel slide">
        <!-- Bootstrap carousel -->
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
      <div class="row g-4">
        <div class="col-6 col-md-3">
          <span class="stat-number" data-target="50">0</span>+
        </div>
      </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Page-specific scripts -->
    <script src="<?= RES_ROOT ?>/js/patreon-auth-enhanced.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
  </body>
</html>
```

**Components Used:**
- ✅ Logo component (includes/logo.php)
- ✅ Glassmorphism panels
- ✅ Bootstrap carousel
- ✅ Stat counters with animation
- ✅ Platform social buttons
- ✅ Tag filter system

**Assets:**
- CSS: `home-theme.css` (responsive social icons, project cards)
- JS: `patreon-auth-enhanced.js`, `youtube-grid.js`, `tag-system.js`

---

### Template 2: Video Grid Hub Template (gaming.php, gamedev.php, youtube.php)

**Purpose:** Content hub with YouTube playlist grids and tag filtering

**Structure:**
```php
<?php
$activePage = 'gaming';
$pageTitle = 'Gaming Content | JenniNexus';
$customCSS = ['/resources/css/gaming-theme.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section py-5">
      <div class="glass-panel">
        <h1>Gaming Content</h1>
        <p class="lead">Let's Play videos, stream highlights, and gaming adventures</p>
      </div>
    </section>

    <!-- Video Grid Container -->
    <section class="mb-5" id="gaming-videos">
      <div class="row g-4" data-tags="gaming,letsplay,highlights">
        <!-- Populated by youtube-grid.js -->
      </div>
    </section>

    <!-- Tag Filter Offcanvas -->
    <?php include __DIR__ . '/includes/tag-filter-offcanvas.php'; ?>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Required Scripts (in order) -->
    <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?>.js"></script>
    <script>
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
          window.YouTubeGrid.loadPageConfig('gaming');
        });
      } else {
        window.YouTubeGrid.loadPageConfig('gaming');
      }
    </script>
  </body>
</html>
```

**Components Used:**
- ✅ Tag filter offcanvas (includes/tag-filter-offcanvas.php)
- ✅ YouTube grid renderer
- ✅ Bootstrap responsive grid
- ✅ Glassmorphism hero
- ✅ Tag badges (clickable)

**Assets:**
- CSS: `gaming-theme.css` (Steam-inspired blue gradients)
- JS: `js-yaml`, `youtube-grid.js`, `tag-system.js`
- YAML: `gaming.yaml` (playlist configuration)

**Script Load Order (CRITICAL):**
1. js-yaml (YAML parser)
2. youtube-grid.js (renders playlists)
3. tag-system.js (listens for tag events)

---

### Template 3: Game Detail Page Template (game/*.php)

**Purpose:** Individual game showcase with devlogs, screenshots, and CTA buttons

**Structure:**
```php
<?php
$activePage = 'gamedev';
$pageTitle = 'Game Name | JenniNexus';
$pageDescription = 'Description of your game';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  <body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Hero Section with Game Banner -->
    <section class="py-5 game-header text-white">
      <div class="container">
        <h1>Game Title</h1>
        <p class="lead">Game tagline</p>
        <?php renderGameCTA('Steam', 'https://store.steampowered.com/...'); ?>
      </div>
    </section>

    <!-- Game Details -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <!-- Game description -->
          </div>
          <div class="col-lg-4">
            <!-- Screenshots/Gallery -->
          </div>
        </div>
      </div>
    </section>

    <!-- Devlog Videos -->
    <section class="mb-5" id="devlogs">
      <div class="container">
        <h2>Development Updates</h2>
        <div class="row g-4" data-tags="gamedev,devlog,game-name">
          <!-- Populated by youtube-grid.js -->
        </div>
      </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?>.js"></script>
    <script>
      window.tagFilter.init();
      // Load game-specific playlist from gamedev.yaml
      window.YouTubeGrid.renderSection({
        container_id: 'devlogs',
        playlist_id: 'PL9QBjNDhgNwQ...',
        columns: { xs: 1, sm: 2, md: 2, lg: 3 },
        aspect_ratio: '16:9',
        max_results: 12
      });
    </script>
  </body>
</html>
```

**Components Used:**
- ✅ Game CTA helper (includes/game-cta-helper.php)
- ✅ YouTube grid for devlogs
- ✅ Tag system integration
- ✅ Responsive game banner
- ✅ Screenshot gallery

**Assets:**
- CSS: `gamedev-theme.css` (purple/pink gradients)
- JS: `js-yaml`, `tag-filter-api.js`, `youtube-grid.js`, `tag-system.js`
- YAML: `gamedev.yaml` (game-specific playlists)

**Include Paths:** Use `../includes/` since game pages are in subdirectory

---

### Template 4: Blog Post Template (blog/*.php)

**Purpose:** Individual blog article with metadata, images, and social sharing

**Structure:**
```php
<?php
$activePage = 'blog';
$pageTitle = 'Blog Post Title | JenniNexus Blog';
$pageDescription = 'Blog post description for SEO';
$pageKeywords = 'keyword1, keyword2, keyword3';

// Define RES_ROOT for blog subdirectory (defensive)
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}

// Optional: Facebook SDK for embeds
// $needsFb = true;
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/../includes/head.php'; ?>
  <body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Article Header -->
    <article class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <header class="mb-5">
              <div class="mb-3">
                <span class="badge bg-primary">Category</span>
                <span class="text-muted ms-2">January 2, 2026</span>
              </div>
              <h1 class="display-4">Blog Post Title</h1>
              <p class="lead">Article summary or excerpt</p>
            </header>

            <!-- Featured Image -->
            <img src="<?= RES_ROOT ?>/images/blog/post-image.jpg" 
                 class="img-fluid rounded mb-5" 
                 alt="Blog post image">

            <!-- Article Content -->
            <div class="article-content">
              <p>Article content goes here...</p>
            </div>

            <!-- Tags -->
            <div class="mt-5">
              <a href="../tags.php?filters=ai" 
                 class="badge bg-secondary me-1 text-decoration-none tag-badge">AI</a>
              <a href="../tags.php?filters=gamedev" 
                 class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Dev</a>
            </div>
          </div>
        </div>
      </div>
    </article>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
  </body>
</html>
```

**Components Used:**
- ✅ Article header with metadata
- ✅ Responsive images
- ✅ Tag badges (linked to tags.php)
- ✅ Bootstrap typography
- ✅ Optional Facebook SDK

**Assets:**
- CSS: Inherits from global `custom.css`
- JS: `tag-system.js` (global)
- Images: `resources/images/blog/*.jpg`

**RES_ROOT Pattern:** Defensive definition before includes (blog pages are in subdirectory)

**Blog Post Registry:** All posts listed in `resources/playlists/blog-posts.yaml`

---

### Template 5: Static Content Page Template (resume.php, services.php)

**Purpose:** Simple static content pages with minimal JavaScript

**Structure:**
```php
<?php
$activePage = 'resume';
$pageTitle = 'Resume | JenniNexus';
$pageDescription = 'Professional resume and portfolio';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section py-5">
      <div class="container">
        <h1>Jennifer Scheerer</h1>
        <p class="lead">Game Developer & 3D Artist</p>
      </div>
    </section>

    <!-- Content Sections -->
    <section class="py-5">
      <div class="container">
        <!-- Static content -->
      </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Optional page-specific scripts -->
    <script src="<?= RES_ROOT ?>/js/compat-resume<?= $assetSuffix ?>.js"></script>
  </body>
</html>
```

**Components Used:**
- ✅ Basic hero section
- ✅ Bootstrap grid layout
- ✅ Minimal JavaScript
- ✅ Standard header/footer

**Assets:**
- CSS: Global `custom.css` only
- JS: Optional compatibility shims

---

## 📦 Required Includes (All Pages)

### PHP Includes

**Location:** `public_html/includes/`

| Include | Purpose | Required | Notes |
|---------|---------|----------|-------|
| **head.php** | HTML head, meta tags, CSS loading | ✅ All pages | Defines RES_ROOT, assetSuffix |
| **header.php** | Navigation bar, mobile menu | ✅ All pages | Logo, nav links, theme toggle |
| **footer.php** | Site footer, core JS loading | ✅ All pages | Back-to-top button, social links |
| **logo.php** | JenniNexus logo component | ⚠️ Optional | Reusable logo with variants |
| **game-cta-helper.php** | Game CTA button generator | ⚠️ Game pages | Steam, itch.io, GameJolt buttons |
| **tag-filter-offcanvas.php** | Tag filtering UI | ⚠️ Content hubs | Gaming, gamedev, DIY, blog pages |
| **error-handler.php** | Whoops error handler | ⚠️ Optional | Dev environment only |

### Include Path Patterns

**Top-level pages (public_html/*.php):**
```php
include __DIR__ . '/includes/head.php';
```

**Subdirectory pages (game/*.php, blog/*.php):**
```php
include __DIR__ . '/../includes/head.php';
```

**RES_ROOT Definition:**
- Defined in `includes/head.php`: `define('RES_ROOT', '/resources');`
- Blog pages: Defensive definition before includes
- Used for all resource paths: `<?= RES_ROOT ?>/css/custom.css`

---

## 🎨 CSS Loading Patterns

### Global CSS (Loaded on ALL Pages via head.php)

**Load Order (head.php lines 140-164):**
```php
<!-- 1. Bootstrap 5.3.8 (Local Vendor) -->
<link href="<?= RES_ROOT ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- 2. FontAwesome 6.7.2 (Local Vendor) -->
<link href="<?= RES_ROOT ?>/vendor/fontawesome/css/all.min.css" rel="stylesheet">

<!-- 3. Main Layout -->
<link href="<?= RES_ROOT ?>/css/main<?= $assetSuffix ?>.css" rel="stylesheet">

<!-- 4. Theme System -->
<link href="<?= RES_ROOT ?>/css/all-themes<?= $assetSuffix ?>.css" rel="stylesheet">

<!-- 5. Pastel Backgrounds -->
<link href="<?= RES_ROOT ?>/css/pastel-backgrounds<?= $assetSuffix ?>.css" rel="stylesheet">

<!-- 6. Typography & Logo -->
<link href="<?= RES_ROOT ?>/css/jenni-fonts<?= $assetSuffix ?>.css" rel="stylesheet">

<!-- 7. Custom CSS Overrides -->
<link href="<?= RES_ROOT ?>/css/custom<?= $assetSuffix ?>.css" rel="stylesheet">

<!-- 8. Media & Video Styles -->
<link href="<?= RES_ROOT ?>/css/media<?= $assetSuffix ?>.css" rel="stylesheet">

<!-- 9. Mixins & Utilities -->
<link href="<?= RES_ROOT ?>/css/mixins<?= $assetSuffix ?>.css" rel="stylesheet">
```

### Page-Specific CSS

**Method 1: Via $customCSS array (before head.php include)**
```php
<?php
$customCSS = [
  '/resources/css/home-theme.css',
  '/resources/css/custom-page.css'
];
include __DIR__ . '/includes/head.php';
?>
```

**Method 2: Manual link tag (after head.php)**
```php
<?php include __DIR__ . '/includes/head.php'; ?>
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/page-specific.css">
```

### Environment-Aware Loading ($assetSuffix)

**Defined in head.php:**
```php
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;
$assetSuffix = $isLocal ? '' : '.min';
```

**Result:**
- **Local dev:** `custom.css` (unminified)
- **Production:** `custom.min.css` (minified)

---

## 📜 JavaScript Loading Patterns

### Core Scripts (Loaded on ALL Pages via footer.php)

**Load Order (footer.php lines 137-150):**
```php
<!-- Bootstrap Bundle (Modal, Offcanvas, etc.) -->
<script src="<?= RES_ROOT ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core Scripts -->
<script src="<?= RES_ROOT ?>/js/theme-toggle<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/performance-optimizer<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/polyfills<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/ui-effects<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/back-to-top<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?>.js"></script>
```

### Page-Specific Scripts

**Method 1: Via $pageScripts array (before footer.php include)**
```php
<?php
$pageScripts = [
    'https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js',
    RES_ROOT . '/js/youtube-grid.js',
    RES_ROOT . '/js/tag-system.js'
];
include __DIR__ . '/includes/footer.php';
?>
```

**Method 2: Manual script tags (after footer.php)**
```php
<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="<?= RES_ROOT ?>/js/page-specific.js"></script>
<script>
  // Inline initialization
  window.YouTubeGrid.loadPageConfig('gaming');
</script>
```

### Script Load Order for Video Pages (CRITICAL)

**Correct Order:**
```html
1. js-yaml (YAML parser)
2. youtube-grid.js (playlist renderer)
3. tag-system.js (tag event listener)
```

**Why This Order:**
- `youtube-grid.js` depends on `js-yaml` for YAML parsing
- `tag-system.js` listens for `YouTubeGrid:usedTagsUpdated` event
- Loading tag-system before youtube-grid causes tag detection failure

**Example:**
```php
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
<script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?>.js"></script>
```

---

## 🧩 Component Reference

### Logo Component (includes/logo.php)

**Usage:**
```php
<?php 
  $logoSize = 'fs-2';           // Bootstrap font size class
  $logoClass = 'mb-4';          // Additional classes
  $logoLink = true;             // Wrap in <a> tag?
  $logoId = 'main-logo';        // Optional ID attribute
  $logoVariant = 'default';     // 'default' or 'diy'
  include __DIR__ . '/includes/logo.php'; 
?>
```

**Output:**
```html
<a href="/" id="main-logo" class="logo-brand fs-2 mb-4">
  <span class="jenni-text">Jenni</span><span class="nexus-text">NEXUS</span>
</a>
```

**Variants:**
- `default`: "JenniNEXUS"
- `diy`: "DIY w/ Jenni"

### Game CTA Helper (includes/game-cta-helper.php)

**Usage:**
```php
<?php
include __DIR__ . '/../includes/game-cta-helper.php';
renderGameCTA('Steam', 'https://store.steampowered.com/app/123456');
renderGameCTA('itch.io', 'https://username.itch.io/game');
renderGameCTA('GameJolt', 'https://gamejolt.com/games/game/123456');
?>
```

**Output:**
```html
<a href="..." class="btn btn-steam btn-lg">
  <i class="fa-brands fa-steam"></i>Play on Steam
</a>
```

### Tag Filter Offcanvas (includes/tag-filter-offcanvas.php)

**Usage:**
```php
<?php include __DIR__ . '/includes/tag-filter-offcanvas.php'; ?>
```

**Features:**
- Bootstrap offcanvas sidebar
- Tag checkboxes by category (gamedev, gaming, DIY, etc.)
- Active filter display
- Apply/Clear buttons
- "Show All Tags" toggle

**Requires:** `tag-system.js` for functionality

---

## 🎯 Page-Specific Features

### Home Page (index.php)

**Unique Features:**
- Featured content carousel (Bootstrap carousel)
- Stat counters with scroll animation
- Responsive social icon row (mobile: stacked, desktop: single row)
- Multiple CTA sections (content, resume, Patreon)

**CSS:** `home-theme.css` - Hero social icons, project card zoom

### Gaming Page (gaming.php)

**Unique Features:**
- Steam-inspired blue/navy color scheme
- Gaming playlist grid from `gaming.yaml`
- Let's Play videos, stream highlights

**CSS:** `gaming-theme.css` - Steam gradients, platform buttons

### Game Dev Page (gamedev.php)

**Unique Features:**
- Purple/pink gradient theme
- Martian Games showcase
- Devlog playlists from `gamedev.yaml`
- Game jam entries

**CSS:** `gamedev-theme.css` - Purple/pink brand colors

### DIY Page (diy.php)

**Unique Features:**
- TikTok embeds (9:16 aspect ratio)
- DIY playlists from `diy.yaml`
- Recent videos RSS feed
- Fashion, beauty, crafts categories

**CSS:** `diy-theme.css` - Pink/lavender gradients
**Script:** `diy-playlists.js` (legacy - to be migrated to youtube-grid.js)

### Live Page (live.php)

**Unique Features:**
- Live status indicator (Twitch + YouTube)
- Stream schedule
- VOD archive playlists

**CSS:** `live-theme.css` - Twitch purple + YouTube red
**Script:** `live-status.js` - Polls Twitch/YouTube APIs

### Patreon Page (patreon.php)

**Unique Features:**
- OAuth2 authentication flow
- VIP content gating
- Dynamic playlist loading for patrons
- PDF viewer embeds
- Tier benefits showcase

**CSS:** `patreon-theme.css` - Patreon coral theme
**Script:** `patreon-auth-enhanced.js` - OAuth + content gating

### Tags Page (tags.php)

**Unique Features:**
- Multi-tag filtering (`?filters=tag1,tag2,tag3`)
- Tag cloud visualization
- Related tags with co-occurrence counts
- Content aggregation from all sources

**CSS:** `tags-theme.css` - Tag badge styling
**Script:** `tag-cloud.js` - Tag cloud renderer

---

## ✅ Page Creation Checklist

### For New Content Hub Pages

- [ ] Create PHP file in `public_html/`
- [ ] Set `$activePage`, `$pageTitle`, `$pageDescription`
- [ ] Add page-specific CSS via `$customCSS` array
- [ ] Include head.php with `__DIR__` path
- [ ] Include header.php
- [ ] Create hero section with `.hero-section` class
- [ ] Add video container with unique `id` and `data-tags`
- [ ] Include tag-filter-offcanvas.php if using filters
- [ ] Include footer.php
- [ ] Load scripts in correct order: js-yaml, youtube-grid, tag-system
- [ ] Initialize YouTubeGrid with `loadPageConfig()` or `renderSection()`
- [ ] Create YAML config file in `resources/playlists/`
- [ ] Test responsive grid, tag filtering, RSS caching

### For New Game Pages

- [ ] Create PHP file in `public_html/game/`
- [ ] Include head.php with `../includes/` path
- [ ] Include game-cta-helper.php
- [ ] Add game banner hero section
- [ ] Render CTA buttons with `renderGameCTA()`
- [ ] Add devlog video section
- [ ] Include footer.php with `../` path
- [ ] Load youtube-grid.js and tag-system.js
- [ ] Configure playlist from gamedev.yaml
- [ ] Test CTA buttons, video grid, tag integration

### For New Blog Posts

- [ ] Create PHP file in `public_html/blog/`
- [ ] Add defensive `RES_ROOT` definition
- [ ] Include head.php with `../includes/` path
- [ ] Add article header with metadata
- [ ] Add featured image
- [ ] Write article content
- [ ] Add tag badges (linked to tags.php)
- [ ] Include footer.php
- [ ] Add entry to `resources/playlists/blog-posts.yaml`
- [ ] Upload thumbnail image to `resources/images/blog/`
- [ ] Test responsive layout, tag links, social sharing

---

## 🔧 Troubleshooting

### Issue: CSS Not Loading

**Symptoms:** Page displays unstyled, missing Bootstrap classes

**Solutions:**
1. Check `RES_ROOT` is defined (should be `/resources`)
2. Verify include path uses `__DIR__` (absolute path)
3. Check `$assetSuffix` matches file existence (.css vs .min.css)
4. Inspect browser DevTools Network tab for 404 errors
5. Run `.\scripts\build.ps1` to sync CSS from src/

### Issue: JavaScript Not Executing

**Symptoms:** YouTube grid not rendering, tags not clickable

**Solutions:**
1. Check script load order (js-yaml FIRST, then youtube-grid, then tag-system)
2. Verify `RES_ROOT` is available to JavaScript (`window.RES_ROOT`)
3. Check browser console for errors
4. Ensure `$assetSuffix` matches file existence
5. Verify YAML config file exists in `resources/playlists/`

### Issue: Includes Not Found

**Symptoms:** "Failed to open stream" errors

**Solutions:**
1. Use `__DIR__` for absolute paths: `include __DIR__ . '/includes/head.php'`
2. Subdirectory pages: `include __DIR__ . '/../includes/head.php'`
3. Check file exists: `ls public_html/includes/head.php`
4. Verify case sensitivity (Linux servers: `Head.php` ≠ `head.php`)

### Issue: Tag System Not Working

**Symptoms:** Tag badges not clickable, filter not updating

**Solutions:**
1. Verify `tag-filter-api.js` loads before `tag-system.js`
2. Check `window.tagFilter` exists in console
3. Ensure tag badges have `onclick="window.tagFilter.toggle('slug')"`
4. Verify `data-tag-slug` attribute on badges
5. Check `tag-filter-offcanvas.php` is included on page

---

## 📚 Related Documentation

- **CSS-SCSS.md** - CSS architecture, build pipeline, theme system
- **JS.md** - JavaScript file inventory, patterns, consolidation
- **YOUTUBE.md** - YouTube RSS feed system, playlist configuration
- **TAG-SYSTEM.md** - Tag filtering system, badge implementation
- **DEPLOYMENT-GUIDE.md** - Build process, asset optimization, deployment

**Last Updated:** January 2, 2026  
**Maintainer:** JenniNexus Development Team
