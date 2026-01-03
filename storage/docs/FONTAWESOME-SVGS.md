# FontAwesome & SVG Icon System - JenniNexus

**Last Updated**: January 2, 2026 (Added Animation/Sizing Preferences Section)  
**FontAwesome Version**: 6.7.2  
**Bootstrap Version**: 5.3.8  
**Status**: ✅ **PRODUCTION READY**

---

## 📚 Overview

JenniNexus uses a **unified icon sizing system** that supports three icon libraries:
1. **Bootstrap Icons** (.bi, .bi-*) - Primary icon library
2. **FontAwesome** (.fa, .fa-solid, .fa-brands, .fa-regular) - Brand and specialty icons
3. **SVG Icons** - Custom inline SVGs for unique designs

All three icon types follow **em-based sizing** (1em, 1.25em, 0.875em) to ensure consistent scaling across button sizes and responsive breakpoints.

---

## 🎨 Animation & Sizing Preferences

### Preferred Animations
**Location**: `src/assets/css/custom.css` (lines 591-673)

| Animation Class | Use Case | Example |
|----------------|----------|---------|
| `.svg-spin` | Loading indicators, processing states | `<i class="fa-solid fa-spinner svg-spin"></i>` |
| `.svg-beat` | Favorites, likes, hearts | `<i class="fa-solid fa-heart svg-beat"></i>` |
| `.svg-pulse` | Notifications, alerts | `<i class="fa-solid fa-bell svg-pulse"></i>` |
| `.svg-fade` | Attention-grabbing, subtle emphasis | `<i class="fa-solid fa-star svg-fade"></i>` |
| `.svg-bounce` | Call-to-action, upvotes | `<i class="fa-solid fa-arrow-up svg-bounce"></i>` |
| `.svg-shake` | Errors, warnings | `<i class="fa-solid fa-exclamation-triangle svg-shake"></i>` |

**Accessibility**: All animations respect `prefers-reduced-motion` and are automatically disabled for users who prefer reduced motion.

### Preferred Sizing
**Location**: `src/assets/css/custom.css` (lines 585-589)

| Size Class | Em Value | Pixel (16px base) | Use Case |
|-----------|---------|-------------------|----------|
| `.svg-xs` | 0.75em | 12px | Tiny inline icons, badges |
| `.svg-sm` | 0.875em | 14px | Small UI elements, compact buttons |
| `.svg-md` | 1.125em | 18px | Standard icons (default) |
| `.svg-lg` | 1.25em | 20px | Large buttons, emphasis |
| `.svg-xl` | 1.5em | 24px | Hero sections, feature highlights |
| `.svg-2xl` | 2em | 32px | Large features, headers |
| `.svg-3xl` | 3em | 48px | Hero icons, landing pages |

**Multipliers** (`.svg-1x` through `.svg-5x`): Use for precise sizing needs (1em-5em).

### Common Patterns

**Button Icons**:
```html
<!-- Small button -->
<button class="btn btn-sm">
  <i class="fa-solid fa-heart svg-sm me-1"></i>Like
</button>

<!-- Default button -->
<button class="btn">
  <i class="fa-solid fa-heart me-2"></i>Like
</button>

<!-- Large button -->
<button class="btn btn-lg">
  <i class="fa-solid fa-heart svg-lg me-2"></i>Like
</button>
```

**Card Headers**:
```html
<div class="card-header">
  <i class="fa-solid fa-gamepad svg-lg me-2"></i>
  <span>Gaming Section</span>
</div>
```

**Hero Sections**:
```html
<div class="hero-section">
  <i class="fa-solid fa-rocket svg-3xl mb-3"></i>
  <h1>Launch Your Game</h1>
</div>
```

**Loading States**:
```html
<button class="btn btn-primary" disabled>
  <i class="fa-solid fa-spinner svg-spin me-2"></i>
  Processing...
</button>
```

### Theme Integration
**Location**: `all-themes.css`, `theme-toggle.js`

**currentColor Usage** (Recommended):
```html
<!-- Icon inherits parent text color -->
<div style="color: var(--jenni-primary);">
  <i class="fa-solid fa-heart svg-lg"></i>
  <span>Automatically matches</span>
</div>
```

**CSS Variable Usage** (Brand Colors):
```html
<i class="fa-brands fa-youtube svg-2x" style="color: var(--youtube-red);"></i>
<i class="fa-brands fa-discord svg-2x" style="color: var(--discord-blurple);"></i>
<i class="fa-brands fa-twitch svg-2x" style="color: var(--twitch-purple);"></i>
```

**Bootstrap Integration**:
```html
<i class="fa-solid fa-check-circle text-success svg-lg"></i>
<i class="fa-solid fa-exclamation-triangle text-warning svg-lg"></i>
<i class="fa-solid fa-times-circle text-danger svg-lg"></i>
```

### Where We Use Animations

