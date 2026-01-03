# CSS Architecture & Standards - JenniNexus

**Last Updated:** January 2, 2026  
**Status:** ✅ CONSOLIDATED & CURRENT  
**Purpose:** Complete CSS/SCSS architecture, standards, browser compatibility, and maintenance guidelines

---

## 📊 CSS Architecture Overview

### Core Principles
1. ✅ **100% Isolated Architecture** - No dependencies on shared-deps or shared/ framework
2. ✅ **Local Vendors** - Bootstrap 5.3.8 and FontAwesome 6.7.2 hosted in `public_html/resources/vendor/`
3. ✅ **Direct CSS Workflow** - Using direct CSS files with local minification (SCSS archived)
4. ✅ **Unified Build Pipeline** - `build.ps1` + `optimize-assets.ps1` handle all asset management
5. ✅ **Theme-Adaptive Platform Buttons** - Consistent brand colors with light/dark mode shadows
6. ✅ **Surface Helper Pattern** - Guaranteed text contrast via `.{page}-surface` classes

---

## 📁 CSS File Inventory & Structure

### Core CSS Files (Loaded Sitewide)

| File | Size | Purpose | Loaded By |
|------|------|---------|-----------|
| **custom.css** | 82 KB | Base styles, button system, glass effects, responsive utilities | All pages (head.php) |
| **custom.min.css** | ~34 KB | Minified version | Production (head.php) |
| **all-themes.css** | 18 KB | Platform colors, social media buttons, light/dark theme variables | All pages (head.php) |
| **all-themes.min.css** | ~7 KB | Minified version | Production (head.php) |
| **main.css** | 12 KB | Legacy global layout styles | All pages (head.php) |
| **main.min.css** | ~5 KB | Minified version | Production (head.php) |

**Total Core CSS:** 112 KB (unminified) → ~46 KB (minified + gzip ~12 KB)

### Page-Specific Theme Files

