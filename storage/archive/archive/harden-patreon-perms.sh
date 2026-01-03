#!/usr/bin/env bash
set -euo pipefail

# Harden runtime permissions for JenniNexus Patreon storage
# Idempotent: safe to run multiple times. Intended to be run on the server as root (or via sudo).

PATREON_DIR="/var/www/jenninexus/storage/patreon"
SECRETS_FILE="/var/www/jenninexus/storage/secrets/patreon.json"

echo "HARDEN: target dir=${PATREON_DIR} secrets=${SECRETS_FILE}"

if [ ! -d "${PATREON_DIR}" ]; then
  echo "ERROR: Patreon storage dir does not exist: ${PATREON_DIR}" >&2
  exit 2
fi

if [ "$(id -u)" -ne 0 ]; then
  echo "This script must be run as root or with sudo." >&2
  exit 1
fi

echo "Removing existing ACLs (if any) on ${PATREON_DIR}..."
setfacl -R -b "${PATREON_DIR}" || true

echo "Set conservative ownership and directory modes..."
chown -R www-data:www-data "${PATREON_DIR}"
chmod 750 "${PATREON_DIR}"

echo "Normalizing existing runtime files to 0600 and owner www-data:www-data..."
shopt -s nullglob
for f in "${PATREON_DIR}"/*.json; do
  echo " - fixing: $f"
  chown www-data:www-data "$f" || true
  chmod 600 "$f" || true
  # ensure no lingering ACLs on the file
  setfacl -b "$f" || true
done
shopt -u nullglob

echo "Lock the secrets file (if present)..."
if [ -f "${SECRETS_FILE}" ]; then
  chown www-data:www-data "${SECRETS_FILE}" || true
  chmod 600 "${SECRETS_FILE}" || true
  setfacl -b "${SECRETS_FILE}" || true
  echo " - secrets file locked"
else
  echo " - no secrets file found at ${SECRETS_FILE} (ok if you use other provisioning)"
fi

echo "Apply default ACLs so new files created by www-data inherit owner-only perms..."
# Give www-data rwX on dir and set default so files are created with owner rw and directories rwx
## Apply ACLs using the owner entry (user::) rather than adding a named user:www-data
## This prevents creating a separate named ACL which can interact with the mask and
## leave group write bits effective. New files will be created with owner-only perms.
setfacl -R -m u::rwX,g::---,o::--- "${PATREON_DIR}" || true
setfacl -R -d -m u::rwX,g::---,o::--- "${PATREON_DIR}" || true

echo
echo "Verification outputs: ls -l and getfacl for ${PATREON_DIR}"
ls -l "${PATREON_DIR}" || true
echo
getfacl "${PATREON_DIR}" || true

echo
echo "HARDEN: done. If files still show group/other access, rerun the script and paste the getfacl output for further analysis."

exit 0
