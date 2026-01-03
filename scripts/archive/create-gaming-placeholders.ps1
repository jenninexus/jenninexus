#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Create placeholder thumbnails for empty gaming playlists
.DESCRIPTION
    Generates gradient placeholder images with gaming-themed text for playlists that have no videos
#>

param(
    [Parameter(Mandatory=$false)]
    [string]$OutputDir = "public_html\resources\images\playlists"
)

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$ProjectRoot = Split-Path -Parent $PSScriptRoot
$ImagesDir = Join-Path $ProjectRoot $OutputDir

# Create directory if it doesn't exist
if (-not (Test-Path $ImagesDir)) {
    New-Item -ItemType Directory -Path $ImagesDir -Force | Out-Null
}

Write-Host "══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  Gaming Playlist Placeholder Generator" -ForegroundColor Cyan
Write-Host "══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Define empty playlists that need placeholders (from failed downloads)
$playlists = @(
    @{
        id = "PL6WnzXOaRqA09bFvNzWaJa3q97w7bGo6c"
        title = "Ori & Will of Wisps"
        subtitle = "Gameplay Coming Soon"
    },
    @{
        id = "PL6WnzXOaRqA0laP8POd37FfKmh_lkr4FN"
        title = "Apex Legends"
        subtitle = "Battle Royale Action"
    },
    @{
        id = "PL6WnzXOaRqA0MiE5cffmM2ZZcuSTl9DcS"
        title = "Batman Arkham Knight"
        subtitle = "Dark Knight Adventures"
    },
    @{
        id = "PL6WnzXOaRqA15NmslIKkGhX-uTqbKjwC-"
        title = "Dead Island"
        subtitle = "Zombie Survival"
    },
    @{
        id = "PL6WnzXOaRqA3UuVTTT-4v6CGS3FD4SlSl"
        title = "Detroit Become Human"
        subtitle = "Interactive Drama"
    },
    @{
        id = "PL6WnzXOaRqA3jKLBqMuntlPHewF1jvl5c"
        title = "Destiny 2"
        subtitle = "Sci-Fi Shooter"
    },
    @{
        id = "PL6WnzXOaRqA0qconj5DXBRn1BbjTsh-La"
        title = "Elden Ring"
        subtitle = "Epic Fantasy"
    },
    @{
        id = "PL6WnzXOaRqA2UVHD5gMNAqvBZ_7_cjnWQ"
        title = "Fallout 4"
        subtitle = "Post-Apocalyptic RPG"
    },
    @{
        id = "PL6WnzXOaRqA3wr2EWmwo7_v--glFo0Qwk"
        title = "Friday 13th"
        subtitle = "Horror Survival"
    },
    @{
        id = "PL6WnzXOaRqA1E_JpXdwR_FVBFz9Mo_808"
        title = "God of War"
        subtitle = "Norse Mythology"
    },
    @{
        id = "PL6WnzXOaRqA0TU01Qs7tR0AFEjqFnlSVr"
        title = "Lies of P"
        subtitle = "Souls-like Action"
    },
    @{
        id = "PL6WnzXOaRqA1EIQeodJsyu256lzjzJcCK"
        title = "Outlast"
        subtitle = "Horror Survival"
    },
    @{
        id = "PL6WnzXOaRqA1bMG-O_gSlUIdFJCRzF4ki"
        title = "Steam Deck"
        subtitle = "Handheld Gaming"
    }
)

# Check if System.Drawing is available (Windows PowerShell)
try {
    Add-Type -AssemblyName System.Drawing
    $useDrawing = $true
} catch {
    $useDrawing = $false
}

if (-not $useDrawing) {
    Write-Host "⚠️  System.Drawing not available - using ImageMagick fallback" -ForegroundColor Yellow
    Write-Host ""
    
    # Check for ImageMagick
    $magick = Get-Command "magick" -ErrorAction SilentlyContinue
    if (-not $magick) {
        Write-Host "❌ ImageMagick not found. Please install it or run this script with Windows PowerShell (not PowerShell Core)" -ForegroundColor Red
        Write-Host ""
        Write-Host "Install ImageMagick: choco install imagemagick" -ForegroundColor Gray
        Write-Host "Or download: https://imagemagick.org/script/download.php" -ForegroundColor Gray
        exit 1
    }
}

foreach ($playlist in $playlists) {
    $outputFile = Join-Path $ImagesDir "$($playlist.id).jpg"
    
    # Skip if already exists
    if (Test-Path $outputFile) {
        Write-Host "⏭️  $($playlist.title): Already exists, skipping" -ForegroundColor Gray
        continue
    }
    
    Write-Host "📸 Creating placeholder for:" -ForegroundColor Cyan
    Write-Host "   $($playlist.title)" -ForegroundColor White
    
    if ($useDrawing) {
        # Create image with System.Drawing
        $width = 1280
        $height = 720
        $bitmap = New-Object System.Drawing.Bitmap($width, $height)
        $graphics = [System.Drawing.Graphics]::FromImage($bitmap)
        
        # Purple to dark purple gradient (gaming theme)
        $gradientBrush = New-Object System.Drawing.Drawing2D.LinearGradientBrush(
            (New-Object System.Drawing.Point(0, 0)),
            (New-Object System.Drawing.Point($width, $height)),
            [System.Drawing.Color]::FromArgb(255, 102, 126, 234),  # #667eea
            [System.Drawing.Color]::FromArgb(255, 118, 75, 162)    # #764ba2
        )
        
        $graphics.FillRectangle($gradientBrush, 0, 0, $width, $height)
        
        # Add text
        $graphics.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAlias
        
        # Title
        $fontTitle = New-Object System.Drawing.Font("Arial", 72, [System.Drawing.FontStyle]::Bold)
        $brushWhite = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::White)
        $format = New-Object System.Drawing.StringFormat
        $format.Alignment = [System.Drawing.StringAlignment]::Center
        $format.LineAlignment = [System.Drawing.StringAlignment]::Center
        
        $graphics.DrawString($playlist.title, $fontTitle, $brushWhite, ($width / 2), ($height / 2) - 40, $format)
        
        # Subtitle
        $fontSubtitle = New-Object System.Drawing.Font("Arial", 36)
        $graphics.DrawString($playlist.subtitle, $fontSubtitle, $brushWhite, ($width / 2), ($height / 2) + 60, $format)
        
        # Save
        $bitmap.Save($outputFile, [System.Drawing.Imaging.ImageFormat]::Jpeg)
        
        # Cleanup
        $graphics.Dispose()
        $bitmap.Dispose()
        $gradientBrush.Dispose()
        $brushWhite.Dispose()
        $fontTitle.Dispose()
        $fontSubtitle.Dispose()
        
        Write-Host "   ✅ Saved: $outputFile" -ForegroundColor Green
    }
    else {
        # Use ImageMagick
        $magickCmd = @(
            "convert"
            "-size", "1280x720"
            "gradient:#667eea-#764ba2"
            "-gravity", "center"
            "-pointsize", "72"
            "-font", "Arial-Bold"
            "-fill", "white"
            "-annotate", "+0-40", $playlist.title
            "-pointsize", "36"
            "-font", "Arial"
            "-annotate", "+0+60", $playlist.subtitle
            $outputFile
        )
        
        & magick @magickCmd
        Write-Host "   ✅ Saved: $outputFile" -ForegroundColor Green
    }
    
    Write-Host ""
}

Write-Host "══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  ✅ Done! Created placeholders for empty playlists" -ForegroundColor Green
Write-Host "══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "📂 Saved to: $ImagesDir" -ForegroundColor Cyan