| File | Size | Used By | Purpose |
|------|------|---------|---------|
| **home-theme.css** | 14.2 KB | index.php | Homepage responsive social icons, project card zoom, hero gradients |
| **diy-theme.css** | 22.8 KB | diy.php | DIY page gradients, category cards, platform buttons, TikTok embeds |
| **gamedev-theme.css** | 19.3 KB | gamedev.php | Game dev purple/pink theme, project cards, Martian Games branding |
| **gaming-theme.css** | 16.7 KB | gaming.php | Steam-inspired navy/blue theme, playlist cards, game library |
| **live-theme.css** | 8.4 KB | live.php | Twitch purple/YouTube red, live indicators, stream status |
| **patreon-theme.css** | 12.1 KB | patreon.php, vip.php | Patreon coral theme, VIP content gating, OAuth UI |
| **youtube-theme.css** | 6.9 KB | youtube.php | YouTube red accents, playlist grid overrides |
| **blog-theme.css** | 5.2 KB | blog.php, blog/*.php | Blog post typography, tag filtering, article layout |

**Total Page-Specific:** 105.6 KB (unminified)

### Vendor CSS (Local)

| File | Size | Purpose |
|------|------|---------|
| **bootstrap.css** | 226 KB | Bootstrap 5.3.8 full framework |
| **bootstrap.min.css** | 189 KB | Bootstrap minified |
| **bootstrap-icons.css** | 78 KB | Bootstrap Icons font |
| **fontawesome/all.css** | 92 KB | FontAwesome 6.7.2 full |
| **fontawesome/all.min.css** | 73 KB | FontAwesome minified |

**Total Vendor:** ~580 KB (loaded from local `public_html/resources/vendor/`)

### Archived/Deprecated CSS

| File | Status | Reason | Archived Date |
|------|--------|--------|---------------|
| **martian-games.css** | ❌ REMOVED | Superseded by gamedev-theme.css | Nov 10, 2025 |
| **scss/** | ⚠️ ARCHIVED | Migrated to direct CSS workflow | Jan 1, 2026 |

---

## 🏗️ Build System (Direct CSS)

### Build Pipeline Overview

```
src/assets/css/*.css  →  [build.ps1 copies]  →  public_html/resources/css/*.css
                                  ↓
                       [optimize-assets.ps1 minifies]
                                  ↓
                  public_html/resources/css/*.min.css
```

### Build Commands

**1. Full Build (Copy + Minify)**
```powershell
.\scripts\build.ps1
```
- Copies CSS from `src/assets/css/` → `public_html/resources/css/`
- Copies JS from `src/assets/js/` → `public_html/resources/js/`
- Runs optimize-assets.ps1 automatically

**2. Asset Optimization Only**
```powershell
.\scripts\optimize-assets.ps1
```
- Creates `.min.css` versions using local `clean-css-cli`
- Creates `.min.js` versions using local `terser`
- Skips file copy (assumes files already in place)

**3. Watch Mode (Auto-Rebuild)**
```powershell
.\scripts\watch.ps1
```
- Monitors `src/assets/` for changes
- Runs build.ps1 automatically on file save
- Keeps dev server running in background

### Environment-Aware Loading ($assetSuffix)

**Defined in head.php and footer.php:**
```php
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;
$assetSuffix = $isLocal ? '' : '.min';
```

**Result:**
- **Local dev:** `custom.css` (unminified, easier debugging)
- **Production:** `custom.min.css` (minified, faster loading)

---

## 📋 CSS Load Order & Integration

### Standard Load Order (head.php lines 140-184)

```php
<!-- 1. Bootstrap 5.3.8 (FIRST - Foundation) -->
<link href="<?= RES_ROOT ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- 2. Core Stylesheets (Site-wide) -->
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/all-themes<?= $assetSuffix ?>.css">
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/custom<?= $assetSuffix ?>.css">
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/main<?= $assetSuffix ?>.css">

<!-- 3. Page-Specific Theme CSS (via $customCSS array) -->
<?php
if (!empty($customCSS) && is_array($customCSS)) {
  foreach ($customCSS as $css) {
    echo '<link rel="stylesheet" href="' . htmlspecialchars($css) . '">';
  }
}
?>
```

### Page-Specific CSS Loading Pattern

**Option A: Set $customCSS Before Including head.php**
```php
<?php
$customCSS = [RES_ROOT . '/css/gamedev-theme' . ($assetSuffix ?? '') . '.css'];
include __DIR__ . '/includes/head.php';
?>
```

**Option B: Inline <link> (NOT RECOMMENDED)**
```html
<!-- ❌ AVOID - Bypasses environment detection -->
<link rel="stylesheet" href="/resources/css/gamedev-theme.css">

<!-- ✅ CORRECT - Uses RES_ROOT + $assetSuffix -->
<?php $customCSS = [RES_ROOT . '/css/gamedev-theme' . ($assetSuffix ?? '') . '.css']; ?>
```

### CSS Hierarchy & Inheritance

```
Bootstrap 5.3.8 (foundation)
    ↓
all-themes.css (platform colors, theme variables)
    ↓
custom.css (global buttons, glass effects, utilities)
    ↓
main.css (legacy layout styles)
    ↓
[page]-theme.css (page-specific overrides)
```

**Example Cascade:**
1. Bootstrap defines `.btn` base class
2. `custom.css` adds `.btn { transition: all 0.3s ease; }`
3. `all-themes.css` defines `.btn-youtube { background: var(--youtube-red); }`
4. `diy-theme.css` enhances: `.btn-youtube { background: linear-gradient(...); }`

---

### Glassmorphism
- **Always use**: Soft glass panels with `backdrop-filter: blur()`
- **Color palette**: Lavender-tinted glass (`rgba(249, 243, 251, 0.85)`) in light mode, dark translucent (`rgba(0, 0, 0, 0.6)`) in dark mode
- **Borders**: Subtle purple-tinted borders (`rgba(165, 99, 209, 0.2)`) for depth
- **Example**: `.glass-card`, `.glass-panel`, `.home-surface`

### Gradients
- **Direction**: Always diagonal (135deg) for dynamic feel
- **Brand colors**: Purple to pink (`#A563D1 → #FF2E88`) for Game Dev, Steam blue gradients for Gaming
- **Layering**: Use multiple gradients for richness (base gradient + overlay gradient)
- **Pastel backgrounds**: Soft lavender gradients via `.section-pastel` - **never pure white**

### Text Contrast System
- **Light mode**: Dark purple-gray text (`#2C2A33`) on lavender backgrounds
- **Dark mode**: Light lavender text (`#F5F3FF`) on rich black (`#0A0A0A`)
- **Implementation**: Surface helper classes (`.home-surface`, `.diy-surface`, etc.)
- **Avoid**: Never use `bg-body-secondary` - causes white-on-white in light mode

### Animations & Effects
- **Parallax**: Subtle scroll-based parallax on hero titles and layered elements (`data-parallax-speed`)
- **Hover effects**: 
  - Cards: `scale(1.05)` zoom with glowing shadows
  - Icons: Pulsing glow animation (`@keyframes iconPulseGlow`)
  - Buttons: Lift + enhanced glow (`translateY(-2px)` + stronger shadow)
- **Smooth everything**: `transition: all 0.3s ease` is default

### Button Design
- **Platform colors**: Always maintain brand colors (YouTube red, Discord blurple, etc.)
- **Consistency**: Use flexbox `gap` for icon/text spacing (never manual margins like `me-1`)
- **Responsive sizing**: Larger touch targets on mobile, standard on desktop
- **Rounded pills**: `.rounded-pill` for hero CTAs, standard `.btn` for utility buttons

### Layout Patterns
- **Mobile-first**: Design for 390px iPhone first
- **Responsive grids**: Use Bootstrap columns with YAML configs (xs:1, md:2, lg:3)
- **Never override**: Don't override Bootstrap grid or spacing utilities - extend with custom classes
- **Card layouts**: 16:9 aspect ratios for video cards, minimal padding, truncated titles

---

## 🏗️ Build System (Direct CSS)

### Build Pipeline Overview

```
src/assets/css/*.css  →  [build.ps1 copies]  →  public_html/resources/css/*.css
                             ↓
                    [optimize-assets.ps1 minifies]
                             ↓
                  public_html/resources/css/*.min.css
```

### Current Workflow

1. Edit CSS in `src/assets/css/`.
2. Run `.\scripts\build.ps1` to sync to `public_html/resources/css/`.
3. Run `.\scripts\optimize-assets.ps1` to create `.min.css` versions using local `clean-css-cli`.
4. Deploy with `.\scripts\build-and-deploy.ps1`.

---

## 📁 CSS File Structure

### Production CSS Files

```
public_html/resources/css/
├── all-themes.css              → Base theme system, platform color variables
├── all-themes.min.css          → Minified (Local)
├── custom.css                  → Global styles, buttons, glass effects, typography
├── custom.min.css              → Minified (Local)
├── main.css                    → Global layout styles
├── main.min.css                → Minified (Local)
├── *-theme.css                 → Page-specific themes (Gaming, DIY, Gamedev, etc.)
├── *-theme.min.css             → Minified page themes
└── vendor/
    └── bootstrap/              → Local Bootstrap 5.3.8
```

---

## 🎯 Global Styling Standards

### Bootstrap 5.3.8 Integration
- Site uses local Bootstrap files for stability and isolation.
- Dark mode enabled via `data-bs-theme="dark"` in `head.php`.
- Responsive design uses Bootstrap's 12-column grid and utility classes.

### Button Consistency
- Managed by `custom.css` and page-specific theme files.
- Uses flexbox gap for icon/text spacing.
- Responsive sizing for mobile, tablet, and desktop.

### Social Media Button Standards

#### Platform Color Variables (all-themes.css)
```css
:root {
  --youtube-red: #ff0000;
  --discord-blurple: #5865F2;
  --twitch-purple: #9146FF;
  --patreon-coral: #FF424D;
  --instagram-magenta: #E4405F;
  --tiktok-black: #000000;
  --tiktok-pink: #ff0050;
  --steam-blue: #66c0f4;
  --steam-navy: #1b2838;
  --spotify-green: #1DB954;
}
```

#### Theme-Adaptive Implementation
All social media buttons maintain their platform brand colors while adapting shadows and glows to the active theme:

**Light Mode:**
- Softer shadows: `0 4px 12px rgba(0, 0, 0, 0.15)`
- Hover: `0 8px 20px rgba(0, 0, 0, 0.25)`

**Dark Mode:**
- Deeper shadows: `0 4px 12px rgba(0, 0, 0, 0.4)`
- Enhanced hover glows: `0 0 25px rgba(r, g, b, 0.6)`

#### Button Classes
```css
.btn-youtube      /* Red gradient with YouTube branding */
.btn-discord      /* Blurple gradient with Discord branding */
.btn-twitch       /* Purple gradient with Twitch branding */
.btn-patreon      /* Coral gradient with Patreon branding */
.btn-instagram    /* Multi-color gradient with Instagram branding */
.btn-steam        /* Blue/Navy gradient with Steam branding */
.btn-tiktok       /* Black/Pink/Cyan gradient with TikTok branding */
```

#### Usage Example
```html
<!-- Hero section with rounded-pill styling -->
<a href="https://www.youtube.com/@channel" 
   class="btn btn-youtube btn-lg rounded-pill">
  <i class="fa-brands fa-youtube"></i>Subscribe on YouTube
