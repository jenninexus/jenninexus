#!/usr/bin/env pwsh
# Wrapper to deploy without confirmation prompt
# Use for automated/AI-driven deployments

$ErrorActionPreference = "Stop"

Write-Host "🚀 Starting automated deployment to jenninexus.com..." -ForegroundColor Cyan
Write-Host ""

# First verify SSH protection
Write-Host "🔐 Verifying SSH protection before deployment..." -ForegroundColor Yellow
$sshCheck = ssh root@jennidrop "lsattr /root/.ssh/authorized_keys 2>/dev/null | grep -q 'i' && echo 'OK' || echo 'MISSING'"

if ($sshCheck -ne "OK") {
    Write-Host "❌ SSH protection check failed! Immutable flag might be missing." -ForegroundColor Red
    Write-Host "   Run: ssh root@jennidrop 'chattr +i /root/.ssh/authorized_keys'" -ForegroundColor Yellow
    exit 1
}

Write-Host "✅ SSH protection verified (immutable flag active)" -ForegroundColor Green
Write-Host ""

# Run deployment by simulating user input
$deployScript = Join-Path $PSScriptRoot "deploy.ps1"
$process = Start-Process -FilePath "pwsh" -ArgumentList @(
    "-Command",
    "param(`$bOnly) & '$deployScript' -BuildOnly:`$bOnly",
    "-Args", "`$false"
) -NoNewWindow -Wait -PassThru -RedirectStandardInput "yes`n"

if ($process.ExitCode -ne 0) {
    Write-Host "❌ Deployment failed with exit code: $($process.ExitCode)" -ForegroundColor Red
    exit $process.ExitCode
}

Write-Host ""
Write-Host "🎊 Deployment completed! Now running post-deployment tasks..." -ForegroundColor Green
Write-Host ""

# Run fix-permissions script on server
Write-Host "🔧 Running fix-permissions script on server..." -ForegroundColor Yellow
ssh root@jennidrop "cd /var/www/jenninexus && ./scripts/fix-permissions-jenninexus-remote.sh"

Write-Host ""
Write-Host "🔐 Verifying SSH protection after deployment..." -ForegroundColor Yellow
$sshCheckAfter = ssh root@jennidrop "lsattr /root/.ssh/authorized_keys 2>/dev/null | grep -q 'i' && echo 'OK' || echo 'MISSING'"

if ($sshCheckAfter -ne "OK") {
    Write-Host "⚠️  WARNING: SSH protection check failed after deployment!" -ForegroundColor Red
    Write-Host "   Attempting to restore protection..." -ForegroundColor Yellow
    ssh root@jennidrop "chattr +i /root/.ssh/authorized_keys"
    Write-Host "✅ Protection restored" -ForegroundColor Green
} else {
    Write-Host "✅ SSH protection still active after deployment" -ForegroundColor Green
}

Write-Host ""
Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║         ✅ DEPLOYMENT COMPLETE & VERIFIED!        ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""
Write-Host "🌐 Visit: https://jenninexus.com" -ForegroundColor White
Write-Host "🔐 SSH: Still protected (immutable flag active)" -ForegroundColor White
Write-Host ""
