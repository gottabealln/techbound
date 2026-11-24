<?php
require __DIR__ . '/_guard.php';
$pdo = admin_db();

$total_enquiries  = 0;
$new_enquiries    = 0;
$active_services  = 0;
$total_reviews    = 0;
$total_blogs      = 0;
$draft_blogs      = 0;
$total_faqs       = 0;
$recent_enquiries    = [];
$recent_posts        = [];
$recent_testimonials = [];

if ($pdo) {
    try {
        $total_enquiries = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
        $new_enquiries   = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();
        $active_services = (int)$pdo->query("SELECT COUNT(*) FROM services WHERE active = 1")->fetchColumn();
        $total_reviews   = (int)$pdo->query("SELECT COUNT(*) FROM testimonials WHERE active = 1")->fetchColumn();
        $total_blogs     = (int)$pdo->query("SELECT COUNT(*) FROM blog_posts WHERE active = 1")->fetchColumn();
        $draft_blogs     = (int)$pdo->query("SELECT COUNT(*) FROM blog_posts WHERE active = 0")->fetchColumn();
        $total_faqs      = (int)$pdo->query("SELECT COUNT(*) FROM faqs WHERE active = 1")->fetchColumn();

        if (admin_can('enquiries')) {
            $recent_enquiries = $pdo->query("SELECT id, name, email, phone, company, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 6")->fetchAll();
        }
        if (admin_can('blog')) {
            $recent_posts = $pdo->query("SELECT id, title, slug, category, published_at, active FROM blog_posts ORDER BY published_at DESC, id DESC LIMIT 5")->fetchAll();
        }
        if (admin_can('testimonials')) {
            $recent_testimonials = $pdo->query("SELECT id, client, role, quote, active FROM testimonials WHERE active = 1 ORDER BY sort_order ASC, id ASC LIMIT 5")->fetchAll();
        }
    } catch (Throwable $e) {}
} else {
    $phpDataPath = __DIR__ . '/../data/blogs_index.php';
    if (is_file($phpDataPath)) {
        $idx = require $phpDataPath;
        if (is_array($idx)) {
            $total_blogs  = count($idx);
            $recent_posts = array_slice($idx, 0, 5);
        }
    }
}

$page_title = 'Dashboard';
require __DIR__ . '/_header.php';
?>

