#!/usr/bin/env pwsh
<#
.SYNOPSIS
    Deploy JenniNexus to production server

.DESCRIPTION
    Two-stage deployment:
    1. Build deploy/ directory from public_html/
    2. Upload to 64.23.141.41:/var/www/jenninexus/ via rsync
    3. Upload Nginx config and reload services
    
.PARAMETER BuildOnly
    Only build deploy/ directory, don't upload to server
    
.PARAMETER Clean
    Clean deploy/ directory before building
    
.PARAMETER DryRun
    Test upload without making changes (rsync --dry-run)
    
.PARAMETER SkipNginx
    Skip Nginx config upload and reload (DEFAULT: true - Nginx config is skipped unless you set -SkipNginx:$false)
    
.EXAMPLE
    .\deploy.ps1 -BuildOnly
    Just build deploy/ directory
    
.EXAMPLE
    .\deploy.ps1 -DryRun
    Test deployment without changes
    
.EXAMPLE
    .\deploy.ps1
    Full deployment to production (Nginx config NOT uploaded)

.EXAMPLE
    .\deploy.ps1 -SkipNginx:$false
    Deploy AND update Nginx config (only use if you changed the config file)
#>

param(
    [switch]$BuildOnly,
    [switch]$Clean,
    [switch]$DryRun,
    [switch]$SkipNginx = $true,
    [switch]$Migrate = $false,
    [switch]$IncludeSecrets = $false,
    [string]$ServerAlias = $null,
    [string]$IdentityFile = $null,
    [switch]$SkipBuild  # New param: Skip local build/clean steps (assume deploy/ is ready)
)

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  JenniNexus Deploy Script" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

$ProjectRoot = Split-Path $PSScriptRoot -Parent
$PublicHtml = Join-Path $ProjectRoot "public_html"
# Top-level deploy folder
$TopDeployDir = Join-Path $ProjectRoot "deploy"
# Site-specific subfolder so deploy package mirrors remote /var/www/jenninexus/
$DeploySiteDir = Join-Path $TopDeployDir "jenninexus"
# Public HTML location inside the deploy package
$DeployPublic = Join-Path $DeploySiteDir "public_html"

Write-Host "Source:  $PublicHtml" -ForegroundColor White
Write-Host "Deploy:  $TopDeployDir`n" -ForegroundColor White

# ==============================================================================
# STAGE 1: BUILD DEPLOY PACKAGE (Skipped if -SkipBuild is passed)
# ==============================================================================

