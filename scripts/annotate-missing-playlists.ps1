<#
Annotate the given YAML file with status: missing for playlists that fail the YouTube RSS check.
Defaults to report-only mode. Use -Apply to modify the YAML in-place (creates a .bak backup).
#>
param(
  [Parameter(Mandatory=$true)][string]$YamlFile,
  [switch]$Apply
)

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$yamlPath = Resolve-Path $YamlFile
if (!(Test-Path $yamlPath)) { Write-Error "YAML file not found: $YamlFile"; exit 1 }

# Run the verifier to produce a fresh report
Write-Host "Running playlist verification..."
& pwsh -NoProfile -ExecutionPolicy Bypass -File "$root\check-youtube-playlists.ps1"

# Find last report
$logDir = Join-Path $root "..\public_html\storage\logs"
$report = Get-ChildItem -Path $logDir -Filter 'playlist-check-*.json' | Sort-Object LastWriteTime -Descending | Select-Object -First 1
if (-not $report) { Write-Error "No playlist-check report found in $logDir"; exit 1 }

$reportJson = Get-Content -Path $report.FullName -Raw | ConvertFrom-Json
$missing = $reportJson | Where-Object { $_.status -ne '200' -and $_.status -ne 200 }
if ($missing.Count -eq 0) { Write-Host "No missing playlists detected in report: $($report.FullName)"; exit 0 }

Write-Host "Found $($missing.Count) failing playlists. Report: $($report.FullName)"
$summary = $missing | Select-Object playlist_id,status,url,error
$summary | Format-Table -AutoSize

# Report path
$outReport = Join-Path $logDir "playlist-annotate-$(Get-Date -Format 'yyyyMMdd-HHmmss').json"
$summary | ConvertTo-Json -Depth 3 | Out-File -FilePath $outReport -Encoding UTF8
Write-Host "Annotated report written to: $outReport"

if (-not $Apply) { Write-Host "Run again with -Apply to annotate the YAML file in-place (creates a backup)."; exit 0 }

# Backup YAML
$backup = "$($yamlPath.Path).bak.$(Get-Date -Format 'yyyyMMdd-HHmmss')"
Copy-Item -Path $yamlPath -Destination $backup -Force
Write-Host "Backup created: $backup"

# Simple text-based insertion: for each failing playlist id, add a 'status: missing' line if not present
$yamlText = Get-Content -Path $yamlPath -Raw -Encoding UTF8
foreach ($row in $missing) {
  $pid = $row.playlist_id
  # Find the playlist id line and insert status under it (preserve indentation)
  $escaped = [regex]::Escape($pid)
  $pattern = '(^\s*-\s*id:\s*"' + $escaped + '"\s*$)'
  $yamlText = [regex]::Replace($yamlText, $pattern, '$1`n      status: missing', 'MultiLine')
}

Set-Content -Path $yamlPath -Value $yamlText -Encoding UTF8
Write-Host "YAML updated: $yamlPath (status: missing added for failing playlists)"
Write-Host "Please review the backup and commit changes as appropriate."