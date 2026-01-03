<#
PowerShell helper: install a local public key to a remote user's ~/.ssh/authorized_keys
Run this locally on your machine. It will attempt to SSH into the remote server and append the provided public key
for the specified remote user. The script requires OpenSSH client available (Windows 10+ has it by default) and
that password or other auth is available for the initial connection.

Usage:
  pwsh ./scripts/install-pubkey.ps1 -Host "64.23.141.41" -User "deploy" -PubKeyPath "C:\Users\Owner\.ssh\id_rsa.pub"

Notes:
 - This script only writes to the remote user's ~/.ssh/authorized_keys. It will create the .ssh directory and
   the authorized_keys file if they do not exist, and set permissions to 700/600 where possible.
 - You must run this locally (we can't perform remote changes from here). The remote must accept the initial
   connection (password or existing key).
 - For root access, run with -User "root" but be careful.
#>
param(
    [Parameter(Mandatory=$true)]
    [string]$Host,

    [Parameter(Mandatory=$true)]
    [string]$User,

    [Parameter(Mandatory=$true)]
    [string]$PubKeyPath,

    [int]$SshPort = 22
)

if (-not (Test-Path $PubKeyPath)) {
    Write-Error "Public key file not found: $PubKeyPath"
    exit 2
}

$pubkey = Get-Content -Raw -Path $PubKeyPath
$escapedKey = $pubkey -replace '"', '\"'

# Build the remote commands to run (POSIX shell)
$remoteCmd = @'
set -e
mkdir -p ~/.ssh
chmod 700 ~/.ssh || true
touch ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys || true
# Append if not present
grep -qxF "{KEY}" ~/.ssh/authorized_keys || echo "{KEY}" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys || true
'@ -replace '\{KEY\}', $escapedKey

# Save remote command to a temp file for clarity
$tempFile = [IO.Path]::GetTempFileName()
Set-Content -Path $tempFile -Value $remoteCmd -Encoding ASCII

# Execute remote command via ssh
$sshCmd = "ssh -p $SshPort $User@$Host 'bash -s' < `"$tempFile`""
Write-Output "Running remote install on $User@$Host (port $SshPort) ..."

$proc = Start-Process -FilePath pwsh -ArgumentList ('-NoProfile','-Command',$sshCmd) -Wait -NoNewWindow -PassThru
$exitCode = $proc.ExitCode

Remove-Item $tempFile -ErrorAction SilentlyContinue

if ($exitCode -eq 0) {
    Write-Output "Public key installed (or already present) for $User@$Host"
} else {
    Write-Error "SSH command exited with code $exitCode"
}
