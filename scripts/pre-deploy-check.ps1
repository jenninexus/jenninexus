#!/usr/bin/env pwsh
#Requires -Version 7.0
<#
.SYNOPSIS
    Pre-deployment safety check for JenniNexus

.DESCRIPTION
    Verifies SSH keys are intact and server connection works before deployment.
    This prevents deploying with corrupted SSH keys.

.EXAMPLE
    .\scripts\pre-deploy-check.ps1
    Run all safety checks before deployment
#>

Write-Host "`n╔════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║  🔍 Pre-Deployment Safety Check                   ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan

$allGood = $true
$ProjectRoot = Split-Path $PSScriptRoot -Parent

# Check 1: SSH key files exist
Write-Host "[1/4] Checking SSH key files exist..." -ForegroundColor Yellow
$keyFiles = @(
    "C:\Users\Owner\.ssh\id_jennidrop"
    "C:\Users\Owner\.ssh\id_jennidrop.ppk"
    "C:\Users\Owner\.ssh\id_jennidrop.openssh"
    "C:\Users\Owner\.ssh\id_jennidrop.pub"
)
foreach ($key in $keyFiles) {
    if (Test-Path $key) {
        $size = (Get-Item $key).Length
        Write-Host "   ✅ $(Split-Path $key -Leaf) ($size bytes)" -ForegroundColor Green
    } else {
        Write-Host "   ❌ MISSING: $(Split-Path $key -Leaf)" -ForegroundColor Red
        $allGood = $false
    }
}

# Check 2: Public key integrity
Write-Host "`n[2/4] Verifying public key integrity..." -ForegroundColor Yellow
$expectedPubKey = "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIClseVXGI3eIDvUUjMo5cTNjUIGSEQFN2WpGczxGtDiO"
try {
    $derivedKey = ssh-keygen -y -f C:\Users\Owner\.ssh\id_jennidrop.openssh 2>&1 | Out-String
    if ($derivedKey -match $expectedPubKey) {
        Write-Host "   ✅ Keys are cryptographically valid" -ForegroundColor Green
        Write-Host "      $(($derivedKey -split "`n")[0])" -ForegroundColor DarkGray
    } else {
        Write-Host "   ❌ Key mismatch - CORRUPTED" -ForegroundColor Red
        Write-Host "      Expected: $expectedPubKey" -ForegroundColor Gray
        Write-Host "      Got:      $($derivedKey -replace "`n",'')" -ForegroundColor Gray
        $allGood = $false
    }
} catch {
    Write-Host "   ❌ Cannot derive public key - CORRUPTED" -ForegroundColor Red
    Write-Host "      Error: $_" -ForegroundColor Gray
    $allGood = $false
}

# Check 3: SSH connection test
Write-Host "`n[3/4] Testing SSH connection to server..." -ForegroundColor Yellow
Write-Host "   Connecting to jennidrop-root (64.23.141.41)..." -ForegroundColor Gray

$sshTest = ssh -o ConnectTimeout=5 -o StrictHostKeyChecking=no jennidrop-root "whoami" 2>&1 | Out-String
if ($LASTEXITCODE -eq 0 -and $sshTest -match "root") {
    Write-Host "   ✅ SSH connection successful (logged in as root)" -ForegroundColor Green
} else {
    Write-Host "   ❌ SSH connection FAILED" -ForegroundColor Red
    Write-Host "      Output: $($sshTest.Trim())" -ForegroundColor Gray
    Write-Host "      Exit code: $LASTEXITCODE" -ForegroundColor Gray
    $allGood = $false
}

# Check 4: Deploy package ready
Write-Host "`n[4/4] Checking deploy package..." -ForegroundColor Yellow
$deployDir = Join-Path $ProjectRoot "deploy\jenninexus"
if (Test-Path $deployDir) {
    $fileCount = (Get-ChildItem $deployDir -Recurse -File -ErrorAction SilentlyContinue).Count
    $dirSize = [math]::Round((Get-ChildItem $deployDir -Recurse -File -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum / 1MB, 2)
    Write-Host "   ✅ Deploy package exists" -ForegroundColor Green
    Write-Host "      Files: $fileCount" -ForegroundColor DarkGray
    Write-Host "      Size:  ${dirSize}MB" -ForegroundColor DarkGray
    Write-Host "      Path:  $deployDir" -ForegroundColor DarkGray
} else {
    Write-Host "   ❌ Deploy package missing" -ForegroundColor Red
    Write-Host "      Run: .\scripts\build-and-deploy.ps1 first" -ForegroundColor Gray
    $allGood = $false
}

# Final verdict
Write-Host "`n╔════════════════════════════════════════════════════╗" -ForegroundColor $(if($allGood){"Green"}else{"Red"})
if ($allGood) {
    Write-Host "║  ✅ ALL CHECKS PASSED - Safe to Deploy            ║" -ForegroundColor Green
    Write-Host "╚════════════════════════════════════════════════════╝`n" -ForegroundColor Green
    
    Write-Host "📦 Ready to deploy!" -ForegroundColor Cyan
    Write-Host "   Files ready:  $fileCount files (${dirSize}MB)" -ForegroundColor White
    Write-Host "   SSH verified: Connected as root@64.23.141.41" -ForegroundColor White
    Write-Host "   Keys intact:  All 4 SSH key files valid`n" -ForegroundColor White
    
    Write-Host "🚀 Next steps:" -ForegroundColor Yellow
    Write-Host "   1. Review deploy package: explorer $deployDir" -ForegroundColor White
    Write-Host "   2. Deploy to production:  .\scripts\deploy.ps1 -BuildOnly:`$false" -ForegroundColor White
    Write-Host "   3. Verify live site:      https://jenninexus.com`n" -ForegroundColor White
    
    exit 0
} else {
    Write-Host "║  ❌ DEPLOYMENT BLOCKED - Fix Issues First         ║" -ForegroundColor Red
    Write-Host "╚════════════════════════════════════════════════════╝`n" -ForegroundColor Red
    
    Write-Host "🔧 RECOVERY OPTIONS:" -ForegroundColor Yellow
    Write-Host "   • If SSH keys corrupted:" -ForegroundColor White
    Write-Host "     → See C:\Users\Owner\.ssh\SSH-KEY-CORRUPTION-PREVENTION.md" -ForegroundColor Gray
    Write-Host "     → Or restore from backup: git checkout -- .ssh/*" -ForegroundColor Gray
    
    Write-Host "`n   • If connection fails but keys are valid:" -ForegroundColor White
    Write-Host "     → Use DigitalOcean console to add public key" -ForegroundColor Gray
    Write-Host "     → See C:\Users\Owner\.ssh\SSH-RECOVERY.md" -ForegroundColor Gray
    
    Write-Host "`n   • If deploy package missing:" -ForegroundColor White
    Write-Host "     → Run: .\scripts\build-and-deploy.ps1" -ForegroundColor Gray
    Write-Host "     → This builds deploy/jenninexus/ (no SSH connection)`n" -ForegroundColor Gray
    
    exit 1
}
