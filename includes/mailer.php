<?php
declare(strict_types=1);

/**
 * Resend Email API Helper (https://api.resend.com/emails)
 * Replaces SMTP for reliable delivery on both local XAMPP and cloud hosts (Render).
 */
function send_via_resend(array $cfg, array $opts): array
{
    $apiKey = trim((string)($cfg['mail']['resend_api_key'] ?? ''));
    if ($apiKey === '') {
        return ['ok' => false, 'error' => 'RESEND_API_KEY is not configured.'];
    }

    $from = trim((string)($opts['from'] ?? ($cfg['mail']['resend_from'] ?? 'TechBound Website <contacts@techbound.in>')));
    $to   = $opts['to'] ?? ['contacts@techbound.in'];
    if (is_string($to)) {
        $to = [$to];
    }
    $to = array_values(array_unique(array_filter(array_map('trim', $to))));
    if (empty($to)) {
        $to = ['contacts@techbound.in'];
    }

    $payload = [
        'from'    => $from,
        'to'      => $to,
        'subject' => (string)($opts['subject'] ?? 'New TechBound Website Enquiry'),
        'text'    => (string)($opts['text'] ?? ''),
    ];

    if (!empty($opts['html'])) {
        $payload['html'] = (string)$opts['html'];
    }
    if (!empty($opts['reply_to'])) {
        $payload['reply_to'] = (string)$opts['reply_to'];
    }
    if (!empty($opts['attachments']) && is_array($opts['attachments'])) {
        $payload['attachments'] = $opts['attachments'];
    }

    $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $url  = 'https://api.resend.com/emails';

    $status = 0;
    $resp   = '';
    $err    = '';

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_USERAGENT      => 'TechBound-Website/1.0',
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS     => $json,
        ]);
        $resp   = (string)curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err    = curl_error($ch);
        curl_close($ch);
    } else {
        $ctx = stream_context_create([
            'http' => [
                'method'        => 'POST',
                'header'        => "Authorization: Bearer {$apiKey}\r\nContent-Type: application/json\r\nAccept: application/json\r\nUser-Agent: TechBound-Website/1.0\r\n",
                'content'       => $json,
                'timeout'       => 15,
                'ignore_errors' => true,
            ],
        ]);
        $resp = (string)@file_get_contents($url, false, $ctx);
        if (!empty($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) {
            $status = (int)$m[1];
        }
    }

    if ($status >= 200 && $status < 300) {
        return ['ok' => true, 'status' => $status, 'response' => $resp];
    }

    return [
        'ok'       => false,
        'status'   => $status,
        'error'    => $err !== '' ? $err : ('Resend HTTP ' . $status . ': ' . $resp),
        'response' => $resp,
    ];
}
