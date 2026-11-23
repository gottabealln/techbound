<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();

$flash   = '';
$action  = $_POST['_action'] ?? '';

function sync_blogs_to_json(PDO $pdo): void {
    try {
        $all = $pdo->query('SELECT * FROM blog_posts ORDER BY published_at DESC, id DESC')->fetchAll();
        $jsonPath = __DIR__ . '/../../techbound_blogs.json';
        file_put_contents($jsonPath, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $indexPath = __DIR__ . '/../../data/blogs_index.php';
        if (is_dir(dirname($indexPath))) {
            $light = array_map(function($p) { unset($p['body']); return $p; }, $all);
            file_put_contents($indexPath, "<?php\nreturn " . var_export($light, true) . ";\n");
        }
        $fullPath = __DIR__ . '/../../data/blogs_full.php';
        if (is_dir(dirname($fullPath))) {
            file_put_contents($fullPath, "<?php\nreturn " . var_export($all, true) . ";\n");
        }
    } catch (Throwable $e) {}
}

// ── Handle POST actions ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . admin_url('resources/blog_posts.php?flash=' . urlencode('error:Cannot modify blog posts while database is offline. Please configure database in Render.')));
        exit;
    }

    if ($action === 'delete' && !empty($_POST['id'])) {
        $pdo->prepare('DELETE FROM blog_posts WHERE id=?')->execute([(int)$_POST['id']]);
        sync_blogs_to_json($pdo);
        header('Location: ' . admin_url('resources/blog_posts.php?flash=' . urlencode('success:Post deleted.')));
        exit;
    }

    if ($action === 'toggle' && !empty($_POST['id'])) {
        $pdo->prepare('UPDATE blog_posts SET active = 1 - active WHERE id=?')->execute([(int)$_POST['id']]);
        sync_blogs_to_json($pdo);
        header('Location: ' . admin_url('resources/blog_posts.php'));
        exit;
    }
}

$flash = $flash ?: urldecode($_GET['flash'] ?? '');

// ── Form edit mode (redirects to the dedicated full-page blog editor) ────────
if (!empty($_GET['edit'])) {
    header('Location: ' . admin_url('resources/blog_editor.php?id=' . (int)$_GET['edit']));
    exit;
}

// ── List ─────────────────────────────────────────────────────────────────────
$search = trim($_GET['q'] ?? '');
$page   = max(1, (int)($_GET['p'] ?? 1));
$per    = 12;
$offset = ($page - 1) * $per;

if ($pdo) {
    $where  = $search !== '' ? 'WHERE title LIKE ? OR excerpt LIKE ?' : '';
    $params = $search !== '' ? ["%$search%", "%$search%"] : [];

    $stmtC = $pdo->prepare("SELECT COUNT(*) FROM blog_posts $where");
    $stmtC->execute($params);
    $total = (int)$stmtC->fetchColumn();

    $stmtR = $pdo->prepare("SELECT * FROM blog_posts $where ORDER BY published_at DESC, id DESC LIMIT $per OFFSET $offset");
    $stmtR->execute($params);
    $rows  = $stmtR->fetchAll();
} else {
    // Fallback: Read from precompiled index
    $all = [];
    $indexPath = __DIR__ . '/../../data/blogs_index.php';
    if (is_file($indexPath)) {
        $all = require $indexPath;
    } elseif (is_file(__DIR__ . '/../../techbound_blogs.json')) {
        $all = json_decode(file_get_contents(__DIR__ . '/../../techbound_blogs.json'), true) ?: [];
    }
    if ($search !== '') {
        $q = strtolower($search);
        $all = array_values(array_filter($all, function($p) use ($q) {
            $hay = strtolower(($p['title'] ?? '') . ' ' . ($p['excerpt'] ?? '') . ' ' . ($p['category'] ?? ''));
            return str_contains($hay, $q);
        }));
    }
    $total = count($all);
    $rows  = array_slice($all, $offset, $per);
}

$total_pages = max(1, ceil($total / $per));

[$flash_type, $flash_msg] = $flash ? explode(':', $flash, 2) : ['', ''];

$page_title = 'Blog Posts';
require __DIR__ . '/../_header.php';
?>

