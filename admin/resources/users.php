<?php
require __DIR__ . '/../_guard.php';

// Super Admin only. The guard already enforces this; repeated here so the page
// stays locked even if it is ever included from somewhere else.
admin_require_super();

$user = admin_current();
$pdo  = admin_db();

// ---- CSRF token ----------------------------------------------------------
if (empty($_SESSION['_csrf'])) {
    $_SESSION['_csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['_csrf'];

function users_redirect(string $flash): void {
    header('Location: ' . admin_url('resources/users.php?flash=' . urlencode($flash)));
    exit;
}

function active_super_count(PDO $pdo, int $excludeId = 0): int {
    $s = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE role='admin' AND active=1 AND id<>?");
    $s->execute([$excludeId]);
    return (int)$s->fetchColumn();
}

$action = $_POST['_action'] ?? '';
$flash  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($csrf, (string)($_POST['_csrf'] ?? ''))) {
        users_redirect('error:Your session expired. Please try again.');
    }
    if (!$pdo) {
        users_redirect('error:Cannot manage users while database is disconnected. Please configure Render DB environment variables.');
    }

    // ---- Create / update ----
    if ($action === 'save') {
        $id     = (int)($_POST['id'] ?? 0);
        $name   = trim($_POST['name']  ?? '');
        $email  = strtolower(trim($_POST['email'] ?? ''));
        $role   = ($_POST['role'] ?? '') === 'admin' ? 'admin' : 'editor';
        $active = isset($_POST['active']) ? 1 : 0;
        $pw     = (string)($_POST['password'] ?? '');

        // Permissions only apply to sub users; keep only known keys
        $perms = [];
        if ($role === 'editor') {
            foreach ((array)($_POST['permissions'] ?? []) as $p) {
                if (isset(ADMIN_PERMISSIONS[$p])) $perms[] = $p;
            }
        }
        $permCsv = implode(',', array_unique($perms));

        $existing = null;
        if ($id) {
            $s = $pdo->prepare('SELECT * FROM admin_users WHERE id=?');
            $s->execute([$id]);
            $existing = $s->fetch();
            if (!$existing) users_redirect('error:User not found.');
        }

        // Protect yourself and the last Super Admin from lock-out
        if ($id === $user['id']) {
            $role   = 'admin';
            $active = 1;
            $permCsv = '';
        }
        if ($existing && $existing['role'] === 'admin' && $existing['active'] && ($role !== 'admin' || !$active)
            && active_super_count($pdo, $id) === 0) {
            $flash = 'error:At least one active Super Admin is required.';
        }

        $dup = $pdo->prepare('SELECT id FROM admin_users WHERE email=? AND id<>?');
        $dup->execute([$email, $id]);

        if ($flash) {
            // already set
        } elseif ($name === '' || $email === '') {
            $flash = 'error:Name and email are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $flash = 'error:Please enter a valid email address.';
        } elseif ($dup->fetch()) {
            $flash = 'error:Another user already uses that email address.';
        } elseif (!$id && $pw === '') {
            $flash = 'error:Password is required for new users.';
        } elseif ($pw !== '' && strlen($pw) < 8) {
            $flash = 'error:Password must be at least 8 characters.';
        } else {
            if ($id) {
                if ($pw !== '') {
                    $pdo->prepare('UPDATE admin_users SET name=?,email=?,role=?,permissions=?,active=?,password_hash=? WHERE id=?')
                        ->execute([$name, $email, $role, $permCsv, $active, password_hash($pw, PASSWORD_DEFAULT), $id]);
                } else {
                    $pdo->prepare('UPDATE admin_users SET name=?,email=?,role=?,permissions=?,active=? WHERE id=?')
                        ->execute([$name, $email, $role, $permCsv, $active, $id]);
                }
                users_redirect('success:User updated successfully.');
            } else {
                $pdo->prepare('INSERT INTO admin_users (name,email,role,permissions,active,password_hash) VALUES (?,?,?,?,?,?)')
                    ->execute([$name, $email, $role, $permCsv, $active, password_hash($pw, PASSWORD_DEFAULT)]);
                users_redirect('success:' . admin_role_label($role) . ' "' . $name . '" created successfully.');
            }
        }
    }

    // ---- Delete ----
    if ($action === 'delete' && !empty($_POST['id'])) {
        $del_id = (int)$_POST['id'];
        $s = $pdo->prepare('SELECT role, active FROM admin_users WHERE id=?');
        $s->execute([$del_id]);
        $target = $s->fetch();
        if ($del_id === $user['id']) {
            $flash = 'error:You cannot delete your own account.';
        } elseif (!$target) {
            $flash = 'error:User not found.';
        } elseif ($target['role'] === 'admin' && active_super_count($pdo, $del_id) === 0) {
            $flash = 'error:You cannot delete the last Super Admin.';
        } else {
            $pdo->prepare('DELETE FROM admin_users WHERE id=?')->execute([$del_id]);
            users_redirect('success:User deleted.');
        }
    }

    // ---- Activate / deactivate ----
    if ($action === 'toggle' && !empty($_POST['id'])) {
        $tog_id = (int)$_POST['id'];
        $s = $pdo->prepare('SELECT role, active FROM admin_users WHERE id=?');
        $s->execute([$tog_id]);
        $target = $s->fetch();
        if ($tog_id === $user['id'] || !$target) {
            users_redirect('error:You cannot deactivate your own account.');
        }
        if ($target['role'] === 'admin' && $target['active'] && active_super_count($pdo, $tog_id) === 0) {
            users_redirect('error:At least one active Super Admin is required.');
        }
        $pdo->prepare('UPDATE admin_users SET active = 1 - active WHERE id=?')->execute([$tog_id]);
        users_redirect('success:User status updated.');
    }
}

