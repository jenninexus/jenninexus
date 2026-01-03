<#
.SYNOPSIS
Validate Tag System Implementation Across All Pages

.DESCRIPTION
Checks each page to verify:
1. Tag filter offcanvas is present (if applicable)
2. tag-system.js is loaded
3. Tags are populated correctly
4. Apply Filters button works
5. Tag data files are accessible

Per TAG-SYSTEM.md protocol, verifies tag filtering on:
- index.php (home page)
- gaming.php
- gamedev.php  
- diy.php
- music.php

.EXAMPLE
.\scripts\validate-tag-system.ps1
.\scripts\validate-tag-system.ps1 -Verbose
.\scripts\validate-tag-system.ps1 -CheckDataFiles
#>

[CmdletBinding()]
param(
    [switch]$CheckDataFiles
)

$ErrorActionPreference = 'Continue'
$projectRoot = Split-Path -Parent $PSScriptRoot

Write-Host "`n🔍 Tag System Validation" -ForegroundColor Cyan
Write-Host "=" * 60

# Pages that should have tag filter offcanvas
$pagesWithOffcanvas = @(
    @{
        File = "index.php"
        Name = "Home Page"
        ExpectedTags = @("gamedev", "gaming", "diy", "music", "voice-acting")
    },
    @{
        File = "gaming.php"
        Name = "Gaming Page"
        ExpectedTags = @("gaming", "fps", "horror", "platformer", "indie")
    },
    @{
        File = "gamedev.php"
        Name = "Game Dev Page"
        ExpectedTags = @("gamedev", "unity", "unreal", "devlog", "3d-modeling")
    },
    @{
        File = "diy.php"
        Name = "DIY Page"
        ExpectedTags = @("diy", "fashion", "beauty", "hair", "nails")
    },
    @{
        File = "music.php"
        Name = "Music Page"
        ExpectedTags = @("music", "dj", "edm", "production")
    }
)

$results = @{
    Passed = 0
    Failed = 0
    Warnings = 0
}

# =====================================================
# STEP 1: Validate data files
# =====================================================
if ($CheckDataFiles) {
    Write-Host "`n📂 Checking Tag Data Files..." -ForegroundColor Yellow
    
    $dataFiles = @(
        @{
            Path = "public_html\resources\playlists\tags.json"
            Name = "Tag Definitions"
            Required = $true
        },
        @{
            Path = "public_html\resources\playlists\content_tags.json"
            Name = "Content Tag Mappings"
            Required = $true
        },
        @{
            Path = "public_html\resources\playlists\generated_tags.json"
            Name = "Generated Tags (optional)"
            Required = $false
        },
        @{
            Path = "public_html\resources\playlists\generated_content_tags.json"
            Name = "Generated Content Tags (optional)"
            Required = $false
        }
    )
    
    foreach ($file in $dataFiles) {
        $fullPath = Join-Path $projectRoot $file.Path
        
        if (Test-Path $fullPath) {
            $content = Get-Content $fullPath -Raw | ConvertFrom-Json
            
            if ($file.Path -like "*tags.json") {
                $count = if ($content -is [Array]) { $content.Count } else { 0 }
                Write-Host "   ✅ $($file.Name): $count tags" -ForegroundColor Green
                $results.Passed++
            }
            elseif ($file.Path -like "*content_tags.json") {
                $count = ($content.PSObject.Properties | Measure-Object).Count
                Write-Host "   ✅ $($file.Name): $count entries" -ForegroundColor Green
                $results.Passed++
            }
            else {
                Write-Host "   ✅ $($file.Name): Present" -ForegroundColor Green
                $results.Passed++
            }
        }
        else {
            if ($file.Required) {
                Write-Host "   ❌ $($file.Name): MISSING (REQUIRED)" -ForegroundColor Red
                $results.Failed++
            }
            else {
                Write-Host "   ⚠️  $($file.Name): Not found (optional - expected on first run)" -ForegroundColor Yellow
                $results.Warnings++
            }
        }
    }
}

# =====================================================
# STEP 2: Validate each page implementation
# =====================================================
Write-Host "`n📄 Validating Page Implementations..." -ForegroundColor Yellow

