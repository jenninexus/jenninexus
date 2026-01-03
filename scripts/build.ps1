<#
.SYNOPSIS
    JenniNexus Build Script - Copy assets from src/ to public_html/resources/
    
.DESCRIPTION
    This script handles the core asset pipeline for JenniNexus:
    - Copies and minifies CSS files from src/assets/css to public_html/resources/css
    - Copies JavaScript files from src/assets/js to public_html/resources/js
    - Copies fonts, images, PDFs, SVGs from src/assets to public_html/resources
    - Copies YAML playlist configuration files
    - Manages JSON config files (tags.json, content_tags.json, playlist-ids.json)
    - Only copies files when source is newer than destination (incremental builds)
    - Minifies CSS using clean-css-cli when files change
    
.PARAMETER Clean
    When specified, removes legacy .html files from public_html (we use .php now)
    
.EXAMPLE
    .\scripts\build.ps1
    Standard build - copies changed files only
    
.EXAMPLE
    .\scripts\build.ps1 -Clean
    Build and clean up old HTML files
    
.NOTES
    - SCSS is archived (no longer compiled) - we use CSS custom properties now
    - Run this before deploying to ensure all assets are up to date
    - CSS minification requires npm (clean-css-cli package)
    - Logs to storage/logs/build-YYYY-MM-DD.log
#>

# JenniNexus Build Script
param(
    [switch]$Clean,
    [switch]$Quiet
)

$ProjectRoot = Split-Path $PSScriptRoot -Parent
$SrcAssets = Join-Path $ProjectRoot "src" | Join-Path -ChildPath "assets"
$ResourcesDir = Join-Path $ProjectRoot "public_html" | Join-Path -ChildPath "resources"
$LogDir = Join-Path $ProjectRoot "storage" | Join-Path -ChildPath "logs"
$LogFile = Join-Path $LogDir "build-$(Get-Date -Format 'yyyy-MM-dd').log"

# Ensure log directory exists
if (-not (Test-Path $LogDir)) {
    New-Item -ItemType Directory -Path $LogDir -Force | Out-Null
}

# Function to log messages
function Write-Log {
    param([string]$Message, [string]$Level = "INFO")
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $logMessage = "[$timestamp] [$Level] $Message"
    Add-Content -Path $LogFile -Value $logMessage
    
    # Only show errors and warnings in quiet mode
    if ($Quiet -and $Level -notin @("ERROR", "WARN")) {
        return
    }
    
    switch ($Level) {
        "ERROR" { Write-Host $Message -ForegroundColor Red }
        "WARN"  { Write-Host $Message -ForegroundColor Yellow }
        "SUCCESS" { Write-Host $Message -ForegroundColor Green }
        default { Write-Host $Message -ForegroundColor Cyan }
    }
}

Write-Log "`n=== JenniNexus Build Started ===" "INFO"
Write-Log "Copying from src/assets to public_html/resources..."

$copiedFiles = 0
$buildErrors = @()

# Use a local ErrorAction variable to avoid analyzer false-positives
# ActionPreference is the correct enum type for ErrorAction values
$EAStop = [System.Management.Automation.ActionPreference]::Stop

# ------------------------------------------------------------------
# SCSS: ARCHIVED - No longer compiled (Bootstrap 5.3.8 uses CSS custom properties)
# ------------------------------------------------------------------
# Note: SCSS source archived at src/assets/scss.archived/
# We now use direct CSS files - no compilation needed
Write-Log "SCSS compilation skipped (archived - using direct CSS files)"

$SrcScssDir = Join-Path $SrcAssets 'scss'
$SrcCssDir = Join-Path $SrcAssets 'css'
$PublicScssDir = Join-Path $ResourcesDir 'scss'

