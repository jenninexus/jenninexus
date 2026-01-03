# JenniNexus - Project Structure Guide# JenniNexus - Project Structure Guide# JenniNexus - Project Structure Guide



## 📁 Directory Organization



```## 📁 Simple Directory Organization## 📁 Directory Organization

jenninexus/

├── src/                           ← DEVELOPMENT SOURCE

│   └── assets/                    ← Edit these, not resources/

│       ├── blog posts/            ← Original markdown files- **`assets/`** = Development source files (fonts, PDFs, blog posts, SVGs)This project uses a clear separation between development assets, web root, and documentation:

│       ├── pdfs/                  ← Original PDFs

│       ├── fonts/                 ← Original fonts- **`public_html/`** = Web root - Upload this entire folder to your server  

│       ├── svgs/                  ← Original SVGs

│       ├── css/                   ← Compiled CSS- **`scripts/`** = Build and utility scripts- **`assets/`** = Development/source files (never upload to server)

│       ├── js/                    ← Additional JS libraries

│       ├── scss/                  ← SCSS source files- **`storage/docs/`** = Project documentation- **`public_html/resources/`** = Web root (upload this to server)

│       └── *.json                 ← Config files

│- **`storage/docs/`** = Documentation and project notes

├── public_html/                   ← WEB ROOT (upload to server)

│   ├── *.html                     ← 8 HTML pages at root---

│   ├── playlist-ids.json          ← Config

│   └── resources/                 ← Built from src/assets---

│       ├── js/                    ← JavaScript files

│       ├── css/                   ← Stylesheets## 🗂️ Complete Structure

│       ├── pdfs/                  ← PDFs (copied from src)

│       ├── blog posts/            ← Blog posts (copied from src)## 🗂️ Complete Structure

│       ├── fonts/                 ← Fonts (copied from src)

│       ├── svgs/                  ← SVGs (copied from src)```

│       └── scss/                  ← SCSS (copied from src)

│jenninexus/```

├── scripts/                       ← BUILD & DEPLOY SCRIPTS

│   ├── build.ps1                  ← Copies src/assets → public_html/resources│jenninexus/

│   ├── deploy.ps1                 ← Creates deploy/ folder

│   └── fix-paths.ps1              ← Path fixer (one-time use)├── assets/                    ← DEV SOURCE FILES│

│

├── storage/│   ├── blog posts/            ← Markdown blog posts├── assets/                        ← DEV ASSETS (originals, backups)

│   └── docs/                      ← DOCUMENTATION

│       ├── PROJECT-STRUCTURE.md   ← This file│   ├── pdfs/                  ← PDF files│   ├── blog posts/                ← Markdown blog posts

│       ├── DEPLOYMENT-CHECKLIST.md

│       ├── QUICKSTART.md│   ├── fonts/                 ← Font files│   ├── pdfs/                      ← PDF files (VIP, resume, etc)

│       └── SUMMARY.md

││   ├── svgs/                  ← SVG graphics│   ├── css/                       ← Uncompiled CSS

├── deploy/                        ← DEPLOY OUTPUT (created by deploy.ps1)

│   └── (copy of public_html/)│   ├── css/, js/, scss/       ← Additional assets│   ├── fonts/                     ← Font files

│

└── README.md                      ← Main project README│   └── *.json                 ← Config files│   ├── js/                        ← JavaScript (dev)

```

││   ├── scss/                      ← SCSS source files

---

├── public_html/               ← WEB ROOT (UPLOAD THIS)│   ├── svgs/                      ← SVG graphics

## 🎯 Key Principles

│   ├── *.html                 ← All pages (index, music, diy, blog, etc.)│   ├── content_tags.json          ← Tag config

### 1. Edit Source, Not Resources

- **✅ Edit:** `src/assets/` - Original files, version controlled│   ├── playlist-ids.json      ← Config│   ├── playlist-ids.json          ← YouTube playlist config

- **❌ Don't Edit:** `public_html/resources/` - Built/copied files

