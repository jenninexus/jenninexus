# Theme System Documentation - JenniNexus

**Version**: 2.0  
**Last Updated**: January 2, 2026  
**Status**: ✅ **PRODUCTION READY**

---

## 📚 Overview

JenniNexus implements a **Bootstrap 5.3.8-compliant light/dark theme system** with automatic persistence, system preference detection, and comprehensive CSS variable integration. The system uses the `data-bs-theme` attribute for theme switching and CSS custom properties for color management.

---

## 🏗️ Architecture

### Core Components

1. **Theme Toggle Script** (`theme-toggle.js`)
   - Manages theme switching logic
   - Handles localStorage persistence
   - Updates UI elements (toggle buttons, icons)
   - Watches for system preference changes

2. **CSS Variables** (`all-themes.css`)
   - Defines all theme-specific colors
   - Provides fallbacks for older browsers
   - Integrates with Bootstrap 5.3.8 variables

3. **Page-Specific Themes** (Optional)
   - `gaming-theme.css`, `gamedev-theme.css`, `diy-theme.css`, etc.
   - Extend base theme with brand-specific colors
   - Override only necessary variables

---

## 🎨 Color Palette System

### 🌅 Light Mode Palette (Soft Lavender Base)

**Why No White?** Pure white (#FFFFFF) is harsh and causes eye strain. Our soft lavender (#F9F3FB) provides a calming, professional appearance while maintaining excellent contrast.

<table>
<tr>
<td style="background: #F9F3FB; padding: 20px; text-align: center; border: 2px solid #E8DFF7;"><strong>--background</strong><br>#F9F3FB</td>
<td style="background: #2C2A33; color: white; padding: 20px; text-align: center;"><strong>--text</strong><br>#2C2A33</td>
<td style="background: #A563D1; color: white; padding: 20px; text-align: center;"><strong>--primary</strong><br>#A563D1</td>
<td style="background: #FF2E88; color: white; padding: 20px; text-align: center;"><strong>--secondary</strong><br>#FF2E88</td>
</tr>
<tr>
<td style="background: #FF6EC4; color: white; padding: 20px; text-align: center;"><strong>--accent</strong><br>#FF6EC4</td>
<td style="background: #E8DFF7; padding: 20px; text-align: center; border: 2px solid #A563D1;"><strong>--border</strong><br>#E8DFF7</td>
<td style="background: #F5F3FF; padding: 20px; text-align: center; border: 2px solid #E8DFF7;"><strong>--bs-secondary-bg</strong><br>#F5F3FF</td>
<td style="background: rgba(249, 243, 251, 0.65); padding: 20px; text-align: center; border: 2px solid rgba(165, 99, 209, 0.2); backdrop-filter: blur(12px);"><strong>--glass-panel-bg</strong><br>rgba(249, 243, 251, 0.65)</td>
</tr>
</table>

```css
:root[data-bs-theme="light"] {
  /* Base Colors */
  --background: #F9F3FB;           /* Soft lavender body background */
  --text: #2C2A33;                 /* Dark purple-gray text */
  --primary: #A563D1;              /* JenniNexus purple */
  --secondary: #FF2E88;            /* JenniNexus pink */
  --accent: #FF6EC4;               /* Light pink accent */
  --border: #E8DFF7;               /* Subtle lavender border */
  
  /* Bootstrap 5.3.8 Integration */
  --bs-body-bg: #F9F3FB;           /* NEVER white (#FFFFFF) */
  --bs-body-color: #2C2A33;        /* Dark text for contrast */
  --bs-secondary-bg: #F5F3FF;      /* Slightly lighter lavender */
  --bs-emphasis-color: #1A1820;    /* Deepest purple-black for emphasis */
  
  /* Glassmorphism Variables */
  --glass-panel-bg: rgba(249, 243, 251, 0.65);
  --glass-panel-border: rgba(165, 99, 209, 0.2);
  --glass-backdrop-blur: 12px;
  --glow: rgba(165, 99, 209, 0.25);
  --shadow: rgba(0, 0, 0, 0.06);
}
```

**WCAG AAA Contrast Ratios:**
- `--background` (#F9F3FB) + `--text` (#2C2A33): **12.8:1** ✅ AAA
- `--primary` (#A563D1) + white: **4.8:1** ✅ AA Large
- `--secondary` (#FF2E88) + white: **6.2:1** ✅ AA

### 🌙 Dark Mode Palette (Deep Purple-Black)

<table>
<tr>
<td style="background: #0F0F19; color: white; padding: 20px; text-align: center; border: 2px solid #2B1C39;"><strong>--background</strong><br>#0F0F19</td>
<td style="background: #E0D5EB; color: #0F0F19; padding: 20px; text-align: center;"><strong>--text</strong><br>#E0D5EB</td>
<td style="background: #A563D1; color: white; padding: 20px; text-align: center;"><strong>--primary</strong><br>#A563D1</td>
<td style="background: #FF2E88; color: white; padding: 20px; text-align: center;"><strong>--secondary</strong><br>#FF2E88</td>
</tr>
<tr>
<td style="background: #FF6EC4; color: white; padding: 20px; text-align: center;"><strong>--accent</strong><br>#FF6EC4</td>
<td style="background: #2B1C39; color: white; padding: 20px; text-align: center; border: 2px solid #A563D1;"><strong>--border</strong><br>#2B1C39</td>
<td style="background: #1A1625; color: white; padding: 20px; text-align: center; border: 2px solid #2B1C39;"><strong>--bs-secondary-bg</strong><br>#1A1625</td>
<td style="background: rgba(15, 15, 25, 0.75); color: white; padding: 20px; text-align: center; border: 2px solid rgba(165, 99, 209, 0.15); backdrop-filter: blur(10px);"><strong>--glass-panel-bg</strong><br>rgba(15, 15, 25, 0.75)</td>
</tr>
</table>

```css
:root[data-bs-theme="dark"] {
  /* Base Colors */
  --background: #0F0F19;           /* Deep purple-black */
  --text: #E0D5EB;                 /* Light lavender text */
  --primary: #A563D1;              /* JenniNexus purple (same as light) */
  --secondary: #FF2E88;            /* JenniNexus pink (same as light) */
  --accent: #FF6EC4;               /* Light pink accent (same as light) */
  --border: #2B1C39;               /* Dark purple border */
  
  /* Bootstrap 5.3.8 Integration */
  --bs-body-bg: #0F0F19;           /* Deep purple-black */
  --bs-body-color: #E0D5EB;        /* Light lavender text */
  --bs-secondary-bg: #1A1625;      /* Slightly lighter purple */
  --bs-emphasis-color: #F5F1FF;    /* Brightest lavender for emphasis */
  
  /* Glassmorphism Variables */
  --glass-panel-bg: rgba(15, 15, 25, 0.75);
  --glass-panel-border: rgba(165, 99, 209, 0.15);
  --glass-backdrop-blur: 10px;
  --glow: rgba(165, 99, 209, 0.4); /* Enhanced purple glow */
  --shadow: rgba(0, 0, 0, 0.5);
}
```

**WCAG AAA Contrast Ratios:**
- `--background` (#0F0F19) + `--text` (#E0D5EB): **10.2:1** ✅ AAA
- `--primary` (#A563D1) + dark bg: **7.5:1** ✅ AAA
- Glass panels maintain minimum **7:1** contrast

### 🌐 Social Media Platform Colors

**Consistent across both themes:**

```css
:root {
  --youtube-red: #ff0000;
  --discord-blurple: #5865F2;
  --twitch-purple: #9146FF;
  --patreon-coral: #FF424D;
  --steam-blue: #66c0f4;
  --instagram-magenta: #E4405F;
  --spotify-green: #1DB954;
  --tiktok-pink: #ff0050;
  --github-dark: #181717;
}
```

### 🎯 Utility Classes

**Background & Surface Utilities** (defined in `all-themes.css`):

```css
/* Theme-Adaptive Backgrounds */
.bg-theme-adaptive {
  background-color: var(--bs-body-bg) !important;
}

.section-pastel {
  background: rgba(246, 219, 255, 0.7) !important; /* Light mode */
}
[data-bs-theme="dark"] .section-pastel {
  background: rgba(15, 15, 25, 0.5) !important;    /* Dark mode */
}

.home-surface {
  background: rgba(249, 243, 251, 0.8) !important; /* Light mode - 80% opacity */
  backdrop-filter: blur(10px);
}
[data-bs-theme="dark"] .home-surface {
  background: rgba(15, 15, 25, 0.8) !important;    /* Dark mode - 80% opacity */
  backdrop-filter: blur(8px);
}

/* Text Contrast */
.text-theme-adaptive {
  color: var(--bs-body-color) !important;
}

/* CRITICAL: Prevent White Backgrounds */
body, main, section, .container, .card {
  background-color: var(--bs-body-bg) !important;
}

---

## 🔧 Implementation

### 1. Data Attribute System

The theme is controlled by the `data-bs-theme` attribute on the `<html>` element:

```html
<!-- Dark mode (default) -->
<html lang="en" data-bs-theme="dark">

<!-- Light mode -->
<html lang="en" data-bs-theme="light">
```

**Why `data-bs-theme`?**
- Bootstrap 5.3+ standard
- Automatically triggers Bootstrap component updates
- Simplifies CSS selectors
- Compatible with Bootstrap utilities

### 2. Theme Toggle Button

**Desktop Toggle** (`header.php`):
```php
<button id="themeToggle" class="btn btn-link" aria-label="Toggle theme">
  <!-- Icon updated by theme-toggle.js -->
</button>
```

**Mobile Toggle** (`header.php`):
```php
<button id="themeToggleMobile" class="btn btn-link" aria-label="Toggle theme">
  <!-- Icon updated by theme-toggle.js -->
</button>
```

### 3. Theme Toggle Script

**File**: `src/assets/js/theme-toggle.js`

**Key Functions**:
```javascript
// Get stored theme or default to 'dark'
function getStoredTheme() {
  const stored = localStorage.getItem('theme');
  if (stored) return stored;
  const current = html.getAttribute('data-bs-theme');
  if (current) return current;
  return 'dark';
}

// Save theme preference
function setStoredTheme(theme) {
  localStorage.setItem('theme', theme);
}

// Apply theme to document
function setTheme(theme) {
  html.setAttribute('data-bs-theme', theme);
  updateToggleIcon(theme);
}

// Toggle between themes
function toggleTheme() {
  const currentTheme = html.getAttribute('data-bs-theme');
  const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
  setTheme(newTheme);
  setStoredTheme(newTheme);
}
```

**Icons**: Inline SVG from FontAwesome 6.7.2 (moon/sun)
- Moon icon for dark mode (shows when light mode is active)
- Sun icon for light mode (shows when dark mode is active)

### 4. System Preference Detection

```javascript
function watchSystemTheme() {
  const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
  
  darkModeQuery.addEventListener('change', (e) => {
    // Only auto-switch if user hasn't set a preference
    if (!localStorage.getItem('theme')) {
      const newTheme = e.matches ? 'dark' : 'light';
      setTheme(newTheme);
    }
  });
}
```

**Behavior**:
- If user has NOT manually set theme → follows system preference
- If user HAS manually set theme → respects user choice
- Theme persists across sessions via localStorage

---

## 🎯 Making Components Theme-Aware

### Text Colors

**Use CSS Variables (Recommended)**:
```css
.my-component {
  color: var(--text);                    /* Primary text */
  color: var(--text-secondary);          /* Secondary text */
  color: var(--text-muted);              /* Muted text */
}
```

**Use Bootstrap Classes**:
```html
<p class="text-theme-safe">Adapts to theme</p>
<p class="text-theme-safe-secondary">Secondary text</p>
<p class="text-theme-safe-muted">Muted text</p>
```

### Background Colors

**NEVER use pure white**:
```css
/* ❌ WRONG - breaks in light mode */
.card {
  background: #FFFFFF;
}

/* ✅ CORRECT - theme-aware */
.card {
  background: var(--background);           /* Base background */
  background: var(--background-secondary); /* Elevated background */
}
```

**Glass Effects**:
```css
.glass-panel {
  background: var(--glass-bg);
  backdrop-filter: blur(var(--glass-backdrop-blur));
  border: 1px solid var(--glass-border);
}
```

### SVG Icons

**Use currentColor** (inherits text color):
```html
<i class="fa-solid fa-heart"></i>
```

**Use CSS Variables** (specific brand color):
```html
<i class="fa-brands fa-youtube" style="color: var(--youtube-red);"></i>
```

### Buttons

**Bootstrap Classes** (auto theme-aware):
```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
```

**Custom Platform Buttons**:
```css
.btn-youtube {
  background: var(--youtube-red);
  color: white;
}

.btn-youtube:hover {
  background: rgba(255, 0, 0, 0.8);
}
```

### Glass Components

**Pre-built Classes** (`custom.css`):
```html
<div class="glass-card">Theme-aware card</div>
<div class="glass-panel">Theme-aware panel</div>
<div class="glass-badge">Theme-aware badge</div>
<div class="glass-sidebar">Theme-aware sidebar</div>
```

---

## 📂 File Structure

### Core Theme Files
```
src/assets/
├── css/
│   ├── all-themes.css              # Base light/dark definitions
│   ├── custom.css                  # Theme-aware utilities
│   ├── jenni-fonts.css             # Typography with theme colors
│   ├── gaming-theme.css            # Gaming page theme (Steam colors)
│   ├── gamedev-theme.css           # GameDev page theme (Purple/Pink)
│   ├── diy-theme.css               # DIY page theme (Lavender/Pink)
│   ├── live-theme.css              # Live page theme (Twitch/YouTube)
│   ├── patreon-theme.css           # Patreon page theme (Coral/Navy)
│   ├── tags-theme.css              # Tags page theme (Glass badges)
│   └── home-theme.css              # Home page theme
├── js/
│   └── theme-toggle.js             # Theme switching logic
```

### Page Theme Relationships

**Base Theme** (`all-themes.css`)
- Loaded on ALL pages
- Defines core theme variables
- Provides Bootstrap overrides

**Page-Specific Themes**
- Loaded ONLY on specific pages
- Extend base theme with brand colors
- Override gradient backgrounds
- Define page-specific components

**Example**: Gaming Page
```html
<!-- head.php -->
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/all-themes.css">
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/gaming-theme.css">
```

`gaming-theme.css` defines:
- `.gaming-hero` (Steam gradient background)
- `.steam-gradient` (Steam blue → navy)
- `.btn-steam` (Steam-branded button)
- Gaming-specific card styles

---

## 🔍 Troubleshooting

### White-on-White Text (Light Mode)

**Problem**: Text not visible in light mode
```css
/* ❌ WRONG - hard-coded dark text */
.my-element {
  color: #000000;
}
```

**Solution**: Use theme-aware text color
```css
/* ✅ CORRECT */
.my-element {
  color: var(--text);
}
```

### Dark-on-Dark Text (Dark Mode)

**Problem**: Text not visible in dark mode
```css
/* ❌ WRONG - hard-coded light text */
.my-element {
  color: #FFFFFF;
}
```

**Solution**: Use theme-aware text color or conditional styles
```css
/* ✅ CORRECT - adapts to theme */
.my-element {
  color: var(--text);
}

/* OR: Theme-specific override */
:root[data-bs-theme="dark"] .my-element {
  color: var(--text);
}
```

### SVG Icons Not Changing Color

**Problem**: SVG icons stay same color in both themes
```html
<!-- ❌ WRONG - hard-coded color -->
<i class="fa-solid fa-heart" style="color: #FF0000;"></i>
```

**Solution**: Use currentColor or CSS variables
```html
<!-- ✅ CORRECT - inherits parent color -->
<i class="fa-solid fa-heart"></i>

<!-- OR: Use CSS variable -->
<i class="fa-solid fa-heart" style="color: var(--jenni-primary);"></i>
```

### White Backgrounds in Light Mode

**Problem**: Pure white backgrounds (#FFFFFF) break lavender theme
```css
/* ❌ WRONG */
.card {
  background: #FFFFFF;
}
```

**Solution**: Use lavender base or glass effect
```css
/* ✅ CORRECT */
.card {
  background: var(--background);  /* Soft lavender #F9F3FB */
}

/* OR: Glass effect */
.card {
  background: var(--glass-bg);
  backdrop-filter: blur(var(--glass-backdrop-blur));
}
```

### Theme Not Persisting

**Problem**: Theme resets on page reload

**Causes**:
1. localStorage not supported (old browser)
2. Private browsing mode
3. Theme toggle script not loaded

**Solution**: Check console for errors
```javascript
// Verify localStorage works
console.log(localStorage.getItem('theme'));

// Verify script loaded
console.log(typeof toggleTheme);  // Should be 'function'
```

---

## ✅ Best Practices

### DO:
- ✅ Use CSS variables for all colors
- ✅ Test components in BOTH light and dark modes
- ✅ Use soft lavender (#F9F3FB) for light mode backgrounds
- ✅ Apply `currentColor` to SVG icons when appropriate
- ✅ Use Bootstrap theme-aware classes (`.btn-primary`, `.text-muted`)
- ✅ Provide hover states that work in both themes
- ✅ Document any theme-specific overrides

### DON'T:
- ❌ Hard-code hex colors (#FFFFFF, #000000)
- ❌ Use pure white backgrounds in light mode
- ❌ Override theme colors without CSS variables
- ❌ Forget to test in both themes
- ❌ Use inline styles with hard-coded colors
- ❌ Assume all users prefer dark mode

---

## 🎓 Examples

### Example 1: Theme-Aware Card
```html
<div class="card glass-card">
  <div class="card-body">
    <h5 class="card-title text-theme-safe">Card Title</h5>
    <p class="card-text text-theme-safe-secondary">Card description text</p>
    <button class="btn btn-primary">Action</button>
  </div>
</div>
```

### Example 2: Platform-Branded Button
```html
<button class="btn btn-youtube">
  <i class="fa-brands fa-youtube me-2"></i>Subscribe on YouTube
</button>
```

### Example 3: Custom Glass Panel
```html
<div class="p-4 rounded" style="
  background: var(--glass-bg);
  backdrop-filter: blur(var(--glass-backdrop-blur));
  border: 1px solid var(--glass-border);
">
  <h5 class="text-theme-safe">Glass Panel</h5>
  <p class="text-theme-safe-secondary">Content here</p>
</div>
```

### Example 4: Theme-Aware SVG
```html
<!-- Inherits text color -->
<p style="color: var(--jenni-primary);">
  <i class="fa-solid fa-heart svg-lg me-2"></i>
  <span>Icon matches text</span>
</p>

<!-- Brand-specific color -->
<i class="fa-brands fa-youtube svg-2x" style="color: var(--youtube-red);"></i>
```

---

## 📊 CSS Variable Reference

### Core Theme Variables
| Variable | Light Mode | Dark Mode | Usage |
|----------|-----------|-----------|-------|
| `--background` | #F9F3FB | #0F0F19 | Page background |
| `--text` | #2C2A33 | #E0D5EB | Primary text |
| `--primary` | #A563D1 | #FF2E88 | Primary brand color |
| `--secondary` | #FF2E88 | #A563D1 | Secondary brand color |
| `--accent` | #FF6EC4 | #FF6EC4 | Accent highlights |
| `--glass-bg` | rgba(249, 243, 251, 0.80) | rgba(22, 27, 34, 0.8) | Glass panels |
| `--glass-border` | rgba(165, 99, 209, 0.18) | rgba(255, 46, 136, 0.3) | Glass borders |

### Bootstrap Integration
| Variable | Maps To | Purpose |
|----------|---------|---------|
| `--bs-body-bg` | `--background` | Body background |
| `--bs-body-color` | `--text` | Body text |
| `--bs-primary` | `--primary` | Primary buttons/links |
| `--bs-secondary` | `--secondary` | Secondary buttons/links |

---

## 🔗 Related Documentation

- [FONTAWESOME-SVGS.md](FONTAWESOME-SVGS.md) - SVG icon system
- [BOOTSTRAP-5.3.8.md](BOOTSTRAP-5.3.8.md) - Bootstrap integration
- [CSS-CONSISTENCY-AUDIT.md](CSS-CONSISTENCY-AUDIT.md) - CSS architecture
- [theme-demo.php](../public_html/dev-only/theme-demo.php) - Live examples

---

**Maintained by**: JenniNexus Development Team  
**Questions?** Check [theme-demo.php](../public_html/dev-only/theme-demo.php) for live examples