| Page/Section | Animation | Purpose |
|-------------|-----------|---------|
| Loading states (all pages) | `.svg-spin` | Indicate processing |
| Favorite buttons | `.svg-beat` | Draw attention to likes |
| Theme toggle | None | Instant feedback (rotation on hover) |
| Social links hover | None | Rely on transform/scale |
| Notification badges | `.svg-pulse` | Alert user to updates |
| Call-to-action buttons | `.svg-bounce` | Encourage clicks |

---

## 🗂️ FontAwesome Reference Directory (EXTERNAL - DO NOT BUILD HERE)

### ⚠️ CRITICAL: This directory is for REFERENCE ONLY

**Located at:**
- `C:\Users\Owner\Projects\Bootstrap\fontawesome-free-6.7.2-web\`

**Contents:**
- CSS files: `css/all.min.css`, `css/brands.min.css`, `css/solid.min.css`, etc.
- Webfonts: `webfonts/fa-brands-400.woff2`, `fa-solid-900.woff2`, `fa-regular-400.woff2`
- SVG source: `svgs/brands/`, `svgs/solid/`, `svgs/regular/`
- Documentation and examples

**Purpose:**
- ✅ **Reference** icon names and classes
- ✅ **Copy** SVG files for custom use
- ✅ **Learn** icon structure and variants
- ✅ **Upgrade** by copying new CSS/webfonts to JenniNexus

**DO NOT:**
- ❌ Modify files in this directory
- ❌ Build or compile in this directory
- ❌ Deploy this directory to production
- ❌ Link directly to this directory in HTML/PHP

**JenniNexus Integration:**
- **FontAwesome CSS:** `jenninexus/public_html/resources/vendor/fontawesome/css/all.min.css`
- **Webfonts:** `jenninexus/public_html/resources/vendor/fontawesome/webfonts/fa-*.woff2`
- **Loaded Via:** `jenninexus/public_html/includes/head.php`
- **Usage:** `<i class="fa-brands fa-discord"></i>`, `<i class="fa-solid fa-gamepad"></i>`

**Correct Workflow:**
1. Reference icons at `C:\Users\Owner\Projects\Bootstrap\fontawesome-free-6.7.2-web\`
2. Use icon classes in JenniNexus: `<i class="fa-brands fa-youtube"></i>`
3. If upgrading FontAwesome:
   - Copy `fontawesome-free-6.7.2-web/css/all.min.css` → `jenninexus/public_html/resources/vendor/fontawesome/css/all.min.css`
   - Copy `fontawesome-free-6.7.2-web/webfonts/*.woff2` → `jenninexus/public_html/resources/vendor/fontawesome/webfonts/`
4. Test at http://localhost:8002
5. Deploy with `jenninexus/scripts/deploy.ps1`

**Bootstrap Icons vs FontAwesome:**
- **Primary:** Bootstrap Icons (`.bi-*`) via CDN - for UI components, generic icons
- **Secondary:** FontAwesome (`.fa-*`) local CSS - for brand icons (Discord, Patreon), specialty icons
- **When to Use Each:**
  - Bootstrap Icons: Default choice for UI elements (youtube, github, envelope, etc.)
  - FontAwesome: When Bootstrap Icons lack specific icon (Discord brand, Patreon brand)

---

## 🎯 FontAwesome 6.7.2 Implementation

### Installation & Loading

**File**: `public_html/includes/head.php`

```php
<link href="<?= RES_ROOT ?>/vendor/fontawesome/css/all.min.css" rel="stylesheet">
```

**Source Files Location**:
- **Local**: `C:\Users\Owner\Projects\Bootstrap\fontawesome-free-6.7.2-web\`
- **Deployed**: `public_html/resources/vendor/fontawesome/css/all.min.css`
- **Webfonts**: `public_html/resources/vendor/fontawesome/webfonts/` (fa-brands-400.woff2, fa-solid-900.woff2, fa-regular-400.woff2)

---

## 🧪 Testing & Demo Page

### Theme Demo Page

**File**: `public_html/theme-demo.php`  
**URL**: http://localhost:8002/theme-demo.php  
**Purpose**: Development & testing only (local environments)

**Features**:
1. **Bootstrap 5.3.8 Components** - All buttons, cards, badges, alerts
2. **FontAwesome 6.7.2 Icons** - Solid, brands, animations
3. **Button Sizing System** - .btn-sm, .btn, .btn-lg with icons
4. **All Page Themes** - Patreon, Game Dev, Gaming, Live, DIY, Tags
5. **Responsive Grid** - Bootstrap breakpoint examples
6. **Icon Alignment** - Flexbox centering demo

**How to Access**:
```powershell
# Start local dev server
.\scripts\dev-server.ps1

# Open in browser
http://localhost:8002/theme-demo.php
```

---

## 📚 Related Documentation

### External Bootstrap 5.3.8 Reference

**Location**: `C:\Users\Owner\Projects\Bootstrap\bootstrap-5.3.8\`

### External FontAwesome Reference

**Location**: `C:\Users\Owner\Projects\Bootstrap\fontawesome-free-6.7.2-web\`

### Bootstrap Examples Reference

**Location**: `C:\Users\Owner\Projects\Bootstrap\bootstrap-5.3.8-examples\`
