# CSS Architecture (Post-Bootstrap 5.3.8)

**Last Updated**: October 31, 2025  
**Bootstrap Version**: 5.3.8  
**SCSS Status**: Archived (no longer compiled)

## Overview

JenniNexus uses **direct CSS files** with Bootstrap 5.3.8's CSS custom properties. No SCSS compilation is required.

## Why Direct CSS?

### Bootstrap 5.3.8 Migration
- Bootstrap 5.3.8 uses **CSS custom properties** (`--bs-*`) instead of SCSS variables
- Runtime theme switching via `[data-bs-theme="dark"]`
- No compilation step needed - edit CSS directly
- Faster development and builds

### Glass Effects & Animations
- Defined as **CSS custom properties** in `custom.css`
- Theme-specific overrides in individual theme files
- No need for SCSS mixins or functions

## File Structure

```
public_html/resources/css/
├── bootstrap.min.css          → Bootstrap 5.3.8 core (CDN fallback)
├── fontawesome-all.min.css    → Font Awesome 6.7.2 icons
├── all-themes.css             → Light/dark theme system
├── custom.css                 → Base styles, glass effects, typography
├── main.css                   → Legacy (may be removed)
├── main.min.css               → Legacy (may be removed)
├── diy-theme.css              → DIY page theme
├── gamedev-theme.css          → Game development page theme
├── gaming-theme.css           → Gaming page theme
├── live-theme.css             → Live streaming page theme
├── tags-theme.css             → Tag system theme
└── patreon-theme.css          → Patreon integration theme
```

## Core Files

### 1. all-themes.css
**Purpose**: Light/dark theme system with animations

**Features**:
- `:root[data-theme="light"]` - Light theme colors
- `:root[data-theme="dark"]` - Dark theme colors
- Investment-focused animations (neonPulse, investmentGlow, professionalFloat)
- Theme-specific enhancements (glass effects, glows, borders)
- Accessibility support (prefers-reduced-motion, prefers-contrast)

**Key Animations**:
```css
@keyframes neonPulse { /* Pulsating glow effect */ }
@keyframes investmentGlow { /* Box shadow glow */ }
@keyframes professionalFloat { /* Subtle floating motion */ }
@keyframes metricCounter { /* Number counter animation */ }
```

### 2. custom.css
**Purpose**: Base styles, glass morphism, typography, brand colors

**Key Features**:

#### Brand Colors
```css
:root {
  --jenni-primary: #FF2E88;      /* Hot pink - creator energy */
  --jenni-secondary: #A563D1;    /* Purple - creativity */
  --jenni-accent: #FF6EC4;       /* Light pink - highlights */
  --jenni-success: #00D4AA;      /* Teal - achievements */
  --jenni-warning: #FFB020;      /* Orange - attention */
  --jenni-error: #FF4757;        /* Red - errors */
  --jenni-info: #5352ED;         /* Blue - information */
}
```

#### Glass Morphism
```css
/* Light Theme */
--glass-bg: rgba(255, 255, 255, 0.8);
--glass-border: rgba(0, 0, 0, 0.1);
--glass-backdrop-blur: 8px;

/* Dark Theme */
--glass-bg: rgba(22, 27, 34, 0.8);
--glass-border: rgba(255, 46, 136, 0.3);
--glass-backdrop-blur: 12px;

/* Apply with utility class */
.site-glass {
  background-color: var(--glass-bg) !important;
  border: 1px solid var(--glass-border) !important;
  backdrop-filter: blur(var(--glass-backdrop-blur));
}
```

#### Typography
```css
body {
  font-family: 'Montserrat', 'Segoe UI', system-ui, sans-serif;
  font-weight: 400;
  line-height: 1.6;
}
```

#### Brand Text Styling
- `.jenni-text` - Hot pink with rainbow gradient hover
- `.nexus-text`, `.diy-text` - Purple with metallic gradient hover
- `.with-text` - Elegant script font (Parisienne)

## Page-Specific Themes

### 3. gaming-theme.css
**Purpose**: Gaming content styling

