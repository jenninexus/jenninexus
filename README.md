# JenniNexus - Creative Platform

**PHP 8.3** | **Production Ready** | **Isolated Architecture**  
**Server:** 64.23.141.41 | **Domain:** jenninexus.com | **Port:** 8002

---

## 🚀 Quick Start

```powershell
# Start dev server (port 8002)
.\scripts\dev-server.ps1

# Build assets
.\scripts\build.ps1

# Watch & auto-rebuild
.\scripts\watch.ps1

# Deploy to production
.\scripts\build-and-deploy.ps1
```

**Access:** http://localhost:8002

---

## 📂 Project Structure

```
jenninexus/
├── public_html/              # WEB ROOT - Deploy this
│   ├── includes/             # PHP partials (head.php, header.php, footer.php)
│   ├── resources/            # CSS, JS, images, playlists, PDFs
│   │   └── vendor/           # External libraries (FontAwesome, Bootstrap)
│   └── *.php                 # 25+ pages (index, gamedev, resume, music, etc.)
├── src/assets/               # SOURCE FILES - Edit these
│   ├── css/                  # Direct CSS source
│   ├── js/                   # JavaScript source
│   ├── blog posts/           # Markdown files
│   ├── pdfs/                 # Original PDFs
│   ├── fonts/                # Font files
│   └── svgs/                 # Custom SVG icons
├── scripts/                  # Build & deployment automation
├── storage/
│   ├── docs/                 # Essential documentation
│   ├── secrets/              # Example secrets and templates
│   └── logs/                 # Build and runtime logs
└── .config/                  # MCP, Nginx configs
```

---

## 🧭 Resource Guidelines

This project is **self-contained**. It does not use the shared framework or vendor symlinks. All assets and dependencies are copied into `public_html/resources/` at build time.

- Always reference files inside `public_html/resources/` using the server-side `RES_ROOT` constant in PHP pages.
- Example: `<img src="<?= RES_ROOT ?>/images/logo.png">`
- JavaScript: core client scripts read `window.RES_ROOT` (injected by `includes/head.php`).
- External libraries (FontAwesome, etc.) are located in `public_html/resources/vendor/`.

---

## 📄 Pages (PHP)

| Page | URL | Features |
|------|-----|----------|
| **index.php** | `/` | Tag filtering, carousel, content sections |
| **gamedev.php** | `/gamedev` | 22 playlists, Martian Games, Jenni Styles |
| **resume.php** | `/resume` | Embedded PDF, skills showcase |
| **music.php** | `/music` | Spotify embeds, 6 YouTube playlists |
| **patreon.php** | `/patreon` | VIP content, CC4 guide, exclusive playlists |
| **diy.php** | `/diy` | Fashion, hair, nails, brand collabs |
| **live.php** | `/live` | Twitch streams, live content |
| **blog.php** | `/blog` | Blog post listing |
| **links.php** | `/links` | Social media aggregation |
| **services.php** | `/services` | Voice acting, game dev, 3D modeling |

---

## 🛠️ Scripts

### Development
```powershell
# Start dev server (PHP built-in server on port 8002)
.\scripts\dev-server.ps1

# Build assets (src/assets → public_html/resources)
.\scripts\build.ps1

# File Watcher: Auto-rebuild on changes
.\scripts\watch.ps1
```

### Deployment
```powershell
# Full pipeline: build → package → upload → reload services
.\scripts\build-and-deploy.ps1

# Deploy only (assumes already built)
.\scripts\deploy.ps1
```

### Maintenance
```powershell
# Sync assets (if you edited src/assets)
.\scripts\sync-assets.ps1

# Build GitHub Package (clean copy for repo)
.\scripts\build-github-package.ps1

# Tag System Validation
.\scripts\validate-tag-system.ps1
```

---

## 🎨 Tech Stack