if (-not $SkipBuild) {
    Write-Host "[1/3] Preparing deploy directory..." -ForegroundColor Yellow
    # Only remove the specific site deploy folder to avoid wiping other deploy artifacts
    if (Test-Path $DeploySiteDir -PathType Container) {
        Remove-Item -Path (Join-Path $DeploySiteDir '*') -Recurse -Force -ErrorAction SilentlyContinue
    }
    Write-Host "      Done" -ForegroundColor Green

    # Step 2: Create deploy directory
    Write-Host "[2/3] Creating deploy directory..." -ForegroundColor Yellow
    New-Item -Path $TopDeployDir -ItemType Directory -Force | Out-Null
    New-Item -Path $DeploySiteDir -ItemType Directory -Force | Out-Null
    New-Item -Path $DeployPublic -ItemType Directory -Force | Out-Null
    Write-Host "      Done" -ForegroundColor Green

    # Step 3: Copy public_html to deploy
    Write-Host "[3/3] Copying public_html to deploy..." -ForegroundColor Yellow
    Copy-Item -Path "$PublicHtml\*" -Destination $DeployPublic -Recurse -Force

    # Clean up unnecessary files from deploy
    Write-Host "      Cleaning unnecessary files..." -ForegroundColor Gray

    # Remove legacy HTML files
    Get-ChildItem -Path $TopDeployDir -Filter "*.html" -File -Recurse -ErrorAction SilentlyContinue | Remove-Item -Force
    Write-Host "      → Removed legacy .html files" -ForegroundColor DarkGray

    # Remove source maps (not needed in production)
    Get-ChildItem -Path "$TopDeployDir\resources\css" -Filter "*.map" -File -Recurse -ErrorAction SilentlyContinue | Remove-Item -Force
    Write-Host "      → Removed CSS source maps" -ForegroundColor DarkGray

    # Remove any .md files that shouldn't be deployed
    Get-ChildItem -Path $TopDeployDir -Filter "*.md" -Recurse -ErrorAction SilentlyContinue | Remove-Item -Force
    Write-Host "      → Removed markdown files" -ForegroundColor DarkGray

    # Remove dev-only directory and files
    $devOnlyDir = Join-Path $DeployPublic "dev-only"
    if (Test-Path $devOnlyDir) {
        Remove-Item -Path $devOnlyDir -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "      → Removed dev-only directory" -ForegroundColor DarkGray
    }

    $devFiles = @('theme-demo.php', 'buttons.php')
    foreach ($devFile in $devFiles) {
        $devPath = Join-Path $DeployPublic $devFile
        if (Test-Path $devPath) {
            Remove-Item -Path $devPath -Force -ErrorAction SilentlyContinue
            Write-Host "      → Removed dev-only file: $devFile" -ForegroundColor DarkGray
        }
    }

    # Remove backup folders (!bak, .bak, backup, archived, etc.)
    # Remove known backup folders inside the deploy site directory
    $backupPaths = @(
        "$DeploySiteDir\resources\js\!bak",
        "$DeploySiteDir\resources\css\!bak",
        "$DeploySiteDir\resources\scss",
        "$DeploySiteDir\resources\archived",
        "$DeployPublic\resources\archived"
    )
    foreach ($path in $backupPaths) {
        if (Test-Path $path) {
            Remove-Item -Path $path -Recurse -Force -ErrorAction SilentlyContinue
            Write-Host "      → Removed backup folder: $(Split-Path $path -Leaf)" -ForegroundColor DarkGray
        }
    }

    # Remove storage directory from public_html (storage should be at project root, not web root)
    $publicStorage = Join-Path $DeployPublic "storage"
    if (Test-Path $publicStorage) {
        Remove-Item -Path $publicStorage -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "      → Removed public_html/storage (storage belongs at project root)" -ForegroundColor DarkGray
    }

    # Exclude videos directory from deploy package (large files, deploy manually)
    # Remove videos from deploy package to speed up deployments
    $videosPath = "$DeployPublic\resources\videos"
    if (Test-Path $videosPath) {
        $videoCount = (Get-ChildItem -Path $videosPath -File -ErrorAction SilentlyContinue).Count
        Remove-Item -Path $videosPath -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "      → Excluded videos/ from deploy package ($videoCount files, upload manually when changed)" -ForegroundColor DarkGray
    } else {
        Write-Host "      → Videos directory not found (will be preserved on server)" -ForegroundColor DarkGray
    }

    # Exclude PDFs directory from deploy package (upload manually when new PDFs are added)
    $pdfsPath = "$DeployPublic\resources\pdfs"
    if (Test-Path $pdfsPath) {
        $pdfCount = (Get-ChildItem -Path $pdfsPath -File -Filter "*.pdf" -ErrorAction SilentlyContinue).Count
        Remove-Item -Path $pdfsPath -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "      → Excluded pdfs/ from deploy package ($pdfCount files, upload manually when new PDFs are added)" -ForegroundColor DarkGray
    } else {
        Write-Host "      → PDFs directory not found (will be preserved on server)" -ForegroundColor DarkGray
    }

    # NOTE: This project uses Nginx on the server. Do NOT create or deploy Apache .htaccess files.
    Write-Host "`nSkipping .htaccess creation (Nginx project)" -ForegroundColor Yellow

    # Do NOT place playlist-ids.json at the site top-level. Playlists belong under:
    #   public_html/resources/playlists/playlist-ids.json
    # Ensure favicon placeholder exists but never create top-level playlist-ids.json here.
    if (-not (Test-Path (Join-Path $DeployPublic 'favicon.ico'))) {
        Write-Host "      → Adding placeholder favicon.ico to deploy/jenninexus/public_html" -ForegroundColor DarkGray
        '# placeholder favicon - replace with real .ico file' | Out-File -FilePath (Join-Path $DeployPublic 'favicon.ico') -Encoding ascii -Force
    }

    # Ensure resources/playlists exists in the deploy package and that playlist files are preserved.
    $deployPlaylists = Join-Path $DeployPublic 'resources\playlists'
    if (-not (Test-Path $deployPlaylists)) {
        New-Item -Path $deployPlaylists -ItemType Directory -Force | Out-Null
    }

    # Remove secrets.json from the deploy package unless user explicitly opts in via -IncludeSecrets.
    if (-not $IncludeSecrets) {
        $secretsInDeploy = Get-ChildItem -Path $DeployPublic -Filter 'secrets.json' -Recurse -ErrorAction SilentlyContinue
        foreach ($s in $secretsInDeploy) {
            Remove-Item -Path $s.FullName -Force -ErrorAction SilentlyContinue
            Write-Host "      → Removed secrets.json from deploy package: $($s.FullName)" -ForegroundColor DarkYellow
        }
    }

    # Always remove storage/secrets from deploy package unless explicit opt-in confirmation provided
    $storageSecretsInDeploy = Join-Path $DeployPublic 'storage\secrets\patreon.json'
    if (Test-Path $storageSecretsInDeploy) {
        if (-not $IncludeSecrets) {
            Remove-Item -Path $storageSecretsInDeploy -Force -ErrorAction SilentlyContinue
            Write-Host "      → Removed storage/secrets/patreon.json from deploy package" -ForegroundColor DarkYellow
        } else {
            $confirm = Read-Host "You passed -IncludeSecrets. Type 'INCLUDE-SECRETS' to confirm inclusion of storage/secrets/patreon.json in the deploy package"
            if ($confirm -ne 'INCLUDE-SECRETS') {
                Remove-Item -Path $storageSecretsInDeploy -Force -ErrorAction SilentlyContinue
                Write-Host "      → Confirmation not provided. Removed storage/secrets/patreon.json from deploy package" -ForegroundColor DarkYellow
            } else {
                Write-Host "      → Included storage/secrets/patreon.json in deploy package (explicit confirmation)" -ForegroundColor Red
            }
        }
    }

    # Handle secrets: by default do NOT include secrets in deploy package. Use -IncludeSecrets to opt-in.
    if ($IncludeSecrets) {
        $srcSecrets = Join-Path $ProjectRoot 'src\env\secrets.json'
        $srcEnv = Join-Path $ProjectRoot 'src\env\.env'
        if (Test-Path $srcSecrets) {
            Copy-Item -Path $srcSecrets -Destination (Join-Path $TopDeployDir 'resources\secrets.json') -Force
            Write-Host "      → Copied src/env/secrets.json into deploy/resources/secrets.json" -ForegroundColor DarkGray
        }
        if (Test-Path $srcEnv) {
            Copy-Item -Path $srcEnv -Destination (Join-Path $TopDeployDir '.env') -Force
            Write-Host "      → Copied src/env/.env into deploy/.env" -ForegroundColor DarkGray
        }
        # Optionally include server-only storage secrets (explicit opt-in required)
        $storageSecrets = Join-Path $ProjectRoot 'storage\secrets\patreon.json'
        if (Test-Path $storageSecrets) {
            $destSecretsDir = Join-Path $DeployPublic 'storage\secrets'
            if (-not (Test-Path $destSecretsDir)) { New-Item -Path $destSecretsDir -ItemType Directory -Force | Out-Null }
            Copy-Item -Path $storageSecrets -Destination (Join-Path $destSecretsDir 'patreon.json') -Force
            Write-Host "      → Included storage/secrets/patreon.json in deploy package (explicit opt-in)" -ForegroundColor DarkGray
        }
    } else {
        $secretsPaths = @(
            (Join-Path $TopDeployDir 'resources\secrets.json'),
            (Join-Path $TopDeployDir 'secrets.json'),
            (Join-Path $TopDeployDir 'src\assets\secrets.json')
        )
        foreach ($sp in $secretsPaths) {
            if (Test-Path $sp) {
                Remove-Item -Path $sp -Force -ErrorAction SilentlyContinue
                Write-Host "      → Removed secrets.json from deploy package: $sp" -ForegroundColor DarkYellow
            }
        }
        # Always remove storage secrets from deploy package unless explicitly included
        $storageSecretsInDeploy = Join-Path $DeployPublic 'storage\secrets\patreon.json'
        if (Test-Path $storageSecretsInDeploy) {
            Remove-Item -Path $storageSecretsInDeploy -Force -ErrorAction SilentlyContinue
            Write-Host "      → Removed storage/secrets/patreon.json from deploy package" -ForegroundColor DarkYellow
        }
    }
    if (-not (Test-Path (Join-Path $TopDeployDir 'playlist-ids.json'))) {
        Write-Host "      → Adding placeholder playlist-ids.json" -ForegroundColor DarkGray
        '[]' | Out-File -FilePath (Join-Path $TopDeployDir 'playlist-ids.json') -Encoding utf8 -Force
    }

    # Include a single maintenance helper script in the deploy package (intentional)
    $maintenanceScript = Join-Path $ProjectRoot 'scripts\fix-permissions-jenninexus-remote.sh'
    if (Test-Path $maintenanceScript) {
        # Place the maintenance helper inside deploy/jenninexus/scripts so it lands at /var/www/jenninexus/scripts/
        $deployScriptsDir = Join-Path $DeploySiteDir 'scripts'
        if (-not (Test-Path $deployScriptsDir)) { New-Item -Path $deployScriptsDir -ItemType Directory -Force | Out-Null }
        Copy-Item -Path $maintenanceScript -Destination (Join-Path $deployScriptsDir 'fix-permissions-jenninexus-remote.sh') -Force
        Write-Host "      → Included maintenance script in deploy/jenninexus/scripts: fix-permissions-jenninexus-remote.sh" -ForegroundColor DarkGray
    }

    # Build complete
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  Deploy Directory Built! ✅" -ForegroundColor Green
    Write-Host "========================================`n" -ForegroundColor Green
} else {
    Write-Host "ℹ️  Skipping local build (using existing deploy/ package)" -ForegroundColor Cyan
}

