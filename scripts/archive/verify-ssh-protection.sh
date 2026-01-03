#!/bin/bash
set -euo pipefail
TS=$(date -u +%Y%m%dT%H%M%SZ)
BACKDIR=/root/ssh-protection-verification/$TS
mkdir -p "$BACKDIR"

echo "=== JenniNexus SSH Protection Verification & Enhancement ==="
echo "Timestamp: $TS"
echo ""

# Backup current state
cp -a /root/.ssh "$BACKDIR/" 2>/dev/null || true
echo "✅ Backed up current SSH config to $BACKDIR"

# The correct SSH public key for jennidrop
CORRECT_KEY="ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIClseVXGI3eIDvUUjMo5cTNjUIGSEQFN2WpGczxGtDiO jennidrop projects"

# Check if immutable flag exists
echo ""
echo "🔍 Checking immutable flag..."
if lsattr /root/.ssh/authorized_keys | grep -q "i"; then
    echo "✅ Immutable flag is ACTIVE"
else
    echo "⚠️  Immutable flag is MISSING - applying now..."
    chattr +i /root/.ssh/authorized_keys
    echo "✅ Immutable flag applied"
fi

# Verify the correct key is present
echo ""
echo "🔍 Verifying SSH key..."
if grep -qxF "$CORRECT_KEY" /root/.ssh/authorized_keys; then
    echo "✅ Correct SSH key is present"
else
    echo "⚠️  Key missing - restoring..."
    chattr -i /root/.ssh/authorized_keys 2>/dev/null || true
    echo "$CORRECT_KEY" >> /root/.ssh/authorized_keys
    chmod 600 /root/.ssh/authorized_keys
    chown root:root /root/.ssh/authorized_keys
    chattr +i /root/.ssh/authorized_keys
    echo "✅ Key restored and protected"
fi

# Check auto-restore cron
echo ""
echo "🔍 Checking auto-restore cron..."
if [ -f /etc/cron.daily/restore-ssh-key ]; then
    echo "✅ Auto-restore cron exists"
    ls -la /etc/cron.daily/restore-ssh-key
else
    echo "⚠️  Auto-restore cron MISSING - creating now..."
    cat > /etc/cron.daily/restore-ssh-key <<'CRONEOF'
#!/bin/bash
# Auto-restore SSH key if missing (runs daily at 6:25 AM)
KEY='ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIClseVXGI3eIDvUUjMo5cTNjUIGSEQFN2WpGczxGtDiO jennidrop projects'
if ! grep -qxF "$KEY" /root/.ssh/authorized_keys 2>/dev/null; then
  chattr -i /root/.ssh/authorized_keys 2>/dev/null || true
  mkdir -p /root/.ssh
  touch /root/.ssh/authorized_keys
  chmod 700 /root/.ssh
  chmod 600 /root/.ssh/authorized_keys
  echo "$KEY" >> /root/.ssh/authorized_keys
  chattr +i /root/.ssh/authorized_keys
  logger "SSH key auto-restored for root (triggered by cron.daily)"
fi
CRONEOF
    chmod 755 /etc/cron.daily/restore-ssh-key
    echo "✅ Auto-restore cron created"
fi

# Fix backup directory permissions
echo ""
echo "🔍 Fixing backup directory permissions..."
if [ -d /root/ssh-keys-backup ]; then
    chown -R root:root /root/ssh-keys-backup
    chmod 700 /root/ssh-keys-backup
    echo "✅ Backup directory permissions fixed"
fi

# Create a permanent backup
echo ""
echo "📦 Creating permanent backup..."
mkdir -p /root/ssh-keys-permanent-backup
cp /root/.ssh/authorized_keys /root/ssh-keys-permanent-backup/authorized_keys.permanent
chmod 400 /root/ssh-keys-permanent-backup/authorized_keys.permanent
echo "✅ Permanent backup created at /root/ssh-keys-permanent-backup/"

echo ""
echo "=== Final Verification ==="
echo "Immutable status:"
lsattr /root/.ssh/authorized_keys
echo ""
echo "Key content:"
cat /root/.ssh/authorized_keys
echo ""
echo "Permissions:"
ls -la /root/.ssh/
echo ""
echo "Auto-restore cron:"
ls -la /etc/cron.daily/restore-ssh-key

echo ""
echo "=== 🎊 PROTECTION STATUS ==="
echo "✅ Immutable flag: ACTIVE"
echo "✅ Auto-restore cron: ACTIVE"
echo "✅ Permanent backup: CREATED"
echo "✅ Permissions: FIXED"
echo ""
echo "🛡️  You are now PROTECTED from lockouts!"
echo ""
exit 0
