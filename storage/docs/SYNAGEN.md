# SYNAGEN — Jenninexus Project (Synabrain Guide)

**Purpose:** Project-specific guidance for using Synabrain with the Jenninexus project. This file is intended for contributors and automated agents that operate on or with the project.

## Project overview
- **Project ID:** `jenninexus`
- **Location (local):** `C:\Users\Owner\Projects\www\jenninexus`
- **Synabrain registration:** `proj:jenninexus` (registered in local Synabrain instance)
- **Primary usage:** Code search, architecture questions, and contextual conversational assistance scoped to this project
- **Last indexed:** Check via GET /projects/jenninexus (see status below)

## 🔍 Querying project-scoped data

**API (project-scoped):** POST /projects/ask

**Example (curl):**
```bash
curl -X POST http://localhost:8765/projects/ask \
  -H "Content-Type: application/json" \
  -d '{"question":"How do I add a login page?","projects":["jenninexus"]}'
```

**UI / Natural language:** Prefix with @ mention to target the project, e.g.:
```
@jenninexus how do I add a login page?
```
The UI will route the question to the project's namespace.

## 🔁 Triggering re-indexing

### Recommended Indexing Schedule
- **Full re-index:** After major refactors, CSS reorganization, or YAML config changes
- **Incremental index:** After adding new pages, blog posts, or game detail pages
- **Frequency:** Weekly or after 50+ changed files

### When to Re-Index
✅ **YES** - Re-index after:
- Adding new CSS files or themes (gamedev-theme.css, etc.)
- Creating new YAML configurations (playlists/*.yaml)
- Adding new pages (game/*.php, blog/*.php)
- Major documentation updates (storage/docs/*.md)
- JavaScript refactoring (youtube-grid.js, tag-system.js)

❌ **NO** - Skip indexing for:
- Minor CSS tweaks (color changes, padding adjustments)
- Image updates (resources/images/)
- Build output changes (public_html/resources/*.min.css)
- Log files (storage/logs/)

### API Method
```bash
curl -X POST http://localhost:8765/projects/jenninexus/index \
  -H "Content-Type: application/json" \
  -d '{
    "max_chars": 1600,
    "overlap": 200,
    "limit_files": 0,
    "max_chunks": 0,
    "respect_gitignore": true
  }'
```

### Programmatic Method (Python)
```python
from synabrain.ui.controller import SynabrainController
c = SynabrainController(profile='foss')
c.index_project(
    'jenninexus', 
    max_chars=1600, 
    overlap=200, 
    limit_files=0, 
    max_chunks=0, 
    respect_gitignore=True
)
```

**Note:** Re-indexing scans the repository and updates the vector store. Large projects may take 5-15 minutes. Run during quiet windows or use `limit_files` for incremental updates.

## ✅ Verify indexing / status

**List all projects:** GET /projects  
**Get project details:** GET /projects/jenninexus

**Example:**
```bash
curl http://localhost:8765/projects/jenninexus
```

**Expected Response:**
```json
{
  "project_id": "jenninexus",
  "path": "C:\\Users\\Owner\\Projects\\www\\jenninexus",
  "indexed_files": 250,
  "last_indexed": "2026-01-02T15:30:00Z",
  "status": "ready"
}
```

## 🎯 Recommended Synabrain Uses for JenniNexus

### 1. **Architecture Questions**
```
@jenninexus How does the youtube-grid.js system load playlists from YAML files?
@jenninexus What's the difference between gamedev-theme.css and media.css?
@jenninexus Show me how tag-system.js filters content across pages
```

### 2. **Code Search & Examples**
```
@jenninexus Find all pages that use the glassmorphism effect
@jenninexus Show me examples of YouTube playlist cards with hover effects
@jenninexus Where is pastel-backgrounds.css included?
```

### 3. **Debugging & Troubleshooting**
```
@jenninexus Why am I seeing white backgrounds in light mode?
@jenninexus How do I add a new game detail page?
@jenninexus What CSS classes control video card aspect ratios?
```

### 4. **Feature Implementation**
```
@jenninexus How do I add a new YAML playlist section to gaming.php?
@jenninexus Show me the pattern for creating theme-aware buttons
@jenninexus How do I implement OAuth-gated content like patreon.php?
```

### 5. **Documentation Lookup**
```
@jenninexus What are the supported aspect ratios for youtube-grid.js?
@jenninexus Show me the CSS custom properties for light/dark themes
@jenninexus What's the difference between .section-pastel and .bg-theme-adaptive?
```

## 🔧 How to register or re-register (if needed)

If the project is not registered locally, you can register it via API or the UI.

API example to register:

```
POST /projects
{
  "project_id": "jenninexus",
  "name": "Jenninexus",
  "path": "C:\\Users\\Owner\\Projects\\www\\jenninexus",
  "language": "unknown",
  "project_type": "other",
  "description": "Jenninexus project",
  "tags": ["web","jenninexus"]
}
```

Or use the Gradio UI Register Project form (Synabrain UI)

## For future agents (operational guidance specific to Jenninexus)
- **Mandatory step:** Before answering project questions or making changes, read the most recent daily plan in the main Synabrain repo (`docs/chat-history/`) and any recent daily plan in this project (if present).
- Verify registration and indexing status (GET /projects/jenninexus). If not indexed, either trigger indexing or ask a human for permission to proceed.
- Use only project-scoped queries to avoid mixing results from other projects.
- When writing a new daily plan for Jenninexus, include `Previous session:` with a link to the most recent daily plan and a one-line summary.
- When making non-trivial edits to code or docs, leave a brief note in the daily plan and notify maintainers (e.g., via PR description or team chat).

## Best practices for Jenninexus
- Keep large binary directories excluded with `.gitignore` (e.g., `node_modules`, `build/`, engine caches). Use `respect_gitignore=true` when indexing.
- Use `tags` and `description` when registering projects to improve discoverability.
- For frequent changes, batch indexing or schedule a low-traffic window for full re-indexing.

## ⚠️ GitHub automation (future)
We may add a GitHub Action later to trigger indexing on `push` to `main` (call POST /projects/jenninexus/index) or to trigger partial indexing when specific paths change. For now, operations are manual — hold off on automation until we confirm indexing resource usage and workflow policy.

### Recommended Next Steps
- Add a **disabled** GitHub Action template (commented/disabled by default) that can be enabled later for incremental indexing; this provides a clear, reviewable starting point.
- Create a small script (e.g., `scripts/reindex-project.ps1`) that wraps the Synabrain API call with sensible defaults (max_chars, overlap) and can be invoked by maintainers or CI.
- Schedule a weekly incremental index (low priority window) and a full re-index after major content imports (e.g., large YAML updates or playlist imports).
- When adding automation, prefer **partial indexing** for specific paths (e.g., `src/assets/js`, `public_html/resources/playlists`) instead of full re-indexes to minimize resource usage.
- Add a short entry in the daily plan template reminding maintainers to run an index after bulk content changes (e.g., playlist updates, large doc edits).

---

## Local docs and cross-references
- Global Synabrain guidance: refer to the repository `storage/docs/JENNI.md` in the Synabrain repo for general policies and agent guidance.
- Project-specific docs: keep project-level guidance under `storage/docs/` in this project and update `SYNAGEN.md` when workflows or responsibilities change.

If you'd like, I can add a small script or a template GitHub Action (disabled by default) that can be enabled later to automate indexing; say "Prepare Action" if you'd like a draft to review.
