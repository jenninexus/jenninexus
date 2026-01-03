#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Scrape playlist names from YouTube pages (no API needed)
#>

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

Write-Host "════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  🎮 Scraping Playlist Names from YouTube" -ForegroundColor Cyan
Write-Host "════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "📡 Fetching $($playlistIds.Count) playlist pages..." -ForegroundColor Yellow
Write-Host ""

$playlists = @()

foreach ($id in $playlistIds) {
    try {
        $url = "https://www.youtube.com/playlist?list=$id"
        $response = Invoke-WebRequest -Uri $url -UseBasicParsing
        
        # Try to extract title from page
        if ($response.Content -match '<title>([^<]+)</title>') {
            $title = $matches[1] -replace ' - YouTube$', ''
            $playlist = [PSCustomObject]@{
                Id = $id
                Title = $title
                Url = $url
            }
            $playlists += $playlist
            Write-Host "✅ " -NoNewline -ForegroundColor Green
            Write-Host $title -ForegroundColor White
        } else {
            Write-Host "⚠️  Could not extract title for: $id" -ForegroundColor Yellow
        }
        
        Start-Sleep -Milliseconds 500  # Be nice to YouTube
    }
    catch {
        Write-Host "❌ Error: $id" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  📝 YAML FORMAT" -ForegroundColor Cyan
Write-Host "════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

foreach ($playlist in $playlists) {
    Write-Host "    - id: `"$($playlist.Id)`""
    Write-Host "      title: `"$($playlist.Title)`""
    Write-Host "      icon: `"star`""
    Write-Host "      tags: [`"gaming`"]"
    Write-Host ""
}

Write-Host "✅ Found $($playlists.Count)/$($playlistIds.Count) playlists!" -ForegroundColor Green
