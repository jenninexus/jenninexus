# JenniNexus Deployment Plan - Bootstrap 5.3.3

## 🏗️ Current Architecture (October 2025)

### **Project Type:** Static PHP Site with Bootstrap 5.3.3
- **Framework:** Bootstrap 5.3.3 + PHP Includes
- **Server:** Nginx + PHP-FPM 8.1 (Production: 64.23.141.41)
- **Domain:** jenninexus.com
- **SSL:** Let's Encrypt (enabled)

### **File Structure:**
```
jenninexus/
├── public_html/              # Web root
│   ├── includes/             # PHP partials (to be created)
│   │   ├── head.php         # <head> section (meta, CSS, fonts)
│   │   ├── header.php       # Navigation + mobile menu
│   │   └── footer.php       # 4-column footer with contact
│   ├── resources/
│   │   ├── css/             # Compiled CSS
│   │   ├── js/              # 10 active JavaScript files
│   │   ├── playlists/       # 6 YAML configs
│   │   └── pdfs/            # Resume & CC4 guide
│   ├── *.php                # Pages (gamedev, resume, music, etc.)
│   └── index.php            # Homepage
├── src/
│   └── assets/
│       └── scss/            # Source SCSS (compiles to CSS)
└── scripts/                 # Build & deployment scripts
```

---

## ✅ What We Have (Current Status)

### **Pages (Currently HTML, converting to PHP):**
- ✅ index.html → index.php
- ✅ gamedev.html → gamedev.php (updated with contact footer)
- ✅ resume.html → resume.php (Contact section + footer email)
- ✅ music.html → music.php (Spotify embeds, updated playlists)
- ✅ patreon.html → patreon.php (VIP music playlist added)
- ✅ live.html → live.php (Twitch branding)
- ✅ gaming.html → gaming.php (26 playlists)
- ✅ diy.html → diy.php
- ✅ blog.html → blog.php
- ✅ links.html → links.php (should reference social-stats.json)
- ✅ services.html → services.php

### **YAML Playlist Configs (Complete):**
- ✅ gamedev.yaml (22 playlists: Featured, Indie Jams, Martian Games, Learning)
- ✅ gaming.yaml (26 playlists: All genres + events)
- ✅ music.yaml (6 playlists: DJ, FL Studio, Sets, History)
- ✅ diy.yaml (Fashion, beauty, crafts)
- ✅ live.yaml (3 playlists: Twitch highlights, VODs, tips)
- ✅ patreon.yaml (1 VIP music playlist)

### **JavaScript (10 Active Files):**
- ✅ youtube-grid.js (YAML playlist loader)
- ✅ theme-toggle.js (Dark/light mode)
- ✅ martian-games.js (Steam-themed game catalog)
- ✅ patreon-auth-enhanced.js (VIP content authentication)
- ✅ back-to-top.js (Scroll to top button)
- ✅ performance-optimizer.js (Page speed)
- ✅ polyfills.js (Browser compatibility)
- ✅ tag-system.js (Content filtering)
- ✅ diy-playlists.js (DIY page loader)
- ✅ music-playlists.js (Music page loader)

### **Features:**
- ✅ YouTube Data API v3 integration (AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg)
- ✅ Platform branding (Steam, Patreon, YouTube, Twitch)
- ✅ Responsive Bootstrap 5.3.3 layout
- ✅ Contact email footer (gamedev, resume completed; 8 pending)
- ✅ PDF embed viewers (resume, CC4 guide)
- ✅ Tag-based filtering system
- ✅ Martian Games showcase (6 games)

---

## 🚀 Deployment Strategy: PHP Includes Approach

### **Why PHP Includes?**
✅ **Pros:**
- Single source of truth for header/footer
- Easy site-wide updates (change once, affects all pages)
- Works perfectly with your existing JavaScript/YAML system
- Nginx already supports PHP-FPM
- Clean URLs with simple rewrite rules
- Minimal changes to existing structure

❌ **Cons:**
- Files become `.php` (but Nginx handles clean URLs: /gamedev instead of /gamedev.php)
- Need to test locally with PHP dev server instead of Python

---

## 📋 Implementation Steps

### **Step 1: Create PHP Includes** ✅ Ready to Execute

Create `public_html/includes/` directory with 3 partials:

#### **1.1 includes/head.php**
```php
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= $pageDescription ?? 'JenniNexus - Game Dev, Music, DIY, and Creative Content' ?>">
  <meta name="author" content="Jenni">
  <meta name="keywords" content="<?= $pageKeywords ?? 'game development, music production, DIY crafts, creative content' ?>">
  <title><?= $pageTitle ?? 'JenniNexus' ?></title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Montserrat:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/alien-league" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Custom CSS -->
  <link href="resources/css/custom.css" rel="stylesheet">
</head>
```

