# JenniNexus Scripts - Consolidated & Updated
**All paths fixed and scripts optimized**

📅 **Updated:** October 14, 2025  
✨ **Status:** Production Ready

---

## 📁 Script Locations

All scripts are in: `jenninexus/scripts/`

```
scripts/
├── build.ps1                           # Simple asset copy (src → public_html)
├── build-and-deploy.ps1                # Full build + deploy package + prompt
├── deploy.ps1                          # Deploy to production server
├── dev-server.ps1                      # Local development server (port 8002)
├── fix-paths.ps1                       # Legacy path fixer (HTML only)
└── check-bootstrap-compatibility.ps1   # Bootstrap 5.3.3 → 5.3.8 checker
```

---

## 🔄 Scripts Overview

### **1. build.ps1** - Simple Asset Builder
**Purpose:** Quick copy of assets from `src/assets/` to `public_html/resources/`

**What it does:**
- Copies PDFs
- Copies blog posts (Markdown)
- Copies fonts
- Copies SVGs

**When to use:**
- During development when you've updated static assets
- Quick resource sync

**Usage:**
```powershell
.\scripts\build.ps1
```

**Output:**
- Copies files from `src/assets/` to `public_html/resources/`
- No cleaning, no deployment, just copy

---

### **2. build-and-deploy.ps1** - Full Pipeline
**Purpose:** Complete build → package → deploy workflow

**What it does:**
1. **BUILD STAGE:**
   - Cleans old `.html` files
   - Removes backup/junk files
   - Verifies all PHP pages exist
   - Verifies includes exist
   - Shows deployment summary

2. **PACKAGE STAGE:**
   - Creates `deploy/` directory
   - Copies `public_html/` → `deploy/`
   - Excludes: `.html`, `.backup`, `.bak`, `.md`
   - Creates `.htaccess` with production settings
   - Generates deployment manifest

3. **DEPLOY PROMPT:**
   - Asks for confirmation
   - Calls `deploy.ps1` if confirmed
   - Shows next steps if declined

