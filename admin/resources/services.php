<?php
require __DIR__ . '/../_guard.php';
require_once __DIR__ . '/../../includes/service_seo.php';
$pdo = admin_db();

if ($pdo) {
    seed_default_services_if_empty($pdo);
}

$page_file_options = [
    'index.php'                              => 'Home Page (index.php)',
    'about.php'                              => 'About Us (about.php)',
    'services.php'                           => 'Services Overview (services.php)',
    'seo.php'                                => 'Search Engine Optimization (seo.php)',
    'ai-seo.php'                             => 'AI SEO, AEO & GEO (ai-seo.php)',
    'smm.php'                                => 'Social Media Marketing (smm.php)',
    'online-advertising.php'                 => 'Online Advertising & PPC (online-advertising.php)',
    'website-development.php'                => 'Website Development (website-development.php)',
    'lead-generation.php'                    => 'Lead Generation (lead-generation.php)',
    'construction.php'                       => 'Real Estate Marketing (construction.php)',
    'digital-marketing-agency-in-kochi.php'  => 'Digital Marketing Kochi (digital-marketing-agency-in-kochi.php)',
    'digital-marketing-trivandrum-guide.php' => 'Trivandrum Guide (digital-marketing-trivandrum-guide.php)',
    'seo-course-in-kerala.php'               => 'AI 360 SEO Course (seo-course-in-kerala.php)',
    'portfolio.php'                          => 'Portfolio (portfolio.php)',
    'blog.php'                               => 'Blog (blog.php)',
    'careers.php'                            => 'Careers (careers.php)',
    'contact.php'                            => 'Contact Us (contact.php)',
    'privacy-policy.php'                     => 'Privacy Policy (privacy-policy.php)',
    'terms-and-conditions.php'               => 'Terms & Conditions (terms-and-conditions.php)',
];

// Map page_file -> FAQ page key (for quick "FAQs" button on each row)
$page_file_to_faq = [
    'index.php'                              => 'home',
    'about.php'                              => 'about',
    'services.php'                           => 'services',
    'seo.php'                                => 'seo',
    'ai-seo.php'                             => 'ai-seo',
    'smm.php'                                => 'smm',
    'online-advertising.php'                 => 'online-advertising',
    'website-development.php'                => 'website-development',
    'lead-generation.php'                    => 'lead-generation',
    'construction.php'                       => 'construction',
    'digital-marketing-agency-in-kochi.php'  => 'kochi',
    'digital-marketing-trivandrum-guide.php' => 'trivandrum-guide',
    'seo-course-in-kerala.php'               => 'seo-course',
    'portfolio.php'                          => 'portfolio',
    'blog.php'                               => 'blog',
    'careers.php'                            => 'careers',
    'contact.php'                            => 'contact',
];

$core_files    = ['index.php', 'about.php', 'portfolio.php', 'blog.php', 'careers.php', 'contact.php'];
$service_files = ['services.php', 'seo.php', 'ai-seo.php', 'smm.php', 'online-advertising.php', 'website-development.php', 'lead-generation.php', 'construction.php'];
$landing_files = ['digital-marketing-agency-in-kochi.php', 'digital-marketing-trivandrum-guide.php', 'seo-course-in-kerala.php', 'privacy-policy.php', 'terms-and-conditions.php'];

