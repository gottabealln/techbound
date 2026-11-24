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

// Maps internal PHP filenames to live SEO-friendly clean URLs
function url(string $path = ''): string
{
    static $routes = [
        'index.php'                              => '',
        'about.php'                              => 'about-us/',
        'services.php'                           => 'our-services/',
        'seo.php'                                => 'our-services/seo-company-in-kerala/',
        'ai-seo.php'                             => 'our-services/ai-seo-services-in-kerala/',
        'smm.php'                                => 'our-services/social-media-management-company-in-kerala/',
        'website-development.php'                => 'our-services/website-development-company-in-kerala/',
        'lead-generation.php'                    => 'our-services/best-lead-generation-company-in-kerala/',
        'online-advertising.php'                 => 'our-services/online-advertising-agency-in-kerala/',
        'construction.php'                       => 'real-estate-marketing-agency-kerala/',
        'digital-marketing-trivandrum-guide.php' => 'digital-marketing-trivandrum-guide/',
        'digital-marketing-agency-in-kochi.php'  => 'digital-marketing-agency-in-kochi/',
        'blog.php'                               => 'blog/',
        'contact.php'                            => 'contact/',
        'portfolio.php'                          => 'portfolio/',
        'careers.php'                            => 'careers/',
        'privacy-policy.php'                     => 'privacy-policy/',
    ];

    $clean  = ltrim($path, '/');
    $suffix = '';

    if (preg_match('/^([^?#]+)([?#].*)$/', $clean, $m)) {
        $clean  = $m[1];
        $suffix = $m[2];
    }

    // Clean blog post URLs: blog-post.php?slug=foo -> blog/foo/
    if (($clean === 'blog-post.php' || $clean === 'blog.php') && preg_match('/^\?slug=([^&#]+)(.*)$/', $suffix, $sm)) {
        $rest = $sm[2];
        if ($rest !== '' && $rest[0] === '&') {
            $rest = '?' . substr($rest, 1);
        }
        return BASE_URL . 'blog/' . $sm[1] . '/' . $rest;
    }

    // Allow dynamic slugs configured in Admin -> Services to override static routes
    if (is_file(__DIR__ . '/../includes/service_seo.php')) {
        require_once __DIR__ . '/../includes/service_seo.php';
        $dynamicRoutes = get_dynamic_service_routes();
        if (array_key_exists($clean, $dynamicRoutes)) {
            return BASE_URL . $dynamicRoutes[$clean] . $suffix;
        }
    }

    if (array_key_exists($clean, $routes)) {
        $clean = $routes[$clean];
    }

    return BASE_URL . $clean . $suffix;
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

/**
 * Automatically resolves Meta Title and Meta Description for any page.
 * Existing pages keep their explicit $page_title / $page_desc; any newly created
 * page that includes header.php without setting them gets a unique, SEO-friendly
 * title and description derived from its filename/slug.
 */
function resolve_page_meta(?string $title = null, ?string $desc = null): array
{
    global $site, $current_page;

    $brand       = $site['name'] ?? 'TechBound';
    $tagline     = $site['tagline'] ?? 'Digital Marketing Agency in Trivandrum, Kerala';
    $defaultDesc = 'TechBound is a premier digital marketing agency in Trivandrum, Kerala with 15+ years of experience in SEO, AI SEO, PPC advertising, social media marketing, and custom web development.';

    $rawTitle = trim(preg_replace('/\s+/', ' ', (string)($title ?? '')));
    $rawDesc  = trim(preg_replace('/\s+/', ' ', (string)($desc ?? '')));

    $slug = pathinfo((string)($current_page ?: basename($_SERVER['PHP_SELF'] ?? 'index.php')), PATHINFO_FILENAME);
    $isHome = ($slug === '' || strtolower($slug) === 'index');

    if ($rawTitle === '') {
        if ($isHome) {
            $rawTitle = $brand . ' | ' . $tagline;
        } else {
            $acronyms = ['seo', 'ai', 'ppc', 'smm', 'aeo', 'geo', 'b2b', 'ui', 'ux', 'faq', 'faqs', 'roi', 'crm', 'gcc'];
            $words = preg_split('/[-_\s]+/', $slug, -1, PREG_SPLIT_NO_EMPTY);
            $formatted = array_map(static function (string $w) use ($acronyms): string {
                $lower = strtolower($w);
                return in_array($lower, $acronyms, true) ? strtoupper($lower) : ucfirst($lower);
            }, $words);
            $human = implode(' ', $formatted);
            $rawTitle = ($human !== '' ? $human . ' | ' . $brand : $brand . ' | ' . $tagline);
        }
    }

    if ($rawDesc === '') {
        if ($isHome) {
            $rawDesc = $defaultDesc;
        } else {
            $label = trim(preg_replace('/\s*\|\s*' . preg_quote($brand, '/') . '.*$/i', '', $rawTitle));
            $rawDesc = $label !== ''
                ? "Explore {$label} with {$brand} Innovations, a digital marketing agency in Trivandrum, Kerala with 15+ years of experience delivering measurable online growth."
                : $defaultDesc;
        }
    }

    return [
        'title'       => $rawTitle,
        'description' => $rawDesc,
    ];
}