| Component | Technology |
|-----------|------------|
| **Base** | Bootstrap 5.3.8 (Local Vendor) |
| **Backend** | PHP 8.3-FPM |
| **Icons** | FontAwesome 6.7.2, Bootstrap Icons |
| **Build** | PowerShell, clean-css-cli, terser |
| **Server** | Nginx, Ubuntu 24.04 |

### Maintenance
```powershell
# Sync assets (if you edited src/assets)
.\scripts\sync-assets.ps1

# Tag System Validation
.\scripts\validate-tag-system.ps1

# Fix tag issues
.\scripts\fix-tag-system.ps1

# Analyze tag usage
node .\scripts\analyze-tags.cjs

# Regenerate content_tags.json
.\scripts\generate-playlist-tags.ps1
```

---

## 🎨 Tech Stack

| Component | Technology |
|-----------|------------|
| **Base** | Custom CSS (transitioning from Bootstrap) |
| **Backend** | PHP 8.3-FPM |
| **Server** | Nginx |
| **Build** | npm (clean-css-cli, terser) |
| **JavaScript** | Custom vanilla JS |
| **Playlists** | YAML configs + YouTube RSS feeds (no API) |
| **Dev Server** | PHP built-in server (port 8002) |
| **Deployment** | rsync over SSH |

---

## 📚 Essential Documentation

### Core Docs (storage/docs/)
- **QUICKSTART.md** - Fast setup guide
- **DEPLOYMENT-GUIDE.md** - Production deployment walkthrough
- **SCRIPTS-CONSOLIDATED.md** - All scripts explained
- **PLAYLIST-MAPPING.md** - YouTube playlist configuration
- **WORKSPACE-CONFIG-UPDATE.md** - MCP & workspace setup

### Reference
- **DEPLOYMENT-CHECKLIST.md** - Pre-deployment verification
- **JS-FILES-AUDIT.md** - JavaScript inventory
- **YOUTUBE-API-SETUP-GUIDE.md** - API credentials

---

## ⚙️ Configuration

### Production Server (✅ VERIFIED)
- **IP:** 64.23.141.41
- **SSH:** root@64.23.141.41:22
- **Web Root:** /var/www/jenninexus
- **PHP:** 8.3-fpm
- **Nginx Config:** /etc/nginx/sites-available/jenninexus.conf
- **SSL:** Let's Encrypt (jenninexus.com)

### SSH keys & deploy access
- Deployment key `main_jenninexus.pub` is configured for `root@64.23.141.41`.
- This project is isolated; do not use keys or hosts from other projects (e.g. Martian Games).

### Self-contained Architecture
This project is **NOT** using the `shared/` framework or `shared-deps` symlinks. All dependencies are local to the project. The only shared component used is the `sys-admin` tool for MCP management.

### Development
- **Port:** 8002
- **Command:** `.\scripts\dev-server.ps1`

### MCP Server
- **Launcher:** `shared-deps/sys-admin/start-jenni-admin.bat`
- **Config:** `.config/mcp_jenni.json`
- **Target:** `.vscode/mcp.json` (Isolated per instance)


---

## 🎯 Key Features

### PHP Includes System
- **head.php** - Bootstrap 5.3.8, meta tags, fonts, CSS
- **header.php** - Navigation with active page detection
- **footer.php** - 4-column footer + core scripts

Note on Facebook SDK usage
-------------------------
Some blog pages include Facebook embedded posts. To avoid loading the Facebook SDK on every page, the site uses a per-page opt-in variable: set `$needsFb = true;` before including `includes/head.php` on any PHP page that requires Facebook embeds. The `includes/footer.php` will render the `fb-root` and load the SDK only when `$needsFb` is truthy. Example in a blog page header:

```php
// This page includes Facebook embeds
$needsFb = true;
$pageUrl = 'https://jenninexus.com/blog/your-post-slug';
$pageImage = 'https://jenninexus.com/resources/images/...';
include '../includes/head.php';
```

