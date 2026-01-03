#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Fetch all playlists from JenniPlaysGames YouTube channel
.DESCRIPTION
    Uses YouTube Data API v3 to list all public playlists with titles and IDs
    Output can be used to update gaming.yaml
.EXAMPLE
    .\fetch-gaming-playlists.ps1
#>

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

# Load YouTube API key
$secretsPath = Join-Path (Split-Path -Parent $PSScriptRoot) "storage\secrets\youtube.json"
if (-not (Test-Path $secretsPath)) {
    Write-Host "❌ Error: youtube.json not found at $secretsPath" -ForegroundColor Red
    exit 1
}

$secrets = Get-Content $secretsPath -Raw | ConvertFrom-Json
$apiKey = $secrets.youtube_api_key

if (-not $apiKey) {
    Write-Host "❌ Error: No API key found in youtube.json" -ForegroundColor Red
    exit 1
}

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  🎮 Fetch JenniPlaysGames Playlists" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# JenniPlaysGames channel ID (from gaming.yaml)
$channelId = "UC4byqahPWuY9WPJNvDgbQMQ"

Write-Host "📡 Fetching playlists from channel: $channelId" -ForegroundColor Yellow
Write-Host ""

# Fetch playlists from YouTube API
$playlists = @()
$pageToken = $null
$totalFetched = 0

do {
    $url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&channelId=$channelId&maxResults=50&key=$apiKey"
    if ($pageToken) {
        $url += "&pageToken=$pageToken"
    }

    try {
        Write-Host "🔍 Fetching page..." -ForegroundColor Gray
        $response = Invoke-RestMethod -Uri $url -Method Get
        
        foreach ($item in $response.items) {
            $playlist = [PSCustomObject]@{
                Id = $item.id
                Title = $item.snippet.title
                Description = $item.snippet.description
                VideoCount = $item.contentDetails.itemCount
                Published = $item.snippet.publishedAt
            }
            $playlists += $playlist
            $totalFetched++
        }

        $pageToken = $response.nextPageToken
    }
    catch {
        Write-Host "❌ Error fetching playlists: $($_.Exception.Message)" -ForegroundColor Red
        exit 1
    }
} while ($pageToken)

Write-Host "✅ Fetched $totalFetched playlists!" -ForegroundColor Green
Write-Host ""
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  📋 PLAYLISTS" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Sort by most recent first
$playlists = $playlists | Sort-Object Published -Descending

# Display playlists
foreach ($playlist in $playlists) {
    Write-Host "Title: " -NoNewline -ForegroundColor Yellow
    Write-Host $playlist.Title
    Write-Host "  ID: " -NoNewline -ForegroundColor Cyan
    Write-Host $playlist.Id
    Write-Host "  Videos: " -NoNewline -ForegroundColor Gray
    Write-Host "$($playlist.VideoCount) videos"
    Write-Host "  URL: " -NoNewline -ForegroundColor Green
    Write-Host "https://www.youtube.com/playlist?list=$($playlist.Id)"
    if ($playlist.Description) {
        $desc = $playlist.Description.Substring(0, [Math]::Min(80, $playlist.Description.Length))
        if ($playlist.Description.Length -gt 80) { $desc += "..." }
        Write-Host "  Desc: $desc" -ForegroundColor DarkGray
    }
    Write-Host ""
}

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  📝 YAML FORMAT" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Generate YAML format
Write-Host "# Copy this into gaming.yaml featured_section.playlists:" -ForegroundColor Green
Write-Host ""

foreach ($playlist in $playlists) {
    Write-Host "    - id: `"$($playlist.Id)`""
    Write-Host "      title: `"$($playlist.Title)`""
    Write-Host "      icon: `"star`"  # Change icon"
    if ($playlist.Description) {
        $desc = $playlist.Description.Replace("`n", " ").Replace("`r", "").Trim()
        $desc = $desc.Substring(0, [Math]::Min(100, $desc.Length))
        Write-Host "      description: `"$desc`""
    }
    Write-Host "      tags: [`"gaming`"]  # Add relevant tags"
    Write-Host ""
}

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "💡 Next Steps:" -ForegroundColor Yellow
Write-Host "  1. Review the playlist list above" -ForegroundColor White
Write-Host "  2. Copy the YAML format section" -ForegroundColor White
Write-Host "  3. Paste into gaming.yaml (replace or add to featured_section.playlists)" -ForegroundColor White
Write-Host "  4. Update icons, descriptions, and tags as needed" -ForegroundColor White
Write-Host "  5. Save and refresh http://localhost:8002/gaming.php" -ForegroundColor White
Write-Host ""
Write-Host "📊 Summary: Found $totalFetched playlists" -ForegroundColor Cyan
Write-Host ""

# Optionally save to file
$outputPath = Join-Path (Split-Path -Parent $PSScriptRoot) "storage\gaming-playlists-export.txt"
$output = @"
# JenniPlaysGames Channel Playlists
# Fetched: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")
# Total: $totalFetched playlists

"@

foreach ($playlist in $playlists) {
    $output += @"
Title: $($playlist.Title)
ID: $($playlist.Id)
URL: https://www.youtube.com/playlist?list=$($playlist.Id)
Videos: $($playlist.VideoCount)
Published: $($playlist.Published)
Description: $($playlist.Description)

"@
}

$output | Out-File -FilePath $outputPath -Encoding UTF8
Write-Host "💾 Full list saved to: $outputPath" -ForegroundColor Green
Write-Host ""
