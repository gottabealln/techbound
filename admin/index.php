<?php
require __DIR__ . '/_guard.php';
$pdo = admin_db();

// Safe fallback metrics if DB is offline on cloud host
$total_enquiries  = 0;
$new_enquiries    = 0;
$active_services  = 12;
$total_reviews    = 8;
$total_blogs      = 260;
$recent_enquiries = [];

if ($pdo) {
    try {
        $total_enquiries = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
        $new_enquiries   = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)")->fetchColumn();
        $active_services = (int)$pdo->query("SELECT COUNT(*) FROM services WHERE active=1")->fetchColumn();
        $total_reviews   = (int)$pdo->query("SELECT COUNT(*) FROM testimonials WHERE active=1")->fetchColumn();
        $total_blogs     = (int)$pdo->query("SELECT COUNT(*) FROM blog_posts WHERE active=1")->fetchColumn();

        $recent_enquiries = admin_can('enquiries')
            ? $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 4")->fetchAll()
            : [];
    } catch (Throwable $e) {}
} else {
    // Read count from precompiled data file
    $phpDataPath = __DIR__ . '/../data/blogs_index.php';
    if (is_file($phpDataPath)) {
        $idx = require $phpDataPath;
        if (is_array($idx)) $total_blogs = count($idx);
    }
}

$page_title = 'Dashboard';
require __DIR__ . '/_header.php';
?>

