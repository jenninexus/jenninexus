$urls = @('/diy.php','/gamedev.php','/media.php','/resources/playlists/playlist-ids.json')
foreach ($u in $urls) {
  $full = 'http://localhost:8002' + $u
  try {
    $r = Invoke-WebRequest -Uri $full -UseBasicParsing -TimeoutSec 15
    $len = if ($r.RawContentLength -ne $null) { $r.RawContentLength } else { ($r.Content).Length }
    Write-Output "$full -> $($r.StatusCode) ($len bytes)"
  } catch {
    Write-Output "$full -> ERROR: $($_.Exception.Message)"
  }
}
