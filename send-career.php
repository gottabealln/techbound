<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

function respond(bool $ok, string $message = '', int $status = 200, array $extra = []): void {
    http_response_code($status);
    echo json_encode(array_merge(['ok' => $ok, 'message' => $message], $extra));
    exit;
}

function field(string $key, int $max = 255, bool $multiline = false): string {
    $v = trim((string)($_POST[$key] ?? ''));
    $v = strip_tags($v);
    if (!$multiline) {
        $v = preg_replace('/\s+/', ' ', $v);
    }
    return mb_substr($v, 0, $max);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Method not allowed', 405);
}

// Honeypot check
if (!empty($_POST['website'])) {
    respond(true, 'Application received.');
}

session_start();
if (isset($_SESSION['last_career_submit']) && time() - $_SESSION['last_career_submit'] < 20) {
    respond(false, 'Please wait a moment before submitting another application.', 429);
}

$name       = field('name', 120);
$email      = field('email', 190);
$code       = field('code', 6);
$phone      = field('phone', 25);
$role       = field('role', 100);
$experience = field('experience', 50);
$portfolio  = field('portfolio', 255);
$message    = field('message', 3000, true);

if (mb_strlen($name) < 2) {
    respond(false, 'Please enter your full name.', 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please provide a valid email address.', 422);
}
if ($role === '') {
    $role = 'General / Speculative Application';
}

$digits = preg_replace('/\D/', '', $phone);
if ($phone !== '' && (strlen($digits) < 7 || strlen($digits) > 15)) {
    respond(false, 'Please enter a valid phone number.', 422);
}
$fullPhone = $phone !== '' ? trim(($code ?: '+91') . ' ' . $phone) : null;

// Handle resume file upload if provided
$resumePath = null;
$resumeFilename = null;
if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['resume'];
    $maxSize = 8 * 1024 * 1024; // 8 MB

    if ($file['size'] > $maxSize) {
        respond(false, 'Resume file size exceeds the 8MB limit.', 422);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExts = ['pdf', 'doc', 'docx', 'rtf'];
    if (!in_array($ext, $allowedExts, true)) {
        respond(false, 'Please upload your resume in PDF, DOC, or DOCX format.', 422);
    }

    $safeName = 'resume_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $targetDir = __DIR__ . '/uploads/resumes/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $dest = $targetDir . $safeName;
    if (move_uploaded_file($file['tmp_name'], $dest)) {
        $resumePath = $dest;
        $resumeFilename = $safeName;
    }
}

// Compile structured text
$compiledMessage = "--- CAREER APPLICATION ---\n";
$compiledMessage .= "Role Applied: " . $role . "\n";
$compiledMessage .= "Experience Level: " . ($experience ?: 'Not specified') . "\n";
if ($portfolio !== '') {
    $compiledMessage .= "Portfolio / LinkedIn / GitHub: " . $portfolio . "\n";
}
if ($resumeFilename) {
    $compiledMessage .= "Resume File: uploads/resumes/" . $resumeFilename . "\n";
}
if ($message !== '') {
    $compiledMessage .= "\nApplicant Note:\n" . $message . "\n";
}

$companyTag = 'Career: ' . mb_substr($role, 0, 80);
if ($experience) {
    $companyTag .= ' (' . mb_substr($experience, 0, 30) . ')';
}

$cfg = require __DIR__ . '/config/config.php';

require_once __DIR__ . '/includes/db.php';

// Save into contact_messages table (shown in Admin -> Enquiries / Leads)
try {
    $pdo = db();

    $stmt = $pdo->prepare(
        'INSERT INTO contact_messages (name, email, phone, company, message, ip)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $name,
        $email,
        $fullPhone,
        $companyTag,
        $compiledMessage,
        $_SERVER['REMOTE_ADDR'] ?? null
    ]);
} catch (Throwable $e) {
    error_log('Career DB error: ' . $e->getMessage());
    respond(false, 'We could not save your application right now. Please try again or email us directly at contacts@techbound.in', 500);
}

// Email notification
try {
    if (!empty($cfg['mail']['host']) && !empty($cfg['mail']['user'])) {
        $m = new PHPMailer(true);
        $m->isSMTP();
        $m->Host       = $cfg['mail']['host'];
        $m->Port       = $cfg['mail']['port'] ?? 465;
        $m->SMTPAuth   = true;
        $m->Username   = $cfg['mail']['user'];
        $m->Password   = $cfg['mail']['pass'];
        $m->SMTPSecure = ($cfg['mail']['secure'] ?? 'ssl') === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $m->CharSet    = 'UTF-8';

        $m->setFrom($cfg['mail']['from'] ?? 'contacts@techbound.in', 'Techbound Careers Portal');
        $m->addAddress($cfg['mail']['to'] ?? 'contacts@techbound.in');
        $m->addReplyTo($email, $name);

        $m->Subject = 'New Job Application: ' . $role . ' - ' . $name;
        $m->Body    = "A new application has been submitted through the Careers page:\n\n" .
                      "Name: $name\n" .
                      "Email: $email\n" .
                      "Phone: " . ($fullPhone ?? 'Not provided') . "\n" .
                      "Role: $role\n" .
                      "Experience: " . ($experience ?: 'Not provided') . "\n" .
                      "Portfolio/Links: " . ($portfolio ?: 'None') . "\n\n" .
                      "Applicant Message:\n" . ($message ?: 'No message provided') . "\n\n" .
                      ($resumeFilename ? "Resume Attached.\n" : "No resume attached.\n");

        if ($resumePath && file_exists($resumePath)) {
            $m->addAttachment($resumePath, $name . '_Resume.' . pathinfo($resumePath, PATHINFO_EXTENSION));
        }

        $m->send();
    }
} catch (Throwable $e) {
    error_log('Career Mail error: ' . $e->getMessage());
    // Continue since DB record is safely stored
}

$_SESSION['last_career_submit'] = time();
respond(true, 'Application submitted successfully! Our talent acquisition team will review your profile and reach out.');
