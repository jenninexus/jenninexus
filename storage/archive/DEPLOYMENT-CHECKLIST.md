# JenniNexus - Deployment Checklist

**Server:** `/var/www/jenninexus/` | **Domain:** `https://jenninexus.com`  
**Last Updated:** 2025-10-14

---

## 📋 Official Deployment References

**This checklist relies on these authoritative sources:**

1. **`DEPLOYMENT-MANIFEST.md`** ← **OFFICIAL WHITELIST/BLACKLIST**
   - Definitive list of what gets deployed
   - File patterns to include/exclude
   - Deployment sources (deploy.ps1 vs direct upload)

2. **`scripts/deploy.ps1`** ← **BUILD AUTOMATION**
   - Copies `public_html/*` → `deploy/`
   - Creates `.htaccess` automatically
   - No additional filtering (copies everything from public_html)

3. **`scripts/build.ps1`** ← **ASSET COMPILATION**
   - Copies `src/assets/*` → `public_html/resources/`
   - PDFs, blog posts, fonts, SVGs only

**CRITICAL:** The whitelist is defined in `DEPLOYMENT-MANIFEST.md`, NOT in deploy.ps1.  
The deploy.ps1 script blindly copies `public_html/*` — it assumes you've already built correctly.

---

## 🎯 Current Status: READY FOR DEPLOYMENT

---

## 📦 What Gets Deployed? (See DEPLOYMENT-MANIFEST.md)

**Official Source:** `jenninexus/DEPLOYMENT-MANIFEST.md`

### ✅ INCLUDE (From deploy.ps1 output)

```
deploy/
├── *.html (8 pages)
├── playlist-ids.json
├── .htaccess (created by deploy.ps1)
└── resources/
    ├── js/ (6 files)
    ├── css/ (1 file)
    ├── pdfs/ (3 files)
    ├── blog posts/ (5 markdown files)
    ├── fonts/ (14 files)
    ├── svgs/ (106 files)
    └── scss/ (source files)
```

**Upload:** `deploy/*` → `/var/www/jenninexus/`

### ❌ EXCLUDE (Never upload these)

```
❌ src/ (development source)
❌ scripts/ (build scripts)
❌ storage/ (documentation)
❌ .config/ (local config)
❌ README.md
❌ DEPLOYMENT-MANIFEST.md
❌ *.ps1
❌ node_modules/
❌ .git/
```

**IMPORTANT:** The `deploy.ps1` script does NOT filter — it copies everything from `public_html/`.  
You must ensure `public_html/` only contains web-ready files before running `deploy.ps1`.

---

## 🔧 Build & Deploy Process

### Step 1: Build Assets
```powershell
cd jenninexus/scripts
.\build.ps1           # Copies src/assets → public_html/resources
```

**What build.ps1 does:**
- Copies PDFs from `src/assets/pdfs/` → `public_html/resources/pdfs/`
- Copies blog posts from `src/assets/blog posts/` → `public_html/resources/blog posts/`
- Copies fonts from `src/assets/fonts/` → `public_html/resources/fonts/`
- Copies SVGs from `src/assets/svgs/` → `public_html/resources/svgs/`

**Does NOT copy:** HTML, CSS, JS (those are edited directly in `public_html/`)

### Step 2: Create Deploy Package
```powershell
.\deploy.ps1          # Copies public_html → deploy + creates .htaccess
```

**What deploy.ps1 does:**
1. Copies ALL of `public_html/*` → `deploy/`
2. Creates `.htaccess` with:
   - Browser caching (1 year for assets)
   - Gzip compression
   - Security headers (X-Content-Type-Options, X-Frame-Options)

**Does NOT filter:** Assumes `public_html/` is clean.

### Step 3: Test Locally
```powershell
cd ../deploy
python -m http.server 8001
# Visit http://localhost:8001
```

### Step 4: Upload to Server
```powershell
scp -r * user@server:/var/www/jenninexus/
```

