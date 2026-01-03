# MG Best Practices - Architecture & Development Standards

**Last Updated:** December 29, 2025  
**Status:** Production-Ready Architecture  
**Philosophy:** Bootstrap-first, single source of truth, accessibility-first

---

## 🎯 Top Features & Benefits

### JavaScript Architecture (17.86 KB minified)

#### 1. **Zero Dependencies (No jQuery)**

- **Benefit**: Faster page loads, smaller bundle size
- **Implementation**: Pure vanilla JavaScript with Bootstrap 5.3.8 native API
- **Size**: 42.66 KB expanded → 17.86 KB minified (58.1% compression)
- **Files**: 4 focused files vs 1 monolithic script

#### 2. **Single Source of Truth Pattern**

- **Benefit**: No duplicate functionality, easier maintenance
- **Implementation**: Each feature has exactly one owner file
  - Theme System → `theme-system.js` (3.32 KB)
  - Particles, Cookie Banner, UI → `gaming-ui.js` (6.74 KB)
  - Video Hover → `video-hover.js` (3.80 KB)
  - YouTube Playlists → `playlist-loader.js` (4.00 KB)
- **Result**: Zero circular dependencies, clear ownership

#### 3. **Accessibility-First Design** ⭐

- **Benefit**: WCAG AA compliant, respects user preferences
- **Implementation**:
  - `CONFIG.REDUCED_MOTION` flag detects `prefers-reduced-motion`
  - Disables animations for users who prefer reduced motion
  - Skips card tilt/parallax on touch devices
  - Applied in: `gaming-ui.js` (lines 7, 258, 400)
- **Example**:
  ```javascript
  if (CONFIG.TOUCH_DEVICE || CONFIG.REDUCED_MOTION) return;
  ```

#### 4. **Modern UI Enhancements (Dec 29, 2025)** 🆕

- **Smooth Scroll Anchors**: Native `scrollIntoView` for all `#` links
- **3D Game Card Tilt**: Desktop-only perspective effect (±8° rotation)
- **Scroll Progress Bar**: Visual progress indicator for long pages
- **Copy-to-Clipboard**: Toast notifications with fallback for older browsers
- **Parallax Scroll**: Subtle 0.15x parallax on hero sections
- **Benefit**: Enhanced UX without sacrificing performance

#### 5. **CSP Compliant Loading**

- **Benefit**: Security without inline scripts
- **Implementation**: Nonce-based script injection via `MG_JS_FILES` environment variable
- **Result**: No `unsafe-inline` CSP directives needed

#### 6. **Bootstrap 5.3.8 Native Integration**

- **Benefit**: No conflicts, uses native dark mode
- **Implementation**: Uses `data-bs-theme` attribute on `<html>`
- **Result**: Automatic sync with Bootstrap components

#### 7. **RSS-Based YouTube Playlist Loader** 🎥

- **Benefit**: No API key required, no quota limits, automatic CORS proxy fallback
- **Implementation**: `playlist-loader.js` fetches YouTube RSS feeds via 3 proxy fallbacks
- **File**: `src/assets/js/playlist-loader.js` (4.00 KB minified)
- **Usage**:

  **Display Full Playlist (Row of Videos):**
  ```html
  <!-- Shows all videos in responsive grid (3 cols desktop, 2 tablet, 1 mobile) -->
  <div class="row playlist-grid" data-playlist-id="PLX4G5KQM4yXqL5oG6T4QQCY7P_jW1ZSJZ">
    <!-- Videos auto-populate here -->
  </div>
  ```

  **Display Limited Videos (e.g., 4 videos):**
  ```html
  <!-- Shows only first 4 videos from playlist -->
  <div class="row playlist-grid" 
       data-playlist-id="PLX4G5KQM4yXqL5oG6T4QQCY7P_jW1ZSJZ" 
       data-limit="4">
    <!-- First 4 videos populate here -->
  </div>
  ```

  **Display Single Video:**
  ```html
  <!-- Shows only 1 video (useful for featured/latest video sections) -->
  <div class="row playlist-grid" 
       data-playlist-id="PLX4G5KQM4yXqL5oG6T4QQCY7P_jW1ZSJZ" 
       data-limit="1">
    <!-- Single video card populates here -->
  </div>
  ```

