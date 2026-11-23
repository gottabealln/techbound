<?php
declare(strict_types=1);

function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    $cfg = null;
    foreach ([__DIR__ . '/../config/config.php', __DIR__ . '/../config.php'] as $p) {
        if (is_file($p)) { $cfg = require $p; break; }
    }
    if (!$cfg) throw new RuntimeException('Config file not found.');

    $port = $cfg['db']['port'] ?? null;
    $host = trim((string)($cfg['db']['host'] ?? ''));
    if ($host === '') {
        throw new RuntimeException('Database host is not configured.');
    }
    $portPart = !empty($port) ? "port={$port};" : "";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // SSL for cloud databases
    if (!empty($cfg['db']['ssl'])) {
        $ca = $cfg['db']['ssl_ca'] ?? '';
        if ($ca === '' || !is_file($ca)) {
            $ca = '/etc/ssl/certs/ca-certificates.crt'; // system CA bundle in the Docker image
        }
        $options[PDO::MYSQL_ATTR_SSL_CA] = $ca;
        if (array_key_exists('ssl_verify', $cfg['db']) && !$cfg['db']['ssl_verify']) {
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }
    }

    $pdo = new PDO(
        "mysql:host={$host};{$portPart}dbname={$cfg['db']['name']};charset=utf8mb4",
        $cfg['db']['user'],
        $cfg['db']['pass'],
        $options
    );
    return $pdo;
}
