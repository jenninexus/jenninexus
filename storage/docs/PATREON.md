# Patreon Integration & Dependencies — FILE AUDIT ✅

**Last Updated:** October 30, 2025  
**Audit Status:** ✅ COMPLETE — All files documented, duplicates identified

---

## 📁 PATREON FILE INVENTORY (Audit Results)

### ✅ No Duplicates Found (Except Intentional Redirect Proxy)

**OAuth Flow (Public-Facing):**
- ✅ `public_html/patreon-auth-start.php` (1,258 bytes) — **CANONICAL** OAuth initiation
- ✅ `public_html/patreon-callback.php` — OAuth callback handler  
- ✅ `public_html/patreon.php` — Main Patreon page with VIP content
- 🔀 `public_html/resources/patreon-auth-start.php` (528 bytes) — **REDIRECT PROXY** to canonical (302 redirect for backward compatibility)

**Verdict:** The `resources/patreon-auth-start.php` file is NOT a duplicate—it's an intentional redirect proxy for legacy URLs. Keep it.

---

# Patreon Integration & Tier Import



This document explains all Patreon-related files, dependencies, runtime storage, and deployment requirements for the JenniNexus Patreon integration.This document explains how the site interacts with Patreon, where secrets live, and how to fetch/sync campaign tiers used in the UI.



## Files and DependenciesFiles and endpoints

- `public_html/resources/api/get-patreon-tiers.php` — proxy endpoint that fetches campaign tiers using the creator access token and returns a normalized `tiers` array. Caches to `storage/patreon/tiers_cache.json`.

### Core Patreon Files (Required for Deploy)- `public_html/resources/api/get-patreon-posts.php` — endpoint to fetch recent posts (used on `patreon.php`).

- `public_html/resources/api/check-patreon-membership.php` — checks current session/server-side auth status.

**OAuth Flow:**- `storage/secrets/patreon.json` — expected location for secrets when present (used by the proxy). Format:

- `public_html/patreon-auth-start.php` — Initiates OAuth flow, redirects to Patreon with CSRF state

- `public_html/patreon-callback.php` — OAuth callback, exchanges code for tokens, persists to storage```

- `public_html/patreon.php` — Main Patreon support page with VIP content and tier display{

  "PATREON_CREATOR_ACCESS_TOKEN": "<long-token>",

**API Endpoints:**  "PATREON_CAMPAIGN_ID": "<campaign-id>"

- `public_html/resources/api/get-patreon-tiers.php` — Fetches campaign tiers using creator token, caches to `storage/patreon/tiers_cache.json`}

- `public_html/resources/api/get-patreon-posts.php` — Fetches recent posts, caches to `storage/patreon/posts_cache.json````

- `public_html/resources/api/check-patreon-membership.php` — Checks current session/server-side auth status

- `public_html/resources/api/patreon-webhook.php` — Receives Patreon webhooks, stores to `storage/patreon/webhooks/`How the tier proxy behaves

- If the secrets file is missing or empty, `get-patreon-tiers.php` responds with `{ status: 'no_token', tiers: [] }`.

**Shared Core:**- If an HTTP fetch to Patreon fails, the proxy will attempt to return cached tiers from `storage/patreon/tiers_cache.json` and respond with `{ status: 'cached', tiers: [...] }`.

- `public_html/resources/includes/app_core.php` — Provides session management, AuthManager fallback, and path helpers:

  - `jn_patreon_secrets_path()` — Returns canonical `storage/secrets/patreon.json` pathQuick CLI test

  - `jn_patreon_storage_dir()` — Returns canonical `storage/patreon/` path- From the project root you can test the proxy locally (without a webserver) using PHP CLI. Example:

  - `PatreonFallbackAuthManager` — Minimal auth manager for session state management

```powershell

### Runtime Storage Structurephp "public_html/resources/api/get-patreon-tiers.php"

```

```

storage/If secrets are present the script will attempt an outbound request to `https://www.patreon.com/api/oauth2/v2/campaigns/<campaignId>/tiers` and return JSON. If secrets are missing you'll get `no_token`.

├── secrets/ (750, www-data)

│   └── patreon.json (600, owner-only) ⚠️ NEVER COMMITAdmin import / continuous sync (suggestion)

├── patreon/ (750, www-data)- If you want automated imports:

│   ├── tokens.json (600, runtime OAuth tokens, auto-created)  - Provide secrets at `storage/secrets/patreon.json` (permission 600) with the creator token + campaign id.

│   ├── user.json (600, runtime user identity, auto-created)  - Option A (safe): Create an admin-only page (protected by a secret) that triggers the proxy and writes the returned tiers into `storage/patreon/tiers_cache.json` and optionally into a site-visible YAML/JSON used by the front-end.

│   ├── posts_cache.json (644, cached posts, auto-created)  - Option B (manual): Run the CLI command above and copy the results into a repo file (e.g., `public_html/resources/playlists/patreon-tiers.json`) for deterministic builds.

│   ├── tiers_cache.json (644, cached tiers, auto-created)

│   ├── logs/ (755)Security notes

│   │   └── patreon_posts.log- Keep the creator access token secret; do not commit `storage/secrets/patreon.json` to source control.

│   └── webhooks/ (700)- The proxy sets a short fetch timeout and caches results to reduce live requests.

│       └── webhook_*.json (600, timestamped webhook payloads)

└── sessions/ (750, PHP session storage)If you'd like, I can:

```- attempt a local run of `get-patreon-tiers.php` and report the result (I will run it next), or

- implement a simple admin import UI to refresh cached tiers safely (requires a follow-up).

### Production Secrets FilePATREON Integration — JenniNexus



**Location (server-only):** `/var/www/jenninexus/storage/secrets/patreon.json`This document describes the server-only secrets, where they live, how to upload them securely, and how to test the Patreon OAuth/webhook flow.

Important: Never commit real secrets to git. Keep `storage/secrets/patreon.json` on the server only.

**Required Fields:**

```jsonHow to upload from Windows (PowerShell)

