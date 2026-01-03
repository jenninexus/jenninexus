#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Auto-generate playlist entries for content_tags.json from YAML files
    
.DESCRIPTION
    Scans gaming.yaml, diy.yaml, gamedev.yaml, gamejams.yaml, ai.yaml, youtube.yaml
    Extracts playlists with their tags
    Updates content_tags.json with playlist entries
    Only includes playlists that have tags defined
    
.NOTES
    Author: JenniNexus Development Team
    Date: October 30, 2025
#>

param(
    [switch]$DryRun,
    [switch]$Verbose
)

$ErrorActionPreference = 'Stop'

# Paths
$rootPath = Split-Path -Parent $PSScriptRoot
$yamlDir = Join-Path $rootPath "public_html\resources\playlists"
$contentTagsPath = Join-Path $yamlDir "content_tags.json"

Write-Host "Playlist Tag Generator" -ForegroundColor Cyan
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

# Function to parse simple YAML playlists
function Get-PlaylistsFromYAML {
    param([string]$YamlPath)
    
    if (-not (Test-Path $YamlPath)) {
        Write-Warning "YAML file not found: $YamlPath"
        return @()
    }
    
    $lines = Get-Content $YamlPath
    $playlists = @()
    $currentPlaylist = $null
    
    foreach ($line in $lines) {
        # Match playlist ID line
        if ($line -match '^\s*-\s*id:\s*(.+?)\s*$') {
            if ($currentPlaylist -and $currentPlaylist.Tags.Count -gt 0) {
                $playlists += $currentPlaylist
            }
            $playlistId = $Matches[1].Trim().Trim('"').Trim("'")
            $currentPlaylist = @{
                Id = $playlistId
                Title = ""
                Tags = @()
            }
        }
        # Match title line
        elseif ($currentPlaylist -and $line -match '^\s*title:\s*(.+?)\s*$') {
            $title = $Matches[1].Trim().Trim('"').Trim("'")
            $currentPlaylist.Title = $title
        }
        # Match tags line
        elseif ($currentPlaylist -and $line -match '^\s*tags:\s*\[(.+)\]') {
            $tagsStr = $Matches[1]
            $tags = $tagsStr -split ',' | ForEach-Object {
                $_.Trim().Trim('"').Trim("'")
            } | Where-Object { $_ }
            $currentPlaylist.Tags = $tags
        }
    }
    
    # Add last playlist if it has tags
    if ($currentPlaylist -and $currentPlaylist.Tags.Count -gt 0) {
        $playlists += $currentPlaylist
    }
    
    return $playlists
}

# Function to determine page URL from YAML filename
function Get-PageUrl {
    param([string]$YamlFile)
    
    $basename = [System.IO.Path]::GetFileNameWithoutExtension($YamlFile)
    return "/$basename.php"
}

# Scan YAML files
$yamlFiles = @('gaming.yaml', 'diy.yaml', 'gamedev.yaml', 'gamejams.yaml', 'ai.yaml', 'youtube.yaml')
$playlistCount = 0

foreach ($yamlFile in $yamlFiles) {
    $yamlPath = Join-Path $yamlDir $yamlFile
    $pageUrl = Get-PageUrl $yamlFile
    
    Write-Host "`nProcessing: $yamlFile" -ForegroundColor Yellow
    
    $playlists = Get-PlaylistsFromYAML $yamlPath
    
    foreach ($playlist in $playlists) {
        $playlistKey = "playlist:$($playlist.Id)"
        $playlistUrl = "$pageUrl#playlist-$($playlist.Id)"
        
        # Create playlist entry
        $entry = @{
            title = $playlist.Title
            url = $playlistUrl
            tags = $playlist.Tags
        }
        
        # Add to content_tags
        if (-not $contentTags.ContainsKey($playlistKey)) {
            $contentTags[$playlistKey] = $entry
            $playlistCount++
            
            if ($Verbose) {
                Write-Host "  Added: $($playlist.Title) [$($playlist.Tags.Count) tags]" -ForegroundColor Green
            }
        } else {
            if ($Verbose) {
                Write-Host "  Exists: $($playlist.Title)" -ForegroundColor Gray
            }
        }
    }
    
    Write-Host "  Found $($playlists.Count) tagged playlists" -ForegroundColor Cyan
}

Write-Host "`n" + ("=" * 50)
Write-Host "Summary:" -ForegroundColor Cyan
Write-Host "  - New playlists added: $playlistCount" -ForegroundColor Green
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
