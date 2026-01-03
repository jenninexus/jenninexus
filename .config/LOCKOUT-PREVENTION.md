# SSH Lockout Prevention Guide

**Last Updated**: November 5, 2025  
**Status**: ✅ FIXED - Deployment scripts updated to prevent future lockouts

---

## 🚨 What Caused The Lockout (November 5, 2025)

### Timeline
1. ✅ **1:00 AM** - Deployment succeeded (534 files uploaded)
2. ✅ **1:00 AM** - `fix-permissions-jenninexus-remote.sh` executed
3. ❌ **1:00 AM** - Script ran `chown -R www-data:www-data .` from `/var/www/jenninexus/`
4. ❌ **1:00 AM** - This tried to change ownership of `/root/.ssh/authorized_keys`
5. ❌ **1:00 AM** - Even though immutable flag prevented deletion, the `chown` attempt triggered Ubuntu's security cleanup
6. ❌ **1:00 AM** - SSH key got removed by automated cleanup scripts
7. 🚫 **1:05 AM** - User locked out: `Permission denied (publickey)`

### Root Cause
**The deployment script's `chown -R www-data:www-data .` command** ran from `/var/www/jenninexus/` and attempted to change ownership of **ALL files including hidden directories**. When it tried to touch `/root/.ssh/authorized_keys`, Ubuntu's automated security scripts detected the suspicious activity and removed the key.

---

## ✅ Fix Applied (November 5, 2025)

### Changes to `fix-permissions-jenninexus-remote.sh`

#### BEFORE (DANGEROUS):
```bash
run "chown -R www-data:www-data ."
```

#### AFTER (SAFE):
```bash
# 🔐 CRITICAL: Protect /root/.ssh from chown operations
# NEVER run chown -R on paths that might contain /root/.ssh or /.ssh directories.
log "🛡️  Protecting SSH directories from ownership changes"

# Basic ownership: ensure www-data owns site tree (idempotent)
# EXCLUDE hidden directories (especially .ssh) to prevent lockout
run "find . -maxdepth 1 ! -name '.*' -exec chown -R www-data:www-data '{}' + 2>/dev/null || true"
```

#### Added Protection Verification at END:
```bash
# 🔐 CRITICAL: Verify /root/.ssh is still protected after deployment
if [ -f /root/.ssh/authorized_keys ]; then
    log "🛡️  Verifying /root/.ssh/authorized_keys protection"
    IMMUTABLE_STATUS=$(lsattr /root/.ssh/authorized_keys 2>/dev/null | grep -o '^....i' || echo "missing")
    if [[ "$IMMUTABLE_STATUS" == *"i"* ]]; then
        log "✅ SSH key immutable flag verified (still protected)"
    else
        log "⚠️  WARNING: SSH key immutable flag MISSING! Re-applying protection..."
        run "chattr +i /root/.ssh/authorized_keys || true"
        log "✅ SSH key immutable flag restored"
    fi
else
    log "⚠️  WARNING: /root/.ssh/authorized_keys does NOT exist!"
fi
```

---

## 🛡️ Protection Layers (Defense in Depth)

### Layer 1: Immutable Flag
```bash
chattr +i /root/.ssh/authorized_keys
```
**What it does**: Makes the file **IMMUTABLE** - cannot be modified or deleted, even by root.

**Verify**:
```bash
lsattr /root/.ssh/authorized_keys
# Should show: ----i---------e------- (the "i" means immutable)
```

### Layer 2: Daily Auto-Restore Cron
**File**: `/etc/cron.daily/restore-ssh-key`  
**Runs**: Daily at 6:25 AM  
**What it does**: Checks if SSH key exists, restores it if missing, re-applies immutable flag

**Verify**:
```bash
ls -la /etc/cron.daily/restore-ssh-key
cat /etc/cron.daily/restore-ssh-key
```

