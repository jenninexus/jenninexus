#!/usr/bin/env bash

# Remote permission fixes for JenniNexus
# Run on production server as root

set -euo pipefail

# Default behavior: perform actions. Use --dry-run to print only.
DRY_RUN=0
LOGFILE="/var/log/jenninexus-deploy.log"

usage() {
    cat <<EOF
Usage: $0 [--dry-run] [--logfile /path/to/log]
    --dry-run    : Print actions without applying changes
    --logfile    : Path to append run log (default: $LOGFILE)
EOF
    exit 1
}

while [[ $# -gt 0 ]]; do
    case "$1" in
        --dry-run)
            DRY_RUN=1; shift ;;
        --logfile)
            LOGFILE="$2"; shift 2 ;;
        -h|--help)
            usage ;;
        *)
            echo "Unknown arg: $1"; usage ;;
    esac
done

log() {
    local msg="$1"
    echo "$(date -Iseconds) $msg" | tee -a "$LOGFILE"
}

run() {
    # run <command string> - respects dry-run
    if [ "$DRY_RUN" -eq 1 ]; then
        echo "[DRY-RUN] $*" | tee -a "$LOGFILE"
    else
        echo "+ $*" | tee -a "$LOGFILE"
        eval "$@" 2>&1 | tee -a "$LOGFILE"
    fi
}

log "=== JenniNexus permissions helper started ==="

# Navigate to project root (be tolerant if path changes)
if [ -d /var/www/jenninexus ]; then
    cd /var/www/jenninexus
    log "Changed directory to $(pwd)"
else
    log "ERROR: /var/www/jenninexus not found"; exit 2
fi

# 🔐 CRITICAL: Protect /root/.ssh from chown operations
# The immutable flag on authorized_keys prevents deletion, but chown still tries
# to change ownership which can trigger system security scripts to remove the key.
# NEVER run chown -R on paths that might contain /root/.ssh or /.ssh directories.
log "🛡️  Protecting SSH directories from ownership changes"

# SAFETY CHECK: Ensure we're NEVER touching /root or any .ssh directories
if [[ "$PWD" == "/root"* ]] || [[ "$PWD" == *"/.ssh"* ]]; then
    log "❌ SAFETY ABORT: Current directory is in /root or .ssh path: $PWD"
    log "This script should only run from /var/www/jenninexus"
    exit 99
fi

# Basic ownership: ensure www-data owns site tree (idempotent)
# EXCLUDE hidden directories (especially .ssh) to prevent lockout
# EXCLUDE /root entirely to be absolutely safe
run "find . -maxdepth 1 ! -name '.*' ! -path '/root*' -exec chown -R www-data:www-data '{}' + 2>/dev/null || true"

# Base perms: dirs 755 files 644
run "find . -type d -exec chmod 755 '{}' ';' || true"
run "find . -type f -exec chmod 644 '{}' ';' || true"

# Writable runtime dirs (create if missing)
run "mkdir -p storage/cache storage/logs storage/sessions public_html/resources public_html/resources/media"
run "chown -R www-data:www-data storage public_html/resources || true"
run "chmod -R 775 storage || true"

# Ensure YouTube cache dir exists in the canonical storage location and is secured
run "mkdir -p storage/cache/youtube || true"
run "chown -R www-data:www-data storage/cache || true"
run "chmod -R 775 storage/cache || true"

# If a legacy cache exists under public_html, inform operator (do not auto-move)
if [ -d public_html/storage/cache/youtube ]; then
    log "⚠️  Legacy YouTube cache detected at public_html/storage/cache/youtube"
    log "Run scripts/move-youtube-cache.sh on the server to safely migrate files to storage/cache/youtube"
fi

# Secure server-only secrets dir
run "mkdir -p storage/secrets"
run "chown -R www-data:www-data storage/secrets || true"
run "chmod -R 700 storage/secrets || true"

# Ensure the secrets file (if present) is locked down
if [ -f storage/secrets/secrets.json ]; then
    run "chown www-data:www-data storage/secrets/secrets.json || true"
    run "chmod 600 storage/secrets/secrets.json || true"
fi

# Ensure Patreon storage and webhook dirs exist and are secured
run "mkdir -p storage/patreon storage/patreon/webhooks"
run "chown -R www-data:www-data storage/patreon || true"
run "chmod -R 750 storage/patreon || true"
run "chmod -R 700 storage/patreon/webhooks || true"