**Features**:
- Steam pulse animation
- Gaming short card hover effects
- Play overlay transitions
- Badge colors: danger (red), purple, teal, steam blue
- Responsive grid layouts

**Key Colors**:
```css
--gaming-primary: #00D4AA;     /* Teal */
--gaming-secondary: #FF2E88;   /* Hot pink */
--gaming-steam: #1B2838;       /* Steam navy */
```

### 4. gamedev-theme.css
**Purpose**: Game development content styling

**Features**:
- Pulse glow animation
- Project card hover effects
- Platform-specific styling (Unity, Unreal, Steam)
- Martian Games branding
- Trophy/controller icon animations

**Key Colors**:
```css
--gamedev-primary: #6750A4;    /* Professional purple */
--gamedev-accent: #FF6EC4;     /* Pink accent */
--gamedev-unity: #000000;      /* Unity black */
```

### 5. diy-theme.css
**Purpose**: DIY fashion/beauty content styling

**Features**:
- Beautiful gradient cards with shimmer effects
- Category-specific colors (fashion, beauty, selfcare)
- Animated badge styles
- Hover transformations with smooth transitions

**Key Colors**:
```css
--diy-fashion: linear-gradient(135deg, #FF2E88, #FF6EC4);
--diy-beauty: linear-gradient(135deg, #A563D1, #D14BFF);
--diy-selfcare: linear-gradient(135deg, #00D4AA, #5352ED);
```

### 6. live-theme.css
**Purpose**: Live streaming page styling

**Features**:
- Twitch purple and YouTube red theming
- Live pulse animation for badges
- Platform card hover effects
- Discord community styling
- Stream schedule table

**Key Colors**:
```css
--live-twitch: #9146ff;        /* Twitch purple */
--live-youtube: #ff0000;       /* YouTube red */
--live-discord: #5865F2;       /* Discord blurple */
```

### 7. tags-theme.css
**Purpose**: Tag filtering system styling

**Features**:
- Tag badge interactive styles
- Tag cloud container
- Filtered results cards
- Content type badges (game, blog, video, page)
- Search input styling

**Key Colors**:
```css
--tags-primary: #6750A4;       /* Purple */
--tags-secondary: #FF2E88;     /* Pink */
--tags-accent: #00D4AA;        /* Teal */
```

### 8. patreon-theme.css
**Purpose**: Patreon integration styling

**Features**:
- Patreon coral brand color
- VIP content blur/reveal effects
- Shimmer loading skeleton
- Tier card styling
- Patreon icon animations

**Key Colors**:
```css
--patreon-coral: #FF424D;      /* Patreon coral */
--patreon-navy: #052D49;       /* Patreon navy */
```

## Bootstrap 5.3.8 Custom Properties

Bootstrap provides extensive CSS custom properties:

```css
/* Colors */
--bs-primary: #6750A4;
--bs-secondary: #E91E63;
--bs-success: #00D4AA;
--bs-info: #5352ED;
--bs-warning: #FFB020;
--bs-danger: #FF4757;

/* Body */
--bs-body-bg: #FFFFFF;
--bs-body-color: #212529;
--bs-body-font-family: system-ui, -apple-system, "Segoe UI", sans-serif;

/* Borders */
--bs-border-width: 1px;
--bs-border-color: #DEE2E6;
--bs-border-radius: 0.375rem;

/* Spacing */
--bs-gutter-x: 1.5rem;
--bs-gutter-y: 0;
```

## Theme Switching

### JavaScript Implementation
```javascript
// Theme toggle (theme-toggle.js)
const currentTheme = document.documentElement.getAttribute('data-bs-theme');
const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
document.documentElement.setAttribute('data-bs-theme', newTheme);
localStorage.setItem('theme', newTheme);
```

### CSS Theme Detection
```css
/* Light theme (default) */
:root,
:root[data-bs-theme="light"] {
  --bs-body-bg: #FFFFFF;
  --bs-body-color: #212529;
}

/* Dark theme */
:root[data-bs-theme="dark"] {
  --bs-body-bg: #0A0A0A;
  --bs-body-color: #E0D5EB;
}
```

## Adding New Styles

