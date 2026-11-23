<?php

if (!defined('BASE_URL')) {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    define('BASE_URL', (strpos($script, '/techbound/') === 0) ? '/techbound/' : '/');
}

$site = [
    'name'    => 'TechBound',
    'tagline' => 'Digital Marketing Agency in Trivandrum, Kerala',
    'social'  => [
        'facebook'  => 'https://www.facebook.com/techboundDigitalAgency',
        'instagram' => 'http://instagram.com/techboundinnovations/',
        'linkedin'  => 'https://www.linkedin.com/company/techboundinnovations',
        'x'         => 'https://x.com/techbounddgtl',
        'threads'   => 'https://www.threads.com/@techboundinnovations',
        'youtube'   => 'https://www.youtube.com/@techboundinnovations1257',
    ],
];

// url('about.php') -> /techbound/about.php
function url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}


function asset(string $path): string
{
    $file = __DIR__ . '/../' . ltrim($path, '/');
    $v    = file_exists($file) ? filemtime($file) : time();
    return BASE_URL . ltrim($path, '/') . '?v=' . $v;
}

/**
 * Return an appropriate branded SVG placeholder asset path based on article category
 */
function blog_placeholder(?string $category = null): string
{
    $cat = strtolower(trim($category ?? ''));
    if (strpos($cat, 'ai') !== false || strpos($cat, 'chat') !== false || strpos($cat, 'gemini') !== false) {
        return 'assets/placeholders/blog-ai-seo.svg';
    }
    if (strpos($cat, 'seo') !== false || strpos($cat, 'search') !== false || strpos($cat, 'rank') !== false) {
        return 'assets/placeholders/blog-seo.svg';
    }
    if (strpos($cat, 'social') !== false || strpos($cat, 'smm') !== false || strpos($cat, 'meta') !== false || strpos($cat, 'instagram') !== false || strpos($cat, 'whatsapp') !== false) {
        return 'assets/placeholders/blog-smm.svg';
    }
    if (strpos($cat, 'web') !== false || strpos($cat, 'dev') !== false || strpos($cat, 'design') !== false) {
        return 'assets/placeholders/blog-web-dev.svg';
    }
    if (strpos($cat, 'marketing') !== false || strpos($cat, 'digital') !== false || strpos($cat, 'ad') !== false || strpos($cat, 'lead') !== false) {
        return 'assets/placeholders/blog-digital-marketing.svg';
    }
    return 'assets/placeholders/blog-default.svg';
}

/**
 * Return the safe, fully qualified image URL with automatic placeholder fallback
 */
function blog_image_url(?string $image, ?string $category = null): string
{
    $img = trim($image ?? '');
    if ($img === '') {
        return asset(blog_placeholder($category));
    }
    if (strpos($img, 'http://') === 0 || strpos($img, 'https://') === 0) {
        return $img;
    }
    return asset($img);
}

// Name of the page being viewed: index.php, about.php, ...
$current_page = basename($_SERVER['PHP_SELF']);

// marks the current page's menu link
function current_attr(string ...$pages): string
{
    global $current_page;
    return in_array($current_page, $pages, true) ? ' aria-current="page"' : '';
}