# JenniNexus Build System Guide

## Overview

The JenniNexus build system manages asset compilation, file synchronization, and deployment to production.

## Build Scripts

### 1. `build.ps1` - Asset Builder

**Purpose**: Copy assets from `src/assets/` to `public_html/resources/`

**Usage**:
```powershell
.\scripts\build.ps1           # Normal build
.\scripts\build.ps1 -Clean    # Build + remove legacy HTML files
```

**What It Does**:
- ✅ Copies PDFs from src → public_html
- ✅ Copies blog posts (*.md) 
- ✅ Copies fonts
- ✅ Copies SVGs
- ✅ Copies CSS files
- ✅ Copies JavaScript files
- ✅ Copies YAML playlists
- ✅ Copies images (recursive)
- ✅ Logs all operations to `storage/logs/build-YYYY-MM-DD.log`
- ✅ Counts files copied
- ✅ Reports errors

**Output**:
```
=== JenniNexus Build Started ===
Copying from src/assets to public_html/resources...
  → Copied 5 PDF files
  → Copied 5 blog posts
  → Copied 12 font files
  → Copied 8 SVG files
  → Copied 3 CSS files
  → Copied 10 JavaScript files
  → Copied 6 playlist files
Build complete! Total files copied: 49
=== Build Finished ===
```

**Log File Location**: `storage/logs/build-2025-10-14.log`

### 2. `dev-server.ps1` - Development Server

**Purpose**: Start local Python HTTP server for testing

**Usage**:
```powershell
.\scripts\dev-server.ps1              # Start server on port 8002
.\scripts\dev-server.ps1 -Build       # Build assets first, then start server
.\scripts\dev-server.ps1 -Port 8000   # Use custom port
```

**Features**:
- Serves from `public_html/` directory
- Default port: 8002 (JenniNexus designated port)
- Clean URLs supported (e.g., `/gamedev` works)
- Optional build before serving

**Output**:
```
═══════════════════════════════════════════════════════
  JenniNexus Development Server
═══════════════════════════════════════════════════════

📂 Server Directory: C:\...\public_html
🌐 Server URL: http://localhost:8002
🎯 Designated Port: 8002 (JenniNexus)

📄 Available Pages:
   • http://localhost:8002/               (Home)
   • http://localhost:8002/gamedev        (Game Dev)
   • http://localhost:8002/music          (Music)
   ...
```

### 3. `build-and-deploy.ps1` - Full Build & Deploy Pipeline

**Purpose**: Build, package, and prompt for production deployment

**Usage**:
```powershell
.\scripts\build-and-deploy.ps1           # Full pipeline
.\scripts\build-and-deploy.ps1 -BuildOnly # Just create deploy package
.\scripts\build-and-deploy.ps1 -Clean    # Clean old files first
```

**Stages**:

#### Stage 1: Build & Optimize
1. Clean old HTML files from public_html
2. Remove backup files (*.bak, *.tmp, etc.)
3. Verify all PHP pages exist
4. Verify PHP includes exist (head, header, footer)
5. Analyze deployment size

#### Stage 2: Create Deploy Package
1. Clean deploy/ directory (if -Clean)
2. Copy public_html → deploy/ (excludes: HTML, backups, markdown)
3. Create .htaccess with caching and security headers
4. Generate deployment manifest

**Output Manifest** (`deploy/MANIFEST.txt`):
```
# JenniNexus Deployment Manifest
Generated: 2025-10-14 15:30:00

## Files Deployed: 143

### PHP Pages: 10
- blog.php
- diy.php
- gamedev.php
...

### Resources:
- JavaScript files: 10
- CSS files: 3
- YAML playlists: 6
- PDF documents: 5

### Server Configuration:
- Target: 64.23.141.41:/var/www/jenninexus/
- Nginx config: jenninexus-nginx.conf
- PHP version: 8.3-FPM
- Permissions: www-data:www-data (755)
```

### 4. `deploy.ps1` - Production Deployment

**Purpose**: Deploy to production server (64.23.141.41)

**Usage**:
```powershell
.\scripts\deploy.ps1              # Full deployment
.\scripts\deploy.ps1 -BuildOnly   # Just build deploy/ directory
.\scripts\deploy.ps1 -DryRun      # Test without changes
.\scripts\deploy.ps1 -SkipNginx   # Skip Nginx config upload
```

**Requirements**:
- rsync installed (`choco install rsync`)
- SSH key authentication to server
- Root access to 64.23.141.41

**What It Does**:
1. Build deploy/ directory from public_html/
2. Test SSH connection
3. rsync files to /var/www/jenninexus/
4. Set permissions (www-data:www-data, 755)
5. Upload Nginx config
6. Test Nginx config
7. Reload Nginx + PHP-FPM 8.3

**Output**:
```
╔════════════════════════════════════════════════════╗
║           ✅ Deployment Successful! 🎉            ║
╚════════════════════════════════════════════════════╝

🌐 Visit: https://jenninexus.com
📊 Logs:  ssh root@64.23.141.41 'sudo tail -f /var/log/nginx/jenninexus.access.log'
```

### 5. `check-bootstrap-compatibility.ps1` - Bootstrap Upgrade Checker

**Purpose**: Scan for Bootstrap 5.3.3 → 5.3.8 compatibility issues

**Usage**:
```powershell
.\scripts\check-bootstrap-compatibility.ps1           # Basic scan
.\scripts\check-bootstrap-compatibility.ps1 -Detailed # Detailed output
```