{1. Create a file locally (do not commit it). Example path:

  "PATREON_CLIENT_ID": "<oauth-client-id>",

  "PATREON_CLIENT_SECRET": "<oauth-client-secret>",  C:\Users\Owner\patreon.json

  "PATREON_REDIRECT_URI": "https://jenninexus.com/patreon-callback.php",2. Copy the file to the server (replace host/identity as needed):

  "PATREON_CREATOR_ACCESS_TOKEN": "<long-lived-creator-token>",

  "PATREON_CAMPAIGN_ID": "<numeric-campaign-id>",```powershell

  "PATREON_WEBHOOK_SECRET": "<webhook-hmac-secret>"```powershell

}scp -i C:\Users\Owner\.ssh\main_jenninexus C:\Users\Owner\patreon.json deploy@yourserver.example.com:/var/www/jenninexus/storage/tmp/patreon.json

```

3. Move to the site storage and secure it (run on server as a user with sudo):

**Development Fallback:** `public_html/resources/playlists/secrets.json` (safe dev stubs, never used in production)```bash

sudo mv /var/www/jenninexus/storage/tmp/patreon.json /var/www/jenninexus/storage/secrets/patreon.json

**Security Requirements:**sudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json

- ⚠️ Mode: `600` (owner-only read/write)sudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json

- ⚠️ Owner: `www-data:www-data`

- ⚠️ NEVER commit this file to source controlQuick test (server)

- ⚠️ NEVER include in deploy package (excluded by build scripts)# Confirm file exists and perms

sudo ls -l /var/www/jenninexus/storage/secrets/patreon.json

## OAuth Flow Sequence# Should show owner www-data:www-data and mode -rw------- (600)

# Tail the deploy log for helper runs

## 📋 Patreon Reveal List (JenniNexus.com)

The following content is confirmed to be automatically blurred for guests and revealed/unblurred for authorized patrons:

| Item | Page | Location / Container | Trigger Point |
| :--- | :--- | :--- | :--- |
| **Patreon API Posts** | `/patreon.php` | `#vipGrid` | After membership check returns `is_patron: true`. |
| **VIP YouTube Playlists** | `/patreon.php` | `#vip-playlists` | Loaded from `patreon.yaml` when authorized. |
| **CC4 Guide PDF Preview** | `/patreon.php` | `#cc4Preview` (iframe) | `revealVIP()` removes inline blur filters. |
| **CC4 Guide PDF Download** | `/patreon.php` | `#cc4PdfLink` (a) | `revealVIP()` removes inline blur filters. |
| **VIP Downloads Section** | `/patreon.php` | `#vipDownloads` | Set to `display: block` upon authorization. |

## 🛠️ Implementation (Classes & Logic)

To gate content for patrons across the site, we use a combination of CSS classes and server-side membership checks:

1.  **Classes:**
    -   `.vip-blur`: The default state for gated content. Applies a `backdrop-filter: blur(8px)` to obscure content while maintaining layout.
    -   `.vip-revealed`: Applied via JavaScript after authorization. Removes the blur and enables interaction.
    -   `.vip-guest-view`: Used on containers to provide context/messages to non-patrons while showing blurred previews.

2.  **Reveal Logic:**
    The `revealVIP()` function in `patreon.php` (and the `check-patreon-membership.php` API) is the primary driver. It removes the blur classes and updates the UI (e.g., hiding login prompts) once a valid session or token is detected.

## Client-Side Gating (Blur/Reveal)

VIP playlists are managed in `public_html/resources/playlists/patreon.yaml`. They are rendered on the Patreon page using `youtube-grid.js` and are only visible/unblurred for authenticated patrons.

### 1. User Initiates Connectionsudo tail -n 200 /var/log/jenninexus-deploy.log

- User clicks "Connect (Sign in)" button on `patreon.php`

- Button redirects to `/patreon-auth-start.php`How to test OAuth flow (local/dev)

1. Ensure `PATREON_CLIENT_ID`, `PATREON_CLIENT_SECRET` and `PATREON_REDIRECT_URI` are set in the server file as above.

### 2. OAuth Start (`patreon-auth-start.php`)2. Visit https://jenninexus.com/patreon and click Connect (this will redirect to Patreon).

- Reads secrets from `storage/secrets/patreon.json` via `jn_patreon_secrets_path()`3. After consenting, Patreon will redirect back to the callback URL; the callback will exchange the code and write `storage/patreon/tokens.json`.

- Generates random CSRF state token (32 bytes, hex-encoded)4. Confirm tokens:

- Stores state in `$_SESSION['patreon_oauth_state']`

- Builds Patreon OAuth URL with scopes: `identity`, `campaigns.members`, `campaigns.posts````bash

- Redirects browser to Patreon authorization pagesudo cat /var/www/jenninexus/storage/patreon/tokens.json

sudo ls -l /var/www/jenninexus/storage/patreon

### 3. User Authorizes on PatreonQuick test (server)

- Patreon displays consent screen

- User approves access# Tail the deploy log for helper runs

- Patreon redirects back to `PATREON_REDIRECT_URI`sudo tail -n 200 /var/log/jenninexus-deploy.log



### 4. OAuth Callback (`patreon-callback.php`)How to test OAuth flow (local/dev)

- Validates CSRF state matches session value1. Ensure `PATREON_CLIENT_ID`, `PATREON_CLIENT_SECRET` and `PATREON_REDIRECT_URI` are set in the server file as above.

- Exchanges OAuth code for access/refresh tokens via Patreon API2. Visit https://jenninexus.com/patreon and click Connect (this will redirect to Patreon).

- Stores tokens to `storage/patreon/tokens.json` (600 perms)3. After consenting, Patreon will redirect back to the callback URL; the callback will exchange the code and write `storage/patreon/tokens.json`.

- Fetches user identity + memberships via Patreon API4. Confirm tokens:

- Stores user data to `storage/patreon/user.json` (600 perms)

- Sets session via `AuthManager->setPatreonSession()````bash

- Redirects back to `/patreon`sudo cat /var/www/jenninexus/storage/patreon/tokens.json

sudo ls -l /var/www/jenninexus/storage/patreon

### 5. Authenticated Experience (`patreon.php`)If tokens are not present after a successful OAuth redirect check the webserver and PHP logs for errors. The callback returns 400 when called with no `code` param — that is expected when curl-ing it directly.

- Client-side JS calls `/resources/api/check-patreon-membership.php`

- If authenticated: Reveals VIP content, fetches posts/tiersWebhook testing and notes

- If patron detected: Shows "Active Patron" badge-------------------------

