<#
Generates a CSV report of files under public_html that reference /resources or ../resources
Output: scripts/resources-report.csv (columns: Count,Path,Sample)
#>
$report = @()
Get-ChildItem -Path "public_html" -Recurse -File | ForEach-Object {
    $path = $_.FullName
    try {
    $fileMatches = Select-String -Path $path -Pattern '/resources|\.\.\/resources' -ErrorAction Stop
    } catch {
        $fileMatches = $null
    }
    if ($fileMatches) {
        $count = $fileMatches.Count
        $sample = ($fileMatches | Select-Object -First 1).Line -replace '\r','' -replace '\n',''
        $report += [PSCustomObject]@{ Count = $count; Path = $path; Sample = $sample }
    }
}
$report | Sort-Object Count -Descending | Export-Csv -Path "scripts/resources-report.csv" -NoTypeInformation
Write-Output "Report written to scripts/resources-report.csv"
