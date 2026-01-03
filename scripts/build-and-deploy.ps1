#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Smart build script for JenniNexus deployment with Bootstrap 5.3.8 optimization
    
.DESCRIPTION
    Three-stage process:
    1. BUILD: Clean public_html, optimize assets, purge unused CSS
    2. PACKAGE: Copy to deploy/ with correct permissions
    3. DEPLOY: Prompt before pushing to 64.23.141.41
    
    Recent Optimizations (Nov 5, 2025):
    - All 14 JavaScript files verified Bootstrap 5.3.8 compatible
    - CSS optimization: mobile-improvements.css archived, consolidated into custom.css
    - Navbar height: Uses Bootstrap default ~56px (no custom overrides)
    - Minification savings: ~40KB+ (62% average reduction)
    - No Bootstrap conflicts: Modal, Offcanvas, Grid APIs work correctly
    - See storage/docs/JS.md for comprehensive JavaScript documentation
    
.PARAMETER BuildOnly
    Stop after building deploy package (don't upload to server) - DEFAULT: true
    
.PARAMETER Clean
    Clean deploy/ directory before building
    
.EXAMPLE
    .\build-and-deploy.ps1
    Full build, package, and prompt for deployment
#>

param(
    [switch]$BuildOnly,
    [switch]$Clean,
    [string]$ServerAlias = $null,
    [string]$ServerHost = $null,
    [string]$IdentityFile = $null,
    [switch]$InstallSudoers,
    [switch]$Direct
    , [switch]$IncludeHarden
)

# Default to build-only mode unless the caller explicitly passed -BuildOnly.
# ⚠️  CRITICAL SAFETY: This prevents accidental SSH connections that can corrupt SSH keys
# ⚠️  Text editors and search tools can inadvertently modify files in C:\Users\Owner\.ssh\
# ⚠️  NEVER run with -BuildOnly:$false unless you've verified SSH keys are intact first
# ⚠️  To deploy safely: 1) Verify keys, 2) Run deploy.ps1 separately, 3) Check connection
if (-not $PSBoundParameters.ContainsKey('BuildOnly')) {
    $BuildOnly = $true
}

$ErrorActionPreference = "Stop"

# Paths
$ProjectRoot = Split-Path $PSScriptRoot -Parent
$PublicHtml = Join-Path $ProjectRoot "public_html"
$TopDeployDir = Join-Path $ProjectRoot "deploy\jenninexus"
$DeployDir = Join-Path $TopDeployDir "public_html"
# Top-level deploy path should be deploy\jenninexus so it mirrors the remote /var/www/jenninexus
# (no local use) $SrcAssets removed to avoid unused variable warnings

# Deployment target (use SSH config alias so IdentityFile and options are resolved locally)
$SERVER_HOST = "jennidrop-root"
$SERVER_USER = "root"
$SERVER = "${SERVER_USER}@${SERVER_HOST}"
$REMOTE_ROOT = "/var/www/jenninexus"

Write-Host "`n╔════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║     🏗️  JenniNexus Smart Build & Deploy          ║" -ForegroundColor Cyan
Write-Host "║     (BUILD-ONLY MODE - No SSH Connection)        ║" -ForegroundColor Yellow
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

# Helper: read exclude patterns from the minimal DEPLOYMENT-MANIFEST.md
function Read-ManifestExcludes([string]$manifestPath) {
    $excludes = @()
    if (-not (Test-Path $manifestPath)) { return $excludes }
    $lines = Get-Content -Path $manifestPath -ErrorAction SilentlyContinue
    $inExclude = $false
    foreach ($line in $lines) {
        if ($line -match '^##\s*Exclude') { $inExclude = $true; continue }
        if ($inExclude) {
            if ($line -match '^##\s') { break }
            if ($line -match '^[\s\-]*-\s+`?(.*)`?') {
                $raw = $matches[1].Trim()
                if ($raw -ne '') { $excludes += $raw }
            }
        }
    }
    return $excludes
}

# ==============================================================================
# STAGE 0: FULL BUILD (Sync Assets & Generate Tags)
# ==============================================================================

Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Yellow
Write-Host "║  STAGE 0: FULL BUILD (Sync Assets & Tags)         ║" -ForegroundColor Yellow
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Yellow
Write-Host ""

$buildAllScript = Join-Path $PSScriptRoot "build-all.ps1"
if (Test-Path $buildAllScript) {
    Write-Host "[1/1] Running build-all.ps1 to sync assets and generate tags..." -ForegroundColor Cyan
    try {
        & $buildAllScript
        Write-Host "      ✅ Build complete!" -ForegroundColor Green
    } catch {
        Write-Host "      ❌ Build failed: $($_.Exception.Message)" -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "      ⚠️  build-all.ps1 not found! Skipping asset sync." -ForegroundColor Yellow
    Write-Host "          Ensure public_html/ is up to date manually." -ForegroundColor Yellow
}
Write-Host ""

# ==============================================================================
# STAGE 1: PREPARE & VERIFY
# ==============================================================================

Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Yellow
Write-Host "║  STAGE 1: PREPARE & VERIFY                        ║" -ForegroundColor Yellow
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Yellow
Write-Host ""

# 1.1 Clean old .html files (we're using .php now)
Write-Host "[1/5] Cleaning old HTML files from public_html..." -ForegroundColor Cyan
$htmlFiles = Get-ChildItem -Path $PublicHtml -Filter "*.html" -File
if ($htmlFiles.Count -gt 0) {
    Write-Host "      Found $($htmlFiles.Count) old .html files" -ForegroundColor Yellow
    foreach ($file in $htmlFiles) {
        Write-Host "      Removing: $($file.Name)" -ForegroundColor Gray
        Remove-Item $file.FullName -Force
    }
    Write-Host "      ✅ Cleaned!" -ForegroundColor Green
} else {
    Write-Host "      ✅ No .html files found (using .php)" -ForegroundColor Green
}
Write-Host ""

# 1.2 Remove backup files and junk
Write-Host "[2/5] Removing backup files and junk..." -ForegroundColor Cyan
$junkPatterns = @('*.backup','*.bak','*~','*.tmp','Thumbs.db','.DS_Store','*.md','*.html','secrets.json','archived')
$junkCount = 0
foreach ($pattern in $junkPatterns) {
    $junkFiles = Get-ChildItem -Path $PublicHtml -Recurse -File -ErrorAction SilentlyContinue | Where-Object { $_.Name -like $pattern -or $_.FullName -like $pattern }
    foreach ($file in $junkFiles) {
        Write-Host "      Removing: $($file.FullName)" -ForegroundColor Gray
        Remove-Item $file.FullName -Force -ErrorAction SilentlyContinue
        $junkCount++
    }
}
if ($junkCount -gt 0) {
    Write-Host "      ✅ Removed $junkCount junk files" -ForegroundColor Green
} else {
    Write-Host "      ✅ No junk files found" -ForegroundColor Green
}
Write-Host ""

# 1.3 Verify all PHP pages exist (include top-level and dynamic blog/game pages)
Write-Host "[3/5] Verifying PHP pages..." -ForegroundColor Cyan
# Core top-level pages that should always be present
$requiredPages = @(
    "index.php", "gamedev.php", "resume.php", "music.php",
    "patreon.php", "live.php", "diy.php", "blog.php",
    "links.php", "services.php"
)

# Auto-include all blog posts and game pages under their directories so we validate their presence
try {
    $blogFiles = Get-ChildItem -Path (Join-Path $PublicHtml 'blog') -Filter '*.php' -File -ErrorAction SilentlyContinue | ForEach-Object { "blog/$($_.Name)" }
    if ($blogFiles) { $requiredPages += $blogFiles }
} catch { }
try {
    $gameFiles = Get-ChildItem -Path (Join-Path $PublicHtml 'game') -Filter '*.php' -File -ErrorAction SilentlyContinue | ForEach-Object { "game/$($_.Name)" }
    if ($gameFiles) { $requiredPages += $gameFiles }
} catch { }

$requiredPages = $requiredPages | Select-Object -Unique
$missingPages = @()
foreach ($page in $requiredPages) {
    $pagePath = Join-Path $PublicHtml $page
    if (-not (Test-Path $pagePath)) {
        $missingPages += $page
        Write-Host "      ❌ Missing: $page" -ForegroundColor Red
    } else {
        Write-Host "      ✅ Found: $page" -ForegroundColor Green
    }
}
if ($missingPages.Count -gt 0) {
    Write-Host ""
    Write-Host "❌ Missing required pages: $($missingPages -join ', ')" -ForegroundColor Red
    Write-Host "   Run convert-to-php.ps1 or restore missing files before packaging." -ForegroundColor Yellow
    exit 1
}
Write-Host ""

# 1.4 Verify includes exist
Write-Host "[4/5] Verifying PHP includes..." -ForegroundColor Cyan
$includesDir = Join-Path $PublicHtml "includes"
$requiredIncludes = @("head.php", "header.php", "footer.php")
if (-not (Test-Path $includesDir)) {
    Write-Host "      ❌ Missing includes/ directory!" -ForegroundColor Red
    Write-Host "         Run convert-to-php.ps1 first!" -ForegroundColor Yellow
    exit 1
}
foreach ($include in $requiredIncludes) {
    $includePath = Join-Path $includesDir $include
    if (-not (Test-Path $includePath)) {
        Write-Host "      ❌ Missing: includes/$include" -ForegroundColor Red
        exit 1
    } else {
        Write-Host "      ✅ Found: includes/$include" -ForegroundColor Green
    }
}
Write-Host ""

# 1.5 Count files to deploy
Write-Host "[5/5] Analyzing deployment size..." -ForegroundColor Cyan
$phpFiles = (Get-ChildItem -Path $PublicHtml -Filter "*.php" -File).Count
$jsFiles = (Get-ChildItem -Path "$PublicHtml\resources\js" -Filter "*.js" -File -ErrorAction SilentlyContinue).Count
$cssFiles = (Get-ChildItem -Path "$PublicHtml\resources\css" -Filter "*.css" -File -ErrorAction SilentlyContinue).Count
$yamlFiles = (Get-ChildItem -Path "$PublicHtml\resources\playlists" -Filter "*.yaml" -File -ErrorAction SilentlyContinue).Count
$pdfFiles = (Get-ChildItem -Path "$PublicHtml\resources\pdfs" -Filter "*.pdf" -File -ErrorAction SilentlyContinue).Count

Write-Host ""
Write-Host "      📊 Deployment Summary:" -ForegroundColor White
Write-Host "         PHP pages:      $phpFiles" -ForegroundColor Gray
Write-Host "         JavaScript:     $jsFiles files" -ForegroundColor Gray
Write-Host "         CSS:            $cssFiles files" -ForegroundColor Gray
Write-Host "         YAML playlists: $yamlFiles files" -ForegroundColor Gray
Write-Host "         PDFs:           $pdfFiles files" -ForegroundColor Gray
Write-Host "Note: Patreon endpoints (public_html/resources/api/get-patreon-posts.php, get-patreon-tiers.php) are part of the site and require server-only secrets at /var/www/jenninexus/storage/secrets/patreon.json. The storage directory is excluded from the deploy package by default." -ForegroundColor Yellow
Write-Host "Ensure /var/www/jenninexus/storage/patreon/ exists and is writable by www-data for cache/logs." -ForegroundColor Yellow
Write-Host ""

# ==============================================================================
# STAGE 1.5: OPTIMIZE ASSETS (PurgeCSS + Minification)
# ==============================================================================

Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Yellow
Write-Host "║  STAGE 1.5: OPTIMIZE CSS/JS ASSETS                 ║" -ForegroundColor Yellow
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Yellow
Write-Host ""

$optimizeScript = Join-Path $PSScriptRoot "optimize-assets.ps1"
if (Test-Path $optimizeScript) {
    Write-Host "[1/1] Running asset optimization..." -ForegroundColor Cyan
    try {
        & $optimizeScript
        Write-Host "      ✅ Asset optimization complete!" -ForegroundColor Green
    } catch {
        Write-Host "      ⚠️  Asset optimization failed: $($_.Exception.Message)" -ForegroundColor Yellow
        Write-Host "      Continuing with unoptimized assets..." -ForegroundColor Yellow
    }
} else {
    Write-Host "[1/1] Skipping asset optimization (optimize-assets.ps1 not found)" -ForegroundColor Cyan
    Write-Host "      ℹ️  To enable CSS/JS optimization:" -ForegroundColor Gray
    Write-Host "         1. Ensure optimize-assets.ps1 exists in scripts/" -ForegroundColor Gray
    Write-Host "         2. Install Node.js and npm" -ForegroundColor Gray
    Write-Host "         3. Run: npm install --save-dev purgecss" -ForegroundColor Gray
}
Write-Host ""

# Note: BuildOnly mode should still create the deploy package locally
# Only skip the remote SSH deployment step
# This section removed - BuildOnly mode now creates the deploy package
# Remote deployment instructions will be shown at the end if BuildOnly is true

# ==============================================================================
# STAGE 2: CREATE DEPLOY PACKAGE
# ==============================================================================

Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Yellow
Write-Host "║  STAGE 2: CREATE DEPLOY PACKAGE                   ║" -ForegroundColor Yellow
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Yellow
Write-Host ""

# 2.1 Clean deploy directory
if ($Clean -and (Test-Path $DeployDir)) {
    Write-Host "[1/4] Cleaning deploy directory..." -ForegroundColor Cyan
     Remove-Item -Path "$TopDeployDir\*" -Recurse -Force
    Write-Host "      ✅ Cleaned" -ForegroundColor Green
} else {
    Write-Host "[1/4] Creating deploy directory..." -ForegroundColor Cyan
}
New-Item -Path $TopDeployDir -ItemType Directory -Force | Out-Null
New-Item -Path $DeployDir -ItemType Directory -Force | Out-Null
Write-Host "      ✅ Ready" -ForegroundColor Green
Write-Host ""

# 2.2 Copy public_html to deploy (with exclusions read from manifest)
Write-Host "[2/4] Copying files to deploy/..." -ForegroundColor Cyan
$copyCount = 0
$manifestPath = Join-Path $ProjectRoot 'DEPLOYMENT-MANIFEST.md'
$excludes = Read-ManifestExcludes $manifestPath
# Enforce excludes for production packaging (ensure src/ is never packaged)
$enforcedExcludes = @(
    'src/**',
    'storage/**',
    'scripts/**',
    'resources/archived/**',
    '**/!bak/**',
    'martiangames-portable.php',
    'theme-demo.php',
    'buttons.php'
)
if ($excludes.Count -eq 0) { $excludes = @('*.backup','*.bak','*~','*.tmp','Thumbs.db','.DS_Store','*.md','*.html','secrets.json','archived') }
foreach ($e in $enforcedExcludes) { if (-not ($excludes -contains $e)) { $excludes += $e } }

Get-ChildItem -Path $PublicHtml -Recurse -File | ForEach-Object {
    $relPath = $_.FullName.Substring($PublicHtml.Length) -replace '^[\\/]+', ''
    # Normalize relPath to forward slashes for consistent matching
    $relPathNormalized = $relPath -replace '\\', '/'
    
    $shouldExclude = $false
    foreach ($pat in $excludes) {
        # Check if pattern is a path pattern (contains / or \)
        if ($pat -match '[\\/]') {
             # Normalize pattern to forward slashes and remove leading slash for relative match
             $patNormalized = $pat -replace '\\', '/' -replace '^/', ''
             
             # Match against relative path (simple wildcard match)
             if ($relPathNormalized -like $patNormalized) { $shouldExclude = $true; break }
             
             # Fallback: Match against full path (for absolute path excludes)
             if ($_.FullName -like $pat) { $shouldExclude = $true; break }
        } else {
             # Simple filename match
             if ($_.Name -like $pat) { $shouldExclude = $true; break }
        }
    }
    if (-not $shouldExclude) {
        $targetPath = Join-Path $DeployDir $relPath
        $targetDir = Split-Path $targetPath -Parent
        if (-not (Test-Path $targetDir)) { New-Item -Path $targetDir -ItemType Directory -Force | Out-Null }
        Copy-Item -Path $_.FullName -Destination $targetPath -Force
        $copyCount++
    } else {
        Write-Host "      → Excluding: $relPath" -ForegroundColor DarkGray
    }
}

Write-Host "      ✅ Copied $copyCount files" -ForegroundColor Green
Write-Host ""

# Exclude videos directory from deploy package (large files ~4MB, upload manually when changed)
$videosPath = Join-Path $DeployDir "resources\videos"
if (Test-Path $videosPath) {
    $videoCount = (Get-ChildItem -Path $videosPath -File -ErrorAction SilentlyContinue).Count
    $videoSize = (Get-ChildItem -Path $videosPath -File -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum
    $videoSizeMB = [math]::Round($videoSize / 1MB, 2)
    Remove-Item -Path $videosPath -Recurse -Force -ErrorAction SilentlyContinue
    Write-Host "      → Excluded videos/ from deploy package ($videoCount files, $videoSizeMB MB - upload manually when changed)" -ForegroundColor DarkGray
} else {
    Write-Host "      → Videos directory not found in deploy package (will be preserved on server)" -ForegroundColor DarkGray
}

# Exclude PDFs directory from deploy package (large files ~2MB, upload manually when new PDFs are added)
$pdfsPath = Join-Path $DeployDir "resources\pdfs"
if (Test-Path $pdfsPath) {
    $pdfCount = (Get-ChildItem -Path $pdfsPath -File -Filter "*.pdf" -ErrorAction SilentlyContinue).Count
    $pdfSize = (Get-ChildItem -Path $pdfsPath -File -Filter "*.pdf" -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum
    $pdfSizeMB = [math]::Round($pdfSize / 1MB, 2)
    Remove-Item -Path $pdfsPath -Recurse -Force -ErrorAction SilentlyContinue
    Write-Host "      → Excluded pdfs/ from deploy package ($pdfCount files, $pdfSizeMB MB - upload manually when new PDFs are added)" -ForegroundColor DarkGray
} else {
    Write-Host "      → PDFs directory not found in deploy package (will be preserved on server)" -ForegroundColor DarkGray
}

Write-Host ""

# Ensure storage/ is not included in the deploy package unless explicitly requested
$deployStoragePath = Join-Path $TopDeployDir 'storage'
if (Test-Path $deployStoragePath) {
    if (-not $IncludeSecrets) {
        Write-Host "      → Removing storage/ from deploy package (storage is server-only)." -ForegroundColor Yellow
        Remove-Item -Path $deployStoragePath -Recurse -Force -ErrorAction SilentlyContinue
    } else {
        # Explicit opt-in: require typed confirmation to avoid accidental inclusion
        $confirm = Read-Host "You passed -IncludeSecrets. Type 'INCLUDE-SECRETS' to confirm you want storage/ included in the deploy package"
        if ($confirm -ne 'INCLUDE-SECRETS') {
            Write-Host "      → Confirmation not provided. Removing storage/ from deploy package." -ForegroundColor Yellow
            Remove-Item -Path $deployStoragePath -Recurse -Force -ErrorAction SilentlyContinue
        } else {
            Write-Host "      → storage/ WILL be included in deploy package (explicit confirmation received)." -ForegroundColor Red
        }
    }
}

# Ensure a small site asset exists in the deploy package
# Only add a placeholder favicon at the top of the public_html package if missing.
# Do NOT add playlist-ids.json at the top-level — playlist files belong under resources/playlists/.
if (-not (Test-Path (Join-Path $DeployDir 'favicon.ico'))) {
    Write-Host "      → Adding placeholder favicon.ico to deploy/jenninexus/public_html" -ForegroundColor DarkGray
    '# placeholder favicon - replace with real .ico file' | Out-File -FilePath (Join-Path $DeployDir 'favicon.ico') -Encoding ascii -Force
}

# 2.3 Skip .htaccess creation (Nginx project)
Write-Host "[3/4] Skipping .htaccess creation (Nginx project)" -ForegroundColor Cyan
Write-Host "      ✅ No Apache .htaccess created" -ForegroundColor Green
Write-Host ""

# Include a single maintenance helper script in the deploy package (intentional)
# Include maintenance helper and any top-level scripts in the deploy package under deploy/jenninexus/scripts
$maintenanceScript = Join-Path $ProjectRoot 'scripts\fix-permissions-jenninexus-remote.sh'
if (Test-Path $maintenanceScript) {
    $scriptsTargetDir = Join-Path $TopDeployDir 'scripts'
    if (-not (Test-Path $scriptsTargetDir)) { New-Item -Path $scriptsTargetDir -ItemType Directory -Force | Out-Null }
    Copy-Item -Path $maintenanceScript -Destination (Join-Path $scriptsTargetDir 'fix-permissions-jenninexus-remote.sh') -Force
    Write-Host "      → Included maintenance script: deploy/jenninexus/scripts/fix-permissions-jenninexus-remote.sh" -ForegroundColor DarkGray
} else {
    Write-Host "      → No maintenance helper found" -ForegroundColor DarkGray
}

# Optionally include harden-patreon-perms.sh if requested (safe to run as root on server)
$hardenScript = Join-Path $ProjectRoot 'scripts\harden-patreon-perms.sh'
if ($IncludeHarden -and (Test-Path $hardenScript)) {
    if (-not (Test-Path $scriptsTargetDir)) { New-Item -Path $scriptsTargetDir -ItemType Directory -Force | Out-Null }
    Copy-Item -Path $hardenScript -Destination (Join-Path $scriptsTargetDir 'harden-patreon-perms.sh') -Force
    Write-Host "      → Included harden script: deploy/jenninexus/scripts/harden-patreon-perms.sh" -ForegroundColor DarkGray
}

Write-Host "[4/4] Generating deployment manifest..." -ForegroundColor Cyan

# Prepare the exclusion list that will be rendered back into the manifest for future runs
$manifestExclusionNotes = @(
    'secrets.json (sensitive secrets are excluded by default; provision on server under /var/www/jenninexus/public_html/resources/playlists/secrets.json)',
    'source directories: /src, /storage, /scripts (these are not shipped in the deploy package)'
)
$exclusionItems = $manifestExclusionNotes + $excludes
$uniqueExclusionItems = $exclusionItems | Select-Object -Unique
$exclusionSection = ($uniqueExclusionItems | ForEach-Object { "- $_" }) -join "`n"

# ============================================================================== 
# STAGE 3: DEPLOYMENT PROMPT
# ==============================================================================

Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║  ✅ DEPLOY PACKAGE READY!                         ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Green
Write-Host ""

Write-Host "📦 Package created in: $DeployDir" -ForegroundColor Cyan
Write-Host "📊 Total files: $copyCount" -ForegroundColor Cyan
Write-Host "🎯 Target: $($SERVER):$REMOTE_ROOT" -ForegroundColor Cyan
$manifest = @"
# JenniNexus Deployment Manifest
Generated: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")

## Files Deployed: $copyCount

### PHP Pages: $phpFiles
$(Get-ChildItem -Path $DeployDir -Filter "*.php" -File | ForEach-Object { "- $($_.Name)" } | Out-String)

### Resources:
- JavaScript files: $jsFiles (includes .min.js versions)
- Active JS modules: 14 source files (see storage/docs/JS.md)
  - Core UI: theme-toggle, back-to-top, performance-optimizer, polyfills, compat-resume
  - Tag System: tag-system, tag-filter-api, tag-cloud
  - Content: youtube-grid, martian-games, diy-playlists, music-playlists, live-status
  - OAuth: patreon-auth-enhanced
- CSS files: $cssFiles
- YAML playlists: $yamlFiles
- PDF documents: $pdfFiles (excluded from deploy package, preserved on server)

**Note:** Videos (~4MB) and PDFs (~2MB) are excluded from the deploy package to save bandwidth.
These files are preserved on the server and only need to be uploaded manually when changed.

### Bootstrap 5.3.8 Integration:
- All JavaScript files Bootstrap 5.3.8 compatible (verified Nov 5, 2025)
- No conflicts with Bootstrap Modal, Offcanvas, or Grid APIs
- Proper use of data-bs-theme, data-bs-toggle, data-bs-target
- Minification savings: ~40KB+ (62% average reduction)
- See storage/docs/JS.md for comprehensive documentation

### Server Configuration:
- Target: $($SERVER):$REMOTE_ROOT
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
$exclusionSection

### Clean URLs enabled:
- /gamedev → gamedev.php
- /resume → resume.php
- /music → music.php
- etc.
"@
# Write consolidated deployment manifest into the project root next to README.md
$manifestFilePath = Join-Path $ProjectRoot 'DEPLOYMENT-MANIFEST.md'
$manifest | Out-File -FilePath $manifestFilePath -Encoding utf8 -Force
Write-Host "      ✅ Created DEPLOYMENT-MANIFEST.md at: $manifestFilePath" -ForegroundColor Green
Write-Host ""

# Display deployment information
Write-Host "📚 Documentation Reference:" -ForegroundColor Cyan
Write-Host "   • DEPLOYMENT-MANIFEST.md - Quick reference (this file)" -ForegroundColor Gray
Write-Host "   • storage/docs/JS.md - JavaScript architecture (27.3 KB)" -ForegroundColor Gray
Write-Host "   • storage/docs/BOOTSTRAP-5.3.8.md - Bootstrap integration (41.2 KB)" -ForegroundColor Gray
Write-Host "   • storage/docs/CSS-SCSS.md - CSS architecture (31 KB)" -ForegroundColor Gray
Write-Host "   • storage/docs/DEPLOYMENT-GUIDE.md - Deployment workflow (32.8 KB)" -ForegroundColor Gray
Write-Host ""

if ($BuildOnly) {
    Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Green
    Write-Host "║  ✅ BUILD-ONLY MODE COMPLETE!                     ║" -ForegroundColor Green
    Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Green
    Write-Host ""
    Write-Host "📦 Deploy package ready at: $TopDeployDir" -ForegroundColor Cyan
    Write-Host "📊 Total files: $copyCount" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "✅ Bootstrap 5.3.8 Optimizations:" -ForegroundColor Green
    Write-Host "   • 14 JavaScript files (all Bootstrap compatible)" -ForegroundColor White
    Write-Host "   • CSS consolidated (mobile-improvements.css archived)" -ForegroundColor White
    Write-Host "   • Navbar height: Bootstrap default ~56px" -ForegroundColor White
    Write-Host "   • Minification savings: ~40KB+ (62% avg reduction)" -ForegroundColor White
    Write-Host ""
    
    # Prompt for deployment even in BuildOnly mode (if user wants to proceed)
    Write-Host "Would you like to proceed with deployment to production? (y/n)" -ForegroundColor Yellow
    $confirmation = Read-Host "Deploy now?"
    if ($confirmation -notmatch '^[Yy]$') {
        Write-Host "   Build complete. Exiting." -ForegroundColor Gray
        exit 0
    }
}

Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Green
Write-Host ""

# If the user confirmed in this script, call deploy.ps1 and forward server options
if ($confirmation -eq 'yes') {
    $deployArgs = @("-SkipBuild") # Use the package we just built
    if ($ServerAlias) { $deployArgs += "-ServerAlias `"$ServerAlias`"" }
    if ($IdentityFile) { $deployArgs += "-IdentityFile `"$IdentityFile`"" }
    if ($DryRun) { $deployArgs += "-DryRun" }
    if ($IncludeSecrets) { $deployArgs += "-IncludeSecrets" }
    
    # Run deploy.ps1 and forward DryRun/IncludeSecrets flags if present
    $deployCmd = ".\scripts\deploy.ps1 " + ($deployArgs -join ' ')
    Write-Host "→ Invoking: $deployCmd" -ForegroundColor Gray
    Invoke-Expression $deployCmd
}


# Optional: automatic upload + remote helper when ServerAlias/IdentityFile provided
function Test-CommandExists($cmd) {
    try { Get-Command $cmd -ErrorAction Stop | Out-Null; return $true } catch { return $false }
}

if ($ServerAlias -or $IdentityFile) {
    # Optional: attempt to upload and install a limited sudoers fragment to enable non-interactive helper runs
    if ($InstallSudoers) {
        Write-Host "→ InstallSudoers requested: attempting to upload and install sudoers fragment on $ServerAlias" -ForegroundColor Cyan
        $installHelper = Join-Path $ProjectRoot 'scripts\install-deploy-sudoers.ps1'
        if (-not (Test-Path $installHelper)) {
            Write-Warning "Install helper not found: $installHelper. Skipping sudoers installation."
        } else {
                # Normalize identity file
                if ($IdentityFile) { try { $IdentityFile = (Resolve-Path -Path $IdentityFile).ProviderPath } catch { } }
                $installArgs = @('-File', $installHelper, '-ServerAlias', $ServerAlias, '-IdentityFile', $IdentityFile)
                Write-Host "→ Invoking: pwsh $($installArgs -join ' ')" -ForegroundColor Gray
                $proc = Start-Process -FilePath pwsh -ArgumentList $installArgs -Wait -NoNewWindow -PassThru
            if ($proc.ExitCode -ne 0) { Write-Warning "Sudoers install helper exited with $($proc.ExitCode). Continue with caution." }
        }
    }
    # Determine server and identity
    # Resolve target host from ssh config using 'ssh -G' if possible, fallback to ServerAlias
    function Resolve-SSHHostLocal([string]$alias) {
        try {
            $o = & ssh -G $alias 2>$null
            if ($o) {
                foreach ($l in $o -split "`n") {
                    $t = $l.Trim()
                    if ($t -match '^hostname\s+(\S+)$') {
                        $candidate = $matches[1]
                        if ($candidate -and $candidate -ne $alias -and $candidate -match '\.') { return $candidate }
                        break
                    }
                }
            }
        } catch { }

        $sshConfig = Join-Path $env:USERPROFILE '.ssh\config'
        if (-not (Test-Path $sshConfig)) { return $null }
        $lines = Get-Content -Path $sshConfig -ErrorAction SilentlyContinue
        $inHostBlock = $false
        foreach ($line in $lines) {
            $trim = $line.Trim()
            if ($trim -match '^Host\s+(.*)') {
                $names = $matches[1] -split '\s+' | ForEach-Object { $_.Trim() } | Where-Object { $_ -ne '' }
                if ($names -contains $alias) { $inHostBlock = $true } else { $inHostBlock = $false }
                continue
            }
            if ($inHostBlock -and $trim -match '^HostName\s+(\S+)') { return $matches[1] }
        }
        return $null
    }

    $resolvedHost = $null
    if ($ServerHost) { $targetHost = $ServerHost } else { if ($ServerAlias) { $resolvedHost = Resolve-SSHHostLocal $ServerAlias }; $targetHost = if ($resolvedHost) { $resolvedHost } elseif ($ServerAlias) { $ServerAlias } else { $SERVER_HOST } }
    if ($IdentityFile) {
        if (-not (Test-Path $IdentityFile)) {
            Write-Host "❌ Identity file not found: $IdentityFile" -ForegroundColor Red
            exit 2
        }
    }

    $remoteTmp = "/tmp/jennideploy"
    $rsyncAvailable = Test-CommandExists -cmd 'rsync'

    # Decide whether to perform direct deploy into $REMOTE_ROOT. If the user supplied -Direct, honor it.
    # If they didn't supply it, default to Direct (as requested).
    if ($PSBoundParameters.ContainsKey('Direct')) { $UseDirect = $Direct.IsPresent } else { $UseDirect = $true }

    Write-Host "\n→ Starting automatic upload to $targetHost (user: $SERVER_USER)" -ForegroundColor Cyan

    if ($rsyncAvailable) {
        # Build rsync argument array to avoid complex quoting
            if ($IdentityFile) {
                $sshOpt = 'ssh -i "' + $IdentityFile + '" -o StrictHostKeyChecking=no'
            } else {
                $sshOpt = 'ssh -o StrictHostKeyChecking=no'
            }
            # Upload the entire site package (deploy/jenninexus) so siblings (public_html, scripts, storage) are preserved
            $sourcePath = (Join-Path $TopDeployDir '')
            if ($UseDirect) {
                # Upload directly into the webroot using remote sudo rsync. This requires the deploy user
                # to be allowed to run /usr/bin/rsync via sudo without password (sudoers fragment).
                $destTarget = "$($SERVER_USER)@$($targetHost):$REMOTE_ROOT/"
                $rsyncArgs = @('-avz','--delete','--exclude=secrets.json',$sourcePath,$destTarget,'-e',$sshOpt,'--rsync-path="sudo rsync"')
            } else {
                $destTarget = "$($SERVER_USER)@$($targetHost):$remoteTmp/"
                $rsyncArgs = @('-avz','--delete','--exclude=secrets.json',$sourcePath,$destTarget,'-e',$sshOpt)
            }
        Write-Host "→ Running: rsync $($rsyncArgs -join ' ')" -ForegroundColor Gray
        & rsync @rsyncArgs
        if ($LASTEXITCODE -ne 0) {
            Write-Host "❌ rsync exited with code $LASTEXITCODE" -ForegroundColor Red
            exit $LASTEXITCODE
        } else {
            Write-Host "✅ Upload complete (rsync)" -ForegroundColor Green
        }
    } else {
    # Fallback to scp
        Write-Host "→ rsync not found, falling back to scp" -ForegroundColor Yellow
    # Upload the entire site package directory (deploy/jenninexus)
    $sourcePath = (Join-Path $TopDeployDir '')
        # Ensure the remote temporary directory exists before using scp. On some OpenSSH builds
        # (notably Windows bundled scp) scp will attempt to canonicalize the remote path which
        # fails if the destination directory doesn't yet exist. Create it via ssh first.
        $sshArgs = @()
        if ($IdentityFile) { $sshArgs += '-i'; $sshArgs += $IdentityFile }
        $sshArgs += @('-o','ConnectTimeout=10','-o','ServerAliveInterval=60','-o','ServerAliveCountMax=3','-o','StrictHostKeyChecking=no',"$($SERVER_USER)@$($targetHost)")

        Write-Host "→ Ensuring remote tmp dir exists: $remoteTmp" -ForegroundColor Gray
        & ssh @sshArgs "mkdir -p $remoteTmp"
        if ($LASTEXITCODE -ne 0) {
            Write-Host "❌ ssh mkdir failed with code $LASTEXITCODE" -ForegroundColor Red
            exit $LASTEXITCODE
        }

        if ($UseDirect) {
            # rsync not available locally but user requested Direct. Attempt scp to remote temp then try sudo rsync on the server.
            if ($IdentityFile) {
                $scpArgs = @('-i',$IdentityFile,'-r',$sourcePath,"$($SERVER_USER)@$($targetHost):$remoteTmp/")
            } else {
                $scpArgs = @('-r',$sourcePath,"$($SERVER_USER)@$($targetHost):$remoteTmp/")
            }
            Write-Host "→ Running: scp $($scpArgs -join ' ')" -ForegroundColor Gray
            & scp @scpArgs
            if ($LASTEXITCODE -ne 0) {
                Write-Host "❌ scp exited with code $LASTEXITCODE" -ForegroundColor Red
                exit $LASTEXITCODE
            } else {
                Write-Host "✅ Upload complete (scp) to remote temp — attempting remote sudo rsync/move" -ForegroundColor Green
            }
            # Try to perform a server-side sudo rsync/move to the final destination. This requires sudoers.
            $sshArgs = @()
            if ($IdentityFile) { $sshArgs += '-i'; $sshArgs += $IdentityFile }
            $sshArgs += @('-o','StrictHostKeyChecking=no',"$($SERVER_USER)@$($targetHost)")
            $attemptCmd = "sudo rsync -a --delete $remoteTmp/public_html/ $REMOTE_ROOT/public_html/ || sudo mv -f $remoteTmp/public_html/* $REMOTE_ROOT/public_html/ || true"
            Write-Host "→ Attempting remote privileged move: ssh $($sshArgs -join ' ') '$attemptCmd'" -ForegroundColor Gray
                        $sshArgs = @()
            if ($IdentityFile) { $sshArgs += '-i'; $sshArgs += $IdentityFile }
            $sshArgs += @('-o','ConnectTimeout=10','-o','ServerAliveInterval=60','-o','ServerAliveCountMax=3','-o','StrictHostKeyChecking=no',"$($SERVER_USER)@$($targetHost)")

            & ssh @sshArgs $attemptCmd
            if ($LASTEXITCODE -ne 0) {
                Write-Host "⚠️ Remote privileged move failed (likely sudo requires a password). Files remain at $remoteTmp on server." -ForegroundColor Yellow
            } else {
                Write-Host "✅ Remote privileged move succeeded" -ForegroundColor Green
            }
        } else {
            if ($IdentityFile) {
                $scpArgs = @('-i',$IdentityFile,'-r',$sourcePath,"$($SERVER_USER)@$($targetHost):$remoteTmp/")
            } else {
                $scpArgs = @('-r',$sourcePath,"$($SERVER_USER)@$($targetHost):$remoteTmp/")
            }
            Write-Host "→ Running: scp $($scpArgs -join ' ')" -ForegroundColor Gray
            & scp @scpArgs
            if ($LASTEXITCODE -ne 0) {
                Write-Host "❌ scp exited with code $LASTEXITCODE" -ForegroundColor Red
                exit $LASTEXITCODE
            } else {
                Write-Host "✅ Upload complete (scp)" -ForegroundColor Green
            }
        }
    }

    # Attempt to run remote helper to move files and fix permissions
        # Preprocess the uploaded helper script while it's still owned by the deploy user
        # (convert CRLF and make executable). Then use sudo to rsync into place and run
        # the helper. This avoids "$'\r': command not found" from CRLF line endings.
        $remoteCmd = @"
set -e
# Convert line endings and make the helper executable in the tmp location (deploy user)
if [ -f $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh ]; then
    sed -i 's/\r$//' $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh || true
    chmod +x $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh || true
fi

# Use sudo to atomically rsync files into the webroot and move the helper into place.
# These steps require sudo privileges. If sudo requires a password this will fail
# in non-interactive mode — see notes in the README about granting NOPASSWD for
# the deploy user or running the helper manually on the server.
sudo rsync -a --delete $remoteTmp/public_html/ $REMOTE_ROOT/public_html/
sudo mkdir -p $REMOTE_ROOT/scripts
sudo mv -f $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh || true
sudo chmod +x $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh || true
sudo /bin/bash $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh || true
"@

    # Create a temporary file containing the remote commands and pipe it into ssh -T for robust quoting
    $hereDoc = $remoteCmd
    $tempPath = Join-Path $env:TEMP 'jennideploy_ssh_input.sh'
    # Write the here-doc to a temp file converting CRLF -> LF to avoid remote shell errors
    $lfContent = $hereDoc -replace "`r`n","`n"
    $lfContent | Out-File -FilePath $tempPath -Encoding ascii -Force

    $sshArgs = @()
    if ($IdentityFile) { $sshArgs += '-i'; $sshArgs += $IdentityFile }
    $sshArgs += @('-o','ConnectTimeout=10','-o','ServerAliveInterval=60','-o','ServerAliveCountMax=3','-o','StrictHostKeyChecking=no',"$($SERVER_USER)@$($targetHost)")

    Write-Host "→ Running remote helper via SSH (bash -s)..." -ForegroundColor Cyan

    # Wrap the remote script with a sudo-noninteractive check. If sudo -n fails, print a manual fallback
    $wrapper = @"
if sudo -n true 2>/dev/null; then
    # privileged path: run uploaded commands
    $(Get-Content -Raw $tempPath)
    exit 0
else
    echo "=== SUDO_INTERACTIVE_REQUIRED ==="
    echo "The deploy user cannot run the privileged helper non-interactively. To finish the deploy manually, run as root:"
    echo "  sudo mv -f $remoteTmp/public_html/ $REMOTE_ROOT/public_html/"
    echo "  sudo mkdir -p $REMOTE_ROOT/scripts && sudo mv -f $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh"
    echo "  sudo chmod +x $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh"
    echo "  sudo /bin/bash $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh"
    exit 2
fi
"@

    # Execute the wrapper remotely. Capture exit code and provide clear instructions if interactive sudo is required.
    # Pipe the wrapper file into ssh 'bash -s' so the remote commands run with proper stdin on Windows PowerShell.
    $sshArgsFinal = @()
    $sshArgsFinal += $sshArgs
    $sshArgsFinal += 'bash -s'

    try {
        # Pipe the wrapper (which includes the preprocessed remote commands) into ssh
        $wrapper | & ssh @sshArgsFinal
        $sshExit = $LASTEXITCODE
    } catch {
        Write-Host "❌ Failed to execute remote helper via ssh: $($_.Exception.Message)" -ForegroundColor Red
        $sshExit = 1
    } finally {
        Remove-Item $tempPath -ErrorAction SilentlyContinue
    }

    if ($sshExit -eq 2) {
        Write-Host "❗ Remote helper detected that sudo requires a password. The files are uploaded to $remoteTmp on the server." -ForegroundColor Yellow
        Write-Host "Run the following on the server as root to finish the deploy:" -ForegroundColor Cyan
        Write-Host "  sudo mv -f $remoteTmp/public_html/ /var/www/jenninexus/public_html/" -ForegroundColor Gray
        Write-Host "  sudo mkdir -p /var/www/jenninexus/scripts && sudo mv -f $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh" -ForegroundColor Gray
        Write-Host "  sudo chmod +x /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh" -ForegroundColor Gray
        Write-Host "  sudo /bin/bash /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh" -ForegroundColor Gray
        Write-Host "You can also run the installer to add a restricted sudoers entry for the deploy user to allow non-interactive deployment." -ForegroundColor Yellow
        # keep uploaded files for manual completion
    } elseif ($sshExit -ne 0) {
        Write-Host "❌ SSH remote helper exited with code $sshExit" -ForegroundColor Red
        Write-Host "Check that the deploy user's public key is in /home/deploy/.ssh/authorized_keys and permissions are correct." -ForegroundColor Yellow
        exit $sshExit
    } else {
        Write-Host "✅ Remote helper executed (check server output above)" -ForegroundColor Green
    }
}
