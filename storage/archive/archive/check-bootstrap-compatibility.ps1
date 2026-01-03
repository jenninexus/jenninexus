<#
.SYNOPSIS
    Bootstrap 5.3.3 → 5.3.8 Compatibility Checker for JenniNexus

.DESCRIPTION
    Scans your project for potential compatibility issues when upgrading
    from Bootstrap 5.3.3 to Bootstrap 5.3.8.

.NOTES
    Author: JenniNexus Development Team
    Date: October 14, 2025
    Version: 1.0
#>

param(
    [switch]$Detailed,
    [switch]$FixIssues
)

# Configuration
$projectRoot = Split-Path -Parent $PSScriptRoot
$scssPath = Join-Path $projectRoot "src\assets\scss"
$phpPath = Join-Path $projectRoot "deploy"
$publicPath = Join-Path $projectRoot "public_html"

# Results storage
$issues = @()
$warnings = @()
$infos = @()

function Write-Header {
    param([string]$Text)
    Write-Host "`n╔══════════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
    Write-Host "║ $($Text.PadRight(64)) ║" -ForegroundColor Cyan
    Write-Host "╚══════════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
}

function Write-Section {
    param([string]$Text)
    Write-Host "`n▶ $Text" -ForegroundColor Yellow
    Write-Host ("─" * 70) -ForegroundColor DarkGray
}

function Test-BootstrapVersionReferences {
    Write-Section "Checking Bootstrap Version References"
    
    $files = Get-ChildItem -Path $projectRoot -Recurse -Include *.html,*.php,*.scss,*.js,*.md -ErrorAction SilentlyContinue
    
    foreach ($file in $files) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'bootstrap@5\.3\.3') {
            $issues += [PSCustomObject]@{
                Type = "Version Reference"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "References Bootstrap 5.3.3"
                Fix = "Update to bootstrap@5.3.8"
                Severity = "Medium"
            }
        }
        
        if ($content -match 'bootstrap/5\.3\.3') {
            $issues += [PSCustomObject]@{
                Type = "CDN Reference"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "CDN link uses version 5.3.3"
                Fix = "Update CDN to 5.3.8"
                Severity = "Medium"
            }
        }
    }
    
    if ($issues.Count -eq 0) {
        Write-Host "✓ No version references found" -ForegroundColor Green
    } else {
        Write-Host "⚠ Found $($issues.Count) version references" -ForegroundColor Yellow
    }
}

function Test-FloatingLabels {
    Write-Section "Checking Floating Label Usage"
    
    $htmlFiles = Get-ChildItem -Path $projectRoot -Recurse -Include *.html,*.php -ErrorAction SilentlyContinue
    
    foreach ($file in $htmlFiles) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'form-floating') {
            $infos += [PSCustomObject]@{
                Type = "Floating Labels"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Uses floating labels (improved in 5.3.8)"
                Fix = "Test disabled state styling"
                Severity = "Info"
            }
        }
    }
    
    Write-Host "ℹ Found $($infos.Count) files using floating labels" -ForegroundColor Cyan
}

function Test-CardGroups {
    Write-Section "Checking Card Group Usage"
    
    $files = Get-ChildItem -Path $projectRoot -Recurse -Include *.html,*.php,*.scss -ErrorAction SilentlyContinue
    
    foreach ($file in $files) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'card-group') {
            $warnings += [PSCustomObject]@{
                Type = "Card Groups"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Uses .card-group (border-radius fix in 5.3.8)"
                Fix = "Test border-radius rendering"
                Severity = "Low"
            }
        }
    }
    
    if ($warnings.Count -eq 0) {
        Write-Host "✓ No card groups found" -ForegroundColor Green
    } else {
        Write-Host "⚠ Found $($warnings.Count) card group references" -ForegroundColor Yellow
    }
}

function Test-VisuallyHidden {
    Write-Section "Checking .visually-hidden Usage"
    
    $files = Get-ChildItem -Path $projectRoot -Recurse -Include *.html,*.php,*.scss -ErrorAction SilentlyContinue
    
    foreach ($file in $files) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'visually-hidden') {
            $infos += [PSCustomObject]@{
                Type = "Accessibility"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Uses .visually-hidden (improved in 5.3.8)"
                Fix = "Test with nested focusable elements"
                Severity = "Info"
            }
        }
    }
    
    Write-Host "ℹ Found $($infos.Count) visually-hidden references" -ForegroundColor Cyan
}

