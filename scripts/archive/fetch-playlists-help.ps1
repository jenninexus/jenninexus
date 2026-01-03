#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Fetch playlists from JenniPlaysGames using channel handle
.DESCRIPTION
    Alternative method to list playlists when API key has restrictions
#>

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "  🎮 JenniPlaysGames Playlist Helper" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

Write-Host "⚠️  YouTube API returned 403 (Forbidden)" -ForegroundColor Yellow
Write-Host ""
Write-Host "This usually means:" -ForegroundColor Gray
Write-Host "  • API key has restrictions (IP, referrer, or API limits)" -ForegroundColor Gray
Write-Host "  • YouTube Data API v3 is not enabled in Google Console" -ForegroundColor Gray
Write-Host "  • Daily quota exceeded" -ForegroundColor Gray
Write-Host ""

Write-Host "📋 Alternative Methods:" -ForegroundColor Cyan
Write-Host ""
Write-Host "Method 1: Manual Copy from YouTube Studio" -ForegroundColor Yellow
Write-Host "  1. Go to: https://studio.youtube.com/" -ForegroundColor White
Write-Host "  2. Select JenniPlaysGames channel" -ForegroundColor White
Write-Host "  3. Click 'Playlists' in left sidebar" -ForegroundColor White
Write-Host "  4. Copy playlist names and URLs" -ForegroundColor White
Write-Host ""

Write-Host "Method 2: Use YouTube Channel Playlists Page" -ForegroundColor Yellow
Write-Host "  1. Go to: https://www.youtube.com/@jenniplaysgames/playlists" -ForegroundColor White
Write-Host "  2. Open browser console (F12)" -ForegroundColor White
Write-Host "  3. Paste this JavaScript:" -ForegroundColor White
Write-Host ""
Write-Host @"
// Copy this JavaScript code:
let playlists = [];
document.querySelectorAll('ytd-grid-playlist-renderer').forEach(el => {
    const title = el.querySelector('#video-title')?.textContent?.trim();
    const href = el.querySelector('a#thumbnail')?.href;
    if (title && href) {
        const id = new URL(href).searchParams.get('list');
        playlists.push({ title, id, url: href });
    }
});
console.table(playlists);
copy(JSON.stringify(playlists, null, 2));
console.log('Copied to clipboard!');
"@ -ForegroundColor DarkGray
Write-Host ""
Write-Host "  4. Press Enter - playlist data will be copied to clipboard" -ForegroundColor White
Write-Host "  5. Paste the JSON into a text file and send to me" -ForegroundColor White
Write-Host ""

Write-Host "Method 3: Current gaming.yaml Playlists" -ForegroundColor Yellow
Write-Host "  You already have 23 playlists configured in gaming.yaml" -ForegroundColor White
Write-Host "  We can keep those and just update titles/descriptions manually" -ForegroundColor White
Write-Host ""

Write-Host "Method 4: Enable API in Google Cloud Console" -ForegroundColor Yellow
Write-Host "  1. Go to: https://console.cloud.google.com/" -ForegroundColor White
Write-Host "  2. Select project: jenni-yt" -ForegroundColor White
Write-Host "  3. Enable 'YouTube Data API v3'" -ForegroundColor White
Write-Host "  4. Check API key restrictions (APIs, IP addresses, HTTP referrers)" -ForegroundColor White
Write-Host "  5. Try running this script again" -ForegroundColor White
Write-Host ""

Write-Host "═══════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""
Write-Host "💡 Recommendation:" -ForegroundColor Yellow
Write-Host "  Use Method 2 (browser console) - fastest and most reliable!" -ForegroundColor Green
Write-Host ""
Write-Host "  OR" -ForegroundColor Gray
Write-Host ""
Write-Host "  Just tell me which playlists you want to:" -ForegroundColor Green
Write-Host "    • Remove from gaming.yaml" -ForegroundColor White
Write-Host "    • Add to gaming.yaml" -ForegroundColor White
Write-Host "    • Reorder in gaming.yaml" -ForegroundColor White
Write-Host "    • Update titles/descriptions" -ForegroundColor White
Write-Host ""
Write-Host "  I can edit the YAML file for you!" -ForegroundColor Green
Write-Host ""
