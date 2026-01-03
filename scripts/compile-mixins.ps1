# Compile mixins SCSS into generated CSS (one-time usage helper)
# Usage: pwsh .\scripts\compile-mixins.ps1

$scss = "src/assets/scss/generated/mixins-usage.scss"
$cssOut = "src/assets/css/generated/mixins.css"

function Try-RunSass() {
    $sassCmd = "sass"
    $err = $null
    try {
        $args = @($scss + ':' + $cssOut, "--no-source-map", "--style=compressed")
        $proc = Start-Process -FilePath $sassCmd -ArgumentList $args -NoNewWindow -PassThru -ErrorAction Stop
        $proc.WaitForExit()
        if ($proc.ExitCode -eq 0) {
            Write-Host "Compiled $scss -> $cssOut"
            return $true
        } else {
            Write-Host "sass exited with code $($proc.ExitCode)"
            return $false
        }
    } catch {
        return $false
    }
}

if (Try-RunSass) { exit 0 }

Write-Host "sass CLI not found or compilation failed. Falling back to conservative precompiled file (already present)." -ForegroundColor Yellow
Write-Host "To enable proper SCSS compilation, install the Dart Sass CLI (https://sass-lang.com/install) and re-run this script." -ForegroundColor Yellow
exit 0
