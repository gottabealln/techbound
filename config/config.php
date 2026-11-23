<?php
// Reads settings from environment variables (set in Render's dashboard).
// Falls back to the old local XAMPP values so the site still runs locally.
$env = function (string $key, $default = null) {
    $v = getenv($key);
    return ($v === false || $v === '') ? $default : $v;
};

// Auto-detect default MySQL port based on environment (3307 for local XAMPP Windows, 3306 for Cloud / Render)
$isLocalXampp = (PHP_OS_FAMILY === 'Windows' && is_dir('C:/xampp'));
$defaultPort  = $isLocalXampp ? 3307 : 3306;

return [
    'db' => [
        'host' => $env('DB_HOST', $isLocalXampp ? '127.0.0.1' : ''),
        'name' => $env('DB_NAME', 'techbound_site'),
        'port' => (int) $env('DB_PORT', $defaultPort),
        'user' => $env('DB_USER', 'root'),
        'pass' => $env('DB_PASS', ''),
        // Cloud MySQL hosts (Aiven, TiDB Cloud...) usually require SSL
        'ssl'      => filter_var($env('DB_SSL', 'false'), FILTER_VALIDATE_BOOLEAN),
        'ssl_ca'   => $env('DB_SSL_CA', ''),   // optional path to a CA file
        'ssl_verify' => filter_var($env('DB_SSL_VERIFY', 'true'), FILTER_VALIDATE_BOOLEAN),
    ],
    'mail' => [
        'host'   => $env('MAIL_HOST', 'mail.techbound.in'),
        'port'   => (int) $env('MAIL_PORT', 465),
        'secure' => $env('MAIL_SECURE', 'ssl'),   // 'ssl', 'tls' or ''
        'user'   => $env('MAIL_USER', 'contacts@techbound.in'),
        'pass'   => $env('MAIL_PASS', ''),
        'from'   => $env('MAIL_FROM', 'contacts@techbound.in'),
        'to'     => $env('MAIL_TO', 'contacts@techbound.in'),
    ],
];
