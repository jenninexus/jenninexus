# JenniNexus Workspace Ready Checklist
**Last Updated:** 2025-10-28  
**Status:** ✅ READY FOR NEXT AGENT

---

## ✅ Configuration Complete

### 1. Workspace Settings Updated
- ✅ Terminal working directory: `C:\Users\Owner\Projects\www\jenninexus`
- ✅ Environment variables configured:
  - `MCP_PROJECT_NAME=jenninexus`
  - `MCP_PROJECT_ROOT=C:\Users\Owner\Projects\www\jenninexus`
  - `MCP_WORKSPACE=jenninexus`
  - `MCP_LOG_DIR=C:\Users\Owner\Projects\www\jenninexus\.vscode\logs`
- ✅ MCP server path: `.vscode\mcp.json` (project-specific)
- ✅ PowerShell CWD: `📡LIVE - jenninexus.com`
- ✅ Terminal integrated CWD: `C:\Users\Owner\Projects\www\jenninexus`

### 2. Task Configuration Updated
All 7 tasks now use absolute paths and explicit CWD:
- ✅ 🏗️ Build JenniNexus Assets
- ✅ 🚀 Start JenniNexus Dev Server
- ✅ � Sync Assets to Public
- ✅ 🚢 Deploy jenninexus.com to Production
- ✅ 🚀 Build & Deploy (Full Pipeline)
- ✅ 🔍 Check Bootstrap 5.3.8 Compatibility
- ✅ 🔍 Check Bootstrap Compatibility (Detailed)

### 3. Memory File Created
- ✅ `.config\memory.mdc` populated with comprehensive project context
- ✅ Includes isolation rules, project structure, tech stack, workflows
- ✅ Clear warnings about other projects to avoid
- ✅ Quick reference commands and common tasks

### 4. Directory Structure Verified
- ✅ `.vscode\logs\` directory created
- ✅ MCP config source exists: `.config\mcp_jenni.json`
- ✅ MCP server wrapper exists: `.config\mcp-server.js`
- ✅ Nginx config present: `.config\jenninexus.conf`

### 5. Node.js Version
- ✅ v22.13.1 (current and up-to-date)

---

## 🎯 What Happens When You Restart VS Code

### On Fresh Launch:
1. **Terminal opens in:** `C:\Users\Owner\Projects\www\jenninexus`
2. **Environment variables are set automatically** (terminal.integrated.env.windows)
3. **MCP autostart enabled** (will load MCP servers)
4. **All tasks run from correct directory** (explicit cwd set)

### Verify After Restart:
```powershell
# 1. Check working directory
pwd
# Expected: C:\Users\Owner\Projects\www\jenninexus

# 2. Check environment variables
$env:MCP_PROJECT_NAME
# Expected: jenninexus

$env:MCP_PROJECT_ROOT
# Expected: C:\Users\Owner\Projects\www\jenninexus

# 3. Check MCP config exists
Test-Path .vscode\mcp.json
# Expected: True (after sys-admin runs)

# 4. Check logs directory
Test-Path .vscode\logs
# Expected: True
```

---

## 🚀 Running sys-admin

### When to Run:
- First time after workspace setup
- After adding/modifying MCP config files
- If MCP servers aren't loading correctly

### How to Run:
```powershell
# From JenniNexus project root
cd C:\Users\Owner\Projects\www\shared-deps\sys-admin
.\start-sys-admin.bat

# OR run once and exit
.\start-sys-admin.bat --once
```

### What sys-admin Does:
1. Creates lock file: `.sys-admin-jenninexus.lock`
2. Reads source: `C:\Users\Owner\Projects\www\shared-deps\sys-admin\.config\` (workspace-level)
3. Reads project: `.config\mcp_jenni.json` (if exists)
4. Merges to: `.vscode\mcp.json` (project-specific)
5. Filters: Only includes `mcp_jenni.json` + `mcp-manager.mcp.json`
6. Excludes: All other project configs (martiangames, neophi, etc.)
7. Logs: Writes to `.vscode\logs\mcp.merged.json` and `merge-summary.json`

---

## 🛡️ Isolation Guarantees

### What's Protected:
- ✅ **Lock file is project-specific:** `.sys-admin-jenninexus.lock`
- ✅ **Target file is project-specific:** `.vscode\mcp.json`
- ✅ **Filter list is project-specific:** Only jenninexus MCPs
- ✅ **Environment variables scope operations:** `MCP_PROJECT_NAME=jenninexus`
- ✅ **Multiple workspaces can run simultaneously:** Each gets its own instance

### What Won't Be Touched:
- ❌ `C:\Users\Owner\Projects\www\workspaces\boobsofwar.code-workspace`
- ❌ `C:\Users\Owner\Projects\www\workspaces\mg-new.code-workspace`
- ❌ `C:\Users\Owner\Projects\www\workspaces\neophi.code-workspace`
- ❌ `C:\Users\Owner\Projects\www\workspaces\waeria.code-workspace`
- ❌ Any other project's `.vscode\mcp.json` files
- ❌ Martiangames server (different IP, different keys)

---

## 📋 Quick Start for Next Agent

### Step 1: Verify Environment
```powershell
# Confirm you're in the right place
pwd  # Should be: C:\Users\Owner\Projects\www\jenninexus

