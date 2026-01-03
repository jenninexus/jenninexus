# JenniNexus Post-Deployment Guide

**Last Updated**: November 18, 2025  
**Server**: 64.23.141.41 (SSH Alias: jennidrop-root)  
**Deploy User**: root (SSH key: id_jennidrop.openssh)

---

## 📋 Complete Deployment Workflow

This guide covers the **complete deployment process** from local build to production verification.

### Prerequisites

- SSH access to 64.23.141.41 server as root
- SSH key: `C:\Users\Owner\.ssh\id_jennidrop.openssh` (Windows) or `~/.ssh/id_jennidrop.openssh` (Linux/Mac)
- SSH alias configured: `jennidrop-root` → `root@64.23.141.41` (see `~/.ssh/config`)

---

## 🚀 Full Deployment Process

### Step 1: Build Locally (Windows PowerShell)

```powershell
# Navigate to project directory
cd C:\Users\Owner\Projects\www\jenninexus

# Run complete build pipeline (compiles CSS, minifies, copies assets)
.\scripts\build-all.ps1

# Package for deployment (creates deploy/jenninexus/ with 534+ files)
.\scripts\build-and-deploy.ps1
```

**What build-all.ps1 does:**
- Fixes duplicate navigation in PHP pages
- Copies assets from `src/assets/` to `public_html/resources/`
- Minifies CSS files (custom.css → custom.min.css)
- Verifies router and nginx configuration
- Total: ~295 files processed

**What build-and-deploy.ps1 does:**
- Cleans old HTML files
- Verifies all PHP pages exist
- Copies everything to `deploy/jenninexus/`
- Total: 534+ files packaged

### Step 2: Deploy to Server (Windows PowerShell)

```powershell
# Upload all files via SCP (using SSH alias)
scp -r deploy\jenninexus\public_html\* jennidrop-root:/var/www/jenninexus/public_html/

# Alternative: Use direct IP with identity file
scp -i C:\Users\Owner\.ssh\id_jennidrop.openssh -r deploy\jenninexus\public_html\* root@64.23.141.41:/var/www/jenninexus/public_html/

# Or use deploy.ps1 script (interactive)
.\scripts\deploy.ps1 -BuildOnly:$false
```

**Deployment confirmation:**
- Files uploaded to: `/var/www/jenninexus/public_html/`
- Typical upload: 534 files (~150 MB with PDFs)
- Upload time: 30-60 seconds on good connection
- **Automatic Permission Fix:** `deploy.ps1` automatically runs `fix-permissions-jenninexus-remote.sh` after upload.

### Step 3: Fix Permissions on Server

*Note: If you used `deploy.ps1`, this step is done automatically.*

**From Windows (recommended):**
```powershell
# Using SSH alias
ssh jennidrop-root "cd /var/www/jenninexus && bash scripts/fix-permissions-jenninexus-remote.sh"

# Or with explicit identity file
ssh -i C:\Users\Owner\.ssh\id_jennidrop.openssh root@64.23.141.41 "cd /var/www/jenninexus && bash scripts/fix-permissions-jenninexus-remote.sh"
```

**Or connect and run manually:**
```bash
# Using alias
ssh jennidrop-root
cd /var/www/jenninexus
bash scripts/fix-permissions-jenninexus-remote.sh
```

**What fix-permissions-jenninexus-remote.sh does:**
- Sets ownership: `www-data:www-data` for all site files
- File permissions: 644 (readable by web server)
- Directory permissions: 755 (executable/listable)
- Storage directories: 775 (writable by PHP)
- Secrets: 600/700 (owner-only access)
- Verifies SSH key protection (immutable flag)
- Creates required directories if missing
- Logs to: `/var/log/jenninexus-deploy.log`

**Expected output confirmation:**
```
✅ SSH key immutable flag verified (still protected)
✅ Correct SSH key verified in /root/.ssh/authorized_keys
✅ SSH key permissions correct (600, owned by root)
✅ Jenninexus permissions and symlinks fixed successfully
```

### Step 4: Reload Web Services

**From Windows:**
```powershell
# Reload nginx to pick up any changes (using SSH alias)
ssh jennidrop-root "systemctl reload nginx"

# Optional: Also reload PHP-FPM if PHP files changed significantly
ssh jennidrop-root "systemctl reload php8.3-fpm"

# Or with explicit identity file
ssh -i C:\Users\Owner\.ssh\id_jennidrop.openssh root@64.23.141.41 "systemctl reload nginx"
```

