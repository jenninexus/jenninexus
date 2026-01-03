# Preview script for replacing ../resources/ with /resources/ in public_html/game
# Generates deploy/notes/root-relative-preview.txt with per-file before/after snippets

$base = Join-Path (Get-Location) 'public_html\game'
$previewPath = Join-Path (Get-Location) 'deploy\notes\root-relative-preview.txt'

if (-not (Test-Path $base)) {
    Write-Error "Base path not found: $base"
    exit 1
}

$files = Get-ChildItem -Path $base -Recurse -File -Include *.php,*.html,*.htm,*.js,*.css
$summary = @()
$out = @()
$totalReplacements = 0

foreach ($f in $files) {
    $lines = Get-Content -LiteralPath $f.FullName -ErrorAction SilentlyContinue
    $changed = @()
    for ($i=0; $i -lt $lines.Count; $i++) {
        $line = $lines[$i]
        if ($line -match '\.\./resources/') {
            $newLine = $line -replace '\.\./resources/','/resources/'
            $changed += [PSCustomObject]@{
                LineNumber = $i+1
                Before = $line
                After = $newLine
            }
        }
    }
    if ($changed.Count -gt 0) {
        $totalReplacements += $changed.Count
        $out += "--- File: $($f.FullName)"
        foreach ($c in $changed) {
            $out += "@@ Line $($c.LineNumber)"
            $out += "- $($c.Before)"
            $out += "+ $($c.After)"
        }
        $out += ""
        $summary += "$($f.FullName): $($changed.Count) replacements"
    }
}

$header = @()
$header += "Root-relative replacement preview"
$header += "Scanned path: $base"
$header += "Files scanned: $($files.Count)"
$header += "Total replacements found: $totalReplacements"
$header += "Generated: $(Get-Date -Format o)"
$header += ""
$header += "Summary per-file:"
$header += $summary
$header += ""
$header += "Detailed changes follow below:"
$header += ""

$final = $header + $out

# Ensure notes dir exists
$notesDir = Split-Path $previewPath -Parent
if (-not (Test-Path $notesDir)) { New-Item -ItemType Directory -Path $notesDir -Force | Out-Null }

$final | Out-File -FilePath $previewPath -Encoding UTF8
Write-Host "Preview written to: $previewPath"
Write-Host "Files scanned: $($files.Count), total replacements: $totalReplacements"

# Also output first 200 lines to console for quick glance
Get-Content -LiteralPath $previewPath -TotalCount 200 | ForEach-Object { Write-Host $_ }

exit 0
