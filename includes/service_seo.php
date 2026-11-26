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
            'page_file'        => 'index.php',
            'title'            => 'Home Page',
            'slug'             => '',
            'intro'            => 'Result-driven digital marketing agency in Kerala helping brands grow with SEO, AI SEO, paid ads, social media, and modern web development.',
            'image'            => 'assets/hero.avif',
            'image_alt'        => 'TechBound Digital Marketing Agency in Kerala',
            'meta_title'       => 'Digital Marketing Agency in Kerala | SEO, AI SEO & Web | TechBound',
            'meta_description' => 'TechBound Innovations is a result-driven digital marketing agency in Kerala with 15+ years of experience in SEO, AI SEO, PPC ads, social media, and web development.',
            'primary_keyword'  => 'digital marketing agency in Kerala',
            'schema_data'      => json_encode([
                '@context' => 'https://schema.org',
                '@type'    => 'Organization',
                'name'     => 'TechBound Digital Innovations',
                'url'      => 'https://techbound.in/',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'sort_order'       => 0,
            'active'           => 1,
        ],
        [
            'page_file'        => 'about.php',
            'title'            => 'About Us',
            'slug'             => 'about-us',
            'intro'            => 'Meet the Trivandrum and Kochi digital marketing team behind TechBound Innovations.',
            'image'            => 'assets/mega-about.avif',
            'image_alt'        => 'TechBound Innovations leadership and digital marketing team in Kerala',
            'meta_title'       => 'About TechBound Innovations | Digital Marketing Agency in Kerala',
            'meta_description' => 'Learn about TechBound Innovations — 15+ years of helping brands across Trivandrum, Kochi, Kerala, and the GCC grow with SEO, AI search, paid ads, and web development.',
            'primary_keyword'  => 'about TechBound Innovations Kerala',
            'schema_data'      => '',
            'sort_order'       => 1,
            'active'           => 1,
        ],
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
            'sort_order'       => 2,
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
            'sort_order'       => 3,
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
            'sort_order'       => 4,
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
            'sort_order'       => 5,
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
            'sort_order'       => 6,
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
            'sort_order'       => 7,
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
            'sort_order'       => 8,
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
            'sort_order'       => 9,
            'active'           => 1,
        ],
        [
            'page_file'        => 'digital-marketing-agency-in-kochi.php',
            'title'            => 'Digital Marketing Agency in Kochi',
            'slug'             => 'digital-marketing-agency-in-kochi',
            'intro'            => 'SEO, AI SEO, Google & Meta Ads, Social Media, and Website Development from our Kadavanthra, Kochi office.',
            'image'            => 'assets/locations/kochi.jpg',
            'image_alt'        => 'Digital Marketing Agency in Kochi - TechBound Innovations',
            'meta_title'       => 'Digital Marketing Agency in Kochi | TechBound Innovations',
            'meta_description' => 'Looking for a result-driven digital marketing agency in Kochi? TechBound delivers SEO, AI SEO, paid ads, social media & web development from our Kadavanthra office.',
            'primary_keyword'  => 'digital marketing agency in Kochi',
            'schema_data'      => '',
            'sort_order'       => 10,
            'active'           => 1,
        ],
        [
            'page_file'        => 'digital-marketing-trivandrum-guide.php',
            'title'            => 'Digital Marketing in Trivandrum Guide',
            'slug'             => 'digital-marketing-trivandrum-guide',
            'intro'            => 'Complete 2026 guide to digital marketing services, costs, timelines, and strategy in Trivandrum.',
            'image'            => 'assets/locations/trivandrum.jpg',
            'image_alt'        => 'Digital Marketing in Trivandrum Guide - TechBound',
            'meta_title'       => 'Digital Marketing in Trivandrum: Services, Costs & 2026 Guide',
            'meta_description' => 'Digital marketing in Trivandrum: SEO, AI search, social, ads and websites, what each costs and how fast it works. Get a free audit and quote from TechBound.',
            'primary_keyword'  => 'digital marketing in Trivandrum',
            'schema_data'      => '',
            'sort_order'       => 11,
            'active'           => 1,
        ],
        [
            'page_file'        => 'seo-course-in-kerala.php',
            'title'            => 'AI 360 SEO Course in Kerala',
            'slug'             => 'seo-course-in-kerala',
            'intro'            => 'Hands-on AI 360 SEO, AEO, and GEO training course in Kerala led by Shabna Nazeer.',
            'image'            => 'assets/course-hero.jpg',
            'image_alt'        => 'AI 360 SEO Course in Kerala by TechBound',
            'meta_title'       => 'AI 360 SEO Course in Kerala | Learn SEO, AEO & GEO | TechBound',
            'meta_description' => 'Master modern SEO, Answer Engine Optimization (AEO), and Generative Engine Optimization (GEO) with TechBound\'s practical AI 360 SEO Course in Kerala.',
            'primary_keyword'  => 'SEO course in Kerala',
            'schema_data'      => '',
            'sort_order'       => 12,
            'active'           => 1,
        ],
        [
            'page_file'        => 'portfolio.php',
            'title'            => 'Portfolio',
            'slug'             => 'portfolio',
            'intro'            => 'Selected SEO, web development, social media, and lead generation projects delivered by TechBound.',
            'image'            => 'assets/hero.avif',
            'image_alt'        => 'TechBound Digital Marketing & Web Development Portfolio',
            'meta_title'       => 'Our Portfolio | Digital Marketing & Web Case Studies | TechBound',
            'meta_description' => 'Explore TechBound\'s portfolio of SEO, performance marketing, social media, and web development work for brands in Kerala and the GCC.',
            'primary_keyword'  => 'TechBound portfolio case studies',
            'schema_data'      => '',
            'sort_order'       => 13,
            'active'           => 1,
        ],
        [
            'page_file'        => 'blog.php',
            'title'            => 'Blog',
            'slug'             => 'blog',
            'intro'            => 'Actionable insights on SEO, AI search, social media, paid ads, and digital growth.',
            'image'            => 'assets/blog-hero.jpg',
            'image_alt'        => 'TechBound Digital Marketing & SEO Blog',
            'meta_title'       => 'Digital Marketing & SEO Blog | Insights & Guides | TechBound',
            'meta_description' => 'Read the latest SEO, AI SEO, social media marketing, and paid advertising guides from TechBound Innovations.',
            'primary_keyword'  => 'digital marketing blog Kerala',
            'schema_data'      => '',
            'sort_order'       => 14,
            'active'           => 1,
        ],
        [
            'page_file'        => 'careers.php',
            'title'            => 'Careers',
            'slug'             => 'careers',
            'intro'            => 'Join our SEO, paid ads, content, social media, and web engineering teams in Trivandrum and Kochi.',
            'image'            => 'assets/mega-careers.avif',
            'image_alt'        => 'Careers at TechBound Innovations Kerala',
            'meta_title'       => 'Careers at TechBound | Digital Marketing Jobs in Kerala',
            'meta_description' => 'Explore digital marketing, SEO, content, design, and web development job openings at TechBound Innovations in Trivandrum and Kochi.',
            'primary_keyword'  => 'digital marketing jobs in Trivandrum Kerala',
            'schema_data'      => '',
            'sort_order'       => 15,
            'active'           => 1,
        ],
        [
            'page_file'        => 'contact.php',
            'title'            => 'Contact Us',
            'slug'             => 'contact',
            'intro'            => 'Get in touch with TechBound offices in Trivandrum, Kochi, and Muscat, Oman.',
            'image'            => 'assets/contact-hero.jpg',
            'image_alt'        => 'Contact TechBound Innovations',
            'meta_title'       => 'Contact TechBound | Digital Marketing Agency in Trivandrum & Kochi',
            'meta_description' => 'Contact TechBound Innovations for SEO, AI SEO, paid advertising, social media marketing, or web development. Offices in Trivandrum, Kochi, and Muscat.',
            'primary_keyword'  => 'contact TechBound Innovations',
            'schema_data'      => '',
            'sort_order'       => 16,
            'active'           => 1,
        ],
        [
            'page_file'        => 'privacy-policy.php',
            'title'            => 'Privacy Policy',
            'slug'             => 'privacy-policy',
            'intro'            => 'TechBound Innovations Privacy Policy aligned with India\'s DPDP Act 2023.',
            'image'            => '',
            'image_alt'        => 'TechBound Privacy Policy',
            'meta_title'       => 'Privacy Policy | TechBound Innovations',
            'meta_description' => 'Read TechBound Innovations\' Privacy Policy explaining how we collect, use, and protect personal data under India\'s DPDP Act 2023.',
            'primary_keyword'  => 'TechBound privacy policy',
            'schema_data'      => '',
            'sort_order'       => 17,
            'active'           => 1,
        ],
        [
            'page_file'        => 'terms-and-conditions.php',
            'title'            => 'Terms & Conditions',
            'slug'             => 'terms-and-conditions',
            'intro'            => 'Terms and Conditions governing use of TechBound Innovations\' website and services.',
            'image'            => '',
            'image_alt'        => 'TechBound Terms and Conditions',
            'meta_title'       => 'Terms & Conditions | TechBound Innovations',
            'meta_description' => 'Review the Terms and Conditions for using TechBound Innovations\' website, digital marketing services, and training programs.',
            'primary_keyword'  => 'TechBound terms and conditions',
            'schema_data'      => '',
            'sort_order'       => 18,
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
        $existingFiles = $pdo->query("SELECT page_file FROM services WHERE page_file <> ''")->fetchAll(PDO::FETCH_COLUMN);
        $existingMap   = array_flip($existingFiles);

        $stmt = $pdo->prepare(
            "INSERT INTO services (page_file, title, meta_title, meta_description, primary_keyword, schema_data, slug, intro, items, image, image_alt, sort_order, active)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, '[]', ?, ?, ?, ?)"
        );
        $inserted = 0;
        foreach (service_seo_defaults() as $d) {
            if (isset($existingMap[$d['page_file']])) {
                continue;
            }
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
            $inserted++;
        }
        if ($inserted > 0) {
            sync_services_cache($pdo);
        }
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