# Remove legacy public_html/resources/scss if it exists
if (Test-Path $PublicScssDir) {
    Write-Log "Removing legacy public_html/resources/scss/ directory..."
    try {
        Remove-Item -Path $PublicScssDir -Recurse -Force -ErrorAction SilentlyContinue
        Write-Log "  → Removed legacy public_html/resources/scss/" "SUCCESS"
    } catch {
        Write-Log "  ⚠ Could not remove legacy scss directory: $($_.Exception.Message)" "WARN"
    }
}

# Remove legacy public_html/resources/webfonts if it exists (moved to vendor/fontawesome/webfonts)
$PublicWebfontsDir = Join-Path $ResourcesDir 'webfonts'
if (Test-Path $PublicWebfontsDir) {
    Write-Log "Removing legacy public_html/resources/webfonts/ directory (moved to vendor)..."
    try {
        Remove-Item -Path $PublicWebfontsDir -Recurse -Force -ErrorAction SilentlyContinue
        Write-Log "  → Removed legacy public_html/resources/webfonts/" "SUCCESS"
    } catch {
        Write-Log "  ⚠ Could not remove legacy webfonts directory: $($_.Exception.Message)" "WARN"
    }
}

# Ensure src/assets/css directory exists (for any future CSS files)
if (-not (Test-Path $SrcCssDir)) { New-Item -ItemType Directory -Path $SrcCssDir -Force | Out-Null }

# Copy PDFs
if (Test-Path "$SrcAssets\pdfs") { 
    try {
        $pdfCount = (Get-ChildItem "$SrcAssets\pdfs" -File -ErrorAction SilentlyContinue).Count
        if ($pdfCount -gt 0) {
            Copy-Item "$SrcAssets\pdfs\*" "$ResourcesDir\pdfs\" -Force -ErrorAction $EAStop
            $copiedFiles += $pdfCount
            Write-Log "  → Copied $pdfCount PDF files"
        }
    } catch {
        $buildErrors += "PDFs: $($_.Exception.Message)"
    }
}

# Copy Blog Posts
if (Test-Path "$SrcAssets\blog posts") { 
    try {
        $blogCount = (Get-ChildItem "$SrcAssets\blog posts" -Filter "*.md" -ErrorAction SilentlyContinue).Count
        if ($blogCount -gt 0) {
            Copy-Item "$SrcAssets\blog posts\*.md" "$ResourcesDir\blog posts\" -Force -ErrorAction $EAStop
            $copiedFiles += $blogCount
            Write-Log "  → Copied $blogCount blog posts"
        }
    } catch {
        $buildErrors += "Blog Posts: $($_.Exception.Message)"
    }
}

# Copy Fonts
if (Test-Path "$SrcAssets\fonts") { 
    try {
        $fontCount = (Get-ChildItem "$SrcAssets\fonts" -File -ErrorAction SilentlyContinue).Count
        if ($fontCount -gt 0) {
            Copy-Item "$SrcAssets\fonts\*" "$ResourcesDir\fonts\" -Force -ErrorAction $EAStop
            $copiedFiles += $fontCount
            Write-Log "  → Copied $fontCount font files"
        }
    } catch {
        $buildErrors += "Fonts: $($_.Exception.Message)"
    }
}

# Copy SVGs
if (Test-Path "$SrcAssets\svgs") { 
    try {
        $svgCount = (Get-ChildItem "$SrcAssets\svgs" -Filter "*.svg" -ErrorAction SilentlyContinue).Count
        if ($svgCount -gt 0) {
            Copy-Item "$SrcAssets\svgs\*.svg" "$ResourcesDir\svgs\" -Force -ErrorAction $EAStop
            $copiedFiles += $svgCount
            Write-Log "  → Copied $svgCount SVG files"
        }
    } catch {
        $buildErrors += "SVGs: $($_.Exception.Message)"
    }
}

