#!/usr/bin/env pwsh
<#
.SYNOPSIS
    JenniNexus File Watcher - Auto-rebuild on src/assets changes
    
.DESCRIPTION
    Watches src/assets/ directory for changes and runs build.ps1 automatically
    - Monitors CSS, JS, YAML, JSON, SVG, image files
    - Debounces rapid file saves (2 second delay)
    - Starts dev server in background on port 8002
    - Opens browser automatically (use -NoBrowser to skip)
    
.PARAMETER Port
    Dev server port (default: 8002 - JenniNexus designated port)
    
.PARAMETER NoBrowser
    Skip opening browser on startup
    
.EXAMPLE
    .\scripts\watch.ps1
    Start watcher + dev server, open browser
    
.EXAMPLE
    .\scripts\watch.ps1 -NoBrowser
    Start watcher + dev server, don't open browser
    
.NOTES
    - Press Ctrl+C to stop both watcher and dev server
    - Watches: *.css, *.js, *.yaml, *.json, *.svg, *.png, *.jpg, *.jpeg
    - Debounce: 2 seconds (prevents multiple builds from rapid saves)
    - Logs to console with color-coded messages
    - Automatically cleans up background jobs on exit
#>

param(
    [int]$Port = 8002,
    [switch]$NoBrowser
)

$ProjectRoot = Split-Path -Parent $PSScriptRoot
$WatchPath = Join-Path $ProjectRoot "src\assets"
$BuildScript = Join-Path $PSScriptRoot "build.ps1"
$DevServerScript = Join-Path $PSScriptRoot "dev-server.ps1"

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  👀 JenniNexus File Watcher" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "👀 Watching: $WatchPath" -ForegroundColor Yellow
Write-Host "🔨 Build Script: build.ps1" -ForegroundColor Cyan
Write-Host "🌐 Dev Server: http://localhost:$Port" -ForegroundColor Green
Write-Host "📂 Working Directory: public_html/" -ForegroundColor White
Write-Host ""

# Check if watch path exists
if (-not (Test-Path $WatchPath)) {
    Write-Host "❌ Error: Watch path not found: $WatchPath" -ForegroundColor Red
    Write-Host "   Create src/assets/ directory first" -ForegroundColor Yellow
    exit 1
}

# Check if build script exists
if (-not (Test-Path $BuildScript)) {
    Write-Host "❌ Error: Build script not found: $BuildScript" -ForegroundColor Red
    exit 1
}

# Start dev server in background job
Write-Host "🚀 Starting dev server..." -ForegroundColor Cyan
$devServerJob = Start-Job -ScriptBlock {
    param($Script, $Port)
    & pwsh -File $Script -Port $Port
} -ArgumentList $DevServerScript, $Port

# Wait a moment for server to start
Start-Sleep -Seconds 1

# Check if server started successfully
if ($devServerJob.State -eq 'Running') {
    Write-Host "✅ Dev server started (Job ID: $($devServerJob.Id))" -ForegroundColor Green
} else {
    Write-Host "❌ Dev server failed to start" -ForegroundColor Red
    Receive-Job -Job $devServerJob
    Remove-Job -Job $devServerJob
    exit 1
}

Write-Host ""

# Open browser (optional)
if (-not $NoBrowser) {
    Write-Host "🌐 Opening browser..." -ForegroundColor Cyan
    Start-Sleep -Seconds 2
    Start-Process "http://localhost:$Port"
    Write-Host ""
}

# Create file watcher
Write-Host "🔍 Initializing file watcher..." -ForegroundColor Cyan
$watcher = New-Object System.IO.FileSystemWatcher
$watcher.Path = $WatchPath
$watcher.IncludeSubdirectories = $true
$watcher.EnableRaisingEvents = $true
$watcher.NotifyFilter = [System.IO.NotifyFilters]::FileName -bor 
                        [System.IO.NotifyFilters]::LastWrite -bor
                        [System.IO.NotifyFilters]::CreationTime

# Watch for CSS, JS, YAML, JSON, SVG, image changes
$watcher.Filter = "*.*"

# Debounce mechanism (prevent multiple builds from rapid saves)
$script:lastBuild = [DateTime]::MinValue
$debounceSeconds = 2