<div class="max-w-7xl mx-auto flex flex-col gap-6">

    <?php if (!$pdo): ?>
    <div class="p-4 rounded-lg bg-amber-50 border border-amber-300 text-amber-950 text-sm flex items-start gap-3">
        <span class="material-symbols-outlined text-[20px] text-amber-700 shrink-0 mt-0.5">warning</span>
        <div class="flex flex-col gap-1">
            <span class="font-semibold text-amber-950">Database offline (read-only fallback)</span>
            <p class="text-xs text-amber-900 leading-relaxed">
                MySQL is not connected. Articles are being read from <code class="bg-amber-200/70 px-1 py-0.5 rounded font-semibold">data/blogs_index.php</code>. Configure <code class="bg-amber-200/70 px-1 py-0.5 rounded font-semibold">DB_HOST</code>, <code class="bg-amber-200/70 px-1 py-0.5 rounded font-semibold">DB_NAME</code>, <code class="bg-amber-200/70 px-1 py-0.5 rounded font-semibold">DB_USER</code>, <code class="bg-amber-200/70 px-1 py-0.5 rounded font-semibold">DB_PASS</code>, and <code class="bg-amber-200/70 px-1 py-0.5 rounded font-semibold">DB_PORT</code> to enable writes.
            </p>
        </div>
    </div>
    <?php endif; ?>

    <?php $__flash = (string)($_GET['flash'] ?? ''); if (strpos($__flash, ':') !== false): [$__ft, $__fm] = explode(':', $__flash, 2); ?>
    <div class="px-4 py-3 rounded-lg border text-sm flex items-center gap-2 <?= $__ft === 'success' ? 'bg-green-50 border-green-200 text-green-900' : 'bg-red-50 border-red-200 text-red-900' ?>">
        <span class="material-symbols-outlined text-[18px]"><?= $__ft === 'success' ? 'check_circle' : 'error' ?></span>
        <span><?= e($__fm) ?></span>
    </div>
    <?php endif; ?>

    <!-- Header Row -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Overview</h1>
            <p class="text-sm text-on-surface-variant mt-0.5">Website content and incoming enquiries for TechBound.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <?php if (admin_can('blog')): ?>
            <a href="<?= e(admin_url('resources/blog_editor.php')) ?>" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-md bg-primary hover:bg-primary-container text-white text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>New Article</span>
            </a>
            <?php endif; ?>
            <?php if (admin_can('enquiries')): ?>
            <a href="<?= e(admin_url('resources/contact_messages.php')) ?>" class="inline-flex items-center gap-1.5 h-9 px-4 rounded-md bg-white border border-outline-variant hover:bg-surface-container text-on-surface text-sm font-medium transition-colors">
                <span>View Enquiries</span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Real Database Counts -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <a href="<?= e(admin_url('resources/contact_messages.php')) ?>" class="bg-white border border-outline-variant rounded-lg p-4 hover:border-primary/50 transition-colors">
            <span class="text-xs font-label-md text-outline uppercase tracking-wide">Enquiries</span>
            <div class="font-data-metric text-data-metric text-on-surface mt-2"><?= number_format($total_enquiries) ?></div>
            <p class="text-xs text-on-surface-variant mt-1"><?= $new_enquiries ?> in the last 7 days</p>
        </a>

        <a href="<?= e(admin_url('resources/blog_posts.php')) ?>" class="bg-white border border-outline-variant rounded-lg p-4 hover:border-primary/50 transition-colors">
            <span class="text-xs font-label-md text-outline uppercase tracking-wide">Published Articles</span>
            <div class="font-data-metric text-data-metric text-on-surface mt-2"><?= number_format($total_blogs) ?></div>
            <p class="text-xs text-on-surface-variant mt-1"><?= $draft_blogs ?> drafts</p>
        </a>

        <a href="<?= e(admin_url('resources/services.php')) ?>" class="bg-white border border-outline-variant rounded-lg p-4 hover:border-primary/50 transition-colors">
            <span class="text-xs font-label-md text-outline uppercase tracking-wide">Active Services</span>
            <div class="font-data-metric text-data-metric text-on-surface mt-2"><?= number_format($active_services) ?></div>
            <p class="text-xs text-on-surface-variant mt-1">Listed on site</p>
        </a>

        <a href="<?= e(admin_url('resources/testimonials.php')) ?>" class="bg-white border border-outline-variant rounded-lg p-4 hover:border-primary/50 transition-colors">
            <span class="text-xs font-label-md text-outline uppercase tracking-wide">Testimonials</span>
            <div class="font-data-metric text-data-metric text-on-surface mt-2"><?= number_format($total_reviews) ?></div>
            <p class="text-xs text-on-surface-variant mt-1">Published reviews</p>
        </a>

        <a href="<?= e(admin_url('resources/faqs.php')) ?>" class="bg-white border border-outline-variant rounded-lg p-4 hover:border-primary/50 transition-colors col-span-2 lg:col-span-1">
            <span class="text-xs font-label-md text-outline uppercase tracking-wide">FAQs</span>
            <div class="font-data-metric text-data-metric text-on-surface mt-2"><?= number_format($total_faqs) ?></div>
            <p class="text-xs text-on-surface-variant mt-1">Active entries</p>
        </a>
    </div>

    <!-- Main 2-Column Content -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        <!-- Left: Tables -->
        <div class="xl:col-span-8 flex flex-col gap-6 min-w-0">

            <?php if (admin_can('enquiries')): ?>
            <div class="bg-white border border-outline-variant rounded-lg overflow-hidden">
                <div class="px-5 py-4 border-b border-outline-variant flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Recent Enquiries</h2>
                        <p class="text-xs text-outline mt-0.5">Latest contact and career form submissions</p>
                    </div>
                    <a href="<?= e(admin_url('resources/contact_messages.php')) ?>" class="text-xs font-label-md text-primary hover:underline">View all</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant bg-surface-container-low text-outline text-xs uppercase tracking-wider">
                                <th class="py-2.5 px-5 font-medium">Name</th>
                                <th class="py-2.5 px-4 font-medium">Contact</th>
                                <th class="py-2.5 px-4 font-medium">Date</th>
                                <th class="py-2.5 px-5 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm">
                            <?php if (empty($recent_enquiries)): ?>
                                <tr>
                                    <td colspan="4" class="py-8 px-5 text-center text-on-surface-variant">No enquiries yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_enquiries as $row): ?>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-3 px-5">
                                        <div class="font-medium text-on-surface"><?= e($row['name']) ?></div>
                                        <?php if (!empty($row['company'])): ?>
                                            <div class="text-xs text-outline truncate max-w-[220px]"><?= e($row['company']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-on-surface-variant">
                                        <div class="truncate max-w-[220px]"><?= e($row['email']) ?></div>
                                        <?php if (!empty($row['phone'])): ?>
                                            <div class="text-xs text-outline"><?= e($row['phone']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-on-surface-variant whitespace-nowrap">
                                        <?= date('d M Y, H:i', strtotime($row['created_at'])) ?>
                                    </td>
                                    <td class="py-3 px-5 text-right whitespace-nowrap">
                                        <a href="<?= e(admin_url('resources/contact_messages.php?q=' . urlencode($row['email']))) ?>" class="text-xs font-medium text-primary hover:underline mr-3">Open</a>
                                        <a href="mailto:<?= e($row['email']) ?>" class="text-xs font-medium text-on-surface-variant hover:text-on-surface">Email</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <?php if (admin_can('blog')): ?>
            <div class="bg-white border border-outline-variant rounded-lg overflow-hidden">
                <div class="px-5 py-4 border-b border-outline-variant flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Recent Blog Posts</h2>
                        <p class="text-xs text-outline mt-0.5">Latest articles on the website</p>
                    </div>
                    <a href="<?= e(admin_url('resources/blog_posts.php')) ?>" class="text-xs font-label-md text-primary hover:underline">Manage all</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant bg-surface-container-low text-outline text-xs uppercase tracking-wider">
                                <th class="py-2.5 px-5 font-medium">Title</th>
                                <th class="py-2.5 px-4 font-medium">Category</th>
                                <th class="py-2.5 px-4 font-medium">Published</th>
                                <th class="py-2.5 px-5 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm">
                            <?php if (empty($recent_posts)): ?>
                                <tr>
                                    <td colspan="4" class="py-8 px-5 text-center text-on-surface-variant">No articles found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_posts as $post): ?>
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="py-3 px-5">
                                        <div class="font-medium text-on-surface line-clamp-1"><?= e($post['title'] ?? '') ?></div>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-on-surface-variant whitespace-nowrap">
                                        <?= e($post['category'] ?: 'General') ?>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-on-surface-variant whitespace-nowrap">
                                        <?= !empty($post['published_at']) ? date('d M Y', strtotime($post['published_at'])) : '—' ?>
                                    </td>
                                    <td class="py-3 px-5 text-right whitespace-nowrap">
                                        <?php if (!empty($post['id'])): ?>
                                            <a href="<?= e(admin_url('resources/blog_editor.php?id=' . (int)$post['id'])) ?>" class="text-xs font-medium text-primary hover:underline mr-3">Edit</a>
                                        <?php endif; ?>
                                        <?php if (!empty($post['slug'])): ?>
                                            <a href="<?= e(url('blog-post.php?slug=' . rawurlencode($post['slug']))) ?>" target="_blank" class="text-xs font-medium text-on-surface-variant hover:text-on-surface">View</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <?php if (admin_can('testimonials')): ?>
            <div class="bg-white border border-outline-variant rounded-lg overflow-hidden">
                <div class="px-5 py-4 border-b border-outline-variant flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Testimonials &amp; Reviews</h2>
                        <p class="text-xs text-outline mt-0.5">Published client reviews shown across the site</p>
                    </div>
                    <a href="<?= e(admin_url('resources/testimonials.php')) ?>" class="text-xs font-label-md text-primary hover:underline">Manage all</a>
                </div>

                <div class="divide-y divide-outline-variant">
                    <?php if (empty($recent_testimonials)): ?>
                        <div class="py-8 px-5 text-center text-sm text-on-surface-variant">No testimonials added yet.</div>
                    <?php else: ?>
                        <?php foreach ($recent_testimonials as $rev): ?>
                        <div class="px-5 py-3.5 flex items-start justify-between gap-4 hover:bg-surface-container-low transition-colors">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-on-surface line-clamp-2">"<?= e($rev['quote']) ?>"</p>
                                <p class="text-xs text-outline mt-1">
                                    <strong class="font-medium text-on-surface-variant"><?= e($rev['client']) ?></strong>
                                    <?php if (!empty($rev['role'])): ?> &middot; <?= e($rev['role']) ?><?php endif; ?>
                                </p>
                            </div>
                            <a href="<?= e(admin_url('resources/testimonials.php?edit=' . (int)$rev['id'])) ?>" class="text-xs font-medium text-primary hover:underline shrink-0">Edit</a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Right: Shortcuts & Info -->
        <div class="xl:col-span-4 flex flex-col gap-6 min-w-0">

            <div class="bg-white border border-outline-variant rounded-lg p-5">
                <h2 class="font-headline-sm text-headline-sm text-on-surface">Quick Links</h2>
                <div class="mt-3 divide-y divide-outline-variant">
                    <?php if (admin_can('blog')): ?>
                    <a href="<?= e(admin_url('resources/blog_editor.php')) ?>" class="py-2.5 flex items-center justify-between text-sm text-on-surface hover:text-primary transition-colors">
                        <span>Write a new blog post</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                    </a>
                    <?php endif; ?>
                    <?php if (admin_can('enquiries')): ?>
                    <a href="<?= e(admin_url('resources/contact_messages.php')) ?>" class="py-2.5 flex items-center justify-between text-sm text-on-surface hover:text-primary transition-colors">
                        <span>Review contact enquiries</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                    </a>
                    <?php endif; ?>
                    <?php if (admin_can('services')): ?>
                    <a href="<?= e(admin_url('resources/services.php')) ?>" class="py-2.5 flex items-center justify-between text-sm text-on-surface hover:text-primary transition-colors">
                        <span>Update services</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                    </a>
                    <?php endif; ?>
                    <?php if (admin_can('testimonials')): ?>
                    <a href="<?= e(admin_url('resources/testimonials.php')) ?>" class="py-2.5 flex items-center justify-between text-sm text-on-surface hover:text-primary transition-colors">
                        <span>Manage testimonials</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                    </a>
                    <?php endif; ?>
                    <?php if (admin_can('faqs')): ?>
                    <a href="<?= e(admin_url('resources/faqs.php')) ?>" class="py-2.5 flex items-center justify-between text-sm text-on-surface hover:text-primary transition-colors">
                        <span>Manage FAQs</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                    </a>
                    <?php endif; ?>
                    <?php if (admin_is_super()): ?>
                    <a href="<?= e(admin_url('resources/users.php')) ?>" class="py-2.5 flex items-center justify-between text-sm text-on-surface hover:text-primary transition-colors">
                        <span>Manage admin users</span>
                        <span class="material-symbols-outlined text-[18px] text-outline">chevron_right</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white border border-outline-variant rounded-lg p-5">
                <h2 class="font-headline-sm text-headline-sm text-on-surface">System Status</h2>
                <dl class="mt-3 space-y-2.5 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-on-surface-variant">Database</dt>
                        <dd class="font-medium <?= $pdo ? 'text-primary' : 'text-amber-700' ?>">
                            <?= $pdo ? 'Connected' : 'Offline' ?>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-on-surface-variant">Signed in as</dt>
                        <dd class="font-medium text-on-surface"><?= e($user['name']) ?></dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-on-surface-variant">Role</dt>
                        <dd class="font-medium text-on-surface"><?= e(admin_role_label($role)) ?></dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-on-surface-variant">Server Time</dt>
                        <dd class="text-on-surface-variant"><?= date('d M Y, H:i') ?></dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/_footer.php'; ?>