# Copy CSS files (only if source is newer than destination or destination missing)
# Also minify CSS files to .min.css variants using clean-css-cli
if (Test-Path "$SrcAssets\css") {
    try {
        $cssFiles = Get-ChildItem "$SrcAssets\css" -Filter "*.css" -File -ErrorAction SilentlyContinue | Where-Object { $_.Name -notlike "*.min.css" }
        foreach ($file in $cssFiles) {
            $targetDir = Join-Path $ResourcesDir 'css'
            if (-not (Test-Path $targetDir)) { New-Item -ItemType Directory -Path $targetDir -Force | Out-Null }
            $targetPath = Join-Path $targetDir $file.Name
            $shouldCopy = $false
            if (-not (Test-Path $targetPath)) { $shouldCopy = $true }
            else {
                $srcTime = $file.LastWriteTimeUtc
                $dstTime = (Get-Item $targetPath).LastWriteTimeUtc
                if ($srcTime -gt $dstTime) { $shouldCopy = $true }
            }
            if ($shouldCopy) {
                Copy-Item -Path $file.FullName -Destination $targetPath -Force -ErrorAction $EAStop
                $copiedFiles += 1
                Write-Log "  → Copied CSS: $($file.Name)"
            } else {
                Write-Log "  → Skipped CSS (up-to-date): $($file.Name)" "INFO"
            }
        }
        
        # Minify non-minified CSS files in public_html/resources/css
        Write-Log "Minifying CSS files..." "INFO"
        $publicCssDir = Join-Path $ResourcesDir 'css'
        $cssToMinify = Get-ChildItem $publicCssDir -Filter "*.css" -File -ErrorAction SilentlyContinue | Where-Object { 
            $_.Name -notlike "*.min.css" -and $_.Name -notlike "*.archived.*" 
        }
        
        foreach ($css in $cssToMinify) {
            $minName = $css.Name -replace '\.css$', '.min.css'
            $minPath = Join-Path $publicCssDir $minName
            
            # Check if minification is needed (source newer than minified or minified missing)
            $shouldMinify = $false
            if (-not (Test-Path $minPath)) { 
                $shouldMinify = $true 
            } else {
                $srcTime = $css.LastWriteTimeUtc
                $dstTime = (Get-Item $minPath).LastWriteTimeUtc
                if ($srcTime -gt $dstTime) { $shouldMinify = $true }
            }
            
            if ($shouldMinify) {
                try {
                    # Use npx clean-css-cli for minification
                    $result = & npx clean-css-cli -o $minPath $css.FullName 2>&1
                    if ($LASTEXITCODE -eq 0) {
                        Write-Log "  → Minified: $($css.Name) → $minName" "SUCCESS"
                    } else {
                        Write-Log "  → Warning: Failed to minify $($css.Name): $result" "WARN"
                    }
                } catch {
                    Write-Log "  → Warning: CSS minification unavailable (install: npm install -g clean-css-cli)" "WARN"
                }
            } else {
                Write-Log "  → Skipped minification (up-to-date): $minName" "INFO"
            }
        }
    } catch {
        $buildErrors += "CSS: $($_.Exception.Message)"
    }
}

# Copy JavaScript files (only if source is newer than destination or destination missing)
if (Test-Path "$SrcAssets\js") {
    try {
        $jsFiles = Get-ChildItem "$SrcAssets\js" -Filter "*.js" -File -ErrorAction SilentlyContinue
        foreach ($file in $jsFiles) {
            $targetDir = Join-Path $ResourcesDir 'js'
            if (-not (Test-Path $targetDir)) { New-Item -ItemType Directory -Path $targetDir -Force | Out-Null }
            $targetPath = Join-Path $targetDir $file.Name
            $shouldCopy = $false
            if (-not (Test-Path $targetPath)) { $shouldCopy = $true }
            else {
                $srcTime = $file.LastWriteTimeUtc
                $dstTime = (Get-Item $targetPath).LastWriteTimeUtc
                if ($srcTime -gt $dstTime) { $shouldCopy = $true }
            }
            if ($shouldCopy) {
                Copy-Item -Path $file.FullName -Destination $targetPath -Force -ErrorAction $EAStop
                $copiedFiles += 1
                Write-Log "  → Copied JS: $($file.Name)"
            } else {
                Write-Log "  → Skipped JS (up-to-date): $($file.Name)" "INFO"
            }
        }
    } catch {
        $buildErrors += "JavaScript: $($_.Exception.Message)"
    }
}