# Event handler for file changes
$onChanged = {
    param($source, $e)
    
    # Only build for relevant file types
    $ext = [System.IO.Path]::GetExtension($e.Name).ToLower()
    $relevantExtensions = @('.css', '.js', '.yaml', '.yml', '.json', '.svg', '.png', '.jpg', '.jpeg', '.gif', '.webp')
    
    if ($ext -notin $relevantExtensions) {
        return
    }
    
    # Skip minified files and map files
    if ($e.Name -like "*.min.*" -or $e.Name -like "*.map") {
        return
    }
    
    # Debounce check
    $now = [DateTime]::Now
    if (($now - $script:lastBuild).TotalSeconds -lt $debounceSeconds) {
        return
    }
    $script:lastBuild = $now
    
    # Determine change type
    $changeType = switch ($e.ChangeType) {
        'Changed' { 'Modified' }
        'Created' { 'Created' }
        'Renamed' { 'Renamed' }
        'Deleted' { 'Deleted' }
        default { $e.ChangeType }
    }
    
    Write-Host "`n────────────────────────────────────────────────────────" -ForegroundColor Gray
    Write-Host "🔄 $changeType`: $($e.Name)" -ForegroundColor Yellow
    Write-Host "🔨 Running build..." -ForegroundColor Cyan
    
    $buildStart = Get-Date
    
    try {
        # Run build script and capture output
        $buildOutput = & pwsh -File $BuildScript 2>&1
        $buildDuration = ((Get-Date) - $buildStart).TotalSeconds
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Build complete! ($([math]::Round($buildDuration, 2))s)" -ForegroundColor Green
            
            # Show relevant build output (skip verbose lines)
            $importantLines = $buildOutput | Where-Object { 
                $_ -match "Copied|Minified|ERROR|WARNING|SUCCESS" -and 
                $_ -notmatch "SKIPPED|up-to-date"
            }
            
            if ($importantLines) {
                Write-Host "📦 Changes:" -ForegroundColor Cyan
                $importantLines | ForEach-Object {
                    Write-Host "   $_" -ForegroundColor Gray
                }
            }
        } else {
            Write-Host "❌ Build failed!" -ForegroundColor Red
            Write-Host $buildOutput -ForegroundColor Red
        }
    } catch {
        Write-Host "❌ Build error: $($_.Exception.Message)" -ForegroundColor Red
    }
    
    Write-Host "👀 Watching for changes..." -ForegroundColor Yellow
}

# Register event handlers
$handlers = @()
$handlers += Register-ObjectEvent -InputObject $watcher -EventName Changed -Action $onChanged
$handlers += Register-ObjectEvent -InputObject $watcher -EventName Created -Action $onChanged
$handlers += Register-ObjectEvent -InputObject $watcher -EventName Renamed -Action $onChanged

Write-Host "✅ File watcher active!" -ForegroundColor Green
Write-Host ""
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  📝 Edit files in src/assets/ to trigger auto-build" -ForegroundColor White
Write-Host "  🌐 Dev server running at http://localhost:$Port" -ForegroundColor White
Write-Host "  ⏹️  Press Ctrl+C to stop watcher and dev server" -ForegroundColor White
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "👀 Watching for changes..." -ForegroundColor Yellow

# Keep script running and monitor dev server
try {
    while ($true) {
        Start-Sleep -Seconds 1
        
        # Check if dev server job is still running
        if ($devServerJob.State -ne 'Running') {
            Write-Host "`n❌ Dev server stopped unexpectedly" -ForegroundColor Red
            
            # Get any output from failed server
            $serverOutput = Receive-Job -Job $devServerJob
            if ($serverOutput) {
                Write-Host "Server output:" -ForegroundColor Yellow
                Write-Host $serverOutput -ForegroundColor Gray
            }
            break
        }
        
        # Check for any watcher errors
        foreach ($handler in $handlers) {
            if ($handler.State -eq 'Failed') {
                Write-Host "`n❌ File watcher error detected" -ForegroundColor Red
                break
            }
        }
    }
} catch {
    # Ctrl+C or other interrupt
    Write-Host "`n🛑 Interrupt received..." -ForegroundColor Yellow
} finally {
    # Cleanup
    Write-Host "`n🛑 Stopping file watcher..." -ForegroundColor Yellow
    
    # Disable watcher
    $watcher.EnableRaisingEvents = $false
    $watcher.Dispose()
    
    # Unregister event handlers
    foreach ($handler in $handlers) {
        try {
            Unregister-Event -SourceIdentifier $handler.Name -ErrorAction SilentlyContinue
        } catch {
            # Ignore errors during cleanup
        }
    }
    
    Write-Host "🛑 Stopping dev server..." -ForegroundColor Yellow
    
    # Stop dev server job
    if ($devServerJob) {
        Stop-Job -Job $devServerJob -ErrorAction SilentlyContinue
        Remove-Job -Job $devServerJob -ErrorAction SilentlyContinue
    }
    
    Write-Host "✅ Cleanup complete" -ForegroundColor Green
    Write-Host ""
    Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
    Write-Host "  👋 JenniNexus File Watcher Stopped" -ForegroundColor Cyan
    Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
}
