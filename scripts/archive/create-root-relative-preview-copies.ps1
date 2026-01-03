# Create preview copies with ../resources -> /resources replacements for public_html/game
$src = Join-Path (Get-Location) 'public_html\game'
$dst = Join-Path (Get-Location) 'deploy\preview\public_html\game'

if (-not (Test-Path $src)) { Write-Error "Source not found: $src"; exit 1 }

$files = Get-ChildItem -Path $src -Recurse -File -Include *.php,*.html,*.htm,*.js,*.css
$total = 0

foreach ($f in $files) {
    $rel = $f.FullName.Substring($src.Length+1).TrimStart('\')
    $outPath = Join-Path $dst $rel
    $outDir = Split-Path $outPath -Parent
    if (-not (Test-Path $outDir)) { New-Item -ItemType Directory -Path $outDir -Force | Out-Null }

    $text = Get-Content -Raw -LiteralPath $f.FullName -ErrorAction SilentlyContinue
    if ($null -eq $text) { continue }
    if ($text -match '\.\./resources/') {
        $new = $text -replace '\.\./resources/','/resources/'
        Set-Content -LiteralPath $outPath -Value $new -Encoding UTF8
        Write-Host "Wrote preview: $outPath"
        $total++
    }
}

Write-Host "Preview copies created for $total files under: $dst"
exit 0
