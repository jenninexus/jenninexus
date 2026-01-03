# 🚀 JenniNexus Deployment Guide - Isolated Architecture

**Last Updated:** December 24, 2025  
**Server:** 64.23.141.41 (SSH Alias: jennidrop-root)  
**Domain:** jenninexus.com  
**Status:** ✅ READY FOR PRODUCTION

**Recent Updates (Jan 02, 2026):**
- ✅ **FONTAWESOME REORGANIZED** - Moved FontAwesome 6.7.2 to `public_html/resources/vendor/fontawesome/` for better organization.
- ✅ **GITHUB PACKAGE REFINED** - Updated `build-github-package.ps1` to exclude large assets (images, videos, etc.) for a minimal GitHub project.
- ✅ **SSH ALIAS UNIFIED** - Standardized on `jennidrop-root` across all documentation.

**Recent Updates (Dec 24, 2025):**
- ✅ **Remote Permissions Script Fixed** - `fix-permissions-jenninexus-remote.sh` now correctly handles directory changes.
- ✅ **Strict Exclusions Enforced** - `archived/` and `!bak/` folders automatically removed during build.
- ✅ **Backup Optimization** - Excluded `storage/deploys` and large media from remote backups.

---

## 🏗️ Isolated Architecture Overview

This project is now **100% self-contained**.

### Key Changes:
1. **No Shared Framework**: The site no longer relies on `/var/www/shared` or workspace-level symlinks.
2. **Local Assets**: All CSS, JS, and vendor libraries are stored within the project root.
3. **Build Pipeline**: Assets are copied from `src/assets/` to `public_html/resources/` using local scripts.
4. **Minification**: Uses `clean-css-cli` and `terser` installed via local `npm`.

---

## 🎨 Asset Optimization Pipeline

### Overview
JenniNexus includes automatic CSS/JS minification. All assets are managed locally.

### What Gets Optimized
**CSS Minification:**
- All theme CSS files minified (custom.css → custom.min.css, etc.)
- Uses `clean-css-cli` for minification.

**Vendor Libraries (Local):**
- **Bootstrap 5.3.8**: Located at `public_html/resources/vendor/bootstrap/`.
- **FontAwesome 6.7.2**: Located at `public_html/resources/vendor/fontawesome/css/all.min.css`.

**Total Impact:**
- ~200-300 KB savings per page load.
- Faster page loads and better Core Web Vitals.

---

## 🚀 Full Deployment Process

### The "One Script" Workflow
We have unified the deployment process into a single script that handles everything in the correct order.

```powershell
.\scripts\build-and-deploy.ps1
```

### Deployment Steps:
1. **Stage 0: Full Build** (`build-all.ps1`)
   - Generates tags.
   - Syncs assets from `src/` to `public_html/`.
2. **Stage 1: Prepare & Verify**
   - Cleans legacy files.
   - **Optimizes Assets** (PurgeCSS + local minification).
3. **Stage 2: Create Package**
   - Copies `public_html` to `deploy/jenninexus`.
   - Removes dev files (markdown, maps, backups).
4. **Stage 3: Deploy** (`deploy.ps1`)
   - Prompts for confirmation.
   - Uploads to `jennidrop-root` via `rsync`.
   - Runs remote `fix-permissions-jenninexus-remote.sh`.

---

## 🔐 SSH Configuration Reference

### **Your SSH Aliases:**
```
Host jennidrop-root
  HostName 64.23.141.41
  User root
  IdentityFile ~/.ssh/id_jennidrop.openssh
```

### **Your SSH Keys:**
- **Private Key:** `C:\Users\Owner\.ssh\id_jennidrop.openssh`
- **Public Key:** `C:\Users\Owner\.ssh\id_jennidrop.pub`

---

## 📊 Deployment Checklist

- [x] All .html files converted to .php
- [x] PHP includes using local vendor paths
- [x] Assets optimized via local build scripts
- [x] No `shared-deps` symlinks present
- [x] Tested locally at http://localhost:8002