$flash = $flash ?? (string)($_GET['flash'] ?? '');
[$flash_type, $flash_msg] = $flash ? array_pad(explode(':', $flash, 2), 2, '') : ['', ''];

$editing     = null;
$rows        = [];
$total       = 0;
$super_total = 0;
$sub_total   = 0;

if ($pdo) {
    try {
        if (!empty($_GET['edit'])) {
            $s = $pdo->prepare('SELECT id,name,email,role,permissions,active,created_at FROM admin_users WHERE id=?');
            $s->execute([(int)$_GET['edit']]);
            $editing = $s->fetch() ?: null;
            if ($editing) $editing['permissions'] = admin_parse_permissions($editing['permissions']);
        }

        $rows        = $pdo->query('SELECT id,name,email,role,permissions,active,created_at FROM admin_users ORDER BY role ASC, id ASC')->fetchAll();
        $total       = count($rows);
        $super_total = count(array_filter($rows, fn($r) => $r['role'] === 'admin'));
        $sub_total   = $total - $super_total;
    } catch (Throwable $e) {}
} else {
    // Show current authenticated session user in offline mode
    $rows = [[
        'id'          => 1,
        'name'        => $user['name'] ?? 'Super Admin',
        'email'       => $user['email'] ?? 'admin@techbound.in',
        'role'        => 'admin',
        'permissions' => [],
        'active'      => 1,
        'created_at'  => date('Y-m-d H:i:s'),
    ]];
    $total       = 1;
    $super_total = 1;
    $sub_total   = 0;
}

$page_title = 'Users & Permissions';
require __DIR__ . '/../_header.php';
?>

