<?php
$user = admin_current();
$page_title = $page_title ?? 'Dashboard';
$role = $user['role'] ?? 'editor';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= e($page_title) ?> | TechBound Admin</title>
    <meta name="description" content="TechBound Innovations Administration and Content Management System.">
    <meta name="robots" content="noindex, nofollow">
    
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0037b0", "on-surface-variant": "#434655", "surface-dim": "#d2d9f4", "surface-tint": "#2151da", "on-tertiary": "#ffffff", "on-background": "#131b2e", "on-tertiary-fixed-variant": "#2f2ebe", "on-secondary-container": "#571a00", "secondary-fixed-dim": "#ffb599", "secondary-container": "#fd651e", "tertiary-fixed-dim": "#c0c1ff", "surface": "#faf8ff", "on-primary-container": "#cad3ff", "on-primary": "#ffffff", "surface-bright": "#faf8ff", "error-container": "#ffdad6", "on-tertiary-container": "#d1d1ff", "inverse-on-surface": "#eef0ff", "on-surface": "#131b2e", "on-secondary-fixed-variant": "#7f2b00", "secondary-fixed": "#ffdbce", "surface-container-high": "#e2e7ff", "error": "#ba1a1a", "surface-container-low": "#f2f3ff", "outline-variant": "#c4c5d7", "on-secondary": "#ffffff", "tertiary-fixed": "#e1e0ff", "on-primary-fixed": "#001551", "surface-container-highest": "#dae2fd", "on-primary-fixed-variant": "#0039b5", "on-tertiary-fixed": "#07006c", "primary-container": "#1d4ed8", "on-secondary-fixed": "#370e00", "on-error-container": "#93000a", "background": "#faf8ff", "surface-container": "#eaedff", "primary-fixed-dim": "#b7c4ff", "primary-fixed": "#dce1ff", "inverse-surface": "#283044", "surface-variant": "#dae2fd", "tertiary": "#2c2abc", "on-error": "#ffffff", "outline": "#747686", "inverse-primary": "#b7c4ff", "tertiary-container": "#4648d4", "surface-container-lowest": "#ffffff", "secondary": "#a73a00"
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                    spacing: { "space-xl": "2.5rem", "margin": "1.5rem", "space-sm": "0.5rem", "gutter-sm": "1rem", "gutter": "1.5rem", "margin-sm": "1rem", "margin-lg": "2rem", "space-lg": "1.5rem", "space-md": "1rem", "gutter-lg": "2rem", "space-xs": "0.25rem" },
                    fontFamily: { "label-sm": ["Plus Jakarta Sans"], "label-lg": ["Plus Jakarta Sans"], "body-sm": ["Plus Jakarta Sans"], "body-md": ["Plus Jakarta Sans"], "headline-sm": ["Plus Jakarta Sans"], "headline-lg-mobile": ["Plus Jakarta Sans"], "headline-lg": ["Plus Jakarta Sans"], "body-lg": ["Plus Jakarta Sans"], "headline-xl-mobile": ["Plus Jakarta Sans"], "headline-md": ["Plus Jakarta Sans"], "headline-xl": ["Plus Jakarta Sans"], "label-md": ["Plus Jakarta Sans"], "data-metric": ["Plus Jakarta Sans"] },
                    fontSize: { "label-sm": ["11px", { "lineHeight": "14px", "letterSpacing": "0.04em", "fontWeight": "700" }], "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }], "body-sm": ["12px", { "lineHeight": "18px", "letterSpacing": "0.005em", "fontWeight": "400" }], "body-md": ["14px", { "lineHeight": "22px", "letterSpacing": "0em", "fontWeight": "400" }], "headline-sm": ["16px", { "lineHeight": "24px", "letterSpacing": "-0.01em", "fontWeight": "600" }], "headline-lg-mobile": ["22px", { "lineHeight": "30px", "letterSpacing": "-0.015em", "fontWeight": "600" }], "headline-lg": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "700" }], "body-lg": ["16px", { "lineHeight": "26px", "letterSpacing": "-0.005em", "fontWeight": "400" }], "headline-xl-mobile": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "700" }], "headline-md": ["20px", { "lineHeight": "28px", "letterSpacing": "-0.015em", "fontWeight": "600" }], "headline-xl": ["36px", { "lineHeight": "44px", "letterSpacing": "-0.025em", "fontWeight": "700" }], "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.015em", "fontWeight": "600" }], "data-metric": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }] }
                }
            }
        }
    </script>
    <style>@layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased min-h-screen">

    <!-- Backdrop Overlay for Mobile Drawer -->
    <div id="adminSidebarBackdrop" class="fixed inset-0 bg-on-surface/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity" onclick="toggleAdminSidebar(false)"></div>

    <!-- Responsive Sidebar Drawer -->
    <aside id="adminSidebar" class="fixed left-0 top-0 h-full w-64 bg-surface-container-low shadow-xl lg:shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-50 flex flex-col justify-between overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center justify-between gap-space-xs bg-surface-container-low border-b border-outline-variant/20 lg:border-b-0">
                <div class="flex flex-col min-w-0 flex-1 pl-space-xs">
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-secondary font-bold">TechBound</span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant truncate">Trivandrum, Kerala</span>
                </div>
                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleAdminSidebar(false)" class="lg:hidden w-8 h-8 rounded-lg hover:bg-surface-container flex items-center justify-center text-on-surface-variant transition-colors" aria-label="Close Sidebar">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <div class="px-space-md py-space-xs">
                <p class="px-space-xs font-label-sm text-label-sm text-outline uppercase tracking-wider mb-space-xs">Navigation Core</p>
            </div>
            <nav class="px-space-sm space-y-1 flex flex-col">
                <?php 
                $nav = [
                    'index.php' => ['label' => 'Dashboard', 'icon' => 'dashboard', 'perm' => 'dashboard'],
                    'resources/contact_messages.php' => ['label' => 'Enquiries / Leads', 'icon' => 'mark_email_unread', 'perm' => 'enquiries'],
                    'resources/blog_posts.php' => ['label' => 'Blog Posts', 'icon' => 'article', 'perm' => 'blog'],
                    'resources/services.php' => ['label' => 'Services', 'icon' => 'design_services', 'perm' => 'services'],
                    'resources/testimonials.php' => ['label' => 'Testimonials & Reviews', 'icon' => 'rate_review', 'perm' => 'testimonials'],
                    'resources/faqs.php' => ['label' => 'FAQs Manager', 'icon' => 'quiz', 'perm' => 'faqs'],
                ];
                $__script = basename($_SERVER['SCRIPT_NAME'] ?? '');
                foreach ($nav as $path => $item):
                    if (!admin_can($item['perm'])) continue;
                    $is_current = ($__script === basename($path)) || ($__script === 'blog_editor.php' && basename($path) === 'blog_posts.php');
                    $active = $is_current ? 'bg-primary-container text-on-primary font-label-lg rounded-lg' : 'rounded-lg font-label-lg text-label-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors group';
                ?>
                <a class="flex items-center justify-between px-space-md py-space-xs transition-colors <?= $active ?>" href="<?= e(admin_url($path)) ?>" onclick="if(window.innerWidth < 1024) toggleAdminSidebar(false)">
                    <div class="flex items-center gap-space-sm">
                        <span class="material-symbols-outlined text-[20px]"><?= $item['icon'] ?></span>
                        <span><?= $item['label'] ?></span>
                    </div>
                </a>
                <?php endforeach; ?>

                <?php if (admin_is_super()): ?>
                <div class="pt-space-xs">
                    <p class="px-space-xs font-label-sm text-label-sm text-outline uppercase tracking-wider mb-space-xs">Governance</p>
                </div>
                <a class="flex items-center justify-between px-space-md py-space-xs transition-colors <?= $__script === 'users.php' ? 'bg-primary-container text-on-primary font-label-lg rounded-lg' : 'rounded-lg font-label-lg text-label-lg text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface group' ?>" href="<?= e(admin_url('resources/users.php')) ?>" onclick="if(window.innerWidth < 1024) toggleAdminSidebar(false)">
                    <div class="flex items-center gap-space-sm">
                        <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                        <span>Users & Permissions</span>
                    </div>
                </a>
                <?php endif; ?>
            </nav>
        </div>
        <div class="p-space-md bg-surface-container-low border-t border-outline-variant/20 lg:border-t-0">
            <div class="p-space-sm rounded-lg bg-surface-container flex items-center justify-between">
                <div class="flex items-center gap-space-xs">
                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Trivandrum Hub</span>
                </div>
                <span class="font-label-sm text-label-sm text-primary font-bold">Active</span>
            </div>
        </div>
    </aside>

    <!-- Topbar & Main Content Wrapper -->
    <div class="pl-0 lg:pl-64 transition-all duration-300 min-w-0 w-full flex flex-col">
        <header class="fixed top-0 left-0 lg:left-64 right-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-30 px-3 sm:px-space-md lg:px-space-lg flex items-center justify-between transition-all duration-300">
            <div class="flex items-center gap-2 sm:gap-space-md flex-1 min-w-0">
                <!-- Hamburger Trigger for Mobile Screens -->
                <button type="button" onclick="toggleAdminSidebar(true)" class="lg:hidden w-10 h-10 rounded-lg hover:bg-surface-container flex items-center justify-center text-on-surface-variant shrink-0" aria-label="Open sidebar">
                    <span class="material-symbols-outlined text-[24px]">menu</span>
                </button>

                <div class="flex items-center gap-space-xs min-w-0">
                    <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight truncate">TechBound</span>
                    <span class="hidden sm:inline-block px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-label-sm text-primary shrink-0">Admin CMS v2.4</span>
                </div>
                <div class="relative max-w-md w-full ml-space-md hidden md:block">
                    <div class="flex items-center h-10 px-space-sm rounded-lg bg-surface-container-low text-on-surface-variant gap-space-xs">
                        <span class="material-symbols-outlined text-[18px] text-outline">search</span>
                        <input class="w-full bg-transparent border-0 outline-none font-body-sm text-body-sm text-on-surface placeholder:text-outline" placeholder="Search campaigns, clients, SEO audits..." type="text"/>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-space-sm shrink-0">
                <a href="<?= e(BASE_URL) ?>" target="_blank" class="flex items-center gap-1.5 h-9 px-2.5 sm:px-space-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:bg-primary-container transition-colors" title="View Public Website">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    <span class="hidden sm:inline">View Site</span>
                </a>
                <div class="flex items-center gap-1.5 sm:gap-space-xs pl-2 sm:pl-space-xs ml-1 sm:ml-4 border-l border-outline-variant">
                    <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-bold flex items-center justify-center shrink-0 text-sm">
                        <?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="hidden md:flex flex-col text-left">
                        <span class="font-label-md text-label-md text-on-surface leading-tight truncate max-w-[200px]"><?= e($user['name']) ?> <span class="font-label-sm text-label-sm <?= admin_is_super() ? 'text-primary' : 'text-tertiary' ?>">· <?= e(admin_role_label($role)) ?></span></span>
                        <a href="<?= e(admin_url('logout.php')) ?>" class="font-body-sm text-body-sm text-secondary leading-tight hover:underline">Logout</a>
                    </div>
                    <a href="<?= e(admin_url('logout.php')) ?>" class="md:hidden w-8 h-8 rounded-lg hover:bg-surface-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Logout">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Workspace Container (Responsive spacing) -->
        <main class="w-full pt-20 sm:pt-24 bg-surface min-h-[calc(100vh-4rem)] px-3 sm:px-space-md lg:px-space-lg pb-space-lg min-w-0 overflow-x-hidden">
