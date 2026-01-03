# JenniNexus Deployment Manifest
Generated: 2026-01-02 19:35:13

## Files Deployed: 539

### PHP Pages: 23
- ai.php
- blog.php
- diy.php
- gamedev.php
- gaming.php
- index.php
- links.php
- live.php
- media.php
- music.php
- patreon-auth-start.php
- patreon-callback.php
- patreon.php
- privacy.php
- resume.php
- router.php
- services.php
- sitemap.php
- tags.php
- tos.php
- vip.php
- youtube.php


### Resources:
- JavaScript files: 22 (includes .min.js versions)
- Active JS modules: 14 source files (see storage/docs/JS.md)
  - Core UI: theme-toggle, back-to-top, performance-optimizer, polyfills, compat-resume
  - Tag System: tag-system, tag-filter-api, tag-cloud
  - Content: youtube-grid, martian-games, diy-playlists, music-playlists, live-status
  - OAuth: patreon-auth-enhanced
- CSS files: 30
- YAML playlists: 10
- PDF documents: 2 (excluded from deploy package, preserved on server)

**Note:** Videos (~4MB) and PDFs (~2MB) are excluded from the deploy package to save bandwidth.
These files are preserved on the server and only need to be uploaded manually when changed.

### Bootstrap 5.3.8 Integration:
- All JavaScript files Bootstrap 5.3.8 compatible (verified Nov 5, 2025)
- No conflicts with Bootstrap Modal, Offcanvas, or Grid APIs
- Proper use of data-bs-theme, data-bs-toggle, data-bs-target
- Minification savings: ~40KB+ (62% average reduction)
- See storage/docs/JS.md for comprehensive documentation

### Server Configuration:
- Target: root@jennidrop-root:/var/www/jenninexus
- Bootstrap Version: 5.3.8 (CDN with SRI hashes)
- PHP Version: 8.3-FPM
- Permissions: www-data:www-data (755 dirs, 644 files)

### Documentation:
- Bootstrap: storage/docs/BOOTSTRAP-5.3.8.md
- JavaScript: storage/docs/JS.md (27.3 KB)
- CSS: storage/docs/CSS-SCSS.md
- Deployment: storage/docs/DEPLOYMENT-GUIDE.md

### Notes:
- Default mode: Build-only (no remote deploy). Run deploy.ps1 to upload and run remote helper.
### Backups (when deploying):
- Remote backups are stored under: /var/www/jenninexus/storage/deploys/
- Nginx config: jenninexus-nginx.conf

## Excluded from deployment
- secrets.json (sensitive secrets are excluded by default; provision on server under /var/www/jenninexus/public_html/resources/playlists/secrets.json)
- source directories: /src, /storage, /scripts (these are not shipped in the deploy package)
- secrets.json (sensitive secrets are excluded by default; provision on server under /var/www/jenninexus/storage/secrets/secrets.json)
- *.backup
- *.bak
- *~
- *.tmp
- Thumbs.db
- .DS_Store
- *.md
- *.html
- secrets.json
- archived
- /src/**
- /storage/**
- /scripts/**
- /resources/archived/**
- **/!bak/**
- /gamedev → gamedev.php
- /resume → resume.php
- /music → music.php
- etc.
- martiangames-portable.php
- theme-demo.php
- buttons.php
- src/**
- storage/**
- scripts/**
- resources/archived/**
- resources/secrets.example.json (moved to storage/secrets/)

### Clean URLs enabled:
- /gamedev → gamedev.php
- /resume → resume.php
- /music → music.php
- etc.