- If not authenticated: Shows blurred previews, "Connect" CTA

1) Webhook URL vs repo path

## API Endpoint Behaviors

  The webhook URL you register in the Patreon dashboard must point to the actual webhook receiver on your site. The repository contains `public_html/resources/api/patreon-webhook.php` (recommended endpoint):

### `get-patreon-tiers.php` (Tier Fetching)

    https://jenninexus.com/resources/api/patreon-webhook.php

**Normal Operation:**

- Reads creator token from `storage/secrets/patreon.json`  Your screenshot shows `https://jenninexus.com/pages/patreon/webhook.php`. If you prefer that path you must ensure the webhook receiver with signature verification exists at that path (or create a redirect from that path to the repo script). The webhook script in the repo expects the secret in `storage/secrets/patreon.json` under `PATREON_WEBHOOK_SECRET`.

- Fetches tiers via Patreon API v2: `/campaigns/{campaignId}/tiers`

- Normalizes response to simple array: `{ id, title, amount_cents, description, published, patron_count }`2) Test webhook locally (signed test)

- Caches to `storage/patreon/tiers_cache.json` (TTL: 30 minutes)

- Returns: `{ status: 'ok', tiers: [...] }`  Use this snippet on a machine that can reach your public site (or on the server itself):



**Fallback Behavior:**```bash

- If secrets missing: `{ status: 'no_token', tiers: [] }`SECRET=$(jq -r .PATREON_WEBHOOK_SECRET /var/www/jenninexus/storage/secrets/patreon.json)

- If API fetch fails: Returns cached tiers from `storage/patreon/tiers_cache.json`PAYLOAD='{"test":"patreon-webhook","time":'"$(date +%s)"'}'

- Response: `{ status: 'cached', tiers: [...] }` or `{ status: 'error', tiers: [] }`SIG=$(printf '%s' "$PAYLOAD" | openssl dgst -sha256 -hmac "$SECRET" -binary | xxd -p -c 256)

curl -v -H "Content-Type: application/json" -H "X-Patreon-Signature: $SIG" -d "$PAYLOAD" https://jenninexus.com/resources/api/patreon-webhook.php

### `get-patreon-posts.php` (Posts Fetching)```



**Normal Operation:**  Expected: a 200 response with JSON `{"status":"ok","stored":"webhook_...json"}` and a file written under `/var/www/jenninexus/storage/patreon/webhooks/`.

- Reads creator token from `storage/secrets/patreon.json`

- Fetches recent posts via Patreon API v2: `/campaigns/{campaignId}/posts` (limit 6, sorted by published_at)3) Resume Patreon webhook

- Caches to `storage/patreon/posts_cache.json` (TTL: 10 minutes)

- Returns: `{ status: 'ok', posts: [...] }`  After the signed test succeeds, go to the Patreon dashboard and click "Resume" for the webhook. Patreon will attempt to replay queued events.



**Fallback Behavior:**4) Troubleshooting webhooks

- If secrets missing: `{ status: 'no_token', posts: [] }`

- If API fetch fails: Returns cached posts from `storage/patreon/posts_cache.json`  - If Patreon paused your webhook (the screenshot shows this), it is because the endpoint returned errors or timed out. Fix signature verification and connectivity, then resume.

- Response: `{ status: 'cached', posts: [...] }` or `{ status: 'error', posts: [] }`  - Inspect the webhook files to confirm delivery:



### `check-patreon-membership.php` (Auth Check)```bash

ls -la /var/www/jenninexus/storage/patreon/webhooks | tail -n 50

**Check Priority (cascading):**sudo -u www-data jq . /var/www/jenninexus/storage/patreon/webhooks/webhook_*.json | less

1. **storage/patreon/user.json** (disk-based, persists across sessions)```

   - If `included` field present with memberships → `is_patron: true`

2. **storage/patreon/tokens.json** (tokens present = authenticated)Campaign ID verification (important)

   - If access_token exists → `authenticated: true`----------------------------------

3. **PHP Session** (`$_SESSION['patreon_user']`, fallback)

   - If session set → returns session statusYour development backups sometimes set `PATREON_CAMPAIGN_ID` incorrectly (for example equal to the OAuth client id). Use the creator access token to fetch the correct campaign id:

4. **No auth found** → `{ authenticated: false, is_patron: false }`

```bash

**Response Format:**TOKEN="<PA T R E O N_CREATOR_ACCESS_TOKEN>"  # replace with real token or use the one in storage/secrets/patreon.json

```json# Fetch the creator's campaigns and extract the numeric campaign id with jq

{curl -sS -H "Authorization: Bearer $TOKEN" "https://www.patreon.com/api/oauth2/v2/campaigns" | jq '.data[] | {id: .id, title: .attributes.title}'

  "authenticated": true,

  "is_patron": true,# Or to extract just the first campaign id (if you have one campaign):

  "user": {curl -sS -H "Authorization: Bearer $TOKEN" "https://www.patreon.com/api/oauth2/v2/campaigns" | jq -r '.data[0].id'

    "id": "123456",```

    "full_name": "John Doe",

    "image_url": "https://...",The response will include the campaign `id` value (numeric string, e.g. "117499") which you should put into `PATREON_CAMPAIGN_ID`. If you need help extracting the id from the returned JSON, paste the output here and I will point to the field.

    "thumb_url": "https://..."

  }Security and deployment policy recap

}----------------------------------