# Count files inside the specific site deploy directory
$fileCount = 0
if (Test-Path $DeploySiteDir) {
    $fileCount = (Get-ChildItem -Path $DeploySiteDir -Recurse -File -ErrorAction SilentlyContinue).Count
}
Write-Host "📦 Deployment package ready:" -ForegroundColor Cyan
Write-Host "   Files: $fileCount" -ForegroundColor White
Write-Host "   Location: $TopDeployDir" -ForegroundColor White
Write-Host ""

# If BuildOnly, stop here
if ($BuildOnly) {
    Write-Host "📦 Build complete! Files ready in: $TopDeployDir" -ForegroundColor Cyan
    Write-Host "   Run without -BuildOnly to deploy to production`n" -ForegroundColor Gray
    exit 0
}

# Prompt user whether to proceed with deployment
Write-Host "`n╔════════════════════════════════════════════════════╗" -ForegroundColor Cyan
Write-Host "║         📦 BUILD COMPLETE - READY TO DEPLOY       ║" -ForegroundColor Cyan
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Cyan
Write-Host ""
Write-Host "Deploy package contains $fileCount files" -ForegroundColor White
Write-Host "Target: $SERVER ($REMOTE_ROOT)" -ForegroundColor White
Write-Host ""
Write-Host "⚠️  Deployment will:"
Write-Host "   • Upload files to production server" -ForegroundColor Yellow
Write-Host "   • Make changes LIVE immediately" -ForegroundColor Yellow
Write-Host "   • Create remote backup before syncing" -ForegroundColor Green
Write-Host ""
$deployConfirm = Read-Host "Proceed with deployment to production? (y/n)"
if ($deployConfirm -notmatch '^[Yy]$') {
    Write-Host ""
    Write-Host "❌ Deployment cancelled by user" -ForegroundColor Yellow
    Write-Host "   Build files ready in: $TopDeployDir" -ForegroundColor Gray
    Write-Host "   Run again and type 'y' to deploy`n" -ForegroundColor Gray
    exit 0
}