<div class="flex flex-col w-full">

    <?php if (!$pdo): ?>
    <div class="mb-space-md p-4 rounded-xl bg-amber-50 border border-amber-300 text-amber-950 text-sm flex items-start gap-3">
        <span class="material-symbols-outlined text-[22px] text-amber-600 shrink-0 mt-0.5">cloud_off</span>
        <div class="flex flex-col gap-1">
            <span class="font-bold text-amber-950">Standalone Cloud Mode Active (Database Disconnected)</span>
            <p class="text-xs text-amber-900 leading-relaxed">
                You are currently running in zero-downtime offline mode. All 260 articles are loaded from precompiled files. To persist new enquiries, live blog additions, and multi-user accounts on Render, set up a MySQL database (e.g. TiDB Cloud, Aiven, or PlanetScale) and add <code class="bg-amber-200/70 px-1.5 py-0.5 rounded text-amber-950 font-semibold">DB_HOST</code>, <code class="bg-amber-200/70 px-1.5 py-0.5 rounded text-amber-950 font-semibold">DB_NAME</code>, <code class="bg-amber-200/70 px-1.5 py-0.5 rounded text-amber-950 font-semibold">DB_USER</code>, <code class="bg-amber-200/70 px-1.5 py-0.5 rounded text-amber-950 font-semibold">DB_PASS</code>, and <code class="bg-amber-200/70 px-1.5 py-0.5 rounded text-amber-950 font-semibold">DB_PORT</code> in Render's Environment Variables.
            </p>
        </div>
    </div>
    <?php endif; ?>

    <?php $__flash = (string)($_GET['flash'] ?? ''); if (strpos($__flash, ':') !== false): [$__ft, $__fm] = explode(':', $__flash, 2); ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $__ft === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $__ft === 'success' ? 'check_circle' : 'error' ?></span> <?= e($__fm) ?>
    </div>
    <?php endif; ?>

    <!-- Top Command & Action Bar -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2 text-on-surface-variant">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Home</span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Dashboard</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Agency Performance &amp; CMS Overview</h1>
            <p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-1.5 flex-wrap">
                <span>Welcome back, <strong class="text-on-surface font-semibold"><?= e($user['name']) ?>!</strong> Here is what happened with TechBound Innovations website traffic and enquiries today</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                    Trivandrum, Kerala • IST GMT+5:30
                </span>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            <button class="h-10 px-space-md rounded-lg bg-surface-container-low hover:bg-surface-container-high text-on-surface font-label-lg text-label-lg shadow-sm transition-all duration-150 flex items-center gap-2 group" type="button">
                <span class="material-symbols-outlined text-[18px] text-on-surface-variant group-hover:text-primary transition-colors">cloud_download</span>
                <span>Download Monthly Report</span>
            </button>
            <?php if (admin_can('enquiries')): ?>
            <a href="<?= e(admin_url('resources/contact_messages.php')) ?>" class="h-10 px-space-md rounded-lg bg-secondary-container text-on-secondary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all duration-150 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>+ New Enquiry</span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- 6-Stat KPI Metric Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-space-md mb-space-lg">
        <!-- Stat 1: Total Enquiries -->
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between relative overflow-hidden group">
            <div class="flex items-center justify-between mb-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Total Enquiries</span>
                <span class="p-1.5 rounded-lg bg-surface-container text-primary">
                    <span class="material-symbols-outlined text-[18px]">mark_email_unread</span>
                </span>
            </div>
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <span class="font-data-metric text-data-metric text-on-surface" data-counter="<?= $total_enquiries ?>">0</span>
                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-bold">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span> +18.4%
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-body-sm text-body-sm text-on-surface-variant">vs. last month</span>
                <svg class="w-16 h-5 text-primary shrink-0 overflow-visible" fill="none" viewbox="0 0 64 20">
                    <path d="M1 17L12 14L22 16L34 9L46 11L54 4L63 2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
            </div>
        </div>

        <!-- Stat 2: New Enquiries -->
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">New Enquiries (Wk)</span>
                <span class="p-1.5 rounded-lg bg-surface-container text-secondary">
                    <span class="material-symbols-outlined text-[18px]">inbox_customize</span>
                </span>
            </div>
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <span class="font-data-metric text-data-metric text-on-surface" data-counter="<?= $new_enquiries ?>">0</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant font-label-sm text-label-sm font-semibold">
                    <?= $new_enquiries ?> pending
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-body-sm text-body-sm text-on-surface-variant">Immediate follow-up</span>
                <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
            </div>
        </div>

        <!-- Stat 3: Published Articles -->
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Published Articles</span>
                <span class="p-1.5 rounded-lg bg-surface-container text-tertiary">
                    <span class="material-symbols-outlined text-[18px]">article</span>
                </span>
            </div>
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <span class="font-data-metric text-data-metric text-on-surface" data-counter="<?= $total_blogs ?>">0</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container-high text-tertiary font-label-sm text-label-sm font-semibold">
                    4 in Draft
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-body-sm text-body-sm text-on-surface-variant">+6 this month</span>
                <span class="material-symbols-outlined text-[16px] text-tertiary">post_add</span>
            </div>
        </div>

        <!-- Stat 4: Active Services -->
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Active Services</span>
                <span class="p-1.5 rounded-lg bg-surface-container text-primary">
                    <span class="material-symbols-outlined text-[18px]">layers</span>
                </span>
            </div>
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <span class="font-data-metric text-data-metric text-on-surface"><?= $active_services ?> <span class="font-headline-sm text-headline-sm font-semibold text-outline">Core</span></span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">
                    100% Active
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-body-sm text-body-sm text-on-surface-variant truncate">AI SEO leads 58%</span>
                <span class="material-symbols-outlined text-[16px] text-primary">psychology</span>
            </div>
        </div>

        <!-- Stat 5: Client Reviews -->
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Client Reviews</span>
                <span class="p-1.5 rounded-lg bg-surface-container text-secondary">
                    <span class="material-symbols-outlined text-[18px]">star</span>
                </span>
            </div>
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <span class="font-data-metric text-data-metric text-on-surface" data-counter="<?= $total_reviews ?>">0</span>
                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant font-label-sm text-label-sm font-bold">
                    4.9 ★
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-body-sm text-body-sm text-on-surface-variant">Kerala &amp; Global</span>
                <span class="material-symbols-outlined text-[16px] text-outline">verified</span>
            </div>
        </div>

        <!-- Stat 6: Monthly Visits -->
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div class="flex items-center justify-between mb-2">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Monthly Visits</span>
                <span class="p-1.5 rounded-lg bg-surface-container text-primary">
                    <span class="material-symbols-outlined text-[18px]">ads_click</span>
                </span>
            </div>
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <span class="font-data-metric text-data-metric text-on-surface" data-counter="84250">84.2k</span>
                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-bold">
                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span> +24.2%
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="font-body-sm text-body-sm text-on-surface-variant">Trivandrum &amp; GCC</span>
                <span class="material-symbols-outlined text-[16px] text-primary">public</span>
            </div>
        </div>
    </div>

    <!-- Operational Core: 2-Column Split (8 cols / 4 cols) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg mb-space-lg">
        
        <!-- LEFT PANE: 8 Columns -->
        <div class="xl:col-span-8 flex flex-col space-y-space-lg min-w-0">
            
            <!-- Lead Velocity Graph Card -->
            <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-sm mb-space-md">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <h2 class="font-headline-md text-headline-md text-on-surface">Enquiries &amp; Lead Velocity</h2>
                            <span class="px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-label-sm text-primary">Last 30 Days</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Aggregated inbound leads via organic search, landing pages, and campaign URLs</p>
                    </div>
                    <div class="inline-flex p-1 rounded-lg bg-surface-container-low shrink-0 self-start sm:self-auto">
                        <button class="px-3 py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface transition-colors" type="button">7 Days</button>
                        <button class="px-3 py-1 rounded bg-surface-container-lowest font-label-sm text-label-sm text-primary shadow-sm font-bold" type="button">30 Days</button>
                        <button class="px-3 py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface transition-colors" type="button">90 Days</button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-sm p-space-sm rounded-lg bg-surface-container-low mb-space-md">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Organic SEO Leads</span>
                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-0.5">824 <span class="font-label-sm text-label-sm text-primary font-normal">(57.7%)</span></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Web &amp; Tech Enquiries</span>
                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-0.5">386 <span class="font-label-sm text-label-sm text-tertiary font-normal">(27.0%)</span></span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Paid Ads / PPC Inbound</span>
                        <span class="font-headline-sm text-headline-sm text-on-surface font-bold mt-0.5">218 <span class="font-label-sm text-label-sm text-secondary font-normal">(15.3%)</span></span>
                    </div>
                </div>

                <!-- SVG Chart -->
                <div class="relative w-full h-64 overflow-hidden">
                    <svg class="w-full h-full" fill="none" preserveaspectratio="none" viewbox="0 0 760 220">
                        <defs>
                            <lineargradient id="primaryAreaGrad" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.28"></stop>
                                <stop offset="100%" stop-color="#1d4ed8" stop-opacity="0.0"></stop>
                            </lineargradient>
                            <lineargradient id="secondaryAreaGrad" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#fd651e" stop-opacity="0.2"></stop>
                                <stop offset="100%" stop-color="#fd651e" stop-opacity="0.0"></stop>
                            </lineargradient>
                        </defs>
                        <line stroke="#dae2fd" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="760" y1="30" y2="30"></line>
                        <line stroke="#dae2fd" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="760" y1="80" y2="80"></line>
                        <line stroke="#dae2fd" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="760" y1="130" y2="130"></line>
                        <line stroke="#dae2fd" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="760" y1="180" y2="180"></line>
                        
                        <path d="M0,190 C60,170 120,180 180,140 C240,110 300,135 360,105 C420,80 480,115 540,75 C600,60 660,85 760,45 L760,220 L0,220 Z" fill="url(#secondaryAreaGrad)"></path>
                        <path d="M0,190 C60,170 120,180 180,140 C240,110 300,135 360,105 C420,80 480,115 540,75 C600,60 660,85 760,45" stroke="#fd651e" stroke-linecap="round" stroke-width="2"></path>
                        
                        <path d="M0,160 C50,140 110,120 170,95 C230,70 290,95 350,60 C410,35 470,65 530,30 C590,15 650,45 760,15 L760,220 L0,220 Z" fill="url(#primaryAreaGrad)"></path>
                        <path d="M0,160 C50,140 110,120 170,95 C230,70 290,95 350,60 C410,35 470,65 530,30 C590,15 650,45 760,15" stroke="#1d4ed8" stroke-linecap="round" stroke-width="3"></path>
                        
                        <circle cx="530" cy="30" fill="#1d4ed8" r="5" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="530" cy="75" fill="#fd651e" r="4" stroke="#ffffff" stroke-width="2"></circle>
                    </svg>
                </div>
            </div>

            <!-- Recent Enquiries Rich Data Table -->
            <?php if (admin_can('enquiries')): ?>
            <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-space-sm mb-space-md">
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2">
                            <h2 class="font-headline-md text-headline-md text-on-surface">Recent Enquiries &amp; Prospects</h2>
                            <span class="px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant font-label-sm text-label-sm font-semibold">Trivandrum Leads Hub</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Live feed of form submissions and booking requests</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto rounded-lg">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-outline font-label-sm text-label-sm uppercase tracking-wider">
                                <th class="py-3 px-space-md" scope="col">Client / Company</th>
                                <th class="py-3 px-space-md" scope="col">Service Focus</th>
                                <th class="py-3 px-space-md" scope="col">Contact</th>
                                <th class="py-3 px-space-md" scope="col">Submitted</th>
                                <th class="py-3 px-space-md" scope="col">Status</th>
                                <th class="py-3 px-space-md text-right" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm divide-y-0">
                            <?php if (empty($recent_enquiries)): ?>
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-on-surface-variant">No enquiries received yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_enquiries as $row): 
                                    // Generate initials for the avatar
                                    $initials = strtoupper(substr($row['name'], 0, 1) . (strpos($row['name'], ' ') !== false ? substr($row['name'], strpos($row['name'], ' ') + 1, 1) : ''));
                                    
                                    $cText = $row['company'] ?? '';
                                    if (stripos($cText, 'Career') !== false) {
                                        $badgeClass = 'bg-purple-100 text-purple-700';
                                        $badgeIcon = 'badge';
                                        $badgeLabel = 'Career Application';
                                    } elseif (stripos($cText, 'Construction') !== false) {
                                        $badgeClass = 'bg-amber-100 text-amber-800';
                                        $badgeIcon = 'construction';
                                        $badgeLabel = 'Construction';
                                    } elseif (stripos($cText, 'Web') !== false) {
                                        $badgeClass = 'bg-blue-100 text-blue-800';
                                        $badgeIcon = 'code';
                                        $badgeLabel = 'Web Development';
                                    } elseif (stripos($cText, 'Lead') !== false) {
                                        $badgeClass = 'bg-emerald-100 text-emerald-800';
                                        $badgeIcon = 'trending_up';
                                        $badgeLabel = 'Lead Generation';
                                    } elseif (stripos($cText, 'SEO') !== false) {
                                        $badgeClass = 'bg-indigo-100 text-indigo-800';
                                        $badgeIcon = 'search';
                                        $badgeLabel = 'SEO Strategy';
                                    } else {
                                        $badgeClass = 'bg-surface-container text-primary';
                                        $badgeIcon = 'mail';
                                        $badgeLabel = 'Client Lead';
                                    }
                                ?>
                                <tr class="hover:bg-surface-container-low/70 transition-colors group">
                                    <td class="py-3.5 px-space-md">
                                        <div class="flex items-center gap-space-xs">
                                            <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-label-md text-label-md flex items-center justify-center shrink-0"><?= $initials ?></div>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-label-lg text-label-lg text-on-surface font-semibold truncate"><?= e($row['name']) ?></span>
                                                <span class="text-on-surface-variant font-body-sm text-body-sm truncate"><?= e($row['company'] ?: 'Individual') ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md font-label-sm text-label-sm font-semibold <?= $badgeClass ?>">
                                            <span class="material-symbols-outlined text-[14px]"><?= $badgeIcon ?></span> <?= $badgeLabel ?>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface-variant">
                                        <div class="flex flex-col">
                                            <span class="truncate"><?= e($row['email']) ?></span>
                                            <span class="font-label-sm text-label-sm text-outline"><?= e($row['phone'] ?: 'No phone') ?></span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-space-md text-on-surface font-medium whitespace-nowrap">
                                        <?= date('M j, H:i', strtotime($row['created_at'])) ?>
                                    </td>
                                    <td class="py-3.5 px-space-md">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> New
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-space-md text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <a href="<?= e(admin_url('resources/contact_messages.php?q=' . urlencode($row['email']))) ?>" aria-label="View Enquiry" class="w-8 h-8 rounded hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="View in Leads Hub">
                                                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                            </a>
                                            <a href="mailto:<?= e($row['email']) ?>" aria-label="Quick Email Reply" class="w-8 h-8 rounded hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Reply via Email">
                                                <span class="material-symbols-outlined text-[18px]">mail</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="pt-space-md mt-space-sm flex items-center justify-between">
                    <span class="font-body-sm text-body-sm text-on-surface-variant">Showing <?= count($recent_enquiries) ?> of <?= $total_enquiries ?> active lead conversations</span>
                    <a class="inline-flex items-center gap-1 font-label-md text-label-md text-primary hover:text-primary-container font-semibold transition-colors" href="<?= e(admin_url('resources/contact_messages.php')) ?>">
                        <span>View All Enquiries</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT PANE: 4 Columns -->
        <div class="xl:col-span-4 flex flex-col space-y-space-lg min-w-0">
            
            <!-- Breakdown by Service Interest (Donut Chart) -->
            <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-space-sm">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Enquiries by Service Interest</h2>
                </div>
                
                <div class="flex items-center justify-center relative my-2">
                    <svg class="w-44 h-44 -rotate-90 transform" viewbox="0 0 160 160">
                        <circle cx="80" cy="80" fill="none" r="62" stroke="#eaedff" stroke-width="18"></circle>
                        <circle class="transition-all duration-500 hover:opacity-85" cx="80" cy="80" fill="none" r="62" stroke="#1d4ed8" stroke-dasharray="148 241.5" stroke-dashoffset="0" stroke-width="18"></circle>
                        <circle class="transition-all duration-500 hover:opacity-85" cx="80" cy="80" fill="none" r="62" stroke="#4648d4" stroke-dasharray="93.5 296" stroke-dashoffset="-148" stroke-width="18"></circle>
                        <circle class="transition-all duration-500 hover:opacity-85" cx="80" cy="80" fill="none" r="62" stroke="#2151da" stroke-dasharray="62.3 327" stroke-dashoffset="-241.5" stroke-width="18"></circle>
                        <circle class="transition-all duration-500 hover:opacity-85" cx="80" cy="80" fill="none" r="62" stroke="#fd651e" stroke-dasharray="46.7 342" stroke-dashoffset="-303.8" stroke-width="18"></circle>
                        <circle class="transition-all duration-500 hover:opacity-85" cx="80" cy="80" fill="none" r="62" stroke="#0037b0" stroke-dasharray="39 350.5" stroke-dashoffset="-350.5" stroke-width="18"></circle>
                    </svg>
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <span class="font-headline-lg text-headline-lg text-on-surface font-bold leading-none"><?= number_format($total_enquiries) ?></span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider mt-1">Total Leads</span>
                    </div>
                </div>
                
                <div class="space-y-2.5 mt-space-md">
                    <div class="flex items-center justify-between p-2 rounded-lg bg-surface-container-low">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-3 h-3 rounded-full bg-primary-container shrink-0"></span>
                            <span class="font-label-md text-label-md text-on-surface truncate">SEO &amp; Organic Growth</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-label-md text-label-md font-bold text-on-surface">542</span>
                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold">38%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg bg-surface-container-low">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-3 h-3 rounded-full bg-tertiary-container shrink-0"></span>
                            <span class="font-label-md text-label-md text-on-surface truncate">AI SEO &amp; Search Exp.</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-label-md text-label-md font-bold text-on-surface">343</span>
                            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-tertiary font-label-sm text-label-sm font-semibold">24%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Administrative Shortcuts -->
            <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col">
                <h2 class="font-headline-sm text-headline-sm text-on-surface mb-1">Administrative Shortcuts</h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">Fast access to key agency workflows</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-xs">
                    <a class="p-3 rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center gap-2.5 group" href="<?= e(admin_url('resources/blog_editor.php')) ?>">
                        <span class="w-9 h-9 rounded-lg bg-primary-container text-on-primary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[20px]">post_add</span>
                        </span>
                        <div class="flex flex-col min-w-0">
                            <span class="font-label-md text-label-md text-on-surface font-semibold truncate">New Article</span>
                        </div>
                    </a>
                    <?php if (admin_can('testimonials')): ?>
                    <a class="p-3 rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-colors flex items-center gap-2.5 group" href="<?= e(admin_url('resources/testimonials.php')) ?>">
                        <span class="w-9 h-9 rounded-lg bg-tertiary-container text-on-tertiary flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined text-[20px]">add_reaction</span>
                        </span>
                        <div class="flex flex-col min-w-0">
                            <span class="font-label-md text-label-md text-on-surface font-semibold truncate">Testimonial</span>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Live Agency Activity Feed -->
            <div class="p-space-lg rounded-xl bg-surface-container-lowest shadow-sm flex flex-col">
                <div class="flex items-center justify-between mb-space-sm">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Live Agency Activity</h2>
                    <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-primary font-bold">
                        <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span> Real-time
                    </span>
                </div>
                <div class="space-y-4 mt-2">
                    <div class="flex items-start gap-3">
                        <span class="p-2 rounded-full bg-surface-container-high text-primary shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[16px]">edit_document</span>
                        </span>
                        <div class="flex flex-col min-w-0">
                            <p class="font-body-sm text-body-sm text-on-surface">
                                <strong class="font-semibold text-primary"><?= e($user['name']) ?></strong> published a new blog post
                            </p>
                            <span class="font-label-sm text-label-sm text-outline mt-0.5">15 minutes ago</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="p-2 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[16px]">contact_mail</span>
                        </span>
                        <div class="flex flex-col min-w-0">
                            <p class="font-body-sm text-body-sm text-on-surface">
                                New lead received via website form
                            </p>
                            <span class="font-label-sm text-label-sm text-outline mt-0.5">45 minutes ago</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/_footer.php'; ?>