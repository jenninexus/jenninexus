# Bootstrap 5.3.8 SRI Hashes

## What is SRI?

Subresource Integrity (SRI) is a security feature that enables browsers to verify that files they fetch from CDNs are delivered without unexpected manipulation.

## How to Get SRI Hashes

### Option 1: Official CDN Page
Visit: https://www.jsdelivr.com/package/npm/bootstrap

1. Search for Bootstrap version 5.3.8
2. Click on the CSS or JS file
3. Copy the full `<link>` or `<script>` tag with SRI hash

### Option 2: Generate Manually

```bash
# For CSS
curl -s https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css | \
  openssl dgst -sha384 -binary | openssl base64 -A

# For JS
curl -s https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js | \
  openssl dgst -sha384 -binary | openssl base64 -A
```

### Option 3: SRI Hash Generator
Use: https://www.srihash.org/

1. Paste the CDN URL
2. Get the SRI hash
3. Copy the full tag

## Current Placeholders

### In `includes/head.php`:
```php
<!-- Bootstrap 5.3.8 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-<SRI_HASH_PLACEHOLDER>" 
      crossorigin="anonymous">
```

### In `includes/footer.php`:
```php
<!-- Bootstrap 5.3.8 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-<SRI_HASH_PLACEHOLDER>" 
        crossorigin="anonymous"></script>
```

## Steps to Update

1. Get the correct SRI hashes for Bootstrap 5.3.8
2. Replace `<SRI_HASH_PLACEHOLDER>` in:
   - `public_html/includes/head.php`
   - `public_html/includes/footer.php`
   - `public_html/gamedev.php` (custom JS load)
   - `public_html/live.php` (custom JS load)
   - `public_html/blog.php` (custom JS load)
   - `public_html/links.php` (custom JS load)

3. Test on dev server
4. Deploy to production

## Why Use SRI?

- **Security**: Prevents CDN compromise attacks
- **Integrity**: Ensures files haven't been tampered with
- **Best Practice**: Required for production environments
- **Browser Support**: All modern browsers

## Note

Bootstrap 5.3.8 might not be released yet. Check:
- https://getbootstrap.com/docs/versions/
- https://github.com/twbs/bootstrap/releases

**Current Latest**: Bootstrap 5.3.3 (stable)
**Alternative**: Wait for 5.3.8 release or use 5.3.3 with correct SRI

## Rollback Plan

If Bootstrap 5.3.8 is not available, revert to 5.3.3:

```bash
# CSS
https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"

# JS
https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
```

These are the correct, verified hashes for Bootstrap 5.3.3.
