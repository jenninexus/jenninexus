# Archived Scripts

Scripts that are no longer needed for regular development but kept for reference.

## 📁 Contents

### `fix-paths.ps1`
**Archived:** October 15, 2025  
**Reason:** No longer needed - we migrated from .html to .php files  
**Purpose:** Fixed resource paths in HTML files to use `resources/` directory  
**When to use again:** Only if we need to batch-update paths in future HTML files

### `check-bootstrap-compatibility.ps1`
**Archived:** October 15, 2025  
**Reason:** Migration to Bootstrap 5.3.8 is complete  
**Purpose:** Scanned project for Bootstrap 5.3.3 → 5.3.8 compatibility issues  
**When to use again:** Next major Bootstrap upgrade (e.g., 5.x → 6.x)

---

## 🔄 Restoration

If you need to use these scripts again:

```powershell
# Restore a script
Copy-Item "scripts\archive\SCRIPT_NAME.ps1" "scripts\SCRIPT_NAME.ps1"

# Or run directly from archive
.\scripts\archive\SCRIPT_NAME.ps1
```

---

## 📝 Notes

- These scripts are fully functional and tested
- Kept for historical reference and potential future use
- Do not delete unless absolutely certain they won't be needed
