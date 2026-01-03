$base = 'http://localhost:8002'
$pages = @('/blog/build-and-deploy-2024.php','/live.php','/blog/pax-west-gaming-con.php')
foreach ($p in $pages) {
  $uri = $base + $p
  try {
    $r = Invoke-WebRequest -Uri $uri -UseBasicParsing -TimeoutSec 10
    Write-Host "URL: $uri  Status:$($r.StatusCode)  Length:$($r.RawContentLength)"
    $c = $r.Content
    if ($c -match '8F3T78MQjys') { Write-Host '  Found embed id 8F3T78MQjys' }
    if ($c -match '0a9amAqV1Go') { Write-Host '  Found embed id 0a9amAqV1Go' }
    if ($c -match 'connect.facebook.net') { Write-Host '  Found Facebook SDK include' }
    if ($c -match 'twitch-embed') { Write-Host '  Found twitch-embed element' }
  } catch {
    Write-Host "URL: $uri  ERROR: $($_.Exception.Message)"
  }
}
