<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();

// Canonical registry of all pages that support a dynamic FAQ section
$faq_pages = [
    'home'                => ['label' => 'Home Page',                'url' => '/'],
    'about'               => ['label' => 'About Us',                 'url' => '/about-us/'],
    'services'            => ['label' => 'Our Services',             'url' => '/our-services/'],
    'seo'                 => ['label' => 'SEO Services',             'url' => '/our-services/seo-company-in-kerala/'],
    'ai-seo'              => ['label' => 'AI SEO, AEO & GEO',        'url' => '/our-services/ai-seo-services-in-kerala/'],
    'smm'                 => ['label' => 'Social Media Marketing',   'url' => '/our-services/social-media-management-company-in-kerala/'],
    'online-advertising'  => ['label' => 'Online Advertising & PPC', 'url' => '/our-services/online-advertising-agency-in-kerala/'],
    'website-development' => ['label' => 'Website Development',      'url' => '/our-services/website-development-company-in-kerala/'],
    'lead-generation'     => ['label' => 'Lead Generation',          'url' => '/our-services/best-lead-generation-company-in-kerala/'],
    'construction'        => ['label' => 'Real Estate Marketing',    'url' => '/real-estate-marketing-agency-kerala/'],
    'kochi'               => ['label' => 'Digital Marketing Kochi',  'url' => '/digital-marketing-agency-in-kochi/'],
    'trivandrum-guide'    => ['label' => 'Trivandrum Guide',         'url' => '/digital-marketing-trivandrum-guide/'],
    'seo-course'          => ['label' => 'AI 360 SEO Course',        'url' => '/seo-course-in-kerala/'],
    'portfolio'           => ['label' => 'Portfolio',                'url' => '/portfolio/'],
    'careers'             => ['label' => 'Careers',                  'url' => '/careers/'],
    'blog'                => ['label' => 'Blog',                     'url' => '/blog/'],
    'contact'             => ['label' => 'Contact Us',               'url' => '/contact/'],
];

function sync_faqs_cache(PDO $pdo): void {
    try {
        $all = $pdo->query("SELECT id, page, question, answer, sort_order, active FROM faqs ORDER BY page ASC, sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $cachePath = __DIR__ . '/../../data/faqs_cache.php';
        if (!is_dir(dirname($cachePath))) {
            @mkdir(dirname($cachePath), 0775, true);
        }
        file_put_contents($cachePath, "<?php\nreturn " . var_export($all, true) . ";\n");
    } catch (Throwable $e) {
        // Ignore on read-only FS
    }
}

$filter_page = trim($_GET['page'] ?? $_POST['return_page'] ?? '');
if ($filter_page !== '' && !isset($faq_pages[$filter_page])) {
    $filter_page = '';
}

$redirect_base = admin_url('resources/faqs.php') . ($filter_page !== '' ? ('?page=' . urlencode($filter_page)) : '');
$sep = $filter_page !== '' ? '&' : '?';

$action = $_POST['_action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . $redirect_base . $sep . 'flash=' . urlencode('error:Cannot modify FAQs while database is disconnected.'));
        exit;
    }

    if ($action === 'save') {
        $id         = (int)($_POST['id'] ?? 0);
        $page_key   = trim($_POST['page'] ?? 'home');
        if (!isset($faq_pages[$page_key])) $page_key = 'home';
        $question   = trim($_POST['question']   ?? '');
        $answer     = trim($_POST['answer']     ?? '');
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $active     = isset($_POST['active']) ? 1 : 0;

        if ($question === '' || $answer === '') {
            $flash = 'error:Question and Answer are required.';
        } else {
            if ($id) {
                $pdo->prepare('UPDATE faqs SET page=?, question=?, answer=?, sort_order=?, active=? WHERE id=?')
                    ->execute([$page_key, $question, $answer, $sort_order, $active, $id]);
                $flash = 'success:FAQ updated for ' . $faq_pages[$page_key]['label'] . '.';
            } else {
                $pdo->prepare('INSERT INTO faqs (page, question, answer, sort_order, active) VALUES (?,?,?,?,?)')
                    ->execute([$page_key, $question, $answer, $sort_order, $active]);
                $flash = 'success:FAQ added to ' . $faq_pages[$page_key]['label'] . '.';
            }
            sync_faqs_cache($pdo);
            header('Location: ' . $redirect_base . $sep . 'flash=' . urlencode($flash));
            exit;
        }
    }

    if ($action === 'delete' && !empty($_POST['id'])) {
        $pdo->prepare('DELETE FROM faqs WHERE id=?')->execute([(int)$_POST['id']]);
        sync_faqs_cache($pdo);
        header('Location: ' . $redirect_base . $sep . 'flash=' . urlencode('success:FAQ deleted.'));
        exit;
    }

    if ($action === 'delete_page_all' && !empty($_POST['page_key'])) {
        $pk = trim($_POST['page_key']);
        if (isset($faq_pages[$pk])) {
            $pdo->prepare('DELETE FROM faqs WHERE page=?')->execute([$pk]);
            sync_faqs_cache($pdo);
            header('Location: ' . $redirect_base . $sep . 'flash=' . urlencode('success:All FAQs removed from ' . $faq_pages[$pk]['label'] . '. The FAQ section is now hidden on that page.'));
            exit;
        }
    }

    if ($action === 'toggle' && !empty($_POST['id'])) {
        $pdo->prepare('UPDATE faqs SET active = 1 - active WHERE id=?')->execute([(int)$_POST['id']]);
        sync_faqs_cache($pdo);
        header('Location: ' . $redirect_base);
        exit;
    }
}

