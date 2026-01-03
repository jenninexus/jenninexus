# Source Assets Directory

**Purpose**: Development source files for JenniNexus  
**Build Target**: `public_html/resources/`  
**Last Updated**: December 25, 2025

## 🎯 Sitewide Protocol Established

**Interactive Element Standards** (Updated Dec 25, 2025):
- ✅ **Color Change** on hover (brand/accent colors)
- ✅ **Glow Effect** (box-shadow with platform color)
- ✅ **Animation** (zoom, lift, or pulse)
- ✅ **Smooth Transitions** (0.3s ease or cubic-bezier)
- ✅ **Theme Consistency** (documented in `theme-demo.php`)
- ✅ **Platform Colors** (YouTube, Discord, Twitch, etc. - maintained across themes)

See `public_html/theme-demo.php` section "Sitewide Hover Protocol" for complete implementation guide.

## ⚠️ CSS ARCHITECTURE - Direct CSS (No SCSS Compilation)

The `scss/` directory has been **archived to `scss.archived/`** because:
- **Bootstrap 5.3.8** provides all base variables via `--bs-*` custom properties
- **Glass effects** are defined in `custom.css` using CSS custom properties
- **Animations** are included in individual theme CSS files
- **No compilation needed** - all styles are direct CSS
- **Theme-adaptive** - Platform colors maintain brand identity across light/dark modes

## Directory Structure

```
src/assets/
├── css/              → Pre-compiled CSS (copied to public)
├── fonts/            → Font files (WOFF, WOFF2, TTF)
├── images/           → Source images (unoptimized originals)
├── js/               → JavaScript source files
├── scss.archived/    → Archived SCSS (no longer compiled)
├── svgs/             → SVG icons and graphics
├── pdfs/             → PDF documents
├── blog posts/       → Markdown blog posts
├── playlists/        → YAML playlist configurations
└── README.md         → This file
```

## Build Process

### Source → Public Workflow

```
src/assets/          →  Build  →  public_html/resources/
├── css/             →          → css/
├── fonts/           →          → fonts/
├── images/          →          → images/
├── js/              →          → js/
├── svgs/            →          → svgs/
├── pdfs/            →          → pdfs/
├── blog posts/      →          → blog posts/
└── playlists/       →          → playlists/
```

### Build Commands

```powershell
# Standard build (copies CSS files, no SCSS compilation)
.\scripts\build.ps1

# Build with cleanup
.\scripts\build.ps1 -Clean

# Build + Deploy (Production)
.\scripts\build-and-deploy.ps1

# Deploy only (skip build)
.\scripts\deploy.ps1 -SkipBuild

# Dev server (local testing)
.\scripts\dev-server.ps1
```

**What happens during build**:
1. Copies all assets from `src/assets/` to `public_html/resources/`
2. Logs operations to `storage/logs/build-YYYY-MM-DD.log`
3. Reports file counts and any errors
4. (Optional) Removes legacy HTML files if `-Clean` flag used

**What happens during deployment**:
1. Runs build process (unless `-SkipBuild` flag used)
2. Syncs `public_html/` to remote server via FTP/SFTP
3. Sets proper file permissions (644 for files, 755 for directories)
4. Logs deployment operations
5. Confirms successful deployment

## CSS Architecture (Post-Bootstrap 5.3.8)

All styles are now **direct CSS files** using Bootstrap 5.3.8's CSS custom properties:

### Core Styles
- `custom.css` - Base styles, glass effects, typography, responsive button system
- `all-themes.css` - Light/dark theme system with platform colors and animations
- `home-theme.css` - Homepage-specific styles with icon glow animations

### Page-Specific Themes
- `gaming-theme.css` - Gaming page colors and cards
- `gamedev-theme.css` - Game development page styling
- `diy-theme.css` - DIY fashion/beauty page styles
- `live-theme.css` - Twitch/YouTube streaming page
- `tags-theme.css` - Tag system and filtering
- `patreon-theme.css` - Patreon integration styles

### Platform Color System (all-themes.css)
All social media platform buttons maintain brand colors across themes:
- **YouTube**: `--youtube-red: #ff0000` (solid + outline variants)
- **Discord**: `--discord-blurple: #5865F2` (+ dark/light variants)
- **Twitch**: `--twitch-purple: #9146FF` (+ dark/light variants)
- **Patreon**: `--patreon-coral: #FF424D` (+ dark/light variants)
- **Instagram**: Gradient (magenta to purple)
- **Steam**: `--steam-navy` + `--steam-blue` (dual-color system)
- **TikTok**: `--tiktok-black` + `--tiktok-pink` border
- **GitHub**: `--github-dark: #333333` (+ light variant)
- **Spotify**: `--spotify-green: #1DB954` (+ dark variant)