If you update or add Facebook embeds, ensure the post `data-href` values point to the full Facebook post URL (https://www.facebook.com/username/posts/<postid> or the share link), and verify `$needsFb` is set so the SDK is loaded.

### YAML Playlist System
**6 YAML configs:**
- `gamedev.yaml` - 22 playlists
- `gaming.yaml` - 26 playlists
- `music.yaml` - 6 playlists
- `diy.yaml` - Fashion, hair, nails
- `live.yaml` - Twitch streams
- `patreon.yaml` - VIP exclusive content

**Loaded by:** `resources/js/youtube-grid.js`  
**Data Source:** YouTube RSS feeds (NO API KEY NEEDED)  
**Caching:** Server-side 10-minute cache + client-side 24-hour cache  
**Proxy:** `resources/api/get-youtube.php` (handles CORS + caching)

### JavaScript Features
1. **theme-toggle.js** - Dark/light mode (all pages)
2. **youtube-grid.js** - YAML playlist loader
3. **tag-system.js** - Content filtering (index.php)
4. **patreon-auth-enhanced.js** - VIP content gating
5. **martian-games.js** - Martian Games showcase
6. **music-playlists.js** - Music page specific
7. **diy-playlists.js** - DIY page specific
8. **back-to-top.js** - Smooth scroll button
9. **performance-optimizer.js** - Lazy loading
10. **polyfills.js** - Browser compatibility

---

## 🚢 Deployment Workflow

### 1. Build Locally
```powershell
cd C:\Users\Owner\Projects\www\jenninexus\scripts
.\build.ps1

---

## ⚠️ Web server / .htaccess note

This project ships an Apache `.htaccess` for convenience and local compatibility, but production uses **nginx**. Nginx does not read `.htaccess` files. The canonical production nginx configuration is kept at `.config/jenninexus.conf` (or the server's `/etc/nginx/sites-available/jenninexus.conf`). Only deploy the nginx config when you intentionally change server rules; otherwise leave server config unchanged.

Where files live at runtime
- YAML playlist configs (preferred): `public_html/resources/playlists/*.yaml` — loaded by `resources/js/youtube-grid.js`
- Legacy JSON playlist mapping: `public_html/playlist-ids.json` and `public_html/resources/playlists/playlist-ids.json` (kept for backward compatibility)
- Other JSON assets: `public_html/resources/playlists/content_tags.json`, `social-stats.json`, `tags.json`
- Secrets / API keys: do NOT commit to the repo. Place `secrets.json` on the server at `public_html/resources/secrets.json` via secure copy (scp/rsync) or use environment variables on the server.

Recommended workflow:
- Keep sensitive credentials out of Git. Use `.env` locally for development.
- During build, the `build.ps1` script copies YAML and non-sensitive JSON from `src/assets` into `public_html/resources/playlists/` and copies `playlist-ids.json` to `public_html/` for legacy code.
- `deploy.ps1` prevents `secrets.json` from being uploaded by deleting it from the deploy package.
```

### 2. Test Locally
```powershell
.\dev-server.ps1
# Visit http://localhost:8002
# Test all pages and features
```

### 3. Deploy to Production
```powershell
.\build-and-deploy.ps1
# Script will:
# - Clean old files
# - Build deploy package
# - Prompt for confirmation
# - Upload via rsync
# - Set permissions
# - Upload Nginx config
# - Reload Nginx + PHP-FPM
```

### 4. Verify Production
```bash
# SSH to server
ssh root@64.23.141.41

# Check services
sudo systemctl status nginx
sudo systemctl status php8.3-fpm

# View logs
sudo tail -f /var/log/nginx/jenninexus.access.log
```

### 5. Test Live Site
- https://jenninexus.com
- https://jenninexus.com/gamedev
- https://jenninexus.com/resume
- https://jenninexus.com/music

---

## Patreon token refresh & webhook processing (new)

To keep Patreon tokens valid and to process archived webhook payloads, two lightweight CLI scripts are included under `scripts/`:

- `scripts/patreon-refresh.php` — refreshes OAuth tokens using `storage/secrets/patreon.json` and writes the updated tokens to `storage/patreon/tokens.json`.
- `scripts/patreon-webhook-processor.php` — processes archived webhook payloads from `storage/patreon/webhooks/`, merges simple user/membership info into `storage/patreon/user.json`, and moves processed payloads into `storage/patreon/webhooks/processed/`.

Both are intentionally conservative and do not run automatically; install a cron job or systemd timer if you want scheduled execution.

Example crontab (runs refresh every 12 hours and webhook processing every 5 minutes):

```cron
# Run token refresh twice a day
0 */12 * * * php /var/www/jenninexus/scripts/patreon-refresh.php --quiet >> /var/log/patreon-refresh.log 2>&1

# Run webhook processor frequently to pick up new webhooks
*/5 * * * * php /var/www/jenninexus/scripts/patreon-webhook-processor.php >> /var/log/patreon-webhook-processor.log 2>&1
```

Sample systemd unit + timer (preferred for more control):

1) Create `/etc/systemd/system/patreon-refresh.service`:

```ini
[Unit]
Description=Patreon Token Refresh

[Service]
Type=oneshot
WorkingDirectory=/var/www/jenninexus
ExecStart=/usr/bin/php /var/www/jenninexus/scripts/patreon-refresh.php
```

2) Create `/etc/systemd/system/patreon-refresh.timer`:

```ini
[Unit]
Description=Run Patreon token refresh twice daily

[Timer]
OnCalendar=*-*-* 00,12:00:00
Persistent=true

[Install]
WantedBy=timers.target
```

3) Create `/etc/systemd/system/patreon-webhook-processor.service` and `.timer` similarly but set `OnCalendar=` or `OnUnitActiveSec=` for frequent runs.

Security notes:
- Ensure `storage/secrets/patreon.json` is only readable by the deploy/admin user (recommended `chmod 600` and owner `root:www-data` or similar), and that `storage/patreon/` is writable by the web user (www-data) so the site can persist tokens/webhooks.
- The refresh script expects `client_id` and `client_secret` in `storage/secrets/patreon.json`.

Local testing:
- Use `php scripts/patreon-refresh.php --dry-run` to validate connectivity without writing files.
- Use `php scripts/patreon-webhook-processor.php --dry-run` to see what would be processed.


---

## 📦 What Gets Deployed

### ✅ Include
```
public_html/*.php           (10 pages)
public_html/includes/       (PHP partials)
public_html/resources/      (CSS, JS, images, playlists, PDFs)
.config/jenninexus-nginx.conf (Nginx config)
```

### ❌ Exclude
```
src/               (source files)
scripts/           (build scripts)
storage/           (documentation)
.config/mcp*.json  (local MCP configs)
README.md          (this file)
```

---

## Why there is no .env or .env.local

This project avoids runtime .env files on both local and production systems by keeping configuration minimal and environment-specific secrets out of the repository.

- Production configuration (Nginx, PHP-FPM) lives on the server and is managed via the Nginx site config (`.config/jenninexus.conf` deployed to `/etc/nginx/sites-available/` when intentionally updated).
- Secrets (API keys) are not committed. If you need to provide a secret, place it manually on the server as `public_html/resources/secrets.json` (not checked into Git), or use server-side environment variables configured in the systemd service for PHP-FPM.
- The local dev server uses the files in `public_html/` directly and does not require `.env` because the code avoids file-based secret loading; where necessary the build process injects non-sensitive content at build-time from `src/assets`.

This keeps deployment simple: there is no build-time or runtime dependency on an `.env` loader, and the surface area for accidental secrets leaks is minimized.

## How the dev server (`scripts/dev-server.ps1`) works

- `dev-server.ps1` runs the PHP built-in server (via `php -S`) from `public_html/` on port 8002 by default. It serves PHP files directly and uses `router.php` (if present) to support clean URLs.
- This is intended for local development and quick iteration only. It does not try to emulate Nginx fully (no SSL, no advanced routing). Use it to preview PHP rendering and assets.
- Ports: local development uses `http://localhost:8002` (no HTTPS). Production uses Nginx on ports 80/443 and PHP-FPM (socket or tcp). They are separate and do not interfere as long as you run the dev server locally and the production Nginx/PHP services run on the server.

## SSH, Nginx, and ports — simple mapping

- SSH: used for administrative access to the server (deploy, log inspection, config edits). Example: `ssh root@64.23.141.41`.
- Nginx: the webserver running on the server. It listens on ports 80 (HTTP) and 443 (HTTPS). Nginx serves static files and proxies PHP requests to PHP-FPM.
- PHP-FPM: processes PHP scripts. Nginx forwards PHP requests to PHP-FPM via a unix socket (e.g. `/var/run/php/php8.3-fpm.sock`) or a TCP socket.
- Dev server: runs locally on an unprivileged port (8002) so you don't need sudo and you won't conflict with system Nginx. It's purely for development.

If you later want to emulate Nginx locally, run a container or local Nginx using the `.config/jenninexus.conf` as a reference, but this is optional for most workflow tasks.


## 🎨 Brand Colors

- **Primary Pink:** #FF2E88
- **Secondary Purple:** #A563D1
- **Accent Pink:** #FF6EC4
- **Dark Background:** #0f0a1a
- **Title Bar:** #1a0b2e

---

## 📞 Contact & Links

- **Email:** jenninexus@gmail.com
- **YouTube Main:** @jenninexus
- **YouTube Gaming:** @jenniplaysgames
- **YouTube DIY:** @jennidiy
- **Instagram:** @jenninexus
- **TikTok:** @jenninexus
- **Patreon:** patreon.com/jenninexus

---

## 🔄 Common Tasks

### Update Blog Post
```powershell
# 1. Edit Markdown file
code src\assets\blog posts\your-post.md

# 2. Build
.\scripts\build.ps1

# 3. Deploy
.\scripts\deploy.ps1
```

### Update Resume PDF
```powershell
# 1. Replace PDF in src/assets/pdfs/
copy new-resume.pdf src\assets\pdfs\resume_jenninexus_2025.pdf

# 2. Build
.\scripts\build.ps1

# 3. Verify in browser
# http://localhost:8002/resume

# 4. Deploy
.\scripts\deploy.ps1
```

### Add New Playlist
```powershell
# 1. Edit YAML config
code public_html\resources\playlists\gamedev.yaml

# 2. Add playlist entry with ID
# 3. Test locally (dev server auto-refreshes)
# 4. Deploy
.\scripts\deploy.ps1
```

### Compile SCSS
```powershell
# If you have SCSS compilation set up:
# src/assets/scss/ → public_html/resources/css/
# (Currently using pre-compiled CSS)
```

---

## Repository artifacts, playlists, and secrets (clarification)

Why some files were in the repository root
- During development or debugging it's common to produce temporary outputs (cached JSON, test HTML snapshots, or temporarily bundled JS) at the repo root. These are not canonical sources and should not be served directly from the project root in production.
- I found a small set of such artifacts in the repo root (for example: `diy-playlists-deployed.js`, `get-youtube-channel.json`, `get-youtube-output.json`, `diy-page.html`). These were archived to `storage/orphaned/` to keep the repository root clean while preserving the data for audit.

Canonical locations and rules
- Playlists: keep YAML source files in `public_html/resources/playlists/` (these are the authoritative configs consumed by `resources/js/youtube-grid.js`). During build the YAML are copied into the deploy package and any derived JSON (if needed) should live under `public_html/resources/playlists/cache/` or a similar subfolder.
- Playlist index / legacy mapping: `public_html/resources/playlists/playlist-ids.json` (or top-level `public_html/playlist-ids.json` for legacy compatibility) is acceptable but prefer the YAML originals in `public_html/resources/playlists/*.yaml`.
- Secrets / API keys: do NOT commit secrets into Git. Place runtime-only secrets on the server at `public_html/resources/secrets.json` (managed outside Git), or configure them as PHP env variables / systemd environment for PHP-FPM.

What I changed in this cleanup
- Archived root artifacts to `storage/orphaned/` and removed the originals from the repository root.
- Updated documentation here to reflect the canonical locations and that the dev server uses the PHP built-in server.

If you prefer a different archive strategy (move to `public_html/resources/playlists/cache/` or keep a `dev-artifacts/` folder under `storage/`), tell me which option and I'll relocate them.


## 🆘 Troubleshooting

### Dev Server Won't Start
```powershell
# Check if port 8002 is in use
netstat -ano | findstr :8002

# Kill process if needed
taskkill /PID <pid> /F

# Restart dev server
.\scripts\dev-server.ps1
```

### PHP Pages Show Code Instead of Rendering
- **Cause:** Not using PHP server
- **Solution:** Use `.\scripts\dev-server.ps1` (Python HTTP works for local testing)
- **Production:** Nginx + PHP-FPM handles this

### Playlists Not Loading
### Playlists Not Loading

**Symptoms:** Empty grids, 502 errors in console  
**Solutions:**

1. Check server-side cache directory exists:
   ```bash
   ssh root@jennidrop "ls -la /var/www/jenninexus/storage/cache/youtube/"
   ```

2. Check browser console for errors (F12)

3. Verify YAML file syntax (playlists/gaming.yaml, etc.)

4. Check network tab for 502 errors on `/resources/api/get-youtube.php`

5. Test RSS proxy directly:
   ```bash
   # From browser or curl
   https://jenninexus.com/resources/api/get-youtube.php?playlist_id=PL6WnzXOaRqA0laP8POd37FfKmh_lkr4FN
   ```

**Note:** 502 errors are usually temporary PHP timeout issues. The site works perfectly without video grids loaded!

### Deployment Fails
```powershell
# Test SSH connection
ssh root@64.23.141.41

# Test rsync manually
rsync -avz --dry-run deploy/ root@64.23.141.41:/var/www/jenninexus/

# Check script output for errors
.\scripts\build-and-deploy.ps1 -Verbose
```

---

## 📖 Version History

- **v3.0** - PHP conversion with includes system (Oct 2025)
- **v2.5** - Bootstrap 5.3.8 upgrade (Oct 2025)
- **v2.0** - YAML playlist system (Oct 2025)
- **v1.0** - Initial static HTML site (2024)

---

**Last Updated:** October 14, 2025  
**Status:** ✅ Production Ready  
**Bootstrap:** 5.3.8  
**PHP:** 8.3-fpm

---

## Developer Quick Checklist (Essential)

Follow these steps when adding assets or working on pages so resources resolve correctly in subfolders and JS can build paths reliably.

- Use server-side `RES_ROOT` in PHP pages for absolute resource paths:

	- Image example: <code>&lt;img src="<?= RES_ROOT ?>/images/..."&gt;</code>
	- Script example: <code>&lt;script src="<?= RES_ROOT ?>/js/foo.js"&gt;&lt;/script&gt;</code>

- The global head include (`public_html/includes/head.php`) injects `window.RES_ROOT`. In client-side JS prefer:

	- const RESOURCE_BASE = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';

	This keeps client code working even on pages that don't go through PHP (or when testing static builds).

- After editing any PHP page, run a quick syntax check:

```powershell
php -l public_html\path\to\file.php
```

- To find remaining hard-coded references use PowerShell from the repo root:

```powershell
Select-String -Path public_html\**\*.php -Pattern "resources/" -SimpleMatch -List | Select Path,LineNumber
```

- Playlists & secrets:
	- Put YAML playlist sources in `public_html/resources/playlists/`.
	- Keep secrets out of Git. For development you may use `public_html/resources/playlists/secrets.json` but do NOT commit it.

- Archive transient outputs (JSON caches, test HTML, or deployed bundles) under `storage/orphaned/` so the repo root stays clean.

If you'd like, I can add a pre-commit hook to warn when `secrets.json` is staged. Tell me to add it and I'll create the hook.