Write-Host ""

# ============================================================================
# STAGE 2: Upload to Production Server

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Deploying to Production" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

$SERVER_HOST = "jennidrop-root"
$SERVER_USER = "root"
$SERVER = "${SERVER_USER}@${SERVER_HOST}"
$REMOTE_WEB_ROOT = "/var/www/jenninexus/public_html"
# Top-level remote site root (we upload the whole site folder so scripts/ and other siblings are included)
$REMOTE_ROOT = "/var/www/jenninexus"
$NGINX_CONFIG_LOCAL = Join-Path $ProjectRoot ".config\jenninexus-nginx.conf"
$NGINX_CONFIG_REMOTE = "/etc/nginx/sites-available/jenninexus.conf"

# Release/migration paths (used when -Migrate is passed)
$REMOTE_RELEASES_ROOT = "/var/www/jenninexus/releases"
$RELEASE_NAME = (Get-Date).ToString("yyyyMMddTHHmmss")
$REMOTE_RELEASE_DIR = "$REMOTE_RELEASES_ROOT/$RELEASE_NAME"

if ($DryRun) {
    Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Yellow
    Write-Host "║  🔍 DRY RUN MODE - No files will be changed      ║" -ForegroundColor Yellow
    Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Yellow
    Write-Host ""
}

Write-Host "📍 Server:       $SERVER" -ForegroundColor Gray
Write-Host "📂 Remote:       $REMOTE_WEB_ROOT" -ForegroundColor Gray
Write-Host "🌐 Domain:       https://jenninexus.com" -ForegroundColor Gray
Write-Host ""

Write-Host "Note: remote backups (created during deploy) will be stored under: /var/www/jenninexus/storage/deploys/" -ForegroundColor Yellow

# Deployment Confirmation Prompt (skip if DryRun)
if (-not $DryRun) {
    Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Magenta
    Write-Host "║       ⚠️  DEPLOY TO PRODUCTION SERVER?            ║" -ForegroundColor Magenta
    Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Magenta
    Write-Host ""
    Write-Host "This will upload $fileCount files to:" -ForegroundColor Yellow
    Write-Host "   Server: $SERVER" -ForegroundColor White
    Write-Host "   Path:   $REMOTE_WEB_ROOT" -ForegroundColor White
    Write-Host "   Domain: https://jenninexus.com" -ForegroundColor White
    Write-Host ""
    Write-Host "Changes will be LIVE immediately after upload!" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Helpful manual commands (copy/paste on the server as root) if you need to finish deploy manually:" -ForegroundColor Cyan
    $manualCmds = @(
        "sudo mkdir -p /var/www/jenninexus/storage/deploys",
        "sudo chown -R www-data:www-data /var/www/jenninexus/public_html",
        "sudo chmod -R 755 /var/www/jenninexus",
        "sudo mkdir -p /var/www/jenninexus/scripts",
        "sudo mv -f $remoteTmp/public_html/* /var/www/jenninexus/public_html/",
        "sudo mv -f $remoteTmp/scripts/fix-permissions-jenninexus-remote.sh /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh",
        "sudo chmod +x /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh",
        "sudo /bin/bash /var/www/jenninexus/scripts/fix-permissions-jenninexus-remote.sh"
    )
    foreach ($c in $manualCmds) { Write-Host "   $c" -ForegroundColor Gray }

    $confirmation = Read-Host "Type 'yes' to continue, anything else to cancel"
    
    if ($confirmation -ne 'yes') {
        Write-Host ""
        Write-Host "❌ Deployment cancelled by user" -ForegroundColor Yellow
        Write-Host "   Files are still ready in: $TopDeployDir" -ForegroundColor Gray
        Write-Host "   Run with -DryRun to test deployment`n" -ForegroundColor Gray
        exit 0
    }
    
    Write-Host ""
}
# Check for deployment tools
$useRsync = $false
$useScp = $false

