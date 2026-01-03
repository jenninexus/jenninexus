#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Download playlist thumbnails from YouTube
.DESCRIPTION
    Fetches the first video from each playlist and downloads its thumbnail
    Saves to public_html/resources/images/playlists/ for offline fallback
.EXAMPLE
    .\download-playlist-thumbnails.ps1
    .\download-playlist-thumbnails.ps1 -PlaylistId PL6WnzXOaRqA09bFvNzWaJa3q97w7bGo6c
#>

param(
    [string]$PlaylistId,
    [string]$YamlFile = "gaming.yaml"
)

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$ProjectRoot = Split-Path -Parent $PSScriptRoot
$PublicHtml = Join-Path $ProjectRoot "public_html"
$PlaylistsDir = Join-Path $PublicHtml "resources\playlists"
$ImagesDir = Join-Path $PublicHtml "resources\images\playlists"

# Create images directory if it doesn't exist
if (-not (Test-Path $ImagesDir)) {
    New-Item -ItemType Directory -Path $ImagesDir -Force | Out-Null
    Write-Host "✅ Created directory: $ImagesDir" -ForegroundColor Green
}

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  Playlist Thumbnail Downloader" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Function to get first video from YouTube playlist RSS
function Get-PlaylistFirstVideo {
    param([string]$PlaylistId)
    
    try {
        $rssUrl = "https://www.youtube.com/feeds/videos.xml?playlist_id=$PlaylistId"
        $response = Invoke-WebRequest -Uri $rssUrl -UseBasicParsing -TimeoutSec 10
        
        # Parse XML
        [xml]$xml = $response.Content
        $ns = @{
            atom = "http://www.w3.org/2005/Atom"
            media = "http://search.yahoo.com/mrss/"
            yt = "http://www.youtube.com/xml/schemas/2015"
        }
        
        # Get first video ID
        $firstEntry = Select-Xml -Xml $xml -XPath "//atom:entry[1]" -Namespace $ns
        if ($firstEntry) {
            $videoId = Select-Xml -Xml $firstEntry.Node -XPath ".//yt:videoId" -Namespace $ns
            return $videoId.Node.InnerText
        }
        
        return $null
    }
    catch {
        Write-Warning "Failed to fetch RSS for playlist $PlaylistId : $_"
        return $null
    }
}

# Function to download YouTube thumbnail
function Download-Thumbnail {
    param(
        [string]$VideoId,
        [string]$OutputPath
    )
    
    # Try different quality levels
    $qualities = @("maxresdefault", "sddefault", "hqdefault", "mqdefault")
    
    foreach ($quality in $qualities) {
        $thumbnailUrl = "https://img.youtube.com/vi/$VideoId/$quality.jpg"
        
        try {
            Invoke-WebRequest -Uri $thumbnailUrl -OutFile $OutputPath -UseBasicParsing -TimeoutSec 10
            
            # Check if image is valid (not a placeholder)
            $fileSize = (Get-Item $OutputPath).Length
            if ($fileSize -gt 1000) {  # Valid thumbnails are usually > 1KB
                Write-Host "  ✅ Downloaded $quality quality ($([math]::Round($fileSize/1KB, 2)) KB)" -ForegroundColor Green
                return $true
            }
        }
        catch {
            # Try next quality
            continue
        }
    }
    
    return $false
}

# Process single playlist or all playlists from YAML
if ($PlaylistId) {
    # Single playlist mode
    Write-Host "📥 Processing single playlist: $PlaylistId" -ForegroundColor Yellow
    
    $videoId = Get-PlaylistFirstVideo -PlaylistId $PlaylistId
    if ($videoId) {
        $outputFile = Join-Path $ImagesDir "$PlaylistId.jpg"
        Write-Host "📹 First video: $videoId"
        
        if (Download-Thumbnail -VideoId $videoId -OutputPath $outputFile) {
            Write-Host "✅ Saved thumbnail: $outputFile" -ForegroundColor Green
        }
        else {
            Write-Host "❌ Failed to download thumbnail" -ForegroundColor Red
        }
    }
    else {
        Write-Host "❌ Could not find videos in playlist" -ForegroundColor Red
    }
}
else {
    # Process all playlists from YAML file
    $yamlPath = Join-Path $PlaylistsDir $YamlFile
    
    if (-not (Test-Path $yamlPath)) {
        Write-Host "❌ YAML file not found: $yamlPath" -ForegroundColor Red
        exit 1
    }
    
    Write-Host "📄 Reading playlists from: $YamlFile" -ForegroundColor Yellow
    Write-Host ""
    
    # Simple YAML parser for playlist IDs
    $content = Get-Content $yamlPath -Raw
    $playlists = [regex]::Matches($content, 'id:\s*"([^"]+)"')
    
    $totalPlaylists = $playlists.Count
    $downloaded = 0
    $skipped = 0
    $failed = 0
    
    Write-Host "Found $totalPlaylists playlists to process" -ForegroundColor Cyan
    Write-Host ""
    
    foreach ($match in $playlists) {
        $playlistId = $match.Groups[1].Value
        $outputFile = Join-Path $ImagesDir "$playlistId.jpg"
        
        Write-Host "[$($downloaded + $skipped + $failed + 1)/$totalPlaylists] Processing: $playlistId" -ForegroundColor Cyan
        
        # Skip if thumbnail already exists
        if (Test-Path $outputFile) {
            Write-Host "  ⏭️  Already exists, skipping" -ForegroundColor Gray
            $skipped++
            continue
        }
        
        # Get first video from playlist
        $videoId = Get-PlaylistFirstVideo -PlaylistId $playlistId
        
        if ($videoId) {
            Write-Host "  📹 First video: $videoId"
            
            if (Download-Thumbnail -VideoId $videoId -OutputPath $outputFile) {
                $downloaded++
            }
            else {
                Write-Host "  ❌ Failed to download" -ForegroundColor Red
                $failed++
            }
        }
        else {
            Write-Host "  ❌ Could not find videos" -ForegroundColor Red
            $failed++
        }
        
        Write-Host ""
        
        # Rate limit: wait 1 second between requests
        Start-Sleep -Seconds 1
    }
    
    Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
    Write-Host "  Summary" -ForegroundColor Cyan
    Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "✅ Downloaded: $downloaded" -ForegroundColor Green
    Write-Host "⏭️  Skipped: $skipped" -ForegroundColor Gray
    Write-Host "❌ Failed: $failed" -ForegroundColor Red
    Write-Host ""
    Write-Host "📂 Thumbnails saved to: $ImagesDir" -ForegroundColor Cyan
}
