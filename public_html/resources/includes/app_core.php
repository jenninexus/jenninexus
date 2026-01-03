<?php
// app_core.php — small shared core for resource endpoints (not a full framework)
// Provides a session-backed AuthManager fallback and a couple of helpers.

if (defined('JENNINEXUS_APP_CORE_INCLUDED') && JENNINEXUS_APP_CORE_INCLUDED) {
    return;
}
define('JENNINEXUS_APP_CORE_INCLUDED', true);

// Ensure a session is available for endpoints that rely on session state
if (session_status() === PHP_SESSION_NONE) {
    // Prefer an application-controlled session storage under project storage/
    $jn_sessions = dirname(__DIR__, 3) . '/storage/sessions';
    if (!is_dir($jn_sessions)) {
        @mkdir($jn_sessions, 0750, true);
    }
    // Use a local, project-writable session path so runtime files stay in storage/
    if (is_dir($jn_sessions) && is_writable($jn_sessions)) {
        ini_set('session.save_path', $jn_sessions);
    }
    session_start();
}

// Minimal AuthManager fallback used when the full app framework isn't present
if (!class_exists('JenniNexus\\Auth\\AuthManager')) {
    class PatreonFallbackAuthManager {
        public function setPatreonSession($user, $isPatron) {
            $_SESSION['patreon_user'] = $user;
            $_SESSION['is_patron'] = (bool) $isPatron;
        }
        public function isPatron() {
            return !empty($_SESSION['is_patron']);
        }
        public function getPatreonUserData() {
            return $_SESSION['patreon_user'] ?? null;
        }
    }
    class_alias('PatreonFallbackAuthManager', 'JenniNexus\\Auth\\AuthManager');
}

// Helpers for common paths used by Patreon endpoints.
function jn_patreon_secrets_path() {
    // public_html/resources/includes -> up 3 levels to project root
    return dirname(__DIR__, 3) . '/storage/secrets/patreon.json';
}

function jn_patreon_storage_dir() {
    return dirname(__DIR__, 3) . '/storage/patreon';
}

return;