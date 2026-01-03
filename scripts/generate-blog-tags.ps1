#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Auto-generate blog post entries for content_tags.json from blog-posts.yaml
    
.DESCRIPTION
    Scans blog-posts.yaml
    Extracts blog posts with their tags
    Updates content_tags.json with blog entries (prefixed with 'blog:')
    
.NOTES
    Author: JenniNexus Development Team
    Date: November 19, 2025
#>

param(
    [switch]$DryRun,
    [switch]$Verbose
)

$ErrorActionPreference = 'Stop'

# Paths
$rootPath = Split-Path -Parent $PSScriptRoot
$yamlDir = Join-Path $rootPath "public_html\resources\playlists"
$blogYamlPath = Join-Path $yamlDir "blog-posts.yaml"
$contentTagsPath = Join-Path $yamlDir "content_tags.json"

Write-Host "Blog Tag Generator" -ForegroundColor Cyan
Write-Host "=" * 50

# Load existing content_tags.json
if (Test-Path $contentTagsPath) {
    $jsonContent = Get-Content $contentTagsPath -Raw
    $jsonObj = ConvertFrom-Json $jsonContent
    
    # Convert PSCustomObject to Hashtable for PS 5.1 compatibility
    $contentTags = @{}
    if ($jsonObj) {
        foreach ($prop in $jsonObj.PSObject.Properties) {
            $contentTags[$prop.Name] = $prop.Value
        }
    }
    Write-Host "Loaded existing content_tags.json" -ForegroundColor Green
} else {
    Write-Host "content_tags.json not found at: $contentTagsPath" -ForegroundColor Red
    exit 1
}

# Function to parse blog YAML
function Get-BlogPostsFromYAML {
    param([string]$YamlPath)
    
    if (-not (Test-Path $YamlPath)) {
        Write-Warning "YAML file not found: $YamlPath"
        return @()
    }
    
    $lines = Get-Content $YamlPath
    $posts = @()
    $currentPost = $null
    
    foreach ($line in $lines) {
        # Match slug line (start of new post)
        if ($line -match '^\s*-\s*slug:\s*(.+?)\s*$') {
            if ($currentPost) {
                $posts += $currentPost
            }
            $slug = $Matches[1].Trim().Trim('"').Trim("'")
            $currentPost = @{
                Slug = $slug
                Title = ""
                Tags = @()
                Excerpt = ""
                Image = ""
            }
        }
        # Match title
        elseif ($currentPost -and $line -match '^\s*title:\s*(.+?)\s*$') {
            $currentPost.Title = $Matches[1].Trim().Trim('"').Trim("'")
        }
        # Match excerpt
        elseif ($currentPost -and $line -match '^\s*excerpt:\s*(.+?)\s*$') {
            $currentPost.Excerpt = $Matches[1].Trim().Trim('"').Trim("'")
        }
        # Match image
        elseif ($currentPost -and $line -match '^\s*image:\s*(.+?)\s*$') {
            $currentPost.Image = $Matches[1].Trim().Trim('"').Trim("'")
        }
        # Match tags
        elseif ($currentPost -and $line -match '^\s*tags:\s*\[(.+)\]') {
            $tagsStr = $Matches[1]
            $tags = $tagsStr -split ',' | ForEach-Object {
                $_.Trim().Trim('"').Trim("'")
            } | Where-Object { $_ }
            $currentPost.Tags = $tags
        }
    }
    
    # Add last post
    if ($currentPost) {
        $posts += $currentPost
    }
    
    return $posts
}

# Process Blog Posts
Write-Host "`nProcessing: blog-posts.yaml" -ForegroundColor Yellow
$posts = Get-BlogPostsFromYAML $blogYamlPath
$newCount = 0

foreach ($post in $posts) {
    $key = "blog:$($post.Slug)"
    
    # Create entry
    $entry = @{
        title = $post.Title
        url = "/blog/$($post.Slug).php"
        tags = $post.Tags
        type = "blog"
        description = $post.Excerpt
        thumbnail = if ($post.Image.StartsWith('/')) { "/resources/images$($post.Image)" } else { "/resources/images/$($post.Image)" }
    }
    
    # Fix double slash if present
    $entry.thumbnail = $entry.thumbnail -replace '//', '/'
    
    # Add/Update content_tags
    # Always update to ensure latest metadata
    $contentTags[$key] = $entry
    $newCount++
    
    Write-Host "  Processed: $($post.Title)" -ForegroundColor Green
}

Write-Host "  Processed $($posts.Count) blog posts" -ForegroundColor Cyan

Write-Host "`n" + ("=" * 50)
Write-Host "Summary:" -ForegroundColor Cyan
Write-Host "  - Blog posts processed: $newCount" -ForegroundColor Green
Write-Host "  - Total entries in content_tags: $($contentTags.Count)" -ForegroundColor Cyan

# Save updated content_tags.json
if (-not $DryRun) {
    # Convert back to JSON with proper formatting
    $json = $contentTags | ConvertTo-Json -Depth 10
    Set-Content -Path $contentTagsPath -Value $json -Encoding UTF8
    Write-Host "`nUpdated content_tags.json" -ForegroundColor Green
} else {
    Write-Host "`nDRY RUN - No changes saved" -ForegroundColor Yellow
}

Write-Host ""
