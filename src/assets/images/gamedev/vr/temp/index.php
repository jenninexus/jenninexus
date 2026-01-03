<?php
/**
 * VR Temporary Images Directory
 * Prevents directory listing and handles placeholder generation
 * @author Jenni Nexus
 */

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__FILE__, 4));
}

// Import required helpers
use JenniNexus\Helpers\ImageHelper;
use JenniNexus\Helpers\UtilsHelper;

require_once ROOT_DIR . '/src/Helpers/ImageHelper.php';
require_once ROOT_DIR . '/src/Helpers/UtilsHelper.php';

// Prevent direct access to the directory
if (empty($_GET['placeholder'])) {
    // Redirect to VR projects page if not requesting a placeholder
    header('Location: ' . UtilsHelper::url('/gamedev/vr'));
    exit;
}

// Handle placeholder generation
if (isset($_GET['placeholder'])) {
    $width = isset($_GET['width']) ? (int)$_GET['width'] : 800;
    $height = isset($_GET['height']) ? (int)$_GET['height'] : 450;
    $text = isset($_GET['text']) ? $_GET['text'] : 'VR Temp Image';
    
    // Use a darker purple/blue background for VR temp images
    $bgColor = '#4527a0'; // Deep purple
    $textColor = '#ffffff'; // White text
    
    // Generate and output the placeholder image
    ImageHelper::generatePlaceholder($width, $height, $text, $bgColor, $textColor);
    exit;
}

// Default redirect if no valid request
header('Location: ' . UtilsHelper::url('/gamedev/vr'));
exit;