</a>

<!-- Standard button -->
<a href="https://discord.gg/invite" 
   class="btn btn-discord">
  <i class="bi bi-discord"></i>Join Discord
</a>
```

---

## 🎨 Surface Helper Pattern (Text Contrast System)

### Purpose
Ensures proper text contrast on all major sections in both light and dark modes. Replaces problematic `bg-body-secondary` which renders as near-white in light mode, causing white-on-white text issues.

### Implementation Pattern
Each major page has a dedicated surface helper class that follows this structure:

#### CSS Structure (Consistent Across All Pages)
```css
/* Surface helper class */
.{page}-surface {
  background: var(--glass-bg);
  border-radius: 0.75rem;
  padding: 2rem 1rem;
}

/* Light mode: Dark text on lavender backgrounds */
:root[data-bs-theme="light"] .{page}-surface h1,
:root[data-bs-theme="light"] .{page}-surface h2,
:root[data-bs-theme="light"] .{page}-surface h3,
:root[data-bs-theme="light"] .{page}-surface p,
:root[data-bs-theme="light"] .{page}-surface .lead {
  color: #2C2A33; /* Dark purple-gray for contrast */
}

/* Dark mode: Light text on dark backgrounds */
:root[data-bs-theme="dark"] .{page}-surface h1,
:root[data-bs-theme="dark"] .{page}-surface h2,
:root[data-bs-theme="dark"] .{page}-surface h3,
:root[data-bs-theme="dark"] .{page}-surface p,
:root[data-bs-theme="dark"] .{page}-surface .lead {
  color: #F5F3FF; /* Light lavender */
}