**Or on server:**
```bash
systemctl reload nginx
systemctl reload php8.3-fpm

# Verify services are running
systemctl status nginx --no-pager
systemctl status php8.3-fpm --no-pager
```

**Expected nginx output:**
```
● nginx.service - A high performance web server and a reverse proxy server
   Loaded: loaded (/usr/lib/systemd/system/nginx.service; enabled; preset: enabled)
   Active: active (running) since [timestamp]
```

### Step 5: Verify Deployment

**From Windows:**
```powershell
# Test site is accessible
curl -I https://jenninexus.com

# Check specific pages
curl -I https://jenninexus.com/gamedev
curl -I https://jenninexus.com/blog
```

**On server (verify file counts):**
```bash
# Connect using SSH alias
ssh jennidrop-root

# Count deployed files (should be 534+)
find /var/www/jenninexus/public_html -type f | wc -l

# Verify blog pages (should be 10)
ls -la /var/www/jenninexus/public_html/blog/*.php | wc -l

# Verify game pages (should be 13)
ls -la /var/www/jenninexus/public_html/game/*.php | wc -l

# Check recent deployment logs
tail -100 /var/log/jenninexus-deploy.log
```

---

## 🔧 Manual Deployment Steps (Alternative)

If automated scripts fail, use these manual steps:

### 1. Build Assets Manually

```powershell
cd C:\Users\Owner\Projects\www\jenninexus

# Step 1: Fix page consistency
.\scripts\fix-all-pages-consistency.ps1

# Step 2: Build assets
.\scripts\build.ps1

# Step 3: Optimize CSS/JS
.\scripts\optimize-assets.ps1

# Step 4: Package deployment
.\scripts\build-and-deploy.ps1
```

### 2. Upload Manually via SCP

```powershell
# Upload everything (using SSH alias)
scp -r deploy\jenninexus\public_html\* jennidrop-root:/var/www/jenninexus/public_html/

# Or with explicit identity file
scp -i C:\Users\Owner\.ssh\id_jennidrop.openssh -r deploy\jenninexus\public_html\* root@64.23.141.41:/var/www/jenninexus/public_html/

# Or upload specific directories
scp -r deploy\jenninexus\public_html\includes\* jennidrop-root:/var/www/jenninexus/public_html/includes/
scp -r deploy\jenninexus\public_html\resources\css\* jennidrop-root:/var/www/jenninexus/public_html/resources/css/
```

### 3. Fix Permissions Manually on Server

```bash
# Connect using SSH alias
ssh jennidrop-root

cd /var/www/jenninexus

# Set base ownership
chown -R www-data:www-data public_html/
chown -R www-data:www-data storage/

# Set base permissions
find public_html/ -type d -exec chmod 755 {} \;
find public_html/ -type f -exec chmod 644 {} \;
find storage/ -type d -exec chmod 775 {} \;
find storage/ -type f -exec chmod 664 {} \;

# Secure secrets
chmod 750 storage/secrets/
chmod 600 storage/secrets/patreon.json
chown www-data:www-data storage/secrets/patreon.json

# Secure Patreon storage
chmod 750 storage/patreon/
chmod 700 storage/patreon/webhooks/
chmod 600 storage/patreon/*.json
chown -R www-data:www-data storage/patreon/
```

---

---

## 📊 Expected Permissions Summary

After running `fix-permissions-jenninexus-remote.sh`, verify these permissions:

```bash
# Main site directories
drwxr-xr-x  www-data www-data  /var/www/jenninexus/
drwxr-xr-x  www-data www-data  /var/www/jenninexus/public_html/
drwxr-xr-x  www-data www-data  /var/www/jenninexus/public_html/includes/
drwxr-xr-x  www-data www-data  /var/www/jenninexus/public_html/resources/

# PHP files (all pages)
-rw-r--r--  www-data www-data  /var/www/jenninexus/public_html/*.php
-rw-r--r--  www-data www-data  /var/www/jenninexus/public_html/blog/*.php
-rw-r--r--  www-data www-data  /var/www/jenninexus/public_html/game/*.php

# CSS/JS files
-rw-r--r--  www-data www-data  /var/www/jenninexus/public_html/resources/css/*.css
-rw-r--r--  www-data www-data  /var/www/jenninexus/public_html/resources/js/*.js
-rw-r--r--  www-data www-data  /var/www/jenninexus/public_html/resources/vendor/fontawesome/css/all.min.css

# Storage directories (writable by PHP)
drwxrwxr-x  www-data www-data  /var/www/jenninexus/storage/
drwxrwxr-x  www-data www-data  /var/www/jenninexus/storage/cache/
drwxrwxr-x  www-data www-data  /var/www/jenninexus/storage/logs/

# Secrets (owner-only access)
drwxr-x---  www-data www-data  /var/www/jenninexus/storage/secrets/
-rw-------  www-data www-data  /var/www/jenninexus/storage/secrets/patreon.json

# Patreon storage (restricted)
drwxr-x---  www-data www-data  /var/www/jenninexus/storage/patreon/
-rw-------  www-data www-data  /var/www/jenninexus/storage/patreon/tokens.json
-rw-------  www-data www-data  /var/www/jenninexus/storage/patreon/user.json
drwx------  www-data www-data  /var/www/jenninexus/storage/patreon/webhooks/

# SSH key protection (CRITICAL)
-rw-------  root     root      /root/.ssh/authorized_keys
# Immutable flag MUST be set: lsattr shows ----i---------e-------
```

**Verification commands:**
```bash
# Check secrets
ls -la /var/www/jenninexus/storage/secrets/patreon.json
# Expected: -rw------- 1 www-data www-data [size] [date] patreon.json

# Check Patreon storage
ls -laR /var/www/jenninexus/storage/patreon/
# All files should be 600 (www-data:www-data)
# webhooks/ directory should be 700 (www-data:www-data)

# Check SSH key immutable flag
lsattr /root/.ssh/authorized_keys
# Expected: ----i---------e------- /root/.ssh/authorized_keys

# Count files
find /var/www/jenninexus/public_html -type f | wc -l
# Expected: 534+ files
```

---

## 🔒 Security Checklist

After every deployment, verify:

- [ ] **SSH Access Still Works**: Test `ssh root@jennidrop` before closing terminal
- [ ] **SSH Key Immutable Flag**: `lsattr /root/.ssh/authorized_keys` shows `i` flag
- [ ] **Secrets File Secure**: `storage/secrets/patreon.json` is 600, owned by www-data
- [ ] **Patreon Storage Secure**: `storage/patreon/` is 750, all files 600
- [ ] **Site Accessible**: `curl -I https://jenninexus.com` returns 200 OK
- [ ] **No PHP Errors**: Check `/var/log/nginx/jenninexus.error.log` for errors
- [ ] **Nginx Running**: `systemctl status nginx` shows active (running)
- [ ] **PHP-FPM Running**: `systemctl status php8.3-fpm` shows active (running)

---

## 🚨 Troubleshooting

### Problem: CSS Not Updating on Live Site

**Cause**: Browser cache or nginx cache with 1-year expiry

**Solution**:
1. Hard refresh browser: `Ctrl+Shift+R` (Windows) or `Cmd+Shift+R` (Mac)
2. Or try incognito/private browsing mode
3. Check CSS file timestamp on server:
   ```bash
   ls -la /var/www/jenninexus/public_html/resources/css/custom.min.css
   ```
4. Clear nginx cache if using proxy cache (not currently configured)

### Problem: 502 Bad Gateway Error

**Cause**: PHP-FPM not running or misconfigured

**Solution**:
```bash
# Check PHP-FPM status
systemctl status php8.3-fpm

# Restart if needed
systemctl restart php8.3-fpm

# Check PHP-FPM logs
tail -100 /var/log/php8.3-fpm.log
```

### Problem: Permission Denied Errors

**Cause**: Files not owned by www-data or wrong permissions

**Solution**:
```bash
# Run fix-permissions script again
cd /var/www/jenninexus
bash scripts/fix-permissions-jenninexus-remote.sh

# Or manually fix
chown -R www-data:www-data /var/www/jenninexus/public_html/
chown -R www-data:www-data /var/www/jenninexus/storage/
```

### Problem: SSH Access Lost After Deployment

**Cause**: SSH key file was accidentally modified