$flash = $flash ?? urldecode($_GET['flash'] ?? '');
[$flash_type, $flash_msg] = ($flash && strpos($flash, ':') !== false) ? explode(':', $flash, 2) : ['', ''];

$editing      = null;
$all_rows     = [];
$rows         = [];
$page_counts  = [];
$total        = 0;
$active_count = 0;
$search       = trim($_GET['q'] ?? '');

foreach ($faq_pages as $pk => $_meta) {
    $page_counts[$pk] = ['total' => 0, 'active' => 0];
}

if ($pdo) {
    try {
        if (!empty($_GET['edit'])) {
            $s = $pdo->prepare('SELECT * FROM faqs WHERE id=?');
            $s->execute([(int)$_GET['edit']]);
            $editing = $s->fetch();
        }

        // Counts per page (unfiltered)
        foreach ($pdo->query('SELECT page, COUNT(*) AS cnt, SUM(active = 1) AS act FROM faqs GROUP BY page')->fetchAll(PDO::FETCH_ASSOC) as $c) {
            $pk = $c['page'] ?: 'home';
            if (!isset($page_counts[$pk])) {
                $page_counts[$pk] = ['total' => 0, 'active' => 0];
            }
            $page_counts[$pk]['total']  = (int)$c['cnt'];
            $page_counts[$pk]['active'] = (int)$c['act'];
        }

        $conds  = [];
        $params = [];
        if ($filter_page !== '') {
            $conds[]  = 'page = ?';
            $params[] = $filter_page;
        }
        if ($search !== '') {
            $conds[]  = '(question LIKE ? OR answer LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        $where = $conds ? ('WHERE ' . implode(' AND ', $conds)) : '';

        $stmtR = $pdo->prepare("SELECT * FROM faqs $where ORDER BY page ASC, sort_order ASC, id ASC");
        $stmtR->execute($params);
        $rows = $stmtR->fetchAll(PDO::FETCH_ASSOC);

        $total        = count($rows);
        $active_count = count(array_filter($rows, fn($r) => (int)$r['active'] === 1));
    } catch (Throwable $e) {}
}

// Group rows by page for categorized display
$grouped_rows = [];
if ($filter_page !== '') {
    $grouped_rows[$filter_page] = $rows;
} else {
    foreach ($faq_pages as $pk => $_meta) {
        $grouped_rows[$pk] = [];
    }
    foreach ($rows as $r) {
        $pk = $r['page'] ?: 'home';
        if (!isset($grouped_rows[$pk])) $grouped_rows[$pk] = [];
        $grouped_rows[$pk][] = $r;
    }
    // If searching, omit empty groups so search results stay clean
    if ($search !== '') {
        $grouped_rows = array_filter($grouped_rows, fn($list) => !empty($list));
    }
}

$page_title = 'FAQs Manager';
require __DIR__ . '/../_header.php';
?>

<div class="max-w-7xl mx-auto flex flex-col gap-5">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2 mb-1">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">FAQs Manager</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">FAQs by Page</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Add, edit, or remove FAQs for any specific page. If a page has 0 active FAQs, its FAQ section is automatically hidden on the live site.</p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-outline-variant text-xs font-medium text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary">quiz</span>
                <span><?= $active_count ?> active</span>
                <span class="text-outline">/ <?= $total ?> shown</span>
            </div>
            <button type="button" data-page="<?= e($filter_page ?: 'home') ?>" onclick="openFaqForm(null, this.dataset.page)" class="h-10 px-4 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-95 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span><?= $filter_page ? ('Add FAQ to ' . e($faq_pages[$filter_page]['label'])) : 'Add FAQ' ?></span>
            </button>
        </div>
    </div>

    <?php if ($flash_msg): ?>
    <div class="px-4 py-3 rounded-lg border text-sm flex items-center gap-2 <?= $flash_type === 'success' ? 'bg-green-50 border-green-200 text-green-900' : 'bg-red-50 border-red-200 text-red-900' ?>">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span>
        <span><?= e($flash_msg) ?></span>
    </div>
    <?php endif; ?>

    <!-- Page Category Filter Pills -->
    <div class="p-4 rounded-xl bg-white border border-outline-variant">
        <div class="flex items-center justify-between gap-3 mb-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-outline">Filter by Page</span>
            <form method="get" class="flex items-center gap-2">
                <?php if ($filter_page !== ''): ?>
                    <input type="hidden" name="page" value="<?= e($filter_page) ?>">
                <?php endif; ?>
                <div class="relative">
                    <span class="material-symbols-outlined text-[16px] text-outline absolute left-2.5 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                    <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search FAQs..." class="h-8 pl-8 pr-3 w-52 rounded-md bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary text-xs text-on-surface">
                </div>
                <button type="submit" class="h-8 px-3 rounded-md bg-primary text-white text-xs font-medium hover:opacity-90">Search</button>
                <?php if ($search !== ''): ?>
                    <a href="<?= e($filter_page !== '' ? ('?page=' . urlencode($filter_page)) : '?') ?>" class="h-8 px-2.5 rounded-md bg-surface-container-low text-xs text-on-surface-variant flex items-center hover:bg-surface-container-high">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="flex flex-wrap gap-2">
            <?php
            $grand_total = array_sum(array_column($page_counts, 'total'));
            $is_all = ($filter_page === '');
            ?>
            <a href="<?= $search !== '' ? ('?q=' . urlencode($search)) : '?' ?>"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border transition-colors <?= $is_all ? 'bg-primary text-white border-primary' : 'bg-surface-container-low text-on-surface border-outline-variant hover:border-primary' ?>">
                <span>All Pages</span>
                <span class="px-1.5 py-0.2 rounded-full text-[11px] <?= $is_all ? 'bg-white/20 text-white' : 'bg-white text-outline' ?>"><?= $grand_total ?></span>
            </a>
            <?php foreach ($faq_pages as $pk => $meta):
                $cnt    = $page_counts[$pk]['total'] ?? 0;
                $act    = $page_counts[$pk]['active'] ?? 0;
                $active = ($filter_page === $pk);
                $href   = '?page=' . urlencode($pk) . ($search !== '' ? ('&q=' . urlencode($search)) : '');
            ?>
            <a href="<?= e($href) ?>"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border transition-colors <?= $active ? 'bg-primary text-white border-primary' : ($act === 0 ? 'bg-gray-50 text-outline border-dashed border-outline-variant hover:border-primary hover:text-on-surface' : 'bg-white text-on-surface border-outline-variant hover:border-primary') ?>">
                <span><?= e($meta['label']) ?></span>
                <span class="px-1.5 py-0.2 rounded-full text-[11px] <?= $active ? 'bg-white/20 text-white' : ($act === 0 ? 'bg-gray-200/80 text-gray-500' : 'bg-green-50 text-green-800') ?>"><?= $act ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Categorized FAQ Groups by Page -->
    <?php if (empty($grouped_rows)): ?>
    <div class="rounded-xl bg-white border border-outline-variant py-14 flex flex-col items-center gap-3 text-on-surface-variant">
        <span class="material-symbols-outlined text-[42px] text-outline">quiz</span>
        <span class="text-sm">No FAQs match your search.</span>
    </div>
    <?php else: ?>
    <div class="flex flex-col gap-5">
        <?php foreach ($grouped_rows as $pk => $page_faqs):
            $meta       = $faq_pages[$pk] ?? ['label' => ucfirst($pk), 'url' => '/'];
            $live_url   = $meta['url'] === '/' ? BASE_URL : (rtrim(BASE_URL, '/') . $meta['url']);
            $page_act   = count(array_filter($page_faqs, fn($r) => (int)$r['active'] === 1));
            $page_tot   = count($page_faqs);
        ?>
        <section class="rounded-xl bg-white border border-outline-variant overflow-hidden">
            <!-- Group Header -->
            <div class="px-5 py-3.5 bg-surface-container-low border-b border-outline-variant flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface"><?= e($meta['label']) ?></h2>
                    <a href="<?= e($live_url) ?>" target="_blank" class="text-xs font-mono text-primary hover:underline"><?= e($meta['url']) ?></a>
                    <?php if ($page_act === 0): ?>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-800 border border-amber-200">FAQ Section Hidden (0 active)</span>
                    <?php else: ?>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-medium bg-green-50 text-green-800 border border-green-200"><?= $page_act ?> active<?= $page_tot > $page_act ? (" / $page_tot total") : '' ?></span>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-2">
                    <?php if ($page_tot > 0): ?>
                    <form method="post" onsubmit="return confirm('Remove ALL FAQs from <?= e($meta['label']) ?>? This will hide the FAQ section on this page.')" class="inline">
                        <input type="hidden" name="_action" value="delete_page_all">
                        <input type="hidden" name="page_key" value="<?= e($pk) ?>">
                        <input type="hidden" name="return_page" value="<?= e($filter_page) ?>">
                        <button type="submit" class="h-8 px-2.5 rounded-md border border-outline-variant bg-white text-xs text-outline hover:text-error hover:border-red-200 transition-colors">
                            Remove All
                        </button>
                    </form>
                    <?php endif; ?>
                    <button type="button" data-page="<?= e($pk) ?>" onclick="openFaqForm(null, this.dataset.page)" class="h-8 px-3 rounded-md bg-primary text-white text-xs font-medium hover:opacity-90 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px]">add</span>
                        <span>Add FAQ</span>
                    </button>
                </div>
            </div>

            <?php if (empty($page_faqs)): ?>
            <div class="px-5 py-6 text-xs text-outline flex items-center justify-between">
                <span>No FAQs configured for <strong><?= e($meta['label']) ?></strong> — the FAQ section is automatically hidden on this page.</span>
            </div>
            <?php else: ?>
            <div class="divide-y divide-outline-variant/40">
                <?php foreach ($page_faqs as $i => $row): ?>
                <div class="flex items-start gap-3 px-5 py-3.5 hover:bg-surface-container-low/50 transition-colors <?= !(int)$row['active'] ? 'opacity-60' : '' ?>">
                    <div class="w-6 h-6 rounded-full bg-surface-container text-outline text-xs font-semibold flex items-center justify-center shrink-0 mt-0.5"><?= $i + 1 ?></div>
                    <div class="flex flex-col flex-1 min-w-0">
                        <p class="font-label-lg text-label-lg text-on-surface font-semibold"><?= e($row['question']) ?></p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed line-clamp-2"><?= e($row['answer']) ?></p>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <form method="post" class="inline">
                            <input type="hidden" name="_action" value="toggle">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <input type="hidden" name="return_page" value="<?= e($filter_page) ?>">
                            <button type="submit" title="<?= $row['active'] ? 'Hide' : 'Show' ?>" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center transition-colors <?= $row['active'] ? 'text-primary' : 'text-outline' ?>">
                                <span class="material-symbols-outlined text-[18px]"><?= $row['active'] ? 'visibility' : 'visibility_off' ?></span>
                            </button>
                        </form>
                        <button type="button" onclick='openFaqForm(<?= json_encode($row, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        <form method="post" onsubmit="return confirm('Delete this FAQ?')" class="inline">
                            <input type="hidden" name="_action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <input type="hidden" name="return_page" value="<?= e($filter_page) ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- FAQ Form Drawer -->
<div id="faqDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-on-surface/40 backdrop-blur-sm" onclick="closeFaqForm()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-surface-container-lowest shadow-2xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/30 shrink-0">
            <h2 id="faqDrawerTitle" class="font-headline-sm text-headline-sm text-on-surface">Add FAQ</h2>
            <button type="button" onclick="closeFaqForm()" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form method="post" id="faqForm" class="flex flex-col flex-1 overflow-y-auto">
            <input type="hidden" name="_action" value="save">
            <input type="hidden" name="id" id="ff-id" value="">
            <input type="hidden" name="return_page" value="<?= e($filter_page) ?>">
            <div class="p-space-lg space-y-space-md flex-1">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-page">Page <span class="text-error">*</span></label>
                    <select id="ff-page" name="page" required class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                        <?php foreach ($faq_pages as $pk => $meta): ?>
                            <option value="<?= e($pk) ?>"><?= e($meta['label']) ?> (<?= e($meta['url']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-question">Question <span class="text-error">*</span></label>
                    <textarea id="ff-question" name="question" rows="3" required class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface resize-none transition-colors" placeholder="e.g. What services does TechBound offer?"></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-answer">Answer <span class="text-error">*</span></label>
                    <textarea id="ff-answer" name="answer" rows="6" required class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface resize-y transition-colors" placeholder="Provide a clear and helpful answer..."></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-order">Sort Order</label>
                    <input type="number" id="ff-order" name="sort_order" min="0" value="0" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                </div>
                <label class="flex items-center gap-space-sm cursor-pointer select-none">
                    <div class="relative">
                        <input type="checkbox" id="ff-active" name="active" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-surface-container-high rounded-full peer-checked:bg-primary transition-colors"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="font-label-lg text-label-lg text-on-surface">Active (visible on page)</span>
                </label>
            </div>
            <div class="px-space-lg py-space-md border-t border-outline-variant/30 flex justify-end gap-space-sm shrink-0">
                <button type="button" onclick="closeFaqForm()" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">Cancel</button>
                <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Save FAQ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const editingFaq = <?= $editing ? json_encode($editing) : 'null' ?>;

function openFaqForm(data, defaultPage) {
    const drawer = document.getElementById('faqDrawer');
    if (data) {
        document.getElementById('faqDrawerTitle').textContent = 'Edit FAQ';
        document.getElementById('ff-id').value       = data.id;
        document.getElementById('ff-page').value     = data.page || 'home';
        document.getElementById('ff-question').value = data.question || '';
        document.getElementById('ff-answer').value   = data.answer   || '';
        document.getElementById('ff-order').value    = data.sort_order ?? 0;
        document.getElementById('ff-active').checked = data.active == 1;
    } else {
        document.getElementById('faqDrawerTitle').textContent = 'Add FAQ';
        document.getElementById('faqForm').reset();
        document.getElementById('ff-id').value = '';
        if (defaultPage) {
            document.getElementById('ff-page').value = defaultPage;
        }
        document.getElementById('ff-active').checked = true;
    }
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
}
function closeFaqForm() {
    document.getElementById('faqDrawer').classList.add('hidden');
    document.getElementById('faqDrawer').classList.remove('flex');
    if (window.location.search.includes('edit=')) {
        const u = new URL(window.location.href);
        u.searchParams.delete('edit');
        history.replaceState(null, '', u.toString());
    }
}
if (editingFaq) openFaqForm(editingFaq);
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
