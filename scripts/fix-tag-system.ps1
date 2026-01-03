<#
.SYNOPSIS
Fix Tag System Issues - Remove duplicates, add blog posts, fix content_tags.json

.DESCRIPTION
Fixes multiple tag system issues:
1. Removes duplicate tag entries (DIY appears 2x, Gaming appears 2x)
2. Adds blog posts to content_tags.json with slug-based tags
3. Adds main pages (index.php, diy.php, gamedev.php, etc.) to content_tags.json
4. Ensures all tags use slugs not numeric IDs for filtering

.EXAMPLE
.\scripts\fix-tag-system.ps1 -Verbose
#>

[CmdletBinding()]
param()

$ErrorActionPreference = 'Stop'
$projectRoot = Split-Path -Parent $PSScriptRoot

# File paths
$tagsJsonPath = Join-Path $projectRoot "public_html\resources\playlists\tags.json"
$contentTagsPath = Join-Path $projectRoot "public_html\resources\playlists\content_tags.json"
$blogYamlPath = Join-Path $projectRoot "public_html\resources\playlists\blog-posts.yaml"

Write-Host "`n🔧 Tag System Fix - Starting..." -ForegroundColor Cyan

# =====================================================
# STEP 1: Remove duplicate tags from tags.json
# =====================================================
Write-Host "`n📋 Step 1: Removing duplicate tags..." -ForegroundColor Yellow

if (-not (Test-Path $tagsJsonPath)) {
    throw "tags.json not found at: $tagsJsonPath"
}

$tagsJson = Get-Content $tagsJsonPath -Raw | ConvertFrom-Json

Write-Host "   Current tags count: $($tagsJson.Count)"

# Track seen slugs to remove duplicates
$seenSlugs = @{}
$uniqueTags = @()

foreach ($tag in $tagsJson) {
    $slug = $tag.slug
    
    if ($seenSlugs.ContainsKey($slug)) {
        Write-Host "   ❌ Removing duplicate: $($tag.name) (slug: $slug, id: $($tag.id))" -ForegroundColor Red
    } else {
        $seenSlugs[$slug] = $true
        $uniqueTags += $tag
    }
}

Write-Host "   ✅ Removed $($tagsJson.Count - $uniqueTags.Count) duplicate tags"
Write-Host "   New tags count: $($uniqueTags.Count)"

# Backup and save
$backupPath = "$tagsJsonPath.backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
Copy-Item $tagsJsonPath $backupPath -Force
Write-Host "   💾 Backed up to: $(Split-Path -Leaf $backupPath)" -ForegroundColor Gray

$uniqueTags | ConvertTo-Json -Depth 10 | Set-Content $tagsJsonPath -Encoding UTF8
Write-Host "   ✅ Saved deduplicated tags.json"

# =====================================================
# STEP 2: Add blog posts to content_tags.json
# =====================================================
Write-Host "`n📝 Step 2: Adding blog posts to content_tags.json..." -ForegroundColor Yellow

if (-not (Test-Path $contentTagsPath)) {
    throw "content_tags.json not found at: $contentTagsPath"
}

$contentTags = Get-Content $contentTagsPath -Raw | ConvertFrom-Json

# Parse blog-posts.yaml
if (-not (Test-Path $blogYamlPath)) {
    Write-Warning "blog-posts.yaml not found, skipping blog posts"
} else {
    $yamlContent = Get-Content $blogYamlPath -Raw
    
    # Simple YAML parser for blog posts
    $blogPosts = @()
    $currentPost = $null
    
    foreach ($line in $yamlContent -split "`n") {
        $line = $line.Trim()
        
        if ($line -match '^-\s+slug:\s*(.+)$') {
            if ($currentPost) { $blogPosts += $currentPost }
            $currentPost = @{
                slug = $matches[1].Trim()
                tags = @()
            }
        }
        elseif ($currentPost -and $line -match '^title:\s*["''](.+)["'']$') {
            $currentPost.title = $matches[1]
        }
        elseif ($currentPost -and $line -match '^title:\s*(.+)$') {
            $currentPost.title = $matches[1].Trim()
        }
        elseif ($currentPost -and $line -match '^tags:\s*\[(.+)\]$') {
            $tagsList = $matches[1] -split ',' | ForEach-Object { 
                $_.Trim().Trim('"').Trim("'") 
            }
            $currentPost.tags = $tagsList
        }
    }
    if ($currentPost) { $blogPosts += $currentPost }
    
    Write-Host "   Found $($blogPosts.Count) blog posts in YAML"
    
    $addedCount = 0
    foreach ($post in $blogPosts) {
        if (-not $post.tags -or $post.tags.Count -eq 0) {
            Write-Verbose "   ⏭️ Skipping: $($post.slug) (no tags)"
            continue
        }
        
        $contentId = "blog:$($post.slug)"
        
        if ($contentTags.PSObject.Properties.Name -contains $contentId) {
            Write-Verbose "   ⏭️ Already exists: $contentId"
            continue
        }
        
        # Create entry with slug-based tags
        $entry = @{
            title = $post.title
            url = "/blog/$($post.slug).php"
            tags = $post.tags
        }
        
        $contentTags | Add-Member -MemberType NoteProperty -Name $contentId -Value $entry -Force
        Write-Host "   ✅ Added: $($post.title)" -ForegroundColor Green
        $addedCount++
    }
    
    Write-Host "   📊 Summary: Added $addedCount new blog post entries"
}