```- Keep production secrets in `/var/www/jenninexus/storage/secrets/patreon.json` and lock them down with `chown www-data:www-data` and `chmod 600`.

- Use `storage/tmp` as an upload staging area (no use of root `/tmp` required).

### `patreon-webhook.php` (Webhook Receiver)- Do not include production secrets in the deploy package — the deploy scripts explicitly remove `storage/secrets/patreon.json` unless `-IncludeSecrets` is provided.



**Verification:**If you'd like I can add a short `resources/api/debug-patreon-status.php` endpoint (IP-restricted) so you can quickly check `user.json` and `tokens.json` contents during setup. Tell me if you'd like that and I'll create it as a temporary helper.

- Validates HMAC-SHA256 signature using `PATREON_WEBHOOK_SECRET`PATREON Integration — JenniNexus

- Reads signature from `X-Patreon-Signature` header

- Compares computed HMAC to provided signature (constant-time comparison)

C:\Users\Owner\Projects\www\jenninexus\storage\patreon

**Storage:**C:\Users\Owner\Projects\www\jenninexus\storage\patreon\tokens.json

- Stores webhook payloads to `storage/patreon/webhooks/webhook_{timestamp}.json` (600 perms)C:\Users\Owner\Projects\www\jenninexus\storage\patreon\user.json

- Returns: `{ status: 'ok', stored: 'webhook_1234567890.json' }`C:\Users\Owner\Projects\www\jenninexus\storage\secrets

C:\Users\Owner\Projects\www\jenninexus\storage\secrets\patreon.json

**Error Responses:**C:\Users\Owner\Projects\www\jenninexus\storage\secrets\patreon.json.example

- Missing signature: `{ status: 'error', message: 'Missing signature' }`C:\Users\Owner\Projects\www\jenninexus\storage\secrets\secrets.json

- Invalid signature: `{ status: 'error', message: 'Invalid signature' }`C:\Users\Owner\Projects\www\jenninexus\DEPLOYMENT-MANIFEST.md

C:\Users\Owner\Projects\www\jenninexus\storage\docs\PATREON.md

## Deployment Package ExclusionsC:\Users\Owner\Projects\www\jenninexus\public_html\resources\api

C:\Users\Owner\Projects\www\jenninexus\public_html\resources\api\check-patreon-membership.php

**❌ EXCLUDED from deploy package (by design):**C:\Users\Owner\Projects\www\jenninexus\public_html\resources\api\get-patreon-posts.php

- `storage/` directory (entire directory excluded by build scripts)C:\Users\Owner\Projects\www\jenninexus\public_html\resources\api\get-youtube.php

- `storage/secrets/patreon.json` (never shipped, must be created on server)C:\Users\Owner\Projects\www\jenninexus\public_html\resources\api\patreon-webhook.php

- `storage/patreon/tokens.json` (runtime-only, auto-created by OAuth callback)C:\Users\Owner\Projects\www\jenninexus\public_html\patreon.php

- `storage/patreon/user.json` (runtime-only, auto-created by OAuth callback)

- `storage/patreon/posts_cache.json` (runtime cache, auto-created)

- `storage/patreon/tiers_cache.json` (runtime cache, auto-created)

This document describes the server-only secrets, where they live, how to upload them securely, and how to test the Patreon OAuth/webhook flow.

**✅ INCLUDED in deploy package:**

- All PHP files (patreon-auth-start.php, patreon-callback.php, patreon.php)Important: Never commit real secrets to git. Keep `storage/secrets/patreon.json` on the server only.

- All API endpoints (resources/api/*.php)

- app_core.php (shared helper with path resolution)Repository backups update: offline repo backups of patreon secrets were moved to `storage/secrets/backups/` and sensitive values redacted. Do NOT copy backups to the server directly; create `/var/www/jenninexus/storage/secrets/patreon.json` on the server and populate it securely.

- Client-side JavaScript (if any)

- Public assets (CSS, images)Required server-only file (location)



**⚠️ SERVER MUST HAVE (created manually):**  /var/www/jenninexus/storage/secrets/patreon.json

- `storage/secrets/patreon.json` (600 perms, www-data:www-data)

- `storage/patreon/` directory (750 perms, www-data:www-data)Contents (example)

- `storage/patreon/logs/` directory (755 perms)

- `storage/patreon/webhooks/` directory (700 perms)```

- `storage/sessions/` directory (750 perms, auto-created by app_core.php){

  "PATREON_CLIENT_ID": "xxxx",

## Post-Deployment Checklist  "PATREON_CLIENT_SECRET": "yyyy",

  "PATREON_REDIRECT_URI": "https://jenninexus.com/patreon-callback.php",

### 1. Create Secrets File  "PATREON_WEBHOOK_SECRET": "a_long_random_string_used_for_webhook_verification"

}

**From Windows (PowerShell):**```

```powershell

# Create local file (do NOT commit)How to upload from Windows (PowerShell)

# C:\Users\Owner\patreon.json

1. Create a file locally (do not commit it). Example path:

# Upload to server via SCP

scp -i C:\Users\Owner\.ssh\main_jenninexus C:\Users\Owner\patreon.json deploy@64.23.141.41:/var/www/jenninexus/storage/tmp/patreon.json   C:\Users\Owner\patreon.json

```

2. Copy the file to the server (replace host/identity as needed):

**On Server (SSH):**

```bash```powershell

# Move to secrets directory# Using an SSH alias defined in C:\Users\Owner\.ssh\config

sudo mv /var/www/jenninexus/storage/tmp/patreon.json /var/www/jenninexus/storage/secrets/patreon.jsonscp -i C:\Users\Owner\.ssh\main_jenninexus C:\Users\Owner\patreon.json deploy@yourserver.example.com:/tmp/patreon.json

```

# Set permissions

sudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json3. Move to the site storage and secure it (run on server as a user with sudo):

sudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json

```bash

# Verifysudo mv /tmp/patreon.json /var/www/jenninexus/storage/secrets/patreon.json

sudo ls -la /var/www/jenninexus/storage/secrets/patreon.jsonsudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json

# Should show: -rw------- 1 www-data www-data ... patreon.jsonsudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json

``````



### 2. Create Runtime DirectoriesQuick test (server)



```bash# Confirm file exists and perms

# Create storage directoriessudo ls -l /var/www/jenninexus/storage/secrets/patreon.json

sudo mkdir -p /var/www/jenninexus/storage/patreon/{logs,webhooks}# Should show owner www-data:www-data and mode -rw------- (600)

sudo mkdir -p /var/www/jenninexus/storage/sessions

# Tail the deploy log for helper runs

# Set ownership and permissionssudo tail -n 200 /var/log/jenninexus-deploy.log

sudo chown -R www-data:www-data /var/www/jenninexus/storage

sudo chmod 750 /var/www/jenninexus/storage/patreonHow to test OAuth flow (local/dev)

sudo chmod 755 /var/www/jenninexus/storage/patreon/logs

sudo chmod 700 /var/www/jenninexus/storage/patreon/webhooks1. Ensure `PATREON_CLIENT_ID`, `PATREON_CLIENT_SECRET` and `PATREON_REDIRECT_URI` are set in the server file as above.