#### **1.2 includes/header.php**
```php
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand logo-brand" href="index.php">
      <span class="jenni-text">Jenni</span><span class="nexus-text">NEXUS</span>
    </a>
    
    <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <i class="bi bi-list"></i>
    </button>
    
    <div class="collapse navbar-collapse d-none d-lg-block" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'music' ? 'active' : '' ?>" href="music.php">Music</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'diy' ? 'active' : '' ?>" href="diy.php">DIY</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'gamedev' ? 'active' : '' ?>" href="gamedev.php">Game Dev</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'blog' ? 'active' : '' ?>" href="blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'links' ? 'active' : '' ?>" href="links.php">Links</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'resume' ? 'active' : '' ?>" href="resume.php">Resume</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'services' ? 'active' : '' ?>" href="services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link <?= $activePage === 'patreon' ? 'active' : '' ?>" href="patreon.php">Patreon</a></li>
        <li class="nav-item ms-2">
          <button class="btn btn-link nav-link" id="themeToggle" aria-label="Toggle theme">
            <i class="bi bi-moon-stars-fill"></i>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileMenu">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title logo-brand"><span class="jenni-text">Jenni</span><span class="nexus-text">NEXUS</span></h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="music.php">Music</a></li>
      <li class="nav-item"><a class="nav-link" href="diy.php">DIY</a></li>
      <li class="nav-item"><a class="nav-link" href="gamedev.php">Game Dev</a></li>
      <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
      <li class="nav-item"><a class="nav-link" href="links.php">Links</a></li>
      <li class="nav-item"><a class="nav-link" href="resume.php">Resume</a></li>
      <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
      <li class="nav-item"><a class="nav-link" href="patreon.php">Patreon</a></li>
    </ul>
  </div>
</div>
```

#### **1.3 includes/footer.php**
```php
<footer class="bg-dark text-white py-5 mt-5">
  <div class="container">
    <div class="row g-4">
      <!-- Brand Column -->
      <div class="col-lg-3">
        <h5 class="logo-brand mb-3"><span class="jenni-text">Jenni</span><span class="nexus-text">NEXUS</span></h5>
        <p class="small text-muted">Game dev, music, DIY, and creative content</p>
        <div class="d-flex gap-3">
          <a href="https://discord.gg/pKSyR4A9Tb" class="text-white" title="Discord"><i class="bi bi-discord fs-5"></i></a>
          <a href="https://patreon.com/jenninexus" class="text-white" title="Patreon"><i class="bi bi-heart-fill fs-5"></i></a>
          <a href="https://youtube.com/@jenninexus" class="text-white" title="YouTube"><i class="bi bi-youtube fs-5"></i></a>
          <a href="https://twitch.tv/jenninexus" class="text-white" title="Twitch"><i class="bi bi-twitch fs-5"></i></a>
        </div>
      </div>
      
      <!-- Explore Column -->
      <div class="col-6 col-lg-2">
        <h6 class="mb-3">Explore</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="music.php" class="text-white-50 text-decoration-none">Music</a></li>
          <li class="mb-2"><a href="diy.php" class="text-white-50 text-decoration-none">DIY</a></li>
          <li class="mb-2"><a href="gamedev.php" class="text-white-50 text-decoration-none">Game Dev</a></li>
          <li class="mb-2"><a href="blog.php" class="text-white-50 text-decoration-none">Blog</a></li>
        </ul>
      </div>
      
      <!-- Connect Column -->
      <div class="col-6 col-lg-2">
        <h6 class="mb-3">Connect</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="links.php" class="text-white-50 text-decoration-none">All Links</a></li>
          <li class="mb-2"><a href="resume.php" class="text-white-50 text-decoration-none">Resume</a></li>
          <li class="mb-2"><a href="services.php" class="text-white-50 text-decoration-none">Services</a></li>
          <li class="mb-2"><a href="patreon.php" class="text-white-50 text-decoration-none">Patreon</a></li>
        </ul>
      </div>
      
      <!-- Contact Column -->
      <div class="col-lg-5">
        <h6 class="mb-3">Contact</h6>
        <p class="small text-muted mb-3">Get in touch for collaborations and inquiries</p>
        <a href="mailto:jenninexus@gmail.com" class="btn btn-outline-light btn-sm mb-3 w-100">
          <i class="bi bi-envelope me-2"></i>jenninexus@gmail.com
        </a>
        <div class="d-flex gap-2">
          <a href="https://discord.gg/pKSyR4A9Tb" class="btn btn-outline-light btn-sm flex-fill">
            <i class="bi bi-discord me-1"></i>Discord
          </a>
          <a href="links.php" class="btn btn-outline-light btn-sm flex-fill">
            <i class="bi bi-link-45deg me-1"></i>All Links
          </a>
        </div>
      </div>
    </div>
    
    <hr class="my-4 border-secondary">
    
    <div class="row">
      <div class="col-12 text-center">
        <p class="mb-0 small text-muted">&copy; <?= date('Y') ?> JenniNexus. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTopBtn" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4" style="display: none; width: 50px; height: 50px; z-index: 1000;" aria-label="Back to top">
  <i class="bi bi-arrow-up fs-5"></i>
</button>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Scripts -->
<script src="resources/js/theme-toggle.js"></script>
<script src="resources/js/back-to-top.js"></script>
<script src="resources/js/performance-optimizer.js"></script>
<script src="resources/js/polyfills.js"></script>
```