<div class="flex flex-col w-full">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Users &amp; Permissions</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Users &amp; Permissions</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Create sub users for blogging and choose which other sections they can access</p>
        </div>
        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <div class="flex items-center gap-space-xs px-3 py-1.5 rounded-lg bg-surface-container font-label-md text-label-md text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary">shield_person</span>
                <?= $super_total ?> super admin<?= $super_total !== 1 ? 's' : '' ?>
            </div>
            <div class="flex items-center gap-space-xs px-3 py-1.5 rounded-lg bg-surface-container font-label-md text-label-md text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-tertiary">edit_note</span>
                <?= $sub_total ?> sub user<?= $sub_total !== 1 ? 's' : '' ?>
            </div>
            <button onclick="openUserForm()" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">person_add</span> Add Sub User
            </button>
        </div>
    </div>

    <?php if ($flash_msg): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $flash_type === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span> <?= e($flash_msg) ?>
    </div>
    <?php endif; ?>

    <!-- Role Explainer -->
    <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest shadow-sm grid grid-cols-1 md:grid-cols-2 gap-space-md">
        <div class="flex items-start gap-space-xs">
            <span class="p-1.5 rounded-lg bg-primary-container text-on-primary shrink-0">
                <span class="material-symbols-outlined text-[18px]">shield_person</span>
            </span>
            <div>
                <p class="font-label-lg text-label-lg text-on-surface font-semibold">Super Admin</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Full access to every section. The only role that can create, edit, deactivate and delete users and grant access.</p>
            </div>
        </div>
        <div class="flex items-start gap-space-xs">
            <span class="p-1.5 rounded-lg bg-tertiary-container text-on-tertiary shrink-0">
                <span class="material-symbols-outlined text-[18px]">edit_note</span>
            </span>
            <div>
                <p class="font-label-lg text-label-lg text-on-surface font-semibold">Sub User</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Can post and manage Blog Posts. Other sections (Enquiries, FAQs, etc.) only if you grant them. Can never manage users.</p>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                    <tr class="bg-surface-container-low text-outline font-label-sm text-label-sm uppercase tracking-wider">
                        <th class="py-3 px-space-md" scope="col">User</th>
                        <th class="py-3 px-space-md" scope="col">Role</th>
                        <th class="py-3 px-space-md" scope="col">Access</th>
                        <th class="py-3 px-space-md" scope="col">Status</th>
                        <th class="py-3 px-space-md" scope="col">Joined</th>
                        <th class="py-3 px-space-md text-right" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/30">
                    <?php foreach ($rows as $row):
                        $initials = strtoupper(substr($row['name'], 0, 1) . (strpos($row['name'], ' ') !== false ? substr($row['name'], strpos($row['name'], ' ') + 1, 1) : ''));
                        $is_me    = (int)$row['id'] === $user['id'];
                        $is_super = $row['role'] === 'admin';
                        $rperms   = admin_parse_permissions($row['permissions']);
                    ?>
                    <tr class="hover:bg-surface-container-low/70 transition-colors <?= !$row['active'] ? 'opacity-60' : '' ?>">
                        <td class="py-3.5 px-space-md">
                            <div class="flex items-center gap-space-xs">
                                <div class="w-9 h-9 rounded-full <?= $is_super ? 'bg-primary-container text-on-primary' : 'bg-tertiary-container text-on-tertiary' ?> font-label-md text-label-md flex items-center justify-center shrink-0 font-bold"><?= e($initials) ?></div>
                                <div class="flex flex-col min-w-0">
                                    <span class="font-label-lg text-label-lg text-on-surface font-semibold truncate">
                                        <?= e($row['name']) ?>
                                        <?php if ($is_me): ?><span class="ml-1 px-1.5 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm text-primary">You</span><?php endif; ?>
                                    </span>
                                    <span class="text-on-surface-variant font-body-sm text-body-sm truncate"><?= e($row['email']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-space-md">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md font-label-sm text-label-sm font-semibold whitespace-nowrap
                                <?= $is_super ? 'bg-primary-container text-on-primary' : 'bg-tertiary-container text-on-tertiary' ?>">
                                <span class="material-symbols-outlined text-[14px]"><?= $is_super ? 'shield_person' : 'edit_note' ?></span>
                                <?= admin_role_label($row['role']) ?>
                            </span>
                        </td>
                        <td class="py-3.5 px-space-md">
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                <?php if ($is_super): ?>
                                    <span class="px-2 py-0.5 rounded bg-primary/10 text-primary font-label-sm text-label-sm">All sections</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm">Blog Posts</span>
                                    <?php foreach ($rperms as $p): ?>
                                        <span class="px-2 py-0.5 rounded bg-tertiary/10 text-tertiary font-label-sm text-label-sm"><?= e(ADMIN_PERMISSIONS[$p][0]) ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="py-3.5 px-space-md">
                            <?php if (!$is_me): ?>
                            <form method="post" class="inline">
                                <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
                                <input type="hidden" name="_action" value="toggle">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold transition-colors
                                    <?= $row['active'] ? 'bg-surface-container-high text-primary hover:bg-primary hover:text-on-primary' : 'bg-error-container text-on-error-container hover:bg-error hover:text-on-error' ?>" title="Click to <?= $row['active'] ? 'deactivate' : 'activate' ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $row['active'] ? 'bg-primary' : 'bg-error' ?>"></span>
                                    <?= $row['active'] ? 'Active' : 'Inactive' ?>
                                </button>
                            </form>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Active
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-space-md text-on-surface whitespace-nowrap font-label-md text-label-md"><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
                        <td class="py-3.5 px-space-md text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="?edit=<?= (int)$row['id'] ?>" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Edit user &amp; access">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <?php if (!$is_me): ?>
                                <form method="post" onsubmit="return confirm('Delete user <?= e(addslashes($row['name'])) ?>? This cannot be undone.')" class="inline">
                                    <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
                                    <input type="hidden" name="_action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- User Form Drawer -->
<div id="userDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-on-surface/40 backdrop-blur-sm" onclick="closeUserForm()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-surface-container-lowest shadow-2xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/30 shrink-0">
            <h2 id="userDrawerTitle" class="font-headline-sm text-headline-sm text-on-surface">Add Sub User</h2>
            <button onclick="closeUserForm()" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form method="post" id="userForm" class="flex flex-col flex-1 overflow-y-auto">
            <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
            <input type="hidden" name="_action" value="save">
            <input type="hidden" name="id" id="uf-id" value="">
            <div class="p-space-lg space-y-space-md flex-1">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="uf-name">Full Name <span class="text-error">*</span></label>
                    <input type="text" id="uf-name" name="name" required class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="e.g. Ravi Sharma">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="uf-email">Email Address <span class="text-error">*</span></label>
                    <input type="email" id="uf-email" name="email" required class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="ravi@techbound.in">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="uf-pw">Password <span id="uf-pw-hint" class="font-label-sm text-label-sm text-outline">(required, min 8 characters)</span></label>
                    <input type="password" id="uf-pw" name="password" minlength="8" autocomplete="new-password" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="••••••••">
                </div>

                <div id="uf-role-block">
                    <label class="block font-label-md text-label-md text-on-surface mb-2">Role</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                        <label class="flex items-center gap-2 p-3 rounded-lg bg-surface-container-low border-2 border-transparent has-[:checked]:border-primary cursor-pointer transition-colors">
                            <input type="radio" name="role" value="editor" id="uf-editor" class="sr-only" checked>
                            <span class="p-1.5 rounded bg-tertiary-container text-on-tertiary">
                                <span class="material-symbols-outlined text-[18px]">edit_note</span>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-label-lg text-label-lg text-on-surface">Sub User</span>
                                <span class="font-label-sm text-label-sm text-outline">Blogs + granted sections</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-lg bg-surface-container-low border-2 border-transparent has-[:checked]:border-primary cursor-pointer transition-colors">
                            <input type="radio" name="role" value="admin" id="uf-admin" class="sr-only">
                            <span class="p-1.5 rounded bg-primary-container text-on-primary">
                                <span class="material-symbols-outlined text-[18px]">shield_person</span>
                            </span>
                            <div class="flex flex-col">
                                <span class="font-label-lg text-label-lg text-on-surface">Super Admin</span>
                                <span class="font-label-sm text-label-sm text-outline">Full access + users</span>
                            </div>
                        </label>
                    </div>
                </div>
                <p id="uf-self-note" class="hidden font-body-sm text-body-sm text-on-surface-variant bg-surface-container-low rounded-lg p-3">This is your own account. You cannot change your own role or deactivate yourself.</p>

                <!-- Permissions (sub users only) -->
                <div id="uf-perms-block">
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Section Access</label>
                    <p class="font-body-sm text-body-sm text-outline mb-2">Blog Posts is always included. Tick any extra sections this sub user may manage.</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-surface-container-low opacity-80">
                            <span class="material-symbols-outlined text-[20px] text-primary">article</span>
                            <div class="flex-1 min-w-0">
                                <p class="font-label-lg text-label-lg text-on-surface">Blog Posts</p>
                                <p class="font-body-sm text-body-sm text-outline">Create, edit and publish articles</p>
                            </div>
                            <span class="material-symbols-outlined text-[20px] text-primary" title="Always included">lock</span>
                        </div>
                        <?php foreach (ADMIN_PERMISSIONS as $key => [$label, $icon, , $desc]): ?>
                        <label class="flex items-center gap-3 p-3 rounded-lg bg-surface-container-low border-2 border-transparent has-[:checked]:border-tertiary cursor-pointer transition-colors">
                            <span class="material-symbols-outlined text-[20px] text-on-surface-variant"><?= e($icon) ?></span>
                            <div class="flex-1 min-w-0">
                                <p class="font-label-lg text-label-lg text-on-surface"><?= e($label) ?></p>
                                <p class="font-body-sm text-body-sm text-outline"><?= e($desc) ?></p>
                            </div>
                            <input type="checkbox" name="permissions[]" value="<?= e($key) ?>" class="uf-perm w-5 h-5 accent-[#2c2abc] shrink-0">
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <label id="uf-active-block" class="flex items-center gap-space-sm cursor-pointer select-none">
                    <div class="relative">
                        <input type="checkbox" id="uf-active" name="active" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-surface-container-high rounded-full peer-checked:bg-primary transition-colors"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="font-label-lg text-label-lg text-on-surface">Account Active</span>
                </label>
            </div>
            <div class="px-space-lg py-space-md border-t border-outline-variant/30 flex justify-end gap-space-sm shrink-0">
                <button type="button" onclick="closeUserForm()" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">Cancel</button>
                <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Save User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const editingUser = <?= $editing ? json_encode($editing) : 'null' ?>;
const currentUserId = <?= (int)$user['id'] ?>;

function syncPermsVisibility() {
    const isSuper = document.getElementById('uf-admin').checked;
    document.getElementById('uf-perms-block').classList.toggle('hidden', isSuper);
}
document.querySelectorAll('input[name="role"]').forEach(r => r.addEventListener('change', syncPermsVisibility));

function openUserForm(data) {
    const drawer = document.getElementById('userDrawer');
    const form   = document.getElementById('userForm');
    form.reset();
    document.querySelectorAll('.uf-perm').forEach(cb => cb.checked = false);

    const isSelf = !!(data && Number(data.id) === currentUserId);
    document.getElementById('uf-role-block').classList.toggle('hidden', isSelf);
    document.getElementById('uf-active-block').classList.toggle('hidden', isSelf);
    document.getElementById('uf-self-note').classList.toggle('hidden', !isSelf);

    if (data) {
        document.getElementById('userDrawerTitle').textContent = 'Edit User & Access';
        document.getElementById('uf-id').value     = data.id;
        document.getElementById('uf-name').value   = data.name  || '';
        document.getElementById('uf-email').value  = data.email || '';
        document.getElementById('uf-pw').value     = '';
        document.getElementById('uf-pw-hint').textContent = '(leave blank to keep current)';
        document.getElementById('uf-active').checked = data.active == 1;
        document.getElementById(data.role === 'admin' ? 'uf-admin' : 'uf-editor').checked = true;
        (data.permissions || []).forEach(p => {
            const cb = document.querySelector('.uf-perm[value="' + p + '"]');
            if (cb) cb.checked = true;
        });
    } else {
        document.getElementById('userDrawerTitle').textContent = 'Add Sub User';
        document.getElementById('uf-id').value = '';
        document.getElementById('uf-pw-hint').textContent = '(required, min 8 characters)';
        document.getElementById('uf-editor').checked = true;
    }
    syncPermsVisibility();
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
}
function closeUserForm() {
    document.getElementById('userDrawer').classList.add('hidden');
    document.getElementById('userDrawer').classList.remove('flex');
    history.replaceState(null, '', '?');
}
if (editingUser) openUserForm(editingUser);
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
