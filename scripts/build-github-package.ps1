#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Builds a clean "GitHub-ready" package of the project in a separate directory.
    
.DESCRIPTION
    Creates a 'github-package' directory containing a clean copy of the project
    suitable for pushing to GitHub.
    
    - EXCLUDES all secrets (.env, secrets.json)
    - EXCLUDES build artifacts (deploy/, node_modules/, vendor/)
    - EXCLUDES user data (storage/patreon, storage/sessions)
    - INCLUDES source code, scripts, and documentation
    
    This allows you to inspect exactly what will be pushed to GitHub before
    running any git commands.

.EXAMPLE
    .\scripts\build-github-package.ps1
#>

$ErrorActionPreference = "Stop"

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Build GitHub Package" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

$ProjectRoot = Split-Path $PSScriptRoot -Parent
$GithubDir = Join-Path $ProjectRoot "github-package"

Write-Host "Source:      $ProjectRoot" -ForegroundColor Gray
Write-Host "Destination: $GithubDir" -ForegroundColor Gray
Write-Host ""

# 1. Clean/Create Destination
if (Test-Path $GithubDir) {
    Write-Host "Cleaning existing github-package directory..." -ForegroundColor Yellow
    Remove-Item $GithubDir -Recurse -Force
}
New-Item $GithubDir -ItemType Directory -Force | Out-Null

# 2. Copy Root Files
Write-Host "Copying root files..." -ForegroundColor Green
$rootExclusions = @('.env', 'secrets.json', 'deploy', 'node_modules', 'vendor', 'github-package', '.git', '.vscode', '.idea', 'storage', 'DEPLOYMENT-MANIFEST.md', '.config', 'archive', 'bak')
Get-ChildItem $ProjectRoot -File | Where-Object { 
    $_.Name -notin $rootExclusions -and $_.Name -notmatch '^\.' 
} | ForEach-Object {
    Copy-Item $_.FullName -Destination $GithubDir
    Write-Host "  + $($_.Name)" -ForegroundColor DarkGray
}

# Explicitly copy .gitignore if it exists
if (Test-Path "$ProjectRoot\.gitignore") {
    Copy-Item "$ProjectRoot\.gitignore" -Destination $GithubDir
    Write-Host "  + .gitignore" -ForegroundColor DarkGray
}

# Copy Nginx config as template
if (Test-Path "$ProjectRoot\.config\jenninexus.conf") {
    $configDest = Join-Path $GithubDir ".config"
    New-Item $configDest -ItemType Directory -Force | Out-Null
    Copy-Item "$ProjectRoot\.config\jenninexus.conf" -Destination (Join-Path $configDest "jenninexus.conf.example")
    Write-Host "  + .config/jenninexus.conf.example" -ForegroundColor Green
}

# 3. Copy Source Directories (Smart Copy)
function Smart-Copy {
    param($Source, $Dest, $ExcludePattern)
    
    Write-Host "Copying $Source -> $Dest ..." -ForegroundColor Green
    
    # Create dest dir
    if (-not (Test-Path $Dest)) { New-Item $Dest -ItemType Directory -Force | Out-Null }
    
    # Copy recursively but filter
    Get-ChildItem $Source -Recurse | ForEach-Object {
        $relPath = $_.FullName.Substring($Source.Length + 1)
        $targetPath = Join-Path $Dest $relPath
        
        # Check exclusions
        if ($relPath -match $ExcludePattern) {
            # Skip
            return
        }
        
        if ($_.PSIsContainer) {
            if (-not (Test-Path $targetPath)) {
                New-Item $targetPath -ItemType Directory -Force | Out-Null
            }
        } else {
            Copy-Item $_.FullName -Destination $targetPath -Force
        }
    }
}

# Copy src/
# Exclude secrets inside src, and archived/bak folders
$srcDest = Join-Path $GithubDir "src"
Copy-Item (Join-Path $ProjectRoot "src") -Destination $srcDest -Recurse
# Post-copy cleanup for src
if (Test-Path "$srcDest\env\.env") { Remove-Item "$srcDest\env\.env" -Force; Write-Host "  - Removed src/env/.env" -ForegroundColor Yellow }
if (Test-Path "$srcDest\env\secrets.json") { Remove-Item "$srcDest\env\secrets.json" -Force; Write-Host "  - Removed src/env/secrets.json" -ForegroundColor Yellow }

# Cleanup archived/bak in src
Get-ChildItem "$srcDest" -Recurse -Directory | Where-Object { $_.Name -match 'archived|archive|!bak' } | Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
Write-Host "  - Cleaned src (removed archived/bak folders)" -ForegroundColor Yellow

# Copy public_html/
# Exclude storage, archives, backups (but INCLUDE dev-only for demos)
$publicDest = Join-Path $GithubDir "public_html"
Copy-Item (Join-Path $ProjectRoot "public_html") -Destination $publicDest -Recurse
# Post-copy cleanup for public_html
Remove-Item "$publicDest\storage" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item "$publicDest\archive" -Recurse -Force -ErrorAction SilentlyContinue
# KEEP dev-only folder for GitHub (theme demos, component showcases)
Remove-Item "$publicDest\resources\archived" -Recurse -Force -ErrorAction SilentlyContinue

