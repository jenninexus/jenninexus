# Smoke tests for JenniNexus (simple header checks)
# Run this while dev server is running (http://localhost:8002)

$base = 'http://localhost:8002'
$pages = @(
  @{ path = '/'; name = 'index'; check = 'Featured Content' },
  @{ path = '/gamedev'; name = 'gamedev'; check = 'Featured Game Projects' },
  @{ path = '/media'; name = 'media'; check = 'Social Media Stats' },
  @{ path = '/youtube'; name = 'youtube'; check = 'Featured Playlists' }
)

function Check-Page($p) {
  Write-Host "Checking $($p.name) -> $($base)$($p.path) ..." -ForegroundColor Cyan
  try {
    $r = Invoke-WebRequest -Uri ($base + $p.path) -UseBasicParsing -TimeoutSec 10
    if ($r.StatusCode -ne 200) { Write-Host "  ❌ HTTP $($r.StatusCode)" -ForegroundColor Red; return $false }
    if ($r.Content -match [regex]::Escape($p.check)) { Write-Host "  ✅ contains '$($p.check)'; OK" -ForegroundColor Green; return $true }
    else { Write-Host "  ⚠️  '$($p.check)' not found in page" -ForegroundColor Yellow; return $false }
  } catch {
    Write-Host "  ❌ Error: $_" -ForegroundColor Red; return $false
  }
}

$allGood = $true
foreach ($p in $pages) { if (-not (Check-Page $p)) { $allGood = $false } }

# Check that social-stats.json is reachable
Write-Host "Checking social-stats.json..." -ForegroundColor Cyan
try {
  $s = Invoke-WebRequest -Uri ($base + '/resources/playlists/social-stats.json') -UseBasicParsing -TimeoutSec 10
  $j = $s.Content | ConvertFrom-Json
  if ($j.youtube) { Write-Host "  ✅ social-stats.json OK" -ForegroundColor Green } else { Write-Host "  ⚠️ social-stats.json missing youtube property" -ForegroundColor Yellow }
} catch { Write-Host "  ❌ Failed to fetch social-stats.json: $_" -ForegroundColor Red; $allGood = $false }

# Check server proxy endpoint for a known playlist id
$testPlaylist = 'PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi'
Write-Host "Checking server proxy get-youtube.php for playlist $testPlaylist..." -ForegroundColor Cyan
try {
  $resp = Invoke-WebRequest -Uri ($base + "/resources/api/get-youtube.php?playlist_id=$testPlaylist") -UseBasicParsing -TimeoutSec 15
  if ($resp.StatusCode -eq 200 -and $resp.Content) { Write-Host "  ✅ get-youtube.php responded" -ForegroundColor Green } else { Write-Host "  ⚠️ get-youtube.php issue" -ForegroundColor Yellow; $allGood = $false }
} catch { Write-Host "  ❌ Error contacting proxy: $_" -ForegroundColor Red; $allGood = $false }

if ($allGood) { Write-Host "\nSmoke Tests: ALL PASSED" -ForegroundColor Green } else { Write-Host "\nSmoke Tests: ISSUES FOUND" -ForegroundColor Red }