# Check env vars
$env:MCP_PROJECT_NAME  # Should be: jenninexus
```

### Step 2: Read Essential Docs
- **FIRST:** `storage\10-28.md` - Today's action plan and todos
- `.config\memory.mdc` - Comprehensive project memory
- `README.md` - Project overview and structure
- `storage\docs\` - Core documentation (ONLY update when needed)
  - `QUICKSTART.md` - Fast setup guide
  - `DEPLOYMENT-GUIDE.md` - Deployment walkthrough
  - `TAG-SYSTEM.md` - Tag filtering system
  - `PLAYLIST-MAPPING.md` - Playlist configs
  - `BOOTSTRAP-5.3.8-COMPLETE.md` - Bootstrap reference
  - `YOUTUBE.md` - YouTube API integration
  - `PATREON.md` / `PATREON-SECRETS.md` - Patreon integration
  - `LOCAL-DEV.md` - Local development

### ⚠️ Documentation Rules
- ❌ **DO NOT CREATE NEW .md SUMMARY FILES**
- ❌ **DO NOT CREATE NEW DOCUMENTATION**
- ✅ **Update `storage/10-28.md` with completed tasks**
- ✅ **Update existing docs in `storage/docs/` ONLY when information changes**

### Step 3: Start Development
```powershell
# Start dev server (port 8002)
.\scripts\dev-server.ps1

# Or use npm
npm run dev

# Access: http://localhost:8002
```

### Step 4: Build Assets (if needed)
```powershell
# Compile SCSS → CSS
.\scripts\build.ps1

# Or
npm run build
```

---

## 🎨 Common Tasks

### Development
```powershell
npm run dev       # Start dev server
npm run build     # Build assets
npm test          # Run tests
```

### Deployment
```powershell
.\scripts\build-and-deploy.ps1  # Full pipeline
.\scripts\deploy.ps1            # Deploy only
```

### Maintenance
```powershell
.\scripts\check-bootstrap-compatibility.ps1         # Quick check
.\scripts\check-bootstrap-compatibility.ps1 -Detailed  # Detailed check
```

---

## 🔧 Tech Stack Reminder

- **Framework:** Bootstrap 5.3.8
- **Backend:** PHP 8.3-FPM
- **Server:** Nginx
- **Dev Port:** 8002
- **Domain:** jenninexus.com
- **Server IP:** 64.23.141.41

---

## 📞 Production Access

### SSH
```powershell
# Via IP
ssh root@64.23.141.41

# Via alias
ssh main-jenninexus

# Key location
C:\Users\Owner\.ssh\main_jenninexus
```

### Deployment
```powershell
# Rsync deploy (automated in scripts)
rsync -avz --delete deploy/ root@64.23.141.41:/var/www/jenninexus/

# Or use the script
.\scripts\deploy.ps1
```

---

## ⚠️ Critical Reminders

### DO:
- ✅ Work in `C:\Users\Owner\Projects\www\jenninexus`
- ✅ Run commands from project root
- ✅ Use tasks defined in workspace
- ✅ Check `.config\memory.mdc` for context
- ✅ Test locally before deploying
- ✅ Use `<?= RES_ROOT ?>` for asset paths

### DON'T:
- ❌ Run commands from `C:\Users\Owner\Projects\www\workspaces`
- ❌ Edit other workspace projects
- ❌ Use Martian Games keys on JenniNexus server
- ❌ Hardcode `/resources/` paths in nested pages
- ❌ Commit `secrets.json` to git
- ❌ Mix up projects (jenninexus vs martiangames)

---

## ✅ Ready to Go!

Your JenniNexus workspace is fully configured and isolated. When you start a new chat:

1. Environment variables will be loaded automatically
2. Terminal will open in the correct directory
3. MCP will only load jenninexus configs
4. All tasks will run from the project root
5. sys-admin will only touch jenninexus files

**No cross-contamination. No confusion. Just clean, isolated development.**

---

*Last verified: 2025-10-28 by GitHub Copilot*
*Node version: v22.13.1 ✅*
*Workspace file: C:\Users\Owner\Projects\www\workspaces\jenninexus.code-workspace*
