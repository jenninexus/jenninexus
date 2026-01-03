# JenniNexus Deployment Scripts

**Project:** JenniNexus Bootstrap 5.3.8 Site  
**Server:** 64.23.141.41 (Nginx + PHP 8.3-FPM)  
**Domain:** https://jenninexus.com

> **📘 COMPLETE DOCUMENTATION:**  
> For the full systematic process, please read:  
> **`storage/docs/DEPLOYMENT-GUIDE.md`**

---

## 🚀 Quick Start

### Just Tell Me to "Deploy"
```powershell
# I'll run the full build and deploy with prompts
.\scripts\build-and-deploy.ps1
```

**What this does (Systematic Process):**
1. **Build All:** Runs `build-all.ps1` (Syncs `src` → `public_html`, generates tags).
2. **Optimize:** Runs `optimize-assets.ps1` (PurgeCSS + Minification).
3. **Package:** Creates a clean deployment package in `deploy/`.
4. **Deploy:** Uploads to server and fixes permissions.

### Build Only (No Deploy)
```powershell
# Build assets from src/ to public_html/resources/
.\scripts\build.ps1

# Create deployment package in deploy/
.\scripts\deploy.ps1 -BuildOnly
```

### Deploy Only (Manual)
```powershell
# Deploy with confirmation prompt
### `build.ps1` vs `build-all.ps1`
#### `build.ps1`
**Purpose:** Copy assets from `src/assets/` to `public_html/resources/`  
**When to use:** Lightweight asset sync after editing SCSS, adding fonts, PDFs, or blog posts. Fast and non-destructive.

#### `build-all.ps1`
**Purpose:** Full rebuild and cleanup (legacy migration steps, SCSS compile attempts, larger fixups). Use when you need deep cleaning or when migrating legacy files.
**When to use:** Run this occasionally (e.g., before releases or when updating the build pipeline). It can remove legacy artifacts and perform broader migrations.
.\scripts\deploy.ps1 -DryRun
```

---

## 📜 Available Scripts

### 🏷️ **Tag System Scripts**

For detailed tag system architecture, see: `storage/docs/TAG-SYSTEM.md`

#### `fix-tag-system.ps1`
**Purpose:** Data integrity maintenance - removes duplicates, indexes blog posts and pages  
**When to use:** After adding blog posts or when tags.json has duplicates

**Usage:**
```powershell
.\scripts\fix-tag-system.ps1 -Verbose
```

**What it does:**
- Removes duplicate tag entries from `tags.json` (by slug)
- Indexes all blog posts from `blog-posts.yaml` → `content_tags.json`
- Indexes main site pages (index, gamedev, gaming, diy, music, blog)
- Creates timestamped backups in `.archive/` folder

**Example output:**
```
✅ Removed 5 duplicate tags (DIY, Gaming, Fashion, Indie, Nails)
✅ Added 9 blog posts to content_tags.json
```powershell
.\scripts\build.ps1          # Build assets
# Include a single maintenance helper script in the deploy package (intentional)
# NOTE: The maintenance helper is intentionally copied into deploy/jenninexus/public_html so that
# when the deploy package is uploaded it lands at /var/www/jenninexus/public_html/fix-permissions-jenninexus-remote.sh
$maintenanceScript = Join-Path $ProjectRoot 'scripts\fix-permissions-jenninexus-remote.sh'
if (Test-Path $maintenanceScript) {
   Copy-Item -Path $maintenanceScript -Destination (Join-Path $TopDeployDir 'jenninexus\public_html\fix-permissions-jenninexus-remote.sh') -Force
   Write-Host "      → Included maintenance script in deploy/jenninexus/public_html: fix-permissions-jenninexus-remote.sh" -ForegroundColor DarkGray
}
- ✅ Logs to `storage/logs/build-YYYY-MM-DD.log`
- ✅ Optional: Removes legacy .html files with `-Clean`

Additional SCSS behavior:
- If a legacy `public_html/resources/scss/` directory exists, `build.ps1` will migrate any files that are missing in `src/assets/scss/` into the canonical source tree. It then removes the legacy `public_html/resources/scss/` folder to avoid accidentally deploying SCSS source.
- If `src/assets/scss/main.scss` exists and a `sass` CLI is available in PATH, the script will attempt to compile it to `src/assets/css/main.css` and a compressed `src/assets/css/main.min.css`.
- If the `sass` CLI is not found or `main.scss` is missing, the script will log a WARN and fall back to copying files from `src/assets/css/` (prebuilt CSS). The script does not install `sass` automatically.

If you want automatic SCSS compilation on your machine or CI, install Dart Sass (recommended):

Windows (PowerShell):
```powershell
# Using npm (if you have Node.js)
npm install -g sass

# Or download Dart Sass distribution and add to PATH
```

