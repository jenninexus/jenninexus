#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Create placeholder thumbnails for empty Ludum Dare playlists
.DESCRIPTION
    Generates gradient placeholder images with text for playlists that have no videos
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
Write-Host "  Ludum Dare Placeholder Generator" -ForegroundColor Cyan
Write-Host "══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Define empty playlists that need placeholders
$playlists = @(
    @{
        id = "PL6WnzXOaRqA19W60NFfCJNJOrr4SBPkZe"
        title = "Ludum Dare Gameplay"
        subtitle = "Collection Coming Soon"
    },
    @{
        id = "PL6WnzXOaRqA3yKvAYjZ4Gja9__cfwG3Ii"
        title = "Ludum Dare 46"
        subtitle = "Keep It Alive"
    },
    @{
        id = "PL6WnzXOaRqA3l4G2qBFlSgm8Yv3-zZlL3"
        title = "Ludum Dare 44"
        subtitle = "Your Life Is Currency"
    },
    @{
        id = "PL6WnzXOaRqA2HN6SQkmpsqetJNwgyRUXZ"
        title = "Red Friday"
        subtitle = "Game Jam Submission"
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
    
    Write-Host "📸 Creating placeholder for:" -ForegroundColor Cyan
    Write-Host "   $($playlist.title)" -ForegroundColor White
    
    if ($useDrawing) {
        # Create image with System.Drawing
        $width = 1280
        $height = 720
        $bitmap = New-Object System.Drawing.Bitmap($width, $height)
        $graphics = [System.Drawing.Graphics]::FromImage($bitmap)
        
        # Orange to yellow gradient (Ludum Dare colors)
        $gradientBrush = New-Object System.Drawing.Drawing2D.LinearGradientBrush(
            (New-Object System.Drawing.Point(0, 0)),
            (New-Object System.Drawing.Point($width, $height)),
            [System.Drawing.Color]::FromArgb(255, 255, 107, 107),  # #ff6b6b
            [System.Drawing.Color]::FromArgb(255, 254, 202, 87)    # #feca57
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
            "gradient:#ff6b6b-#feca57"
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
Write-Host "  ✅ Done! Created $($playlists.Count) placeholders" -ForegroundColor Green
Write-Host "══════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "📂 Saved to: $ImagesDir" -ForegroundColor Cyan