$action = $_POST['_action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . admin_url('resources/services.php?flash=' . urlencode('error:Cannot modify services while database is disconnected.')));
        exit;
    }

    if ($action === 'save') {
        $id               = (int)($_POST['id'] ?? 0);
        $page_file        = basename(trim($_POST['page_file'] ?? ''));
        $title            = trim($_POST['title'] ?? '');
        $slug             = trim($_POST['slug'] ?? '', " \t\n\r\0\x0B/");
        $meta_title       = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $primary_keyword  = trim($_POST['primary_keyword'] ?? '');
        $schema_data      = trim($_POST['schema_data'] ?? '');
        $intro            = trim($_POST['intro'] ?? '');
        $items            = trim($_POST['items'] ?? '');
        if ($items === '') $items = '[]';
        $image                 = trim($_POST['image'] ?? '');
        $image_alt             = trim($_POST['image_alt'] ?? '');
        $image_alt_description = trim($_POST['image_alt_description'] ?? '');
        $sort_order            = (int)($_POST['sort_order'] ?? 0);
        $active           = isset($_POST['active']) ? 1 : 0;

        // Clean slug preserving nested paths like our-services/seo-company-in-kerala
        $slug = preg_replace('/[^a-z0-9\/-]+/i', '-', strtolower($slug));
        $slug = trim(preg_replace('/\/+/', '/', $slug), '/');

        if ($title === '') {
            $flash = 'error:Title is required.';
        } elseif ($schema_data !== '' && json_decode($schema_data, true) === null && json_last_error() !== JSON_ERROR_NONE) {
            $flash = 'error:Schema data must be valid JSON-LD (' . json_last_error_msg() . ').';
        } else {
            if ($slug === '' && $page_file !== 'index.php') {
                $slug = 'our-services/' . trim(preg_replace('/[^a-z0-9]+/i', '-', strtolower($title)), '-');
            }
            if ($meta_title === '') {
                $meta_title = $title . ' | TechBound';
            }
            if ($meta_description === '' && $intro !== '') {
                $meta_description = mb_substr($intro, 0, 160);
            }
            if ($image_alt === '') {
                $image_alt = $title . ' - TechBound Innovations';
            }

            if ($id) {
                $pdo->prepare(
                    'UPDATE services
                     SET page_file=?, title=?, meta_title=?, meta_description=?, primary_keyword=?, schema_data=?, slug=?, intro=?, items=?, image=?, image_alt=?, image_alt_description=?, sort_order=?, active=?
                     WHERE id=?'
                )->execute([
                    $page_file, $title, $meta_title, $meta_description, $primary_keyword, $schema_data,
                    $slug, $intro, $items, $image, $image_alt, $image_alt_description, $sort_order, $active, $id
                ]);
                $flash = 'success:Service SEO & details updated.';
            } else {
                $pdo->prepare(
                    'INSERT INTO services (page_file, title, meta_title, meta_description, primary_keyword, schema_data, slug, intro, items, image, image_alt, image_alt_description, sort_order, active)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
                )->execute([
                    $page_file, $title, $meta_title, $meta_description, $primary_keyword, $schema_data,
                    $slug, $intro, $items, $image, $image_alt, $image_alt_description, $sort_order, $active
                ]);
                $flash = 'success:Service created.';
            }
            sync_services_cache($pdo);
            header('Location: ' . admin_url('resources/services.php?flash=' . urlencode($flash)));
            exit;
        }
    }

    if ($action === 'delete' && !empty($_POST['id'])) {
        $pdo->prepare('DELETE FROM services WHERE id=?')->execute([(int)$_POST['id']]);
        sync_services_cache($pdo);
        header('Location: ' . admin_url('resources/services.php?flash=' . urlencode('success:Service deleted.')));
        exit;
    }

    if ($action === 'toggle' && !empty($_POST['id'])) {
        $pdo->prepare('UPDATE services SET active = 1 - active WHERE id=?')->execute([(int)$_POST['id']]);
        sync_services_cache($pdo);
        header('Location: ' . admin_url('resources/services.php'));
        exit;
    }
}

$flash = $flash ?? urldecode($_GET['flash'] ?? '');
[$flash_type, $flash_msg] = $flash && strpos($flash, ':') !== false ? explode(':', $flash, 2) : ['', ''];

$editing = null;
$rows    = [];
$total   = 0;

if ($pdo) {
    try {
        if (!empty($_GET['edit'])) {
            $s = $pdo->prepare('SELECT * FROM services WHERE id=?');
            $s->execute([(int)$_GET['edit']]);
            $editing = $s->fetch();
        }
        $rows  = $pdo->query('SELECT * FROM services ORDER BY sort_order ASC, id ASC')->fetchAll();
        $total = count($rows);
    } catch (Throwable $e) {}
} else {
    $rows  = get_all_services_seo();
    $total = count($rows);
}

