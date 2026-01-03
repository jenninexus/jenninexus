# Asset Optimization Guide

## Overview

The JenniNexus build pipeline now includes automatic CSS/JS optimization via PurgeCSS and minification. This can reduce your Bootstrap and FontAwesome bundle sizes by **60-80%**, significantly improving page load times.

## Quick Start

### 1. Test Optimization (Dry Run)
```powershell
.\scripts\optimize-assets.ps1 -DryRun
```
This will show you what would be optimized without making any changes.

### 2. Run Full Build with Optimization
```powershell
.\scripts\build-all.ps1
```
This will:
- Fix all page consistency issues
- Compile SCSS to CSS
- **Optimize CSS/JS assets** (NEW!)
- Verify router and Nginx configuration

### 3. Create Optimized Deploy Package
```powershell
.\scripts\build-and-deploy.ps1
```
This will build and package optimized assets for deployment.

## What Gets Optimized

### PurgeCSS (Third-Party Bundles)
- **Bootstrap 5.3.8**: `bootstrap.min.css` → `bootstrap.purged.min.css`
  - Original: ~200 KB → Optimized: ~60-80 KB (60-70% reduction)
- **FontAwesome 6.7.2**: `all.min.css` → `fontawesome.purged.min.css`
  - Original: ~80 KB → Optimized: ~20-30 KB (60-75% reduction)

### CSS Minification (Custom Files)
- `gamedev-theme.css` → `gamedev-theme.min.css`
- `gaming-theme.css` → `gaming-theme.min.css`
- `diy-theme.css` → `diy-theme.min.css`
- All other custom CSS files

### JavaScript Minification (Custom Files)
- All custom `.js` files → `.min.js` versions
- Uses terser if available, falls back to basic minification

## Prerequisites

### Required
- **Node.js** (v18+): Download from https://nodejs.org/

### Automatic Installation
The script will automatically install PurgeCSS when you first run it:
```powershell
npm install --save-dev purgecss
```

### Optional (Better JS Minification)
```powershell
npm install --save-dev terser cssnano
```

## How It Works

### PurgeCSS Process
1. Scans all PHP, HTML, and JS files for CSS class names
2. Identifies unused classes in Bootstrap/FontAwesome
3. Removes unused classes from bundles
4. Outputs optimized `.purged.min.css` files

### Safelist
PurgeCSS preserves critical classes that might be added dynamically:
- Bootstrap components: `navbar`, `dropdown`, `modal`, `carousel`, `offcanvas`
- State classes: `active`, `show`, `collapse`, `fade`
- Icon prefixes: `fa-*`, `bi-*`
- Data attributes: `data-bs-*`

### Skip Logic
- Already optimized files are skipped (checks file timestamps)
- Source files are never modified
- Optimization creates new `.min` and `.purged.min` versions

## Integration Points

### build-all.ps1
Added **STEP 2.5: Optimize Assets** between SCSS compilation and router verification.

### build-and-deploy.ps1
Added **STAGE 1.5: Optimize Assets** before creating the deploy package.

### Logs
All optimization activity is logged to:
```
storage/logs/optimize-YYYY-MM-DD.log
```

## Testing Optimized Assets

### 1. Visual Regression Testing
After optimization, test all pages to ensure no visual regressions:
```powershell
.\scripts\dev-server.ps1
```

Visit these pages and verify Bootstrap components work:
- http://localhost:8002/gamedev (hero, cards, buttons)
- http://localhost:8002/music (embedded players, badges)
- http://localhost:8002/patreon (modals, tier cards, auth flow)
- http://localhost:8002/blog/game-dev-in-2025 (blog layout)
- http://localhost:8002/game/purgatoryfell (game page layout)

### 2. Check Navbar & Dropdowns
- Test mobile menu (hamburger icon)
- Test dropdown menus
- Verify offcanvas sidebar