│   └── resources/             ← ALL ASSETS│   ├── secrets.json               ← Patreon credentials (local only)

### 2. Build Process

```powershell│       ├── js/                ← JavaScript│   ├── social-stats.json          ← Social stats (local only)

# Build: Copies src/assets → public_html/resources

cd scripts│       ├── css/               ← Stylesheets│   └── tags.json                  ← Tag data

.\build.ps1

│       ├── pdfs/              ← PDFs (copied from assets/)│

# Deploy: Copies public_html → deploy/

.\deploy.ps1│       ├── blog posts/        ← Blog posts (copied from assets/)├── public_html/

```

│       ├── fonts/             ← Fonts (copied from assets/)│   └── resources/                 ← WEB ROOT (UPLOAD THIS FOLDER)

### 3. Clean URLs

- HTML pages at `public_html/` root│       └── svgs/              ← SVGs (copied from assets/)│       ├── blog posts/            ← Blog markdown (copied from assets)

- Example: `yoursite.com/music.html` (not `/pages/music.html`)

││       ├── pdfs/                  ← PDFs (copied from assets)

### 4. Organized Assets

- All assets in `public_html/resources/`├── scripts/                   ← BUILD SCRIPTS│       ├── css/                   ← Compiled CSS

- Relative paths: `resources/js/`, `resources/css/`, etc.

│   └── build.ps1              ← Copies assets to public_html/resources│       ├── fonts/                 ← Web fonts

---

││       ├── js/                    ← JavaScript

## 🔧 Build Process

└── storage/docs/              ← DOCUMENTATION│       ├── scss/                  ← SCSS (if needed)

### Build Script (`scripts/build.ps1`)

Copies files from `src/assets/` to `public_html/resources/`:    ├── PROJECT-STRUCTURE.md   ← This file│       ├── svgs/                  ← SVG graphics



```powershell    ├── DEPLOYMENT-CHECKLIST.md│       ├── index.html             ← Main landing page

cd scripts

.\build.ps1         # Normal build    └── QUICKSTART.md│       ├── music.html             ← Music & playlists page

.\build.ps1 -Clean  # Clean build (removes old files first)

``````│       ├── diy.html               ← DIY tutorials page



**What it copies:**│       ├── blog.html              ← Blog listing page

- PDFs: `src/assets/pdfs/` → `public_html/resources/pdfs/`

- Blog posts: `src/assets/blog posts/` → `public_html/resources/blog posts/`---│       ├── links.html             ← Social links page

- Fonts: `src/assets/fonts/` → `public_html/resources/fonts/`

- SVGs: `src/assets/svgs/` → `public_html/resources/svgs/`│       ├── resume.html            ← Resume page



---## 🔧 Build Process│       ├── services.html          ← Services page



## 🚀 Deploy Process│       ├── patreon.html           ← Patreon VIP page



### Deploy Script (`scripts/deploy.ps1`)```powershell│       ├── theme-toggle.js        ← Light/dark mode toggle

Creates a clean `deploy/` folder ready for upload:

# Build project│       ├── patreon-auth-enhanced.js ← Patreon VIP authentication

```powershell

cd scriptscd scripts│       ├── music-playlists.js     ← Music playlist loader

.\deploy.ps1         # Normal deploy

.\deploy.ps1 -Clean  # Clean deploy.\build.ps1│       ├── diy-playlists.js       ← DIY playlist loader

```

│       ├── youtube-grid.js        ← Video grid display

**What it does:**

1. Copies `public_html/` → `deploy/`# Clean build│       ├── tag-system.js          ← Tag filtering system

2. Creates `.htaccess` file

3. Ready to upload to server.\build.ps1 -Clean│       ├── custom.css             ← Main custom styles



---```│       └── playlist-ids.json      ← YouTube playlist config



## 📦 Deployment│



### Step 1: Build**What it does:** Copies PDFs, blog posts, fonts, and SVGs from `assets/` to `public_html/resources/`├── storage/

```powershell

