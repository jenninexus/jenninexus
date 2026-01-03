# Asset Loading & Build System Documentation

**Last Updated:** January 02, 2026  
**Build Scripts:** `scripts/build.ps1`, `scripts/build-all.ps1`, `scripts/optimize-assets.ps1`

## Overview

JenniNexus uses a centralized asset loading system via `includes/head.php` and `includes/footer.php`. All CSS and JS files are served from `public_html/resources/` using the `RES_ROOT` constant (`/resources`).

## Vendor Assets (External Libraries)

External libraries are stored in `public_html/resources/vendor/` to separate them from custom project code.

### FontAwesome 6.7.2
- **CSS:** `public_html/resources/vendor/fontawesome/css/all.min.css`
- **Webfonts:** `public_html/resources/vendor/fontawesome/webfonts/`
- **Integration:** Loaded globally in `head.php`.

## CSS Files Structure

### Global CSS (Loaded on All Pages via `head.php`)

Loaded in this order:

1. **FontAwesome** - `vendor/fontawesome/css/all.min.css`
2. **main.css** - Base styles, utilities, body defaults
3. **all-themes.css** - Theme system (light/dark mode variables, platform colors)
4. **jenni-fonts.css** - Typography, logo gradients, text contrast utilities
5. **custom.css** - Site-wide enhancements, glass effects, animations, button system
6. **media.css** - Image/video display settings, responsive video grids
7. **mixins.css** - Theme-aware utility classes and helper mixins

### Page-Specific CSS (Loaded via `$customCSS` array)

These files are loaded conditionally based on the page:

- `home-theme.css` - Home page specific styles
- `diy-theme.css` - DIY page theme
- `gamedev-theme.css` - Game development page theme
- `gaming-theme.css` - Gaming page theme
- `live-theme.css` - Live streaming page theme
- `patreon-theme.css` - Patreon page theme
- `tags-theme.css` - Tags page theme

**Usage Example:**
```php
$customCSS = [
  '/resources/css/home-theme.css'
];
```

## JavaScript Files Structure

### Global JS (Loaded on All Pages via `footer.php`)

Loaded in this order:

1. **Bootstrap Bundle** - `vendor/bootstrap/js/bootstrap.bundle.min.js`
2. **theme-toggle.js** - Dark/light mode switching
3. **performance-optimizer.js** - Lazy loading, resource hints
4. **polyfills.js** - Browser compatibility shims
5. **ui-effects.js** - Parallax, card tilt, copy-to-clipboard, stat counters
6. **back-to-top.js** - Scroll-to-top button functionality
7. **tag-filter-api.js** - Tag filtering utilities

### Page-Specific JS (Loaded per-page)

These scripts are loaded conditionally:

- **youtube-grid.js** - YouTube playlist rendering (used on: index.php, gamedev.php, gaming.php, diy.php, etc.)
- **tag-system.js** - Tag filtering system (used on: index.php, tags.php, etc.)
- **patreon-auth-enhanced.js** - Patreon OAuth (used on: patreon.php)
- **live-status.js** - Live streaming status (used on: live.php)

**Usage Example:**
```php
$pageScripts = [
  RES_ROOT . '/js/youtube-grid.js',
  RES_ROOT . '/js/tag-system.js'
];
```

Or inline:
```php
<script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
```

## Build Process

### Step 1: Copy Assets (`build.ps1`)

Copies files from `src/assets/` to `public_html/resources/`:

- **CSS:** `src/assets/css/*.css` → `public_html/resources/css/`
- **JS:** `src/assets/js/*.js` → `public_html/resources/js/`
- **Images:** `src/assets/images/` → `public_html/resources/images/`
- **Fonts:** `src/assets/fonts/` → `public_html/resources/fonts/`
- **PDFs:** `src/assets/pdfs/` → `public_html/resources/pdfs/`
- **Playlists:** `src/assets/playlists/*.yaml` → `public_html/resources/playlists/`