- **How It Works**:
  1. Fetches `https://www.youtube.com/feeds/videos.xml?playlist_id={ID}`
  2. Tries 3 CORS proxies if first fails (allorigins.win → corsproxy.io → codetabs.com)
  3. Parses XML feed using native `DOMParser`
  4. Generates responsive video cards with thumbnails + play icons
  5. Handles errors gracefully with fallback message + direct YouTube link

- **CSS Styling**: Uses `.playlist-card`, `.playlist-thumbnail`, `.playlist-content` from `pages/_playlists.scss`
- **Responsive Grid**: Bootstrap `.col-12 .col-sm-6 .col-md-4 .col-lg-3` (1→2→3→4 columns)
- **Example Pages**: `/news` (featured videos), `/tankoff` (game devlogs)

---

### CSS/SCSS Architecture (58.68 KB minified)

#### 8. **Modular SCSS with Bootstrap-First Approach** ⭐

- **Benefit**: Never override Bootstrap grid, extend instead
- **Implementation**:
  - Bootstrap handles: Grid (`.col-*`), Spacing (`.p-4`), Flexbox (`.d-flex`)
  - MG handles: Colors, Visual Components, Interactions
- **Result**: No grid conflicts, predictable responsive behavior

#### 9. **Single Source of Truth for Colors**

- **Benefit**: Theme changes in one place, instant site-wide updates
- **Implementation**: `base/colors.scss` defines ALL colors as CSS variables
- **Rule**: No hex codes outside `colors.scss`
- **Example**:
  ```scss
  color: var(--color-primary); // ✅ Correct
  color: #ff6b00; // ❌ Never do this
  ```

#### 10. **Glassmorphism Mixins Library** 🎨

- **Benefit**: Consistent glass panels across site in 1 line
- **Implementation**: 14 reusable mixins in `base/_mixins.scss`
- **Example**:
  ```scss
  .my-panel {
    @include glass-panel(10px); // Instant glassmorphism
    @include hover-lift(4px); // Subtle elevation on hover
  }
  ```
- **Most Used Mixins**:
  - `glass-panel()` - Standard glassmorphism with backdrop-filter
  - `reduced-motion()` - Accessibility wrapper for animations
  - `hover-lift()` - Consistent elevation effects
  - `focus-ring()` - WCAG AA focus indicators

#### 11. **Theme-Aware Styling System**

- **Benefit**: Automatic light/dark theme support
- **Implementation**: `:root[data-theme="dark|light"]` selectors
- **Example**:

  ```scss
  .nav-link {
    color: var(--text-light);

    :root[data-theme="dark"] & {
      border-color: var(--color-primary); // Orange in dark
    }

    :root[data-theme="light"] & {
      border-color: #ffffff; // White in light
    }
  }
  ```

#### 12. **Reduced-Motion Accessibility** ⭐

- **Benefit**: Respects user motion preferences (WCAG)
- **Implementation**: `@include reduced-motion` wrapper
- **Example**:

  ```scss
  .card {
    transition: transform 0.3s ease;

    &:hover {
      transform: translateY(-4px);
    }

    @include reduced-motion {
      transition: none;
      &:hover {
        transform: none;
      }
    }
  }
  ```

#### 13. **Vendor Prefix Support for Safari**

- **Benefit**: Cross-browser compatibility (Safari 9+)
- **Implementation**: `-webkit-backdrop-filter` before `backdrop-filter`
- **Automated**: Mixins handle prefixes automatically
- **Example**:
  ```scss
  @include glass-panel(10px); // Adds -webkit- prefix automatically
  ```

#### 14. **Build Optimization Pipeline**