**Solution**:
1. **DO NOT PANIC** - Auto-restore cron runs daily at 6:25 AM UTC
2. Use DigitalOcean console to access server
3. Manually restore from backup:
   ```bash
   cp /root/ssh-keys-permanent-backup/authorized_keys.permanent /root/.ssh/authorized_keys
   chmod 600 /root/.ssh/authorized_keys
   chattr +i /root/.ssh/authorized_keys
   ```
4. Verify SSH key content:
   ```bash
   cat /root/.ssh/authorized_keys
   # Should contain: ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIClseVXGI3eIDvUUjMo5cTNjUIGSEQFN2WpGczxGtDiO jennidrop projects
   ```

### Problem: Patreon Integration Not Working

**Cause**: Secrets file missing or wrong permissions

**Solution**:
```bash
# Check secrets file exists
ls -la /var/www/jenninexus/storage/secrets/patreon.json

# Fix permissions if needed
chmod 600 /var/www/jenninexus/storage/secrets/patreon.json
chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json

# Verify JSON is valid
cat /var/www/jenninexus/storage/secrets/patreon.json | jq .
# Should parse without errors

# Check PHP can read it
su -s /bin/bash www-data -c "cat /var/www/jenninexus/storage/secrets/patreon.json"
```

---

## 📝 Deployment Log Template

Use this template to document each deployment:

```markdown
## Deployment - [Date] [Time UTC]

**Deployed By**: [Your Name]
**Commit/Version**: [Git commit hash or version number]
**Files Changed**: [Number] files

### Changes Deployed:
- [ ] Navbar glass effect fix
- [ ] Mobile menu improvements
- [ ] [Other changes]

### Build Steps:
1. ✅ Ran build-all.ps1
2. ✅ Ran build-and-deploy.ps1
3. ✅ Uploaded via SCP (534 files)
4. ✅ Ran fix-permissions script
5. ✅ Reloaded nginx
6. ✅ Verified site accessible

### Verification:
- [ ] Site loads: https://jenninexus.com
- [ ] No PHP errors in logs
- [ ] CSS changes visible (hard refresh)
- [ ] Mobile menu works
- [ ] SSH access still works

### Issues Encountered:
- None / [Describe any issues and resolutions]

### Notes:
- [Any additional notes for future reference]
```

---

## 🔄 Rollback Procedure

If deployment causes issues, rollback to previous version:

### Quick Rollback (if backup exists on server)

```bash
ssh root@jennidrop

# Check available backups
ls -la /var/www/jenninexus/storage/deploys/

# Find most recent backup before this deployment
# Example: jenninexus_deploy.20251106T140000Z.tar.gz

# Create backup of current broken state
BACKUP_TS=$(date -u +%Y%m%dT%H%M%SZ)
tar -czf /var/www/jenninexus/storage/deploys/jenninexus_broken.$BACKUP_TS.tar.gz \
  -C /var/www jenninexus/public_html

# Restore from backup
RESTORE_FILE="/var/www/jenninexus/storage/deploys/jenninexus_deploy.20251106T140000Z.tar.gz"
mkdir -p /tmp/jenn_restore
tar -xzf "$RESTORE_FILE" -C /tmp/jenn_restore
rsync -a --delete /tmp/jenn_restore/jenninexus/public_html/ /var/www/jenninexus/public_html/

# Fix permissions
cd /var/www/jenninexus
bash scripts/fix-permissions-jenninexus-remote.sh

# Reload services
systemctl reload nginx
systemctl reload php8.3-fpm

# Verify rollback
curl -I https://jenninexus.com
```

### Full Rebuild and Redeploy (from local backup)

```powershell
# On Windows workstation

# 1. Check out previous commit
git log --oneline -20  # Find commit to rollback to
git checkout [commit-hash]

# 2. Rebuild
cd C:\Users\Owner\Projects\www\jenninexus
.\scripts\build-all.ps1
.\scripts\build-and-deploy.ps1

# 3. Redeploy
scp -r deploy\jenninexus\public_html\* root@jennidrop:/var/www/jenninexus/public_html/

# 4. Fix permissions on server
ssh root@jennidrop "cd /var/www/jenninexus && bash scripts/fix-permissions-jenninexus-remote.sh"

# 5. Reload nginx
ssh root@jennidrop "systemctl reload nginx"

# 6. Return to latest code (optional)
git checkout main
```

---

## 📚 Related Documentation