**Alternative:** Direct upload without deploy.ps1
```powershell
scp -r ../public_html/* user@server:/var/www/jenninexus/
```
(You'll need to create `.htaccess` manually on server)

---

## ✅ COMPLETED TASKS

### Phase 1: Enhanced Patreon System
- [x] Enhanced Patreon authentication (`patreon-auth-enhanced.js`)
- [x] VIP content section with gated access
- [x] CC4 PDF embedded viewer (iframe)
- [x] VIP playlist filtering (4 playlists identified)
  - `vip`
  - `sub_updates`
  - `sexy_music`
  - `fire_dancing_hoop_yoga`
- [x] Patron badge in navbar
- [x] Success/logout functionality for testing

### Phase 2: Blog System
- [x] Blog listing page (`/blog.html`)
- [x] 5 blog posts with metadata
  - AI Tools for Technical Artists
  - Game Dev in 2025
  - Voice Acting in Games
  - PAX West Gaming Con
  - DIY Beauty Trends 2025
- [x] Category badges and tags
- [x] Playlist mapping for each post

### Phase 3: Links & Social
- [x] Links page (`/links.html`)
- [x] All social platforms included
  - YouTube channels (3)
  - Patreon, Discord, Twitch
  - GitHub, LinkedIn
  - Instagram, Facebook, TikTok, Spotify
  - Discord communities
- [x] Hover effects on link cards

### Phase 4: UI/UX Enhancements
- [x] Navigation updated (Blog, Links added)
- [x] Professional hover effects added to `custom.css`
  - Button ripple effects
  - Card lift animations
  - Link underline animations
  - Video thumbnail overlays
  - Form input focus states
  - Icon scale effects
  - Badge pulse effects
- [x] Theme toggle integration throughout

---

## 🔄 IN PROGRESS

### Local Testing (NOW)
- [ ] Test Patreon authentication flow
- [ ] Verify VIP content shows/hides correctly
- [ ] Test all VIP playlists load from JSON
- [ ] Check CC4 PDF embed renders properly
- [ ] Test blog page navigation
- [ ] Verify all links page cards work
- [ ] Test theme toggle across all pages
- [ ] Check responsive design on mobile/tablet
- [ ] Test all hover effects work smoothly
- [ ] Verify tag filtering system

---

## 📋 PRE-DEPLOYMENT TODO

### CRITICAL: Must Complete Before SSH Upload

#### 1. Create Individual Blog Post Pages
**Priority:** HIGH  
**Files Needed:** `blog-post.html` (template)

**Tasks:**
- [ ] Read all 5 markdown blog post files
- [ ] Create HTML template with Bootstrap layout
- [ ] Implement markdown rendering (or convert to HTML)
- [ ] Add URL parameter parsing (`?post=slug`)
- [ ] Integrate associated playlists into each post
- [ ] Add tag filtering within posts
- [ ] Proofread all blog content
- [ ] Add social share buttons
- [ ] Add "Related Posts" section
- [ ] Test all 5 blog post URLs

**Markdown Files to Process:**
```
assets/blog posts/ai-tools-for-technical-artists.md
assets/blog posts/game-dev-in-2025.md
assets/blog posts/voice-acting-in-games.md
assets/blog posts/pax-west-gaming-con.md
assets/blog posts/diy-beauty-trends-2025.md
```

**Playlist Mapping:**
- AI Tools → `ai_tools` playlist
- Game Dev → `devlogs` playlist
- Voice Acting → `voice_acting` playlist
- PAX West → `pax_west_gaming_con` playlist
- DIY Beauty → `diy_tutorials` playlist

---

#### 2. Implement Client-Side Routing
**Priority:** MEDIUM  
**File:** `router.js` (new)

**Options:**
1. **Simple History API Router** (Recommended for static site)
   - Use `window.history.pushState()`
   - Intercept link clicks
   - Show/hide content sections
   - Update URL without reload

2. **Hash-Based Router** (Fallback)
   - Use `#/blog/post-slug` format
   - Simpler server config
   - Works without server-side routing

**Tasks:**
- [ ] Choose routing approach
- [ ] Create router.js
- [ ] Update links to use router
- [ ] Test back/forward browser buttons
- [ ] Handle 404 pages
- [ ] Add loading states

---

#### 3. Nginx Configuration
**Priority:** HIGH  
**File:** `nginx.conf` (new)

**Information Needed from You:**
- [ ] Server domain name (e.g., `jenninexus.com`)
- [ ] SSL certificate location (if using HTTPS)
- [ ] Server root directory path
- [ ] PHP/Backend requirements (if any)

**Configuration Tasks:**
- [ ] Create nginx config for clean URLs
- [ ] Set up try_files for SPA routing
- [ ] Configure static file serving
- [ ] Add gzip compression
- [ ] Set cache headers for assets
- [ ] Configure HTTPS redirect (if applicable)
- [ ] Add security headers

**Sample Config Needed:**
```nginx
server {
    listen 80;
    server_name YOUR_DOMAIN;
    root /var/www/jenninexus;
    index index.html;

    # SPA routing
    location / {
        try_files $uri $uri/ /index.html;
    }

    # Static assets caching
    location ~* \.(css|js|jpg|jpeg|png|gif|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

---

#### 4. CSS Optimization (PurgeCSS)
**Priority:** MEDIUM  
**Goal:** Reduce Bootstrap 5.3.3 from ~200KB to <50KB

**Tasks:**
- [ ] Install PurgeCSS: `npm install -g purgecss`
- [ ] Scan all HTML files for used Bootstrap classes
- [ ] Create purged Bootstrap CSS
- [ ] Test all pages still render correctly
- [ ] Minify custom.css
- [ ] Combine into single optimized CSS file (optional)

**Command:**
```bash
purgecss --css path/to/bootstrap.min.css \
         --content *.html **/*.js \
         --output deploy/css/
```

**Bootstrap Classes to Always Keep:**
- All theme-related classes
- Modal classes (for Patreon auth)
- Navbar collapse classes
- Grid system (col-*, row)
- Utility classes (d-*, mb-*, etc.)

---

#### 5. Prepare Deploy Folder
**Priority:** HIGH  
**Structure:**
```
deploy/
├── index.html
├── blog.html
├── blog-post.html
├── links.html
├── css/
│   ├── bootstrap.min.css (purged)
│   └── custom.min.css
├── js/
│   ├── patreon-auth-enhanced.js (minified)
│   ├── youtube-grid.js
│   ├── theme-toggle.js
│   ├── tag-system.js
│   └── router.js (new)
├── assets/
│   ├── brand/
│   ├── blog posts/
│   └── js/
├── playlist-ids.json
└── README.md
```

**Tasks:**
- [ ] Create deploy directory
- [ ] Copy optimized files
- [ ] Minify all JavaScript
- [ ] Minify all CSS
- [ ] Optimize images (if any)
- [ ] Update CDN links to local files (optional)
- [ ] Create deployment README

---

#### 6. Security & Performance
**Priority:** MEDIUM

**Tasks:**
- [ ] Add Content Security Policy headers
- [ ] Implement rate limiting for API calls
- [ ] Add CORS headers if needed
- [ ] Test page load performance
- [ ] Run Lighthouse audit
- [ ] Fix any accessibility issues
- [ ] Add meta tags for SEO
- [ ] Add Open Graph tags for social sharing

---

#### 7. Backend Integration (Future)
**Priority:** LOW (Local testing uses mock auth)

**Current State:**
- Patreon auth uses `localStorage` for testing
- No actual OAuth2 flow

**Production Requirements:**
- [ ] Set up OAuth2 backend (Node.js/PHP)
- [ ] Store Patreon API credentials securely
- [ ] Create `/api/patreon/auth` endpoint
- [ ] Create `/api/patreon/verify` endpoint
- [ ] Add session management
- [ ] Test full OAuth flow

---

## 🧪 TESTING CHECKLIST

### Before Deployment, Test:

#### Functionality
- [ ] Patreon modal opens/closes
- [ ] "Authenticate with Patreon" button works
- [ ] VIP content appears after auth
- [ ] CC4 PDF loads in iframe
- [ ] All 4 VIP playlists display correctly
- [ ] Logout clears auth state
- [ ] Blog listing shows all 5 posts
- [ ] Blog post links work (after creating blog-post.html)
- [ ] All social links open correctly
- [ ] Tag filtering works
- [ ] Theme toggle works on all pages
- [ ] Navigation links work

#### Design/UX
- [ ] All hover effects work smoothly
- [ ] Cards lift on hover
- [ ] Buttons have ripple effect
- [ ] Links have underline animation
- [ ] Video thumbnails show overlay
- [ ] Icons scale on hover
- [ ] Forms have focus states
- [ ] No layout shifts
- [ ] No console errors

#### Responsive Design
- [ ] Mobile (320px - 767px)
- [ ] Tablet (768px - 1023px)
- [ ] Desktop (1024px+)
- [ ] 4K displays (2560px+)

#### Performance
- [ ] Page loads in <3 seconds
- [ ] No render-blocking resources
- [ ] Images lazy load
- [ ] CSS/JS minified
- [ ] Lighthouse score >90

#### Browsers
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari
- [ ] Mobile Safari
- [ ] Mobile Chrome

---

## 🚀 DEPLOYMENT STEPS

### When Ready to Upload to SSH:

1. **Backup Current Site**
   ```bash
   ssh user@your-server
   cd /var/www
   tar -czf jenninexus-backup-$(date +%F).tar.gz jenninexus/
   ```

2. **Upload Deploy Folder**
   ```bash
   scp -r deploy/* user@your-server:/var/www/jenninexus/
   ```

3. **Update Nginx Config**
   ```bash
   sudo nano /etc/nginx/sites-available/jenninexus
   sudo nginx -t
   sudo systemctl reload nginx
   ```

4. **Set Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/jenninexus
   sudo chmod -R 755 /var/www/jenninexus
   ```

5. **Test Live Site**
   - Visit domain
   - Test all features
   - Check SSL certificate
   - Run production Lighthouse audit

---

## 📊 OPTIMIZATION TARGETS

### Before Optimization (Estimated):
- HTML: ~50KB (unminified)
- CSS: ~250KB (Bootstrap + Custom)
- JS: ~150KB (all scripts)
- **Total:** ~450KB

### After Optimization (Target):
- HTML: ~40KB (minified)
- CSS: ~60KB (purged + minified)
- JS: ~80KB (minified)
- **Total:** ~180KB (60% reduction)

### Performance Targets:
- **First Contentful Paint:** <1.5s
- **Largest Contentful Paint:** <2.5s
- **Time to Interactive:** <3.5s
- **Lighthouse Score:** >90

---

## 📝 NEXT IMMEDIATE ACTIONS

### Right Now (While Testing Locally):

1. **Test the current build** at `http://localhost:8000`
   - Click through all pages
   - Test Patreon auth flow
   - Check all hover effects
   - Verify responsive design

2. **Create `blog-post.html`**
   - Read markdown files
   - Convert to HTML template
   - Add playlist embeds
   - Test with all 5 posts

3. **Decide on Routing**
   - Hash-based (`#/blog/post-slug`) - Easier
   - History API (`/blog/post-slug`) - Cleaner URLs

4. **Gather Nginx Info**
   - Server domain name
   - Root directory path
   - SSL certificate details

5. **Run PurgeCSS**
   - Optimize Bootstrap
   - Test all pages still work

---

## ❓ QUESTIONS FOR YOU

Before proceeding to deployment, please provide:

1. **Server Details:**
   - Domain name: `_____________`
   - Root directory: `_____________`
   - Using HTTPS? (yes/no): `_____________`
   - SSL certificate location: `_____________`

2. **Routing Preference:**
   - Hash-based URLs (`#/blog/post`) or History API (`/blog/post`)? `_____________`

3. **Patreon Integration:**
   - Need real OAuth backend now, or later? `_____________`
   - Patreon Client ID (if ready): `_____________`

4. **Optimization:**
   - Run PurgeCSS now? (yes/no): `_____________`
   - Host Bootstrap locally or keep CDN? `_____________`

---

## 🎉 WHEN COMPLETE

You'll have:
- ✅ Fully functional multi-page site
- ✅ Enhanced Patreon VIP system
- ✅ Complete blog with 5 posts
- ✅ Social links page
- ✅ Professional hover effects
- ✅ Optimized for performance
- ✅ Nginx configured for clean URLs
- ✅ Ready for production deployment

---

**Last Updated:** ${new Date().toLocaleDateString()}  
**Status:** 🧪 Local Testing Phase  
**Server:** http://localhost:8000
