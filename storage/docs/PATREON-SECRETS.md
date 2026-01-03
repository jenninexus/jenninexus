<!-- PRIVATE: production Patreon secrets backup
     This file is intentionally private and should never be committed to any public repo.
     Use this as a copy to deploy to /var/www/jenninexus/storage/secrets/patreon.json on the server.
-->

{
  "environment": "production",
  "APP_NAME": "Jenni Patreon App V2",
  "API_VERSION": "2",

  "PATREON_CLIENT_ID": "rpG5M7dfBT8HsnSkDtPhbu7Bwe7RAdpcHKX-MpiVwqg7zsS3--97aMxXTFNI1nGt",
  "PATREON_CLIENT_SECRET": "VtzCYA4NEyKLJz0XFCV8DpOQVtH9c9DAluFlHqgIT821VYgZRGUoFc4Y4QX5UOI5",

  "PATREON_CREATOR_ACCESS_TOKEN": "GQdYJqg0mgl9bBqSmwQyJFL4ovsXpT2qjp0U_QeA3kg",
  "PATREON_CREATOR_REFRESH_TOKEN": "kGILT2aWLrsNPi0Wc06MoVnH1udrHyI364j1nUyygU0",

  "PATREON_CAMPAIGN_ID": "117499",
  "PATREON_WEBHOOK_SECRET": "RYd3hakJzbCEm9LQYwaxgNgFkWWFrBezu1ZCFle38WXZg2g8Wqshlkn2YAp_n9uk",

  "PATREON_REDIRECT_URI": "https://jenninexus.com/patreon-callback.php",
  "PATREON_WEBHOOK_URL": "https://jenninexus.com/resources/api/patreon-webhook.php"
}

<!-- NOTES
 - Confirm PATREON_CAMPAIGN_ID: this value in older backups sometimes contains the client id placeholder. Use the creator access token to fetch the real campaign id:
  curl -sS -H "Authorization: Bearer <CREATOR_TOKEN>" "https://www.patreon.com/api/oauth2/v2/campaigns" | jq .
 - After uploading this file to the server, run:
     sudo chown www-data:www-data /var/www/jenninexus/storage/secrets/patreon.json
     sudo chmod 600 /var/www/jenninexus/storage/secrets/patreon.json
 - Required keys checklist for production `patreon.json`:
   - PATREON_CLIENT_ID
   - PATREON_CLIENT_SECRET
   - PATREON_REDIRECT_URI
   - PATREON_WEBHOOK_URL
   - PATREON_WEBHOOK_SECRET
   - PATREON_CREATOR_ACCESS_TOKEN
   - PATREON_CREATOR_REFRESH_TOKEN
   - PATREON_CAMPAIGN_ID (numeric id)
 - Do NOT store this file in a public repository. Rotate secrets if ever exposed.

POSTS PROXY & CACHE
--------------------
- The site uses `public_html/resources/api/get-patreon-posts.php` to fetch recent posts for the VIP area.
- On the server this script uses the creator access token from `storage/secrets/patreon.json` and writes a small cache file to:
  - `/var/www/jenninexus/storage/patreon/posts_cache.json`
- If the Patreon API is temporarily unavailable or returns invalid JSON, the endpoint will return the cached posts with `status: cached`.

Cache TTL and logs
------------------
- The posts cache has a TTL of 15 minutes. The proxy prefers fresh data but will serve the cache when Patreon is unreachable.
- Non-200 Patreon responses and brief response snippets are appended to:
  - `/var/www/jenninexus/storage/patreon/logs/patreon_posts.log`

Test the posts endpoint (debug):

  curl -sS "https://jenninexus.com/resources/api/get-patreon-posts.php?debug=1" | jq .

If you see `status: no_token` the secrets file on the server is missing required keys (creator access token or campaign id). Ensure `PATREON_CREATOR_ACCESS_TOKEN` and `PATREON_CAMPAIGN_ID` are present in `/var/www/jenninexus/storage/secrets/patreon.json`.

Tiers endpoint
--------------
We added `public_html/resources/api/get-patreon-tiers.php` which fetches campaign tiers and caches them to `storage/patreon/tiers_cache.json`. The site will attempt to render the real tiers on the `/patreon` page using this endpoint.
-->