**Theme Adaptation**: Platform colors stay consistent; shadows/glows adjust for light/dark mode.

### Why Direct CSS?
1. **Bootstrap 5.3.8** uses CSS custom properties (`--bs-primary`, `--bs-body-bg`, etc.)
2. **No SCSS variables needed** - everything is runtime-configurable
3. **Faster builds** - no compilation step
4. **Easier debugging** - inspect actual CSS in DevTools
5. **Better performance** - no build pipeline delays
6. **Theme-adaptive** - Platform colors + hover effects adapt to active theme

### Browser Compatibility Protocol
**Critical vendor prefixes** (documented in `storage/docs/CSS-SCSS.md`):
- `-webkit-backdrop-filter` (before `backdrop-filter`) - Safari/iOS support
- `-webkit-user-select` (before `user-select`) - Safari/iOS support

**Property Ordering Rule**: Vendor prefixes MUST come before the standard property.

```css
/* ✅ CORRECT */
.element {
  -webkit-backdrop-filter: blur(12px);
  backdrop-filter: blur(12px);
}

/* ❌ WRONG */
.element {
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
}
```

## JavaScript Files

### Active JS Files (in use)
Located in `public_html/resources/js/`:

1. **theme-toggle.js** - Dark/light theme switcher
2. **back-to-top.js** - Scroll-to-top button
3. **youtube-grid.js** - YouTube playlist grid loader
4. **diy-playlists.js** - DIY page playlist handler
5. **music-playlists.js** - Music page playlist handler
6. **martian-games.js** - Martian Games showcase
7. **patreon-auth-enhanced.js** - Patreon authentication
8. **tag-system.js** - Content tagging system
9. **performance-optimizer.js** - Page performance optimizations
10. **polyfills.js** - Browser compatibility polyfills

**Total**: 10 active JavaScript files

### Archived JS Files (not in use)
Located in `public_html/resources/js/!bak/`:

These files are no longer used but kept for reference:
- breakpoints.js
- core-web-vitals.js
- disney-animations.js
- diy-filter.js
- gamedev-filter.js
- gaming-filter.js
- glightbox.js
- main.js
- neon-effects.js
- neophi.js
- patreon-auth.js (replaced by patreon-auth-enhanced.js)
- performance.js (replaced by performance-optimizer.js)
- social-links.js
- swiper-init.js
- tabs.js
- tag-colors.js
- tags.js
- video-embed.js
- video-filter.js

**Note**: The `src/assets/js/` directory is currently empty. Active JS files are maintained directly in `public_html/resources/js/` for easier development.

## SCSS Files

### Structure
```
src/assets/scss/
├── main.scss              # Main stylesheet (imports all others)
├── abstracts/             # Variables, mixins, functions
│   ├── _animations.scss
│   ├── _mixins.scss
│   ├── _variables.scss
│   └── ...
├── base/                  # Reset, typography, core styles
│   ├── _reset.scss
│   ├── _typography.scss
│   └── ...
├── components/            # Component-specific styles
│   ├── _buttons.scss
│   ├── _cards.scss
│   └── ...
├── layout/                # Layout styles
├── pages/                 # Page-specific styles
├── themes/                # Theme variations
└── utils/                 # Utility classes
```

### Compilation

**Currently**: SCSS files are compiled manually or via external tools  
**Output**: `public_html/resources/css/main.css`

**Future Enhancement**: Add SCSS compilation to build script

## CSS Files

### Custom CSS (in `src/assets/css/`)
- **custom.css** - Custom styles and overrides
- **all-themes.css** - Theme variations

**Load Order**:
```html
1. Bootstrap 5.3.3 CSS (CDN)
2. Custom CSS (resources/css/custom.css)
```

This ensures custom styles override Bootstrap defaults.

## Images

### Source Images (`src/assets/images/`)
- Unoptimized originals
- High-resolution versions
- Edit these when needed

### Public Images (`public_html/resources/images/`)
- Optimized for web
- Built from source images
- Served to users

### Image Structure
```
images/
├── gamedev/              # Game development screenshots
│   ├── blueballs/
│   ├── botborgs/
│   ├── catgame/
│   └── ...
└── profilepix/           # Profile images
```

## Fonts

### Custom Fonts
- Font files in WOFF, WOFF2, TTF formats
- Google Fonts also used (CDN):
  - Parisienne
  - Montserrat
  - Alien League

## SVGs

### Icon System
- Custom SVG icons and graphics
- Stored in `svgs/` directory
- Used for logos, icons, decorative elements

## PDFs

### Documents
- Resume (resume_jenninexus_2025.pdf)
- Guides and resources
- Available for download on website

## Playlists

### YAML Configuration Files
Located in `playlists/`:

1. **diy.yaml** - DIY w/ Jenni playlists
2. **music.yaml** - Music playlists
3. **gamedev.yaml** - Game development videos
4. **gaming.yaml** - Gaming videos
5. **live.yaml** - Live stream VODs
6. **patreon.yaml** - Patreon VIP content

**Format**: YAML with playlist metadata and video IDs  
**Loader**: `resources/js/youtube-grid.js`

## Blog Posts

### Markdown Files
Located in `blog posts/`:

1. ai-tools-for-technical-artists.md
2. diy-beauty-trends-2025.md
3. game-dev-in-2025.md
4. pax-west-gaming-con.md
5. voice-acting-in-games.md

**Format**: Markdown  
**Used in**: blog.php (loaded via JavaScript)

## Best Practices

### When to Edit Source Files

1. **JavaScript**: Edit directly in `public_html/resources/js/` (no source copy needed)
2. **CSS**: Edit in `src/assets/css/` or `src/assets/scss/`, then build
3. **Images**: Edit originals in `src/assets/images/`, then build
4. **Fonts**: Add to `src/assets/fonts/`, then build
5. **SVGs**: Edit in `src/assets/svgs/`, then build
6. **PDFs**: Replace in `src/assets/pdfs/`, then build
7. **Playlists**: Edit YAML in `src/assets/playlists/`, then build
8. **Blog Posts**: Edit Markdown in `src/assets/blog posts/`, then build

### Build Workflow

```powershell
# 1. Edit source files in src/assets/
# 2. Build to public_html/resources/
.\scripts\build.ps1

# 3. Test locally
.\scripts\dev-server.ps1

# 4. Check build log
cat storage\logs\build-2025-10-14.log

# 5. Deploy (when ready)
.\scripts\deploy.ps1
```

### Archive Unused Files

**Location**: `public_html/resources/js/!bak/`  
**Purpose**: Keep old files for reference without cluttering active directory

## Bootstrap Integration

### Current Version: Bootstrap 5.3.3

**Note**: References to "5.3.8" in code comments refer to the Bootstrap methodology/examples, not the actual CDN version. We're using the latest stable version (5.3.3) with proper SRI hashes for security.

**CDN Links**:
```html
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
      crossorigin="anonymous">

<!-- JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
```

### Bootstrap Features Used
- Responsive grid system
- Navbar with offcanvas mobile menu
- Cards and card groups
- Buttons and button groups
- Badges for tags
- Alerts for notifications
- Accordion for FAQs
- Dark mode with `data-bs-theme="dark"`

### Bootstrap Icons
**Version**: 1.11.3  
**CDN**: jsdelivr  
**50+ icons** used across the site

## Development & Testing Pages

### Local Development Only
These pages are excluded from deployment and only accessible locally:

1. **`buttons.php`** - Comprehensive button showcase
   - All button patterns, sizes, and styles
   - Platform-specific buttons (YouTube, Discord, Steam, etc.)
   - Theme-adaptive examples (light/dark mode)
   - Social icons (square, pill, outline variants)
   - Tag filter buttons
   - Usage frequency guide (80% outline, 15% platform, 5% specialized)

2. **`theme-demo.php`** - Theme system reference
   - Bootstrap 5.3.8 Grid System
   - Sitewide Hover Protocol (NEW - Dec 25, 2025)
   - VIP Content Gating (Patreon blur/reveal)
   - Platform button color reference
   - Social media button patterns

**Access**: Only available at `localhost` or `127.0.0.1:8002` (dev server).

**Purpose**: Ensures design consistency and serves as living documentation for developers.

## Future Enhancements

### Potential Additions
1. **SCSS Auto-Compilation**: Add to build script
2. **Image Optimization**: Auto-optimize images during build
3. **JS Minification**: Minify JS files for production
4. **CSS Purging**: Remove unused Bootstrap CSS
5. **Asset Versioning**: Cache-busting for static assets

### Maintenance Tasks
1. **Regular cleanup**: Archive unused JS files
2. **Update Bootstrap**: When 5.3.8+ releases
3. **Optimize images**: Compress large images
4. **Review SCSS**: Remove unused styles

## File Count Summary

**Last Build** (October 14, 2025):
- PDFs: 3 files
- Blog Posts: 5 files
- Fonts: 14 files
- SVGs: 106 files
- CSS: 2 files
- Images: 173 files
- **Total**: 303 files

**Build Log**: `storage/logs/build-2025-10-14.log`

## Support Resources

- **Build Guide**: `storage/docs/BUILD-SYSTEM-GUIDE.md`
- **Bootstrap Docs**: `storage/docs/BOOTSTRAP-5.3.8-IMPLEMENTATION.md`
- **Scripts Reference**: `storage/docs/SCRIPTS-CONSOLIDATED.md`
- **Project README**: `README.md` (project root)

---

*Last Updated: October 14, 2025*  
*Build System Version: 2.0*
