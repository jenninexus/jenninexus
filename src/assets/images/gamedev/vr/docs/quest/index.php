<?php
/**
 * Quest VR Documentation - Directory Listing Prevention
 * Redirects users to the VR Projects page
 * @author Jenni Nexus
 */

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__FILE__, 5));
}

require_once ROOT_DIR . '/src/Helpers/UtilsHelper.php';

use JenniNexus\Helpers\UtilsHelper;

// Prevent directory listing
header('Location: ' . UtilsHelper::url('/gamedev/vr'));
exit; 