# Selective cleanup of resources/ (Minimal GitHub Package)
$resourcesDest = Join-Path $publicDest "resources"
$excludeResources = @('images', 'videos', 'media', 'pdfs', 'svgs')
foreach ($folder in $excludeResources) {
    $target = Join-Path $resourcesDest $folder
    if (Test-Path $target) {
        Remove-Item $target -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "  - Removed resources/$folder (excluded from GitHub)" -ForegroundColor Yellow
    }
}

Get-ChildItem "$publicDest" -Recurse -Directory | Where-Object { $_.Name -match 'archived|archive|!bak' } | Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
Get-ChildItem "$publicDest" -Recurse -Filter "*.bak" | Remove-Item -Force -ErrorAction SilentlyContinue
Write-Host "  - Cleaned public_html (removed storage, backups, and large assets; kept dev-only/)" -ForegroundColor Yellow

# Copy scripts/
$scriptsDest = Join-Path $GithubDir "scripts"
Copy-Item (Join-Path $ProjectRoot "scripts") -Destination $scriptsDest -Recurse
# Remove this script itself from the package? No, it's useful to have.
# Remove deploy artifacts if any exist in scripts (unlikely)

# Copy .github/
if (Test-Path "$ProjectRoot\.github") {
    Copy-Item "$ProjectRoot\.github" -Destination "$GithubDir\.github" -Recurse
    Write-Host "  + .github/" -ForegroundColor Green
}

# 4. Handle Storage (Docs Only)
Write-Host "Processing storage (Docs only)..." -ForegroundColor Green
$storageDest = Join-Path $GithubDir "storage"
$docsDest = Join-Path $storageDest "docs"
New-Item $docsDest -ItemType Directory -Force | Out-Null

# Allowed docs list
$allowedDocs = @(
    "ASSETS.md",
    "BOOTSTRAP-5.3.8.md",
    "CSS-SCSS.md",
    "DEPLOYMENT-GUIDE.md",
    "FONTAWESOME-SVGS.md",
    "JS.md",
    "LOCAL-DEV.md",
    "PAGE-CONSISTENCY.md",
    "PAGE-CONSISTENCY-AUDIT.md",
    "PATREON.md",
    "PLAYLIST-MAPPING.md",
    "QUICKSTART.md",
    "SYNAGEN.md",
    "VIDEO-GRID.md",
    "YOUTUBE.md",
    "TAG-SYSTEM.md",
    "ROUTING-SYSTEM.md",
    "THEME-SYSTEM.md",
    "BLOG-PAGES.md",
    "GAME-PAGES.md"
)

foreach ($doc in $allowedDocs) {
    $srcDoc = Join-Path "$ProjectRoot\storage\docs" $doc
    if (Test-Path $srcDoc) {
        Copy-Item $srcDoc -Destination $docsDest
        Write-Host "  + storage/docs/$doc" -ForegroundColor DarkGray
    }
}

# Copy DAILY-PLAN.md
if (Test-Path "$ProjectRoot\storage\DAILY-PLAN.md") {
    Copy-Item "$ProjectRoot\storage\DAILY-PLAN.md" -Destination $storageDest
    Write-Host "  + storage/DAILY-PLAN.md" -ForegroundColor DarkGray
}

# Create empty placeholders for structure
$placeholders = @("storage/logs", "storage/cache", "storage/sessions")
foreach ($p in $placeholders) {
    $pPath = Join-Path $GithubDir $p
    New-Item $pPath -ItemType Directory -Force | Out-Null
    New-Item (Join-Path $pPath ".gitkeep") -ItemType File -Force | Out-Null
}
Write-Host "  + Created placeholders with .gitkeep" -ForegroundColor DarkGray
$placeholders = @('logs', 'cache', 'sessions', 'secrets', 'patreon')
foreach ($p in $placeholders) {
    $pDir = Join-Path $storageDest $p
    New-Item $pDir -ItemType Directory -Force | Out-Null
    New-Item (Join-Path $pDir ".gitkeep") -ItemType File -Force | Out-Null
}
Write-Host "  + Created empty storage structure with .gitkeep" -ForegroundColor DarkGray

# 5. Create Example Secrets (SKIPPED per user request)
# Write-Host "Creating example secret files..." -ForegroundColor Green
# ... skipped ...


# 6. Final Verification
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Verification" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

$secretsFound = Get-ChildItem $GithubDir -Recurse -Include "secrets.json", ".env", "patreon.json"
if ($secretsFound) {
    Write-Host "❌ WARNING: Secrets found in package!" -ForegroundColor Red
    foreach ($s in $secretsFound) {
        Write-Host "   $($s.FullName)" -ForegroundColor Red
        Remove-Item $s.FullName -Force
        Write-Host "   -> Removed automatically." -ForegroundColor Yellow
    }
} else {
    Write-Host "✅ No secrets found." -ForegroundColor Green
}

Write-Host "`n📦 GitHub Package Ready!" -ForegroundColor Green
Write-Host "   Location: $GithubDir" -ForegroundColor White
Write-Host "   You can now initialize a git repo there or upload these files." -ForegroundColor White
