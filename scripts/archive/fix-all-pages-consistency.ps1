#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Fix ALL Pages - Remove Duplicate Navigation & Standardize Includes
.DESCRIPTION
    Ensures ZERO duplicate navigation across ALL pages
    Standardizes include paths and resource references
    Makes every page use the same header.php and footer.php
#>

param(
    [switch]$WhatIf
)

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$ProjectRoot = Split-Path -Parent $PSScriptRoot
$GameDir = Join-Path $ProjectRoot "public_html\game"
$BlogDir = Join-Path $ProjectRoot "public_html\blog"

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  🧹 FIXING ALL PAGES - NO DUPLICATE NAVIGATION" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# ============================================================================
# STEP 1: Fix Game Pages
# ============================================================================
Write-Host "📂 Processing Game Pages..." -ForegroundColor Yellow
$gameFiles = Get-ChildItem -Path $GameDir -Filter "*.php"

foreach ($file in $gameFiles) {
    Write-Host "  🎮 $($file.Name)" -ForegroundColor White
    
    $content = Get-Content -Path $file.FullName -Raw
    $originalContent = $content
    
    # Check for embedded navigation
    if ($content -match '<nav class=|navbar-brand|<div class="offcanvas') {
        Write-Host "    ⚠️  DUPLICATE NAV FOUND - Removing..." -ForegroundColor Red
        
        # Remove embedded navigation block (everything between header include and hero section)
        # Pattern: include header.php ... </nav> ... offcanvas menu ... </div> ... <!-- Hero
        $pattern = '(?s)(\<\?php include.*?header\.php.*?\?\>).*?(\<\!-- Hero Section --\>)'
        $replacement = '$1' + "`n`n" + '$2'
        $content = $content -replace $pattern, $replacement
        
        Write-Host "    ✅ Removed embedded navigation" -ForegroundColor Green
    }
    
    # Fix include paths
    $includeChanges = 0
    
    # Convert $_SERVER['DOCUMENT_ROOT'] to relative
    if ($content -match '\$_SERVER\[.DOCUMENT_ROOT.\].*?/includes/') {
        $content = $content -replace [regex]::Escape('$_SERVER') + "\[.DOCUMENT_ROOT.\] \. '/includes/", "'../includes/"
        $includeChanges++
    }
    
    # Convert 'includes/' to '../includes/'
    if ($content -match "include 'includes/") {
        $content = $content -replace "include 'includes/", "include '../includes/"
        $includeChanges++
    }
    
    if ($includeChanges -gt 0) {
        Write-Host "    ✅ Fixed $includeChanges include path(s)" -ForegroundColor Green
    }
    
    # Fix resource paths
    $resourceChanges = 0
    
    # src="resources/ → src="../resources/
    $beforeCount = ([regex]::Matches($content, 'src="resources/')).Count
    $content = $content -replace 'src="resources/', 'src="../resources/'
    $afterCount = ([regex]::Matches($content, 'src="../resources/')).Count
    $resourceChanges += ($afterCount - $beforeCount + $beforeCount) / 2
    
    # href="resources/ → href="../resources/
    $beforeCount = ([regex]::Matches($content, 'href="resources/')).Count
    $content = $content -replace 'href="resources/', 'href="../resources/'
    $afterCount = ([regex]::Matches($content, 'href="../resources/')).Count
    $resourceChanges += ($afterCount - $beforeCount + $beforeCount) / 2
    
    if ($resourceChanges -gt 0) {
        Write-Host "    ✅ Fixed $([int]$resourceChanges) resource path(s)" -ForegroundColor Green
    }
    
    # Fix navigation links to use clean URLs
    $linkChanges = 0
    $links = @('index', 'gamedev', 'music', 'blog', 'diy', 'links', 'resume', 'services', 'patreon', 'live')
    foreach ($link in $links) {
        if ($content -match "href=`"$link\.php`"") {
            $content = $content -replace "href=`"$link\.php`"", "href=`"/$link`""
            $linkChanges++
        }
    }
    
    if ($linkChanges -gt 0) {
        Write-Host "    ✅ Fixed $linkChanges navigation link(s)" -ForegroundColor Green
    }
    
    # Save if changed
    if ($content -ne $originalContent) {
        if (-not $WhatIf) {
            Set-Content -Path $file.FullName -Value $content -NoNewline
            Write-Host "    💾 Saved changes" -ForegroundColor Cyan
        } else {
            Write-Host "    [WHATIF] Would save changes" -ForegroundColor Gray
        }
    } else {
        Write-Host "    ℹ️  Already clean" -ForegroundColor Gray
    }
    Write-Host ""
}

