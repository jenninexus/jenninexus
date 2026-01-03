#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Optimize CSS/JS assets - PurgeCSS and minification
.DESCRIPTION
    Removes unused CSS from Bootstrap/FontAwesome bundles and minifies custom assets.
    Should be run after build.ps1 compiles SCSS to CSS.
.PARAMETER DryRun
    Preview what would be purged without making changes
.EXAMPLE
    .\optimize-assets.ps1
    .\optimize-assets.ps1 -DryRun
#>

param([switch]$DryRun)

$ErrorActionPreference = "Stop"
$ProjectRoot = Split-Path $PSScriptRoot -Parent
$PublicHtml = Join-Path $ProjectRoot "public_html"
$ResourcesDir = Join-Path $PublicHtml "resources"
$CssDir = Join-Path $ResourcesDir "css"
$JsDir = Join-Path $ResourcesDir "js"
$LogDir = Join-Path $ProjectRoot "storage\logs"
$LogFile = Join-Path $LogDir "optimize-$(Get-Date -Format 'yyyy-MM-dd').log"

# Ensure log directory exists
if (-not (Test-Path $LogDir)) {
    New-Item -ItemType Directory -Path $LogDir -Force | Out-Null
}

function Write-Log {
    param([string]$Message, [string]$Level = "INFO")
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $logMessage = "[$timestamp] [$Level] $Message"
    Add-Content -Path $LogFile -Value $logMessage -ErrorAction SilentlyContinue
    
    switch ($Level) {
        "ERROR" { Write-Host $Message -ForegroundColor Red }
        "WARN"  { Write-Host $Message -ForegroundColor Yellow }
        "SUCCESS" { Write-Host $Message -ForegroundColor Green }
        default { Write-Host $Message -ForegroundColor Cyan }
    }
}

Write-Host "`n╔════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║     🚀 CSS/JS Asset Optimization                  ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""

if ($DryRun) {
    Write-Log "DRY RUN MODE - No files will be modified" "WARN"
    Write-Host ""
}

Write-Log "=== Asset Optimization Started ===" "INFO"

# ==============================================================================
# STEP 1: Check for required tools
# ==============================================================================
Write-Host "[1/4] Checking for optimization tools..." -ForegroundColor Yellow

$hasNpm = $null -ne (Get-Command npm -ErrorAction SilentlyContinue)
$hasNode = $null -ne (Get-Command node -ErrorAction SilentlyContinue)
$hasPurgeCSS = $false
$hasCssNano = $false
$hasTerser = $false

if ($hasNpm -and $hasNode) {
    Write-Log "  ✅ Node.js and npm found" "SUCCESS"
    
    # Check if PurgeCSS is available globally or can be run via npx
    try {
        $purgeCssCheck = & npm list -g purgecss 2>&1 | Out-String
        if ($purgeCssCheck -match "purgecss@") {
            $hasPurgeCSS = $true
            Write-Log "  ✅ PurgeCSS found (global)" "SUCCESS"
        }
    } catch { }
    
    if (-not $hasPurgeCSS) {
        # Check local node_modules
        $localPurgeCSS = Join-Path $ProjectRoot "node_modules\.bin\purgecss.cmd"
        if (Test-Path $localPurgeCSS) {
            $hasPurgeCSS = $true
            Write-Log "  ✅ PurgeCSS found (local)" "SUCCESS"
        } else {
            Write-Log "  ⚠️  PurgeCSS not found - will attempt npx install" "WARN"
            if (-not $DryRun) {
                Write-Log "  → Installing PurgeCSS..." "INFO"
                try {
                    & npm install --save-dev purgecss
                    $hasPurgeCSS = $true
                    Write-Log "  ✅ PurgeCSS installed" "SUCCESS"
                } catch {
                    Write-Log "  ❌ Failed to install PurgeCSS: $($_.Exception.Message)" "ERROR"
                }
            }
        }
    }
    
    # Check for cssnano (CSS minifier)
    try {
        $cssNanoCheck = & npm list -g cssnano 2>&1 | Out-String
        if ($cssNanoCheck -match "cssnano@") {
            $hasCssNano = $true
            Write-Log "  ✅ cssnano found" "SUCCESS"
        }
    } catch { }
    
    # Check for terser (JS minifier)
    try {
        $terserCheck = & npm list -g terser 2>&1 | Out-String
        if ($terserCheck -match "terser@") {
            $hasTerser = $true
            Write-Log "  ✅ terser found" "SUCCESS"
        }
    } catch { }
    
    if (-not $hasCssNano -or -not $hasTerser) {
        Write-Log "  ℹ️  Optional minifiers not found (cssnano, terser) - will use basic minification" "INFO"
    }
} else {
    Write-Log "  ❌ Node.js/npm not found - optimization requires Node.js" "ERROR"
    Write-Host ""
    Write-Host "Install Node.js from https://nodejs.org/ to enable asset optimization" -ForegroundColor Yellow
    exit 1
}