$filter_cat = trim($_GET['cat'] ?? '');
$all_rows   = $rows;
if ($filter_cat === 'core') {
    $rows = array_values(array_filter($all_rows, fn($r) => in_array($r['page_file'] ?? '', $core_files, true)));
} elseif ($filter_cat === 'services') {
    $rows = array_values(array_filter($all_rows, fn($r) => in_array($r['page_file'] ?? '', $service_files, true)));
} elseif ($filter_cat === 'landing') {
    $rows = array_values(array_filter($all_rows, fn($r) => in_array($r['page_file'] ?? '', $landing_files, true)));
}
$total = count($rows);

$page_title = 'Pages & SEO';
require __DIR__ . '/../_header.php';
?>

<div class="max-w-7xl mx-auto flex flex-col gap-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Pages &amp; SEO Settings</h1>
            <p class="text-sm text-on-surface-variant mt-0.5">Manage Meta Title, Meta Description, URL Slug, Primary Keyword, Schema JSON-LD, and Image Alt text for every page across the website.</p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            <span class="px-3 py-1.5 rounded-md bg-white border border-outline-variant text-xs font-medium text-on-surface-variant">
                <?= $total ?> page<?= $total !== 1 ? 's' : '' ?>
            </span>
            <button type="button" onclick="openServiceForm()" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-md bg-primary hover:bg-primary-container text-white text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>New Page</span>
            </button>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex flex-wrap items-center gap-2">
        <?php
        $cat_tabs = [
            ''         => ['All Pages',       count($all_rows)],
            'core'     => ['Core Pages',      count(array_filter($all_rows, fn($r) => in_array($r['page_file'] ?? '', $core_files, true)))],
            'services' => ['Service Pages',   count(array_filter($all_rows, fn($r) => in_array($r['page_file'] ?? '', $service_files, true)))],
            'landing'  => ['Landing & Legal', count(array_filter($all_rows, fn($r) => in_array($r['page_file'] ?? '', $landing_files, true)))],
        ];
        foreach ($cat_tabs as $ck => [$clabel, $ccnt]):
            $cact = ($filter_cat === $ck);
        ?>
        <a href="<?= $ck === '' ? '?' : ('?cat=' . urlencode($ck)) ?>"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-medium border transition-colors <?= $cact ? 'bg-primary text-white border-primary' : 'bg-white text-on-surface border-outline-variant hover:border-primary' ?>">
            <span><?= e($clabel) ?></span>
            <span class="px-1.5 py-0.2 rounded-full text-[11px] <?= $cact ? 'bg-white/20 text-white' : 'bg-surface-container text-outline' ?>"><?= $ccnt ?></span>
        </a>
        <?php endforeach; ?>
    </div>

    <?php if ($flash_msg): ?>
    <div class="px-4 py-3 rounded-lg border text-sm flex items-center gap-2 <?= $flash_type === 'success' ? 'bg-green-50 border-green-200 text-green-900' : 'bg-red-50 border-red-200 text-red-900' ?>">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span>
        <span><?= e($flash_msg) ?></span>
    </div>
    <?php endif; ?>

    <!-- Services Table -->
    <?php if (empty($rows)): ?>
    <div class="bg-white border border-outline-variant rounded-lg py-16 flex flex-col items-center gap-3 text-on-surface-variant">
        <span class="material-symbols-outlined text-[40px] text-outline">work_outline</span>
        <span class="text-sm">No services configured yet.</span>
        <button type="button" onclick="openServiceForm()" class="h-9 px-4 rounded-md bg-primary text-white text-sm font-medium">Add Service</button>
    </div>
    <?php else: ?>
    <div class="bg-white border border-outline-variant rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-outline text-xs uppercase tracking-wider">
                        <th class="py-3 px-5 font-medium">Service / Page</th>
                        <th class="py-3 px-4 font-medium">URL Slug</th>
                        <th class="py-3 px-4 font-medium">Primary Keyword</th>
                        <th class="py-3 px-4 font-medium">SEO Completeness</th>
                        <th class="py-3 px-4 font-medium">Status</th>
                        <th class="py-3 px-5 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant text-sm">
                    <?php foreach ($rows as $row):
                        $hasMeta   = !empty(trim((string)($row['meta_title'] ?? ''))) && !empty(trim((string)($row['meta_description'] ?? '')));
                        $hasSchema = !empty(trim((string)($row['schema_data'] ?? '')));
                        $hasAlt    = !empty(trim((string)($row['image_alt'] ?? '')));
                        $cleanSlug = trim((string)($row['slug'] ?? ''), '/');
                        $liveUrl   = $cleanSlug === '' ? BASE_URL : (rtrim(BASE_URL, '/') . '/' . $cleanSlug . '/');
                        $slugLabel = $cleanSlug === '' ? '/' : ('/' . $cleanSlug . '/');
                        $faqKey    = $page_file_to_faq[$row['page_file'] ?? ''] ?? '';
                    ?>
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="py-3.5 px-5">
                            <div class="font-medium text-on-surface"><?= e($row['title']) ?></div>
                            <div class="text-xs text-outline mt-0.5"><?= e($row['page_file'] ?: 'Custom entry') ?></div>
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="<?= e($liveUrl) ?>" target="_blank" class="text-xs font-mono text-primary hover:underline break-all">
                                <?= e($slugLabel) ?>
                            </a>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-on-surface-variant">
                            <?= e($row['primary_keyword'] ?: '—') ?>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex flex-wrap gap-1.5 text-[11px]">
                                <span class="px-2 py-0.5 rounded <?= $hasMeta ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-500' ?>">Meta</span>
                                <span class="px-2 py-0.5 rounded <?= $hasSchema ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-500' ?>">Schema</span>
                                <span class="px-2 py-0.5 rounded <?= $hasAlt ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-500' ?>">Alt</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <form method="post" class="inline">
                                <input type="hidden" name="_action" value="toggle">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <button type="submit" class="px-2.5 py-0.5 rounded-full text-xs font-medium border transition-colors <?= $row['active'] ? 'bg-green-50 border-green-200 text-green-800 hover:bg-green-100' : 'bg-gray-100 border-gray-200 text-gray-600 hover:bg-gray-200' ?>">
                                    <?= $row['active'] ? 'Active' : 'Hidden' ?>
                                </button>
                            </form>
                        </td>
                        <td class="py-3.5 px-5 text-right whitespace-nowrap">
                            <?php if ($faqKey !== ''): ?>
                                <a href="<?= e(admin_url('resources/faqs.php?page=' . urlencode($faqKey))) ?>" class="text-xs font-medium text-on-surface-variant hover:text-primary hover:underline mr-3">FAQs</a>
                            <?php endif; ?>
                            <button type="button" onclick='openServiceForm(<?= json_encode($row, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="text-xs font-medium text-primary hover:underline mr-3">Edit SEO</button>
                            <form method="post" onsubmit="return confirm('Delete this page SEO entry?')" class="inline">
                                <input type="hidden" name="_action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <button type="submit" class="text-xs font-medium text-outline hover:text-error">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Service & SEO Drawer -->
