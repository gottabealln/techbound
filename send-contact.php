<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/mailer.php';
require_once __DIR__ . '/includes/spam_guard.php';

header('Content-Type: application/json; charset=utf-8');

function respond(bool $ok, string $message = '', int $status = 200): void {
    http_response_code($status);
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}
// 

function field(string $key, int $max, bool $multiline = false): string {
    $v = trim((string)($_POST[$key] ?? ''));
    $v = strip_tags($v);
    if (!$multiline) $v = preg_replace('/\s+/', ' ', $v);
    return mb_substr($v, 0, $max);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'Method not allowed', 405);

if (spam_guard_honeypot_tripped()) {
    respond(true, 'Thank you! Your message has been sent.');
}

$cfg = require __DIR__ . '/config/config.php';
$rc  = spam_guard_verify_recaptcha($cfg, (string)($_POST['recaptcha_token'] ?? ''));
if (empty($rc['ok'])) {
    respond(false, $rc['error'] ?? 'Security verification failed.', 422);
}


session_start();
if (isset($_SESSION['last_contact']) && time() - $_SESSION['last_contact'] < 30) {
    respond(false, 'Please wait a moment before sending another message.', 429);
}

$name    = field('name', 120);
$email   = field('email', 190);
$code    = field('code', 6);
$phone   = field('phone', 25);
$company = field('company', 150);
$service = field('service', 80);
$message = field('message', 3000, true);

if (mb_strlen($name) < 2)                          respond(false, 'Please enter your name.', 422);
if (!filter_var($email, FILTER_VALIDATE_EMAIL))    respond(false, 'Please enter a valid email.', 422);
if (mb_strlen($message) < 10)                      respond(false, 'Please tell us about your project.', 422);

$digits = preg_replace('/\D/', '', $phone);
if ($phone !== '' && (strlen($digits) < 7 || strlen($digits) > 12)) {
    respond(false, 'Please enter a valid phone number.', 422);
}
$fullPhone = $phone !== '' ? trim($code . ' ' . $phone) : null;

$companyTag = $company;
if ($service !== '') {
    $companyTag = $company !== '' ? "[$service] $company" : "[$service]";
}
$companyTag = mb_substr($companyTag, 0, 150);

$cfg = require __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';

$dbSaved = false;
try {
    $pdo = db();
    $stmt = $pdo->prepare(
        'INSERT INTO contact_messages (name, email, phone, company, message, ip)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$name, $email, $fullPhone, $companyTag ?: null, $message, $_SERVER['REMOTE_ADDR'] ?? null]);
    $dbSaved = true;
} catch (Throwable $e) {
    error_log('Contact DB error: ' . $e->getMessage());
}

$toRaw      = trim((string)($cfg['mail']['to'] ?? ''));
$recipients = $toRaw !== '' ? array_values(array_filter(array_map('trim', explode(',', $toRaw)))) : ['allen.medowa@gmail.com'];

$subjectTag = $service ? " [$service]" : '';
$mailSubj   = 'New enquiry' . $subjectTag . ' from ' . $name;
$mailBody   = "Name: $name\nEmail: $email\nPhone: " . ($fullPhone ?? '-') .
              "\nCategory/Service: " . ($service ?: 'General') .
              "\nCompany: " . ($company ?: '-') . "\n\nMessage:\n$message\n";
$mailHtml   = '<div style="font-family:Arial,sans-serif;line-height:1.6;color:#111827">'
            . '<h2 style="margin:0 0 12px;color:#1b8c43">New Website Enquiry</h2>'
            . '<p><strong>Name:</strong> ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '<br>'
            . '<strong>Email:</strong> ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '<br>'
            . '<strong>Phone:</strong> ' . htmlspecialchars($fullPhone ?? '-', ENT_QUOTES, 'UTF-8') . '<br>'
            . '<strong>Service:</strong> ' . htmlspecialchars($service ?: 'General', ENT_QUOTES, 'UTF-8') . '<br>'
            . '<strong>Company / Website:</strong> ' . htmlspecialchars($company ?: '-', ENT_QUOTES, 'UTF-8') . '</p>'
            . '<p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . '</p>'
            . '</div>';

$mailRes  = send_via_resend($cfg, [
    'to'       => $recipients,
    'reply_to' => $email,
    'subject'  => $mailSubj,
    'text'     => $mailBody,
    'html'     => $mailHtml,
]);
$mailSent = !empty($mailRes['ok']);
if (!$mailSent) {
    error_log('Contact Resend error: ' . ($mailRes['error'] ?? 'Unknown error'));
}

if (!$dbSaved && !$mailSent) {
    $reason = !empty($mailRes['error']) ? $mailRes['error'] : 'Mail delivery failed';
    error_log('Contact delivery failed: ' . $reason);
    respond(false, 'Could not deliver your message right now. Please email us directly at contacts@techbound.in.', 500);
}

$_SESSION['last_contact'] = time();
respond(true, 'Thank you! Your message has been sent. Our team will get back to you within one business day.');