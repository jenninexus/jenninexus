# Jenninexus One-Click Re-indexing Script
# This script triggers a manual re-index of the Jenninexus project in Synabrain.

$Uri = "http://localhost:8765/projects/jenninexus/index"
$Body = @{
    max_chars = 1600
    overlap = 200
    limit_files = 0
    max_chunks = 0
    respect_gitignore = $true
} | ConvertTo-Json

Write-Host "🚀 Triggering re-index for Jenninexus..." -ForegroundColor Cyan

try {
    $Response = Invoke-RestMethod -Uri $Uri -Method Post -ContentType "application/json" -Body $Body
    Write-Host "✅ Re-index successful!" -ForegroundColor Green
    Write-Host "Files indexed: $($Response.files_indexed)"
    Write-Host "Chunks created: $($Response.chunks_indexed)"
    Write-Host "Duration: $($Response.duration_ms) ms"
} catch {
    Write-Host "❌ Re-index failed!" -ForegroundColor Red
    Write-Host $_.Exception.Message
    Write-Host "Ensure Synabrain API is running (.\scripts\start-api.ps1)" -ForegroundColor Yellow
}