# If setfacl is available, set default ACLs so files created under storage/patreon
# are not group- or world-writable (helps when PHP's umask allows group-write).
if command -v setfacl >/dev/null 2>&1; then
    log "🔐 Setting default ACLs on storage/patreon to enforce 600/700 defaults"
    # Default for directories: u::rwx,g::---,o::--- (new files inherit restrictive mask)
    run "setfacl -R -m d:u::rwx,d:g::---,d:o::--- storage/patreon || true"
    # Ensure the directory itself has the restrictive ACL as well
    run "setfacl -R -m u::rwx,g::---,o::--- storage/patreon || true"
fi

# Ensure expected token/user files exist and are owner-locked
run "mkdir -p storage/patreon"
if [ ! -f storage/patreon/tokens.json ]; then
    run "touch storage/patreon/tokens.json || true"
fi
if [ ! -f storage/patreon/user.json ]; then
    run "touch storage/patreon/user.json || true"
fi
run "chown www-data:www-data storage/patreon/tokens.json storage/patreon/user.json || true"
run "chmod 600 storage/patreon/tokens.json storage/patreon/user.json || true"

# Ensure all regular files under storage/patreon are owner-only readable/writable (600)
# but keep webhooks directory itself restricted (700) and webhooks files 600.
run "find storage/patreon -maxdepth 1 -type f -exec chmod 600 '{}' ';' || true"
run "if [ -d storage/patreon/webhooks ]; then find storage/patreon/webhooks -type d -exec chmod 700 '{}' ';' || true; find storage/patreon/webhooks -type f -exec chmod 600 '{}' ';' || true; fi"
run "if [ -f storage/patreon/posts_cache.json ]; then chmod 600 storage/patreon/posts_cache.json || true; fi"

# Secure server-only Patreon secrets file if present, and assert its owner/perms
PATREON_SECRETS=storage/secrets/patreon.json
if [ -f "$PATREON_SECRETS" ]; then
    log "🔐 Found Patreon secrets file: $PATREON_SECRETS — verifying owner and permissions"
    # Ensure ownership and strict mode
    run "chown www-data:www-data $PATREON_SECRETS || true"
    run "chmod 600 $PATREON_SECRETS || true"

    # Report current stat for operator visibility
    run "stat -c '%A %U %G %a %n' $PATREON_SECRETS || true"

    # Programmatic assertion: if owner != www-data or mode != 600, attempt to fix (already attempted above)
    OWNER=$(stat -c '%U' "$PATREON_SECRETS" 2>/dev/null || echo "") || true
    MODE=$(stat -c '%a' "$PATREON_SECRETS" 2>/dev/null || echo "") || true
    if [ "$OWNER" != "www-data" ] || [ "$MODE" != "600" ]; then
        log "⚠️  Patreon secrets had unexpected owner/mode ($OWNER/$MODE) — re-applying strict ownership and mode"
        run "chown www-data:www-data $PATREON_SECRETS || true"
        run "chmod 600 $PATREON_SECRETS || true"
        run "stat -c '%A %U %G %a %n' $PATREON_SECRETS || true"
    else
        log "Locked down $PATREON_SECRETS"
    fi
else
    log "Note: $PATREON_SECRETS not present — create on server and chmod 600"
fi

# Ensure a default secrets fallback (dev) is not world-readable
if [ -f public_html/resources/playlists/secrets.json ]; then
    run "chown www-data:www-data public_html/resources/playlists/secrets.json || true"
    run "chmod 600 public_html/resources/playlists/secrets.json || true"
fi

# Resources: readable by webserver
if [ -d public_html/resources ]; then
    run "chown -R www-data:www-data public_html/resources || true"
    run "find public_html/resources -type d -exec chmod 755 '{}' ';' || true"
    run "find public_html/resources -type f -exec chmod 644 '{}' ';' || true"
fi

# Videos directory: ensure web-readable permissions for .mp4 files
if [ -d public_html/resources/videos ]; then
    log "🎥 Setting permissions for videos directory"
    run "mkdir -p public_html/resources/videos || true"
    run "chown -R www-data:www-data public_html/resources/videos || true"
    run "find public_html/resources/videos -type d -exec chmod 755 '{}' ';' || true"
    run "find public_html/resources/videos -type f -name '*.mp4' -exec chmod 644 '{}' ';' || true"
    run "find public_html/resources/videos -type f -name '*.webm' -exec chmod 644 '{}' ';' || true"
    VIDEO_COUNT=$(find public_html/resources/videos -type f \( -name '*.mp4' -o -name '*.webm' \) | wc -l | tr -d ' ' || echo 0)
    log "ℹ️  public_html/resources/videos contains ${VIDEO_COUNT:-0} video files"