"# Copy Playlists (YAML files)"
if (Test-Path "$SrcAssets\playlists") {
    try {
        $playlistCount = (Get-ChildItem "$SrcAssets\playlists" -Filter "*.yaml" -ErrorAction SilentlyContinue).Count
        if ($playlistCount -gt 0) {
            Copy-Item "$SrcAssets\playlists\*.yaml" "$ResourcesDir\playlists\" -Force -ErrorAction $EAStop
            $copiedFiles += $playlistCount
            Write-Log "  → Copied $playlistCount playlist files"
        }
    } catch {
        $buildErrors += "Playlists: $($_.Exception.Message)"
    }
}

# Copy top-level JSON config files (playlist-ids.json, content_tags.json, social-stats.json, tags.json)
$jsonFiles = @("playlist-ids.json", "content_tags.json", "social-stats.json", "tags.json")
# Ensure playlists target dir is defined and exists
$targetPlaylistsDir = Join-Path $ResourcesDir "playlists"
if (-not (Test-Path $targetPlaylistsDir)) { New-Item -ItemType Directory -Path $targetPlaylistsDir -Force | Out-Null }

foreach ($json in $jsonFiles) {
    $srcJson = Join-Path $SrcAssets $json
    $dstJson = Join-Path $targetPlaylistsDir $json
    if (Test-Path $srcJson) {
        try {
            # If destination doesn't exist, copy it. If it exists, only replace when source is newer
            $shouldCopy = $false
            $dstJson = Join-Path $targetPlaylistsDir $json
            if (-not (Test-Path $dstJson)) {
                $shouldCopy = $true
            } else {
                $srcText = Get-Content -Path $srcJson -Raw -ErrorAction SilentlyContinue
                $dstText = Get-Content -Path $dstJson -Raw -ErrorAction SilentlyContinue
                if ($srcText -ne $dstText) { $shouldCopy = $true }
            }

            if ($shouldCopy) {
                Copy-Item -Path $srcJson -Destination $dstJson -Force -ErrorAction $EAStop
                $copiedFiles += 1
                Write-Log "  → Copied/Updated $json to resources/playlists/"

                # For backward compatibility, keep playlist-ids.json at public_html root as well
                if ($json -eq 'playlist-ids.json') {
                    $publicRootJson = Join-Path $ProjectRoot 'public_html' | Join-Path -ChildPath $json
                    Copy-Item -Path $dstJson -Destination $publicRootJson -Force -ErrorAction $EAStop
                    Write-Log "  → Also copied playlist-ids.json to public_html/ for legacy consumers"
                }
            } else {
                Write-Log "  → Skipped $json (no changes)" "INFO"
            }

        } catch {
            $buildErrors += "$($json): $($_.Exception.Message)"
        }
    } else {
        # If src doesn't have the file but runtime has it, we leave runtime alone. If neither exist, log a warning.
        if (-not (Test-Path $dstJson)) {
            Write-Log "  ⚠️ $json not found in src/assets and not present in resources/playlists/" "WARN"
        } else {
            Write-Log "  → Using existing resources/playlists/$json (no src copy)" "INFO"
        }
    }
}

# Copy Images (if needed)
if (Test-Path "$SrcAssets\images") {
    try {
        $imageCount = (Get-ChildItem "$SrcAssets\images" -File -Recurse -ErrorAction SilentlyContinue).Count
        if ($imageCount -gt 0) {
            Copy-Item "$SrcAssets\images\*" "$ResourcesDir\images\" -Recurse -Force -ErrorAction $EAStop
            $copiedFiles += $imageCount
            Write-Log "  → Copied $imageCount image files"
        }
    } catch {
        $buildErrors += "Images: $($_.Exception.Message)"
    }
}