<div id="serviceDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/35" onclick="closeServiceForm()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-2xl bg-white border-l border-outline-variant shadow-xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant shrink-0">
            <h2 id="serviceDrawerTitle" class="font-headline-sm text-headline-sm text-on-surface">Edit Service SEO</h2>
            <button type="button" onclick="closeServiceForm()" class="w-8 h-8 rounded-md hover:bg-surface-container flex items-center justify-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form method="post" id="serviceForm" class="flex flex-col flex-1 overflow-y-auto">
            <input type="hidden" name="_action" value="save">
            <input type="hidden" name="id" id="sf-id" value="">

            <div class="p-6 space-y-5 flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-title">Service Name <span class="text-error">*</span></label>
                        <input type="text" id="sf-title" name="title" required class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface" placeholder="e.g. Search Engine Optimization">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-page-file">Linked Page File</label>
                        <select id="sf-page-file" name="page_file" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface">
                            <option value="">-- Select service template --</option>
                            <?php foreach ($page_file_options as $pf => $lbl): ?>
                                <option value="<?= e($pf) ?>"><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Slug (URL) -->
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-slug">Slug (URL)</label>
                    <div class="flex items-center rounded-md border border-outline-variant bg-surface-container-low overflow-hidden focus-within:border-primary">
                        <span class="px-3 text-xs font-mono text-outline shrink-0"><?= e(rtrim(BASE_URL, '/') . '/') ?></span>
                        <input type="text" id="sf-slug" name="slug" class="w-full h-10 px-2 bg-white border-0 focus:outline-none text-sm font-mono text-on-surface" placeholder="our-services/seo-company-in-kerala">
                    </div>
                    <p class="text-[11px] text-outline mt-1">Changing the slug updates all internal links and routes the new URL automatically.</p>
                </div>

                <!-- Meta Title & Meta Description -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-on-surface" for="sf-meta-title">Meta Title</label>
                        <span id="sf-mt-count" class="text-[11px] text-outline">0 / 60</span>
                    </div>
                    <input type="text" id="sf-meta-title" name="meta_title" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface" placeholder="SEO Services in Trivandrum | TechBound">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-on-surface" for="sf-meta-desc">Meta Description</label>
                        <span id="sf-md-count" class="text-[11px] text-outline">0 / 160</span>
                    </div>
                    <textarea id="sf-meta-desc" name="meta_description" rows="3" class="w-full px-3 py-2 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface resize-none" placeholder="Compelling 140-160 character search summary..."></textarea>
                </div>

                <!-- Primary Keyword -->
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-keyword">Primary Keyword</label>
                    <input type="text" id="sf-keyword" name="primary_keyword" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface" placeholder="e.g. SEO company in Trivandrum, Kerala">
                </div>

                <!-- Image URL & Alt Text -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-image">Image URL / Path</label>
                        <input type="text" id="sf-image" name="image" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface" placeholder="assets/services/seo-hero-1.jpg">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-image-alt">Image Alt Text</label>
                        <input type="text" id="sf-image-alt" name="image_alt" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface" placeholder="Short alt text for hero/service image">
                    </div>
                </div>

                <!-- Image Alt Description (Unlimited) -->
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-image-alt-desc">Image Alt Description</label>
                    <textarea id="sf-image-alt-desc" name="image_alt_description" rows="4" class="w-full px-3 py-2 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface resize-y" placeholder="Detailed image alt description (no character limit)..."></textarea>
                    <p class="text-[11px] text-outline mt-1">No character limit. Use for rich accessibility and visual context descriptions.</p>
                </div>

                <!-- Schema Data (JSON-LD) -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-on-surface" for="sf-schema">Schema Data (JSON-LD)</label>
                        <button type="button" onclick="generateDefaultSchema()" class="text-xs font-medium text-primary hover:underline">Generate default Service schema</button>
                    </div>
                    <textarea id="sf-schema" name="schema_data" rows="7" class="w-full px-3 py-2 rounded-md bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary text-xs font-mono text-on-surface resize-y" placeholder='{"@context":"https://schema.org","@type":"Service","serviceType":"SEO"}'></textarea>
                    <p class="text-[11px] text-outline mt-1">Valid JSON-LD is automatically injected into &lt;head&gt; on the service page.</p>
                </div>

                <!-- Intro & Sort Order -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-intro">Short Intro</label>
                        <input type="text" id="sf-intro" name="intro" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface" placeholder="One-line service summary">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="sf-order">Sort Order</label>
                        <input type="number" id="sf-order" name="sort_order" min="0" value="0" class="w-full h-10 px-3 rounded-md bg-white border border-outline-variant focus:outline-none focus:border-primary text-sm text-on-surface">
                    </div>
                </div>

                <input type="hidden" id="sf-items" name="items" value="">

                <label class="inline-flex items-center gap-2.5 cursor-pointer select-none">
                    <input type="checkbox" id="sf-active" name="active" value="1" class="w-4 h-4 accent-[#1b8c43] rounded" checked>
                    <span class="text-sm text-on-surface">Active (published)</span>
                </label>
            </div>

            <div class="px-6 py-4 border-t border-outline-variant flex justify-end gap-2.5 shrink-0 bg-surface-container-low">
                <button type="button" onclick="closeServiceForm()" class="h-9 px-4 rounded-md bg-white border border-outline-variant text-sm text-on-surface hover:bg-surface-container transition-colors">Cancel</button>
                <button type="submit" class="h-9 px-4 rounded-md bg-primary hover:bg-primary-container text-white text-sm font-medium transition-colors">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