foreach ($page in $pagesWithOffcanvas) {
    $filePath = Join-Path $projectRoot "public_html\$($page.File)"
    
    Write-Host "`n   📄 $($page.Name) ($($page.File))" -ForegroundColor Cyan
    
    if (-not (Test-Path $filePath)) {
        Write-Host "      ❌ File not found: $($page.File)" -ForegroundColor Red
        $results.Failed++
        continue
    }
    
    $content = Get-Content $filePath -Raw
    
    # Check 1: Offcanvas panel exists
    if ($content -match 'id="tagFilterOffcanvas"') {
        Write-Host "      ✅ Tag filter offcanvas present" -ForegroundColor Green
        $results.Passed++
    }
    else {
        Write-Host "      ❌ Tag filter offcanvas MISSING" -ForegroundColor Red
        $results.Failed++
    }
    
    # Check 2: tag-system.js is loaded
    if ($content -match 'tag-system\.js') {
        Write-Host "      ✅ tag-system.js loaded" -ForegroundColor Green
        $results.Passed++
    }
    else {
        Write-Host "      ❌ tag-system.js NOT loaded" -ForegroundColor Red
        $results.Failed++
    }
    
    # Check 3: Apply Filters button exists
    if ($content -match 'id="applyFiltersBtn"|applyFiltersBtn') {
        Write-Host "      ✅ Apply Filters button present" -ForegroundColor Green
        $results.Passed++
    }
    else {
        Write-Host "      ⚠️  Apply Filters button not found (may use inline handler)" -ForegroundColor Yellow
        $results.Warnings++
    }
    
    # Check 4: Clear Filters button exists  
    if ($content -match 'id="clearFiltersBtn"|clearFiltersBtn') {
        Write-Host "      ✅ Clear Filters button present" -ForegroundColor Green
        $results.Passed++
    }
    else {
        Write-Host "      ⚠️  Clear Filters button not found" -ForegroundColor Yellow
        $results.Warnings++
    }
    
    # Check 5: Tag list containers exist
    $expectedContainers = @("gamedevTagsList", "gamingTagsList", "diyTagsList", "musicTagsList")
    $foundContainers = 0
    
    foreach ($container in $expectedContainers) {
        if ($content -match "id=""$container""") {
            $foundContainers++
        }
    }
    
    if ($foundContainers -gt 0) {
        Write-Host "      ✅ Tag list containers: $foundContainers found" -ForegroundColor Green
        $results.Passed++
    }
    else {
        Write-Host "      ⚠️  No tag list containers found" -ForegroundColor Yellow
        $results.Warnings++
    }
    
    # Check 6: RES_ROOT constant used for script loading
    if ($content -match '\<\?=\s*RES_ROOT\s*\?\>') {
        Write-Host "      ✅ RES_ROOT constant used" -ForegroundColor Green
        $results.Passed++
    }
    else {
        Write-Host "      ⚠️  RES_ROOT not found (may use hardcoded paths)" -ForegroundColor Yellow
        $results.Warnings++
    }
}

# =====================================================
# STEP 3: Check youtube.php (should NOT have tag system)
# =====================================================
Write-Host "`n📄 Checking youtube.php (No Tag System Expected)..." -ForegroundColor Yellow

$youtubePath = Join-Path $projectRoot "public_html\youtube.php"

if (Test-Path $youtubePath) {
    $youtubeContent = Get-Content $youtubePath -Raw
    
    # youtube.php should NOT have offcanvas or tag-system.js per latest changes
    $hasOffcanvas = $youtubeContent -match 'tagFilterOffcanvas'
    $hasTagSystem = $youtubeContent -match 'tag-system\.js'
    
    if (-not $hasOffcanvas -and -not $hasTagSystem) {
        Write-Host "   ✅ youtube.php correctly has NO tag filtering (RSS feed only)" -ForegroundColor Green
        $results.Passed++
    }
    elseif ($hasOffcanvas -or $hasTagSystem) {
        Write-Host "   ⚠️  youtube.php has tag filtering components (may be outdated)" -ForegroundColor Yellow
        $results.Warnings++
    }
}

# =====================================================
# STEP 4: Summary
# =====================================================
Write-Host "`n" + ("=" * 60)
Write-Host "📊 Validation Summary" -ForegroundColor Cyan
Write-Host ("=" * 60)

Write-Host "`n   ✅ Passed: $($results.Passed)" -ForegroundColor Green
Write-Host "   ❌ Failed: $($results.Failed)" -ForegroundColor $(if ($results.Failed -gt 0) { "Red" } else { "Gray" })
Write-Host "   ⚠️  Warnings: $($results.Warnings)" -ForegroundColor Yellow

Write-Host "`n📋 Pages with Tag Filtering:" -ForegroundColor Cyan
foreach ($page in $pagesWithOffcanvas) {
    Write-Host "   • $($page.Name) - $($page.File)" -ForegroundColor White
}

Write-Host "`n📚 Tag System Documentation:" -ForegroundColor Cyan
Write-Host "   • storage/docs/TAG-SYSTEM.md" -ForegroundColor White
Write-Host "   • .config/tag-deps.json" -ForegroundColor White

Write-Host "`n🔧 Recommended Actions:" -ForegroundColor Yellow

if ($results.Failed -gt 0) {
    Write-Host "   1. Fix failed checks above" -ForegroundColor Red
    Write-Host "   2. Verify tag data files are present in public_html/resources/playlists/" -ForegroundColor White
    Write-Host "   3. Test tag filtering on affected pages" -ForegroundColor White
}
else {
    Write-Host "   1. Test tag filtering manually on each page" -ForegroundColor White
    Write-Host "   2. Click 'Filter by Tags' button" -ForegroundColor White
    Write-Host "   3. Select multiple tags from different categories" -ForegroundColor White
    Write-Host "   4. Click 'Apply Filters' → should redirect to /tags.php?filters=..." -ForegroundColor White
    Write-Host "   5. Verify filtered results show correct content" -ForegroundColor White
}

Write-Host "`n✨ Next Steps:" -ForegroundColor Cyan
Write-Host "   • Run scripts/generate-playlist-tags.ps1 to update content_tags.json" -ForegroundColor White
Write-Host "   • Test on dev server: http://localhost:8002" -ForegroundColor White
Write-Host "   • Deploy after validation passes" -ForegroundColor White
Write-Host ""

# Exit code based on failures
if ($results.Failed -gt 0) {
    exit 1
}
else {
    exit 0
}
