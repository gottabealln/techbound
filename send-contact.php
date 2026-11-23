<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

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


if (!empty($_POST['website'])) respond(true);


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

try {
    $pdo = db();
    $stmt = $pdo->prepare(
        'INSERT INTO contact_messages (name, email, phone, company, message, ip)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$name, $email, $fullPhone, $companyTag ?: null, $message, $_SERVER['REMOTE_ADDR'] ?? null]);
} catch (Throwable $e) {
    error_log('Contact DB error: ' . $e->getMessage());
    respond(false, 'Could not save your message.', 500);
}


try {
    $m = new PHPMailer(true);
    $m->isSMTP();
    $m->Host       = $cfg['mail']['host'];
    $m->Port       = $cfg['mail']['port'];
    $m->SMTPAuth   = true;
    $m->Username   = $cfg['mail']['user'];
    $m->Password   = $cfg['mail']['pass'];
    $m->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $m->CharSet    = 'UTF-8';

    $m->setFrom($cfg['mail']['from'], 'Techbound Website');
    $m->addAddress($cfg['mail']['to']);
    $m->addReplyTo($email, $name);

    $subjectTag = $service ? " [$service]" : '';
    $m->Subject = 'New enquiry' . $subjectTag . ' from ' . $name;
    $m->Body    = "Name: $name\nEmail: $email\nPhone: " . ($fullPhone ?? '-') .
                  "\nCategory/Service: " . ($service ?: 'General') .
                  "\nCompany: " . ($company ?: '-') . "\n\nMessage:\n$message\n";
    $m->send();
} catch (Throwable $e) {
    error_log('Contact mail error: ' . $e->getMessage());
}

$_SESSION['last_contact'] = time();
respond(true, 'Message sent.');