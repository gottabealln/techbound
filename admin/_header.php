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
    <meta name="description" content="TechBound Innovations Content Management System.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="<?= e(asset('assets/favicon.png')) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= e(asset('assets/favicon.png')) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= e(asset('assets/apple-touch-icon.png')) ?>">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&amp;family=Lato:wght@400;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1b8c43",
                        "primary-container": "#157336",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#dcfce7",
                        "primary-fixed": "#dcfce7",
                        "primary-fixed-dim": "#86efac",
                        "on-primary-fixed": "#052e16",
                        "on-primary-fixed-variant": "#166534",
                        "inverse-primary": "#86efac",

                        "secondary": "#374151",
                        "secondary-container": "#1f2937",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#f3f4f6",
                        "secondary-fixed": "#f3f4f6",
                        "secondary-fixed-dim": "#d1d5db",
                        "on-secondary-fixed": "#111827",
                        "on-secondary-fixed-variant": "#374151",

                        "tertiary": "#475569",
                        "tertiary-container": "#334155",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#f1f5f9",
                        "tertiary-fixed": "#f1f5f9",
                        "tertiary-fixed-dim": "#cbd5e1",
                        "on-tertiary-fixed": "#0f172a",
                        "on-tertiary-fixed-variant": "#334155",

                        "background": "#f6f7f6",
                        "surface": "#f6f7f6",
                        "surface-bright": "#ffffff",
                        "surface-dim": "#e5e7eb",
                        "surface-tint": "#1b8c43",
                        "surface-variant": "#ecefec",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f9faf9",
                        "surface-container": "#f1f3f1",
                        "surface-container-high": "#e7ebe8",
                        "surface-container-highest": "#dce2de",
                        "inverse-surface": "#111827",
                        "inverse-on-surface": "#f9fafb",

                        "on-background": "#111827",
                        "on-surface": "#111827",
                        "on-surface-variant": "#4b5563",
                        "outline": "#6b7280",
                        "outline-variant": "#e5e7eb",

                        "error": "#dc2626",
                        "on-error": "#ffffff",
                        "error-container": "#fef2f2",
                        "on-error-container": "#991b1b"
                    },
                    borderRadius: { "DEFAULT": "0.375rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                    spacing: { "space-xl": "2.5rem", "margin": "1.5rem", "space-sm": "0.5rem", "gutter-sm": "1rem", "gutter": "1.5rem", "margin-sm": "1rem", "margin-lg": "2rem", "space-lg": "1.5rem", "space-md": "1rem", "gutter-lg": "2rem", "space-xs": "0.25rem" },
                    fontFamily: {
                        "label-sm": ["DM Sans", "sans-serif"],
                        "label-md": ["DM Sans", "sans-serif"],
                        "label-lg": ["DM Sans", "sans-serif"],
                        "body-sm": ["Lato", "sans-serif"],
                        "body-md": ["Lato", "sans-serif"],
                        "body-lg": ["Lato", "sans-serif"],
                        "headline-sm": ["DM Sans", "sans-serif"],
                        "headline-md": ["DM Sans", "sans-serif"],
                        "headline-lg": ["DM Sans", "sans-serif"],
                        "headline-lg-mobile": ["DM Sans", "sans-serif"],
                        "headline-xl": ["DM Sans", "sans-serif"],
                        "headline-xl-mobile": ["DM Sans", "sans-serif"],
                        "data-metric": ["DM Sans", "sans-serif"]
                    },
                    fontSize: {
                        "label-sm": ["11px", { "lineHeight": "14px", "letterSpacing": "0.03em", "fontWeight": "600" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0em", "fontWeight": "500" }],
                        "body-sm": ["13px", { "lineHeight": "19px", "fontWeight": "400" }],
                        "body-md": ["14px", { "lineHeight": "22px", "fontWeight": "400" }],
                        "body-lg": ["15px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-sm": ["16px", { "lineHeight": "24px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-md": ["19px", { "lineHeight": "26px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-lg": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.015em", "fontWeight": "600" }],
                        "headline-lg-mobile": ["20px", { "lineHeight": "28px", "letterSpacing": "-0.015em", "fontWeight": "600" }],
                        "headline-xl": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "600" }],
                        "headline-xl-mobile": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "600" }],
                        "data-metric": ["28px", { "lineHeight": "34px", "letterSpacing": "-0.02em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior: none; }
            main > :first-child { margin-top: 0 !important; }
            main > :last-child { margin-bottom: 0 !important; }
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased min-h-screen">

    <!-- Mobile Sidebar Backdrop -->
    <div id="adminSidebarBackdrop" class="fixed inset-0 bg-black/30 z-40 hidden lg:hidden" onclick="toggleAdminSidebar(false)"></div>

    <!-- Sidebar -->
    <aside id="adminSidebar" class="fixed left-0 top-0 h-full w-60 bg-white border-r border-outline-variant z-50 flex flex-col justify-between overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div class="flex flex-col">
            <div class="h-16 px-5 flex items-center justify-between border-b border-outline-variant">
                <a href="<?= e(admin_url('index.php')) ?>" class="flex items-center min-w-0">
                    <img src="<?= e(asset('assets/logo_techbound.png')) ?>" alt="TechBound" class="h-7 w-auto object-contain">
                </a>
                <button type="button" onclick="toggleAdminSidebar(false)" class="lg:hidden w-8 h-8 rounded-md hover:bg-surface-container flex items-center justify-center text-on-surface-variant" aria-label="Close Sidebar">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <div class="px-4 pt-5 pb-2">
                <p class="px-2 font-label-sm text-label-sm text-outline uppercase tracking-wider">Menu</p>
            </div>
            <nav class="px-3 space-y-0.5 flex flex-col">
                <?php
                $nav = [
                    'index.php'                      => ['label' => 'Dashboard',    'icon' => 'dashboard',        'perm' => 'dashboard'],
                    'resources/contact_messages.php' => ['label' => 'Enquiries',    'icon' => 'mail',             'perm' => 'enquiries'],
                    'resources/blog_posts.php'       => ['label' => 'Blog Posts',   'icon' => 'article',          'perm' => 'blog'],
                    'resources/services.php'         => ['label' => 'Services',     'icon' => 'work_outline',     'perm' => 'services'],
                    'resources/testimonials.php'     => ['label' => 'Testimonials', 'icon' => 'format_quote',     'perm' => 'testimonials'],
                    'resources/faqs.php'             => ['label' => 'FAQs',         'icon' => 'help_outline',     'perm' => 'faqs'],
                ];
                $__script = basename($_SERVER['SCRIPT_NAME'] ?? '');
                foreach ($nav as $path => $item):
                    if (!admin_can($item['perm'])) continue;
                    $is_current = ($__script === basename($path)) || ($__script === 'blog_editor.php' && basename($path) === 'blog_posts.php');
                    $active = $is_current
                        ? 'bg-primary/10 text-primary font-semibold'
                        : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface';
                ?>
                <a class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm font-label-lg transition-colors <?= $active ?>" href="<?= e(admin_url($path)) ?>" onclick="if(window.innerWidth < 1024) toggleAdminSidebar(false)">
                    <span class="material-symbols-outlined text-[19px]"><?= $item['icon'] ?></span>
                    <span><?= $item['label'] ?></span>
                </a>
                <?php endforeach; ?>

                <?php if (admin_is_super()): ?>
                <div class="pt-5 pb-2 px-1">
                    <p class="px-2 font-label-sm text-label-sm text-outline uppercase tracking-wider">Administration</p>
                </div>
                <a class="flex items-center gap-2.5 px-3 py-2 rounded-md text-sm font-label-lg transition-colors <?= $__script === 'users.php' ? 'bg-primary/10 text-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?>" href="<?= e(admin_url('resources/users.php')) ?>" onclick="if(window.innerWidth < 1024) toggleAdminSidebar(false)">
                    <span class="material-symbols-outlined text-[19px]">group</span>
                    <span>Users</span>
                </a>
                <?php endif; ?>
            </nav>
        </div>

        <div class="p-4 border-t border-outline-variant">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-on-surface truncate"><?= e($user['name']) ?></p>
                    <p class="text-xs text-outline truncate"><?= e(admin_role_label($role)) ?></p>
                </div>
                <a href="<?= e(admin_url('logout.php')) ?>" class="p-1.5 rounded-md text-outline hover:text-error hover:bg-error-container transition-colors" title="Sign out">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Column -->
    <div class="pl-0 lg:pl-60 min-w-0 w-full flex flex-col">
        <header class="fixed top-0 left-0 lg:left-60 right-0 h-16 bg-white border-b border-outline-variant z-30 px-4 sm:px-6 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button" onclick="toggleAdminSidebar(true)" class="lg:hidden w-9 h-9 rounded-md hover:bg-surface-container flex items-center justify-center text-on-surface-variant shrink-0" aria-label="Open sidebar">
                    <span class="material-symbols-outlined text-[22px]">menu</span>
                </button>
                <span class="font-headline-sm text-headline-sm text-on-surface truncate"><?= e($page_title) ?></span>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="<?= e(BASE_URL) ?>" target="_blank" class="inline-flex items-center gap-1.5 h-9 px-3 rounded-md border border-outline-variant bg-white text-on-surface text-xs font-label-md hover:bg-surface-container transition-colors" title="View Public Website">
                    <span class="material-symbols-outlined text-[16px] text-on-surface-variant">open_in_new</span>
                    <span class="hidden sm:inline">View Site</span>
                </a>
                <a href="<?= e(admin_url('logout.php')) ?>" class="hidden sm:inline-flex items-center gap-1.5 h-9 px-3 rounded-md text-xs font-label-md text-on-surface-variant hover:text-error hover:bg-error-container transition-colors">
                    <span>Sign out</span>
                </a>
            </div>
        </header>

        <main class="w-full pt-20 sm:pt-24 bg-surface min-h-[calc(100vh-4rem)] px-4 sm:px-6 lg:px-8 pb-10 min-w-0 overflow-x-hidden">