### Option 1: Edit Existing Files (Recommended)
1. Identify appropriate file:
   - Base styles → `custom.css`
   - Theme colors → `all-themes.css`
   - Page-specific → `*-theme.css`
2. Edit CSS directly (no compilation needed)
3. Test in browser (hard refresh: Ctrl+Shift+R)

### Option 2: Create New Theme File
1. Create `src/assets/css/new-theme.css`
2. Run `.\scripts\build.ps1` to copy to public
3. Include in PHP:
```php
<link rel="stylesheet" href="/resources/css/new-theme.css">
```

### Option 3: Use Bootstrap Utilities
Bootstrap 5.3.8 provides extensive utility classes:
```html
<!-- Colors -->
<div class="text-primary bg-dark border-success">...</div>

<!-- Spacing -->
<div class="mt-3 p-4 mx-auto">...</div>

<!-- Flexbox -->
<div class="d-flex justify-content-center align-items-start gap-3">...</div>

<!-- Display -->
<div class="d-none d-md-block">...</div>
```

## Animation System

### Keyframes Available
- `neonPulse` - Pulsating glow (all-themes.css)
- `investmentGlow` - Box shadow pulse (all-themes.css)
- `professionalFloat` - Subtle floating (all-themes.css)
- `pulse-glow` - Color pulse (gamedev-theme.css, patreon-theme.css)
- `shimmer` - Loading skeleton (patreon-theme.css)
- `live-pulse` - Live indicator (live-theme.css)

### Using Animations
```css
.animated-element {
  animation: neonPulse 4s ease-in-out infinite;
}

/* Respect user preferences */
@media (prefers-reduced-motion: reduce) {
  .animated-element {
    animation: none;
  }
}
```

## Performance Considerations

### CSS Loading Strategy
1. **Bootstrap** (CDN with local fallback)
2. **Font Awesome** (local)
3. **all-themes.css** (theme system)
4. **custom.css** (base styles)
5. **page-specific-theme.css** (only on relevant pages)

### Optimization Tips
- Use CSS custom properties for runtime values
- Leverage Bootstrap utilities before custom CSS
- Minimize custom styles per page
- Use `backdrop-filter` sparingly (GPU-intensive)
- Respect `prefers-reduced-motion`

## Migration from SCSS

### What Changed
- **SCSS directory archived**: `src/assets/scss/` → `src/assets/scss.archived/`
- **No compilation**: Direct CSS files only
- **Variables → Custom Properties**: SCSS variables replaced with CSS `var(--*)`
- **Mixins → Utilities**: SCSS mixins replaced with Bootstrap utilities or direct CSS

### Archived SCSS Files
For reference, archived SCSS structure:
```
scss.archived/
├── main.scss                  → Deprecated entry point
├── base/                      → Colors (now in custom.css)
├── abstracts/                 → Animations, glass, mixins (now in CSS)
├── themes/                    → Theme system (now in all-themes.css)
├── layout/                    → Layout (now Bootstrap utilities)
└── components/                → Components (now in *-theme.css)
```

## Troubleshooting

### Issue: Styles not applying
1. Check browser console for 404 errors
2. Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
3. Verify file exists in `public_html/resources/css/`
4. Check CSS file is linked in PHP page

### Issue: Theme not switching
1. Verify `theme-toggle.js` is loaded
2. Check `data-bs-theme` attribute on `<html>` element
3. Ensure theme colors defined in `all-themes.css`

### Issue: Animations not working
1. Check `prefers-reduced-motion` user preference
2. Verify keyframes defined in CSS file
3. Test in different browsers (Safari, Chrome, Firefox)

## Resources

- **Bootstrap 5.3.8 Docs**: https://getbootstrap.com/docs/5.3/
- **CSS Custom Properties**: https://developer.mozilla.org/en-US/docs/Web/CSS/--*
- **Font Awesome Icons**: https://fontawesome.com/icons

---

**See also**:
- `src/assets/README.md` - Build process
- `src/assets/scss.archived/README.md` - Why SCSS was deprecated
- `storage/docs/CSS-SCSS.md` - Legacy SCSS documentation
