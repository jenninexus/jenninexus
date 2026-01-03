<#
Safe SSH key prune utility

This script inspects C:\Users\Owner\.ssh for private key files and compares them to
keys referenced in the ssh config file (`C:\Users\Owner\.ssh\config`). Files that
appear unused are reported and moved to `.ssh/archived/` only when run with `-DoIt`.

Usage:
  # Dry-run (default)
  pwsh .\scripts\prune-ssh-keys.ps1

  # Commit changes (move files)
  pwsh .\scripts\prune-ssh-keys.ps1 -DoIt
#>

param(
    [switch]$DoIt
)

$sshDir = "$env:USERPROFILE\.ssh"
if (-not (Test-Path $sshDir)) { Write-Host "SSH directory not found: $sshDir"; exit 1 }

$configPath = Join-Path $sshDir 'config'
$referenced = @()
if (Test-Path $configPath) {
    $content = Get-Content $configPath -ErrorAction SilentlyContinue | Out-String
    foreach ($match in [regex]::Matches($content, 'IdentityFile\s+(\S+)')) {
        $path = $match.Groups[1].Value -replace '"',''
        # Expand ~ and environment variables if present
        $expanded = $path -replace '^~', $env:USERPROFILE
        $expanded = [Environment]::ExpandEnvironmentVariables($expanded)
        $referenced += (Resolve-Path -Path $expanded -ErrorAction SilentlyContinue | ForEach-Object { $_.ProviderPath })
    }
}

# Known safe names to keep (common main keys)
$keepNames = @('id_rsa','id_ed25519','main_jenninexus','main_neophi','main_boobsofwar')

$files = Get-ChildItem -Path $sshDir -File | Where-Object { $_.Extension -eq '' -or $_.Extension -eq '.ppk' }

$candidates = @()
foreach ($f in $files) {
    $full = $f.FullName
    if ($referenced -contains $full) { continue }
    if ($keepNames -contains $f.BaseName) { continue }
    # Skip known host files
    if ($f.Name -match 'known_hosts|authorized_keys') { continue }
    $candidates += $f
}

if ($candidates.Count -eq 0) {
    Write-Host "No unreferenced SSH key candidates found in $sshDir" -ForegroundColor Green
    exit 0
}

Write-Host ("Found {0} candidate key file(s) that are not referenced in {1}:" -f $candidates.Count, $configPath) -ForegroundColor Yellow
foreach ($c in $candidates) { Write-Host "  - $($c.Name) -> $($c.FullName)" }

if (-not $DoIt) {
    Write-Host "\nDry-run: no files moved. Re-run with -DoIt to archive these keys." -ForegroundColor Cyan
    exit 0
}

$archiveDir = Join-Path $sshDir 'archived'
New-Item -Path $archiveDir -ItemType Directory -Force | Out-Null
foreach ($c in $candidates) {
    $dest = Join-Path $archiveDir $c.Name
    Write-Host "Moving $($c.FullName) -> $dest" -ForegroundColor Gray
    Move-Item -Path $c.FullName -Destination $dest -Force
}

Write-Host "Archived $($candidates.Count) key(s) to $archiveDir" -ForegroundColor Green
exit 0
