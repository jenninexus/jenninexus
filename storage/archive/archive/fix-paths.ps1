# Fix all paths in HTML files to use resources/ directory
Write-Host "Fixing paths in all HTML files..." -ForegroundColor Cyan

$publicHtml = Join-Path $PSScriptRoot ".." | Join-Path -ChildPath "public_html"
$htmlFiles = Get-ChildItem -Path $publicHtml -Filter "*.html"

foreach ($file in $htmlFiles) {
    Write-Host "Processing: $($file.Name)" -ForegroundColor Yellow
    
    $content = Get-Content -Path $file.FullName -Raw
    $originalContent = $content
    
    # Fix CSS links
    $content = $content -replace 'href="custom\.css"', 'href="resources/css/custom.css"'
    
    # Fix JS script tags
    $content = $content -replace 'src="theme-toggle\.js"', 'src="resources/js/theme-toggle.js"'
    $content = $content -replace 'src="patreon-auth-enhanced\.js"', 'src="resources/js/patreon-auth-enhanced.js"'
    $content = $content -replace 'src="patreon-auth\.js"', 'src="resources/js/patreon-auth.js"'
    $content = $content -replace 'src="music-playlists\.js"', 'src="resources/js/music-playlists.js"'
    $content = $content -replace 'src="diy-playlists\.js"', 'src="resources/js/diy-playlists.js"'
    $content = $content -replace 'src="youtube-grid\.js"', 'src="resources/js/youtube-grid.js"'
    $content = $content -replace 'src="tag-system\.js"', 'src="resources/js/tag-system.js"'
    
    if ($content -ne $originalContent) {
        $content | Set-Content -Path $file.FullName -NoNewline
        Write-Host "  ✓ Updated paths in $($file.Name)" -ForegroundColor Green
    } else {
        Write-Host "  - No changes needed for $($file.Name)" -ForegroundColor Gray
    }
}

Write-Host "`nAll HTML files processed!" -ForegroundColor Green