function Test-Dropdowns {
    Write-Section "Checking Dropdown Usage"
    
    $files = Get-ChildItem -Path $projectRoot -Recurse -Include *.html,*.php,*.js -ErrorAction SilentlyContinue
    
    foreach ($file in $files) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'dropdown') {
            $infos += [PSCustomObject]@{
                Type = "Dropdowns"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Uses dropdowns (focus behavior changed in 5.3.8)"
                Fix = "Test dropdown focus behavior"
                Severity = "Info"
            }
        }
    }
    
    Write-Host "ℹ Found $($infos.Count) dropdown references" -ForegroundColor Cyan
}

function Test-ColorContrast {
    Write-Section "Checking SCSS Color Contrast Usage"
    
    $scssFiles = Get-ChildItem -Path $scssPath -Recurse -Include *.scss -ErrorAction SilentlyContinue
    
    foreach ($file in $scssFiles) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'color-contrast\(') {
            $infos += [PSCustomObject]@{
                Type = "Color Contrast"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Uses color-contrast() (WCAG 2.1 improved in 5.3.8)"
                Fix = "Automatic improvement - no action needed"
                Severity = "Info"
            }
        }
    }
    
    Write-Host "ℹ Found $($infos.Count) color-contrast() references" -ForegroundColor Cyan
}

function Test-Spinners {
    Write-Section "Checking Spinner Usage"
    
    $files = Get-ChildItem -Path $projectRoot -Recurse -Include *.html,*.php -ErrorAction SilentlyContinue
    
    foreach ($file in $files) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match 'spinner-') {
            $infos += [PSCustomObject]@{
                Type = "Spinners"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Uses spinners (flex distortion fix in 5.3.8)"
                Fix = "Test in flex containers"
                Severity = "Info"
            }
        }
    }
    
    Write-Host "ℹ Found $($infos.Count) spinner references" -ForegroundColor Cyan
}

function Test-CustomBootstrapImports {
    Write-Section "Checking Bootstrap SCSS Imports"
    
    $scssFiles = Get-ChildItem -Path $scssPath -Recurse -Include *.scss -ErrorAction SilentlyContinue
    
    $hasBootstrapImport = $false
    foreach ($file in $scssFiles) {
        $content = Get-Content $file.FullName -Raw -ErrorAction SilentlyContinue
        
        if ($content -match '@import.*bootstrap|@use.*bootstrap') {
            $hasBootstrapImport = $true
            $warnings += [PSCustomObject]@{
                Type = "SCSS Import"
                File = $file.FullName.Replace($projectRoot, "")
                Issue = "Imports Bootstrap SCSS directly"
                Fix = "Update Bootstrap source path if using local files"
                Severity = "Medium"
            }
        }
    }
    
    if (-not $hasBootstrapImport) {
        Write-Host "✓ No direct Bootstrap SCSS imports found (using CDN or compiled CSS)" -ForegroundColor Green
        Write-Host "  → Upgrade is simpler - just update CDN links" -ForegroundColor Gray
    }
}

