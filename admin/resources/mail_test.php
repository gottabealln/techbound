<?php
declare(strict_types=1);

require __DIR__ . '/../_guard.php';
require_once __DIR__ . '/../../includes/mailer.php';

header('Content-Type: text/plain; charset=utf-8');

$envPath = __DIR__ . '/../../.env';
$cfg     = require __DIR__ . '/../../config/config.php';
$apiKey  = trim((string)($cfg['mail']['resend_api_key'] ?? ''));
$from    = trim((string)($cfg['mail']['resend_from'] ?? ''));
$to      = trim((string)($cfg['mail']['to'] ?? ''));

echo "=== TechBound Mail Diagnostics ===\n";
echo "ENV file exists   : " . (is_file($envPath) ? 'YES' : 'NO') . "\n";
echo "ENV file readable : " . (is_readable($envPath) ? 'YES' : 'NO') . "\n";
echo "cURL available    : " . (function_exists('curl_init') ? 'YES' : 'NO') . "\n";
echo "RESEND_API_KEY    : " . ($apiKey !== '' ? (substr($apiKey, 0, 7) . '...' . substr($apiKey, -4)) : 'EMPTY / NOT SET') . "\n";
echo "RESEND_FROM       : " . ($from !== '' ? $from : 'EMPTY') . "\n";
echo "MAIL_TO           : " . ($to !== '' ? $to : 'EMPTY') . "\n\n";

$recipients = $to !== '' ? array_values(array_filter(array_map('trim', explode(',', $to)))) : ['contacts@techbound.in'];
$res = send_via_resend($cfg, [
    'to'      => $recipients,
    'subject' => 'TechBound Live Mail Test (' . date('Y-m-d H:i:s') . ')',
    'text'    => "This is a live diagnostic email from TechBound Admin.\nHost: " . ($_SERVER['HTTP_HOST'] ?? 'unknown'),
]);

echo "=== Resend API Result ===\n";
echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