/* Cards inside surface use glass panel styling */
.{page}-surface .card {
  background: var(--glass-panel-bg);
  -webkit-backdrop-filter: blur(var(--glass-panel-blur));
  backdrop-filter: blur(var(--glass-panel-blur));
  border: 1px solid var(--glass-panel-border);
}
```

### HTML Usage Pattern
```html
<!-- Major sections: section-pastel + {page}-surface -->
<section class="section-pastel home-surface" id="about">
  <div class="container">
    <h2>About Me</h2>
    <p class="lead">Biography content with proper contrast</p>
  </div>
</section>

<!-- Individual cards: glass-card -->
<div class="card glass-card hover-lift">
  <div class="card-body">
    <h3 class="card-title">Game Development</h3>
    <p>Card content with glassmorphism effect</p>
  </div>
</div>
```

### Implemented Pages
1. **home-theme.css** → `.home-surface`
   - About section, Content section, Channels section, Resume section
2. **diy-theme.css** → `.diy-surface`
   - All playlist grid sections
3. **gaming-theme.css** → `.gaming-surface`
   - Steam library sections
4. **gamedev-theme.css** → `.gamedev-surface`
   - Project showcase sections

### Design Principle
**Always use** `section-pastel {page}-surface` for major sections and `glass-card` for individual cards. This ensures:
- ✅ Proper text contrast in light mode (dark text on lavender)
- ✅ Proper text contrast in dark mode (light text on dark)
- ✅ Consistent glassmorphism across all pages
- ✅ No white-on-white or dark-on-dark issues

### Migration from bg-body-secondary
When you see `bg-body-secondary` in HTML:
```html
<!-- ❌ OLD - Causes white-on-white in light mode -->
<section class="bg-body-secondary">
  <div class="container">
    <h2>Title</h2>
  </div>
