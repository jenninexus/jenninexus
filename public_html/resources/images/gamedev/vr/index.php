<?php
/**
 * VR Images Directory Index
 * Handles placeholder generation and prevents directory listing
 * @author Jenni Nexus
 */

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(dirname(dirname(dirname(__FILE__)))));
}

require_once ROOT_DIR . '/src/Helpers/ImageHelper.php';
require_once ROOT_DIR . '/src/Helpers/UtilsHelper.php';

// Import the helper classes
use JenniNexus\Helpers\ImageHelper;
use JenniNexus\Helpers\UtilsHelper;

// Prevent direct access to directory listings
if (!isset($_GET['placeholder'])) {
    // Redirect to the VR projects page
    header('Location: ' . UtilsHelper::url('/gamedev/vr'));
    exit;
}

// Generate placeholder image if requested
if (isset($_GET['placeholder'])) {
    $width = isset($_GET['width']) ? (int)$_GET['width'] : 800;
    $height = isset($_GET['height']) ? (int)$_GET['height'] : 450;
    $text = isset($_GET['text']) ? $_GET['text'] : 'VR Project';
    
    // VR specific color scheme - indigo background with white text
    $bgColor = '#4f46e5'; // Indigo
    $textColor = '#ffffff'; // White
    
    // Generate and output the placeholder image
    ImageHelper::generatePlaceholder($width, $height, $text, $bgColor, $textColor);
    exit;
}

// Fallback - redirect to VR projects page if no valid request is made
header('Location: ' . UtilsHelper::url('/gamedev/vr'));
exit; 