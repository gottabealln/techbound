<?php
declare(strict_types=1);

/*
 * Roles
 *   admin  = Super Admin  -> every feature + user management (create / edit / delete users)
 *   editor = Sub User     -> Blog Posts always, plus whatever sections the Super Admin grants
 *
 * Sub users can NEVER manage users. That check is enforced on the server in
 * admin_require_super() and in admin/resources/users.php, not just hidden in the menu.
 */

// Sections a Super Admin can grant to a Sub User.
// key => [label, icon, page path (relative to /admin/), description]
const ADMIN_PERMISSIONS = [
    'dashboard'    => ['Dashboard',              'dashboard',         'index.php',                       'Overview stats and recent enquiries'],
    'enquiries'    => ['Enquiries / Leads',      'mark_email_unread', 'resources/contact_messages.php',  'View and manage contact form leads'],
    'services'     => ['Services',               'design_services',   'resources/services.php',          'Edit the services listed on the site'],
    'testimonials' => ['Testimonials & Reviews', 'rate_review',       'resources/testimonials.php',      'Add and edit client reviews'],
    'faqs'         => ['FAQs Manager',           'quiz',              'resources/faqs.php',              'Add and edit FAQ entries'],
];

// Every sub user gets this, it cannot be removed.
const ADMIN_BASE_PERMISSION = 'blog';

// Page (script basename) => permission required. 'super' = Super Admin only.
const ADMIN_PAGE_PERMISSIONS = [
    'index.php'            => 'dashboard',
    'contact_messages.php' => 'enquiries',
    'services.php'         => 'services',
    'testimonials.php'     => 'testimonials',
    'faqs.php'             => 'faqs',
    'blog_posts.php'       => 'blog',
    'blog_editor.php'      => 'blog',
    'users.php'            => 'super',
];

function admin_session_start(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function admin_db(): ?PDO {
    try {
        return db();
    } catch (Throwable $e) {
        return null;
    }
}

function admin_current(): ?array {
    return $_SESSION['admin'] ?? null;
}

function admin_get_bootstrap_user(): array {
    $envEmail = getenv('ADMIN_EMAIL') ?: 'admin@techbound.in';
    $envPass  = getenv('ADMIN_PASS') ?: 'Admin12345!';
    return [
        'name'          => 'Super Admin',
        'email'         => $envEmail,
        'default_pass'  => $envPass,
        'password_hash' => password_hash($envPass, PASSWORD_DEFAULT),
    ];
}

/** Adds the `permissions` column to admin_users if it is missing (runs once per session). */
function admin_ensure_schema(): void {
    if (!empty($_SESSION['_admin_schema_ok'])) return;
    try {
        $pdo = db();
        $has = $pdo->query("SHOW COLUMNS FROM admin_users LIKE 'permissions'")->fetch();
        if (!$has) {
            $pdo->exec("ALTER TABLE admin_users ADD COLUMN permissions VARCHAR(255) NOT NULL DEFAULT '' AFTER role");
        }
        $_SESSION['_admin_schema_ok'] = true;
    } catch (Throwable $e) {
        // Silently skip if DB is not connected
    }
}

/** "faqs,enquiries" -> ['faqs','enquiries'] (only known keys) */
function admin_parse_permissions(?string $csv): array {
    $out = [];
    foreach (explode(',', (string)$csv) as $p) {
        $p = trim($p);
        if ($p !== '' && isset(ADMIN_PERMISSIONS[$p])) $out[] = $p;
    }
    return array_values(array_unique($out));
}

function admin_build_session(array $u): array {
    return [
        'id'          => (int)$u['id'],
        'name'        => $u['name'],
        'email'       => $u['email'],
        'role'        => $u['role'],
        'permissions' => admin_parse_permissions($u['permissions'] ?? ''),
        'is_fallback' => !empty($u['is_fallback']),
    ];
}

function admin_login(string $email, string $password): bool {
    try { admin_ensure_schema(); } catch (Throwable $e) {}

    $emailClean = strtolower(trim($email));

    // 1. Try database authentication if database is reachable
    try {
        $stmt = db()->prepare('SELECT * FROM admin_users WHERE LOWER(email) = ? AND active = 1');
        $stmt->execute([$emailClean]);
        $u = $stmt->fetch();
        if ($u) {
            if (!password_verify($password, $u['password_hash'])) {
                return false;
            }
            session_regenerate_id(true);
            $_SESSION['admin'] = admin_build_session($u);
            return true;
        }
    } catch (Throwable $e) {
        // Database unreachable or table missing: record error in session for feedback
        $_SESSION['_db_error'] = $e->getMessage();
    }

    // 2. Emergency / Bootstrap fallback credentials (ensures login on Render before DB is attached)
    $bootstrap = admin_get_bootstrap_user();
    if ($emailClean === strtolower($bootstrap['email'])) {
        if ($password === $bootstrap['default_pass'] || password_verify($password, $bootstrap['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin'] = [
                'id'          => 1,
                'name'        => $bootstrap['name'],
                'email'       => $bootstrap['email'],
                'role'        => 'admin',
                'permissions' => [],
                'is_fallback' => true,
            ];
            return true;
        }
    }

    return false;
}

/**
 * Re-reads the logged-in user from the DB on every request so that role / permission
 * changes and deactivation by the Super Admin take effect immediately.
 */
function admin_refresh(): ?array {
    $cur = admin_current();
    if (!$cur) return null;
    if (!empty($cur['is_fallback'])) {
        return $cur; // Keep fallback session alive
    }
    try {
        $stmt = db()->prepare('SELECT * FROM admin_users WHERE id = ? AND active = 1');
        $stmt->execute([(int)$cur['id']]);
        $u = $stmt->fetch();
        if (!$u) {
            admin_logout();
            return null;
        }
        $_SESSION['admin'] = admin_build_session($u);
        return $_SESSION['admin'];
    } catch (Throwable $e) {
        // If DB is temporarily offline, keep user logged in rather than crashing
        return $cur;
    }
}

function admin_logout(): void {
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) session_destroy();
}

function admin_is_super(?array $u = null): bool {
    $u = $u ?? admin_current();
    return ($u['role'] ?? '') === 'admin';
}

/** Can the current user use a section? Super Admin: always. Sub user: blog + granted sections. */
function admin_can(string $perm, ?array $u = null): bool {
    $u = $u ?? admin_current();
    if (!$u) return false;
    if (admin_is_super($u)) return true;
    if ($perm === 'super') return false;
    if ($perm === ADMIN_BASE_PERMISSION) return true;
    return in_array($perm, $u['permissions'] ?? [], true);
}

/** First page this user is allowed to open (used as a landing page / redirect target). */
function admin_home_url(?array $u = null): string {
    if (admin_can('dashboard', $u)) return admin_url('index.php');
    return admin_url('resources/blog_posts.php');
}

/** Stops the request if the current user lacks the permission. */
function admin_require(string $perm): void {
    if (admin_can($perm)) return;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(403);
        exit('Access denied.');
    }
    $msg = urlencode('error:You do not have access to that section. Ask the Super Admin to grant it.');
    header('Location: ' . admin_home_url() . '?flash=' . $msg);
    exit;
}

function admin_require_super(): void {
    admin_require('super');
}

function admin_role_label(string $role): string {
    return $role === 'admin' ? 'Super Admin' : 'Sub User';
}

function admin_url(string $p = ''): string {
    $base = defined('BASE_URL') ? BASE_URL : '/';
    return rtrim($base, '/') . '/admin/' . ltrim($p, '/');
}

function e($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
