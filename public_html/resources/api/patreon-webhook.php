<?php
// Patreon webhook receiver (simple verifier + store)
// Expects header 'X-Patreon-Signature' containing HMAC SHA256 of the raw body using PATREON_WEBHOOK_SECRET

$header_line = 'Content-Type: application/json; charset=utf-8';
header($header_line);

// Use shared helper to resolve secrets path
require_once __DIR__ . '/../includes/app_core.php';
$secretsPath = jn_patreon_secrets_path();
$secret = null;
if (file_exists($secretsPath)) {
    $s = json_decode(file_get_contents($secretsPath), true);
    $secret = $s['PATREON_WEBHOOK_SECRET'] ?? null;
}

$raw = file_get_contents('php://input');
$sig = $_SERVER['HTTP_X_PATREON_SIGNATURE'] ?? null;

if ($secret) {
    $expected = hash_hmac('sha256', $raw, $secret);
    if (!hash_equals($expected, $sig)) {
        http_response_code(403);
        echo json_encode(['status' => 'invalid_signature']);
        exit;
    }
}

// Store webhook payload for background processing
$webhookDir = jn_patreon_storage_dir() . '/webhooks';
if (!is_dir($webhookDir)) { @mkdir($webhookDir, 0755, true); }
$file = $webhookDir . '/webhook_' . time() . '_' . bin2hex(random_bytes(6)) . '.json';
file_put_contents($file, $raw);

echo json_encode(['status' => 'ok', 'stored' => basename($file)]);
exit;