const editingService = <?= $editing ? json_encode($editing) : 'null' ?>;

function updateSeoCounts() {
    const mt = document.getElementById('sf-meta-title');
    const md = document.getElementById('sf-meta-desc');
    document.getElementById('sf-mt-count').textContent = (mt.value || '').length + ' / 60';
    document.getElementById('sf-md-count').textContent = (md.value || '').length + ' / 160';
}

function openServiceForm(data) {
    const drawer = document.getElementById('serviceDrawer');
    if (data) {
        document.getElementById('serviceDrawerTitle').textContent = 'Edit: ' + (data.title || 'Service');
        document.getElementById('sf-id').value         = data.id || '';
        document.getElementById('sf-page-file').value  = data.page_file || '';
        document.getElementById('sf-title').value      = data.title || '';
        document.getElementById('sf-slug').value       = data.slug || '';
        document.getElementById('sf-meta-title').value = data.meta_title || '';
        document.getElementById('sf-meta-desc').value  = data.meta_description || '';
        document.getElementById('sf-keyword').value    = data.primary_keyword || '';
        document.getElementById('sf-schema').value     = data.schema_data || '';
        document.getElementById('sf-intro').value      = data.intro || '';
        document.getElementById('sf-items').value      = data.items || '';
        document.getElementById('sf-image').value          = data.image || '';
        document.getElementById('sf-image-alt').value      = data.image_alt || '';
        document.getElementById('sf-image-alt-desc').value = data.image_alt_description || '';
        document.getElementById('sf-order').value          = data.sort_order ?? 0;
        document.getElementById('sf-active').checked   = data.active == 1;
    } else {
        document.getElementById('serviceDrawerTitle').textContent = 'New Service';
        document.getElementById('serviceForm').reset();
        document.getElementById('sf-id').value = '';
    }
    updateSeoCounts();
    drawer.classList.remove('hidden');
}