</section>

<!-- ✅ NEW - Proper contrast guaranteed -->
<section class="section-pastel home-surface">
  <div class="container">
    <h2>Title</h2>
  </div>
</section>
```

---

## 🎨 Theme System Architecture

### CSS Hierarchy
1. **all-themes.css**: Base theme variables and platform colors
2. **custom.css**: Global utilities, buttons, and cross-page styles
3. **Page themes**: Specific color palettes and overrides (diy-theme.css, gamedev-theme.css, etc.)

### Theme Switching
- Uses Bootstrap 5.3.8's `data-bs-theme` attribute
- JavaScript-driven toggle stored in localStorage
- All platform buttons adapt automatically

---

## 🔧 CSS Browser Compatibility Protocol

### CRITICAL: Vendor Prefixes (Avoid Red Errors)

To avoid linter errors and ensure cross-browser compatibility, **always** include vendor prefixes for these properties:

#### 1. Backdrop Filter (Safari/iOS Support)
```css
/* ❌ WRONG - Will cause red error */
.element {
  backdrop-filter: blur(12px);
}

/* ✅ CORRECT - Webkit prefix BEFORE standard property */
.element {
  -webkit-backdrop-filter: blur(12px);
  backdrop-filter: blur(12px);
}
```

**Rule:** Always add `-webkit-backdrop-filter` before `backdrop-filter`.

#### 2. User Select (Safari/iOS Support)
```css
/* ❌ WRONG - Will cause red error */
.no-select {
  user-select: none;
}

/* ✅ CORRECT - Webkit prefix BEFORE standard property */
.no-select {
  -webkit-user-select: none;
  user-select: none;
}
```

**Rule:** Always add `-webkit-user-select` before `user-select`.

#### 3. Property Ordering
**Always list vendor-prefixed properties BEFORE the standard property:**
```css
/* ✅ CORRECT ORDER */
.element {
  -webkit-backdrop-filter: blur(12px);  /* 1. Webkit prefix first */
  backdrop-filter: blur(12px);          /* 2. Standard property second */
}

/* ❌ WRONG ORDER - Will cause warning */
.element {
  backdrop-filter: blur(12px);          /* Wrong: standard first */
  -webkit-backdrop-filter: blur(12px);  /* Wrong: webkit second */
}
```

### Progressive Enhancement Properties (Warnings OK)

These properties may show **warnings** (not errors) - they're safe to use:

#### Scrollbar Styling (Firefox/Chrome 121+)
```css
html {
  scrollbar-width: thin;           /* Firefox */
  scrollbar-color: #FF2E88 #0D1117; /* Firefox */
}

