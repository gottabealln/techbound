<?php
declare(strict_types=1);

/**
 * Dynamic XML Sitemap (served at /sitemap.xml via .htaccess).
 * Automatically updates whenever pages/services or blog posts are added, edited, or unpublished.
 */

require_once __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/service_seo.php';

header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex, follow');

// Use canonical production domain on live hosts, or current host on localhost
$host = $_SERVER['HTTP_HOST'] ?? 'techbound.in';
$isLocal = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);
if ($isLocal) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $siteRoot = $scheme . '://' . $host . rtrim(BASE_URL, '/') . '/';
} else {
    $siteRoot = 'https://techbound.in/';
}

$urls = [];
$addUrl = function (string $loc, string $lastmod, string $changefreq = 'weekly', string $priority = '0.8') use (&$urls): void {
    $loc = trim($loc);
    if ($loc === '' || isset($urls[$loc])) return;
    $urls[$loc] = [
        'loc'        => $loc,
        'lastmod'    => $lastmod,
        'changefreq' => $changefreq,
        'priority'   => $priority,
    ];
};

// 1. All active Site Pages & Services (live from DB, fallback to cache/defaults)
$pages = [];
try {
    require_once __DIR__ . '/includes/db.php';
    $pdo = db();
    $pages = $pdo->query("SELECT page_file, slug, active FROM services WHERE active = 1 ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    $pages = [];
}

if (empty($pages)) {
    $pages = array_values(array_filter(get_all_services_seo(), fn($r) => (int)($r['active'] ?? 1) === 1));
    if (empty($pages)) {
        $pages = service_seo_defaults();
    }
}

foreach ($pages as $p) {
    $file = basename(trim((string)($p['page_file'] ?? '')));
    $slug = trim((string)($p['slug'] ?? ''), '/');

    if ($file === 'index.php' || $slug === '') {
        $loc      = $siteRoot;
        $priority = '1.0';
        $freq     = 'daily';
    } else {
        $loc = $siteRoot . $slug . '/';
        if (in_array($file, ['privacy-policy.php', 'terms-and-conditions.php'], true)) {
            $priority = '0.4';
            $freq     = 'yearly';
        } elseif (in_array($file, ['blog.php', 'services.php', 'seo.php', 'ai-seo.php', 'digital-marketing-agency-in-kochi.php', 'digital-marketing-trivandrum-guide.php', 'seo-course-in-kerala.php'], true)) {
            $priority = '0.9';
            $freq     = 'weekly';
        } else {
            $priority = '0.8';
            $freq     = 'monthly';
        }
    }

    $fullPath = $file !== '' ? (__DIR__ . '/' . $file) : '';
    $mtime    = ($fullPath !== '' && is_file($fullPath)) ? filemtime($fullPath) : time();
    $lastmod  = gmdate('Y-m-d', $mtime ?: time());

    $addUrl($loc, $lastmod, $freq, $priority);
}

// 2. All published Blog Posts (live from DB, fallback to data/blogs_index.php)
$posts = [];
try {
    require_once __DIR__ . '/includes/db.php';
    $posts = db()->query(
        "SELECT slug, published_at FROM blog_posts WHERE active = 1 AND slug <> '' ORDER BY published_at DESC, id DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    $posts = [];
}

if (empty($posts) && is_file(__DIR__ . '/data/blogs_index.php')) {
    $idx = require __DIR__ . '/data/blogs_index.php';
    if (is_array($idx)) {
        foreach ($idx as $item) {
            if ((int)($item['active'] ?? 1) === 1 && !empty($item['slug'])) {
                $posts[] = [
                    'slug'         => $item['slug'],
                    'published_at' => $item['published_at'] ?? '',
                ];
            }
        }
    }
}

foreach ($posts as $post) {
    $slug = trim((string)($post['slug'] ?? ''), '/');
    if ($slug === '') continue;
    $ts      = !empty($post['published_at']) ? strtotime((string)$post['published_at']) : false;
    $lastmod = $ts ? gmdate('Y-m-d', $ts) : gmdate('Y-m-d');
    $addUrl($siteRoot . 'blog/' . rawurlencode($slug) . '/', $lastmod, 'monthly', '0.7');
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
    echo '    <lastmod>' . htmlspecialchars($u['lastmod'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</lastmod>\n";
    echo '    <changefreq>' . htmlspecialchars($u['changefreq'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</changefreq>\n";
    echo '    <priority>' . htmlspecialchars($u['priority'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</priority>\n";
    echo "  </url>\n";
}
echo "</urlset>\n";
