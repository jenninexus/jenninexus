# JenniNexus Quick Start Guide

## 🚀 Development

### Start Dev Server (Port 8002)
```powershell
.\scripts\dev-server.ps1
```

**OR** with build first:
```powershell
.\scripts\dev-server.ps1 -Build
```

### Access Site
- **Home**: http://localhost:8002
- **Game Dev**: http://localhost:8002/gamedev
- **DIY**: http://localhost:8002/diy
- **Music**: http://localhost:8002/music
- **Blog**: http://localhost:8002/blog

> ℹ️ PHP files are served directly. Clean URLs like `/gamedev` work via `router.php` locally and Nginx `try_files` in production.

---

## 🔨 Build Assets
```powershell
.\scripts\build.ps1
```

Handles:
- Copies `src/assets/css/**` → `public_html/resources/css/`
- Minifies CSS to `.min.css` using `clean-css-cli`
- Copies JS, YAML, images, and other assets

---

## 📦 Deploy to Production
- **IP**: 64.23.141.41
- **Web Root**: `/var/www/jenninexus/`
- **SSH Alias**: `jennidrop-root`

### Deployment Steps
1. **Build and Deploy**:
   ```powershell
   .\scripts\build-and-deploy.ps1
   ```
   Follow prompts to confirm upload.

---

## 🎯 Port Assignments
| Port | Project | Purpose |
|------|---------|---------|
| 8002 | **JenniNexus** | Isolated Platform (this project) |

---

## 📂 Project Structure
```
jenninexus/
├── public_html/           ← WEB ROOT (Deploy this)
│   ├── index.php
│   ├── gamedev.php
│   └── resources/
│       ├── css/           ← Minified CSS
│       ├── js/            ← Vanilla JS
│       ├── vendor/        ← Localized vendors (Bootstrap, etc.)
│       └── playlists/     ← YAML configs
├── src/
│   └── assets/            ← SOURCE FILES
├── scripts/               ← Automation (build, deploy, watch)
└── .config/               ← Project isolation & MCP configs
```

---

## 🔧 Isolated Architecture
This project is **self-contained**. It does NOT use:
- ❌ `shared/` framework
- ❌ `shared-deps` symlinks
- ❌ Workspace-level dependencies

All CSS, JS, and vendor files are managed locally within the project.
