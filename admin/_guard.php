<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/lib/auth.php';

admin_session_start();
if (!admin_current()) {
    header('Location: ' . admin_url('login.php'));
    exit;
}

try { admin_ensure_schema(); } catch (Throwable $e) { /* run admin/sql/roles_permissions.sql manually if ALTER is not allowed */ }

// Reload role / permissions from the DB (logs out deactivated or deleted users)
if (!admin_refresh()) {
    header('Location: ' . admin_url('login.php'));
    exit;
}

// Page-level access control, enforced for every admin page that includes this guard
$__page = basename($_SERVER['SCRIPT_NAME'] ?? '');
if (isset(ADMIN_PAGE_PERMISSIONS[$__page])) {
    admin_require(ADMIN_PAGE_PERMISSIONS[$__page]);
}
unset($__page);