::-webkit-scrollbar {              /* Chrome/Safari/Edge */
  width: 14px;
}
```
**Note:** Chrome < 121 doesn't support `scrollbar-width/color`, but fallback to webkit is automatic.

#### Legacy iOS Momentum Scrolling
```css
.scrollable {
  -webkit-overflow-scrolling: touch;  /* Legacy iOS < 13 */
}
```
**Note:** Deprecated but harmless. Modern iOS ignores it.

### Browser Compatibility Checklist

When writing CSS with modern features:

- [ ] ✅ Added `-webkit-backdrop-filter` before `backdrop-filter`
- [ ] ✅ Added `-webkit-user-select` before `user-select`
- [ ] ✅ Vendor prefix listed BEFORE standard property
- [ ] ✅ Tested in Safari/iOS (most common compatibility issues)
- [ ] ✅ Warnings (not errors) are acceptable for progressive enhancement

### Quick Reference: Common Prefixes

| Property | Prefix Required | Support |
|:---------|:---------------|:--------|
| `backdrop-filter` | `-webkit-` | Safari 9+, iOS 9+ |
| `user-select` | `-webkit-` | Safari 3+, iOS 3+ |
| `transform` | None (auto) | All modern browsers |
| `transition` | None (auto) | All modern browsers |
| `box-shadow` | None (auto) | All modern browsers |

### Files to Check for Compatibility

Always run linter checks after editing:
- `public_html/resources/css/custom.css`
- `public_html/resources/css/gamedev-theme.css`
- `public_html/resources/css/gaming-theme.css`
- `public_html/resources/css/diy-theme.css`
- `public_html/resources/css/patreon-theme.css`

**Command:**
```bash
# Cursor IDE will auto-lint, or run:
npx stylelint "public_html/resources/css/**/*.css"
```

---

## 🚀 Next Steps
- Continue refining `custom.css` to reduce reliance on legacy `main.css`.
- Monitor minified file sizes for further optimization.
- Ensure all new pages follow the isolated asset pattern.
- Maintain consistency in social media button styling across all pages.
- **Always follow browser compatibility protocol when adding modern CSS features.**

---

## 🛠️ How to add or update CSS & JS (practical guide)
Follow this workflow to add or update styles or scripts safely and consistently across the site.

### 1) Authoring files (source location)
- Edit source files under `src/assets/`:
  - CSS: `src/assets/css/*.css` (or `src/assets/scss/` if introducing an SCSS file for mixins; we maintain a one-time compiled output strategy).
  - JS: `src/assets/js/*.js` if you prefer authoring in `src` (build script will copy to production), or create directly in `public_html/resources/js/` for small, page-local scripts.

### 2) One-time SCSS mixins -> compiled CSS
- We keep mixin sources in SCSS for authoring (`src/assets/scss/base/_mixins.scss`) and provide a one-time compiled CSS artifact located at `src/assets/css/generated/mixins.css`.
- To regenerate after editing SCSS:
  - Install Dart Sass: https://sass-lang.com/install
  - Run: `pwsh scripts/compile-mixins.ps1` (this will call `sass` automatically)
  - Re-run: `pwsh scripts/build.ps1` to copy the generated CSS into `public_html/resources/css/`
- If you do not want an ongoing SCSS toolchain, keep using the committed compiled CSS — it's the production artifact.

### 3) Build & copy to production
- Run: `pwsh scripts/build.ps1` from project root.
  - Copies files from `src/assets/css/` -> `public_html/resources/css/`
  - Copies JS from `src/assets/js/` -> `public_html/resources/js/` (if applicable)
  - Minifies to `*.min.css` and `*.min.js` where appropriate
- Verify that `public_html/resources/css/` contains the updated files and `.min.css` copies exist.

### 4) How to include CSS on a page
- For page-specific CSS, set the `$customCSS` array before including `includes/head.php` in a PHP page. Example:
  ```php
  <?php
  $customCSS = ['resources/css/gamedev-theme.min.css'];
  include __DIR__ . '/../includes/head.php';
  ?>
  ```
- The canonical load order is:
  1. Bootstrap CSS (local vendor)
  2. `custom.css` (site-wide)
  3. `all-themes.css` (platform colors)
  4. Page-specific theme CSS (e.g., `gamedev-theme.css`)
- Avoid adding raw <link> tags in the page body; prefer `$customCSS` so `head.php` manages ordering and `assetSuffix`.

### 5) How to include JS on a page
- Place JS includes before `</body>` (footer) to avoid blocking rendering.
- Use `RES_ROOT` and `$assetSuffix` for consistent referencing (minified vs dev):
  ```php
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
  ```
- Recommended script order for video pages:
  1. js-yaml (if page uses YAML-driven playlists) — CDN or local
  2. `youtube-grid.js` — main renderer
  3. `tag-system.js` — attaches to events emitted by the grid
- For global scripts, add them in `includes/footer.php` or `includes/head.php` only when necessary (e.g., polyfills or global utilities). For page-scoped scripts, include them directly in the page footer (after `youtube-grid.js` if they rely on it).

### 6) Accessibility & contrast checks
- Use `ensure-contrast` patterns (we provide a compiled helper `mixins.css` with conservative defaults).
- When introducing new visuals on translucent backgrounds, ensure a light-theme and dark-theme fallback, e.g., use `:root[data-bs-theme="light"]` and `:root[data-bs-theme="dark"]` overrides.

### 7) Testing & verification
- Run `pwsh scripts/build.ps1`, then load the page on the dev server (`.	emplates` or `dev-server.ps1`) and verify in both themes.
- Check for white-on-white or low contrast in both light and dark modes.
- Run linting if available: `npx stylelint "public_html/resources/css/**/*.css"`.