Once `sass` is available on PATH, running `.\\scripts\\build.ps1` will produce `src/assets/css/main.css` and `src/assets/css/main.min.css` when `main.scss` is present.

---

### `deploy.ps1` ⭐ **MAIN DEPLOYMENT**
**Purpose:** Create deployment package and upload to production server  
**When to use:** When you want to push changes to live site  

**Usage:**
```powershell
.\scripts\deploy.ps1                # Full deployment (prompts for confirmation)
.\scripts\deploy.ps1 -BuildOnly     # Just create deploy/ package
.\scripts\deploy.ps1 -DryRun        # Test deployment (no changes)
.\scripts\deploy.ps1 -SkipNginx     # Skip Nginx config upload
# Optional: pass a ServerAlias from your SSH config and/or identity file
# .\scripts\deploy.ps1 -DryRun -ServerAlias main-jenninexus -IdentityFile 'C:\Users\Owner\.ssh\main_jenninexus'
```

**What it does:**
1. **Stage 1: Build Package**
   - Purges `deploy/` directory
   - Copies `public_html/` → `deploy/`
   - Removes: .html, .map, .md, !bak/, scss/
   - Creates `.htaccess`
   - Shows file count

2. **Stage 2: Confirmation Prompt** (unless -DryRun)
   - Shows deployment summary
   - Requires typing "yes" to proceed
   - Can cancel safely

3. **Stage 3: Upload to Server**
   - Tests SSH connection
   - Uses SCP (rsync fallback)
   - Uploads to `/var/www/jenninexus/`
   - Sets permissions: `www-data:www-data` (755)
   - Verifies permissions after upload
   - Optionally uploads Nginx config

**Deployment Safety:**
- ✅ Always prompts for confirmation (unless -DryRun)
- ✅ Tests SSH before uploading
- ✅ Verifies permissions after upload
- ✅ Dry run mode available
- ✅ Build-only mode for testing package

---

### `build-and-deploy.ps1`
**Purpose:** Complete pipeline - build assets, create package, deploy  
**When to use:** Full deployment from scratch  

**Usage:**
```powershell
.\scripts\build-and-deploy.ps1            # Full pipeline
.\scripts\build-and-deploy.ps1 -BuildOnly # Just build, don't deploy
.\scripts\build-and-deploy.ps1 -Clean     # Clean old files first
```

**What it does:**
1. **Stage 1: Build & Optimize**
   - Cleans old .html files
   - Removes backup/junk files
   - Verifies PHP pages exist
   - Verifies includes exist
   - **Runs `optimize-assets.ps1`** (PurgeCSS + Minification)
   - Shows deployment summary

2. **Stage 2: Create Deploy Package**
   - Purges `deploy/`
   - Copies with exclusions
   - Creates `.htaccess`
   - Generates `MANIFEST.txt`

3. **Stage 3: Deployment Prompt**
   - Shows what will be deployed
   - Asks for confirmation
   - Calls `deploy.ps1` if approved
   - Shows final success message

**Double Confirmation:**
- Prompts once in build-and-deploy.ps1
- Prompts again in deploy.ps1
- Safe for automated workflows

---

### `optimize-assets.ps1`
**Purpose:** Optimize CSS/JS assets (PurgeCSS + Minification)
**When to use:** Automatically called by `build-and-deploy.ps1`, or run manually to test optimization.

**Usage:**
```powershell
.\scripts\optimize-assets.ps1          # Run optimization
.\scripts\optimize-assets.ps1 -DryRun  # Preview changes
```

**What it does:**
- **PurgeCSS:** Removes unused CSS from Bootstrap 5.3.8 and FontAwesome 6.7.2 bundles (saves ~60-80%).
- **Minification:** Minifies custom CSS and JS files using `clean-css-cli` and `terser` (if available).
- **Safelist:** Preserves dynamic classes (navbar, modal, etc.) to prevent broken UI.

**Prerequisites:**
- Node.js and npm installed.
- `npm install --save-dev purgecss` (script attempts to install if missing).

---

### `dev-server.ps1`
**Purpose:** Start local PHP development server  
**When to use:** Testing changes before deployment  

**Usage:**
```powershell
.\scripts\dev-server.ps1         # Start on port 8002
.\scripts\dev-server.ps1 -Port 8003  # Custom port
.\scripts\dev-server.ps1 -Build  # Build SCSS first
```

**Access:**
- http://localhost:8002 (default)
- Serves from `public_html/`
- Processes PHP files
- Clean URLs via router.php

---

## 🎯 Deployment Workflows

### Workflow 1: Quick Deploy (Tell me "deploy")
```powershell
# I'll run this:
.\scripts\build-and-deploy.ps1

# It will:
# 1. Build assets
# 2. Create deploy package
# 3. Prompt for confirmation
# 4. Deploy to production
# 5. Set permissions
```