sudo chmod 750 /var/www/jenninexus/storage/sessions2. Visit https://jenninexus.com/patreon and click Connect (this will redirect to Patreon).

```3. After consenting, Patreon will redirect back to the callback URL; the callback will exchange the code and write `storage/patreon/tokens.json`.

4. Confirm tokens:

### 3. Run Permissions Helper

```bash

```bashsudo cat /var/www/jenninexus/storage/patreon/tokens.json

# Run the automatic permission fixersudo ls -l /var/www/jenninexus/storage/patreon

sudo /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.shPATREON Integration — JenniNexus



# Verify output in deploy logOverview

sudo tail -n 200 /var/log/jenninexus-deploy.log--------

```This document explains all Patreon-related files in the repository, where they belong on the server, and what permissions are required. There are two zones:



### 4. Test OAuth Flow- Development/local (under the repository `storage/` folder). These files are convenient for local testing but should not be used in production as-is.

- Production/server (under `/var/www/jenninexus/storage/`). Secrets used by the live site must live on the server only and be locked down to `www-data: www-data` with mode `600`.

**From Browser:**

1. Visit https://jenninexus.com/patreonFiles and purpose

2. Click "Connect (Sign in)" button-----------------

3. Verify redirect to Patreon works (no "invalid redirect_uri" error)

4. Authorize on Patreon1) `storage/patreon/`

5. Verify redirect back to `/patreon` works  - Purpose: runtime storage for OAuth tokens and user information that the site writes at runtime.

6. Check that VIP content is revealed (no blur overlay)  - Typical files:

    - `storage/patreon/tokens.json` — OAuth access/refresh tokens written by the OAuth callback. Mode: `600`, owner `www-data:www-data` on server.

**Verify Tokens Created:**    - `storage/patreon/user.json` — Patreon user identity & membership info returned by Patreon API. Mode: `600`, owner `www-data:www-data` on server.

```bash  - Location on server: `/var/www/jenninexus/storage/patreon/`

# Check tokens file exists

sudo ls -la /var/www/jenninexus/storage/patreon/tokens.json2) `storage/patreon/secrets.json` (development-local)

# Should show: -rw------- 1 www-data www-data ... tokens.json  - Purpose: a developer-local copy of Patreon client credentials (extracted from your `storage/secrets/secrets.json` for convenience).

  - This file is present in the repo for local testing only (I created one at `storage/patreon/secrets.json` using your existing values). Do NOT copy this file to production.

# Check user file exists  - If you prefer to keep a single source, you can remove it and rely on `storage/secrets/patreon.json` on the server.

sudo ls -la /var/www/jenninexus/storage/patreon/user.json

# Should show: -rw------- 1 www-data www-data ... user.json3) `storage/secrets/patreon.json` (production — server-only)

  - Purpose: production Patreon credentials (client id, client secret, redirect URI, webhook secret) used by server-side endpoints.

# Inspect token contents (debug only)  - Required in production. This file must NOT be committed to git.

sudo cat /var/www/jenninexus/storage/patreon/tokens.json | jq .  - Location on server: `/var/www/jenninexus/storage/secrets/patreon.json`

sudo cat /var/www/jenninexus/storage/patreon/user.json | jq .  - Permissions: `sudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json` and `sudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json`.

```

4) `storage/secrets/secrets.json`

### 5. Test API Endpoints  - Purpose: repository-held development backup file (already in repo). It currently contains Patreon fields in your workspace — treat this as dev-only.

  - Recommendation: remove production secrets from this file or rotate them if they were ever published. Prefer `storage/secrets/patreon.json` on server for production.

**Test Tiers Endpoint:**

```bash5) `storage/secrets/patreon.json.example`

# Should return: {"status":"ok","tiers":[...]} or {"status":"no_token","tiers":[]}  - Purpose: example/template file (safe to keep in repo). Copy and fill with real credentials on your workstation and upload to the server (do not commit filled file).

curl -s https://jenninexus.com/resources/api/get-patreon-tiers.php | jq .

```6) `public_html/resources/api/check-patreon-membership.php`

  - Purpose: lightweight endpoint the client can call to check if the current visitor/session is a patron. It checks `storage/patreon/user.json` and `storage/patreon/tokens.json` first, then falls back to an AuthManager if present.

**Test Posts Endpoint:**  - Location on server: `/var/www/jenninexus/public_html/resources/api/check-patreon-membership.php`

```bash  - Permissions: PHP files under `public_html` should be `644` and owned by `www-data:www-data`.

# Should return: {"status":"ok","posts":[...]} or {"status":"no_token","posts":[]}

curl -s https://jenninexus.com/resources/api/get-patreon-posts.php | jq .7) `public_html/resources/api/get-patreon-posts.php`

```  - Purpose: development stub/proxy for fetching Patreon posts. In production this should call Patreon API using a creator access token from `storage/secrets/patreon.json`.

  - Location: `/var/www/jenninexus/public_html/resources/api/get-patreon-posts.php`

**Test Membership Check:**  - Permissions: `644`, `www-data:www-data`.

```bash

# Should return: {"authenticated":false,...} or {"authenticated":true,...}8) `public_html/resources/api/patreon-webhook.php`

curl -s https://jenninexus.com/resources/api/check-patreon-membership.php | jq .  - Purpose: webhook receiver that verifies HMAC signature using `PATREON_WEBHOOK_SECRET` from `storage/secrets/patreon.json` and writes payloads to `storage/patreon/webhooks/`.

```  - Location: `/var/www/jenninexus/public_html/resources/api/patreon-webhook.php`

  - Permissions: `644`, `www-data:www-data` for the PHP file; webhook files should be written to `storage/patreon/webhooks/` (dir perms `750`, files `600`).

### 6. Test Webhook (Optional)

9) `public_html/patreon.php`

**Register Webhook in Patreon Dashboard:**  - Purpose: public-facing Patreon landing page that provides the client UI and a "Connect" button that starts OAuth (redirects to `patreon-auth-start.php` / `/patreon-auth-start.php`).

1. Go to https://www.patreon.com/portal/registration/register-clients  - Location: `/var/www/jenninexus/public_html/patreon.php` on server.

2. Edit your OAuth client  - Permissions: `644`, `www-data:www-data`.

3. Add webhook URL: `https://jenninexus.com/resources/api/patreon-webhook.php`

