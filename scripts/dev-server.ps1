#!/usr/bin/env pwsh
<#
.SYNOPSIS
    JenniNexus Local Development Server
.DESCRIPTION
    Starts PHP built-in server on port 8002 from public_html directory
    Processes PHP files and supports clean URLs
.EXAMPLE
    .\dev-server.ps1
#>

param(
    [int]$Port = 8002,
    [switch]$Build
)

# Set strict mode
Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

# Project paths
$ProjectRoot = Split-Path -Parent $PSScriptRoot
$PublicHtml = Join-Path $ProjectRoot "public_html"

Write-Host "===============================================================" -ForegroundColor Cyan
Write-Host "  JenniNexus Development Server" -ForegroundColor Cyan
Write-Host "===============================================================" -ForegroundColor Cyan
Write-Host ""

# Check if public_html exists
if (-not (Test-Path $PublicHtml)) {
    Write-Host "Error: public_html directory not found at:" -ForegroundColor Red
    Write-Host "   $PublicHtml" -ForegroundColor Red
    exit 1
}

# Optional: Run build first
if ($Build) {
    Write-Host "Building SCSS..." -ForegroundColor Yellow
    & "$PSScriptRoot\build.ps1"
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Build failed!" -ForegroundColor Red
        exit 1
    }
    Write-Host "Build complete!" -ForegroundColor Green
    Write-Host ""
}

# Check if PHP is installed
$phpPath = Get-Command php -ErrorAction SilentlyContinue
if (-not $phpPath) {
    Write-Host "Error: PHP is not installed or not in PATH" -ForegroundColor Red
    Write-Host "   Please install PHP from: https://windows.php.net/download/" -ForegroundColor Yellow
    Write-Host "   Or use Chocolatey: choco install php" -ForegroundColor Yellow
    exit 1
}

$phpVersion = php -v | Select-Object -First 1
Write-Host "PHP Found: $phpVersion" -ForegroundColor Green
Write-Host ""

# Change to public_html directory
Set-Location $PublicHtml

Write-Host "Server Directory: $PublicHtml" -ForegroundColor White
Write-Host "Server URL: http://localhost:$Port" -ForegroundColor Green
Write-Host "Designated Port: 8002 (JenniNexus)" -ForegroundColor Magenta
Write-Host ""
Write-Host "Available Pages:" -ForegroundColor Yellow
Write-Host "   - http://localhost:$Port/               (Home - index.php)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/gamedev.php    (Game Dev)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/diy.php        (DIY)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/music.php      (Music)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/blog.php       (Blog)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/links.php      (Links)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/resume.php     (Resume)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/services.php   (Services)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/patreon.php    (Patreon)" -ForegroundColor Gray
Write-Host "   - http://localhost:$Port/live.php       (Live)" -ForegroundColor Gray
Write-Host ""
Write-Host "Note: PHP files are processed server-side" -ForegroundColor Cyan
Write-Host "   Bootstrap 5.3.8 with SRI hashes enabled" -ForegroundColor Cyan
Write-Host ""
Write-Host "Press Ctrl+C to stop server..." -ForegroundColor Yellow
Write-Host ""

# Start PHP built-in server with router
$routerFile = Join-Path $PublicHtml "router.php"
try {
    if (Test-Path $routerFile) {
        php -S localhost:$Port -t $PublicHtml $routerFile
    } else {
        php -S localhost:$Port -t $PublicHtml
    }
} catch {
    Write-Host ""
    Write-Host "Server stopped or error occurred" -ForegroundColor Red
    Write-Host $_.Exception.Message -ForegroundColor Red
    exit 1
}
