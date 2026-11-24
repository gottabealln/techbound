<?php
// Load local .env file if present (never overrides server/Render environment variables)
$envFile = __DIR__ . '/../.env';
if (is_file($envFile) && is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $v = trim($v, "\"'");
        if ($k !== '' && getenv($k) === false) {
            putenv("$k=$v");
            $_ENV[$k] = $v;
        }
    }
}

// Reads settings from environment variables (set in Render's dashboard or local .env).
// Falls back to the old local XAMPP values so the site still runs locally.
$env = function (string $key, $default = null) {
    $v = getenv($key);
    return ($v === false || $v === '') ? $default : $v;
};

// Default MySQL port (3306 for both local XAMPP and Cloud / Render; override via DB_PORT env var if needed)
$isLocalXampp = (PHP_OS_FAMILY === 'Windows' && is_dir('C:/xampp'));
$defaultPort  = 3306;

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
        'provider'       => 'resend',
        'resend_api_key' => $env('RESEND_API_KEY', ''),
        'resend_from'    => $env('RESEND_FROM', 'TechBound Website <onboarding@resend.dev>'),
        'to'             => $env('MAIL_TO', 'allen.medowa@gmail.com'),
    ],
];