cd scripts│   └── docs/                      ← PROJECT DOCUMENTATION

.\build.ps1

```---│       ├── PROJECT-STRUCTURE.md   ← This file



### Step 2: Create Deploy Package│       ├── DEPLOYMENT-CHECKLIST.md

```powershell

.\deploy.ps1## 🚀 Deploy│       ├── QUICKSTART.md

```

│       └── SUMMARY.md

### Step 3: Test Locally

```powershell### 1. Build│

cd ../deploy

python -m http.server 8001```powershell├── build.ps1                      ← Build script (PowerShell, optional)

# Visit http://localhost:8001

```cd scripts && .\build.ps1├── nginx.conf                     ← Nginx server configuration



### Step 4: Upload to Server```├── README.md                      ← Main documentation

```powershell

# Upload deploy/* to your web server└── .gitignore                     ← Git ignore rules

scp -r deploy/* user@server:/var/www/html/

```### 2. Test```



---```powershell



## 🔗 Asset Pathscd public_html---



All HTML files use relative paths:python -m http.server 8001



```html```## 🎯 Key Concepts

<!-- CSS -->

<link href="resources/css/custom.css" rel="stylesheet">



<!-- JavaScript -->### 3. Upload### Development Assets (`assets/`)

<script src="resources/js/theme-toggle.js"></script>

<script src="resources/js/patreon-auth-enhanced.js"></script>Upload **entire `public_html/` folder** to your web server**Purpose:** Store original, unmodified files for backup and version control



<!-- PDFs -->

<a href="resources/pdfs/resume.pdf" download>

---**What goes here:**

<!-- Navigation -->

<a href="index.html">Home</a>- ✅ Markdown blog posts

<a href="music.html">Music</a>

```## 🔗 Asset Paths- ✅ Source images, SVGs



---- ✅ Original PDFs



## 📝 Maintenance WorkflowAll HTML files use **relative paths**:- ✅ SCSS/CSS source files



### Add New Blog Post- ✅ Unminified JavaScript

1. Create `.md` file in `src/assets/blog posts/`

2. Run `scripts\build.ps1````html- ✅ Tag/config JSON files

3. Update `public_html/blog.html` listing

<link href="resources/css/custom.css" rel="stylesheet">

### Update PDF

1. Replace file in `src/assets/pdfs/`<script src="resources/js/theme-toggle.js"></script>**DO NOT upload `assets/` to the server!**

2. Run `scripts\build.ps1`

3. Verify in `public_html/resources/pdfs/`<a href="resources/pdfs/resume.pdf">Resume</a>



### Add New Page```---

1. Create `.html` in `public_html/`

2. Use relative paths: `resources/js/`, `resources/css/`

3. Test locally before deploying

✅ **Portable** - Move `public_html/` anywhere, paths still work!### Web Root (`public_html/resources/`)

### Modify CSS/JS

1. Edit source files in `src/assets/css/` or `src/assets/js/`**Purpose:** Web-accessible files to upload to your server

2. Copy to `public_html/resources/` (manually or via build script)

3. Test changes---



---**What goes here:**



## 🎯 What to Upload## 📦 What to Upload- ✅ All HTML pages



### ✅ Upload to Server- ✅ JavaScript files (optimized/minified)