fi

# Media downloads: tighter perms
if [ -d public_html/resources/media ]; then
    run "chown -R www-data:www-data public_html/resources/media || true"
    run "find public_html/resources/media -type d -exec chmod 750 '{}' ';' || true"
    run "find public_html/resources/media -type f -exec chmod 640 '{}' ';' || true"
fi

# Set executable permissions for scripts in scripts/
run "find scripts/ -name '*.sh' -exec chmod +x '{}' ';' 2>/dev/null || true"

# Remove legacy symlinks (if present)
cd public_html || true
if [ -L shared ]; then
    log "ℹ️  Removing legacy symlink: public_html/shared"
    run "rm -f shared || true"
fi
cd .. || true
if [ -L vendor ]; then
    log "ℹ️  Removing legacy symlink: vendor"
    run "rm -rf vendor || true"
fi

log "✅ Symlink cleanup complete (site is self-contained)"

# Verify and list key directories (non-fatal)
log "🔍 Verifying key directories and symlinks:"
run "ls -la public_html || true"
if [ -L public_html/shared ]; then
    log "ℹ️  public_html/shared is a symlink (legacy):"
    run "ls -la public_html/shared || true"
else
    log "ℹ️  No public_html/shared symlink present"
fi

if [ -L vendor ]; then
    log "ℹ️  vendor is a symlink (legacy):"
    run "ls -la vendor || true"
else
    log "ℹ️  No vendor symlink present"
fi

if [ -d public_html/resources/media ]; then
    log "🔍 resources/media listing (permissions summary):"
    run "ls -la public_html/resources/media || true"
fi

# Verify blog and game page directories exist and report counts
if [ -d public_html/blog ]; then
    BLOG_COUNT=$(find public_html/blog -maxdepth 1 -type f -name '*.php' | wc -l | tr -d ' ' || true)
    log "ℹ️  public_html/blog contains ${BLOG_COUNT:-0} PHP files"
    run "ls -la public_html/blog || true"
else
    log "⚠️  public_html/blog missing — expected blog posts under public_html/blog"
fi

if [ -d public_html/game ]; then
    GAME_COUNT=$(find public_html/game -maxdepth 1 -type f -name '*.php' | wc -l | tr -d ' ' || true)
    log "ℹ️  public_html/game contains ${GAME_COUNT:-0} PHP files"
    run "ls -la public_html/game || true"
else
    log "⚠️  public_html/game missing — expected game pages under public_html/game"
fi

# Ensure blog/game files and directories have expected base perms (reinforce)
if [ -d public_html/blog ]; then
    run "find public_html/blog -type d -exec chmod 755 '{}' ';' || true"
    run "find public_html/blog -type f -exec chmod 644 '{}' ';' || true"
fi
if [ -d public_html/game ]; then
    run "find public_html/game -type d -exec chmod 755 '{}' ';' || true"
    run "find public_html/game -type f -exec chmod 644 '{}' ';' || true"
fi

# Sanity checks: detect accidental nesting like /var/www/jenninexus/scripts/public_html
if [ -d scripts/public_html ] || [ -d scripts/storage ]; then
    log "⚠️  Detected nested deploy folders under scripts/: scripts/public_html or scripts/storage"
    log "This often happens when the deploy package was created incorrectly and placed public_html under scripts/."
    log "Suggested fix (run as root):"
    log "  mv -v /var/www/jenninexus/scripts/public_html/* /var/www/jenninexus/public_html/ || true"
    log "  mv -v /var/www/jenninexus/scripts/storage/* /var/www/jenninexus/storage/ || true"
    log "  rmdir /var/www/jenninexus/scripts/public_html 2>/dev/null || true"
    log "  rmdir /var/www/jenninexus/scripts/storage 2>/dev/null || true"
    log "After moving, re-run this helper to ensure permissions are corrected."
fi