---

### **Step 2: Convert Pages to PHP**

Example conversion for `gamedev.html` → `gamedev.php`:

```php
<?php
$activePage = 'gamedev';
$pageTitle = 'Game Development | JenniNexus';
$pageDescription = 'Game Development Projects & Tutorials - Unity, Unreal Engine, Blender, and original game showcases by JenniNexus';
$pageKeywords = 'game development, unity tutorials, unreal engine, indie games, game jam, VR development, 3D modeling, blender';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include 'includes/head.php'; ?>
<body>

<?php include 'includes/header.php'; ?>

<!-- MAIN CONTENT HERE (keep all existing sections) -->

<?php include 'includes/footer.php'; ?>

<!-- Page-specific scripts -->
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
<script src="resources/js/youtube-grid.js"></script>
<script src="resources/js/martian-games.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    YouTubeGrid.loadPageConfig('gamedev');
  });
</script>

</body>
</html>
```

**Pages to Convert:**
- [ ] index.html → index.php
- [ ] gamedev.html → gamedev.php
- [ ] resume.html → resume.php
- [ ] music.html → music.php
- [ ] patreon.html → patreon.php
- [ ] live.html → live.php
- [ ] gaming.html → gaming.php
- [ ] diy.html → diy.php
- [ ] blog.html → blog.php
- [ ] links.html → links.php
- [ ] services.html → services.php

---

### **Step 3: Update All Links**

Search and replace in all PHP files:
- `.html` → `.php` in href attributes
- `index.html` → `index.php`
- `gamedev.html` → `gamedev.php`
- etc.

---

### **Step 4: Local Testing**

```powershell
# Start PHP dev server
cd jenninexus/public_html
php -S localhost:8002

# Test URLs:
# http://localhost:8002/index.php
# http://localhost:8002/gamedev.php
# http://localhost:8002/resume.php
# etc.
```

**Test Checklist:**
- [ ] All pages load correctly
- [ ] Navigation links work (*.php)
- [ ] Footer contact email displays
- [ ] YouTube playlists load from YAML
- [ ] Theme toggle works
- [ ] PDF viewers display (resume, CC4)
- [ ] Patreon VIP content works
- [ ] Spotify embeds play
- [ ] Mobile offcanvas menu works

---

### **Step 5: Create Deployment Script**

Create `scripts/deploy.ps1`:

```powershell
#!/usr/bin/env pwsh
# JenniNexus Deployment Script
# Deploys to production server at 64.23.141.41 via rsync over SSH

param(
    [switch]$DryRun,
    [switch]$Verbose
)

$SERVER = "root@64.23.141.41"
$REMOTE_PATH = "/var/www/jenninexus/public_html"
$LOCAL_PATH = "jenninexus/public_html/"

$RSYNC_OPTS = @(
    "-avz",
    "--delete",
    "--exclude='.git*'",
    "--exclude='node_modules'",
    "--exclude='*.md'",
    "--exclude='.config'",
    "--exclude='scripts/dev-*'",
    "--exclude='*.html'",  # Don't sync old HTML files
    "--progress"
)

if ($DryRun) {
    $RSYNC_OPTS += "--dry-run"
    Write-Host "🔍 DRY RUN MODE - No files will be changed" -ForegroundColor Yellow
}

if ($Verbose) {
    $RSYNC_OPTS += "--verbose"
}

Write-Host "🚀 Deploying JenniNexus to Production..." -ForegroundColor Cyan
Write-Host "📍 Server: $SERVER" -ForegroundColor Gray
Write-Host "📂 Remote: $REMOTE_PATH" -ForegroundColor Gray
Write-Host ""

# Sync files
Write-Host "📦 Syncing files..." -ForegroundColor Cyan
rsync $RSYNC_OPTS $LOCAL_PATH ${SERVER}:${REMOTE_PATH}/

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Files synced successfully!" -ForegroundColor Green
    
    if (-not $DryRun) {
        Write-Host "🔄 Reloading Nginx and PHP-FPM..." -ForegroundColor Cyan
        ssh $SERVER "sudo systemctl reload nginx && sudo systemctl reload php8.1-fpm"
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Services reloaded!" -ForegroundColor Green
            Write-Host ""
            Write-Host "🌐 Deployment complete! Visit: https://jenninexus.com" -ForegroundColor Green
        } else {
            Write-Host "❌ Failed to reload services" -ForegroundColor Red
        }
    }
} else {
    Write-Host "❌ Deployment failed!" -ForegroundColor Red
    exit 1
}
```