---

## ✅ Page consistency check (CSS & JS usage summary)
Quick summary of pages that required attention and recommended fixes (see `storage/docs/PAGE-CONSISTENCY-AUDIT.md` for the full audit report):

- gaming.php — script order incorrect (tag-system loaded before youtube-grid). Recommended: load `js-yaml`, then `youtube-grid.js`, then `tag-system.js`.
- diy.php — redundant `diy-playlists.js` duplicates `youtube-grid.js`; also script order issue. Recommended: remove `diy-playlists.js`, use `YouTubeGrid.loadPageConfig('diy')` and keep TikTok embed as a separate inline helper.
- live.php — script order issue (tag-system before youtube-grid). Fix order.
- gamedev.php, music.php, ai.php — use of hardcoded iframes or inline rendering instead of `youtube-grid.js`; optional migration to `YouTubeGrid.loadPageConfig()` for consistency.

Actionable checklist (apply when updating pages):
- [ ] Ensure `js-yaml` is loaded before any JS that parses YAML (e.g., youtube-grid.js)
- [ ] If page uses `youtube-grid.js`, include `youtube-grid.js` before `tag-system.js`
- [ ] Use `$customCSS` to add page-specific CSS to head instead of inline <link> tags
- [ ] Use `RES_ROOT` + `$assetSuffix` for asset paths (minified/dev toggles)
- [ ] Test in both light & dark themes and on mobile breakpoints

---

If you want, I can now:
- (A) Update problematic pages automatically (fix script order and replace `diy-playlists.js` usage with `youtube-grid.js`), or
- (B) Run a dev-server visual check and capture screenshots of the affected pages for your review.

Which would you like me to do next?

---

## 📝 Recent Changes (Dec 25, 2025)

### Browser Compatibility Protocol (Dec 25, 2025)
- ✅ Fixed all red linter errors in `custom.css` and `gamedev-theme.css`
- ✅ Added `-webkit-backdrop-filter` prefixes for Safari/iOS support (10 instances)
- ✅ Added `-webkit-user-select` prefixes for Safari/iOS support (2 instances)
- ✅ Documented CSS Browser Compatibility Protocol with examples
- ✅ Created vendor prefix checklist and quick reference table
- ✅ Added property ordering rules (webkit before standard)

### Social Media Button Improvements (Dec 24, 2025)
- ✅ Made all platform buttons theme-adaptive
- ✅ Unified styling across `custom.css`, `diy-theme.css`, and other page themes
- ✅ Enhanced shadows/glows for better contrast in dark mode
- ✅ Maintained platform brand colors while improving accessibility
- ✅ Added comprehensive documentation for button usage patterns
