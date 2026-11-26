<?php
declare(strict_types=1);

require __DIR__ . '/../_guard.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

$pdo = admin_db();
if (!$pdo) {
    echo json_encode(['ok' => false, 'unread_count' => 0, 'latest_id' => 0, 'latest' => null]);
    exit;
}

// Ensure `is_read` column exists on contact_messages
try {
    $cols = $pdo->query("SHOW COLUMNS FROM contact_messages LIKE 'is_read'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE contact_messages ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0 AFTER ip");
    }
} catch (Throwable $e) {
    // Ignore if ALTER is restricted
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));
    $id     = (int)($_POST['id'] ?? 0);

    try {
        if ($action === 'mark_read' && $id > 0) {
            $pdo->prepare('UPDATE contact_messages SET is_read = 1 WHERE id = ?')->execute([$id]);
        } elseif ($action === 'mark_unread' && $id > 0) {
            $pdo->prepare('UPDATE contact_messages SET is_read = 0 WHERE id = ?')->execute([$id]);
        } elseif ($action === 'mark_all_read') {
            $pdo->exec('UPDATE contact_messages SET is_read = 1 WHERE is_read = 0');
        }
    } catch (Throwable $e) {
        echo json_encode(['ok' => false, 'error' => 'Update failed']);
        exit;
    }
}

try {
    $unread = (int)$pdo->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();
    $latest = $pdo->query('SELECT id, name, email, company, created_at, is_read FROM contact_messages ORDER BY id DESC LIMIT 1')->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'ok'           => true,
        'unread_count' => $unread,
        'latest_id'    => $latest ? (int)$latest['id'] : 0,
        'latest'       => $latest ?: null,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    echo json_encode(['ok' => false, 'unread_count' => 0, 'latest_id' => 0, 'latest' => null]);
}