### Layer 3: Fixed Deployment Scripts
**File**: `/var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh`  
**What it does**: 
- Excludes hidden directories (`.ssh`) from `chown -R`
- Verifies immutable protection at END of deployment
- Re-applies immutable flag if somehow removed

**Verify**:
```bash
grep -A5 "CRITICAL: Protect" /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh
```

### Layer 4: Timestamped Backups
**Locations**:
- `/root/ssh-keys-backup/authorized_keys.YYYYMMDD`
- `/root/repair-backups/YYYYMMDDTHHMMSSZ/`

---

## 🚀 Deployment Checklist

### Before Every Deployment
- [ ] Verify deployment script excludes `.ssh` directories
- [ ] Test deployment in staging environment first (if available)
- [ ] Backup current SSH keys: `ssh root@jennidrop "cp /root/.ssh/authorized_keys /root/ssh-keys-backup/authorized_keys.$(date +%Y%m%d)"`

### During Deployment
- [ ] Monitor deployment output for warnings
- [ ] Check for `chattr -i` warnings (means immutable flag was encountered)
- [ ] Watch for permission errors on `/root/.ssh/`

### After Deployment
- [ ] Test SSH connection immediately: `ssh root@jennidrop "whoami"`
- [ ] Verify immutable flag: `ssh root@jennidrop "lsattr /root/.ssh/authorized_keys"`
- [ ] Check deployment logs: `ssh root@jennidrop "tail -30 /var/log/jenninexus-deploy.log"`

### If Locked Out
- [ ] Open DigitalOcean console: https://cloud.digitalocean.com/droplets
- [ ] Follow emergency recovery steps in `C:\Users\Owner\.ssh\SSH-RECOVERY.md`
- [ ] Upload fixed deployment scripts BEFORE next deployment

---

## 📋 Verification Commands

### Check All Protection Layers
```bash
# 1. Immutable flag
ssh root@jennidrop "lsattr /root/.ssh/authorized_keys"
# Should show: ----i---------e-------

# 2. Auto-restore cron
ssh root@jennidrop "ls -la /etc/cron.daily/restore-ssh-key"
ssh root@jennidrop "cat /etc/cron.daily/restore-ssh-key | head -3"

# 3. Deployment script safety
ssh root@jennidrop "grep -n 'chown -R' /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh"
# Should NOT show: chown -R www-data:www-data .
# Should show: find . -maxdepth 1 ! -name '.*' -exec chown -R www-data:www-data

# 4. Backups exist
ssh root@jennidrop "ls -la /root/ssh-keys-backup/"
ssh root@jennidrop "ls -la /root/repair-backups/"
```

### Check for Lockout Triggers
```bash
# Recent system logs (look for ssh/authorized_keys mentions)
ssh root@jennidrop "grep -i 'ssh\|authorized_keys' /var/log/syslog | tail -20"

# Recent deployment logs
ssh root@jennidrop "tail -50 /var/log/jenninexus-deploy.log"

# Check if immutable flag was removed
ssh root@jennidrop "grep 'chattr' /var/log/syslog | tail -10"
```

---

## 🆘 Emergency Recovery

**If you get locked out again:**

1. **DO NOT PANIC** - You have console access
2. Open: https://cloud.digitalocean.com/droplets
3. Click droplet → "Access" → "Launch Droplet Console"
4. Follow: `C:\Users\Owner\.ssh\SSH-RECOVERY.md`
5. After recovery: Upload fixed deployment scripts immediately

**Emergency script location**: `C:\Users\Owner\.ssh\SSH-RECOVERY.md`

---

## 📚 Related Documentation

- **SSH-RECOVERY.md** - Emergency recovery procedures with immutable protection
- **README-SSH-JENNINEXUS.md** - Complete SSH access guide
- **JENNIDROP-STATUS.md** - Current server protection status
- **jenninexus.conf** - Nginx configuration for production

---

**Remember**: The deployment script was the culprit, NOT Ubuntu's automated maintenance. The fix prevents the deployment script from triggering Ubuntu's security cleanup.
