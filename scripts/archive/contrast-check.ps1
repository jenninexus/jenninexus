function HexToRGB($hex) {
  $h = $hex.TrimStart('#')
  if ($h.Length -eq 3) { $h = ($h.ToCharArray() | ForEach-Object { $_ + $_ }) -join '' }
  $r = [Convert]::ToInt32($h.Substring(0,2),16)
  $g = [Convert]::ToInt32($h.Substring(2,2),16)
  $b = [Convert]::ToInt32($h.Substring(4,2),16)
  return @($r,$g,$b)
}

function RelativeLuminance($rgb) {
  # rgb is [r,g,b] 0-255
  $srgb = $rgb | ForEach-Object { $_ / 255.0 }
  $lin = $srgb | ForEach-Object { if ($_ -le 0.03928) { $_ / 12.92 } else { [math]::Pow((($_ + 0.055) / 1.055), 2.4) } }
  return 0.2126 * $lin[0] + 0.7152 * $lin[1] + 0.0722 * $lin[2]
}

function ContrastRatio($hexA, $hexB) {
  $a = HexToRGB $hexA
  $b = HexToRGB $hexB
  $La = RelativeLuminance $a
  $Lb = RelativeLuminance $b
  if ($La -lt $Lb) { $tmp = $La; $La = $Lb; $Lb = $tmp }
  return ([math]::Round((($La + 0.05) / ($Lb + 0.05)), 2))
}

$pairs = @(
  @{name='Header bg (glass light) vs nav link (text-secondary)'; a='#ffffff'; b='#495057'},
  @{name='Header bg (glass dark) vs nav link (text-secondary)'; a='#0d1117'; b='#C9D1D9'},
  @{name='Footer bg (#000) vs footer text (text-muted)'; a='#000000'; b='#A0AEC0'},
  @{name='Footer bg (#000) vs footer text (text-white)'; a='#000000'; b='#FFFFFF'},
  @{name='Footer bg (#000) vs social icon red (#EA4335)'; a='#000000'; b='#EA4335'},
  @{name='Footer bg (#000) vs social icon YT red (#FF0000)'; a='#000000'; b='#FF0000'},
  @{name='Footer bg (#000) vs social icon twitch (#9146FF)'; a='#000000'; b='#9146FF'},
  @{name='Footer bg (#000) vs social icon spotify (#1DB954)'; a='#000000'; b='#1DB954'},
  @{name='Footer bg (#000) vs social icon patreon (#FF424D)'; a='#000000'; b='#FF424D'},
  @{name='Footer bg (#000) vs social icon discord (#5865F2)'; a='#000000'; b='#5865F2'}
)

Write-Output "Contrast Check Results (WCAG):"
foreach ($p in $pairs) {
  $ratio = ContrastRatio $p.a $p.b
  $level = if ($ratio -ge 7) { 'AAA' } elseif ($ratio -ge 4.5) { 'AA' } elseif ($ratio -ge 3) { 'AA Large / A' } else { 'Fail' }
  Write-Output ("{0,-60} {1,5}  {2}" -f $p.name, $ratio, $level)
}
