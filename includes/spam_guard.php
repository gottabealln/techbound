<?php
declare(strict_types=1);

/**
 * Anti-spam protection: Honeypot + timing trap + Google reCAPTCHA v3 verification.
 */

function spam_guard_honeypot_tripped(): bool
{
    foreach (['website', 'hp_field', 'fax_number'] as $trap) {
        if (!empty($_POST[$trap])) {
            return true;
        }
    }

    // Timing trap: reject instant bot submissions (< 2 seconds after page render)
    if (!empty($_POST['_form_ts']) && ctype_digit((string)$_POST['_form_ts'])) {
        $elapsed = time() - (int)$_POST['_form_ts'];
        if ($elapsed >= 0 && $elapsed < 2) {
            return true;
        }
    }

    return false;
}

function spam_guard_verify_recaptcha(array $cfg, string $token, string $expectedAction = ''): array
{
    $secret   = trim((string)($cfg['recaptcha']['secret_key'] ?? ''));
    $minScore = (float)($cfg['recaptcha']['min_score'] ?? 0.5);

    // If reCAPTCHA secret key isn't configured yet, allow submission gracefully
    if ($secret === '') {
        return ['ok' => true, 'skipped' => true];
    }

    $token = trim($token);
    if ($token === '') {
        return ['ok' => false, 'error' => 'Security verification missing. Please refresh the page and try again.'];
    }

    $postFields = http_build_query([
        'secret'   => $secret,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
    ]);

    $url  = 'https://www.google.com/recaptcha/api/siteverify';
    $resp = '';

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_USERAGENT      => 'TechBound-Website/1.0',
            CURLOPT_POSTFIELDS     => $postFields,
        ]);
        $resp = (string)curl_exec($ch);
        curl_close($ch);
    } else {
        $ctx = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\nUser-Agent: TechBound-Website/1.0\r\n",
                'content' => $postFields,
                'timeout' => 10,
            ],
        ]);
        $resp = (string)@file_get_contents($url, false, $ctx);
    }

    $data = json_decode($resp, true);
    if (!is_array($data) || empty($data['success'])) {
        error_log('reCAPTCHA v3 verify failed: ' . $resp);
        return ['ok' => false, 'error' => 'Security verification failed. Please try again.'];
    }

    $score = isset($data['score']) ? (float)$data['score'] : 1.0;
    if ($score < $minScore) {
        error_log('reCAPTCHA v3 low score: ' . $score);
        return ['ok' => false, 'error' => 'Automated submission detected. Please email us directly at contacts@techbound.in.'];
    }

    if ($expectedAction !== '' && !empty($data['action']) && $data['action'] !== $expectedAction) {
        error_log('reCAPTCHA v3 action mismatch: expected=' . $expectedAction . ' got=' . $data['action']);
        return ['ok' => false, 'error' => 'Security verification mismatch. Please refresh and try again.'];
    }

    return ['ok' => true, 'score' => $score];
}