Write-Host ""

# ==============================================================================
# STEP 2: PurgeCSS - Remove unused CSS from Bootstrap/FontAwesome
# ==============================================================================
Write-Host "[2/4] Running PurgeCSS on Bootstrap/FontAwesome..." -ForegroundColor Yellow

if ($hasPurgeCSS) {
    # Files to scan for used CSS classes
    $contentFiles = @(
        "$PublicHtml\**\*.php",
        "$PublicHtml\**\*.html",
        "$ResourcesDir\js\**\*.js"
    )
    
    # CSS files to purge (only third-party bundles, not custom themes)
    $cssFilesToPurge = @(
        @{
            Input = "bootstrap.min.css"
            Output = "bootstrap.purged.min.css"
            Description = "Bootstrap 5.3.8"
        },
        @{
            Input = "all.min.css"
            Output = "fontawesome.purged.min.css"
            Description = "FontAwesome 6.7.2"
        }
    )
    
    $purgedCount = 0
    $totalSavings = 0
    
    foreach ($cssFile in $cssFilesToPurge) {
        $inputPath = Join-Path $CssDir $cssFile.Input
        $outputPath = Join-Path $CssDir $cssFile.Output
        
        if (Test-Path $inputPath) {
            $originalSize = (Get-Item $inputPath).Length
            $originalSizeKB = [math]::Round($originalSize / 1KB, 2)
            
            Write-Log "  → Purging $($cssFile.Description): $($cssFile.Input) ($originalSizeKB KB)"
            
            if (-not $DryRun) {
                try {
                    # Create PurgeCSS config on-the-fly
                    $purgeConfig = @"
{
  "content": [
    "public_html/**/*.php",
    "public_html/**/*.html",
    "public_html/resources/js/**/*.js"
  ],
  "css": ["$inputPath"],
  "output": "$outputPath",
  "safelist": {
    "standard": ["active", "show", "collapse", "collapsing", "modal-backdrop", "fade", "tooltip", "popover"],
    "deep": [/^navbar/, /^dropdown/, /^carousel/, /^modal/, /^offcanvas/, /^btn/, /^fa-/, /^bi-/],
    "greedy": [/data-bs-/, /^toast/, /^alert/]
  }
}
"@
                    $configPath = Join-Path $ProjectRoot "purgecss.config.json"
                    $purgeConfig | Out-File -FilePath $configPath -Encoding utf8 -Force
                    
                    # Run PurgeCSS
                    $purgeCmd = "purgecss --config `"$configPath`""
                    & npx --yes purgecss --css "$inputPath" --content $contentFiles -o (Split-Path $outputPath -Parent)
                    
                    if (Test-Path $outputPath) {
                        $newSize = (Get-Item $outputPath).Length
                        $newSizeKB = [math]::Round($newSize / 1KB, 2)
                        $savings = $originalSize - $newSize
                        $savingsKB = [math]::Round($savings / 1KB, 2)
                        $savingsPercent = [math]::Round(($savings / $originalSize) * 100, 1)
                        
                        $totalSavings += $savings
                        $purgedCount++
                        
                        Write-Log "    ✅ $($cssFile.Output): $newSizeKB KB (saved $savingsKB KB / $savingsPercent%)" "SUCCESS"
                    } else {
                        Write-Log "    ❌ PurgeCSS failed to create output file" "ERROR"
                    }
                    
                    # Clean up temp config
                    Remove-Item $configPath -ErrorAction SilentlyContinue
                    
                } catch {
                    Write-Log "    ❌ PurgeCSS error: $($_.Exception.Message)" "ERROR"
                }
            } else {
                Write-Log "    [DRY RUN] Would purge $($cssFile.Input) → $($cssFile.Output)" "INFO"
            }
        } else {
            Write-Log "  ⚠️  $($cssFile.Input) not found, skipping" "WARN"
        }
    }
    
    if ($purgedCount -gt 0 -and -not $DryRun) {
        $totalSavingsMB = [math]::Round($totalSavings / 1MB, 2)
        Write-Log ""
        Write-Log "  📊 Total CSS reduction: $totalSavingsMB MB across $purgedCount files" "SUCCESS"
    }
} else {
    Write-Log "  ⚠️  Skipping PurgeCSS (not available)" "WARN"
}

Write-Host ""

# ==============================================================================
# STEP 3: Minify Custom CSS
# ==============================================================================
Write-Host "[3/4] Minifying custom CSS files..." -ForegroundColor Yellow

$customCssFiles = Get-ChildItem -Path $CssDir -Filter "*.css" -File -ErrorAction SilentlyContinue | Where-Object {
    $_.Name -notmatch "\.min\.css$" -and 
    $_.Name -notmatch "\.purged\.css$" -and
    $_.Name -notmatch "^bootstrap" -and
    $_.Name -notmatch "^all\.css" -and
    $_.Name -notmatch "^fontawesome"
}

$minifiedCount = 0

foreach ($cssFile in $customCssFiles) {
    $inputPath = $cssFile.FullName
    $outputName = $cssFile.BaseName + ".min.css"
    $outputPath = Join-Path $CssDir $outputName
    
    # Skip if .min.css already exists and is newer
    if ((Test-Path $outputPath) -and ((Get-Item $outputPath).LastWriteTime -gt $cssFile.LastWriteTime)) {
        Write-Log "  → Skipping $($cssFile.Name) (already minified)" "INFO"
        continue
    }
    
    $originalSize = $cssFile.Length
    $originalSizeKB = [math]::Round($originalSize / 1KB, 2)
    
    Write-Log "  → Minifying $($cssFile.Name) ($originalSizeKB KB)"
    
    if (-not $DryRun) {
        try {
            # Simple minification: remove comments, whitespace, newlines
            $content = Get-Content -Path $inputPath -Raw
            $minified = $content -replace '/\*[\s\S]*?\*/', '' # Remove comments
            $minified = $minified -replace '\s+', ' ' # Collapse whitespace
            $minified = $minified -replace '\s*([{}:;,])\s*', '$1' # Remove spaces around punctuation
            $minified = $minified.Trim()
            
            $minified | Out-File -FilePath $outputPath -Encoding utf8 -NoNewline -Force
            
            $newSize = (Get-Item $outputPath).Length
            $newSizeKB = [math]::Round($newSize / 1KB, 2)
            $savings = [math]::Round((1 - ($newSize / $originalSize)) * 100, 1)
            
            $minifiedCount++
            Write-Log "    ✅ $outputName : $newSizeKB KB (reduced ${savings}%)" "SUCCESS"
        } catch {
            Write-Log "    ❌ Minification error: $($_.Exception.Message)" "ERROR"
        }
    } else {
        Write-Log "    [DRY RUN] Would minify $($cssFile.Name) → $outputName" "INFO"
    }
}

if ($minifiedCount -eq 0) {
    Write-Log "  ℹ️  No custom CSS files needed minification" "INFO"
}

Write-Host ""

# ==============================================================================
# STEP 4: Minify Custom JavaScript
# ==============================================================================
Write-Host "[4/4] Minifying custom JavaScript files..." -ForegroundColor Yellow

$customJsFiles = Get-ChildItem -Path $JsDir -Filter "*.js" -File -ErrorAction SilentlyContinue | Where-Object {
    $_.Name -notmatch "\.min\.js$" -and
    $_.Name -notmatch "^bootstrap" -and
    $_.Name -notmatch "^jquery"
}

$jsMinifiedCount = 0

foreach ($jsFile in $customJsFiles) {
    $inputPath = $jsFile.FullName
    $outputName = $jsFile.BaseName + ".min.js"
    $outputPath = Join-Path $JsDir $outputName
    
    # Skip if .min.js already exists and is newer
    if ((Test-Path $outputPath) -and ((Get-Item $outputPath).LastWriteTime -gt $jsFile.LastWriteTime)) {
        Write-Log "  → Skipping $($jsFile.Name) (already minified)" "INFO"
        continue
    }
    
    $originalSize = $jsFile.Length
    $originalSizeKB = [math]::Round($originalSize / 1KB, 2)
    
    Write-Log "  → Minifying $($jsFile.Name) ($originalSizeKB KB)"
    
    if (-not $DryRun) {
        try {
            if ($hasTerser) {
                # Use terser for proper JS minification
                & npx --yes terser "$inputPath" -o "$outputPath" --compress --mangle
            } else {
                # Basic minification: remove comments and excess whitespace
                $content = Get-Content -Path $inputPath -Raw
                $minified = $content -replace '//.*$', '' # Remove single-line comments
                $minified = $minified -replace '/\*[\s\S]*?\*/', '' # Remove multi-line comments
                $minified = $minified -replace '\s+', ' ' # Collapse whitespace
                $minified = $minified.Trim()
                
                $minified | Out-File -FilePath $outputPath -Encoding utf8 -NoNewline -Force
            }
            
            if (Test-Path $outputPath) {
                $newSize = (Get-Item $outputPath).Length
                $newSizeKB = [math]::Round($newSize / 1KB, 2)
                $savings = [math]::Round((1 - ($newSize / $originalSize)) * 100, 1)
                
                $jsMinifiedCount++
                Write-Log "    ✅ $outputName : $newSizeKB KB (reduced ${savings}%)" "SUCCESS"
            }
        } catch {
            Write-Log "    ❌ Minification error: $($_.Exception.Message)" "ERROR"
        }
    } else {
        Write-Log "    [DRY RUN] Would minify $($jsFile.Name) → $outputName" "INFO"
    }
}

if ($jsMinifiedCount -eq 0) {
    Write-Log "  ℹ️  No custom JavaScript files needed minification" "INFO"
}

Write-Host ""

# ==============================================================================
# Summary
# ==============================================================================
Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║  ✅ ASSET OPTIMIZATION COMPLETE!                  ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Green
Write-Host ""

if (-not $DryRun) {
    Write-Log "📊 Optimization Summary:" "SUCCESS"
    Write-Log "   • CSS files purged: $purgedCount" "INFO"
    Write-Log "   • Custom CSS minified: $minifiedCount" "INFO"
    Write-Log "   • JavaScript minified: $jsMinifiedCount" "INFO"
    if ($totalSavings -gt 0) {
        $totalSavingsMB = [math]::Round($totalSavings / 1MB, 2)
        Write-Log "   • Total space saved: $totalSavingsMB MB" "SUCCESS"
    }
} else {
    Write-Log "DRY RUN COMPLETE - No changes made" "WARN"
    Write-Log "Run without -DryRun to apply optimizations" "INFO"
}

Write-Host ""
Write-Log "=== Asset Optimization Finished ===" "INFO"