### 3. Check Modals & Tooltips
- Test any modal dialogs
- Verify tooltips show correctly
- Check popovers if used

### 4. Performance Testing
Use browser DevTools Network tab:
- Before: Bootstrap ~200 KB + FontAwesome ~80 KB = **~280 KB**
- After: Bootstrap ~70 KB + FontAwesome ~25 KB = **~95 KB**
- **Savings: ~185 KB (66% reduction)**

## Production Deployment

### Option A: Use Optimized Assets (Recommended)
Update `includes/head.php` to load purged CSS in production:

```php
<?php if (ENVIRONMENT === 'production'): ?>
  <!-- Optimized bundles -->
  <link href="<?= RES_ROOT ?>/css/bootstrap.purged.min.css" rel="stylesheet">
  <link href="<?= RES_ROOT ?>/css/fontawesome.purged.min.css" rel="stylesheet">
<?php else: ?>
  <!-- Full bundles for development -->
  <link href="<?= RES_ROOT ?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= RES_ROOT ?>/css/all.min.css" rel="stylesheet">
<?php endif; ?>
```

### Option B: Replace Original Files
If you're confident the purged CSS works everywhere:
```powershell
# Backup originals
Copy-Item public_html/resources/css/bootstrap.min.css public_html/resources/css/bootstrap.min.css.original
Copy-Item public_html/resources/css/all.min.css public_html/resources/css/all.min.css.original

# Replace with purged versions
Copy-Item public_html/resources/css/bootstrap.purged.min.css public_html/resources/css/bootstrap.min.css -Force
Copy-Item public_html/resources/css/fontawesome.purged.min.css public_html/resources/css/all.min.css -Force
```

## Troubleshooting

### "PurgeCSS not found"
Install Node.js and run:
```powershell
npm install --save-dev purgecss
```

### "Classes are missing after purge"
If you find missing styles, add them to the safelist in `optimize-assets.ps1`:
```powershell
"safelist": {
  "standard": ["your-class-name"],
  "deep": [/^your-prefix-/]
}
```

### "Optimization is slow"
First run takes ~30-60 seconds. Subsequent runs are faster because already-optimized files are skipped.

### "Source maps missing"
PurgeCSS doesn't generate source maps. For debugging, use the original unminified files during development.

## File Structure

```
scripts/
├── build-all.ps1              # Full build pipeline (includes optimization)
├── build-and-deploy.ps1       # Build + deploy (includes optimization)
├── optimize-assets.ps1        # NEW: Asset optimization script
└── README-OPTIMIZATION.md     # This file

public_html/resources/css/
├── bootstrap.min.css          # Original Bootstrap (200 KB)
├── bootstrap.purged.min.css   # Optimized Bootstrap (60-80 KB)
├── all.min.css                # Original FontAwesome (80 KB)
├── fontawesome.purged.min.css # Optimized FontAwesome (20-30 KB)
├── gamedev-theme.css          # Custom theme (source)
├── gamedev-theme.min.css      # Minified custom theme
└── ...

storage/logs/
└── optimize-YYYY-MM-DD.log    # Optimization logs
```

## Benefits

### Performance
- **66% smaller CSS bundles** (280 KB → 95 KB)
- **Faster page loads** (especially on mobile/slow connections)
- **Better Core Web Vitals** (LCP, CLS, FID scores)

### Deployment
- **Smaller deploy packages** (less bandwidth, faster uploads)
- **Lower CDN costs** (if using CDN for assets)
- **Better caching** (smaller files = faster cache writes)

### SEO
- **Improved page speed** (Google ranking factor)
- **Better mobile experience** (Mobile-First Indexing)

## Learn More

- **PurgeCSS Documentation**: https://purgecss.com/
- **CSS Optimization Best Practices**: https://web.dev/minify-css/
- **JavaScript Minification**: https://terser.org/

---

**Ready to optimize!** Run `.\scripts\build-all.ps1` to get started. 🚀
