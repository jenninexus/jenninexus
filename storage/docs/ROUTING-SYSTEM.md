# JenniNexus Routing System Documentation

**Version:** 1.0  
**Date:** November 4, 2025  
**Status:** 🟢 Production Ready

---

## Overview

JenniNexus uses a dual routing system:
- **Development:** `router.php` (PHP built-in server)
- **Production:** Nginx configuration (jenninexus.conf)

Both systems handle clean URLs for `/game/*` and `/blog/*` subdirectories without duplication.

---

## Router.php (Development)

**Purpose:** Handle routing for `php -S localhost:8002 router.php`

### Key Features

✅ **Clean URL Support:**
- `/game/martiangames` → `/game/martiangames.php`
- `/blog/voice-acting` → `/blog/voice-acting.php`
- `/gamedev` → `/gamedev.php`

✅ **Extensionless URLs:**
```php
// All work:
/game/catgame
/game/catgame.php
/game/catgame/
```

✅ **Whoops Integration (Debug Mode):**
```bash
# Enable debug mode:
ROUTER_DEBUG=1 php -S localhost:8002 router.php

# Or via URL:
http://localhost:8002/invalid-page?debug=1
```

**Debug Features:**
- Pretty error pages with Bootstrap 5.3.8
- Request details (URI, method, headers)
- Available routes list
- File existence checks
- Whoops stack traces for PHP errors

### Route Handling Logic

```php
// 1. Static files (CSS, JS, images) - served directly
if (is_file(__DIR__ . $uri)) return false;

// 2. Root → index.php
if ($uri === '/') require 'index.php';

// 3. Top-level pages (gamedev, gaming, diy, music, etc.)
// Matches: /gamedev, /gamedev/, /gamedev.php
foreach ($topLevelPages as $route => $file) { ... }

// 4. Game pages with regex
// Matches: /game/catgame, /game/catgame/, /game/catgame.php
if (preg_match('#^/game/([^/]+?)(?:\.php)?/?$#', $uri, $matches)) { ... }

// 5. Blog posts with regex
// Matches: /blog/slug, /blog/slug/, /blog/slug.php
if (preg_match('#^/blog/([^/]+?)(?:\.php)?/?$#', $uri, $matches)) { ... }

// 6. Top-level game slugs (without /game/ prefix)
// Matches: /catgame → /game/catgame.php
if (preg_match('#^/([a-z0-9\-]+)(?:\.php)?/?$#i, $uri, $m)) { ... }

// 7. 404 with debug info (if debug mode enabled)
```

---

## Nginx Configuration (Production)

**Purpose:** Production routing at 64.23.141.41 (jenninexus.com)

### Key Features

✅ **Clean URL Support via try_files:**
```nginx
location / {
    # Try exact file, directory, then PHP variant
    try_files $uri $uri/ $uri.php?$args;
}
```

✅ **PHP-FPM Processing:**
```nginx
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
}
```