**Checks**:
- ✅ Bootstrap version references
- ✅ Bootstrap SCSS imports
- ✅ Floating label usage
- ✅ Card group usage
- ✅ Visually hidden classes
- ✅ Dropdown components
- ✅ Color contrast functions
- ✅ Spinner components

**Output**: JSON report saved to `storage/bootstrap-compatibility-report.json`

### 6. `fix-paths.ps1` - Legacy Path Fixer

**Purpose**: Fix old HTML file paths (rarely needed)

**Usage**:
```powershell
.\scripts\fix-paths.ps1
```

**Note**: Only use if you have old HTML files with incorrect resource paths.

## Asset Directory Structure

### Source Assets (`src/assets/`)
```
src/assets/
├── pdfs/              # PDF documents
├── blog posts/        # Markdown blog posts
├── fonts/             # Font files
├── svgs/              # SVG icons
├── css/               # Compiled CSS
├── js/                # JavaScript files
├── images/            # Image assets
├── playlists/         # YAML playlist configs
├── scss/              # SCSS source files
└── secrets.json       # API keys (not deployed)
```

### Public Resources (`public_html/resources/`)
```
public_html/resources/
├── pdfs/              # Built from src/assets/pdfs/
├── blog posts/        # Built from src/assets/blog posts/
├── fonts/             # Built from src/assets/fonts/
├── svgs/              # Built from src/assets/svgs/
├── css/               # Built from src/assets/css/
├── js/                # Built from src/assets/js/
├── images/            # Built from src/assets/images/
├── playlists/         # Built from src/assets/playlists/
├── scss/              # SCSS source (for reference)
└── secrets.json       # Built from src/assets/secrets.json
```

## Build Workflow

### Daily Development Workflow

1. **Make changes to source files** (`src/assets/`)
2. **Build assets**:
   ```powershell
   .\scripts\build.ps1
   ```
3. **Test locally**:
   ```powershell
   .\scripts\dev-server.ps1 -Build
   ```
4. **Open browser**: http://localhost:8002
5. **Verify changes work**
6. **Check build log**: `storage/logs/build-2025-10-14.log`

### Production Deployment Workflow

1. **Test locally first**:
   ```powershell
   .\scripts\dev-server.ps1 -Build
   ```

2. **Build deployment package**:
   ```powershell
   .\scripts\build-and-deploy.ps1 -BuildOnly
   ```

3. **Review manifest**:
   ```powershell
   cat deploy\MANIFEST.txt
   ```

4. **Dry run deployment**:
   ```powershell
   .\scripts\deploy.ps1 -DryRun
   ```

5. **Deploy to production**:
   ```powershell
   .\scripts\deploy.ps1
   ```

6. **Verify live site**: https://jenninexus.com

## Troubleshooting

### Build Issues

**Problem**: Files not copying
- Check source paths exist in `src/assets/`
- Review error log in `storage/logs/build-YYYY-MM-DD.log`
- Run with `-Clean` flag

**Problem**: Permission denied
- Run PowerShell as Administrator
- Check file locks (close editors)

### Deployment Issues

**Problem**: SSH connection failed
- Test SSH: `ssh root@64.23.141.41`
- Check SSH key authentication
- Verify firewall rules

**Problem**: rsync not found
- Install: `choco install rsync`
- Restart PowerShell

**Problem**: Nginx config test failed
- Check syntax in `.config/jenninexus-nginx.conf`
- Test locally: `nginx -t` on server

## Build Script Logs

### Log Location
```
storage/logs/build-YYYY-MM-DD.log
```

### Log Format
```
[2025-10-14 15:30:00] [INFO] === JenniNexus Build Started ===
[2025-10-14 15:30:01] [INFO] Copying from src/assets to public_html/resources...
[2025-10-14 15:30:01] [INFO]   → Copied 5 PDF files
[2025-10-14 15:30:02] [SUCCESS] Build complete! Total files copied: 49
[2025-10-14 15:30:02] [INFO] === Build Finished ===
```

### Log Levels
- **INFO**: General information
- **SUCCESS**: Successful operations
- **WARN**: Warnings (non-fatal)
- **ERROR**: Errors (operations failed)

## Best Practices

1. **Always test locally before deploying**
   ```powershell
   .\scripts\dev-server.ps1 -Build
   ```

2. **Use dry-run for deployment testing**
   ```powershell
   .\scripts\deploy.ps1 -DryRun
   ```

3. **Check logs after builds**
   ```powershell
   cat storage\logs\build-2025-10-14.log
   ```

4. **Review deployment manifest**
   ```powershell
   cat deploy\MANIFEST.txt
   ```

5. **Keep backups**
   - Git commit before major changes
   - Keep old deploy/ directory if needed

## Environment Variables

None required. All paths are relative to project root.

## Dependencies

- **PowerShell**: Core Windows scripting
- **Python**: For dev server (http.server module)
- **rsync**: For deployment (install via Chocolatey)
- **SSH**: For server access (built-in Windows 10+)

## Quick Reference

```powershell
# Daily workflow
.\scripts\build.ps1
.\scripts\dev-server.ps1 -Build

# Full deployment
.\scripts\build-and-deploy.ps1
.\scripts\deploy.ps1

# Bootstrap upgrade check
.\scripts\check-bootstrap-compatibility.ps1 -Detailed

# View logs
cat storage\logs\build-2025-10-14.log
cat deploy\MANIFEST.txt
```

## Next Steps

1. ✅ Build scripts fully configured
2. ✅ Logging system in place
3. ⏳ Get Bootstrap 5.3.8 SRI hashes
4. ⏳ Test full deployment pipeline
5. ⏳ Update production server