<div class="flex flex-col w-full">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Blog Posts</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Blog Posts</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Create and manage articles published on the TechBound website</p>
        </div>
        <a href="<?= e(admin_url('resources/blog_editor.php')) ?>" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center gap-2 self-start lg:self-auto font-bold">
            <span class="material-symbols-outlined text-[18px]">post_add</span> Create New Article
        </a>
    </div>

    <!-- Flash -->
    <?php if (!$pdo): ?>
    <div class="mb-space-md p-3.5 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-200 font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px] text-amber-400">cloud_off</span>
        <span>Standalone Mode: Viewing <?= $total ?> posts from precompiled index. Connect MySQL in Render to edit live articles.</span>
    </div>
    <?php endif; ?>

    <?php if ($flash_msg): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $flash_type === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span> <?= e($flash_msg) ?>
    </div>
    <?php endif; ?>

    <!-- Search + Filter -->
    <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-space-sm">
        <form method="get" class="flex flex-1 items-center gap-space-sm">
            <div class="relative flex-1 max-w-md">
                <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search posts by title or excerpt..." class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface placeholder:text-outline transition-colors">
            </div>
            <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all shrink-0">Search</button>
            <?php if ($search): ?><a href="?" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface-variant font-label-lg text-label-lg hover:bg-surface-container-high transition-colors flex items-center shrink-0">Clear</a><?php endif; ?>
        </form>
        <span class="font-label-md text-label-md text-on-surface-variant shrink-0"><?= $total ?> post<?= $total !== 1 ? 's' : '' ?></span>
    </div>

    <!-- Posts Table -->
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-outline font-label-sm text-label-sm uppercase tracking-wider">
                        <th class="py-3 px-space-md" scope="col">Title &amp; Excerpt</th>
                        <th class="py-3 px-space-md" scope="col">Slug</th>
                        <th class="py-3 px-space-md" scope="col">Published</th>
                        <th class="py-3 px-space-md" scope="col">Status</th>
                        <th class="py-3 px-space-md text-right" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/30">
                    <?php if (empty($rows)): ?>
                        <tr><td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] text-outline">article</span>
                                <span class="font-body-md text-body-md"><?= $search ? 'No posts match your search.' : 'No blog posts yet. Create your first one!' ?></span>
                                <?php if (!$search): ?><a href="<?= e(admin_url('resources/blog_editor.php')) ?>" class="mt-1 h-9 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg inline-flex items-center gap-1.5 font-bold">Create Post</a><?php endif; ?>
                            </div>
                        </td></tr>
                    <?php else: foreach ($rows as $row): ?>
                        <tr class="hover:bg-surface-container-low/70 transition-colors group">
                            <td class="py-3.5 px-space-md max-w-sm">
                                <p class="font-label-lg text-label-lg text-on-surface font-semibold truncate"><?= e($row['title']) ?></p>
                                <div class="flex flex-wrap items-center gap-2 mt-0.5 mb-0.5">
                                    <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold bg-primary/10 text-primary"><?= e($row['category'] ?? 'Digital Marketing') ?></span>
                                    <span class="text-[11px] text-outline font-medium">By <?= e($row['author'] ?? 'TechBound') ?><?= !empty($row['author_designation']) ? ' · ' . e($row['author_designation']) : '' ?></span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5 truncate"><?= e(mb_substr($row['excerpt'], 0, 85)) ?><?= mb_strlen($row['excerpt']) > 85 ? '…' : '' ?></p>
                            </td>
                            <td class="py-3.5 px-space-md">
                                <span class="font-label-sm text-label-sm text-outline bg-surface-container px-2 py-0.5 rounded"><?= e($row['slug']) ?></span>
                            </td>
                            <td class="py-3.5 px-space-md text-on-surface whitespace-nowrap font-label-md text-label-md">
                                <?= $row['published_at'] ? date('M j, Y', strtotime($row['published_at'])) : '<span class="text-outline">Draft</span>' ?>
                            </td>
                            <td class="py-3.5 px-space-md">
                                <form method="post" class="inline">
                                    <input type="hidden" name="_action" value="toggle">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold transition-colors
                                        <?= $row['active'] ? 'bg-surface-container-high text-primary hover:bg-primary hover:text-on-primary' : 'bg-error-container text-on-error-container hover:bg-error hover:text-on-error' ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $row['active'] ? 'bg-primary' : 'bg-error' ?>"></span>
                                        <?= $row['active'] ? 'Published' : 'Draft' ?>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-space-md text-right">
                                <div class="inline-flex items-center gap-1">
                                    <a href="<?= e(admin_url('resources/blog_editor.php?id=' . (int)$row['id'])) ?>" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Edit in Full Editor">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form method="post" onsubmit="return confirm('Delete this post permanently?')" class="inline">
                                        <input type="hidden" name="_action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                        <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($total_pages > 1): ?>
        <div class="px-space-md py-3 border-t border-outline-variant/30 flex items-center justify-between">
            <span class="font-body-sm text-body-sm text-on-surface-variant">Showing <?= $offset+1 ?>–<?= min($offset+$per,$total) ?> of <?= $total ?></span>
            <div class="inline-flex items-center gap-1">
                <?php for ($pg = 1; $pg <= $total_pages; $pg++): ?>
                    <a href="?p=<?= $pg ?><?= $search ? '&q='.urlencode($search) : '' ?>" class="w-8 h-8 rounded-lg flex items-center justify-center font-label-md text-label-md transition-colors <?= $pg===$page ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container-high' ?>"><?= $pg ?></a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../_footer.php'; ?>