- **Benefit**: 67.8% CSS reduction, 58.1% JS reduction
- **Implementation**: Sass → PurgeCSS → Minification
- **Results**:
  - CSS: 103.22 KB → 58.68 KB (customMG.css)
  - JS: 42.66 KB → 17.86 KB (all files)
- **Command**: `pwsh scripts/build-legacy.ps1 -Environment production`

---

## 🚀 Development Workflow Best Practices

### 15. **Always Edit Source, Never Output**

- **Rule**: Edit `src/assets/scss/` and `src/assets/js/`, NEVER `html/resources/`
- **Benefit**: Changes won't be overwritten by build
- **Process**:
  1. Edit source: `src/assets/scss/pages/_games.scss`
  2. Build: `pwsh scripts/build-css.ps1`
  3. Output: `html/resources/css/customMG.min.css`

### 16. **Mixin Requirement Protocol**

- **Rule**: Any file using `@include` MUST import mixins
- **Implementation**:

  ```scss
  @use "../base/mixins" as *; // REQUIRED at top of file

  .my-element {
    @include hover-lift(4px); // Now available
  }
  ```

- **Benefit**: Prevents "Undefined mixin" build errors

### 17. **Mobile Containment Standard**

- **Rule**: Use `!important` ONLY for 390px breakpoint in `_layout.scss`
- **Benefit**: Forces containers to fit iPhone SE/Fold screens
- **Implementation**: Centralized in `pages/_layout.scss` (single source)

### 18. **Environment Variable Loading**

- **Benefit**: Switch between dev/production with .env files
- **Implementation**:
  - Production: `MG_JS_FILES` → `.min.js` variants
  - Development: `MG_JS_FILES` → `.js` (unminified) variants
- **File**: `html/src/Config/env/.env` (production), `.env.local` (dev)

---

## 📊 Performance Metrics

### File Size Comparison

| Asset              | Expanded      | Minified      | Compression | Purpose                         |
| ------------------ | ------------- | ------------- | ----------- | ------------------------------- |
| **JavaScript**     |               |               |             |                                 |
| theme-system.js    | 9.77 KB       | 3.32 KB       | 66.0%       | Theme + Bootstrap integration   |
| gaming-ui.js       | 16.01 KB      | 6.74 KB       | 57.9%       | UI enhancements + accessibility |
| video-hover.js     | 8.67 KB       | 3.80 KB       | 56.2%       | Video autoplay interactions     |
| playlist-loader.js | 8.21 KB       | 4.00 KB       | 51.3%       | YouTube RSS feed integration    |
| **JS Total**       | **42.66 KB**  | **17.86 KB**  | **58.1%**   |                                 |
| **CSS**            |               |               |             |                                 |
| customMG.css       | 103.22 KB     | 58.68 KB      | 43.2%       | All components + pages          |
| socials.css        | 43.45 KB      | 29.48 KB      | 32.2%       | Social brand buttons            |
| header.css         | 22 KB         | 9.02 KB       | 59.0%       | Navigation                      |
| **CSS Total**      | **225.56 KB** | **140.18 KB** | **37.8%**   | (6 files)                       |

### Total Production Bundle

- **Before Compression**: 268.22 KB
- **After Compression**: 158.04 KB
- **Total Savings**: 41.1% reduction

---

## 🎨 Design Consistency Patterns (Dec 29, 2025)

### 19. **Shared Timing Constants** ⭐

- **Benefit**: Consistent animation feel across SCSS & JS
- **Standard**: `0.35s cubic-bezier(0.4, 0, 0.2, 1)`
- **Implementation**:
  ```scss
  // SCSS
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  ```
  ```javascript
  // JavaScript
  element.style.transition = "all 0.35s cubic-bezier(0.4, 0, 0.2, 1)";
  ```

### 20. **Accessibility Integration**

- **SCSS**: `@include reduced-motion { transition: none; }`
- **JS**: `if (CONFIG.REDUCED_MOTION) return;`
- **Benefit**: Unified accessibility across tech stack

### 21. **Color Variable Usage**

- **SCSS**: `color: var(--text-light);`
- **JS**: `getCssVariable('--text-light')`
- **Benefit**: Single color definition, runtime resolution