# If a deploy accidentally put the site under scripts/public_html or scripts/storage,
# attempt to move the files into place automatically (idempotent). Respect DRY_RUN.
if [ -d scripts/public_html ]; then
    # If public_html is effectively empty or scripts/public_html is populated, move it
    if [ ! -d public_html ] || [ -z "$(ls -A public_html 2>/dev/null || true)" ]; then
        log "⚠️  Auto-fixing nested scripts/public_html → public_html"
        run "mkdir -p public_html || true"
        run "mv -v scripts/public_html/* public_html/ || true"
        run "rmdir scripts/public_html 2>/dev/null || true"
    else
        log "Note: public_html already contains files; not moving scripts/public_html to avoid overwriting."
    fi
fi
if [ -d scripts/storage ]; then
    if [ ! -d storage ] || [ -z "$(ls -A storage 2>/dev/null || true)" ]; then
        log "⚠️  Auto-fixing nested scripts/storage → storage"
        run "mkdir -p storage || true"
        run "mv -v scripts/storage/* storage/ || true"
        run "rmdir scripts/storage 2>/dev/null || true"
    else
        log "Note: storage already contains files; not moving scripts/storage to avoid overwriting."
    fi
fi


# Optional: ensure deploy user's SSH dir is secure if present
if [ -d /home/deploy/.ssh ]; then
    log "🔐 Securing /home/deploy/.ssh permissions"
    run "chown -R deploy:deploy /home/deploy/.ssh || true"
    run "chmod 700 /home/deploy/.ssh || true"
    if [ -f /home/deploy/.ssh/authorized_keys ]; then
        run "chmod 600 /home/deploy/.ssh/authorized_keys || true"
    fi
fi

# 🔐 CRITICAL: Verify /root/.ssh is still protected after deployment
# This runs at the END to ensure immutable flag wasn't accidentally removed
if [ -f /root/.ssh/authorized_keys ]; then
    log "🛡️  Verifying /root/.ssh/authorized_keys protection"
    
    # Verify immutable flag
    IMMUTABLE_STATUS=$(lsattr /root/.ssh/authorized_keys 2>/dev/null | grep -o '^....i' || echo "missing")
    if [[ "$IMMUTABLE_STATUS" == *"i"* ]]; then
        log "✅ SSH key immutable flag verified (still protected)"
    else
        log "⚠️  WARNING: SSH key immutable flag MISSING! Re-applying protection..."
        run "chattr +i /root/.ssh/authorized_keys || true"
        log "✅ SSH key immutable flag restored"
    fi
    
    # Verify key content hasn't changed
    EXPECTED_KEY="ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIClseVXGI3eIDvUUjMo5cTNjUIGSEQFN2WpGczxGtDiO jennidrop projects"
    if grep -qxF "$EXPECTED_KEY" /root/.ssh/authorized_keys; then
        log "✅ Correct SSH key verified in /root/.ssh/authorized_keys"
    else
        log "❌ CRITICAL: SSH key content has changed or is missing!"
        log "Expected key: $EXPECTED_KEY"
        log "Current content:"
        cat /root/.ssh/authorized_keys | tee -a "$LOGFILE"
        log "⚠️  Auto-restore cron will fix this on next run (daily at 6:25 AM)"
        log "Or manually restore: See /root/ssh-keys-permanent-backup/authorized_keys.permanent"
    fi
    
    # Verify permissions
    PERMS=$(stat -c '%a' /root/.ssh/authorized_keys 2>/dev/null || echo "???")
    OWNER=$(stat -c '%U' /root/.ssh/authorized_keys 2>/dev/null || echo "???")
    if [[ "$PERMS" == "600" ]] && [[ "$OWNER" == "root" ]]; then
        log "✅ SSH key permissions correct (600, owned by root)"
    else
        log "⚠️  SSH key permissions incorrect: $PERMS, owner: $OWNER"
        log "Fixing permissions..."
        run "chmod 600 /root/.ssh/authorized_keys || true"
        run "chown root:root /root/.ssh/authorized_keys || true"
        run "chattr +i /root/.ssh/authorized_keys || true"
    fi
    
    run "ls -la /root/.ssh/ || true"
else
    log "❌ CRITICAL: /root/.ssh/authorized_keys does NOT exist!"
    log "This deployment helper does not manage root SSH keys."
    log "Auto-restore cron will recreate it on next run (daily at 6:25 AM)"
    log "Or manually restore: cp /root/ssh-keys-permanent-backup/authorized_keys.permanent /root/.ssh/authorized_keys"
    log "If locked out, use DigitalOcean console to restore access."
fi

log "✅ Jenninexus permissions and symlinks fixed successfully"
log "=== JenniNexus permissions helper finished ==="

exit 0
