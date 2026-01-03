# AI Agent Instructions for JenniNexus Project

## 🤖 General AI Agent Workflow

### When completing a coding task:
- Run a compile test using `.\scripts\build.ps1`
- Read the logs / use `get_errors` tool
- Verify / fix your work
- Run related unit tests, if they exist
- Write unit tests whenever a new feature is added and the complexity of the code is high
- If a `get_errors` tool is not available, refer to the logs first, and then compose an action plan to create a `get_errors` tool

### Documentation Rule:
**Do not write any documentation or any .md files unless explicitly instructed to do so**

### GitHub Actions & Deployment Rule:
**Do not create GitHub Actions workflows, push to remote repositories, or attempt deployment without explicit user permission**

---

# ⛔ ABSOLUTE PROHIBITIONS (CRITICAL)

### File Creation Restrictions
You are FORBIDDEN from creating:
- ❌ ANY new `.md` files
- ❌ `CHANGES.md`, `SUMMARY.md`, `UPDATE.md`
- ❌ `session-*.md`, `notes-*.md`, `log-*.md`
- ❌ Any documentation summaries
- ❌ Any new files in `storage/docs/`

### GitHub & CI/CD Restrictions
You are FORBIDDEN from:
- ❌ Creating GitHub Actions workflows (`.github/workflows/*.yml`)
- ❌ Pushing to remote repositories (`git push`)
- ❌ Creating CI/CD pipelines without explicit permission
- ❌ Scheduling automated tasks via GitHub Actions
- ❌ Modifying `.git/` configuration

### Why?
Creating new documentation files causes documentation sprawl, duplicate information, and confusion for future agents. GitHub Actions and CI/CD changes can trigger unintended deployments or resource usage and must be reviewed by the user first.

## ✅ REQUIRED WORKFLOW

### 1. Start Every Session
- **Read the daily action plan FIRST**: `storage/[MM-DD].md` (e.g., `storage/12-29.md`).
- If it doesn't exist, check `storage/DAILY-PLAN.md` for the latest tracking file.

### 2. As You Work
- Update the daily tracking file (`storage/[MM-DD].md`) with completed tasks.
- Mark todos as `[x]` when done.
- Add notes about decisions or changes.

### 3. Update Existing Docs (Only When Needed)
- If information changes, edit existing docs in `storage/docs/` in-place.
- Never create new files to document changes.

### 4. End of Session
- Ensure the daily tracking file reflects all completed work.
- **No summary files needed** - the daily file IS the summary.

---

# 🏗️ Architecture & Patterns

### Big Picture
- **Isolated Architecture**: Project is 100% self-contained. Do NOT use `shared-deps` or `shared/` framework.
- **Tech Stack**: PHP 8.3, Bootstrap 5.3.8 (Local), Vanilla JS (No jQuery), SCSS (Source in `src/assets/scss`).
- **Web Root**: `public_html/` is the deployment root.
- **Asset Management**: 
    - Source files are in `src/assets/`.
    - Build script (`.\scripts\build.ps1`) syncs them to `public_html/resources/`.
    - **PHP**: Use `RES_ROOT` constant for assets (e.g., `<img src="<?= RES_ROOT ?>/images/logo.png">`).
    - **JS**: Use `window.RES_ROOT` (injected via `head.php`).

### Coding Conventions
- **Bootstrap-First**: Never override Bootstrap grid (`.col-*`) or spacing (`.p-*`). Extend with custom classes instead.
- **Glassmorphism**: Use mixins from `src/assets/scss/base/_mixins.scss` (e.g., `@include glass-panel()`).
- **Single Source of Truth**: Colors defined as CSS variables in `base/colors.scss`. No hex codes in component files.
- **YouTube Playlists**: RSS-based loading via `youtube-grid.js` and YAML configs (e.g., `gamedev.yaml`). No API keys required.

---

# 🚀 Critical Workflows

### Development
- **Start Dev Server**: `.\scripts\dev-server.ps1` (Port 8002).
- **Build Assets**: `.\scripts\build.ps1` (Syncs `src/assets` -> `public_html/resources`).
- **Watch Mode**: `.\scripts\watch.ps1` (Auto-rebuild on source changes).

### Deployment
- **Full Pipeline**: `.\scripts\build-and-deploy.ps1`.
- **SSH Alias**: Always use `ssh jennidrop-root` (IP: `64.23.141.41`).
- **Exclusions**: `deploy.ps1` automatically excludes `videos/`, `pdfs/`, `archived/`, and `!bak/` directories.

---

# 🎯 Working Directory
Always work from: `C:\Users\Owner\Projects\www\jenninexus`
Never work from: `C:\Users\Owner\Projects\www\workspaces` ❌

---

**These rules are mandatory. Violating them causes significant workflow disruption.**