### Workflow 2: Build Then Deploy Manually
```powershell
# Step 1: Build assets
.\scripts\build.ps1

# Step 2: Create deployment package
.\scripts\deploy.ps1 -BuildOnly

# Step 3: Review files in deploy/

# Step 4: Test with dry run
.\scripts\deploy.ps1 -DryRun

# Step 5: Deploy for real (prompts for confirmation)
.\scripts\deploy.ps1
```

### Workflow 3: Just Deploy (No Build)
```powershell
# If you've already tested locally and just want to push
.\scripts\deploy.ps1

# Will prompt: "Type 'yes' to continue"
# Then uploads and sets permissions
```

---

## � Pretty URLs and routing

Routing for the development server is handled by `public_html/router.php` (used by `dev-server.ps1`). That file implements lightweight, fast, PHP-based routing for the built-in PHP server and provides these behaviors:

- Clean URLs for top-level pages: `/music` → `music.php`, `/gamedev` → `gamedev.php` (the router tries `$uri . '.php'`).
- Clean sub-directory routes for games and blog posts:
   - `/game/<slug>` → `public_html/game/<slug>.php` (router uses a preg_match for `^/game/([^/]+)$`).
   - `/blog/<slug>` → `public_html/blog/<slug>.php` (router uses a preg_match for `^/blog/([^/]+)$`).
- Static files (CSS/JS/images/webfonts/etc.) are served directly when the path exists on disk.

Best practices for links in templates and pages:

- Use clean URLs in navigation and internal links (e.g. `href="/gamedev"`, not `href="gamedev.php"`).
- Use relative resource paths inside subdirectories so `fix-all-pages-consistency.ps1` can normalize them to `../resources/...` when moving files into `game/` or `blog/` subfolders.

Fixup tooling:

- `scripts/fix-all-pages-consistency.ps1` will scan pages and convert hard-coded `.php` links to clean URLs, standardize include paths to `../includes/`, and normalize resource references to `../resources/`. Run it when you migrate pages into subdirectories or after bulk edits.

If you need to change routing behavior for production, edit the server configuration (Nginx/Apache) or modify `public_html/router.php`. The router is intended for local development only; production uses the webserver's rewrite rules.

## 🗄️ Archived / deprecated scripts

Some helper scripts are kept for reference but are no longer intended to be run directly. These are moved to `scripts/archived/` and are safe to inspect if you need historical behavior. If you want a script restored, move it back to `scripts/`.


## �🔒 Safety Features

### All Deployment Scripts Have:
- ✅ **Confirmation Prompts** - Type "yes" to proceed
- ✅ **Dry Run Mode** - Test without making changes
- ✅ **SSH Connection Test** - Validates before upload
- ✅ **Permission Verification** - Checks after upload
- ✅ **File Count Display** - Shows what's being deployed
- ✅ **Cancellation** - Easy to abort at any prompt

### Automatic Purging:
- ❌ Legacy .html files removed
- ❌ CSS source maps (.map) removed
- ❌ Markdown files (.md) removed
- ❌ Backup folders (!bak, scss) removed
- ✅ Only production-ready files deployed

---

## 📋 Deployment Checklist

Before running `deploy.ps1`:
- [ ] Test locally: `.\scripts\dev-server.ps1`
- [ ] Commit changes to git
- [ ] Review `deploy/` contents
- [ ] Check file count makes sense
- [ ] Run dry run: `.\scripts\deploy.ps1 -DryRun`

After deployment:
- [ ] Visit https://jenninexus.com
- [ ] Check all pages load
- [ ] Open browser console (F12)
- [ ] Verify no 404 errors
- [ ] Test Font Awesome icons display
- [ ] Check mobile responsive

---

## 🗂️ Archived Scripts

See `scripts/archive/README.md` for scripts no longer needed:
- `fix-paths.ps1` - HTML path fixer (we use PHP now)
- `check-bootstrap-compatibility.ps1` - Bootstrap 5.3.8 migration checker (complete)
- `optimize-tags.ps1` - Tag SEO optimizer (superseded by manual curation)
- `import-youtube-tags.js` - YouTube RSS tag importer (superseded by YAML workflow)

---

## 📞 Quick Reference

| Task | Command |
|------|---------|
| **Full build & deploy** | `.\scripts\build-and-deploy.ps1` |
| **Deploy only** | `.\scripts\deploy.ps1` |
| **Test deployment** | `.\scripts\deploy.ps1 -DryRun` |
| **Build package** | `.\scripts\deploy.ps1 -BuildOnly` |
| **Build assets** | `.\scripts\build.ps1` |
| **Optimize assets** | `.\scripts\optimize-assets.ps1` |
| **Local dev server** | `.\scripts\dev-server.ps1` |
| **Just say "deploy"** | I'll run build-and-deploy.ps1 for you! |

---

**Pro Tip:** You can just tell me "deploy jenninexus" or "build and deploy" and I'll run the appropriate script with all the prompts and safety checks!
