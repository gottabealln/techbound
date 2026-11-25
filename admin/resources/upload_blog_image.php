<?php
declare(strict_types=1);

require __DIR__ . '/../_guard.php';

header('Content-Type: application/json; charset=utf-8');

function upload_json(bool $ok, array $extra = [], int $status = 200): void {
    http_response_code($status);
    echo json_encode(array_merge(['ok' => $ok], $extra), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    upload_json(false, ['message' => 'Method not allowed.'], 405);
}

$csrf = (string)($_SESSION['_csrf'] ?? '');
$sent = (string)($_POST['_csrf'] ?? '');
if ($csrf === '' || !hash_equals($csrf, $sent)) {
    upload_json(false, ['message' => 'Security token expired. Please refresh the page.'], 403);
}

if (empty($_FILES['image']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
    upload_json(false, ['message' => 'Please choose an image file to upload.'], 422);
}

$file = $_FILES['image'];
if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    upload_json(false, ['message' => 'Upload failed with error code ' . (int)$file['error'] . '.'], 422);
}

$maxBytes = 8 * 1024 * 1024; // 8 MB
if (($file['size'] ?? 0) > $maxBytes) {
    upload_json(false, ['message' => 'Image must be 8 MB or smaller.'], 422);
}

$allowedMimes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    'image/gif'  => 'gif',
    'image/avif' => 'avif',
];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = $finfo ? (string)finfo_file($finfo, $file['tmp_name']) : '';
if ($finfo) finfo_close($finfo);

if (!isset($allowedMimes[$mime])) {
    upload_json(false, ['message' => 'Unsupported image format. Please upload JPG, PNG, WebP, GIF, or AVIF.'], 422);
}

$ext  = $allowedMimes[$mime];
$base = pathinfo((string)($file['name'] ?? 'blog-image'), PATHINFO_FILENAME);
$base = strtolower(trim((string)preg_replace('/[^a-zA-Z0-9]+/', '-', $base), '-'));
if ($base === '') $base = 'blog-image';
$base = substr($base, 0, 60);

$uploadDir = __DIR__ . '/../../assets/blog';
if (!is_dir($uploadDir) && !@mkdir($uploadDir, 0755, true)) {
    upload_json(false, ['message' => 'Could not create assets/blog directory.'], 500);
}

$filename = $base . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
$destPath = $uploadDir . '/' . $filename;

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    upload_json(false, ['message' => 'Could not save uploaded image.'], 500);
}

$relPath = 'assets/blog/' . $filename;
upload_json(true, [
    'path' => $relPath,
    'url'  => BASE_URL . $relPath,
]);