function closeServiceForm() {
    document.getElementById('serviceDrawer').classList.add('hidden');
    if (window.location.search.includes('edit=')) {
        history.replaceState(null, '', window.location.pathname);
    }
}

function generateDefaultSchema() {
    const title = document.getElementById('sf-title').value.trim() || 'Digital Marketing Service';
    const desc  = document.getElementById('sf-meta-desc').value.trim() || document.getElementById('sf-intro').value.trim();
    const kw    = document.getElementById('sf-keyword').value.trim();
    const obj = {
        "@context": "https://schema.org",
        "@type": "Service",
        "serviceType": title,
        "description": desc,
        "provider": {
            "@type": "Organization",
            "name": "TechBound Innovations",
            "url": "https://techbound.in/"
        },
        "areaServed": ["Trivandrum", "Kerala", "India"]
    };
    if (kw) obj.keywords = kw;
    document.getElementById('sf-schema').value = JSON.stringify(obj, null, 2);
}

document.getElementById('sf-meta-title').addEventListener('input', updateSeoCounts);
document.getElementById('sf-meta-desc').addEventListener('input', updateSeoCounts);
document.getElementById('sf-title').addEventListener('input', function() {
    if (!document.getElementById('sf-id').value) {
        const s = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('sf-slug').value = s ? ('our-services/' + s) : '';
    }
});

if (editingService) openServiceForm(editingService);
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
