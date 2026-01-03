# Check YouTube playlist RSS availability for IDs listed in music.yaml
# Outputs a JSON report to storage/logs/playlist-check-<date>.json

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$yamlPath = Join-Path $root "..\public_html\resources\playlists\music.yaml" | Resolve-Path
$logDir = Join-Path $root "..\public_html\storage\logs"
if (!(Test-Path $logDir)) { New-Item -ItemType Directory -Path $logDir | Out-Null }

$lines = Get-Content -Path $yamlPath
$ids = @()
foreach ($line in $lines) {
    if ($line -match '^\s*-?\s*id:\s*"(.*?)"') { $ids += $matches[1] }
}

$results = @()
foreach ($id in $ids) {
    Write-Host "Checking playlist id: $id"
    $url = "https://www.youtube.com/feeds/videos.xml?playlist_id=$id"
    $status = $null
    $errorMessage = $null
    $contentLength = $null

    # Prefer system curl if available (faster & more reliable for remote HEAD checks)
    if (Get-Command curl.exe -ErrorAction SilentlyContinue) {
        try {
            $out = & curl.exe -s -o NUL -w "%{http_code} %{size_download}" --max-time 15 $url
            if ($LASTEXITCODE -eq 0) {
                $parts = $out -split '\s+'
                $status = $parts[0]
                $contentLength = $parts[1]
            } else {
                $status = 'ERR'
                $errorMessage = "curl exit code $LASTEXITCODE"
            }
        } catch {
            $status = 'ERR'
            $errorMessage = $_.Exception.Message
        }
    } else {
        try {
            $req = [System.Net.WebRequest]::Create($url)
            $req.Method = 'GET'
            $req.Timeout = 15000
            $resp = $req.GetResponse()
            $status = ([int]$resp.StatusCode)
            $contentLength = $resp.Headers['Content-Length']
            $resp.Close()
        } catch {
            $err = $_.Exception
            if ($err.Response -ne $null) {
                try { $status = ([int]$err.Response.StatusCode) } catch { $status = 'ERR' }
                $errorMessage = $err.Message
            } else {
                $status = 'ERR'
                $errorMessage = $err.Message
            }
        }
    }

    $results += [PSCustomObject]@{
        playlist_id = $id
        url = $url
        status = $status
        content_length = $contentLength
        error = $errorMessage
    }
}

# Write report
$date = Get-Date -Format 'yyyyMMdd-HHmmss'
$outFile = Join-Path $logDir "playlist-check-$date.json"
$results | ConvertTo-Json -Depth 4 | Out-File -FilePath $outFile -Encoding UTF8
Write-Host "Report written to: $outFile"
Write-Host "Summary:"
$results | Format-Table -AutoSize

# Also return path for downstream automation
$script:LAST_OUTPUT = @{ report = $outFile; results = $results }