# Resolve ssh target and args using optional ServerAlias and IdentityFile
$sshTarget = $SERVER
if ($ServerAlias -and $ServerAlias -ne '') { $sshTarget = "${SERVER_USER}@${ServerAlias}" }

$sshArgs = @("-o", "ConnectTimeout=10", "-o", "ServerAliveInterval=60", "-o", "ServerAliveCountMax=3")
if ($IdentityFile -and $IdentityFile -ne '') { $sshArgs += @("-i", $IdentityFile) }

# Helper for scp identity option (empty when not provided)
$scpIdentity = ""
if ($IdentityFile -and $IdentityFile -ne '') { $scpIdentity = "-i '$IdentityFile'" }

if (Get-Command rsync -ErrorAction SilentlyContinue) {
# Write a simple manifest of the deploy site (for reference inside deploy package)
# Note: build-and-deploy.ps1 creates the comprehensive DEPLOYMENT-MANIFEST.md at project root
$manifest = "Files: $fileCount`nGenerated: $(Get-Date)`n`nNote: See DEPLOYMENT-MANIFEST.md at project root for detailed deployment information."
$manifest | Out-File -FilePath (Join-Path $DeploySiteDir 'MANIFEST.txt') -Encoding utf8 -Force
    Write-Host "✅ Using rsync for deployment" -ForegroundColor Green
} elseif (Get-Command scp -ErrorAction SilentlyContinue) {
    $useScp = $true
    Write-Host "✅ Using SCP for deployment (rsync not available)" -ForegroundColor Yellow
} else {
    Write-Host "❌ Error: Neither rsync nor scp found!" -ForegroundColor Red
    Write-Host "   Install Git for Windows or enable OpenSSH" -ForegroundColor Yellow
    exit 1
}
Write-Host ""

# Test SSH connection
Write-Host "🔐 Testing SSH connection..." -ForegroundColor Cyan
& ssh @sshArgs $sshTarget "exit" 2>$null
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ SSH connection failed!" -ForegroundColor Red
    Write-Host "   Test with: ssh $sshTarget" -ForegroundColor Yellow
    if ($IdentityFile -and $IdentityFile -ne '') { Write-Host "   If using a custom identity, test: ssh -i $IdentityFile $sshTarget" -ForegroundColor Yellow }
    exit 1
}
Write-Host "✅ SSH connection successful!" -ForegroundColor Green
Write-Host ""

# Before syncing, create a timestamped remote backup of the existing site (non-destructive)
if (-not $DryRun) {
    $BACKUP_TS = (Get-Date).ToUniversalTime().ToString("yyyyMMddTHHmmssZ")
    # Prefer non-root storage location for backups so they live under the project storage/deploys
    $backupDir = "/var/www/jenninexus/storage/deploys"
    $backupPath = "$backupDir/jenninexus_site_bak.$BACKUP_TS.tar.gz"
    # Determine the basename of the remote root (e.g., jenninexus) and use it when archiving
    $REMOTE_BASENAME = (Split-Path $REMOTE_ROOT -Leaf)
    Write-Host "🔁 Creating remote backup archive: $backupPath" -ForegroundColor Cyan
    # Create storage/deploys and ensure ownership, then archive the site into it.
    ssh @sshArgs $sshTarget "sudo mkdir -p $backupDir && sudo chown -R www-data:www-data $backupDir"
    # Create a tar.gz archive of the current remote site and move into storage/deploys
    # Create a compressed tarball of the current site (from /var) and place into storage/deploys
    # Exclude the backups directory itself to prevent recursive ballooning, and large media folders
    $excludes = "--exclude='$REMOTE_BASENAME/storage/deploys' --exclude='$REMOTE_BASENAME/public_html/resources/videos' --exclude='$REMOTE_BASENAME/public_html/resources/pdfs' --exclude='$REMOTE_BASENAME/node_modules'"
    $tarCmd = "sudo bash -lc 'set -e; cd /var && sudo tar $excludes -czf '" + "'" + $backupPath + "' '" + $REMOTE_BASENAME + "' || true'"
    ssh @sshArgs $sshTarget $tarCmd
    if ($LASTEXITCODE -ne 0) {
        Write-Host "⚠️ Remote backup failed (continuing deploy)" -ForegroundColor Yellow
    } else {
        Write-Host "✅ Remote backup created: $backupPath" -ForegroundColor Green
    }
}

