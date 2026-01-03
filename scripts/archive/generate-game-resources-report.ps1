# Generates a CSV report for files under public_html/game that reference /resources or ../resources
$report = @()
Get-ChildItem -Path "public_html\game" -Recurse -File | ForEach-Object {
    $path = $_.FullName
    try {
        $matches = Select-String -Path $path -Pattern '/resources|\.\.\/resources' -ErrorAction Stop
    } catch {
        $matches = $null
    }
    if ($matches) {
        $report += [PSCustomObject]@{ Count = $matches.Count; Path = $path; Sample = ($matches | Select-Object -First 1).Line }
    }
}
$report | Sort-Object Count -Descending | Export-Csv -Path "scripts/game-resources-report.csv" -NoTypeInformation
Write-Output "Wrote scripts/game-resources-report.csv"