# =====================================================
# STEP 3: Add main pages to content_tags.json
# =====================================================
Write-Host "`n🌐 Step 3: Adding main pages to content_tags.json..." -ForegroundColor Yellow

$mainPages = @(
    @{
        id = "page:index"
        title = "JenniNexus - Home"
        url = "/"
        tags = @("gamedev", "gaming", "diy", "music", "voice-acting", "content-creation")
    },
    @{
        id = "page:gamedev"
        title = "Game Development"
        url = "/gamedev.php"
        tags = @("gamedev", "unity", "unreal", "blender", "game-dev", "indie", "3d-modeling")
    },
    @{
        id = "page:gaming"
        title = "Gaming Content"
        url = "/gaming.php"
        tags = @("gaming", "fps", "survival", "horror", "indie")
    },
    @{
        id = "page:diy"
        title = "DIY w/ Jenni"
        url = "/diy.php"
        tags = @("diy", "beauty", "fashion", "nails", "hair", "makeup", "diy-beauty", "self-care")
    },
    @{
        id = "page:music"
        title = "Music Production"
        url = "/music.php"
        tags = @("music", "edm", "production", "festivals")
    },
    @{
        id = "page:blog"
        title = "Blog"
        url = "/blog.php"
        tags = @("blog", "gamedev", "diy", "voice-acting", "tutorials")
    }
)

$pagesAdded = 0
foreach ($page in $mainPages) {
    if ($contentTags.PSObject.Properties.Name -contains $page.id) {
        Write-Verbose "   ⏭️ Already exists: $($page.id)"
        continue
    }
    
    $entry = @{
        title = $page.title
        url = $page.url
        tags = $page.tags
    }
    
    $contentTags | Add-Member -MemberType NoteProperty -Name $page.id -Value $entry -Force
    Write-Host "   ✅ Added: $($page.title)" -ForegroundColor Green
    $pagesAdded++
}

Write-Host "   📊 Summary: Added $pagesAdded main page entries"

# =====================================================
# STEP 4: Save updated content_tags.json
# =====================================================
Write-Host "`n💾 Step 4: Saving updated content_tags.json..." -ForegroundColor Yellow

$backupPath = "$contentTagsPath.backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
Copy-Item $contentTagsPath $backupPath -Force
Write-Host "   💾 Backed up to: $(Split-Path -Leaf $backupPath)" -ForegroundColor Gray

$contentTags | ConvertTo-Json -Depth 10 | Set-Content $contentTagsPath -Encoding UTF8
Write-Host "   ✅ Saved updated content_tags.json"

# =====================================================
# Summary
# =====================================================
Write-Host "`n✅ Tag System Fix Complete!" -ForegroundColor Green
Write-Host "   • Removed duplicate tags" -ForegroundColor Cyan
Write-Host "   • Added blog posts with slug-based tags" -ForegroundColor Cyan
Write-Host "   • Added main pages (index, gamedev, diy, etc.)" -ForegroundColor Cyan
Write-Host "`n📋 Next Steps:" -ForegroundColor Yellow
Write-Host "   1. Test filtering on /tags.php with multiple tags" -ForegroundColor White
Write-Host "   2. Verify blog posts show up in filtered results" -ForegroundColor White
Write-Host "   3. Check that 'DIY' no longer appears twice in tag lists" -ForegroundColor White
Write-Host "   4. Test 'Apply Filters' redirects to /tags.php?filters=..." -ForegroundColor White