✅ **Asset Caching (1 Year):**
```nginx
location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|pdf|yaml|json)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

✅ **Security Headers:**
- HSTS (Strict-Transport-Security)
- X-Frame-Options: SAMEORIGIN
- X-XSS-Protection
- X-Content-Type-Options: nosniff

### How It Works

**Request Flow:**
1. Client requests `/game/martiangames`
2. Nginx `try_files $uri $uri/ $uri.php?$args`
3. First tries `/game/martiangames` (file) → not found
4. Then tries `/game/martiangames/` (directory) → not found
5. Finally tries `/game/martiangames.php` (PHP file) → match!
6. Nginx passes to `location ~ \.php$` block
7. PHP-FPM executes `/game/martiangames.php`

**No Duplication:** Nginx doesn't need regex patterns for `/game/*` and `/blog/*` because `try_files` automatically appends `.php` and checks file existence.

---

## Comparison: Router.php vs Nginx

| Feature | Router.php (Dev) | Nginx (Prod) |
|---------|------------------|--------------|
| **Clean URLs** | ✅ Regex patterns | ✅ try_files |
| **Extensionless** | ✅ Optional .php | ✅ Optional .php |
| **Debug Mode** | ✅ Whoops + Pretty 404 | ❌ Default error pages |
| **Performance** | 🟡 PHP overhead | ✅ Native nginx speed |
| **Asset Caching** | ❌ No caching | ✅ 1-year cache headers |
| **SSL/HTTPS** | ❌ Local dev only | ✅ Let's Encrypt |
| **Gzip** | ❌ No compression | ✅ Automatic gzip |

---

## Why No Duplication?

### Problem (Before)
Router.php had explicit regex patterns:
```php
if (preg_match('#^/game/([^/]+?)(?:\.php)?/?$#', $uri, $matches)) { ... }
if (preg_match('#^/blog/([^/]+?)(?:\.php)?/?$#', $uri, $matches)) { ... }
```

Nginx would also need similar patterns in `location` blocks, creating duplication.

### Solution (Current)
**Router.php:** Keep regex patterns for development flexibility and debug mode.

**Nginx:** Use simple `try_files` directive that automatically checks file variants:
```nginx
location / {
    try_files $uri $uri/ $uri.php?$args;
}
```

**Result:** Both systems achieve clean URLs without configuration duplication.

---

## Usage Examples

### Development Server

```bash
# Start dev server (default)
cd C:\Users\Owner\Projects\www\jenninexus\public_html
php -S localhost:8002 router.php

# Start with debug mode
ROUTER_DEBUG=1 php -S localhost:8002 router.php

# Or via PowerShell script
.\scripts\dev-server.ps1
```

**Test URLs:**
- http://localhost:8002/gamedev
- http://localhost:8002/game/martiangames
- http://localhost:8002/blog/voice-acting
- http://localhost:8002/invalid-page?debug=1 (see pretty 404)

### Production Server

```bash
# Deploy to production
.\scripts\build-and-deploy.ps1

# SSH to server
ssh root@64.23.141.41

# Check nginx config
sudo nginx -t

# Reload nginx
sudo systemctl reload nginx

# View logs
sudo tail -f /var/log/nginx/jenninexus.access.log
sudo tail -f /var/log/nginx/jenninexus.error.log
```

**Test URLs:**
- https://jenninexus.com/gamedev
- https://jenninexus.com/game/martiangames
- https://jenninexus.com/blog/voice-acting

---

## Troubleshooting

### Router.php Issues

**404 on valid page:**
```bash
# Enable debug mode to see routing details
http://localhost:8002/page-name?debug=1
```

**Whoops not loading:**
```bash
# Check vendor/autoload.php exists
ls vendor/filp/whoops/

# If missing, run composer install
composer install
```

**Static files not loading:**
```php
// router.php line 23-26
if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false; // Let PHP serve the file
}
```

### Nginx Issues

**404 on valid PHP page:**
```bash
# Check PHP-FPM is running
sudo systemctl status php8.3-fpm

# Check file permissions
ls -la /var/www/jenninexus/public_html/game/martiangames.php
# Should be www-data:www-data, mode 644
```

**Clean URLs not working:**
```bash
# Check try_files in nginx config
sudo nginx -T | grep try_files
# Should show: try_files $uri $uri/ $uri.php?$args;

# Reload nginx
sudo systemctl reload nginx
```

**SSL certificate errors:**
```bash
# Renew Let's Encrypt certificates
sudo certbot renew

# Check certificate expiry
sudo certbot certificates
```

---

## Best Practices

### Development
1. ✅ Use `dev-server.ps1` script for consistent startup
2. ✅ Enable debug mode when testing routing changes
3. ✅ Test URLs with and without .php extension
4. ✅ Test trailing slashes: `/page`, `/page/`

### Production
1. ✅ Always test nginx config before reload: `sudo nginx -t`
2. ✅ Monitor error logs after deployment
3. ✅ Use CDN URLs for Bootstrap (with SRI hashes)
4. ✅ Keep certificates up-to-date with certbot

### Code Quality
1. ✅ Document regex patterns with examples
2. ✅ Keep router.php focused on routing (no business logic)
3. ✅ Use `file_exists()` checks before `require`
4. ✅ Log 404s for debugging: `error_log("404: $uri");`

---

## Related Files

- `public_html/router.php` - Development router with Whoops
- `.config/jenninexus.conf` - Nginx production config
- `scripts/dev-server.ps1` - Development server startup script
- `scripts/build-and-deploy.ps1` - Production deployment script
- `vendor/filp/whoops/` - Whoops error handler library

---

## Version History

**v1.0** (Nov 4, 2025):
- Initial documentation
- Whoops integration added to router.php
- Debug mode with pretty 404 pages
- Nginx vs router comparison
- Removed duplication concerns

**Future Improvements:**
- [ ] Add route caching in production
- [ ] Implement route middleware system
- [ ] Add health check endpoint: `/health`
- [ ] Sitemap.xml generation from routes