4. Copy `PATREON_WEBHOOK_SECRET` from secrets file into Patreon settingsWhere each file belongs on the server (summary)

----------------------------------------------

**Test Webhook Signature:**

```bashServer production layout (important files only):

# Generate signed test payload

SECRET=$(sudo cat /var/www/jenninexus/storage/secrets/patreon.json | jq -r .PATREON_WEBHOOK_SECRET) - `/var/www/jenninexus/public_html/` — website root (PHP pages and `resources/api/*`)

PAYLOAD='{"test":"patreon-webhook","time":'"$(date +%s)"'}' - `/var/www/jenninexus/storage/patreon/` — runtime tokens and user data (files mode `600`, owner `www-data`)

SIG=$(printf '%s' "$PAYLOAD" | openssl dgst -sha256 -hmac "$SECRET" -binary | xxd -p -c 256) - `/var/www/jenninexus/storage/secrets/patreon.json` — server-only Patreon credentials (mode `600`, owner `www-data`)



# Send test webhookPermissions checklist (recommended)

curl -v -H "Content-Type: application/json" \---------------------------------

     -H "X-Patreon-Signature: $SIG" \

     -d "$PAYLOAD" \ - Directories: `755` (owner `www-data`), except runtime secrets/webhook dirs below.

     https://jenninexus.com/resources/api/patreon-webhook.php - Files: `644` for static PHP/JS/CSS files.

 - Runtime dirs: `storage/` and children should be `775` and owned by `www-data:www-data` so the app can write where needed.

# Verify webhook file created - Secrets: `storage/secrets/*` and `/var/www/jenninexus/storage/patreon/*.json` — `600` and owned by `www-data:www-data`.

sudo ls -la /var/www/jenninexus/storage/patreon/webhooks/ | tail -n 10 - Webhook dir: `storage/patreon/webhooks/` — `750` and files `600`.

```

How I extracted the values (what I did)

## Troubleshooting-------------------------------------



### "Patreon OAuth not configured" Error- I created a `storage/patreon/secrets.json` in the repo (development copy) using the Patreon values that were present in `storage/secrets/secrets.json` so you have a convenient local copy for testing. This file should not be used in production.

- Production should use `/var/www/jenninexus/storage/secrets/patreon.json` (server-only) — copy the values from your local copy into that file on the server and then delete or rotate values in any repo-backed files.

**Symptoms:**

- Page shows error message about missing configurationQuick upload & secure steps (copy/paste)

- OAuth flow doesn't start---------------------------------------



**Solution:**From Windows PowerShell (example):

1. Verify secrets file exists: `sudo ls -la /var/www/jenninexus/storage/secrets/patreon.json````powershell

2. Check file permissions are 600: `sudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json`scp -i C:\Users\Owner\.ssh\main_jenninexus C:\path\to\patreon.json deploy@yourserver.example.com:/tmp/patreon.json

3. Verify owner is www-data: `sudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json````

4. Validate JSON format: `sudo cat /var/www/jenninexus/storage/secrets/patreon.json | jq .`

On the server (run as sudo):

### "Invalid redirect_uri" Error from Patreon```bash

sudo mv /tmp/patreon.json /var/www/jenninexus/storage/secrets/patreon.json

**Symptoms:**sudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json

- Patreon shows error: "Redirect URI https://jenninexus.com/patreon-callback.php is not supported by client"sudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json

sudo /bin/bash /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh --logfile /var/log/jenninexus-deploy.log

**Solution:**```

1. Go to https://www.patreon.com/portal/registration/register-clients

2. Edit your OAuth clientVerify:

3. Add exact redirect URI: `https://jenninexus.com/patreon-callback.php` (include https, exact domain)```bash

4. Save changessudo ls -l /var/www/jenninexus/storage/secrets/patreon.json

5. Verify `PATREON_REDIRECT_URI` in secrets file matches exactly: `sudo cat /var/www/jenninexus/storage/secrets/patreon.json | jq -r .PATREON_REDIRECT_URI`sudo ls -l /var/www/jenninexus/storage/patreon

sudo tail -n 200 /var/log/jenninexus-deploy.log

### "Invalid OAuth state" Error```



**Symptoms:**Testing the flow

- Callback shows error about invalid CSRF state----------------

- User redirected back but not authenticated

1. Visit https://jenninexus.com/patreon and click "Connect". That will redirect to Patreon.

**Solution:**2. After consent, Patreon redirects back to the callback; the callback exchanges the code and writes `storage/patreon/tokens.json`.

1. Check session storage is writable: `sudo ls -la /var/www/jenninexus/storage/sessions`3. Confirm tokens exist and have `600` perms.

2. Verify PHP session.save_path is configured correctly

3. Clear browser cookies and try OAuth flow againIf anything goes wrong, paste the last ~200 lines of `/var/log/jenninexus-deploy.log` and I will help you interpret the helper output.

4. Check PHP-FPM logs for session errors: `sudo tail -n 100 /var/log/php8.3-fpm.log`

Posts proxy & cache (VIP previews)

### "Token exchange failed" Error----------------------------------



**Symptoms:**The site fetches recent Patreon posts via `public_html/resources/api/get-patreon-posts.php` and caches the normalized result to `storage/patreon/posts_cache.json`.

- OAuth callback fails to exchange code for tokens

- Error logged in server logsTo test the posts proxy (debug mode) from the server or any machine:



**Solution:**```bash

1. Verify `PATREON_CLIENT_ID` is correct: `sudo cat /var/www/jenninexus/storage/secrets/patreon.json | jq -r .PATREON_CLIENT_ID`curl -sS "https://jenninexus.com/resources/api/get-patreon-posts.php?debug=1" | jq .

2. Verify `PATREON_CLIENT_SECRET` is correct (never log this value)```

3. Check server can reach Patreon API: `curl -v https://www.patreon.com/api/oauth2/token`

4. Review PHP error logs: `sudo tail -n 100 /var/www/jenninexus/storage/logs/error.log`Behavior notes:

- `status: ok` — fresh data returned from Patreon and cached.

### "Failed to fetch tiers/posts" Error- `status: cached` — the remote call failed or returned invalid JSON and the endpoint served a cached copy from `storage/patreon/posts_cache.json`.

- `status: no_token` — missing creator token or campaign id in `storage/secrets/patreon.json`.

**Symptoms:**

- API endpoints return `{"status":"no_token","tiers":[]}` or `{"status":"error",...}`If you see `status: no_token` ensure your server-only secrets include `PATREON_CREATOR_ACCESS_TOKEN` and `PATREON_CAMPAIGN_ID` (numeric campaign id).

- VIP content doesn't load on patreon.php



**Solution:**Notes and recommendations

1. Verify `PATREON_CREATOR_ACCESS_TOKEN` exists in secrets file-------------------------

2. Check token is valid (not expired): Use Patreon API explorer or curl to test

3. Verify `PATREON_CAMPAIGN_ID` is correct numeric campaign ID (not client ID)- Consolidation policy (what I changed):

4. Check network connectivity: `curl -v https://www.patreon.com/api/oauth2/v2/campaigns`  - Production credentials MUST live only at `/var/www/jenninexus/storage/secrets/patreon.json` (server-only). This file must be `600` and owned by `www-data:www-data`.

5. Review cache files: `sudo cat /var/www/jenninexus/storage/patreon/tiers_cache.json | jq .`  - I removed sensitive Patreon values from repo-backed files and replaced them with empty placeholders so there are no accidental production secrets in the repo. Specifically:

    - `storage/secrets/secrets.json` — cleared Patreon fields (left as dev backup without secrets)

### Webhook Not Receiving Events    - `storage/patreon/secrets.json` — replaced with a dev-only placeholder (empty client id/secret) and a header telling you not to copy to production

    - `storage/secrets/patreon.json` (repo copy) is intentionally empty; production copy must be created on the server only

**Symptoms:**

- Patreon dashboard shows webhook paused or failed- Why: this reduces accidental leaks and centralizes production-only data in the live server location.

- No webhook files in `storage/patreon/webhooks/`

- If you accidentally published production credentials previously, rotate the `PATREON_CLIENT_SECRET` (create a new secret in Patreon and update the server-side file).

**Solution:**

1. Verify `PATREON_WEBHOOK_SECRET` is set in secrets file- If you want local convenience, keep `storage/patreon/secrets.json` with empty values and manually copy values into `/var/www/jenninexus/storage/secrets/patreon.json` on the server when you're ready to go live.

2. Check webhook URL in Patreon matches: `https://jenninexus.com/resources/api/patreon-webhook.php`

3. Test webhook signature validation (see Test Webhook section above)Contact

4. Check webhook directory permissions: `sudo ls -la /var/www/jenninexus/storage/patreon/webhooks/`-------

5. Review Nginx access logs: `sudo tail -n 100 /var/log/nginx/access.log | grep patreon-webhook`

6. Resume webhook in Patreon dashboard after fixing issuesTell me whether you want me to:



## Campaign ID Verification- leave the `storage/patreon/secrets.json` development copy in the repo (currently created), or

- remove it and rely strictly on `storage/secrets/patreon.json` on the server (more secure).

**Problem:** Development backups sometimes set `PATREON_CAMPAIGN_ID` incorrectly (e.g., equal to OAuth client ID instead of numeric campaign ID).

When you're ready I'll run the build script locally and walk you through uploading the server-only file and running the helper so we can confirm everything on the server.

**Solution - Fetch Correct Campaign ID:**

Redirect URI mismatch — common error & fix

```bash----------------------------------------

# Get creator token from secrets

TOKEN=$(sudo cat /var/www/jenninexus/storage/secrets/patreon.json | jq -r .PATREON_CREATOR_ACCESS_TOKEN)Problem you saw

---------------

# Fetch campaigns and extract ID + title

curl -sS -H "Authorization: Bearer $TOKEN" \When clicking "Connect" you saw an error from Patreon similar to:

     "https://www.patreon.com/api/oauth2/v2/campaigns" | jq '.data[] | {id: .id, title: .attributes.title}'

{ "error": "invalid_request", "error_description": "Redirect URI https://jenninexus.com/patreon-callback.php is not supported by client.", "state": "..." }

# Or just get first campaign ID (if you have one campaign)

curl -sS -H "Authorization: Bearer $TOKEN" \Why this happens

     "https://www.patreon.com/api/oauth2/v2/campaigns" | jq -r '.data[0].id'-----------------

```

Patreon only allows redirect URIs that have been explicitly registered for your OAuth client in the Patreon developer settings. If the redirect URI sent in the OAuth request (the `redirect_uri` value in `patreon-auth-start.php`) doesn't exactly match one of the allowed URIs in your Patreon app settings, Patreon will reject the request with the error above.

**Expected Response:**

```jsonChecklist to fix

{----------------

  "id": "117499",

  "title": "Your Campaign Name"1. Confirm the redirect URI your app is sending:

}  - The code path in `public_html/patreon-auth-start.php` builds the authorize URL using `PATREON_REDIRECT_URI` from the server secrets file. Ensure your `storage/secrets/patreon.json` on the server contains:

```

```json

**Update Secrets:**{

- Copy the numeric `id` value (e.g., "117499")  "PATREON_CLIENT_ID": "your_client_id",

- Update `PATREON_CAMPAIGN_ID` in `storage/secrets/patreon.json`  "PATREON_CLIENT_SECRET": "your_client_secret",

- **DO NOT use client ID or any other ID** - must be the campaign ID from this API call  "PATREON_REDIRECT_URI": "https://jenninexus.com/patreon-callback.php",

  "PATREON_WEBHOOK_SECRET": "..."

## Local Development Testing}

```

### Quick CLI Test (Without Webserver)

2. Verify Patreon developer app settings:

**Test Tiers Endpoint:**  - Log into https://www.patreon.com/ and open your creator account's developer settings (Creator Dashboard → Settings → API or the developer area where OAuth clients are listed).

```powershell  - Edit the OAuth client and make sure `https://jenninexus.com/patreon-callback.php` is present in the list of allowed redirect URIs (exact string match, including https and trailing slash rules).

# From project root

php public_html/resources/api/get-patreon-tiers.php3. Consistency rules:

```  - Use https exactly (Patreon requires exact match with scheme).

  - Do NOT include URL fragments or query parameters in the registered redirect (register the base callback URL; query params are usually rejected unless present in the original registration).

**Expected Responses:**  - If you register `https://jenninexus.com/patreon-callback.php` but your app sends `https://www.jenninexus.com/patreon-callback.php`, Patreon will reject it — register the exact host variant you use.

- If secrets present: Attempts outbound request to Patreon API, returns JSON

- If secrets missing: `{"status":"no_token","tiers":[]}`4. After updating the Patreon app, re-run the flow:

  - Clear any session state on the browser (optional). Click Connect on `https://jenninexus.com/patreon` and complete the OAuth consent.

### Development Secrets (Local Testing Only)

5. If you still get an error:

**Location:** `public_html/resources/playlists/secrets.json` (fallback for local dev)  - Dump the actual authorization URL being sent by the browser (open developer tools → Network and follow the 302 to Patreon). Verify the `redirect_uri` param equals the registered URI.

  - If your `patreon-auth-start.php` uses a fallback secrets file (e.g., `resources/playlists/secrets.json`) in dev, ensure it isn't overriding `PATREON_REDIRECT_URI` with a different value.

**Usage:**

- Used ONLY when `storage/secrets/patreon.json` doesn't existQuick verification commands (server)

- Safe for local testing with stub values----------------------------------

- NEVER used in production (app_core.php prioritizes `storage/secrets/` path)

```bash

## Security Notessudo cat /var/www/jenninexus/storage/secrets/patreon.json

sudo ls -l /var/www/jenninexus/storage/secrets/patreon.json

### Critical Security Requirementssudo cat /var/www/jenninexus/public_html/patreon-auth-start.php

```

- ⚠️ **NEVER commit** `storage/secrets/patreon.json` to source control

- ⚠️ **NEVER include** secrets in deploy package (excluded by build scripts)Dependencies & required files

- ⚠️ **Runtime tokens** (`tokens.json`, `user.json`) are **600 permissions** (owner-only)-----------------------------

- ⚠️ **Webhook secret** validates incoming webhook signatures (prevents unauthorized injection)

- ✅ **CSRF state tokens** prevent OAuth hijacking (random 32-byte hex, stored in session)Minimum runtime & PHP extensions

- ✅ **Short fetch timeouts** (5s connect, 10s total) prevent long-running requests - PHP 8.1+ recommended (site runs on PHP-FPM 8.3 in our deployments).

- ✅ **Caching** reduces live API requests and improves performance - Required PHP extensions: curl, json, mbstring, openssl, session (built-in), and fileinfo (optional).

- ✅ **Constant-time comparison** for HMAC signature validation (prevents timing attacks) - CLI tools used by deploy/helper: bash, rsync (optional), chown, chmod, mkdir, mv.



### If Secrets Are CompromisedKey application files (canonical locations)

 - /var/www/jenninexus/public_html/patreon.php — public landing page & Connect button.

**Immediate Actions:** - /var/www/jenninexus/public_html/patreon-auth-start.php — canonical OAuth start redirect (keeps CSRF state in PHP session).

1. **Rotate OAuth credentials:** - /var/www/jenninexus/public_html/patreon-callback.php — OAuth callback that exchanges code for tokens and persists them to storage/patreon/tokens.json.

   - Go to https://www.patreon.com/portal/registration/register-clients - /var/www/jenninexus/public_html/resources/api/check-patreon-membership.php — membership-check endpoint used by client JS.

   - Regenerate `PATREON_CLIENT_SECRET` - /var/www/jenninexus/public_html/resources/api/get-patreon-posts.php — optional posts proxy/stub.

   - Update server secrets file - /var/www/jenninexus/public_html/resources/api/patreon-webhook.php — webhook receiver (verifies HMAC using PATREON_WEBHOOK_SECRET).

   - Delete `storage/patreon/tokens.json` (forces users to re-authorize) - /var/www/jenninexus/storage/secrets/patreon.json — server-only secrets (PATREON_CLIENT_ID, PATREON_CLIENT_SECRET, PATREON_REDIRECT_URI, PATREON_WEBHOOK_SECRET).

 - /var/www/jenninexus/storage/patreon/ — runtime storage for tokens and user JSON written by the callback.

2. **Rotate creator access token:**

   - Generate new creator access token in Patreon settingsPermissions & ownership rules

   - Update `PATREON_CREATOR_ACCESS_TOKEN` in secrets file - All PHP app files: owner `www-data:www-data`, mode `644`.

   - Clear tiers/posts caches - Secrets file: owner `www-data:www-data`, mode `600` (very important).

 - Runtime storage dir `/var/www/jenninexus/storage/patreon` and children: owner `www-data:www-data`, dirs `750`, files `600` so PHP can write tokens but other users cannot read.

3. **Rotate webhook secret:**

   - Generate new random secret (32+ bytes, hex-encoded)Which auth-start file to use / consolidation

   - Update `PATREON_WEBHOOK_SECRET` in secrets file - Keep the canonical `public_html/patreon-auth-start.php` as the authoritative OAuth starter.

   - Update webhook secret in Patreon dashboard - The legacy `public_html/resources/patreon-auth-start.php` was a compatibility redirect. It has been archived to `public_html/resources/archived/patreon-auth-start.php` to avoid accidental double-redirects and to reduce confusion. External links to the legacy path should be updated to the canonical `/patreon-auth-start.php` where possible.



4. **Review logs:**Notes about webhooks

   - Check Nginx access logs for suspicious requests - If you register webhooks in the Patreon dashboard, set the webhook URI to the public `/resources/api/patreon-webhook.php` endpoint and enter `PATREON_WEBHOOK_SECRET` into the Patreon webhook settings so you can verify HMAC signatures.

   - Review webhook payloads for unexpected events

   - Monitor error logs for failed auth attemptsTroubleshooting checklist

 - If you get a Patreon 400 about redirect URI, confirm the string printed by the PHP debug one-liner matches exactly the registered redirect URI in the Patreon client settings (scheme, host, path, trailing slash).

--- - Ensure session storage is working in PHP (session.save_path writable by www-data) so CSRF state is preserved between the start and callback.

 - Check `/var/log/nginx/error.log` and FPM logs for callback or token exchange errors.

**PATREON Integration Documentation — JenniNexus**  

Last Updated: 2025-01-29

If you'd like, I can also add a short debug mode to `patreon-auth-start.php` that logs or prints the exact authorize URL (only enabled via a query param or local dev flag), which makes it trivial to confirm what's being sent to Patreon without changing production behavior.
