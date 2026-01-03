<?php
// Define ROOT_DIR if not already defined
if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(dirname(dirname(dirname(__FILE__)))));
}

// Include necessary files
require_once ROOT_DIR . '/includes/configs/config.php';
require_once ROOT_DIR . '/src/Helpers/ImageHelper.php';

use JenniNexus\Helpers\ImageHelper;

// Game images to generate
$gameImages = [
    'purgatoryfell' => 'Purgatory Fell',
    'jennistyles' => 'Jenni Styles',
    'tankoff' => 'Tank Off',
    'roomscale' => 'Roomscale VR',
    'catgame' => 'Cat Game',
    'alterkat' => 'AlterKat'
];

// Create games directory if not exists
$gamesDir = __DIR__ . '/games';
if (!is_dir($gamesDir)) {
    mkdir($gamesDir, 0755, true);
}

// Create logos directory if not exists
$logosDir = dirname(dirname(__DIR__)) . '/logos';
if (!is_dir($logosDir)) {
    mkdir($logosDir, 0755, true);
}

// Generate game image placeholders
echo "Generating game image placeholders...\n";
foreach ($gameImages as $slug => $name) {
    $outputPath = $gamesDir . '/' . $slug . '.jpg';
    if (!file_exists($outputPath)) {
        echo "Creating $name placeholder at $outputPath\n";
        ImageHelper::generatePlaceholder(
            500, 300, 
            '493267', 'ffffff',
            $name, 
            $outputPath
        );
    } else {
        echo "Skipping $name - file already exists\n";
    }
}

// Generate Martian Games logo
$logoPath = $logosDir . '/martian-games-logo.png';
if (!file_exists($logoPath)) {
    echo "Creating Martian Games logo at $logoPath\n";
    ImageHelper::generatePlaceholder(
        400, 400, 
        '28004d', 'a0ff00',
        'MARTIAN GAMES', 
        $logoPath
    );
} else {
    echo "Skipping Martian Games logo - file already exists\n";
}

echo "Done generating placeholders!\n"; 