**Flags:**
- `-BuildOnly` - Stop after build verification (don't create package)
- `-Clean` - Clean `deploy/` before building

**Usage:**
```powershell
# Full pipeline
.\scripts\build-and-deploy.ps1

# Just verify build
.\scripts\build-and-deploy.ps1 -BuildOnly

# Clean deploy folder first
.\scripts\build-and-deploy.ps1 -Clean
```

**Output:**
- Verified build
- Deploy package in `deploy/`
- Optional: Deployment to production

---

### **3. deploy.ps1** - Production Deployment
**Purpose:** Upload deploy package to production server

**What it does:**
1. **BUILD STAGE (if not using build-and-deploy):**
   - Optionally cleans `deploy/`
   - Creates `deploy/` directory
   - Copies `public_html/` → `deploy/`
   - Creates `.htaccess`

2. **DEPLOY STAGE:**
   - Tests SSH connection to `64.23.141.41`
   - Syncs files via `rsync`
   - Sets permissions (`www-data:www-data`, 755)
   - Uploads Nginx config (if exists)
   - Tests Nginx configuration
   - Reloads Nginx + PHP-FPM 8.3

**Flags:**
- `-BuildOnly` - Just build deploy folder, don't upload
- `-Clean` - Clean deploy folder before building
- `-DryRun` - Test deployment without making changes
- `-SkipNginx` - Don't upload/reload Nginx config

**Usage:**
```powershell
# Full deployment
.\scripts\deploy.ps1

# Test deployment (no changes)
.\scripts\deploy.ps1 -DryRun

# Just build deploy folder
.\scripts\deploy.ps1 -BuildOnly

# Deploy without Nginx config
.\scripts\deploy.ps1 -SkipNginx
```

**Requirements:**
- `rsync` installed (`choco install rsync`)
- SSH key configured for `root@64.23.141.41`
- Nginx config at: `..\..\.config\jenninexus-nginx.conf` (relative to project root)

**Output:**
- Files deployed to `/var/www/jenninexus/`
- Nginx reloaded
- Site live at `https://jenninexus.com`

---

### **4. dev-server.ps1** - Local Development Server
**Purpose:** Start local HTTP server for testing

**What it does:**
- Starts Python HTTP server on port 8002
- Serves from `public_html/` directory
- Supports clean URLs (e.g., `/gamedev` works)
- Optionally builds assets first

**Flags:**
- `-Port <number>` - Custom port (default: 8002)
- `-Build` - Run `build.ps1` before starting server

**Usage:**
```powershell
# Start server
.\scripts\dev-server.ps1

# Build first, then serve
.\scripts\dev-server.ps1 -Build

# Custom port
.\scripts\dev-server.ps1 -Port 8080
```

**Access:**
```
http://localhost:8002/              # Home
http://localhost:8002/gamedev       # Game Dev page
http://localhost:8002/music         # Music page
http://localhost:8002/blog          # Blog page
etc.
```

**Stop server:** `Ctrl+C`

---

### **5. check-bootstrap-compatibility.ps1** - Bootstrap Upgrade Checker
**Purpose:** Check compatibility for Bootstrap 5.3.3 → 5.3.8 upgrade

**What it does:**
- Scans for Bootstrap version references
- Checks for breaking changes
- Identifies components to test
- Checks:
  - Version references in files
  - Floating labels usage
  - Card groups
  - Visually hidden elements
  - Dropdowns
  - Color contrast functions
  - Spinners
  - Custom Bootstrap imports

**Flags:**
- `-Detailed` - Show all findings (issues + warnings + info)
- `-FixIssues` - (Not yet implemented)

**Usage:**
```powershell
# Quick scan
.\scripts\check-bootstrap-compatibility.ps1

# Detailed report
.\scripts\check-bootstrap-compatibility.ps1 -Detailed
```

**Output:**
- Console report (color-coded)
- JSON report: `storage/bootstrap-compatibility-report.json`
- Recommendations for upgrade path

---

### **6. fix-paths.ps1** - Legacy Path Fixer
**Purpose:** Fix old path references in HTML files

**What it does:**
- Converts old paths to use `resources/` directory
- Fixes: CSS, JS paths
- Updates: `custom.css`, theme toggles, playlists, etc.

**Status:** ⚠️ **Legacy** - Only needed for old `.html` files

**When to use:**
- If you have old `.html` files with broken paths
- Migrating from old structure

**Usage:**
```powershell
.\scripts\fix-paths.ps1
```

**Note:** Should NOT be needed anymore since we use `.php` files now.

---

## 🎯 Common Workflows

### **Development Workflow**
```powershell
# 1. Start dev server
.\scripts\dev-server.ps1

# 2. Make changes to files
# 3. Refresh browser

# 4. If you updated assets:
.\scripts\build.ps1

# 5. Refresh browser again
```

---

### **Deployment Workflow (Recommended)**
```powershell
# 1. Build and deploy with prompts
.\scripts\build-and-deploy.ps1

# 2. Review the deploy package
# 3. Confirm deployment when prompted

# Site is now live!
```

---

### **Manual Deployment Workflow**
```powershell
# 1. Build deploy package
.\scripts\build-and-deploy.ps1 -BuildOnly

# 2. Review files in deploy/
explorer deploy/

# 3. Deploy when ready
.\scripts\deploy.ps1
```

---

### **Safe Deployment Workflow**
```powershell
# 1. Test deployment (no changes)
.\scripts\deploy.ps1 -DryRun

# 2. Review what will be deployed

# 3. Deploy for real
.\scripts\deploy.ps1
```

---

## 📝 Script Consolidation Analysis

### **Overlap Between Scripts:**

#### `build.ps1` vs `build-and-deploy.ps1`:
- **build.ps1:** Simple asset copy only
- **build-and-deploy.ps1:** Full build verification + deploy package creation

**Recommendation:** ✅ Keep both
- `build.ps1` - Quick development builds
- `build-and-deploy.ps1` - Production deployments

---

#### `build-and-deploy.ps1` vs `deploy.ps1`:
- **build-and-deploy.ps1:** Creates package + prompts for deployment
- **deploy.ps1:** Can build OR just deploy existing package

**Recommendation:** ✅ Keep both
- `build-and-deploy.ps1` - Full pipeline with safety prompts
- `deploy.ps1` - Direct deployment or standalone deploy

---

#### `fix-paths.ps1`:
- **Status:** Legacy script
- **Purpose:** Fixed old HTML file paths

**Recommendation:** ⚠️ **Keep but document as legacy**
- Only use if you have old `.html` files
- Not needed for current `.php` files

---

## 🔧 Path Corrections Made

### **All scripts now use:**
```powershell
$ProjectRoot = Split-Path -Parent $PSScriptRoot   # Parent of scripts/
$PublicHtml = Join-Path $ProjectRoot "public_html"
$DeployDir = Join-Path $ProjectRoot "deploy"
$SrcAssets = Join-Path $ProjectRoot "src\assets"
```

### **Documentation paths updated:**
All references changed from:
- ❌ `docs/BOOTSTRAP-*.md`

To:
- ✅ `storage/docs/BOOTSTRAP-*.md`

### **Scripts updated:**
1. ✅ `check-bootstrap-compatibility.ps1` - Updated doc paths
2. ✅ Workspace summary - Updated all doc references

---

## 🎯 Best Practices

### **For Development:**
```powershell
# Use dev server with auto-build
.\scripts\dev-server.ps1 -Build
```

### **For Production:**
```powershell
# Use full pipeline (safest)
.\scripts\build-and-deploy.ps1
```

### **For Quick Fixes:**
```powershell
# Direct deploy (skip build verification)
.\scripts\deploy.ps1
```

### **For Testing:**
```powershell
# Dry run first
.\scripts\deploy.ps1 -DryRun

# Then deploy
.\scripts\deploy.ps1
```

---

## 📊 Script Dependency Map

```
build.ps1
  └─ Standalone (no dependencies)

build-and-deploy.ps1
  └─ Calls: deploy.ps1 (optional, on confirmation)

deploy.ps1
  └─ Standalone (can build or just deploy)

dev-server.ps1
  └─ Optionally calls: build.ps1 (with -Build flag)

check-bootstrap-compatibility.ps1
  └─ Standalone (generates report)

fix-paths.ps1
  └─ Standalone (legacy)
```

---

## ✅ Verification Checklist

After script consolidation:

### **build.ps1:**
- [x] Paths correct (`src/assets/` → `public_html/resources/`)
- [x] No broken references
- [x] Works standalone

### **build-and-deploy.ps1:**
- [x] Paths correct
- [x] Calls `deploy.ps1` correctly
- [x] All verifications work
- [x] Manifest generation works
- [x] .htaccess creation works

### **deploy.ps1:**
- [x] Paths correct
- [x] SSH connection works
- [x] rsync works
- [x] Nginx config path correct (`..\..\.config\jenninexus-nginx.conf`)
- [x] Permissions set correctly

### **dev-server.ps1:**
- [x] Paths correct
- [x] Port 8002 default
- [x] Optional build works
- [x] Serves from `public_html/`

### **check-bootstrap-compatibility.ps1:**
- [x] Paths correct
- [x] Doc paths updated (`storage/docs/`)
- [x] Report paths correct
- [x] Scans work

### **fix-paths.ps1:**
- [x] Paths correct
- [x] Documented as legacy
- [x] Still works if needed

---

## 🎉 Summary

All scripts have been:
- ✅ **Audited** for correct paths
- ✅ **Consolidated** where appropriate
- ✅ **Documented** with clear usage
- ✅ **Updated** to reference `storage/docs/`
- ✅ **Tested** for path correctness

**No scripts were deleted** - each serves a specific purpose.

**Recommended daily use:**
- Development: `dev-server.ps1`
- Asset updates: `build.ps1`
- Deployment: `build-and-deploy.ps1`

---

*Last Updated: October 14, 2025*  
*All paths verified and corrected*