```

deploy/                (entire folder contents)### ✅ Upload- ✅ CSS files (compiled/minified)

OR

public_html/           (entire folder contents)- `public_html/*` (entire folder)- ✅ Images, SVGs (optimized)

├── *.html

├── playlist-ids.json- ✅ PDFs (web-ready)

└── resources/

```### ❌ Don't Upload- ✅ Configuration files (playlist-ids.json, tags.json)



### ❌ DO NOT Upload- `assets/` (source files)

```

src/                   (source files only)- `scripts/` (build scripts)**This is your WEB ROOT - upload THIS to server!**

scripts/               (build scripts only)

storage/               (documentation only)- `storage/` (documentation)

README.md              (project docs)

```---



------



## 🛠️ Quick Reference### Documentation (`storage/docs/`)



| Task | Command |**Keep it simple. Build. Test. Deploy.** 🚀**Purpose:** Project documentation, checklists, and guides

|------|---------|

| Build project | `cd scripts && .\build.ps1` |

| Create deploy package | `cd scripts && .\deploy.ps1` |**What goes here:**

| Test locally | `cd deploy && python -m http.server 8001` |- ✅ PROJECT-STRUCTURE.md (this file)

| Upload to server | `scp -r deploy/* user@server:/var/www/html/` |- ✅ DEPLOYMENT-CHECKLIST.md

- ✅ QUICKSTART.md

---- ✅ SUMMARY.md



## 📋 Directory Details---



### `src/assets/` - Development Source## 🔧 Build/Deploy Process

- **Purpose:** Original files, edit these

- **Version Control:** Yes, commit these### Manual Build (Current)

- **Upload:** No, never upload to serverFiles are organized for manual copying. No build step required unless using build.ps1.



### `public_html/` - Web Root### Using build.ps1 (Optional)

- **Purpose:** Complete website, ready to serve```powershell

- **Version Control:** Optional (can be rebuilt)# Run from project root

- **Upload:** Yes, this is what goes on server.\build.ps1

```

### `public_html/resources/` - Built Assets**What it does:**

- **Purpose:** Assets copied from `src/assets/`1. ✅ Verifies all HTML files exist

- **Edit:** No, rebuild from source instead2. ✅ Checks JavaScript and CSS files

- **Upload:** Yes, as part of `public_html/`3. ✅ Verifies required assets (PDFs, blog posts)

4. ✅ Copies assets from `assets/` to `public_html/resources/`

### `scripts/` - Automation5. ✅ Shows build summary

- **Purpose:** Build and deploy scripts

- **Version Control:** Yes---

- **Upload:** No

## 🚀 Deployment Workflow

### `storage/docs/` - Documentation

- **Purpose:** Project documentation### Step 1: Build (Optional)

- **Version Control:** Yes```powershell

- **Upload:** No# From project root

.\build.ps1

### `deploy/` - Deploy Package```

- **Purpose:** Clean copy ready for server

- **Version Control:** No (generated)### Step 2: Test Locally

- **Upload:** Yes, upload this folder's contents```powershell

# Navigate to public_html

---cd public_html



**Edit `src/assets/` → Build → Test `public_html/` → Deploy → Upload** 🚀# Start local server

python -m http.server 8001

# Visit http://localhost:8001
```

### Step 3: Upload to Server
**Upload ONLY the `public_html/resources/` directory contents:**

```powershell
# Using SCP (replace with your server details)
scp -r public_html/resources/* user@your-server:/var/www/html/

# Or using SFTP/FileZilla
# Connect to server
# Navigate to /var/www/html/
# Upload contents of public_html/resources/ folder
```

### Step 4: Configure Nginx
```bash
# SSH into server
ssh user@your-server

# Edit Nginx config
sudo nano /etc/nginx/sites-available/jenninexus

# Copy contents from nginx.conf in project root
# Test configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

---

## 📦 What to Upload

### ✅ Upload to Server
```
public_html/resources/
├── *.html                 (all HTML pages)
├── *.js                   (all JavaScript)
├── *.css                  (all CSS)
├── playlist-ids.json      (config)
└── [assets folders]       (all assets: blog posts, pdfs, fonts, etc)
```

### ❌ DO NOT Upload
```
assets/                    (dev/source files - local only)
build.ps1                  (build script - local only)
README.md                  (documentation - local only)
DEPLOYMENT-CHECKLIST.md    (checklist - local only)
PROJECT-STRUCTURE.md       (this file - local only)
.gitignore                 (Git config - local only)
storage/                   (docs - local only)
```

---

## 🔄 File Sync Rules

### When to Copy from `src/` to `public_html/`

1. **Blog Posts Changed**
   ```powershell
   Copy-Item src\assets\"blog posts"\* public_html\assets\"blog posts"\ -Force
   ```

2. **PDFs Updated**
   ```powershell
   Copy-Item src\assets\pdfs\* public_html\assets\pdfs\ -Force
   ```

3. **All Assets Changed**
   ```powershell
   Copy-Item src\assets\* public_html\assets\ -Recurse -Force
   ```

4. **Full Rebuild**
   ```powershell
   .\build.ps1
   ```

---

## 📝 Development Workflow

### Adding a New Blog Post
1. Create markdown file in `src/assets/blog posts/`
2. Copy to `public_html/assets/blog posts/`
3. Add metadata to `blog.html`
4. Create entry in `blog-post.html` (when built)
5. Test locally
6. Upload changed files to server

### Updating a PDF
1. Update file in `src/assets/pdfs/`
2. Copy to `public_html/assets/pdfs/`
3. Test locally (verify links work)
4. Upload to server

### Modifying JavaScript
1. Edit file in `public_html/` directly
2. (Optional) Keep backup in `src/js/` if needed
3. Test locally
4. Upload to server

### Updating Styles
1. Edit `public_html/custom.css`
2. Test locally
3. Upload to server

---

## 🗄️ Backup Strategy

### What to Backup
```
jenninexus-landing/
├── src/                   ← CRITICAL: Original files
├── public_html/           ← Rebuild-able from src
├── README.md              ← Documentation
├── build.ps1              ← Build automation
└── nginx.conf             ← Server config
```

### Backup Commands
```powershell
# Full project backup
Compress-Archive -Path jenninexus-landing -DestinationPath "jenninexus-backup-$(Get-Date -Format 'yyyy-MM-dd').zip"

# Source files only
Compress-Archive -Path jenninexus-landing\src -DestinationPath "jenninexus-src-backup-$(Get-Date -Format 'yyyy-MM-dd').zip"
```

---

## 🌐 Server Directory Structure

### On Your SSH Server
```
/var/www/html/                         ← Web root
├── index.html                        ← From public_html/index.html
├── music.html
├── diy.html
├── blog.html
├── links.html
├── resume.html
├── services.html
├── patreon.html
├── *.js                              ← All JavaScript files
├── *.css                             ← All CSS files
├── playlist-ids.json
└── assets/
    ├── blog posts/
    ├── pdfs/
    ├── fonts/
    └── ...
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/html;              # Points to public_html contents
    index index.html;
    
    location / {
        try_files $uri $uri/ /index.html;
    }
}
```

---

## 🔍 Quick Reference

### Common Commands

**Test locally:**
```powershell
cd public_html
python -m http.server 8001
```

**Build project:**
```powershell
.\build.ps1
```

**Upload to server:**
```powershell
scp -r public_html/* user@server:/var/www/html/
```

**Backup project:**
```powershell
Compress-Archive -Path . -DestinationPath "backup-$(Get-Date -Format 'yyyy-MM-dd').zip"
```

---

## ❓ FAQ

**Q: Why separate `src/` and `public_html/`?**
A: Keeps original files safe. `public_html/` can be rebuilt from `src/` anytime.

**Q: Can I work directly in `public_html/`?**
A: Yes! For HTML/JS/CSS edits. For assets, update in `src/` first, then copy.

**Q: What if I delete `public_html/` by accident?**
A: No problem! Run `.\build.ps1` to rebuild from `src/`.

**Q: Do I upload the whole `jenninexus-landing/` folder?**
A: NO! Only upload the **contents** of `public_html/` folder.

**Q: Where do I test changes?**
A: Always test in `public_html/` directory using local server.

---

## 🎉 Summary

- **Work in:** `public_html/` for code, `src/` for assets
- **Test in:** `public_html/` directory
- **Upload:** `public_html/` contents only
- **Backup:** Entire `jenninexus-landing/` folder
- **Build:** Run `.\build.ps1` to sync files

---

**Last Updated:** October 14, 2025  
**Project:** JenniNexus Landing Page  
**Structure Version:** 1.0.0