# Archive the deploy package and upload it into the project's storage on the server for easy rollbacks
if (-not $DryRun) {
    try {
        Write-Host "📦 Archiving deploy package for storage on server..." -ForegroundColor Cyan
        $ARCH_TS = (Get-Date).ToUniversalTime().ToString("yyyyMMddTHHmmssZ")
        $localArchive = Join-Path $env:TEMP "jenninexus_deploy_$ARCH_TS.zip"
        # Use Compress-Archive (ZIP) for cross-platform reliability from Windows
        if (Test-Path $localArchive) { Remove-Item -Path $localArchive -Force -ErrorAction SilentlyContinue }
        Compress-Archive -Path (Join-Path $DeploySiteDir '*') -DestinationPath $localArchive -Force
        Write-Host "   → Created local archive: $localArchive" -ForegroundColor Green

        # Upload the archive to /tmp on the server then move it into project storage with sudo
        $remoteTmp = "/tmp/$(Split-Path $localArchive -Leaf)"
        if ($IdentityFile -and $IdentityFile -ne '') {
            & scp -i $IdentityFile $localArchive "${sshTarget}:/tmp/"
        } else {
            & scp $localArchive "${sshTarget}:/tmp/"
        }

        if ($LASTEXITCODE -ne 0) {
            Write-Host "⚠️ Failed to upload archive to server (continuing deploy)" -ForegroundColor Yellow
        } else {
            # Move into storage/deploys with sudo and set ownership to www-data
            $remoteName = Split-Path $localArchive -Leaf
            $remoteCmd = "sudo mkdir -p /var/www/jenninexus/storage/deploys && sudo mv /tmp/$remoteName /var/www/jenninexus/storage/deploys/ && sudo chown www-data:www-data /var/www/jenninexus/storage/deploys/$remoteName"
            ssh @sshArgs $sshTarget $remoteCmd
            if ($LASTEXITCODE -eq 0) {
                Write-Host "✅ Archived deploy stored on server: /var/www/jenninexus/storage/deploys/$remoteName" -ForegroundColor Green
            } else {
                Write-Host "⚠️ Could not move archive into project storage (check server permissions)" -ForegroundColor Yellow
            }
        }
    } catch {
        Write-Host "⚠️ Exception while archiving deploy: $_" -ForegroundColor Yellow
    }
}

# Purge specific asset directories on the server to ensure no orphaned files (e.g. SVGs)
if (-not $DryRun -and -not $Migrate) {
    Write-Host "🧹 Purging orphaned assets on server (SVGs)..." -ForegroundColor Cyan
    # We only purge SVGs because we are migrating to FontAwesome and want to ensure old SVGs are removed.
    # We do NOT purge videos/ or pdfs/ as they are managed manually.
    $purgeCmd = "sudo rm -rf $REMOTE_WEB_ROOT/resources/svgs/*"
    ssh @sshArgs $sshTarget $purgeCmd
    if ($LASTEXITCODE -eq 0) {
        Write-Host "   → Purged remote resources/svgs/" -ForegroundColor Green
    } else {
        Write-Host "   → Note: Could not purge remote resources/svgs/ (might be empty or missing)" -ForegroundColor Gray
    }
}

