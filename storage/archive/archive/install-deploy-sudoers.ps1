param(
    [Parameter(Mandatory=$false)]
    [string]$ServerAlias,
    [Parameter(Mandatory=$false)]
    [string]$ServerHost,
    [Parameter(Mandatory=$true)]
    [string]$IdentityFile,
    [string]$SudoersLocalPath = "deploy\deploy_jenninexus_sudoers",
    [switch]$DryRun
)

Write-Host "Installing sudoers fragment to server: $ServerAlias" -ForegroundColor Cyan

if (-not (Test-Path $SudoersLocalPath)) {
    Write-Error "Local sudoers fragment not found: $SudoersLocalPath"
    exit 2
}

# Resolve SSH alias to hostname (try 'ssh -G' then fallback to parsing ~/.ssh/config)
function Resolve-SSHHost([string]$alias) {
    try {
        $out = & ssh -G $alias 2>$null
        if ($out) {
            foreach ($line in $out -split "`n") {
                $l = $line.Trim()
                if ($l -match '^hostname\s+(\S+)$') {
                    $candidate = $matches[1]
                    # If ssh -G returns the alias itself (no resolution), ignore and fall back to config parsing
                    if ($candidate -and $candidate -ne $alias -and $candidate -match '\.') { return $candidate }
                    break
                }
            }
        }
    } catch { }

    $sshConfig = Join-Path $env:USERPROFILE '.ssh\config'
    if (-not (Test-Path $sshConfig)) { return $null }
    $lines = Get-Content -Path $sshConfig -ErrorAction SilentlyContinue
    $inHostBlock = $false
    foreach ($line in $lines) {
        $trim = $line.Trim()
        if ($trim -match '^Host\s+(.*)') {
            $names = $matches[1] -split '\s+' | ForEach-Object { $_.Trim() } | Where-Object { $_ -ne '' }
            if ($names -contains $alias) { $inHostBlock = $true } else { $inHostBlock = $false }
            continue
        }
        if ($inHostBlock -and $trim -match '^HostName\s+(\S+)') { return $matches[1] }
    }
    return $null
}

# Normalize IdentityFile to absolute path if provided
if ($IdentityFile) {
    try { $IdentityFile = (Resolve-Path -Path $IdentityFile).ProviderPath } catch { }
}

Write-Host "Copying sudoers fragment to server via scp..." -ForegroundColor Yellow
if ($DryRun) { Write-Host "Dry run: not executing"; exit 0 }
$resolved = $null
if ($ServerHost) { $hostForUse = $ServerHost } else { $resolved = Resolve-SSHHost $ServerAlias; $hostForUse = if ($resolved) { $resolved } else { $ServerAlias } }
$remoteTarget = "deploy@${hostForUse}:/tmp/deploy_jenninexus_sudoers"
$scpArgs = @()
$sshConfigPath = Join-Path $env:USERPROFILE '.ssh\config'
if (Test-Path $sshConfigPath) { $scpArgs += '-F'; $scpArgs += $sshConfigPath }
if ($IdentityFile) { $scpArgs += '-i'; $scpArgs += $IdentityFile }
$scpArgs += @('-o', 'StrictHostKeyChecking=accept-new', $SudoersLocalPath, $remoteTarget)
$copyProc = Start-Process -FilePath 'scp' -ArgumentList $scpArgs -Wait -NoNewWindow -PassThru
if ($copyProc.ExitCode -ne 0) { Write-Error "scp failed with exit code $($copyProc.ExitCode)"; exit $copyProc.ExitCode }

Write-Host "Attempting to install sudoers fragment as root (requires passwordless sudo or interactive root)" -ForegroundColor Cyan

$sshTarget = "deploy@${hostForUse}"
$sshArgs = @()
$sshConfigPath = Join-Path $env:USERPROFILE '.ssh\config'
if (Test-Path $sshConfigPath) { $sshArgs += '-F'; $sshArgs += $sshConfigPath }
if ($IdentityFile) { $sshArgs += '-i'; $sshArgs += $IdentityFile }
$sshArgs += @('-o', 'StrictHostKeyChecking=accept-new', $sshTarget, "sudo mv /tmp/deploy_jenninexus_sudoers /etc/sudoers.d/deploy_jenninexus && sudo chmod 440 /etc/sudoers.d/deploy_jenninexus && sudo visudo -c")
$installProc = Start-Process -FilePath 'ssh' -ArgumentList $sshArgs -Wait -NoNewWindow -PassThru
if ($installProc.ExitCode -ne 0) {
    Write-Warning "Remote sudoers install returned exit code $($installProc.ExitCode). This may require interactive root or password entry."
    Write-Host "You can install the file manually on the server as root: sudo mv /tmp/deploy_jenninexus_sudoers /etc/sudoers.d/deploy_jenninexus && sudo chmod 440 /etc/sudoers.d/deploy_jenninexus && sudo visudo -c" -ForegroundColor Magenta
    exit $installProc.ExitCode
}

Write-Host "✅ Sudoers fragment installed and validated on server (or visudo reported OK)." -ForegroundColor Green
exit 0