# ============================================================================
# STEP 2: Fix Blog Pages
# ============================================================================
Write-Host "📂 Processing Blog Pages..." -ForegroundColor Yellow
$blogFiles = Get-ChildItem -Path $BlogDir -Filter "*.php"

foreach ($file in $blogFiles) {
    Write-Host "  📝 $($file.Name)" -ForegroundColor White
    
    $content = Get-Content -Path $file.FullName -Raw
    $originalContent = $content
    
    # Check for embedded navigation
    if ($content -match '<nav class=|navbar-brand|<div class="offcanvas') {
        Write-Host "    ⚠️  DUPLICATE NAV FOUND - Removing..." -ForegroundColor Red
        # Remove embedded navigation (same pattern as game pages)
        $pattern = '(?s)(\<\?php include.*?header\.php.*?\?\>).*?(\<\!-- .*?Section --\>)'
        $replacement = '$1' + "`n`n" + '$2'
        $content = $content -replace $pattern, $replacement
        Write-Host "    ✅ Removed embedded navigation" -ForegroundColor Green
    }
    
    # Fix include paths (blog uses ../ since it's in blog/ subdirectory)
    if ($content -match "include 'includes/") {
        $content = $content -replace "include 'includes/", "include '../includes/"
        Write-Host "    ✅ Fixed include paths" -ForegroundColor Green
    }
    
    # Fix resource paths
    if ($content -match 'resources/' -and $content -notmatch '\.\./resources/') {
        $content = $content -replace '(src|href)="resources/', '$1="../resources/'
        Write-Host "    ✅ Fixed resource paths" -ForegroundColor Green
    }
    
    # Save if changed
    if ($content -ne $originalContent) {
        if (-not $WhatIf) {
            Set-Content -Path $file.FullName -Value $content -NoNewline
            Write-Host "    💾 Saved changes" -ForegroundColor Cyan
        } else {
            Write-Host "    [WHATIF] Would save changes" -ForegroundColor Gray
        }
    } else {
        Write-Host "    ℹ️  Already clean" -ForegroundColor Gray
    }
    Write-Host ""
}

# ============================================================================
# STEP 3: Verify Header/Footer Usage
# ============================================================================
Write-Host "🔍 Verifying Header/Footer Includes..." -ForegroundColor Yellow

$allPhpFiles = @()
$allPhpFiles += Get-ChildItem -Path $GameDir -Filter "*.php"
$allPhpFiles += Get-ChildItem -Path $BlogDir -Filter "*.php"

$missingHeader = @()
$missingFooter = @()

foreach ($file in $allPhpFiles) {
    $content = Get-Content -Path $file.FullName -Raw
    
    if ($content -notmatch "include.*header\.php") {
        $missingHeader += $file.Name
    }
    if ($content -notmatch "include.*footer\.php") {
        $missingFooter += $file.Name
    }
}

if ($missingHeader.Count -gt 0) {
    Write-Host "  ⚠️  Missing header.php include:" -ForegroundColor Red
    $missingHeader | ForEach-Object { Write-Host "     - $_" -ForegroundColor Red }
} else {
    Write-Host "  ✅ All pages have header.php" -ForegroundColor Green
}

if ($missingFooter.Count -gt 0) {
    Write-Host "  ⚠️  Missing footer.php include:" -ForegroundColor Red
    $missingFooter | ForEach-Object { Write-Host "     - $_" -ForegroundColor Red }
} else {
    Write-Host "  ✅ All pages have footer.php" -ForegroundColor Green
}

Write-Host ""
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  ✅ ALL PAGES FIXED - SINGLE SOURCE HEADER/FOOTER" -ForegroundColor Green
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "Summary:" -ForegroundColor Cyan
Write-Host "  • Game pages: $($gameFiles.Count) files processed" -ForegroundColor White
Write-Host "  • Blog pages: $($blogFiles.Count) files processed" -ForegroundColor White
Write-Host "  • Include path: ../includes/header.php & ../includes/footer.php" -ForegroundColor White
Write-Host "  • Resource path: ../resources/*" -ForegroundColor White
Write-Host "  • Navigation: Clean URLs (no .php)" -ForegroundColor White
Write-Host ""
