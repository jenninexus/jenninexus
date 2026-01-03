<?php
/**
 * JenniNexus Logo Component
 * 
 * Usage:
 * <?php $logoSize = 'fs-2'; $logoClass = 'my-custom-class'; include 'includes/logo.php'; ?>
 * 
 * Or just:
 * <?php include 'includes/logo.php'; ?>
 */

// Default size if not specified
$logoSize = isset($logoSize) ? $logoSize : '';
$logoClass = isset($logoClass) ? $logoClass : '';
$logoLink = isset($logoLink) ? $logoLink : true;
$logoId = isset($logoId) ? 'id="' . $logoId . '"' : '';
$logoVariant = isset($logoVariant) ? $logoVariant : 'default'; // 'default', 'diy'

// If it's a link (default), wrap in <a>, otherwise use <div>
$tag = $logoLink ? 'a' : 'div';
$href = $logoLink ? 'href="/"' : '';
?>

<<?= $tag ?> <?= $href ?> <?= $logoId ?> class="logo-brand <?= $logoSize ?> <?= $logoClass ?> text-decoration-none">
    <?php if ($logoVariant === 'diy'): ?>
        <span class="diy-text">DIY</span> <span class="with-text">w/</span> <span class="jenni-text">Jenni</span>
    <?php else: ?>
        <span class="jenni-text">Jenni</span><span class="nexus-text">NEXUS</span>
    <?php endif; ?>
</<?= $tag ?>>
