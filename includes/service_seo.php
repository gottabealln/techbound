<?php
declare(strict_types=1);

/**
 * Dynamic Services SEO & Routing Helper
 * Stores Meta Title, Meta Description, Slug (URL), Primary Keyword,
 * Schema Data (JSON-LD), and Image Alt Text in MySQL `services` table
 * with automatic file-cache fallback (`data/services_seo.php`).
 */

function service_seo_defaults(): array
{
    return [
        [
            'page_file'        => 'services.php',
            'title'            => 'Our Services',
            'slug'             => 'our-services',
            'intro'            => 'Full-service digital marketing and web engineering from Trivandrum, Kerala.',
            'image'            => 'assets/services.avif',
            'image_alt'        => 'TechBound digital marketing services overview in Trivandrum, Kerala',
            'meta_title'       => 'Digital Marketing Services in Trivandrum, Kerala | TechBound',
            'meta_description' => 'Explore TechBound\'s digital marketing services in Trivandrum, Kerala: SEO, AI SEO, PPC online advertising, social media marketing, lead generation, and web development.',
            'primary_keyword'  => 'digital marketing services in Trivandrum',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Digital Marketing Services',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 1,
            'active'           => 1,
        ],
        [
            'page_file'        => 'seo.php',
            'title'            => 'Search Engine Optimization',
            'slug'             => 'our-services/seo-company-in-kerala',
            'intro'            => 'Rank higher on Google and generate consistent organic leads in Trivandrum and across Kerala.',
            'image'            => 'assets/services/seo-hero-1.jpg',
            'image_alt'        => 'Search Engine Optimization services team in Trivandrum, Kerala',
            'meta_title'       => 'SEO Services in Trivandrum | Rank Higher, Get More Leads | TechBound',
            'meta_description' => 'Stop losing customers to competitors. TechBound\'s SEO services in Trivandrum help your business rank on Google and generate consistent organic traffic & leads.',
            'primary_keyword'  => 'SEO company in Trivandrum, Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Search Engine Optimization (SEO)',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 2,
            'active'           => 1,
        ],
        [
            'page_file'        => 'ai-seo.php',
            'title'            => 'AI SEO, AEO & GEO',
            'slug'             => 'our-services/ai-seo-services-in-kerala',
            'intro'            => 'Get your business cited by Google AI Overviews, ChatGPT, Gemini, and Perplexity.',
            'image'            => 'assets/services/ai-seo-hero-2.jpg',
            'image_alt'        => 'AI SEO, Answer Engine Optimization and Generative Engine Optimization in Kerala',
            'meta_title'       => 'AI SEO, AEO & GEO Services in Kerala | TechBound',
            'meta_description' => 'Get your business cited by Google AI Overviews, ChatGPT, Gemini and Perplexity. Expert Answer Engine and Generative Engine Optimization from Trivandrum.',
            'primary_keyword'  => 'AI SEO services in Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'AI SEO, AEO & GEO Optimization',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 3,
            'active'           => 1,
        ],
        [
            'page_file'        => 'smm.php',
            'title'            => 'Social Media Marketing',
            'slug'             => 'our-services/social-media-management-company-in-kerala',
            'intro'            => 'Grow and engage your audience on Instagram, Facebook, and LinkedIn with measurable enquiries.',
            'image'            => 'assets/image3.avif',
            'image_alt'        => 'Social Media Marketing and Management services in Kerala',
            'meta_title'       => 'Social Media Marketing Company in Kerala | TechBound',
            'meta_description' => 'Grow your brand and generate leads with TechBound, a results-driven social media management company in Trivandrum, Kerala.',
            'primary_keyword'  => 'social media management company in Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Social Media Marketing',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 4,
            'active'           => 1,
        ],
        [
            'page_file'        => 'online-advertising.php',
            'title'            => 'Online Advertising & PPC',
            'slug'             => 'our-services/online-advertising-agency-in-kerala',
            'intro'            => 'Google Ads, Meta Advertising, and LinkedIn campaigns engineered to maximize ROAS.',
            'image'            => 'assets/image2.avif',
            'image_alt'        => 'Online Advertising and PPC campaign management in Trivandrum, Kerala',
            'meta_title'       => 'Online Advertising & PPC Services in Trivandrum | TechBound',
            'meta_description' => 'Make your ad budget work harder. TechBound manages Google, Meta & LinkedIn ad campaigns in Trivandrum that drive real enquiries, not just clicks and impressions.',
            'primary_keyword'  => 'online advertising agency in Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Online Advertising & PPC',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 5,
            'active'           => 1,
        ],
        [
            'page_file'        => 'website-development.php',
            'title'            => 'Website Development',
            'slug'             => 'our-services/website-development-company-in-kerala',
            'intro'            => 'Fast, mobile-first, SEO-ready websites built to convert visitors into enquiries.',
            'image'            => 'assets/image4.avif',
            'image_alt'        => 'Custom Website Development company in Trivandrum, Kerala',
            'meta_title'       => 'Website Development Company in Kerala | TechBound',
            'meta_description' => 'Custom, fast, conversion-focused websites engineered in Trivandrum, Kerala. Built for Core Web Vitals, SEO, and measurable business growth.',
            'primary_keyword'  => 'website development company in Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Website Development',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 6,
            'active'           => 1,
        ],
        [
            'page_file'        => 'lead-generation.php',
            'title'            => 'Lead Generation',
            'slug'             => 'our-services/best-lead-generation-company-in-kerala',
            'intro'            => 'Full-funnel acquisition systems that turn attention into qualified sales conversations.',
            'image'            => 'assets/image5.avif',
            'image_alt'        => 'Lead Generation agency services in Trivandrum, Kerala',
            'meta_title'       => 'Best Lead Generation Company in Kerala | TechBound',
            'meta_description' => 'Drive consistent, sales-ready enquiries with TechBound\'s full-funnel lead generation services in Trivandrum and across Kerala.',
            'primary_keyword'  => 'best lead generation company in Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Lead Generation',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 7,
            'active'           => 1,
        ],
        [
            'page_file'        => 'construction.php',
            'title'            => 'Real Estate Marketing',
            'slug'             => 'real-estate-marketing-agency-kerala',
            'intro'            => 'Specialized digital marketing, SEO, and site-visit lead generation for real estate developers and builders in Kerala.',
            'image'            => 'assets/hero.avif',
            'image_alt'        => 'Real Estate Digital Marketing Agency in Kerala',
            'meta_title'       => 'Real Estate Marketing Agency in Kerala | TechBound',
            'meta_description' => 'Specialized real estate digital marketing for property developers, luxury villa projects, and apartment builders in Kerala. Generate high-intent local and NRI buyer leads.',
            'primary_keyword'  => 'real estate marketing agency Kerala',
            'schema_data'      => json_encode([
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'serviceType' => 'Real Estate Digital Marketing',
                'provider'    => ['@type' => 'Organization', 'name' => 'TechBound Innovations', 'url' => 'https://techbound.in/'],
                'areaServed'  => ['Trivandrum', 'Kerala', 'India'],
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 8,
            'active'           => 1,
        ],
    ];
}

function ensure_services_seo_schema(PDO $pdo): void
{
    try {
        $cols = $pdo->query("SHOW COLUMNS FROM services")->fetchAll(PDO::FETCH_COLUMN);
        $alters = [
            'page_file'        => "ALTER TABLE services ADD COLUMN page_file VARCHAR(120) NOT NULL DEFAULT '' AFTER id",
            'meta_title'       => "ALTER TABLE services ADD COLUMN meta_title VARCHAR(255) NOT NULL DEFAULT '' AFTER title",
            'meta_description' => "ALTER TABLE services ADD COLUMN meta_description TEXT NULL AFTER meta_title",
            'primary_keyword'       => "ALTER TABLE services ADD COLUMN primary_keyword VARCHAR(255) NOT NULL DEFAULT '' AFTER meta_description",
            'schema_data'           => "ALTER TABLE services ADD COLUMN schema_data LONGTEXT NULL AFTER primary_keyword",
            'image_alt'             => "ALTER TABLE services ADD COLUMN image_alt TEXT NULL AFTER image",
            'image_alt_description' => "ALTER TABLE services ADD COLUMN image_alt_description LONGTEXT NULL AFTER image_alt",
        ];
        foreach ($alters as $col => $sql) {
            if (!in_array($col, $cols, true)) {
                $pdo->exec($sql);
            }
        }
    } catch (Throwable $e) {
        // Ignore if ALTER is restricted
    }
}

function seed_default_services_if_empty(PDO $pdo): void
{
    try {
        ensure_services_seo_schema($pdo);
        $count = (int)$pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
        if ($count > 0) return;

        $stmt = $pdo->prepare(
            "INSERT INTO services (page_file, title, meta_title, meta_description, primary_keyword, schema_data, slug, intro, items, image, image_alt, sort_order, active)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, '[]', ?, ?, ?, ?)"
        );
        foreach (service_seo_defaults() as $d) {
            $stmt->execute([
                $d['page_file'],
                $d['title'],
                $d['meta_title'],
                $d['meta_description'],
                $d['primary_keyword'],
                $d['schema_data'],
                $d['slug'],
                $d['intro'],
                $d['image'],
                $d['image_alt'],
                $d['sort_order'],
                $d['active'],
            ]);
        }
        sync_services_cache($pdo);
    } catch (Throwable $e) {
        // Ignore seed error
    }
}

function sync_services_cache(PDO $pdo): void
{
    try {
        $rows = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
        $cachePath = __DIR__ . '/../data/services_seo.php';
        if (!is_dir(dirname($cachePath))) {
            @mkdir(dirname($cachePath), 0775, true);
        }
        file_put_contents($cachePath, "<?php\nreturn " . var_export($rows, true) . ";\n");
    } catch (Throwable $e) {
        // Ignore write error on read-only FS
    }
}

function get_all_services_seo(): array
{
    static $cached = null;
    if ($cached !== null) return $cached;

    $rows = [];
    $cachePath = __DIR__ . '/../data/services_seo.php';

    // Prefer fast precompiled cache if present, else read DB
    if (is_file($cachePath)) {
        $data = require $cachePath;
        if (is_array($data) && !empty($data)) {
            $rows = $data;
        }
    }

    if (empty($rows)) {
        try {
            require_once __DIR__ . '/db.php';
            $pdo = db();
            $rows = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            $rows = [];
        }
    }

    $cached = $rows;
    return $rows;
}

function get_service_seo_by_file(string $pageFile): ?array
{
    $pageFile = basename($pageFile);
    foreach (get_all_services_seo() as $row) {
        if (($row['page_file'] ?? '') === $pageFile) {
            return $row;
        }
    }
    return null;
}

function get_service_seo_by_slug(string $slug): ?array
{
    $norm = trim(strtolower($slug), '/');
    if ($norm === '') return null;
    foreach (get_all_services_seo() as $row) {
        $rowSlug = trim(strtolower((string)($row['slug'] ?? '')), '/');
        if ($rowSlug === $norm && !empty($row['page_file'])) {
            return $row;
        }
    }
    return null;
}

function get_dynamic_service_routes(): array
{
    $map = [];
    foreach (get_all_services_seo() as $row) {
        $file = trim((string)($row['page_file'] ?? ''));
        $slug = trim((string)($row['slug'] ?? ''), '/');
        if ($file !== '' && $slug !== '') {
            $map[$file] = $slug . '/';
        }
    }
    return $map;
}
