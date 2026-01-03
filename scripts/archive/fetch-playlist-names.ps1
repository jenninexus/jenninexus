#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Fetch playlist names from YouTube playlist IDs
#>

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

# Playlist IDs from user's list
$playlistIds = @(
    "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep",
    "PL6WnzXOaRqA0AmWzg6b12-8O4eRifnTRC",
    "PL6WnzXOaRqA16OQ60_EcUZ0Y8tjHB73Gi",
    "PL6WnzXOaRqA09bFvNzWaJa3q97w7bGo6c",
    "PL6WnzXOaRqA19W60NFfCJNJOrr4SBPkZe",
    "PL6WnzXOaRqA3yKvAYjZ4Gja9__cfwG3Ii",
    "PL6WnzXOaRqA3pXypZTl65mYKnSy0eC8cG",
    "PL6WnzXOaRqA0nMzZ_iOGxUpxdvYJIBap8",
    "PL6WnzXOaRqA0laP8POd37FfKmh_lkr4FN",
    "PL6WnzXOaRqA0MiE5cffmM2ZZcuSTl9DcS",
    "PL6WnzXOaRqA3l4G2qBFlSgm8Yv3-zZlL3",
    "PL6WnzXOaRqA3vuLsU1KgCJNySY_CHDByN",
    "PL6WnzXOaRqA15NmslIKkGhX-uTqbKjwC-",
    "PL6WnzXOaRqA35cPcERn6qwjx92i1PrXfb",
    "PL6WnzXOaRqA3PDrywv-oe88ZjSdCfEnJa",
    "PL6WnzXOaRqA3UuVTTT-4v6CGS3FD4SlSl",
    "PL6WnzXOaRqA3jKLBqMuntlPHewF1jvl5c",
    "PL6WnzXOaRqA0qconj5DXBRn1BbjTsh-La",
    "PL6WnzXOaRqA2UVHD5gMNAqvBZ_7_cjnWQ",
    "PL6WnzXOaRqA3wr2EWmwo7_v--glFo0Qwk",
    "PL6WnzXOaRqA1E_JpXdwR_FVBFz9Mo_808",
    "PL6WnzXOaRqA0TU01Qs7tR0AFEjqFnlSVr",
    "PL6WnzXOaRqA1EIQeodJsyu256lzjzJcCK",
    "PL6WnzXOaRqA2iRZTiNSFIXkmhTAAZ0GVJ",
    "PL6WnzXOaRqA15_KprTTYjVf8ERVO4F-hl",
    "PL6WnzXOaRqA3CdHVSiGIsuMt0mB04ZpdF",
    "PL6WnzXOaRqA0cTClXMfa1TC_zf0qw_77W",
    "PL6WnzXOaRqA1bMG-O_gSlUIdFJCRzF4ki",
    "PL6WnzXOaRqA2HN6SQkmpsqetJNwgyRUXZ",
    "PL6WnzXOaRqA1_RuR0QpR-dZJiZBlUbU58"
)

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  🎮 Fetching Playlist Names from YouTube" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

# Load YouTube API key
$secretsPath = Join-Path (Split-Path -Parent $PSScriptRoot) "storage\secrets\youtube.json"
$secrets = Get-Content $secretsPath -Raw | ConvertFrom-Json
$apiKey = $secrets.youtube_api_key

Write-Host "📡 Fetching details for $($playlistIds.Count) playlists..." -ForegroundColor Yellow
Write-Host ""

$playlists = @()

foreach ($id in $playlistIds) {
    try {
        $url = "https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&id=$id&key=$apiKey"
        $response = Invoke-RestMethod -Uri $url -Method Get
        
        if ($response.items -and $response.items.Count -gt 0) {
            $item = $response.items[0]
            $playlist = [PSCustomObject]@{
                Id = $id
                Title = $item.snippet.title
                Description = $item.snippet.description
                VideoCount = $item.contentDetails.itemCount
            }
            $playlists += $playlist
            Write-Host "✅ " -NoNewline -ForegroundColor Green
            Write-Host $playlist.Title -ForegroundColor White
        } else {
            Write-Host "⚠️  No data for playlist: $id" -ForegroundColor Yellow
        }
        
        Start-Sleep -Milliseconds 100  # Rate limiting
    }
    catch {
        Write-Host "❌ Error fetching $id : $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  📝 YAML FORMAT FOR gaming.yaml" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

Write-Host "featured_section:" -ForegroundColor Green
Write-Host "  title: `"Gaming Playlists`"" -ForegroundColor Green
Write-Host "  icon: `"controller`"" -ForegroundColor Green
Write-Host "  playlists:" -ForegroundColor Green

foreach ($playlist in $playlists) {
    Write-Host "    - id: `"$($playlist.Id)`""
    Write-Host "      title: `"$($playlist.Title)`""
    Write-Host "      icon: `"star`"  # Change icon as needed"
    if ($playlist.Description) {
        $desc = $playlist.Description.Replace("`n", " ").Replace("`r", "").Trim()
        $desc = $desc.Substring(0, [Math]::Min(100, $desc.Length))
        if ($desc) {
            Write-Host "      description: `"$desc`""
        }
    }
    Write-Host "      tags: [`"gaming`"]  # Add relevant tags"
    Write-Host ""
}

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "✅ Found $($playlists.Count) playlists!" -ForegroundColor Green
Write-Host ""
Write-Host "💾 Saving to: storage\gaming-playlists-full.yaml" -ForegroundColor Cyan

# Save to file
$outputPath = Join-Path (Split-Path -Parent $PSScriptRoot) "storage\gaming-playlists-full.yaml"
$yamlOutput = @"
# JenniPlaysGames Gaming Playlists
# Generated: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")
# Total: $($playlists.Count) playlists

featured_section:
  title: "Gaming Playlists"
  icon: "controller"
  playlists:
"@

foreach ($playlist in $playlists) {
    $desc = if ($playlist.Description) {
        $d = $playlist.Description.Replace("`n", " ").Replace("`r", "").Trim()
        $d.Substring(0, [Math]::Min(100, $d.Length))
    } else { "" }
    
    $yamlOutput += @"

    - id: "$($playlist.Id)"
      title: "$($playlist.Title)"
      icon: "star"
      description: "$desc"
      tags: ["gaming"]
"@
}

$yamlOutput | Out-File -FilePath $outputPath -Encoding UTF8
Write-Host "✅ Saved!" -ForegroundColor Green
Write-Host ""