---

## 🔧 Quick Reference Commands

### Development

```powershell
# Build CSS (development mode with source maps)
pwsh scripts/build-css.ps1

# Build JavaScript (minified)
pwsh scripts/build-js.ps1

# Build all assets (CSS + JS)
pwsh scripts/build-legacy.ps1

# Local testing
pwsh scripts/deploy.ps1 -LocalTest
```

### Production

```powershell
# Build with PurgeCSS optimization
pwsh scripts/build-legacy.ps1 -Environment production

# Stage deployment (build only, no upload)
pwsh scripts/deploy.ps1 -BuildOnly

# Deploy to production (with prompts)
pwsh scripts/deploy.ps1

# Deploy without prompts (CI/CD mode)
pwsh scripts/deploy.ps1 -Force

# Deploy with verbose output
pwsh scripts/deploy.ps1 -Verbose
```

### Validation

```powershell
# Validate system (all checks)
pwsh scripts/validate-system.ps1

# Enhanced deployment (with validation)
pwsh scripts/deploy-enhanced.ps1

# Dry run (preview deployment)
pwsh scripts/deploy-enhanced.ps1 -DryRun
```

---

## 🚀 Deployment Script Guide

### If deploy.ps1 Appears "Stuck"

The script may be waiting for user input at one of three confirmation prompts:

1. **`.htaccess` Upload Confirmation** (Line 887)

   - Prompt: `Upload .htaccess to production? [Y/n]`
   - Look for: `>>> USER INPUT REQUIRED <<<` (yellow text)

2. **`.env` Update Confirmation** (Line 910)

   - Prompt: `Confirm .env is up-to-date on server (or will be updated manually) [y/N]`
   - Look for: `>>> USER INPUT REQUIRED <<<` (yellow text)

3. **Final Deployment Confirmation** (Line 937)
   - Prompt: `Proceed with upload now? [y/N]`
   - Look for: `>>> FINAL CONFIRMATION REQUIRED <<<` (yellow text)

### Solutions

**Option 1: Use -Force flag (skip all prompts)**

```powershell
pwsh scripts/deploy.ps1 -Force
```

- ⚠️ WARNING: This will deploy without confirmation
- ✅ Use for: CI/CD pipelines, automated deployments
- ❌ Avoid for: Manual production deployments (unless confident)

**Option 2: Use deploy-enhanced.ps1 (better validation)**

```powershell
pwsh scripts/deploy-enhanced.ps1
```

- ✅ Pre-deployment validation
- ✅ Staging verification
- ✅ Clearer user prompts
- ✅ Post-deployment checks

**Option 3: Stage first, then deploy**

```powershell
# Step 1: Build staging area (no prompts)
pwsh scripts/deploy.ps1 -BuildOnly

# Step 2: Review staged files in mg/deploy/html/

# Step 3: Deploy staged files
pwsh scripts/deploy.ps1 -DeployOnly
```

### Typical Deployment Workflow

```powershell
# 1. Build production assets (CSS + JS)
pwsh scripts/build-legacy.ps1 -Environment production

# 2. Validate build
pwsh scripts/validate-system.ps1

# 3. Deploy with validation
pwsh scripts/deploy-enhanced.ps1

# 4. Test production site
# - Hard refresh browser (Ctrl+Shift+R)
# - Check browser console for errors
# - Test theme toggle
# - Verify responsive layout
```

### SSH/SCP Timeout Information

If deployment hangs during SSH/SCP operations (not prompts):

| Operation           | Expected Duration | Timeout Threshold |
| ------------------- | ----------------- | ----------------- |
| Remote backup (tar) | 30-60 seconds     | 5 minutes         |
| File upload (SCP)   | 1-3 minutes       | 10 minutes        |
| Remote commands     | 10-20 seconds     | 2 minutes         |
| Permission fixes    | 20-40 seconds     | 3 minutes         |

**If operations exceed timeout:**

