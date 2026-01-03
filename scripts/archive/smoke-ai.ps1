$u = 'http://localhost:8002/blog/ai-tools-for-technical-artists'
try {
  $r = Invoke-WebRequest -Uri $u -UseBasicParsing -TimeoutSec 10
  Write-Host "Status: $($r.StatusCode)"
  $c = $r.Content
  if ($c -match 'Blog post content coming soon') { Write-Host 'FOUND_PLACEHOLDER' } else { Write-Host 'NO_PLACEHOLDER' }
  if ($c -match 'connect.facebook.net') { Write-Host 'FB_SDK_IN_HTML' }
  if ($c -match 'video-grid-container') { Write-Host 'FOUND_PLAYLIST_CONTAINER' }
} catch { Write-Host "ERROR: $($_.Exception.Message)" }