# Sync files
Write-Host "📦 Syncing files to production..." -ForegroundColor Cyan
Write-Host ""

    if ($useRsync) {
    # Use rsync for fast incremental sync
    $RSYNC_OPTS = @(
        "-avz",
        # NO --delete: keep remote files that aren't present locally to avoid destructive deploys
        "--exclude='.git*'",
        "--exclude='*.md'",
        "--exclude='*.html'",
        "--exclude='*.map'",
        "--exclude='node_modules/'",
        "--exclude='.DS_Store'",
        "--exclude='Thumbs.db'",
        "--exclude='resources/videos/'",
        "--exclude='resources/pdfs/'",
        "--exclude='resources/archived/'",
        "--exclude='**/!bak/'",
        "--exclude='**/*.bak'",
        "--exclude='**/*.backup'",
        "--progress"
    )
    
    if ($DryRun) {
        $RSYNC_OPTS += "--dry-run"
    }
    
    # Choose remote target: either the live webroot or a new release dir for migration
    if ($Migrate) {
        $remoteTarget = "${sshTarget}:${REMOTE_RELEASE_DIR}/"
    } else {
        # Upload the entire site folder so sibling directories (scripts/, public_html/) are included
        $remoteTarget = "${sshTarget}:${REMOTE_ROOT}/"
    }

    # Sync the contents of the site-specific folder (deploy/jenninexus/) to the remote site root
    if ($IdentityFile -and $IdentityFile -ne '') {
        # Use ssh -i via rsync's -e option
        $rsyncCmd = @("rsync", "-e", "ssh -i $IdentityFile", $RSYNC_OPTS + @("$DeploySiteDir/", $remoteTarget))
        & $rsyncCmd
    } else {
        rsync $RSYNC_OPTS "$DeploySiteDir/" $remoteTarget
    }
} else {
    # Use SCP as fallback (uploads all files, slower but works)
    if ($DryRun) {
        Write-Host "   [DRY RUN] Would upload deploy/ to ${SERVER}:${REMOTE_WEB_ROOT}/" -ForegroundColor Yellow
        $LASTEXITCODE = 0
    } else {
        if ($Migrate) {
            Write-Host "   → Creating remote release directory: $REMOTE_RELEASE_DIR" -ForegroundColor Gray
            & ssh @sshArgs $sshTarget "sudo mkdir -p $REMOTE_RELEASE_DIR && sudo chown $($SERVER_USER):$($SERVER_USER) $REMOTE_RELEASE_DIR"
            Write-Host "   → Uploading files to release dir via SCP..." -ForegroundColor Gray
            if ($IdentityFile -and $IdentityFile -ne '') { & scp -i $IdentityFile -r "$DeploySiteDir/*" "$($sshTarget):$REMOTE_RELEASE_DIR/" } else { & scp -r "$DeploySiteDir/*" "$($sshTarget):$REMOTE_RELEASE_DIR/" }
        } else {
            # First, clean remote directory
            # Non-destructive upload: do not remove remote files. Upload all files from the local deploy public folder.
            Write-Host "   → Uploading files via SCP (non-destructive) ..." -ForegroundColor Gray
            if ($IdentityFile -and $IdentityFile -ne '') { & scp -i $IdentityFile -r "$DeploySiteDir/*" "$($sshTarget):$REMOTE_ROOT/" } else { & scp -r "$DeploySiteDir/*" "$($sshTarget):$REMOTE_ROOT/" }
        }
    }
}

if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "❌ File sync failed!" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "✅ Files synced successfully!" -ForegroundColor Green
Write-Host ""

# Set permissions and finalize migration (if applicable)
if (-not $DryRun) {
    Write-Host "🔒 Setting file permissions..." -ForegroundColor Cyan

        if ($Migrate) {
        # Set permissions on the release directory
        ssh $SERVER "sudo chown -R www-data:www-data $REMOTE_RELEASE_DIR && sudo chmod -R 755 $REMOTE_RELEASE_DIR"

        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Permissions set on release dir!" -ForegroundColor Green

            # Atomically update public_html symlink to point at the new release
            Write-Host "🔁 Activating new release (atomic symlink swap)..." -ForegroundColor Cyan
            $cmd = "sudo mkdir -p $REMOTE_RELEASES_ROOT && sudo ln -sfn $REMOTE_RELEASE_DIR /var/www/jenninexus/public_html && sudo chown -h root:root /var/www/jenninexus/public_html"
            ssh $SERVER $cmd

            if ($LASTEXITCODE -eq 0) {
                Write-Host "✅ New release active: $RELEASE_NAME" -ForegroundColor Green
            } else {
                Write-Host "❌ Failed to activate release via symlink" -ForegroundColor Red
                Write-Host "   You can manually inspect releases in: $REMOTE_RELEASES_ROOT" -ForegroundColor Yellow
            }
        } else {
            Write-Host "❌ Warning: Could not set permissions on release directory" -ForegroundColor Red
        }
    } else {
        # Set ownership and permissions on live site root (includes public_html and scripts)
        ssh $SERVER "sudo chown -R www-data:www-data $REMOTE_ROOT && sudo chmod -R 755 $REMOTE_ROOT"

        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ Permissions set!" -ForegroundColor Green
            
            # Verify permissions on public_html
            Write-Host "🔍 Verifying permissions (public_html)..." -ForegroundColor Cyan
            $permCheck = ssh $SERVER "ls -la $REMOTE_ROOT/public_html | head -n 20"
            Write-Host $permCheck -ForegroundColor Gray
            Write-Host ""
        } else {
            Write-Host "❌ Warning: Could not set permissions" -ForegroundColor Red
            Write-Host "   You may need to run manually:" -ForegroundColor Yellow
            Write-Host "   ssh $SERVER 'sudo chown -R www-data:www-data $REMOTE_ROOT'" -ForegroundColor Gray
            Write-Host "   ssh $SERVER 'sudo chmod -R 755 $REMOTE_ROOT'" -ForegroundColor Gray
            Write-Host ""
        }
    }

    # Run the maintenance helper on the remote host to tighten permissions (resources/media) and remove legacy symlinks.
    # The maintenance helper is included under deploy/jenninexus/scripts/fix-permissions-jenninexus-remote.sh and uploaded to $REMOTE_ROOT/scripts/.
    Write-Host "🔧 Running remote maintenance helper to finalize permissions and cleanup..." -ForegroundColor Cyan
    ssh $SERVER "sudo sed -i 's/\r$//' $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh || true && sudo chmod +x $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh && sudo /bin/bash $REMOTE_ROOT/scripts/fix-permissions-jenninexus-remote.sh"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Remote maintenance helper executed successfully" -ForegroundColor Green
    } else {
        Write-Host "⚠️ Remote maintenance helper exited with non-zero status" -ForegroundColor Yellow
    }
}

