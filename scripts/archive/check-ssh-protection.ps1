# Quick SSH Protection Status Check for JenniNexus
# Run this anytime to verify you're protected from lockouts

Write-Host "`n=== JenniNexus SSH Protection Status ===" -ForegroundColor Cyan
Write-Host "Server: jennidrop (64.23.141.41)" -ForegroundColor White
Write-Host ""

# Test root SSH access
Write-Host "🔍 Testing root SSH access..." -ForegroundColor Yellow
try {
    $rootTest = ssh root@jennidrop "echo OK" 2>&1
    if ($rootTest -eq "OK") {
        Write-Host "✅ Root SSH: WORKING" -ForegroundColor Green
    } else {
        Write-Host "❌ Root SSH: FAILED" -ForegroundColor Red
        Write-Host "   Response: $rootTest" -ForegroundColor Gray
    }
} catch {
    Write-Host "❌ Root SSH: ERROR - $_" -ForegroundColor Red
}

# Test jenni backup user
Write-Host "🔍 Testing backup user (jenni)..." -ForegroundColor Yellow
try {
    $jenniTest = ssh jenni@jennidrop "echo OK" 2>&1
    if ($jenniTest -eq "OK") {
        Write-Host "✅ Jenni SSH: WORKING" -ForegroundColor Green
    } else {
        Write-Host "⚠️  Jenni SSH: Check needed" -ForegroundColor Yellow
        Write-Host "   Response: $jenniTest" -ForegroundColor Gray
    }
} catch {
    Write-Host "⚠️  Jenni SSH: Not configured or error" -ForegroundColor Yellow
}

# Check immutable flag
Write-Host "🔍 Checking immutable protection..." -ForegroundColor Yellow
try {
    $immutableCheck = ssh root@jennidrop "lsattr /root/.ssh/authorized_keys 2>&1"
    if ($immutableCheck -match "----i") {
        Write-Host "✅ Immutable flag: ACTIVE" -ForegroundColor Green
    } else {
        Write-Host "❌ Immutable flag: NOT ACTIVE" -ForegroundColor Red
        Write-Host "   Run: ssh root@jennidrop 'chattr +i /root/.ssh/authorized_keys'" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Cannot check immutable flag: $_" -ForegroundColor Red
}

# Check auto-restore cron
Write-Host "🔍 Checking auto-restore cron..." -ForegroundColor Yellow
try {
    $cronCheck = ssh root@jennidrop "test -f /etc/cron.daily/restore-ssh-key && echo EXISTS || echo MISSING" 2>&1
    if ($cronCheck -eq "EXISTS") {
        Write-Host "✅ Auto-restore cron: ACTIVE" -ForegroundColor Green
    } else {
        Write-Host "❌ Auto-restore cron: MISSING" -ForegroundColor Red
        Write-Host "   Run the verify-ssh-protection.sh script to fix" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Cannot check cron: $_" -ForegroundColor Red
}

# Check backups
Write-Host "🔍 Checking backups..." -ForegroundColor Yellow
try {
    $backupCheck = ssh root@jennidrop "test -f /root/ssh-keys-permanent-backup/authorized_keys.permanent && echo EXISTS || echo MISSING" 2>&1
    if ($backupCheck -eq "EXISTS") {
        Write-Host "✅ Permanent backup: EXISTS" -ForegroundColor Green
    } else {
        Write-Host "⚠️  Permanent backup: Not found (not critical)" -ForegroundColor Yellow
    }
} catch {
    Write-Host "⚠️  Cannot check backups" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "=== 🎊 Summary ===" -ForegroundColor Cyan
Write-Host "If all checks show ✅, you are FULLY PROTECTED from lockouts!" -ForegroundColor Green
Write-Host ""
Write-Host "If any checks fail:" -ForegroundColor Yellow
Write-Host "1. Run: .\scripts\verify-ssh-protection.sh on the server" -ForegroundColor White
Write-Host "2. Or check C:\Users\Owner\.ssh\SSH-RECOVERY.md for manual recovery" -ForegroundColor White
Write-Host ""
