#!/usr/bin/env pwsh
Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$ScriptDir = $PSScriptRoot
$ProjectRoot = Split-Path -Parent $ScriptDir

Write-Host "Starting Build Pipeline..."

# Step 0: Generate Content Tags
if (Test-Path "$ScriptDir\generate-playlist-tags.ps1") {
    Write-Host "Running generate-playlist-tags.ps1..."
    & "$ScriptDir\generate-playlist-tags.ps1"
}
if (Test-Path "$ScriptDir\generate-blog-tags.ps1") {
    Write-Host "Running generate-blog-tags.ps1..."
    & "$ScriptDir\generate-blog-tags.ps1"
}

# Step 1: Build Assets
if (Test-Path "$ScriptDir\build.ps1") {
    Write-Host "Running build.ps1..."
    & "$ScriptDir\build.ps1" -Quiet
}

# Step 2: Optimize Assets
if (Test-Path "$ScriptDir\optimize-assets.ps1") {
    Write-Host "Running optimize-assets.ps1..."
    & "$ScriptDir\optimize-assets.ps1"
}

# Step 3: Verify Router
$routerPath = Join-Path $ProjectRoot "public_html\router.php"
if (Test-Path $routerPath) {
    $routerContent = Get-Content $routerPath -Raw
    if ($routerContent -match "preg_match.*game") {
        Write-Host "Router: /game/ route detected."
    }
    if ($routerContent -match "preg_match.*blog") {
        Write-Host "Router: /blog/ route detected."
    }
}

# Step 4: Verify Nginx
$nginxPath = Join-Path $ProjectRoot ".config\jenninexus-nginx.conf"
if (Test-Path $nginxPath) {
    $nginxContent = Get-Content $nginxPath -Raw
    if ($nginxContent -match 'location /game/') {
        Write-Host "Nginx: /game/ location detected."
    }
}

# Step 5: Check for duplicate nav
$gameDir = Join-Path $ProjectRoot "public_html\game"
$blogDir = Join-Path $ProjectRoot "public_html\blog"
$duplicateNav = @()

if (Test-Path $gameDir) {
    Get-ChildItem -Path $gameDir -Filter "*.php" | ForEach-Object {
        $content = Get-Content $_.FullName -Raw
        if ($content -match '<nav class="navbar') {
            $duplicateNav += "game/$($_.Name)"
        }
    }
}

if (Test-Path $blogDir) {
    Get-ChildItem -Path $blogDir -Filter "*.php" | ForEach-Object {
        $content = Get-Content $_.FullName -Raw
        if ($content -match '<nav class="navbar') {
            $duplicateNav += "blog/$($_.Name)"
        }
    }
}

if ($duplicateNav.Count -gt 0) {
    Write-Host "WARNING: Duplicate navigation found in:"
    $duplicateNav | ForEach-Object { Write-Host " - $_" }
}

Write-Host "Build Complete."