- **Build Process**: `storage/docs/DEPLOYMENT-GUIDE.md` - Complete build workflow
- **Bootstrap Integration**: `storage/docs/BOOTSTRAP-5.3.8.md` - CSS framework details
- **JavaScript Architecture**: `storage/docs/JS.md` - All custom JS files explained
- **CSS Architecture**: `storage/docs/CSS-SCSS.md` - Custom styling documentation
- **SSH Setup**: `C:\Users\Owner\.ssh\README-SSH-JENNINEXUS.md` - SSH key configuration
- **Session Logs**: `storage/[YYYY-MM-DD].md` - Daily session documentation

---

## 🔐 SSH Key Management

### Current SSH Configuration

**Local Key Location (Windows)**:
- Private key (OpenSSH): `C:\Users\Owner\.ssh\id_jennidrop.openssh`
- Private key (PuTTY): `C:\Users\Owner\.ssh\id_jennidrop.ppk`
- Public key: `C:\Users\Owner\.ssh\id_jennidrop.pub`

**Server Key Location**:
- Authorized keys: `/root/.ssh/authorized_keys`
- Backup: `/root/ssh-keys-permanent-backup/authorized_keys.permanent`
- Permissions: 600, owned by root:root
- Immutable flag: MUST be set (`chattr +i`)

**SSH Aliases in `~/.ssh/config`**:
```
Host jennidrop
    HostName 64.23.141.41
    User root
    IdentityFile ~/.ssh/id_jennidrop.openssh
    Port 22

Host main-studio
    HostName 64.23.141.41
    User root
    IdentityFile ~/.ssh/id_jennidrop.openssh
    Port 22
```

### SSH Key Protection (4 Layers)

1. **Immutable Flag**: Prevents deletion/modification
   ```bash
   lsattr /root/.ssh/authorized_keys
   # Expected: ----i---------e------- 
   ```

2. **Auto-Restore Cron**: Runs daily at 6:25 AM UTC
   ```bash
   crontab -l | grep authorized_keys
   # Expected: 25 6 * * * cp /root/ssh-keys-permanent-backup/authorized_keys.permanent /root/.ssh/authorized_keys && chmod 600 /root/.ssh/authorized_keys && chattr +i /root/.ssh/authorized_keys
   ```

3. **Backup User**: `jenni` user has backup SSH access
   ```bash
   ls -la /home/jenni/.ssh/authorized_keys
   ```

4. **Safe Scripts**: `fix-permissions-jenninexus-remote.sh` NEVER touches `/root/.ssh/`

### Verifying SSH Key After Deployment

Always verify SSH access is still working after deployment:

```bash
# From Windows
ssh -i C:\Users\Owner\.ssh\id_jennidrop.openssh root@jennidrop "echo 'SSH works'"

# Expected output: SSH works
```

If SSH fails, see "Troubleshooting: SSH Access Lost After Deployment" section above.

---

## 📞 Support and Maintenance

### Server Details

- **Provider**: DigitalOcean
- **Droplet Name**: jennidrop
- **IP**: 64.23.141.41
- **OS**: Ubuntu 24.10
- **Web Server**: Nginx 1.26
- **PHP**: 8.3-FPM
- **SSL**: Let's Encrypt (auto-renewed)

### Access Methods

1. **SSH (Primary)**: `ssh jennidrop-root`
2. **DigitalOcean Console**: Use if SSH access lost
3. **Backup User**: `ssh jenni@64.23.141.41` (emergency)

### Log Locations

```bash
# Deployment logs
/var/log/jenninexus-deploy.log

# Nginx logs
/var/log/nginx/jenninexus.access.log
/var/log/nginx/jenninexus.error.log

# PHP-FPM logs
/var/log/php8.3-fpm.log

# System logs
journalctl -u nginx -n 100
journalctl -u php8.3-fpm -n 100
```

### Monitoring Commands

```bash
# Check disk space
df -h

# Check memory usage
free -h

# Check running processes
ps aux | grep nginx
ps aux | grep php-fpm

# Check open ports
ss -tulpn | grep LISTEN

# Check recent logins
last -20

# Check system load
uptime
top -bn1 | head -20
```

---

**Last Verified**: November 6, 2025  
**Maintained By**: JenniNexus Development Team  
**Next Review**: Monthly or after major deployments
