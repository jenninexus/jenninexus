#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Optimize tags.json - Keep only most used tags for SEO
    
.DESCRIPTION
    1. Analyzes tag usage across content_tags.json
    2. Identifies top 50 most-used tags
    3. Creates optimized tags.json with SEO-friendly tags
    4. Backs up original tags.json
    
.NOTES
    Focus on SEO value: gaming, game-dev, DIY, beauty, fashion
#>

param(
    [switch]$DryRun,
    [int]$TopTags = 50
)

$ErrorActionPreference = 'Stop'

# Paths
$rootPath = Split-Path -Parent $PSScriptRoot
$resourcesPath = Join-Path $rootPath "public_html\resources\playlists"
$tagsPath = Join-Path $resourcesPath "tags.json"
$contentTagsPath = Join-Path $resourcesPath "content_tags.json"
$backupPath = Join-Path $resourcesPath "tags.json.backup"

Write-Host "🏷️  Tag Optimizer - Keep Top $TopTags SEO Tags" -ForegroundColor Cyan
Write-Host "=" * 50

# Load files
$tags = Get-Content $tagsPath -Raw | ConvertFrom-Json
$contentTags = Get-Content $contentTagsPath -Raw | ConvertFrom-Json

Write-Host "📊 Current stats:" -ForegroundColor Yellow
Write-Host "  • Total tags defined: $($tags.Count)" -ForegroundColor Cyan
Write-Host "  • Content entries: $($contentTags.PSObject.Properties.Count)" -ForegroundColor Cyan

# Count tag usage
$tagUsage = @{}

foreach ($prop in $contentTags.PSObject.Properties) {
    $entry = $prop.Value
    $tagList = @()
    
    if ($entry -is [Array]) {
        $tagList = $entry
    } elseif ($entry.tags) {
        $tagList = $entry.tags
    }
    
    foreach ($tag in $tagList) {
        $tagStr = $tag.ToString()
        $tagUsage[$tagStr] = ($tagUsage[$tagStr] ?? 0) + 1
    }
}

# Find top used tags
$topUsedTags = $tagUsage.GetEnumerator() | 
    Sort-Object -Property Value -Descending | 
    Select-Object -First $TopTags

Write-Host "`n🔝 Top $TopTags most-used tags:" -ForegroundColor Green
foreach ($tag in $topUsedTags | Select-Object -First 10) {
    Write-Host "  • $($tag.Key): $($tag.Value) uses" -ForegroundColor Cyan
}
if ($topUsedTags.Count -gt 10) {
    Write-Host "  ... and $($topUsedTags.Count - 10) more" -ForegroundColor Gray
}

# Create optimized tag list
$optimizedTags = @()

foreach ($tagSlug in ($topUsedTags | ForEach-Object { $_.Key })) {
    # Find matching tag definition
    $tagDef = $tags | Where-Object { 
        $_.slug -eq $tagSlug -or 
        $_.name -eq $tagSlug -or
        $_.id.ToString() -eq $tagSlug
    } | Select-Object -First 1
    
    if ($tagDef) {
        $optimizedTags += $tagDef
    }
}

Write-Host "`n📦 Optimization results:" -ForegroundColor Yellow
Write-Host "  • Original tags: $($tags.Count)" -ForegroundColor Red
Write-Host "  • Optimized tags: $($optimizedTags.Count)" -ForegroundColor Green
Write-Host "  • Removed: $($tags.Count - $optimizedTags.Count)" -ForegroundColor Red

if (-not $DryRun) {
    # Backup original
    Copy-Item $tagsPath $backupPath -Force
    Write-Host "`n💾 Backed up original to tags.json.backup" -ForegroundColor Cyan
    
    # Save optimized version
    $json = $optimizedTags | ConvertTo-Json -Depth 10
    Set-Content -Path $tagsPath -Value $json -Encoding UTF8
    
    Write-Host "✅ Saved optimized tags.json" -ForegroundColor Green
    Write-Host "`n📝 To restore: Copy-Item '$backupPath' '$tagsPath' -Force" -ForegroundColor Yellow
} else {
    Write-Host "`n🔍 DRY RUN - No changes saved" -ForegroundColor Yellow
    Write-Host "   Run without -DryRun to apply changes" -ForegroundColor Gray
}

Write-Host ""