# Clean old .html files from public_html (legacy cleanup)
if ($Clean) {
    try {
        $PublicHtml = Join-Path $ProjectRoot "public_html"
        $htmlFiles = Get-ChildItem -Path $PublicHtml -Filter "*.html" -File -ErrorAction SilentlyContinue
        if ($htmlFiles.Count -gt 0) {
            $htmlFiles | Remove-Item -Force
            Write-Log "  → Removed $($htmlFiles.Count) legacy HTML files" "WARN"
        }
    } catch {
        $buildErrors += "HTML Cleanup: $($_.Exception.Message)"
    }
}

# Copy SVGs (if needed)
if (Test-Path "$SrcAssets\svgs") {
    try {
        $svgCount = (Get-ChildItem "$SrcAssets\svgs" -File -Recurse -ErrorAction SilentlyContinue).Count
        if ($svgCount -gt 0) {
            $targetSvgDir = Join-Path $ResourcesDir 'svgs'
            if (-not (Test-Path $targetSvgDir)) { New-Item -ItemType Directory -Path $targetSvgDir -Force | Out-Null }
            Copy-Item "$SrcAssets\svgs\*" "$targetSvgDir\" -Recurse -Force -ErrorAction $EAStop
            $copiedFiles += $svgCount
            Write-Log "  → Copied $svgCount SVG files"
        }
    } catch {
        $buildErrors += "SVGs: $($_.Exception.Message)"
    }
}

# Copy PDFs (if needed)
if (Test-Path "$SrcAssets\pdfs") {
    try {
        $pdfCount = (Get-ChildItem "$SrcAssets\pdfs" -File -Recurse -ErrorAction SilentlyContinue).Count
        if ($pdfCount -gt 0) {
            $targetPdfDir = Join-Path $ResourcesDir 'pdfs'
            if (-not (Test-Path $targetPdfDir)) { New-Item -ItemType Directory -Path $targetPdfDir -Force | Out-Null }
            Copy-Item "$SrcAssets\pdfs\*" "$targetPdfDir\" -Recurse -Force -ErrorAction $EAStop
            $copiedFiles += $pdfCount
            Write-Log "  → Copied $pdfCount PDF files"
        }
    } catch {
        $buildErrors += "PDFs: $($_.Exception.Message)"
    }
}

# Enforce exclusion of 'archived' and '!bak' folders from resources
# This ensures they never pollute the build or deployment
Write-Log "Enforcing exclusions (removing 'archived' and '!bak' folders)..."
$excludePatterns = @("archived", "!bak", "webfonts") # Added webfonts to legacy cleanup
foreach ($pattern in $excludePatterns) {
    try {
        $excludedDirs = Get-ChildItem -Path $ResourcesDir -Recurse -Directory -Filter $pattern -ErrorAction SilentlyContinue
        foreach ($dir in $excludedDirs) {
            # Special case: don't remove vendor/fontawesome/webfonts
            if ($dir.FullName -like "*vendor*") { continue }
            
            Remove-Item -Path $dir.FullName -Recurse -Force -ErrorAction SilentlyContinue
            Write-Log "  → Removed excluded/legacy directory: $($dir.FullName)" "SUCCESS"
        }
    } catch {
        $buildErrors += "Exclusion Cleanup: $($_.Exception.Message)"
    }
}

# Report errors if any
if ($buildErrors.Count -gt 0) {
    Write-Log "=== Errors Encountered ===" "ERROR"
    foreach ($buildErr in $buildErrors) {
        Write-Log "  ✗ $buildErr" "ERROR"
    }
}

Write-Log "Build complete! Total files copied: $copiedFiles" "SUCCESS"
Write-Log "=== Build Finished ===`n" "INFO"