# Upload and configure Nginx — ask the operator to decide at runtime
if (-not $DryRun) {
    $doNginx = $false
    if (-not $PSBoundParameters.ContainsKey('SkipNginx') -or -not $SkipNginx) {
        # Ask operator whether to upload/update nginx now
        Write-Host "Would you like to upload & reload Nginx configuration now? (y/N)" -ForegroundColor Cyan
        $ans = Read-Host "Upload & reload Nginx?"
        if ($ans -match '^[Yy]') { $doNginx = $true }
    } elseif (-not $SkipNginx) {
        $doNginx = $true
    }

    if ($doNginx) {
        Write-Host "📝 Uploading Nginx configuration..." -ForegroundColor Cyan
        if (-not (Test-Path $NGINX_CONFIG_LOCAL)) {
            Write-Host "⚠️  Nginx config not found: $NGINX_CONFIG_LOCAL" -ForegroundColor Yellow
            Write-Host "   Skipping Nginx config upload" -ForegroundColor Gray
        } else {
            # Upload config
            scp $NGINX_CONFIG_LOCAL ${SERVER}:${NGINX_CONFIG_REMOTE}

            if ($LASTEXITCODE -eq 0) {
                Write-Host "✅ Nginx config uploaded!" -ForegroundColor Green

                # Create symlink
                Write-Host "🔗 Creating symlink in sites-enabled..." -ForegroundColor Cyan
                ssh $SERVER "sudo ln -sf $NGINX_CONFIG_REMOTE /etc/nginx/sites-enabled/jenninexus.conf"

                # Test Nginx config
                Write-Host "🧪 Testing Nginx configuration..." -ForegroundColor Cyan
                ssh $SERVER "sudo nginx -t"

                if ($LASTEXITCODE -eq 0) {
                    Write-Host "✅ Nginx config is valid!" -ForegroundColor Green

                    # Ask whether to reload services
                    Write-Host "Reload Nginx and PHP-FPM now? (y/N)" -ForegroundColor Cyan
                    $r = Read-Host "Reload services?"
                    if ($r -match '^[Yy]') {
                        Write-Host "🔄 Reloading Nginx and PHP-FPM..." -ForegroundColor Cyan
                        ssh $SERVER "sudo systemctl reload nginx && sudo systemctl reload php8.3-fpm"
                        if ($LASTEXITCODE -eq 0) {
                            Write-Host "✅ Services reloaded!" -ForegroundColor Green
                        } else {
                            Write-Host "❌ Failed to reload services" -ForegroundColor Red
                            exit 1
                        }
                    } else {
                        Write-Host "Skipped reloading services. Remember to reload manually when ready." -ForegroundColor Yellow
                    }
                } else {
                    Write-Host "❌ Nginx config test failed!" -ForegroundColor Red
                    Write-Host "   Fix the config and try again" -ForegroundColor Yellow
                    exit 1
                }
            } else {
                Write-Host "❌ Failed to upload Nginx config" -ForegroundColor Red
            }
        }
        Write-Host ""
    }
}

# Success
Write-Host ""
Write-Host "╔════════════════════════════════════════════════════╗" -ForegroundColor Green
Write-Host "║           ✅ Deployment Successful! 🎉            ║" -ForegroundColor Green
Write-Host "╚════════════════════════════════════════════════════╝" -ForegroundColor Green
Write-Host ""
Write-Host "🌐 Visit: https://jenninexus.com" -ForegroundColor Cyan
Write-Host "📊 Logs:  ssh $SERVER 'sudo tail -f /var/log/nginx/jenninexus.access.log'" -ForegroundColor Gray
Write-Host ""

if ($DryRun) {
    Write-Host "ℹ️  This was a dry run. Run without -DryRun to deploy for real." -ForegroundColor Yellow
    Write-Host ""
}