function Show-Summary {
    Write-Header "COMPATIBILITY CHECK SUMMARY"
    
    $total = $issues.Count + $warnings.Count + $infos.Count
    
    Write-Host "`nTotal Items Found: $total" -ForegroundColor White
    Write-Host "  🔴 Issues:   $($issues.Count)" -ForegroundColor Red
    Write-Host "  🟡 Warnings: $($warnings.Count)" -ForegroundColor Yellow
    Write-Host "  🔵 Info:     $($infos.Count)" -ForegroundColor Cyan
    
    if ($issues.Count -gt 0) {
        Write-Host "`n╔════════════════════════════════════════════════════════════════════════╗" -ForegroundColor Red
        Write-Host "║ 🔴 ISSUES REQUIRING ACTION" -PadRight(73) "║" -ForegroundColor Red
        Write-Host "╚════════════════════════════════════════════════════════════════════════╝" -ForegroundColor Red
        $issues | Format-Table -AutoSize -Wrap
    }
    
    if ($Detailed -and $warnings.Count -gt 0) {
        Write-Host "`n╔════════════════════════════════════════════════════════════════════════╗" -ForegroundColor Yellow
        Write-Host "║ 🟡 WARNINGS (Review Recommended)" -PadRight(73) "║" -ForegroundColor Yellow
        Write-Host "╚════════════════════════════════════════════════════════════════════════╝" -ForegroundColor Yellow
        $warnings | Format-Table -AutoSize -Wrap
    }
    
    if ($Detailed -and $infos.Count -gt 0) {
        Write-Host "`n╔════════════════════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
        Write-Host "║ 🔵 INFORMATIONAL (Testing Recommended)" -PadRight(73) "║" -ForegroundColor Cyan
        Write-Host "╚════════════════════════════════════════════════════════════════════════╝" -ForegroundColor Cyan
        $infos | Format-Table -AutoSize -Wrap
    }
    
    Write-Host "`n╔════════════════════════════════════════════════════════════════════════╗" -ForegroundColor Green
    Write-Host "║ 📋 RECOMMENDATIONS" -PadRight(73) "║" -ForegroundColor Green
    Write-Host "╚════════════════════════════════════════════════════════════════════════╝" -ForegroundColor Green
    
    if ($issues.Count -eq 0 -and $warnings.Count -eq 0) {
        Write-Host "✅ Your project is ready for Bootstrap 5.3.8 upgrade!" -ForegroundColor Green
        Write-Host "✅ No blocking issues found" -ForegroundColor Green
        Write-Host "✅ Recommended: Update CDN links and test thoroughly" -ForegroundColor Green
    } elseif ($issues.Count -gt 0) {
        Write-Host "⚠️  Fix the issues listed above before upgrading" -ForegroundColor Yellow
        Write-Host "⚠️  Review the migration guide: storage/docs/BOOTSTRAP-5.3.8-MIGRATION.md" -ForegroundColor Yellow
    } else {
        Write-Host "✓ No critical issues found" -ForegroundColor Green
        Write-Host "⚠️  Review warnings and test affected features" -ForegroundColor Yellow
    }
    
    Write-Host "`n📚 Next Steps:" -ForegroundColor Cyan
    Write-Host "  1. Review: storage/docs/BOOTSTRAP-5.3.8-MIGRATION.md" -ForegroundColor Gray
    Write-Host "  2. Backup: Run backup of CSS files" -ForegroundColor Gray
    Write-Host "  3. Update: Change version in CDN links or local files" -ForegroundColor Gray
    Write-Host "  4. Test: Full regression testing on dev server" -ForegroundColor Gray
    Write-Host "  5. Deploy: To staging, then production" -ForegroundColor Gray
}

function Export-Report {
    $reportPath = Join-Path $projectRoot "storage\bootstrap-compatibility-report.json"
    
    $report = @{
        Timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        Issues = $issues
        Warnings = $warnings
        Info = $infos
        Summary = @{
            TotalIssues = $issues.Count
            TotalWarnings = $warnings.Count
            TotalInfo = $infos.Count
            ReadyForUpgrade = ($issues.Count -eq 0 -and $warnings.Count -eq 0)
        }
    }
    
    $report | ConvertTo-Json -Depth 5 | Out-File $reportPath -Encoding UTF8
    
    Write-Host "`n📄 Report saved to: storage\bootstrap-compatibility-report.json" -ForegroundColor Cyan
}

# Main Execution
Write-Header "Bootstrap 5.3.3 → 5.3.8 Compatibility Checker"
Write-Host "Project: JenniNexus Creator Platform" -ForegroundColor Gray
Write-Host "Scan Time: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')" -ForegroundColor Gray

# Run all checks
Test-BootstrapVersionReferences
Test-CustomBootstrapImports
Test-FloatingLabels
Test-CardGroups
Test-VisuallyHidden
Test-Dropdowns
Test-ColorContrast
Test-Spinners

# Show results
Show-Summary
Export-Report

Write-Host "`n✨ Scan complete!" -ForegroundColor Green