1. Check SSH key authentication: `ssh -i ~/.ssh/martiangames_ed25519 root@martiangames.com`
2. Check network connectivity: `ping martiangames.com`
3. Check server disk space: `ssh root@martiangames.com 'df -h'`
4. Check server load: `ssh root@martiangames.com 'uptime'`

### Manual Recovery

If deployment fails mid-upload, you can complete manually:

```powershell
# 1. Upload staged files
scp -i ~/.ssh/martiangames_ed25519 -r mg/deploy/html/. root@64.23.243.225:/var/www/html/

# 2. Fix permissions
ssh -i ~/.ssh/martiangames_ed25519 root@64.23.243.225 '/var/www/html/fix-permissions.sh'

# 3. Verify deployment
ssh -i ~/.ssh/martiangames_ed25519 root@64.23.243.225 'ls -la /var/www/html/'
```

---

## 🚫 Anti-Patterns to Avoid

### ❌ Don't Override Bootstrap Grid

```scss
// ❌ BAD: Custom widths break responsive behavior
.col-md-6 {
  width: 45%;
}

// ✅ GOOD: Use Bootstrap utilities or custom classes
.custom-width {
  width: 45%;
}
```

### ❌ Don't Define Colors Locally

```scss
// ❌ BAD: Hardcoded color
.button {
  background: #ff6b00;
}

// ✅ GOOD: CSS variable
.button {
  background: var(--color-primary);
}
```

### ❌ Don't Edit Compiled Output

```scss
// ❌ BAD: Editing html/resources/css/customMG.min.css
// Changes will be overwritten by next build

// ✅ GOOD: Edit src/assets/scss/customMG.scss
```

### ❌ Don't Duplicate Functionality

```javascript
// ❌ BAD: Cookie banner in multiple JS files
// gaming-ui.js AND theme-system.js both handle cookies

// ✅ GOOD: Single source in gaming-ui.js only
```

### ❌ Don't Use `!important` Freely

```scss
// ❌ BAD: !important everywhere
.card {
  margin: 1rem !important;
}

// ✅ GOOD: Only for 390px mobile fix in _layout.scss
@media (max-width: 390px) {
  .container {
    max-width: 100vw !important;
  } // Authorized
}
```

---

## 📚 Related Documentation

- **[JAVASCRIPT.md](JAVASCRIPT.md)** - Complete JS architecture (4 files, 17.86 KB)
- **[CSS-SCSS.md](CSS-SCSS.md)** - SCSS system (16 files, Bootstrap 5.3.8)
- **[DESIGN-CONSISTENCY.md](DESIGN-CONSISTENCY.md)** - SCSS + JS integration patterns
- **[PROTOCOL.md](PROTOCOL.md)** - Development guidelines & system rules
- **[BUILD-ARCHITECTURE.md](BUILD-ARCHITECTURE.md)** - Build system documentation

---

## ✅ Success Checklist

Before deploying to production, verify:

- [ ] All assets built: `pwsh scripts/build-legacy.ps1 -Environment production`
- [ ] No linter errors: Check `storage/logs/` for build logs
- [ ] CSS minified: Verify `.min.css` files exist and are recent
- [ ] JS minified: Verify `.min.js` files exist and are recent
- [ ] Theme toggle works in both light/dark modes
- [ ] Reduced-motion preferences respected
- [ ] No console errors in browser DevTools
- [ ] Mobile responsive (test at 390px, 768px, 992px, 1200px)
- [ ] `.env` file up-to-date on production server
- [ ] Backup created before deployment

---

**Architecture Status:** ✅ EXCELLENT  
**File Count:** 4 JS files (consolidated), 16 SCSS files (modular)  
**Bootstrap Compliance:** ✅ VERIFIED (native data-bs-theme, no conflicts)  
**Accessibility:** ✅ WCAG AA (reduced-motion, focus-ring, color contrast)  
**Performance:** ✅ OPTIMIZED (58.1% JS compression, 43.2% CSS compression)  
**Maintenance:** ✅ SUSTAINABLE (single source of truth, clear ownership)