**CSS Minification:** `build.ps1` also minifies CSS files using `clean-css-cli`:
- `custom.css` → `custom.min.css`
- `all-themes.css` → `all-themes.min.css`
- etc.

### Step 2: Optimize Assets (`optimize-assets.ps1`)

Additional optimization (run after `build.ps1`):

- **PurgeCSS:** Removes unused CSS from Bootstrap/FontAwesome bundles
- **JS Minification:** Uses `terser` to minify JavaScript files
- **CSS Minification:** Additional CSS minification for custom files

### Complete Build (`build-all.ps1`)

Runs the complete pipeline:

1. Generate content tags (`generate-playlist-tags.ps1`)
2. Copy assets (`build.ps1`)
3. Optimize assets (`optimize-assets.ps1`)

## Environment Detection

The system automatically detects local vs production:

```php
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;
$assetSuffix = $isLocal ? '' : '.min';
```

- **Local Dev:** Loads `.css` and `.js` files (unminified)
- **Production:** Loads `.min.css` and `.min.js` files (minified)

## File Checklist

### CSS Files (src/assets/css/)

✅ **All files copied and minified:**
- [x] all-themes.css → all-themes.min.css
- [x] custom.css → custom.min.css
- [x] diy-theme.css → diy-theme.min.css
- [x] gamedev-theme.css → gamedev-theme.min.css
- [x] gaming-theme.css → gaming-theme.min.css
- [x] home-theme.css → home-theme.min.css
- [x] jenni-fonts.css → jenni-fonts.min.css
- [x] live-theme.css → live-theme.min.css
- [x] main.css → main.min.css
- [x] media.css → media.min.css
- [x] mixins.css → mixins.min.css
- [x] patreon-theme.css → patreon-theme.min.css
- [x] tags-theme.css → tags-theme.min.css

### JavaScript Files (src/assets/js/)

✅ **All files copied and minified:**
- [x] back-to-top.js → back-to-top.min.js
- [x] live-status.js → live-status.min.js
- [x] patreon-auth-enhanced.js → patreon-auth-enhanced.min.js
- [x] performance-optimizer.js → performance-optimizer.min.js
- [x] polyfills.js → polyfills.min.js
- [x] tag-filter-api.js → tag-filter-api.min.js
- [x] tag-system.js → tag-system.min.js
- [x] theme-toggle.js → theme-toggle.min.js
- [x] ui-effects.js → ui-effects.min.js
- [x] youtube-grid.js → youtube-grid.min.js

## RES_ROOT Usage

All asset paths use the `RES_ROOT` constant:

```php
// In PHP
define('RES_ROOT', '/resources');
<link href="<?= RES_ROOT ?>/css/custom.css" rel="stylesheet">

// In JavaScript (exposed via head.php)
window.RES_ROOT = '/resources';
const cssPath = window.RES_ROOT + '/css/custom.css';
```

## Verification

To verify all assets are loaded correctly:

1. **Run build:** `.\scripts\build.ps1`
2. **Check files exist:** All CSS/JS files should be in `public_html/resources/css/` and `public_html/resources/js/`
3. **Check minified versions:** All `.min.css` and `.min.js` files should exist
4. **Test in browser:** Check Network tab to verify correct files are loaded based on environment

## Troubleshooting

**Issue:** CSS/JS files not loading
- **Check:** `RES_ROOT` is defined correctly
- **Check:** Files exist in `public_html/resources/`
- **Check:** Build script ran successfully
- **Check:** Browser console for 404 errors

**Issue:** Minified files not loading in production
- **Check:** `$assetSuffix` is set to `.min` in production
- **Check:** `.min.css` and `.min.js` files exist
- **Check:** Build script minified files correctly

**Issue:** Page-specific CSS/JS not loading
- **Check:** `$customCSS` or `$pageScripts` array is set correctly
- **Check:** File paths use `RES_ROOT` or absolute paths starting with `/resources`
- **Check:** Files exist in `public_html/resources/`