**Usage:**
```powershell
# Dry run (test without changes)
.\scripts\deploy.ps1 -DryRun

# Deploy to production
.\scripts\deploy.ps1

# Deploy with verbose output
.\scripts\deploy.ps1 -Verbose
```

---

### **Step 6: Production Nginx Configuration**

Update `/etc/nginx/sites-available/jenninexus.com`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name jenninexus.com www.jenninexus.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name jenninexus.com www.jenninexus.com;

    root /var/www/jenninexus/public_html;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/jenninexus.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/jenninexus.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Clean URLs
    location / {
        try_files $uri $uri.php $uri/ =404;
    }

    # PHP Processing
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Static Assets
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot|yaml|json|pdf)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }
}
```

---

## 📝 Final Checklist Before Deployment

### **Local (Development):**
- [ ] Create `public_html/includes/` directory
- [ ] Create `head.php`, `header.php`, `footer.php` partials
- [ ] Convert all `.html` pages to `.php`
- [ ] Update all internal links (`.html` → `.php`)
- [ ] Test locally with `php -S localhost:8002`
- [ ] Verify all pages load correctly
- [ ] Test YouTube playlist loading
- [ ] Test Patreon VIP authentication
- [ ] Verify PDF embeds work

### **Deployment Script:**
- [ ] Create `scripts/deploy.ps1`
- [ ] Test dry run: `.\scripts\deploy.ps1 -DryRun`
- [ ] Verify rsync excludes are correct
- [ ] Test SSH connection: `ssh root@64.23.141.41`

### **Production Server:**
- [ ] Verify PHP 8.1 installed: `php -v`
- [ ] Verify PHP-FPM running: `systemctl status php8.1-fpm`
- [ ] Update Nginx config for clean URLs
- [ ] Test Nginx config: `sudo nginx -t`
- [ ] Reload Nginx: `sudo systemctl reload nginx`
- [ ] Verify SSL certificate valid
- [ ] Test clean URLs work (e.g., `/gamedev` instead of `/gamedev.php`)

### **Post-Deployment:**
- [ ] Test all pages on jenninexus.com
- [ ] Verify SSL certificate loads correctly
- [ ] Test contact email links
- [ ] Verify YouTube playlists load
- [ ] Test Patreon VIP content
- [ ] Check mobile responsiveness
- [ ] Test all navigation links
- [ ] Verify PDFs display correctly

---

## 🎯 Summary

**What You'll Have:**
- ✅ PHP includes for header/footer (single source of truth)
- ✅ All pages using `.php` extension
- ✅ Clean URLs in production (`/gamedev` works)
- ✅ Easy site-wide updates (change footer once, affects all pages)
- ✅ All your YAML/JavaScript features preserved
- ✅ Automated deployment with rsync
- ✅ Production-ready Nginx config

**What Changes:**
- File extensions: `.html` → `.php`
- Dev server: Python → PHP (`php -S localhost:8002`)
- Internal links updated (`.html` → `.php`)

**What Stays the Same:**
- ✅ All your YAML playlist configs
- ✅ All your JavaScript functionality
- ✅ Bootstrap 5.3.3 framework
- ✅ YouTube Data API integration
- ✅ Platform branding and styling
- ✅ PDF viewers
- ✅ Patreon authentication
- ✅ Theme toggle
- ✅ Tag system
- ✅ Everything else!

---

**Status:** Ready to implement  
**Estimated Time:** 2-3 hours (includes, conversion, testing, deployment)  
**Risk Level:** Low (all features preserved, simple PHP includes)

